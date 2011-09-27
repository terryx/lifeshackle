<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of About
 *
 * @author terryx
 */
class TemplateController extends CommonController {
	
	public static function generateCSS(){
		$str = '<link rel="stylesheet" href="'.Doo::conf()->APP_URL.'global/css/main.css?v1" type="text/css" media="screen" />';
		$str .= '<link rel="stylesheet" href="'.Doo::conf()->APP_URL.'global/min/validationEngine.jquery.css" type="text/css" media="screen" />';
		return $str;
	}
	
	public static function generateJavaScript() {

		$str = '<script type="text/javascript" src="' . Doo::conf()->remote_url . 'global/min/common.js?v1"></script>';
		$str .= '<script type="text/javascript" src="' . Doo::conf()->remote_url . 'global/min/jquery.validationEngine.js?v1"></script>';
		$str .= '<script type="text/javascript" src="' . Doo::conf()->remote_url . 'global/min/jquery.paginate.js?v1"></script>';
		return $str;
	}
	
	public static function generateCustomScript(){
		
	}
	

	public static function generateNavigation() {
		$nav = null;
		if (isset($_SESSION['user']) && $_SESSION['user']['status'] === "active") {
			switch ($_SESSION['user']['role']) {
				case "admin":
					$nav = $this->generateAdminNav();
					break;
				case "super_admin":
					$nav = "master";
					break;
				default :
					$nav = generateVisitorNav();
					break;
			}
		} else {
			$nav = self::generateVisitorNav();
		}
		return $nav;
	}

	private function generateAdminNav() {
		
	}

	private function generateMasterNav() {
		
	}

	private function generateMinionNav() {
		
	}

	private static function generateVisitorNav() {
		$str = '<section id="navigation">';
		$str .= '<div class="topbar">
						<div class="topbar-inner">
							<div class="container">
							<a class="brand" href="' . Doo::conf()->APP_URL . '">Life Shackle</a>
							<ul class="nav">
								<li><a href="' . Doo::conf()->APP_URL . '"article">Article</a></li>
								<li><a href="' . Doo::conf()->APP_URL . '"video">Video</a></li>
								<li><a href="' . Doo::conf()->APP_URL . '"about">About</a></li>
							</ul>
							</div>
						</div>
				  </div>
				  </section>';
		return $str;
	}

}
?>

