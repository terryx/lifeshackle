<?php

class ChatController extends CommonController {

	public function publicPage() {
		
	}

	public function escape_val($val) {

		if (get_magic_quotes_gpc()) {
			$val = stripcslashes($val);
		}
		return $val;
	}

	public function editPage() {
		$data = $this->templateData();
		$data["title"] = 'Chat';
		$data["content"] = $data["role"] . "/chat/edit";

		$this->view()->render('template/layout', $data, true);
	}

	public function saveUser() {
		$username = $_POST['chatuser'];
		$email = $_POST['chatemail'];

		$rules = array(
			'chatuser' => array('required', 'Name must not empty'),
			'chatemail' => array('email')
		);

		$v = new DooValidator();
		$v->checkMode = DooValidator::CHECK_SKIP;
		$err = $v->validate($_POST, $rules);
		if ($err) {
			$this->toJSON($err, true);
			return 400;
		} else {
			setcookie('lfshackschatuser', $username, time() + 31536000, '/', $_SERVER['HTTP_HOST']);
			setcookie('lfshackschatemail', $email, time() + 31536000, '/', $_SERVER['HTTP_HOST']);
			$this->toJSON(array($username, $email), true);
			return 200;
		}
	}

	public function saveChat() {
		$content = $_POST['chat_content'];
		$user = $_POST['c_user'];
		$email = $_POST['c_email'];

		$rules = array(
			'c_user' => array('required', 'Name must not empty'),
			'c_email' => array('email'),
			'chat_content' => array('required', 'Content must not empty')
		);

		$v = new DooValidator();
		$v->checkMode = DooValidator::CHECK_SKIP;
		$err = $v->validate($_POST, $rules);
		if ($err) {
			$this->toJSON($err, true);
			return 400;
		} else {

			Doo::loadModel('Chat');
			$chat_array = array(
				'created' => strftime("%Y-%m-%d %H:%M:%S", time()),
				'message' => $this->escape_val($content),
				'username' => $user,
				'email' => $email
			);

			$c = new Chat($chat_array);
			$new_id = $c->insert();

			$this->toJSON(array($new_id), true);
			return 201;
		}
		return 404;
	}

	public function fetchChatList() {
		$rs = $this->db()->find('Chat', array('select' =>
			'chat_id as k0, DATE_FORMAT(created, "%D %M %Y %r") as k1, message as k2, username as k3, email as k4',
			'desc' => 'chat_id'));
		$this->toJSON($rs, true, true);
	}

	public function poolChat() {
		$id = $this->params['id'];

		if (intval($id) < 0) {
			//return with empty data
			header("Status: 200");
			exit;
		} else {
			$sql = "SELECT MAX(chat_id) as k0 FROM chat";
			$last_id = $this->db()->fetchAll($sql);
			$last_id = $last_id[0]['k0'];
			if ($id === $last_id) {
				header("Status: 200");
				exit;
			} else {
				//get untracked id by minus last id
				if ($id === 0) {
					$sql = "SELECT chat_id as k0, DATE_FORMAT(created, '%D %M %Y %r') as k1, message as k2, username as k3, email as k4";
					$sql .= " FROM chat WHERE chat_id = 1 ORDER BY chat_id DESC";
				} else {
					$sql = "SELECT chat_id as k0, DATE_FORMAT(created, '%D %M %Y %r') as k1, message as k2, username as k3, email as k4";
					$sql .= " FROM chat WHERE chat_id > {$id} ORDER BY chat_id DESC";
				}
				$untracked = $this->db()->fetchAll($sql);

				//if sql is empty
				if (!$untracked) {
					header("Status: 200");
					exit;
				}

				$this->toJSON(array($untracked, $last_id), true);
				if (!headers_sent()) {
					header("Status: 200");
					exit;
				}
				exit;
			}
		}
		return 404;
	}

	public function deleteChatPost() {
		$sql = 'TRUNCATE TABLE chat';
		$rs = $this->db()->fetchAll($sql);
		if ($rs) {
			return 200;
		} else {
			return 400;
		}
	}

}

?>