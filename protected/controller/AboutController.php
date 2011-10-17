<?php

/**
 * Description of About
 *
 * @author terryx
 */
class AboutController extends CommonController {

	public function index() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;
		$data['title'] = "Terry Profile";
		$data['nav'] = self::navigation();

		if (isset($_SESSION['user']['role'])) {

			$data['customscript'] = Doo::conf()->APP_URL . "global/js/" . $_SESSION['user']['role'] . "/about.js?" . Doo::conf()->version;
		} else {

			$data['customscript'] = Doo::conf()->APP_URL . "global/js/about.js?" . Doo::conf()->version;
		}

		$role = self::checkRole();
		if($role){
			$data['content'] = $role.'/about';
		} else {
			$data['content'] = 'about';
		}
		
		$this->render('template/layout', $data, true);
	}

	public function saveMyInfo() {

		if (isset($_SESSION['user']['id'])) {
			//save personal content
//			if($_POST['personal_content']){
//				$ud = new UserDetail;
//				
//			}

			$personal = $_POST['personal_content'];
			$technical = $_POST['technical_content'];
			$quote = $_POST['quote_content'];

			if (empty($_POST['user_detail_id'])) {
				$user_detail = array(
					'user_id' => $_SESSION['user']['id'],
					'personal' => $personal,
					'technical' => $technical,
					'quote' => $quote
				);
				
				Doo::loadModel('UserDetail');
				$ud = new UserDetail($user_detail);
				$ud->insert();
				
				$this->toJSON('created', true);
				
			} else if(!empty($_POST['user_detail_id'])){
				$user_detail = array(
					'user_detail_id' => $this->xss($_POST['user_detail_id']),
					'user_id' => $_SESSION['user']['id'],
					'personal' => $personal,
					'technical' => $technical,
					'quote' => $quote
				);
				
				Doo::loadModel('UserDetail');
				$ud = new UserDetail($user_detail);
				$ud->update();
				
				$this->toJSON('updated', true);
			}
		} else {
			$this->toJSON('failed', true);
		}
	}
	
	public function getDetailId(){
		Doo::loadModel('UserDetail');
		$ud = new UserDetail;
		
		$rs = $ud->getOne();
		
		$this->toJSON($rs, true);
		exit;
	}

}

?>
