<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreController
 *
 * @author terryxlife
 */
class StoreController extends CommonController {

	public $admin_per_page = 10;

	public function editPage() {
		$data = $this->templateData($this->checkRole() . '/store/edit');
		
		//overwrite some template array
		$data['title'] = 'Edit | Store';
		$data['message'] = isset($_SESSION['message']) ? $_SESSION['message'] : '';

		$this->view()->render('template/layout', $data, true);
	}

	public function editCategoryPage() {
		$data = $this->templateData($this->checkRole() . '/store/edit-category');

		//overwrite some template array
		$data['title'] = 'Edit | Item Category';

		$this->view()->render('template/layout', $data, true);
	}

	public function getCategory() {

		$sql = "SELECT product_category.category_id, product_category.category_name FROM product_category";
		$rs = $this->db()->fetchAll($sql);

		if ($rs) {
			$this->toJSON($rs, true);
		}
	}

	public function saveCategory() {

		$id = $_POST['category_id'];
		$category = $_POST['category'];
		$description = $_POST['description'];

		if (empty($category)) {
			$this->toJSON(array('Category cannot be empty'));
			return 200;
		} else {

			//DEFINE model and POST array
			Doo::loadModel('ProductCategory');
			$stack = array(
				'category_name' => $category,
				'description' => $description
			);

			//CREATE if id is empty
			if (empty($id)) {
				$pc = new ProductCategory($stack);
				$last_id = $pc->insert();

				unset($stack);
				$this->toJSON(array($last_id), true);
				return 200;
			} else {
				if (intval($id) > 0) {
					//append category id to array $stack
					$update_stack = array('category_id' => $id);
					$stack = array_merge($stack, $update_stack);
					$pc = new ProductCategory($stack);
					$pc->update();

					unset($stack);
					$this->toJSON(array($category . ' is updated'), true);
					return 200;
				}

				//DEFAULT update error
				$this->toJSON(array('Failed to update category'), true);
				return 200;
			}
		}

		//DEFAULT save error
		$this->toJSON(array('Failed to save category'), true);
		return 200;
	}

	//template form
	public function storePictureForm() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['original'] = '';
		$data['thumb'] = '';
		$data['message'] = isset($_SESSION['message']) ? $_SESSION['message'] : '';

		Doo::loadModel('Product');
		$product = new Product;
		$product->product_id = $this->params['product_id'];
		$get = Doo::db()->find($product, array('limit' => 1));

		$imagePath = 'global/store/';

