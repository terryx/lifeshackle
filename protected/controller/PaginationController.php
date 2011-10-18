<?php

/**
 * Description of PaginationController
 *
 * @author terryxlife
 */
class PaginationController extends DooController {

	protected $per_page = 20;

	public function calculateExactPage($page_number) {
		$page = 0;
		//if page number is int then return the value
		if (is_int($page_number)) {
			$page = $page_number;
		}
		else if ($page_number < 1) {
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
