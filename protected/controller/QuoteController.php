<?php

class QuoteController extends CommonController {

	public $per_page = 20;

	public function index() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;
		$data['title'] = "Life's Quote";
		$data['content'] = 'quote';
		$data['nav'] = self::navigation();
//		$data['customscript'] = "global/js/video.js?v2";

		$this->render('template/layout', $data, true);
	}

	public function manageQuotePage() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;
		$data['title'] = "Life's Quote";
		$data['content'] = 'manage-quote';
		$data['nav'] = self::navigation();

		$this->render('template/layout', $data, true);
	}

	public function countPage() {
		$per_page = $this->per_page;
		$sql = 'SELECT COUNT(video_id)/' . $per_page . ' as num_of_item FROM video ';
		$sql .= 'WHERE video.visible';
		$rs = $this->db()->fetchAll($sql);
		$page_number = $rs[0]['num_of_item'];

		//if page number is int then return the value
		if (is_int($page_number)) {
			$this->toJSON($page_number, true);
		} else if ($page_number < 1) {
			$page = 1;
			$this->toJSON($page, true);
		} else {
			$page = strrpos($page_number, '.') + 1;
			$this->toJSON($page, true);
		}
	}

	public function getPagination() {
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;
		$sql = 'SELECT video.video_id as k0, video.title as k1, video.link as k2, video.thumbnail as k3 FROM video';
		$sql .= ' WHERE video.visible = 1 ORDER BY video.video_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

}

?>
