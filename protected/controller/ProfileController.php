<?php

/**
 * Description of Profile
 *
 * @author terryx
 */
class ProfileController extends CommonController {
	
	private $file = 'global/file/profile.txt';
	
	protected function getPictureId($id){
		Doo::loadModel('ProfilePicture');
		$pc = new ProfilePicture;
		$pc->picture_id = $id;
		$rs = $pc->getOne();
		return $rs;
	}
	
	public function editPage() {
		$data = $this->templateData($this->checkRole() . '/profile/edit');
		$data['title'] = 'Edit | Profile';
		
		$file = $this->fetchContent();
		$data['profile_content'] = (isset($file)) ? $file : '';
		
		$this->view()->render('template/layout', $data, true);
	}
	
	public function setCurrent(){
		Doo::loadModel('ProfilePicture');
		$current_picture = new ProfilePicture;
		
		$current_picture->is_current = 'yes';
		$current = $current_picture->getOne();
		
		if($current){
			$current->is_current = 'no';
			$current->update();
		}
		
		$pc = new ProfilePicture;
		$pc->picture_id =  $this->params['id'];
		$rs = $pc->getOne();
		
		if($rs){
			$pc->is_current = 'yes';
			$pc->update();
			$this->toJSON(array('updated'), true);
		}
		return 200;
	}
	
	public function getCurrent(){
		Doo::loadModel('ProfilePicture');
		$current = new ProfilePicture;
		$current->is_current = 'yes';
		$rs = $current->getOne();
		if($rs){
			$original = 'global/uploaded_pic/' . $rs->original;
			$resized = 'global/resized_pic/' . $rs->resized;
		} else {
			$original = 'global/uploaded_pic/terry.jpg';
			$resized = 'global/uploaded_pic/terry.jpg';
		}
		
		return array($original, $resized);
	}
	
	public function fetchContent(){
		$output = file_get_contents($this->file);
		return $output;
	}

	public function save(){
		$_SESSION['user']['id'] = ($_SESSION['user']['id'] === null) ?  $this->toJSON('failed', true) : false;
		
		$content = $this->escape_val($_POST['txtcontent']);
		
		$output = file_put_contents($this->file, $content);
		if($output){
			$this->toJSON(array('saved'), true);
		} else {
			$this->toJSON(array('failed'), true);
		}
		return 200;
	}
	
	public function uploadPicturePage($message = '') {
		$role = $this->checkRole();
		$data['message'] = $message;
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;

		$data['title'] = 'Upload picture | Profile';

		$this->view()->render($role . '/profile/upload-picture', $data, true);
	}

	public function deletePicture() {
		Doo::loadModel('ProfilePicture');
		$pc = new ProfilePicture;
		$pc->picture_id = $this->params['id'];
		$rs = $pc->getOne();

		$original = 'global/uploaded_pic/' . $rs->original;
		$resized = 'global/resized_pic/' . $rs->resized;

		if (file_exists($original)) {
			unlink($original);
		}

		if (file_exists($resized)) {
			unlink($resized);
		}

		$rs->beginTransaction();
		try {
			$rs->delete();
			$rs->commit();
			$this->toJSON(array('deleted'), true);
		} catch (PDOException $e) {
			$rs->rollBack();
			$this->toJSON(array('failed'), true);
		}
	}

	public function uploadPicture() {
		Doo::loadHelper('DooGdImage');
		$ext = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'tiff');
		$gd = new DooGdImage('global/uploaded_pic/', 'global/resized_pic/');
		if ($gd->checkImageExtension('upload_file', $ext)) {

			$imageType = explode('/', $_FILES['upload_file']['type']);
			$originalType = $imageType[1];

			$new_name = 'profile_' . time();
			$uploadImg = $gd->uploadImage('upload_file', $new_name);

			$gd->generatedQuality = 85;
			$gd->generatedType = 'jpg';
			$gd->thumbSuffix = '_thumb';
			$gd->createThumb($uploadImg, 200, 250);

			$original = $new_name . '.' . $originalType;
			$resized = $new_name . $gd->thumbSuffix . '.' . $gd->generatedType;
			Doo::loadModel('ProfilePicture');

			$picture_array = array(
				'original' => $original,
				'resized' => $resized,
				'visible' => 'yes',
				'caption' => $_POST['caption']
			);
			$p = new ProfilePicture($picture_array);
			$last_insert_id = $p->insert();
			$this->uploadPicturePage('<div class="input success">Upload sucessfully</div>');
		} else {
			$this->uploadPicturePage('<div class="input fail">Upload failed</div>');
		}
	}

	public function fetchPicture() {
		$sql = "SELECT profile_picture.picture_id, profile_picture.original, profile_picture.resized, profile_picture.visible, profile_picture.caption, profile_picture.is_current ";
		$sql .= "FROM profile_picture ORDER BY profile_picture.picture_id DESC";

		$rs = $this->db()->fetchAll($sql);
		if ($rs) {
			$this->toJSON($rs, true);
			return 200;
		} else {
			return 200;
		}
	}
}
?>