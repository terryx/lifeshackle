<?php

class StatusUpdateController extends CommonController {

	private  $per_page = 5;
	
	public function escape_val($val) {

		if (get_magic_quotes_gpc()) {
			$val = stripcslashes($val);
		}
		return $val;
	}

	public function editPage() {
		$data = $this->templateData($this->checkRole() . '/status-update/edit');
		$data['title'] = 'Edit | Status Update';

		$this->view()->render('template/layout', $data, true);
	}

	public function setPagination() {
		$per_page = $this->per_page ;
		
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(status_update_id)/' . $per_page . ' as num_of_item FROM status_update ';

		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function getPagination() {
		if (!intval($this->params['page']) || $this->params['page'] < 1) {
			return 404;
		}
		
		$per_page = $this->per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;

		$sql = "SELECT status_update.status_update_id as k0, status_update.message as k1, status_update.created as k2 FROM status_update ";
		$sql .= "ORDER BY status_update.status_update_id DESC LIMIT " . $offset . ", " . $per_page;
		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function save() {
		if (!empty($_POST['status_update_text'])) {
			$content = nl2br($_POST['status_update_text']);
			//insert
			if (empty($_POST['status_update_id'])) {
				Doo::loadModel('LatestUpdate');
				$lu = new LatestUpdate;
				$lu->type = 'status-update';
				$lu_id = $lu->insert();

				Doo::loadModel('StatusUpdate');
				$s = new StatusUpdate;
				$s->user_id = $_SESSION['user']['id'];
				$s->created = time();
				$s->message = $this->escape_val($content);
				$s->latest_id = $lu_id;
				$new_id = $s->insert();

				$this->toJSON(array('created', $new_id), true);
				return 201;
			}
			//update
			else if (intval($_POST['status_update_id'])) {
				//GET current status update
				Doo::loadModel('StatusUpdate');
				$status = new StatusUpdate();
				$status->status_update_id = $_POST['status_update_id'];
				$status_rs = $status->getOne();

				if ($status_rs) {
					//DELETE latest update id from current status update
					Doo::loadModel('LatestUpdate');
					$latest = new LatestUpdate();
					$latest->latest_id = $status_rs->latest_id;
					$latest_rs = $latest->getOne();

					if ($latest_rs) {
						$latest_rs->delete();
					}

					Doo::loadModel('LatestUpdate');
					$lu = new LatestUpdate;
					$lu->type = 'status-update';
					$lu_id = $la->insert();

					Doo::loadModel('StatusUpdate');
					$s = new StatusUpdate;
					$s->status_update_id = $_POST['status_update_id'];
					$s->user_id = $_SESSION['user']['id'];
					$s->created = strftime("%Y-%m-%d %H:%M:%S", time());
					$s->message = $_POST['status_update_text'];
					$s->latest_id = $lu_id;
					$s->update();

					$this->toJSON(array('updated', $s), true);
					return 200;
				}
			}
			//wrong id
			else {
				$this->toJSON('status id not found', true);
				return 400;
			}
		}
		//id is empty
		else {
			return;
		}
	}

	public function deleteOne() {
		$id = $this->params['id'];

		if (intval($id) > 0) {
			Doo::loadModel('StatusUpdate');
			$st = new StatusUpdate;
			$st->status_update_id = $id;
			$st_rs = $st->getOne();

			if ($st_rs->latest_id) {
				Doo::loadModel('LatestUpdate');
				$lu = new LatestUpdate;
				$lu->latest_id = $st_rs->latest_id;
				$lu_rs = $lu->getOne();
				if($lu_rs){
					$lu_rs->delete();
				}
				
				$st_rs->beginTransaction();
				try {
					$st_rs->delete();
					$st_rs->commit();
					$this->toJSON(array('deleted'), true);
					return 200;
				} catch (PDOException $e) {
					$st_rs->rollBack();
					return 400;
				}
			}
		} else {
			return 400;
		}
	}

}

?>
