<?php

class ArticleController extends CommonController {

	//global setting per page for visitor and admin
	public $per_page = 5;
	public $admin_per_page = 10;

	public function escape_val($val) {

		if (get_magic_quotes_gpc()) {
			$val = stripcslashes($val);
		}
		return $val;
	}

	public function viewPage() {
		//article and index page is currently same
		//TODO make own article page or merge manage article with index
		
		$data = $this->templateData();
		$data["title"] = 'View | Article';
		$data["content"] = $data["role"]."/article/view";
		$this->view()->render('template/layout', $data, true);
	}
	
	public function editPage() {
		$data = $this->templateData();
		$data['title'] = 'Edit | Article';
		$data['content'] = $data['role'].'/article/edit';
		$this->view()->render('template/layout', $data, true);
	}

	public function getArticleList() {
		$rs = $this->db()->find('Article', array('select' =>
			'article_id as k0, title as k1, created as k2, visible as k3',
			'desc' => 'created'));
		$this->toJSON($rs, true, true);
	}

	public function getOneArticle() {
		if (!$this->params['id'] || intval($this->params['id']) < 1) {
			return 404;
		}
		else {
			Doo::loadModel('Article');
			$a = new Article();
			$a->article_id = $this->params['id'];
			$rs = $a->getOne();

			if ($rs) {
				$this->toJSON($rs, true, true);
			}
			else {
				$this->toJSON('Article not found', true);
				return 400;
			}
		}
	}

	public function countPage() {
		$per_page = $this->per_page;
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(article_id)/' . $per_page . ' as num_of_item FROM article ';
		$sql .= 'WHERE article.visible = 1';

		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function getPagination() {
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;
		$role = $this->checkRole();

		if ($role) {
			$sql = 'SELECT article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, "%D %M %Y") as k2, ';
			$sql .= 'article.body as k3, article.tag as k4 FROM article';
			$sql .=' ORDER BY article.created DESC LIMIT ' . $offset . ', ' . $per_page;
		}
		else {
			$sql = 'SELECT article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, "%D %M %Y") as k2, ';
			$sql .= 'article.body as k3, article.tag as k4 FROM article';
			$sql .=' WHERE article.visible = 1 ORDER BY article.created DESC LIMIT ' . $offset . ', ' . $per_page;
		}

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function archive() {
		$sql = "SELECT COUNT(article.article_id) as k0, DATE_FORMAT(created, '%M %Y') as k1";
		$sql .= " FROM article GROUP BY DATE_FORMAT(article.created, '%M %Y') ORDER BY article.article_id DESC";
		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function filterbyArchive() {
		$date = str_replace("%20", " ", $this->params['date']);

		Doo::loadModel("Article");

//		$a = new Article;
//		$opt['select'] = "article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, '%D %M %Y') as k2, article.body as k3, article.tag as k4";
//		$opt["where"] = "article.visible = 1 AND DATE_FORMAT(article.created, '%M %Y') = '$date'";
//		$opt['desc'] = 'article.article_id';
//		$rs = $a->relate("Users", $opt);
		$sql = "SELECT article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, '%D %M %Y') as k2, article.body as k3, article.tag as k4 FROM article";
		$sql .= " WHERE article.visible = 1 AND DATE_FORMAT(article.created, '%M %Y') = '$date'";
		$sql .= " ORDER BY article.article_id DESC";

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	/*
	 *  Master section
	 * 
	 */


	public function adminCountPage() {
		$per_page = $this->admin_per_page;
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

		$sql = 'SELECT article.article_id as k0, article.title as k1, DATE_FORMAT(article.created, "%D %M %Y") as k2, ';
		$sql .= 'article.body as k3, article.tag as k4 FROM article';
		$sql .=' ORDER BY article.created DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function saveArticle() {
		Doo::loadCore('helper/DooValidator');

		//check if user exist before proceed
		if (!$_SESSION['user']['username']) {
			$this->toJSON('Only authorized personel can access this page', true);
			return 404;
		}

		//do server side validation
		$rules = array(
			'title' => array('required', 'Title must not empty'),
			'txtcontent' => array('required', 'Content must not empty')
		);

		$v = new DooValidator();
		$v->checkMode = DooValidator::CHECK_SKIP;

		$err = $v->validate($_POST, $rules);
		if ($err) {
			$this->toJSON(array('failed', $err), true);
			return 200;
		}

		//set word length of body content
		$txtcontent = wordwrap($_POST['txtcontent'], 90, '\n');

		/*
		 * 	create a new article if id is not defined
		 */
		if (empty($_POST['article_id'])) {

			//insert latest id
			$latest_update_array = array(
				'type' => 'article'
			);

			Doo::loadModel('LatestUpdate');
			$la = new LatestUpdate($latest_update_array);
			$last_insert_id = $la->insert();

			$article = array(
				'title' => $this->xss($_POST['title']),
				'created' => strftime("%Y-%m-%d %H:%M:%S", time()),
				'body' => $this->escape_val($txtcontent),
				'tag' => $this->xss($_POST['tag']),
				'visible' => 1,
				'user_id' => $_SESSION['user']['id'],
				'latest_id' => $last_insert_id
			);

			Doo::loadModel('Article');
			$a = new Article($article);
			$new_id = $a->insert();

			$this->toJSON(array('created', $new_id, $a->title), true);
			return 201;
		}

		////////////////////////////////////////
		// edit article with existing post id //
		////////////////////////////////////////

		if (!empty($_POST['article_id']) && intval($_POST['article_id']) > 0) {
			$article = array(
				'article_id' => $this->xss($_POST['article_id']),
				'title' => $this->xss($_POST['title']),
				'body' => $this->escape_val($txtcontent),
				'tag' => $this->xss($_POST['tag']),
				'visible' => 1,
				'user_id' => $_SESSION['user']['id'],
			);
			Doo::loadModel('Article');
			$a = new Article($article);
			$a->update();
			
			$this->toJSON(array('updated', $a->title), true);
			return 200;
		}

		//throw error page if non condition matched
		return 404;
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
		}
		else {
			return 404;
		}
	}

}

?>
