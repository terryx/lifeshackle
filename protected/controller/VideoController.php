<?php

class VideoController extends SessionController {

	protected $per_page = 20;

	public function createPager() {
		$content = intval($this->params['content']);

		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = array(
			'select' => 'COUNT(video.video_id) / ? as num_of_item',
			'where' => 'video.visible = 1',
			'desc' => 'video.video_id',
			'param' => array($content)
		);
		
		$rs = Doo::db()->find('Video', $sql);
		$page_number = doubleval($rs[0]->num_of_item);
		
		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}
	
	public function makePagination(){
		
		$per_page = $this->params['page'];
		$current_page = $this->params['id'];

		$offset = ($current_page - 1) * $per_page;
		$sql = array(
			'select' => 'video.video_id, video.title',
			'desc' => 'video.video_id',
			'limit' => $offset . ', ' . $per_page
		);

		$rs = Doo::db()->find('Video', $sql);
		$this->toJSON($rs, true, true);
	}

	public function countTotal() {
		$per_page = $this->per_page;
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(video.video_id)/' . $per_page . ' as num_of_item FROM video ';
		$sql .= 'WHERE video.visible = 1';

		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function getPagination() {
		if (!intval($this->params['page']) || $this->params['page'] < 1) {
			return 404;
		}
		$per_page = $this->per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;

		$sql = 'SELECT video.video_id as k0, video.title as k1, video.link as k2, video.thumbnail as k3 FROM video';
		$sql .=' WHERE video.visible = 1 ORDER BY video.video_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function getVideoList() {
		$rs = $this->db()->find('Video', array(
			'select' => 'video_id as k0, title as k1',
			'desc' => 'video_id'
				));
		$this->toJSON($rs, true, true);
	}

	public function getOneVideo() {
		if (!$this->params['id'] || intval($this->params['id']) < 1) {
			return 404;
		} else {
			Doo::loadModel('Video');
			$a = new Video();
			$a->video_id = $this->params['id'];
			$rs = $a->getOne();

			if ($rs) {
				$this->toJSON($rs, true, true);
			} else {
				$this->toJSON('Video not found', true);
				return 400;
			}
		}
	}

	public function fetchVideos() {
		$per_page = $this->per_page;
		Doo::loadController('PaginationController');
	}

//----------------------------------------------------------------//
//------------------------ admin section -------------------------//
//----------------------------------------------------------------//

	public function adminSetPagination() {
		if (intval($this->params['set']) < 1) {
			return 404;
		}

		//how many sets per one page
		$per_page = intval($this->params['set']);
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(video_id)/' . $per_page . ' as num_of_item FROM video';
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

		$sql = 'SELECT video.video_id as k0, video.title as k1, video.link as k2, video.thumbnail as k3 FROM video';
		$sql .=' ORDER BY video.video_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function saveVideo() {
		if (intval($_POST['video_id']) > 0) {
			// update video info
			$video_array = array(
				'visible' => $_POST['visible']
			);
			Doo::loadModel('Video');
			$v = new Video($video_array);
			if ($v->video_id = $_POST['video_id']) {
				$v->update();
				return 200;
			} else {
				$this->toJSON('Video could not be save.', true);
			}
		} elseif (empty($_POST['video_id'])) {
			// upload video
			if ($_POST['title'] && $_POST['videolink']) {

				//insert latest id
				$latest_update_array = array(
					'type' => 'article'
				);

				Doo::loadModel('LatestUpdate');
				$la = new LatestUpdate($latest_update_array);
				$last_insert_id = $la->insert();

				$string = $_POST['title'];
				$quote_style = ENT_NOQUOTES;
				$charset = 'UTF-8';

				$title = html_entity_decode($string, $quote_style, $charset);
				$video_array = array(
					'title' => $title,
					'created' => strftime("%Y-%m-%d %H:%M:%S", time()),
					'link' => $_POST['videolink'],
					'thumbnail' => $_POST['thumbnail'],
					'visible' => 1,
					'user_id' => $_SESSION['user']['id'],
					'latest_id' => $last_insert_id
				);

				Doo::loadModel('Video');
				$v = new Video($video_array);
				$new_video_id = $v->insert();

				$this->toJSON($new_video_id, true);
				return 201;
			} else {
				$this->toJSON('Video could not be save.', true);
			}
		}
	}

	public function deleteVideo() {
		//get video
		$v = $this->db()->find('Video', array(
			'limit' => 1,
			'where' => 'video.video_id = ?',
			'param' => array(intval($this->params['id']))
				));

		if ($v->count()) {
			//get latest id
//			$la = $this->db()->find('LatestUpdate', array(
//				'limit' => 1,
//				'where' => 'latest_update.latest_id = ?',
//				'param' => array($v->latest_id)
//					));

			$v->beginTransaction();
//			$la->beginTransaction();
			try {
				$v->delete();
//				$la->delete();
				$v->commit();
				$this->toJSON(array('deleted'), true);
			} catch (PDOException $e) {
				$v->rollBack();
				return 400;
			}
		} else {
			return 404;
		}
	}

}

?>
