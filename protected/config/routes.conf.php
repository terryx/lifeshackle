<?php
//home page routing
$route['*']['/'] = array('HomeController', 'index');
$route['*']['/home'] = array('HomeController', 'index');
$route['*']['/index'] = array('HomeController', 'index');
$route['*']['/master'] = array('HomeController', 'index');

//home page public module view
$route['*']['/article'] = array('HomeController', 'article');
$route['*']['/profile'] = array('HomeController', 'profile');
$route['*']['/store'] = array('HomeController', 'store');
$route['*']['/video'] = array('HomeController', 'video');

$route['*']['/picture'] = array('HomeController', 'picture');

//Login
$route['*']['/login'] = array('LoginController', 'index');
$route['post']['/login/process-login'] = array('LoginController', 'processLogin');
$route['*']['/logout'] = array('LoginController', 'logout');

//Profile
$route['post']['/profile/save'] = array('ProfileController', 'save');
$route['*']['/profile/edit'] = array('ProfileController', 'editPage');
$route['*']['/profile/upload-picture-page'] = array('ProfileController', 'uploadPicturePage');
$route['post']['/profile/upload-picture'] = array('ProfileController', 'uploadPicture');
$route['get']['/profile/fetch-picture'] = array('ProfileController', 'fetchPicture');
$route['get']['/profile/delete-picture/:id'] = array('ProfileController', 'deletePicture');
$route['get']['/profile/set-current-picture/:id'] = array('ProfileController', 'setCurrent');

//Contact
$route['*']['/contact'] = array('HomeController', 'contact');

//iframe picture
$route['*']['/template/picture-form'] = array('ProfileController', 'picForm');


//Article
$route['*']['/article/edit'] = array('ArticleController', 'editPage');
$route['get']['/article/fetch-article/:number'] = array('ArticleController', 'fetchArticle');
$route['get']['/article/archive'] = array('ArticleController', 'archive');
$route['*']['/article/archive-date-filter/:date'] = array('ArticleController', 'archiveDateFilter');

$route['post']['/article/save-article'] = array('ArticleController', 'saveArticle');
$route['get']['/article/get_article_list'] = array('ArticleController', 'getArticleList');
$route['get']['/article/get_one_article/:id'] = array('ArticleController', 'getOneArticle');
$route['delete']['/article/delete_article/:id'] = array('ArticleController', 'deleteArticle');
$route['get']['/article/set-pagination/:set'] = array('ArticleController', 'setPagination');
$route['get']['/article/get-pagination/:page'] = array('ArticleController', 'getPagination');
$route['get']['/article/filter-by-archive/:date'] = array('ArticleController', 'filterByArchive');
$route['get']['/article/admin-set-pagination/:set'] = array('ArticleController', 'adminSetPagination');
$route['get']['/article/admin-get-pagination/:page'] = array('ArticleController', 'adminGetPagination');

//Chat
$route['*']['/chat/edit'] = array('ChatController', 'editPage');
$route['post']['/chat/save-user'] = array('ChatController', 'saveUser');
$route['post']['/chat/save-chat'] = array('ChatController', 'saveChat');
$route['get']['/chat/fetch-chat-list'] = array('ChatController', 'fetchChatList');
$route['get']['/chat/pool-chat/:id'] = array('ChatController', 'poolChat');
$route['get']['/chat/delete-chat-post'] = array('ChatController', 'deleteChatPost');

//Master rights
$route['*']['/manage-user'] = array('MasterController', 'manageUserPage');
$route['post']['/master/save_user'] = array('MasterController', 'saveUser');
$route['get']['/master/get_user_list'] = array('MasterController', 'getUserList');
$route['get']['/master/get_one_user/:id'] = array('MasterController', 'getOneUser');

//Picture Gallery
$route['*']['/manage-picture'] = array('PictureController', 'managePicturePage');
$route['post']['/picture/save_picture'] = array('PictureController', 'savePicture');
$route['get']['/picture/get_picture_list'] = array('PictureController', 'getPictureList');
$route['get']['/picture/get_one_picture/:id'] = array('PictureController', 'getOnePicture');
$route['get']['/picture/get_picture_gallery'] = array('PictureController', 'getPictureGallery');
$route['delete']['/picture/delete_picture/:id'] = array('PictureController', 'deletePicture');

