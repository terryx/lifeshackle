<?php

//homecontroller control all public pages for non-register user
class HomeController extends CommonController {
	
	//set universal module , data template
	//if is user page will redirect to role/page else page
	private function setData($page) {
		$data = $this->templateData();
		$data['module_login'] = 'template/login';
		$data['module_chat'] = 'template/chat';
		$data['content'] = ($data['role'] !== null) ? $data['role'] . DIRECTORY_SEPARATOR . $page :  $page;
		return $data;
	}
 
	public function index() {
		$data = $this->setData(__FUNCTION__);
		$this->render('template/layout', $data, true);
	}

	public function article() {
		$data = $this->setData(__FUNCTION__);
		$data['title'] = 'Article';

		if ($data['role'] !== null) {
			$data["content"] = $data["role"] . "/article/view";
		} else {
			$data['content'] = 'index';
		}
		$this->render('template/layout', $data, true);
	}

	public function profile() {
		$data = $this->setData(__FUNCTION__);
		$this->render('template/layout', $data, true);
	}

	public function video() {
		$data = $this->setData(__FUNCTION__);
		$this->view()->render('template/layout', $data, true);
	}
}

?>