<?php
//All template redirect
$route['*']['/'] = array('TemplateController', 'homepage');
$route['*']['/home'] = array('TemplateController', 'homepage');
$route['*']['/login'] = array('TemplateController', 'login');
$route['*']['/article'] = array('TemplateController', 'article');
$route['*']['/video'] = array('TemplateController', 'video');
$route['*']['/profile'] = array('TemplateController', 'profile');

//Master
$route['*']['/master'] = array('TemplateController', 'master');
$route['*']['/master/article'] = array('TemplateController', 'master_article');
$route['*']['/master/video'] = array('TemplateController', 'master_video');

//Login
$route['post']['/login/process-login'] = array('LoginController', 'processLogin');
$route['*']['/logout'] = array('LoginController', 'logout');

//Profile
$route['get']['/profile/get'] = array('ProfileController', 'get');

$route['post']['/profile/save'] = array('ProfileController', 'save');
$route['*']['/profile/edit'] = array('ProfileController', 'editPage');
$route['*']['/profile/upload-picture-page'] = array('ProfileController', 'uploadPicturePage');
$route['post']['/profile/upload-picture'] = array('ProfileController', 'uploadPicture');
$route['get']['/profile/fetch-picture'] = array('ProfileController', 'fetchPicture');
$route['get']['/profile/delete-picture/:id'] = array('ProfileController', 'deletePicture');
$route['get']['/profile/set-current-picture/:id'] = array('ProfileController', 'setCurrent');


//iframe picture
$route['*']['/template/picture-form'] = array('ProfileController', 'picForm');


//Article
$route['*']['/article/list-articles'] = array('ArticleController', 'listArticles');
$route['get']['/article/fetch-one-article/:id'] = array('ArticleController', 'fetchOneArticle');
$route['*']['/article/create-pager/:content'] = array('ArticleController', 'createPager');
$route['get']['/article/master/make-pagination/:id/:page'] = array('ArticleController', 'makePagination');
$route['post']['/article/save'] = array('ArticleController', 'saveArticle');



$route['*']['/article/:id'] = array('ArticleController', 'article');
$route['get']['/article/fetch-articles'] = array('ArticleController', 'fetchArticles');
$route['get']['/article/archive'] = array('ArticleController', 'archive');
$route['*']['/article/archive-date-filter/:date'] = array('ArticleController', 'archiveDateFilter');
$route['get']['/article/delete-one-article/:id'] = array('ArticleController', 'deleteOneArticle');

//Video
$route['get']['/video/count-total'] = array('VideoController', 'countTotal');
$route['get']['/video/create-pager/:content'] = array('VideoController', 'createPager');
$route['get']['/video/master/make-pagination/:id/:page'] = array('VideoController', 'makePagination');

$route['*']['/video/view'] = array('VideoController', 'viewPage');
$route['*']['/video/edit'] = array('VideoController', 'editPage');
$route['get']['/video/get-pagination/:page'] = array('VideoController', 'getPagination');

$route['get']['/video/admin-get-pagination/:page'] = array('VideoController', 'adminGetPagination');
$route['post']['/video/save_video'] = array('VideoController', 'saveVideo');
$route['get']['/video/get_video_list'] = array('VideoController', 'getVideoList');
$route['get']['/video/get_one_video/:id'] = array('VideoController', 'getOneVideo');
$route['delete']['/video/delete_video/:id'] = array('VideoController', 'deleteVideo');

$route['get']['/video/fetch-videos/:page'] = array('VideoController', 'fetchVideos');

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