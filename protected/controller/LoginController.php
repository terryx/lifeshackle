<?php

class LoginController extends CommonController {
	
	public function index() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;
		$data['title'] = "Sign In";
		$data['content'] = 'login';
		$data['nav'] = self::navigation();
		$data['customscript'] = $data['baseurl']."global/js/login.js?".$data['version'];

		$this->render('template/layout', $data, true);
		
	}

  //set auto login cookie for 1 year
  protected function setRememberMe($cookie_user, $cookie_pass) {
    setcookie('lfshacksuser', $cookie_user, time() + 31536000, '/', $_SERVER['HTTP_HOST']);
    setcookie('lfshackspwd', $cookie_pass, time() + 31536000, '/', $_SERVER['HTTP_HOST']);
  }

  public function login() {
    if (isset($_POST['username']) && isset($_POST['password'])) {

      $username = trim(htmlentities($_POST['username']));
      $password = trim(htmlentities($_POST['password']));

      Doo::loadModel('Users');

      $u = new Users;
      $u->username = $username;
      $u->password = hash('sha256', $password);

      $rs = $this->db()->getOne($u, array('select' => 'id, username, type, status'));
      if ($rs) {

        if ($rs->status === 'active') {
          $_SESSION['user'] = array(
              'id' => $rs->id,
              'username' => $rs->username,
              'role' => $rs->type,
              'status' => $rs->status,
              'is_logged_in' => true
          );

          //if remember me is selected
          (isset($_POST['remember'])) ? $this->setRememberMe($username, $u->password) : false;

          $this->toJSON(array('is_logged_in' => true), true);

          return 200;
        } else {
          $this->toJSON("You are not allow to access. Please contact the administrator", true);
          return 400;
        }
      } else {
        $this->toJSON("Invalid combination of username and password !", true);
        return 400;
      }
    } else {
      $this->toJSON("Connection error. Please try again.", true);
      return 400;
    }
  }

  public function logout() {
    unset($_SESSION['user']);
    session_destroy();
    if (isset($_COOKIE['lfshacksuser']) && isset($_COOKIE['lfshackspwd'])) {
      setcookie('lfshacksuser', '', 0, '/', $_SERVER['HTTP_HOST']);
      setcookie('lfshackspwd', '', 0, '/', $_SERVER['HTTP_HOST']);
    }
    return Doo::conf()->APP_URL;
  }

  public function passwordReset() {
    Doo::loadModel('Users');
    $u = new User;
  }

}

?>
