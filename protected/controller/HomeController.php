<?php

//homecontroller control all public pages for non-register user
class HomeController extends CommonController {
	
	public function index() {
		$data = $this->templateData(__FUNCTION__);
		$data['chatuser'] = isset($_COOKIE['lfshackschatuser']) ? $_COOKIE['lfshackschatuser'] : '';
		$data['chatemail'] = isset($_COOKIE['lfshackschatemail']) ? $_COOKIE['lfshackschatemail'] : '';
		$this->render('template/layout', $data, true);
	}

	public function article() {
		$data = $this->templateData(__FUNCTION__);
		$this->render('template/layout', $data, true);
	}

	public function profile() {
		$data = $this->templateData(__FUNCTION__);
		
		if($data['role'] !== null){
			$data['content'] =  $data['role'] . DIRECTORY_SEPARATOR . __FUNCTION__;
		}
		$this->render('template/layout', $data, true);
	}

	public function video() {
		$data = $this->templateData(__FUNCTION__);
		$this->render('template/layout', $data, true);
	}
}

?>