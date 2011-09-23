<?php

class PictureController extends CommonController {

  public function managePicturePage() {
    $menu = self::assignMenu();
    $this->renderc('/manage-picture', $menu);
  }

  //temporary redirect for super admin only
  public function savePicture() {
    Doo::loadHelper('DooGdImage');

    $ext = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'tiff');
    $gd = new DooGdImage('global/uploaded_pic/', 'global/resized_pic/');
    if ($gd->checkImageExtension('picture', $ext)) {

      $new_name = 'life_img_' . date('Ymdhis');
      $uploadImg = $gd->uploadImage('picture', $new_name);

      $gd->generatedQuality = 85;
      $gd->generatedType = 'jpg';

      $gd->thumbSuffix = '_shac';
      $resized_name = $gd->createThumb($uploadImg, 650, 600);

      Doo::loadModel('Picture');

      $picture_array = array(
          'name' =>$uploadImg,
          'created' => strftime("%Y-%m-%d %H:%M:%S", time()),
          'resized_name' => $new_name,
          'is_show' => 1,
          'user_id' => $_SESSION['user']['id']
      );
      $p = new Picture($picture_array);
      $last_insert_id = $p->insert();
      return Doo::conf()->APP_URL.'manage-picture';
    } else {
      $this->toJSON(array('Picture format is not supported'), true);
      return 400;
    }
  }

  //set thumbnails
  public function getPictureList(){
  $rs = $this->db()->find('Picture', array('select' => 'picture_id as k0, resized_name as k1', 'desc' => 'picture_id'));
  $this->toJSON($rs, true, true);
  }

  public function getOnePicture() {
    if (!$this->params['id'] || intval($this->params['id']) < 1) {
      return 404;
    } else {

      $rs = $this->db()->find('Picture', array(
                  'limit' => 1,
                  'where' => 'picture_id = ?',
                  'param' => array($this->params['id'])
              ));

      if ($rs) {
        $data = array(
            $rs->picture_id,
            $rs->name,
            $rs->created,
            $rs->resized_name,
            $rs->user_id);
        $this->toJSON($data, true, true);
      } else {
        $this->toJSON('Picture not found', true);
        return 400;
      }
    }
  }

  public function getPictureGallery() {
    $rs = $this->db()->find('Picture', array('select' => 'resized_name as k0', 'desc' => 'resized_name'));
    $this->toJSON($rs, true, true);
  }

  public function deletePicture(){
     if (!$this->params['id'] || intval($this->params['id']) < 1) {
      return 404;
    } else {
      Doo::loadModel('Picture');
      $p = new Picture;
      $p->picture_id = $this->params['id'];

      if($p->count()<1){
        return 404;
      }
      Doo::loadHelper('DooGdImage');

      $rs = $p->getOne();
      if($rs != null){
        $uploaded = Doo::conf()->SITE_PATH.'global/uploaded_pic/'.$rs->name;
        $resized = Doo::conf()->SITE_PATH.'global/resized_pic/'.$rs->resized_name.'_shac.jpg';

        unlink($uploaded);
        unlink($resized);
      }
      
      $this->db()->beginTransaction();
      try{
        $p->delete();
        $this->db()->commit();
        $this->toJSON(array('success'=>'Picture is deleted'), true);
        return 200;
      } catch(PDOException $e){
        $this->db()->rollBack();

        if($e->getCode()==23000){
           echo json_encode(array('error'=>'There is picture associated with this package. You cannot delete it.'));
                return 400;
        }
        return 500;
      }

    }

  }

}

?>