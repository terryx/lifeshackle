<?php

class StatusUpdateController extends CommonController {

	public function editPage() {
		$data = $this->templateData();
		$data['title'] = 'Edit | Status Update';
		$data['content'] = $data['role'] . '/status-update/edit';
		$this->view()->render('template/layout', $data, true);
	}

	public function getAll() {
		$s = Doo::db()->find('StatusUpdate');
		if ($s) {
			$this->toJSON($s, true);
			return 200;
		}
		else {
			return 404;
		}
	}

	public function save() {
		if (!empty($_POST['status_update'])) {
			//insert
			if (empty($_POST['status_update_id'])) {
				Doo::loadModel('StatusUpdate');
				$s = new StatusUpdate;
				$s->user_id = $_SESSION['user']['id'];
				$s->created = strftime("%Y-%m-%d %H:%M:%S", time());
				$s->message = $_POST['status_update'];
				$new_id = $s->insert();

				$this->toJSON($s, true);
				return 201;
			}
			//update
			else if (intval($_POST['status_update_id'])) {
				//update
				Doo::loadModel('StatusUpdate');
				$s = new StatusUpdate;
				$s->status_update_id = $_POST['status_update_id'];
				$s->user_id = $_SESSION['user']['id'];
				$s->created = strftime("%Y-%m-%d %H:%M:%S", time());
				$s->message = $_POST['status_update'];
				$s->update();

				return 200;
			}
			//wrong id
			else {
				$this->toJSON('status id not found', true);
				return 400;
			}
		}
		//id is empty
		else {
			return 404;
		}
	}
}

?>
