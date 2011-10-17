<?php

/**
 * Description of Profile
 *
 * @author terryx
 */
class ProfileController extends CommonController {

	public function profile() {
		$data = self::templateData();
		$data['title'] = "Terry Yuen";
		$data['content'] = $data['role'] . 'profile';

		$this->render('template/layout', $data, true);
	}

	public function save() {

		if (isset($_SESSION['user']['id'])) {

			$personal = $_POST['personal-content'];
			$technical = $_POST['technical-content'];
			$quote = $_POST['quote-content'];

			if (empty($_POST['profile_id'])) {
				$user_detail = array(
					'user_id' => $_SESSION['user']['id'],
					'personal' => nl2br($personal),
					'technical' => nl2br($technical),
					'quote' => nl2br($quote),
				);

				Doo::loadModel('Profile');
				$ud = new Profile($user_detail);
				$ud->insert();

				$this->toJSON('created', true);
			}
			else if (!empty($_POST['profile_id'])) {
				$user_detail = array(
					'profile_id' => $this->xss($_POST['profile_id']),
					'user_id' => $_SESSION['user']['id'],
					'personal' => nl2br($personal),
					'technical' => nl2br($technical),
					'quote' => nl2br($quote),
				);

				Doo::loadModel('Profile');
				$ud = new Profile($user_detail);
				$ud->update();

				$this->toJSON('updated', true);
			}
		}
		else {
			$this->toJSON('failed', true);
		}
	}

	public function get() {

		Doo::loadModel('Profile');
		$p = new Profile;
		$rs = $p->getOne();

		$this->toJSON($rs, true);
		exit;
	}

	public function savePic() {
		if (isset($_SESSION['user']['id'])) {

			Doo::loadHelper('DooGdImage');

			$ext = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'tiff');
			
			$gd = new DooGdImage('global/uploaded_pic/', 'global/resized_pic/');
			
			if ($gd->checkImageExtension('filename', $ext)) {
				$new_name = 'life_img_' . date('Ymdhis');
				$uploadImg = $gd->uploadImage('filename', $new_name);

				$gd->generatedQuality = 85;
				$gd->generatedType = 'jpg';

				$gd->thumbSuffix = '_shac';
				$resized_name = $gd->createThumb($uploadImg, 250, 300);

				Doo::loadModel('Profile');

				$picture_array = array(
					'profile_id' => 2,
					'picture' => $uploadImg,
				);
				$p = new Picture($picture_array);
				$p->update();

				echo "File uploaded successfully";
			}
			else {
				echo "File uploaded failed";
			}
		}
		else {
			echo "Please login";
		}
	}

	public function picForm() {
		$data['baseurl'] = Doo::conf()->APP_URL;

		$this->render('template/picture-form', $data, true);
	}

}

?>