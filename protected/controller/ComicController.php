<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComicController
 *
 * @author terryx
 */
class ComicController extends CommonController {
 public function managePicturePage() {
    $menu = self::assignMenu();
    $this->renderc('/manage-comic', $menu);
  }
}

?>
