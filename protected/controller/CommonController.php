<?php

class CommonController extends DooController {

	public function beforeRun($resource, $action) {

		session_start();
		//TODO :
		//find user cookie if session not found
		//assign role as visitor if session not found
		if (isset($_SESSION['user']) === false) {

			if (isset($_COOKIE['lfshacksuser']) && isset($_COOKIE['lfshackspwd'])) {

				Doo::loadModel('Users');

				$u = new Users;
				$u->username = $_COOKIE['lfshacksuser'];
				$u->password = $_COOKIE['lfshackspwd'];

				$found_user = $this->db()->getOne($u, array('select' => 'id, username, type, status'));

				if ($found_user && $found_user->status != 'active') {
					$role = 'inactive';
				} else if ($found_user && $found_user->status == 'active') {

					$_SESSION['user'] = array(
						'id' => $found_user->id,
						'username' => $found_user->username,
						'role' => $found_user->type,
						'status' => $found_user->status,
						'is_logged_in' => true
					);

					$role = $_SESSION['user']['role'];
				} else {
					$role = 'visitor';
				}

				$rs = $this->acl()->process($role, $resource, $action);
				return $rs;
			}
		}

		//if session already exist
		elseif (isset($_SESSION['user'])) {

			if ($_SESSION['user']['status'] != 'active') { //check for banned user
				$role = 'inactive';
			} else {

				$role = $_SESSION['user']['role'];
			}

			$rs = $this->acl()->process($role, $resource, $action);
			return $rs;
		} else {

			$role = 'visitor';
			$rs = $this->acl()->process($role, $resource, $action);
			return $rs;
		}
	}

	protected function templateData($content) {
		$role = $this->checkRole();
		$data['role'] = $role;
		
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;
		
		$data['nav'] = ($role !== null) ? 'template/nav-' . $role : 'template/nav-visitor';
		
		$data['title'] = ($content !== 'index') ? $content : 'Life Shackle';
		$data['content'] = $content;
//		$data['content'] = $role . DIRECTORY_SEPARATOR . $content;
		
		return $data;
	}
	
//	private function setData($content) {
//		$data = $this->templateData();
//		$data['module_chat'] = 'template/chat';
//		$data['title'] = ($content !== 'index') ? $content : 'Life Shackle';
//		$data['content'] = ($data['role'] !== null) ? $data['role'] . DIRECTORY_SEPARATOR . $content : $content;
//		$this->render('template/layout', $data, true);
//	}
	
	protected function checkRole() {
		$role = null;
		if (isset($_SESSION['user'])) {
			switch ($_SESSION['user']['role']) {
				case "admin":
					$role = 'admin';
					break;
				case "master":
					$role = 'master';
					break;
				case 'minion':
					$role = 'minion';
				default :
					$role= null;
					break;
			}
		}
		return $role;
	}

	public function xss($str, $striptags=true) {
		if ($striptags) {
			$str = strip_tags($str);
		}

		if (!isset(Doo::conf()->xssFilter)) {
			Doo::loadClass('htmlpurifier/library/HTMLPurifier.auto');
			$purifyconfig = HTMLPurifier_Config::createDefault();
			$purifyconfig->set('Core.Encoding', 'UTF-8');
			$purifier = new HTMLPurifier($purifyconfig);
			Doo::conf()->xssFilter = $purifier;
			$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
			return str_replace('&amp;', '&', $purifier->purify($str));
		}

		$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
		return str_replace('&amp;', '&', Doo::conf()->xssFilter->purify($str));
	}

	protected function redirect($url) {
		header('Location:' . $url);
		exit;
	}
	
	protected function status_code_200(){
		header("Status: 200");
		exit;
	}

}

?>
