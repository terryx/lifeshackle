<?php

class ArticleController extends CommonController {

	//global setting per page for visitor and admin
	public $per_page = 2;
	public $admin_per_page = 3;
	private $file_path = 'global/file/';

	public function escape_val($val) {

		if (get_magic_quotes_gpc()) {
			$val = stripcslashes($val);
		}
		return $val;
	}

	public function editPage() {
		$data = $this->templateData($this->checkRole() . '/article/edit');

		//overwrite some template array
		$data['title'] = 'Edit | Article';
		$this->view()->render('template/layout', $data, true);
	}

	public function fetchArticle() {
		if (!$this->params['number'] || intval($this->params['number']) < 1) {
			return 404;
		}

		$number = $this->params['number'];
		
		$sql = array(
			'limit' => $number,
			'select' => 'article.article_id as k0, article.title as k1, article.created as k2, article.last_edited as k3, article.tag as k4',
			'where' => 'article.visible = 1',
			'desc' => 'article.article_id'
		);
		$rs = Doo::db()->find('Article', $sql);

		//read txt file
		foreach ($rs as $id) {
			$file = file_get_contents($this->file_path . 'article_' . $id->k0 . '.txt');
			$id->k5 = $file;
		}
		$this->toJSON($rs, true, true);
	}

	public function archive(){
		$sql = "SELECT FROM_UNIXTIME(article.created, '%M %Y') as k1";
		$sql .= " FROM article GROUP BY k1";
		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}
	
	public function archiveDateFilter(){
		$date = urldecode($this->params['date']);

		if (empty($date)) {
			return 404;
		}

		$sql = array(
			'select' => 'article.article_id as k0, article.title as k1, article.created as k2, article.last_edited as k3, article.tag as k4',
			'where' => 'FROM_UNIXTIME(article.created, "%M %Y") = ? AND visible = 1',
			'desc' => 'article.article_id',
			'param' => array($date)
		);
		$rs = Doo::db()->find('Article', $sql);
		
		foreach ($rs as $id) {
			$file = file_get_contents($this->file_path . 'article_' . $id->k0 . '.txt');
			$id->k5 = $file; 
		}
		$this->toJSON($rs, true, true);
	}

	//------------------------------------//

	public function getOneArticle() {
		if (!$this->params['id'] || intval($this->params['id']) < 1) {
			return 404;
		} else {
			Doo::loadModel('Article');
			$a = new Article();
			$a->article_id = $this->params['id'];
			$rs = $a->getOne();

			if ($rs) {
				$this->toJSON($rs, true, true);
			} else {
				$this->toJSON('Article not found', true);
				return 400;
			}
		}
	}

	public function fetchArticleList() {
		$sql = 'SELECT article_id as k0, title as k1, DATE_FORMAT(article.created, "%D %M %Y") as k2, body as k3 FROM article ';
		$sql .= 'ORDER BY article_id DESC LIMIT 3';
		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
		return 200;
	}

	public function setPagination() {
		if (intval($this->params['set']) < 1) {
			return 404;
		}
		$per_page = $this->params['set'];
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(article_id)/' . $per_page . ' as num_of_item FROM article ';
		$sql .= 'WHERE article.visible = 1';

		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function getPublicArticleList() {
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;

//		$sql = 'SELECT article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, "%D %M %Y") as k2, ';
//		$sql .= 'article.body as k3, article.tag as k4 FROM article';
//		$sql .=' WHERE article.visible = 1 ORDER BY article.created DESC LIMIT ' . $offset . ', ' . $per_page;

		$sql = 'SELECT article.article_id as k0, article.title as k1, article.created as k2, ';
		$sql .= 'article.last_edited as k3, article.tag as k4 FROM article';
		$sql .= ' WHERE article.visible = 1';
		$sql .=' ORDER BY article.article_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function getPagination() {
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;

//		$sql = 'SELECT article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, "%D %M %Y") as k2, ';
//		$sql .= 'article.body as k3, article.tag as k4 FROM article';
//		$sql .=' WHERE article.visible = 1 ORDER BY article.created DESC LIMIT ' . $offset . ', ' . $per_page;

		$sql = 'SELECT article.article_id as k0, article.title as k1, article.created as k2, ';
		$sql .= 'article.last_edited as k3, article.tag as k4 FROM article';
		$sql .= ' WHERE article.visible = 1';
		$sql .=' ORDER BY article.article_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);

		$file = file_get_contents($this->file_path . 'test.txt');


//		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($file, true);
	}

	/*
	 *  Master section
	 * 
	 */

	public function adminSetPagination() {
		if (intval($this->params['set']) < 1) {
			return 404;
		}

		//how many sets per one page
		$per_page = $this->params['set'];
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(article_id)/' . $per_page . ' as num_of_item FROM article ';
		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function adminGetPagination() {
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->admin_per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;

		$sql = 'SELECT article.article_id as k0, article.title as k1, article.created as k2, ';
		$sql .= 'article.last_edited as k3, article.tag as k4 FROM article';
		$sql .=' ORDER BY article.article_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function saveArticle() {
		$id = $_POST['article_id'];
		$title = $this->xss($_POST['title']);

		//check is content empty
		$txtcontent = $_POST['txtcontent'];
		if (empty($txtcontent)) {
			$this->toJSON(array('failed', 'Content is empty'), true);
			return 200;
		}

		$tag = $this->xss($_POST['tag']);

		if (intval($_POST['article_id']) > 0) {
			$this->updateArticle($id, $txtcontent, $title, $tag);
		} else {
			$this->createArticle($txtcontent, $title, $tag);
		}

		exit;
	}

	private function createArticle($txtcontent, $title='', $tag='') {

		//insert latest id
		$latest_update_array = array(
			'type' => 'article'
		);

		Doo::loadModel('LatestUpdate');
		$la = new LatestUpdate($latest_update_array);
		$last_insert_id = $la->insert();

		$now = time();
		$article = array(
			'title' => $title,
			'created' => $now,
			'tag' => $tag,
			'visible' => 1,
			'latest_id' => $last_insert_id
		);

		Doo::loadModel('Article');
		$a = new Article($article);

		$a->beginTransaction();
		try {
			$new_id = $a->insert();
			$filename = 'article_' . $new_id . '.txt';
			$output = file_put_contents($this->file_path . $filename, $txtcontent);
			$this->toJSON(array('created', $new_id, $title), true);
			return 201;
		} catch (PDOException $e) {
			$a->rollBack();
			return 500;
		}
		exit;
	}

	private function updateArticle($id, $txtcontent, $title='', $tag='') {

		$article = array(
			'article_id' => $id,
			'title' => $title,
			'last_edited' => time(),
			'tag' => $tag,
			'visible' => 1,
		);
		Doo::loadModel('Article');
		$a = new Article($article);
		$a->update();

		$this->toJSON(array('updated', $a->article_id), true);
		return 200;
	}

	public function deleteArticle() {

		//get article
		$a = $this->db()->find('Article', array(
			'limit' => 1,
			'where' => 'article.article_id = ?',
			'param' => array(intval($this->params['id']))
				));

		if ($a->count()) {
			//get latest id
			$la = $this->db()->find('LatestUpdate', array(
				'limit' => 1,
				'where' => 'latest_update.latest_id = ?',
				'param' => array($a->latest_id)
					));

			$a->beginTransaction();
			$la->beginTransaction();
			try {
				$a->delete();
				$la->delete();
				$a->commit();
				$this->toJSON(array('deleted'), true);
			} catch (PDOException $e) {
				$a->rollBack();
				return 500;
			}
		} else {
			return 404;
		}
	}

}

?>
