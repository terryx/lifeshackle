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
        } elseif ($found_user && $found_user->status == 'active') {

          $_SESSION['user'] = array(
              'id' => $found_user->id,
              'username' => $found_user->username,
              'role' => $found_user->type,
              'status' => $found_user->status,
              'is_logged_in' => true
          );

          $role = $_SESSION['user']['role'];
        } else {
          $role = "visitor";
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

  //set navigation and menu bar for registered and non-register user
  // nav -> navigation bar
  //menu -> menu bar
  protected static function assignNavigation() {
    //set navigation to admin if is user
    if (isset($_SESSION['user']) && $_SESSION['user']['status'] === 'active') {
      $data['nav'] = 'template/a-nav';
      switch ($_SESSION['user']['role']) {
        case 'normal':
          $data['menu'] = 'template/normal-menu';
          break;
        case 'admin':
          $data['menu'] = 'template/admin-menu';
          break;
        case 'super_admin':
          $data['menu'] = 'template/master-menu';
          break;
      }
    } else {
      //set navigation to visitor
      $data['nav'] = 'template/v-nav';
      $data['menu'] = 'template/v-menu';
    }
    return $data;
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

}

?>