		if ($get) {
			if (file_exists($imagePath . $get->image)) {
				$data['original'] = $data['baseurl'] . $imagePath . $get->image;
				$data['thumb'] = $data['baseurl'] . $get->thumbnail;
			}
		} else {
			$data['original'] = $data['baseurl'] . $imagePath . 'no-image.png';
			$data['thumb'] = $data['baseurl'] . $imagePath . 'no-image.png';
		}
		$this->render('template/store-picture-form', $data, true);
	}

	public function savePicture() {
		$product_id = $_POST['product_picture_id'];
		Doo::loadHelper('DooGdImage');

		//IMAGE UPLOAD PATH SETTINGS
		$ext = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'tiff');
		//Doo image : uploadpath, processpath, saveimage, time as name
		$uploadPath = 'global/store/';
		$processPath = 'global/store/';
		$gd = new DooGdImage($uploadPath, $processPath);

		if ($gd->checkImageExtension('filename', $ext)) {

			$new_name = time();
			$uploadImg = $gd->uploadImage('filename', $new_name);

			//RESIZE & UPLOAD STORE IMAGE
			$gd->generatedQuality = 85;
			$format = $gd->generatedType = 'jpg';
			$gd->thumbSuffix = '_thumb';
			$thumbnail = $gd->createThumb($uploadImg, 210, 150);

//			//DELETE ORIGNAL IMAGE
//			if ($storeImage) {
//				unlink($uploadPath . $uploadImg);
//			}
			//DELETE EXISTING IMAGE IN STORE

			if (!empty($product_id)) {
				$store = Doo::db()->find('Product', array(
					'select' => 'product.image, product.thumbnail',
					'where' => 'product.product_id = ?',
					'param' => array($product_id)
						));
				$existedStoreImage = $store[0]->image;
				$existedStoreThumb = $store[0]->thumbnail;
				
				if ($existedStoreImage && file_exists($processPath . $existedStoreImage)) {
					unlink($processPath . $existedStoreImage);
				}

				if ($existedStoreThumb && file_exists($existedStoreThumb)) {
					unlink($existedStoreThumb);
				}

				Doo::loadModel('Product');
				$picture_array = array(
					'product_id' => $product_id,
					'image' => $uploadImg,
					'thumbnail' => $thumbnail
				);

				$p = new Product($picture_array);
				$p->update();
			} else {
				$_SESSION['message'] = "There is no product for this image.";
			}

			return Doo::conf()->APP_URL . 'template/store-picture-form/' . $product_id;
		} else {
			$_SESSION['message'] = "Picture cannot be uploaded. Please try again";
			return Doo::conf()->APP_URL . 'template/store-picture-form/' . $product_id;
		}
	}

	public function saveProduct() {
		$id = $_POST['product_id'];
		$category = $_POST['category'];
		$item_name = $_POST['item_name'];
		$code_name = $_POST['code_name'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$description = $_POST['description'];
		$visible = $_POST['visible'];

		//DOO VALIDATOR
		Doo::loadCore('helper/DooValidator');
		$rules = array(
			'category' => array('required', 'Please select a product category'),
			'item_name' => array('required', 'Please enter a product name'),
			'price' => array(
				array('required', 'Price is required')
//				array('float', 'Example : 10.00')
			)
		);
		$v = new DooValidator();
		$v->checkMode = DooValidator::CHECK_SKIP;
		$err = $v->validate($_POST, $rules);
		if ($err) {
			$this->toJSON(array('failed', $err), true);
			return 200;
		}

		$stack = array(
			'catergory_id' => $category,
			'product_name' => $item_name,
			'product_code' => $code_name,
			'price' => $price,
			'quantity' => $quantity,
			'description' => $description,
			'visible' => $visible
		);

		Doo::loadModel('product');

		//CREATE
		if (empty($id)) {
			$p = new Product($stack);
			$new_id = $p->insert();

			if ($new_id) {
				$this->toJSON(array('created', $new_id), true);
				return 201;
			}
		}

		//UPDATE
		else if (intval($id) > 0) {
			$update = array('product_id' => $id);
			$stack = array_merge($stack, $update);
			$p = new Product($stack);
			$p->update();

			unset($stack);
			$this->toJSON(array('Updated'), true);
			return 200;
		}

		//DEFAULT error
		$this->toJSON(array('failed'), true);
		return 200;
	}

	public function fetchStoreItem() {

		$sql = "SELECT product.product_id, product.category_id, product.product_name, product.description, product.image, product.thumbnail ";
		$sql .= "FROM product";
		$store = $this->db()->fetchAll($sql);
		$this->toJSON($store, true);
	}

	public function adminCountPage() {
		$per_page = $this->admin_per_page;
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(product_id)/' . $per_page . ' as num_of_item FROM product ';
		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}

	public function adminGetPagination() {
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->admin_per_page;
		$current_page = $this->params['page'];
//		$offset = ($current_page > 1) ? ($current_page - 1) * $per_page : 1;
		$offset = ($current_page - 1) * $per_page;

		$sql = 'SELECT product.product_id as k0, product.product_name as k1';
		$sql .= ' FROM product ORDER BY product.product_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}

	public function getOneProduct() {
		if(isset($_SESSION['message'])){
			unset($_SESSION['message']);
		}
		
		if (!$this->params['id'] || intval($this->params['id']) < 1) {
			return 404;
		} else {
			Doo::loadModel('Product');
			$a = new Product();
			$a->product_id = $this->params['id'];
			$rs = $a->getOne();

			if ($rs) {
				$this->toJSON($rs, true, true);
				return 200;
			} else {
				$this->toJSON('Store item not found', true);
				return 400;
			}
		}
	}

	public function deleteProduct() {
		$a = $this->db()->find('Product', array(
			'limit' => 1,
			'where' => 'product.product_id = ?',
			'param' => array(intval($this->params['id']))
				));

		$image = 'global/store/' . $a->image;
		$thumbnail = 'global/store/' . $a->thumbnail;


		if ($a->count()) {
			if (file_exists($image)) {
				unlink($image);
			}

			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}

			$a->beginTransaction();
			try {

				$a->delete();
				$a->commit();
				$this->toJSON(array('deleted'), true);
			} catch (PDOException $e) {
				$a->rollBack();
				return 500;
			}
		} else {
			return 404;
		}
	}
	
	public function adminGetCategoryPagination(){
		if (intval($this->params['page']) < 1) {
			return 404;
		}
		$per_page = $this->admin_per_page;
		$current_page = $this->params['page'];
		$offset = ($current_page - 1) * $per_page;

		$sql = 'SELECT product_category.category_id as k0, product_category.category_name as k1';
		$sql .= ' FROM product_category ORDER BY product_category.category_id DESC LIMIT ' . $offset . ', ' . $per_page;

		$rs = $this->db()->fetchAll($sql);
		$this->toJSON($rs, true);
	}
	
	public function adminCountCategoryPage(){
		$per_page = $this->admin_per_page;
		Doo::loadController('PaginationController');
		$pagination = new PaginationController();

		$sql = 'SELECT COUNT(category_id)/' . $per_page . ' as num_of_item FROM product_category ';
		$rs = $this->db()->fetchAll($sql);
		$page_number = doubleval($rs[0]['num_of_item']);

		$page = $pagination->calculateExactPage($page_number);
		$this->toJSON($page, true);
	}
	
	public function getOneCategory(){
		
		if (!$this->params['id'] || intval($this->params['id']) < 1) {
			return 404;
		} else {
			Doo::loadModel('ProductCategory');
			$a = new ProductCategory();
			$a->category_id = $this->params['id'];
			$rs = $a->getOne();

			if ($rs) {
				$this->toJSON($rs, true, true);
				return 200;
			} else {
				$this->toJSON('Category not found', true);
				return 400;
			}
		}
	}
	
	public function deleteCategory(){
		$a = $this->db()->find('ProductCategory', array(
			'limit' => 1,
			'where' => 'product_category.category_id = ?',
			'param' => array(intval($this->params['id']))
				));

		if ($a->count()) {

			$a->beginTransaction();
			try {

				$a->delete();
				$a->commit();
				$this->toJSON(array('deleted'), true);
			} catch (PDOException $e) {
				$a->rollBack();
				return 500;
			}
		} else {
			return 404;
		}
	}

}

?>