//StatusUpdate
$route['*']['/status-update/edit'] = array('StatusUpdateController', 'editPage');
$route['*']['/status-update/get-all'] = array('StatusUpdateController', 'getAll');
$route['*']['/status-update/save'] = array('StatusUpdateController', 'save');
$route['get']['/status-update/set-pagination/:set'] = array('StatusUpdateController', 'setPagination');
$route['get']['/status-update/get-pagination/:page'] = array('StatusUpdateController', 'getPagination');
$route['get']['/status-update/delete/:id'] = array('StatusUpdateController', 'deleteOne');
//$route['get']['/status-update/check-status'] = array('StatusUpdateController', 'checkStatus');

//Store
$route['*']['/store/edit'] = array('StoreController', 'editPage');
$route['*']['/template/store-picture-form/:product_id'] = array('StoreController', 'storePictureForm');
$route['*']['/store/edit-category'] = array('StoreController', 'editCategoryPage');
$route['post']['/store/save-picture'] = array('StoreController', 'savePicture');
$route['post']['/store/save-product'] = array('StoreController', 'saveProduct');
$route['post']['/store/save-category'] = array('StoreController', 'saveCategory');
$route['get']['/store/get-category'] = array('StoreController', 'getCategory');
$route['get']['/store/fetch-store-item'] = array('StoreController', 'fetchStoreItem');
$route['get']['/store/admin-count-page'] = array('StoreController', 'adminCountPage');
$route['get']['/store/admin-get-pagination/:page'] = array('StoreController', 'adminGetPagination');
$route['get']['/store/get-one-product/:id'] = array('StoreController', 'getOneProduct');
$route['delete']['/store/delete-product/:id'] = array('StoreController', 'deleteProduct');
$route['get']['/store/admin-get-category-pagination/:page'] = array('StoreController', 'adminGetCategoryPagination');
$route['get']['/store/admin-count-category-page'] = array('StoreController', 'adminCountCategoryPage');
$route['get']['/store/get-one-category/:id'] = array('StoreController', 'getOneCategory');
$route['delete']['/store/delete-category/:id'] = array('StoreController', 'deleteCategory');

//Video
$route['*']['/video/view'] = array('VideoController', 'viewPage');
$route['*']['/video/edit'] = array('VideoController', 'editPage');
$route['post']['/video/save_video'] = array('VideoController', 'saveVideo');
$route['get']['/video/get_video_list'] = array('VideoController', 'getVideoList');
$route['get']['/video/get_one_video/:id'] = array('VideoController', 'getOneVideo');
$route['delete']['/video/delete_video/:id'] = array('VideoController', 'deleteVideo');
$route['get']['/video/total-page'] = array('VideoController', 'totalPage');
$route['get']['/video/get-pagination/:page'] = array('VideoController', 'getPagination');
$route['get']['/video/admin-count-page'] = array('VideoController', 'adminCountPage');
$route['get']['/video/admin-get-pagination/:page'] = array('VideoController', 'adminGetPagination');

//Validation
$route['*']['/validate/check_username'] = array('ValidateController', 'checkUsername');
$route['*']['/validate/check_email'] = array('ValidateController', 'checkEmail');

//Error page
$route['*']['/error'] = array('ErrorController', 'index');
$route['*']['/deny_access'] = array('ErrorController', 'banUser');

//Test page
$route['*']['/test-page'] = array('TestController', 'testPage');


//---------- Delete if not needed ------------
/*
$admin = array('admin'=>'1234');

//view the logs and profiles XML, filename = db.profile, log, trace.log, profile
$route['*']['/debug/:filename'] = array('MainController', 'debug', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//show all urls in app
$route['*']['/allurl'] = array('MainController', 'allurl', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate routes file. This replace the current routes.conf.php. Use with the sitemap tool.
$route['post']['/gen_sitemap'] = array('MainController', 'gen_sitemap', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

////generate routes & controllers. Use with the sitemap tool.
$route['post']['/gen_sitemap_controller'] = array('MainController', 'gen_sitemap_controller', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate Controllers automatically
$route['*']['/gen_site'] = array('MainController', 'gen_site', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate Models automatically
$route['*']['/gen_model'] = array('MainController', 'gen_model', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

*/
?>