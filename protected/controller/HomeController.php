<?php

class HomeController extends CommonController {

	public function index() {
		$data = self::templateData();
		$data['title'] = "Life Shackle";
		$data['content'] = $data['role'] . 'index';

		$this->render('template/layout', $data, true);
	}

}

?>
