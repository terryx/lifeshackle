<?php

class SessionController extends DooController {
	
	public function beforeRun($resource, $action) {

		session_start();
		
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
		} else {

			$role = 'visitor';
			$rs = $this->acl()->process($role, $resource, $action);
		}
		
	}
	
	public function checkRole() {
		$role = 'visitor';
		
		if (isset($_SESSION['user'])) {
			switch ($_SESSION['user']['role']) {
				case "admin":
					$role = 'admin';
					break;
				case "master":
					$role = 'master';
					break;
				default :
					$role = 'minion';
					break;
			}
		}
		return $role;
	}
}
?>
