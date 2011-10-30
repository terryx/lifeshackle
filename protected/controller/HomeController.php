<?php

//homecontroller control all public pages for non-register user
class HomeController extends CommonController {

	public function index() {
		$data = $this->templateData();
		
		if (isset($_COOKIE['lfshackschatuser']) && isset($_COOKIE['lfshackschatemail'])) {
			$data['chatuser'] = $_COOKIE['lfshackschatuser'];
			$data['chatemail'] = $_COOKIE['lfshackschatemail'];
		} else {
			$data['chatuser'] = '';
			$data['chatemail'] = '';
		}
		
		if ($data['role'] !== null) {
			$data['title'] = "Life Shackle | " . ucfirst($data['role']);
			$data['content'] = $data['role'] . '/index';
		}
		else {
			$data['title'] = "Life Shackle";
			$data['content'] = 'index';
		}

		$this->render('template/layout', $data, true);
	}

	public function article() {
		$data = $this->templateData();
		if ($data['role'] !== null) {
			$data["title"] = 'Article | ' . ucfirst($data['role']) . ' View';
			$data["content"] = $data["role"] . "/article/view";
		}
		else {
			$data['title'] = 'Article';
			$data['content'] = 'index';
		}
		$this->render('template/layout', $data, true);
	}

	public function profile() {
		$data = $this->templateData();
		$data['title'] = "Profile";
		if ($data['role'] !== null) {
			$data['content'] = $data['role'] . '/profile';
		}
		else {
			$data['title'] = "Profile";
			$data['content'] = 'profile';
		}

		$this->render('template/layout', $data, true);
	}

	public function video() {
		$data = $this->templateData();
		if ($data['role'] !== null) {
			$data["title"] = 'Video | ' . ucfirst($data['role']) . ' View';
			$data["content"] = $data["role"] . "/video/view";
		}
		else {
			$data['title'] = 'Videos';
			$data['content'] = 'video';
		}

		$this->render('template/layout', $data, true);
	}

}

?>