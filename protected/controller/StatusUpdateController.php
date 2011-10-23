<?php

class StatusUpdateController extends CommonController {

	public function editPage() {
		$data = $this->templateData();
		$data['title'] = 'Edit | Status Update';
		$data['content'] = $data['role'] . '/status-update/edit';
		$this->view()->render('template/layout', $data, true);
	}

	public function save() {
		
	}

}

?>
