<?php

/**
 * Description of PaginationController
 *
 * @author terryxlife
 */
class PaginationController extends DooController {

	public function calculateExactPage($page_number) {
		$page = explode(".", $page_number);
		
		//if page number is int then return the value
		if (sizeof($page) === 1) {
			$page = $page_number;
		}
		else if (sizeof($page) > 1 && $page_number < 1) {
			$page = 1;
		}
		else {
			$page = $page_number + 1;
			$page = explode(".", $page);
			$page = $page[0];
		}
		return $page;
	}

}

?>
