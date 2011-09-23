<?php

class HomeController extends CommonController {

  public function index() {

    $data = self::assignNavigation();
    $this->renderc('index', $data);
  }

  public function article() {
    $data = self::assignNavigation();
    $this->renderc('article', $data);
  }

  public function picture() {
    $data = self::assignNavigation();
    $this->renderc('picture', $data);
  }

  public function about() {
//    if(isset($_SESSION['user']) && $_SESSION['is_logged_in'] === true && $_SESSION['user']['role'] === "super_admin" ){
//
//    }

    $data = self::assignNavigation();
    $this->renderc('about', $data);
  }

   public function video() {
    $data = self::assignNavigation();
    $this->renderc('video', $data);
  }

  public function signin() {
    if(isset($_SESSION['user']) && $_SESSION['user']['is_logged_in'] === true){
    $this->redirect('home');
    }

    $data = self::assignNavigation();
    $this->renderc('signin', $data);
  }

}

?>
