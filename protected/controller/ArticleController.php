<?php

class ArticleController extends SessionController {

	//global setting per page for visitor and admin
	private $file_path = 'global/file/';

	public function listArticles() {
		$sql = "SELECT article.article_id, article.title FROM article";
		$sql .= " WHERE article.visible = 1 ORDER BY article.article_id DESC";
		$rs = $this->db()->fetchAll($sql);

		if ($rs) {
			$this->toJSON($rs, true);
		}
	}

	public function createPager() {
		$content = intval($this->params['content']);

		//how many sets per one page
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = array(
			'select' => 'COUNT(article.article_id) / ? as num_of_item',
			'where' => 'article.visible = 1',
			'desc' => 'article.article_id',
			'param' => array($content)
		);

		$rs = Doo::db()->find('Article', $sql);
		$page_number = doubleval($rs[0]->num_of_item);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function makePagination() {

		$per_page = $this->params['page'];
		$current_page = $this->params['id'];

		$offset = ($current_page - 1) * $per_page;
		$sql = array(
			'select' => 'article.article_id, article.title',
			'desc' => 'article.article_id',
			'limit' => $offset . ', ' . $per_page
		);

		$rs = Doo::db()->find('Article', $sql);
		$this->toJSON($rs, true, true);
	}

	public function fetchArticles() {

		$sql = array(
			'limit' => '5',
			'select' => 'article.article_id as id, article.title as title, article.created as created, article.last_edited as edited, article.tag as tag',
			'where' => 'article.visible = 1',
			'desc' => 'article.article_id'
		);
		$rs = Doo::db()->find('Article', $sql);

		//read txt file
		foreach ($rs as $id) {
			if ($id->edited === '0') {
				$id->date = 'Created on ' . date('j M Y, D g:i a', $id->created);
			} else {
				$id->date = 'Modified on ' . date('j M Y, D g:i a', $id->modified);
			}

			$file = file_get_contents($this->file_path . 'article_' . $id->id . '.txt');
			$id->content = stripslashes($file);

			$text = strip_tags($id->content);
			$length = strlen($text);
			$shortenText = substr($id->content, 0, 600);

			if ($length > 600) {
				$id->content = $shortenText . '.... <span><a href="/article/' . $id->id . '">view full text</a></span>';
			}

			unset($id->created);
			unset($id->edited);
		}

		$this->toJSON($rs, true, true);
	}

	public function fetchOneArticle() {
		$id = intval($this->params['id']);

		if (!$id) {
			return 404;
		}

		$sql = array(
			'select' => 'article.article_id as id, article.title as title, article.created as created, article.last_edited as edited, article.tag as tag',
			'where' => 'article.visible = 1 AND article.article_id = ?',
			'param' => array($id)
		);
		$rs = Doo::db()->find('Article', $sql);

		//read txt file
		foreach ($rs as $id) {
			if ($id->edited === '0') {
				$id->date = 'Created on ' . date('j M Y, D g:i a', $id->created);
			} else {
				$id->date = 'Modified on ' . date('j M Y, D g:i a', $id->edited);
			}

			$file = file_get_contents($this->file_path . 'article_' . $id->id . '.txt');
			$id->content = stripslashes($file);

//			$text = strip_tags($id->content);
//			$length = strlen($text);
//			$shortenText = substr($id->content, 0, 600);
//			if($length > 600){
//				$id->content = $shortenText . '.... <span><a href="/article/'. $id->id .'">view full text</a></span>';
//			}

			unset($id->created);
			unset($id->edited);
		}
		$this->toJSON($rs[0], true, true);
	}

	//------------------------------------//

	/*
	 *  Master section
	 * 
	 */

	public function saveArticle() {
		//TODO:: add security check for input

		$id = $_POST['id'];
		$title = $_POST['title'];
		$tag = $_POST['tag'];

		//check is content empty
		$content = $_POST['content'];
		if (empty($content)) {
			$this->toJSON(array('failed', 'Content is empty'), true);
			return 200;
		}

		$data = array(
			'id' => $id,
			'title' => $title,
			'content' => $content,
			'tag' => $tag
		);
		
		if (intval($id) > 0) {
			$this->updateArticle($data);
		} else {
			$this->createArticle($data);
		}
		exit;
	}

	private function createArticle($data) {
		//insert latest id
		$latest_update_array = array(
			'type' => 'article'
		);

		Doo::loadModel('LatestUpdate');
		$la = new LatestUpdate($latest_update_array);
		$last_insert_id = $la->insert();

		$now = time();
		$article = array(
			'title' => $data['title'],
			'created' => $now,
			'tag' => $data['tag'],
			'visible' => 1,
			'latest_id' => $last_insert_id
		);

		Doo::loadModel('Article');
		$a = new Article($article);

		$a->beginTransaction();
		try {
			$new_id = $a->insert();
			$filename = 'article_' . $new_id . '.txt';
			$output = file_put_contents($this->file_path . $filename, $this->escape_val($data['content']));
			$this->toJSON(array('created', $new_id, $data['title']), true);
			return 201;
		} catch (PDOException $e) {
			$a->rollBack();
			return 500;
		}
		exit;
	}

	private function updateArticle($data) {
		$article = array(
			'article_id' => $data['id'],
			'title' => $data['title'],
			'last_edited' => time(),
			'tag' => $data['tag'],
			'visible' => 1,
		);
		Doo::loadModel('Article');
		$a = new Article($article);
		try {
			$a->update();
			$filename = 'article_' . $data['id'] . '.txt';
			$output = $output = file_put_contents($this->file_path . $filename, $this->escape_val($data['content']));
			$this->toJSON(array('updated', $data['id'], $data['title']), true);
			return 200;
		} catch (PDOException $e) {
			$a->rollBack();
			return 500;
		}
		exit;
	}

	public function deleteOneArticle() {
		$id = intval($this->params['id']);

		//get article
		$a = $this->db()->find('Article', array(
			'limit' => 1,
			'where' => 'article.article_id = ?',
			'param' => array($id)
				));

		if ($a) {
			$title = $a->title;
		}

		if ($a->count()) {
			//get latest id
			$la = $this->db()->find('LatestUpdate', array(
				'limit' => 1,
				'where' => 'latest_update.latest_id = ?',
				'param' => array($a->latest_id)
					));
			$filename = 'article_' . $id . '.txt';

			$a->beginTransaction();
			$la->beginTransaction();
			try {
				$a->delete();
				$la->delete();
				$file = unlink($this->file_path . $filename);
				$a->commit();
				$this->toJSON(array('deleted', $title), true);
			} catch (PDOException $e) {
				$a->rollBack();
				return 500;
			}
		} else {
			return 404;
		}
		exit;
	}
	
	//helper function
	//TODO:: move to a helper class
	public function escape_val($val) {

		if (get_magic_quotes_gpc()) {
			$val = stripcslashes($val);
		}
		return $val;
	}

}

?>
