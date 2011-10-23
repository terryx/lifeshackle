<?php
//home page routing
$route['*']['/'] = array('HomeController', 'index');
$route['*']['/home'] = array('HomeController', 'index');
$route['*']['/index'] = array('HomeController', 'index');
$route['*']['/master'] = array('MasterController', 'index');

//home page public module view
$route['*']['/article'] = array('HomeController', 'article');
$route['*']['/profile'] = array('HomeController', 'profile');
$route['*']['/video'] = array('HomeController', 'video');

$route['*']['/picture'] = array('HomeController', 'picture');

$route['*']['/sign-in'] = array('LoginController', 'index');
$route['*']['/quote'] = array('QuoteController', 'index');

$route['post']['/login'] = array('LoginController', 'login');
$route['*']['/logout'] = array('LoginController', 'logout');
$route['*']['/finance'] = array('FinanceController', 'index');

//Profile
$route['*']['/master/profile'] = array('ProfileController', 'viewPage');
$route['post']['/profile/save'] = array('ProfileController', 'save');
$route['get']['/profile/get'] = array('ProfileController', 'get');
$route['post']['/profile/save-pic'] = array('ProfileController', 'savePic');
//iframe picture
$route['*']['/template/picture-form'] = array('ProfileController', 'picForm');

//Article
$route['*']['/article/view'] = array('ArticleController', 'viewPage');
$route['*']['/article/edit'] = array('ArticleController', 'editPage');
$route['post']['/article/save-article'] = array('ArticleController', 'saveArticle');
$route['get']['/article/get_article_list'] = array('ArticleController', 'getArticleList');
$route['get']['/article/get_one_article/:id'] = array('ArticleController', 'getOneArticle');
$route['delete']['/article/delete_article/:id'] = array('ArticleController', 'deleteArticle');
$route['get']['/article/count-page'] = array('ArticleController', 'countPage');
$route['get']['/article/get-pagination/:page'] = array('ArticleController', 'getPagination');
$route['get']['/article/archive'] = array('ArticleController', 'archive');
$route['get']['/article/filter-by-archive/:date'] = array('ArticleController', 'filterByArchive');
$route['get']['/article/admin-count-page'] = array('ArticleController', 'adminCountPage');
$route['get']['/article/admin-get-pagination/:page'] = array('ArticleController', 'adminGetPagination');

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

//Video
$route['*']['/video/view'] = array('VideoController', 'viewPage');
$route['*']['/video/edit'] = array('VideoController', 'editPage');
$route['*']['/manage-video'] = array('VideoController', 'manageVideoPage');
$route['post']['/video/save_video'] = array('VideoController', 'saveVideo');
$route['get']['/video/get_video_list'] = array('VideoController', 'getVideoList');
$route['get']['/video/get_one_video/:id'] = array('VideoController', 'getOneVideo');
$route['delete']['/video/delete_video/:id'] = array('VideoController', 'deleteVideo');
$route['get']['/video/count-page'] = array('VideoController', 'countPage');
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

//$admin = array('admin'=>'1234');
//
////view the logs and profiles XML, filename = db.profile, log, trace.log, profile
//$route['*']['/debug/:filename'] = array('MainController', 'debug', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//
////show all urls in app
//$route['*']['/allurl'] = array('MainController', 'allurl', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//
////generate routes file. This replace the current routes.conf.php. Use with the sitemap tool.
//$route['post']['/gen_sitemap'] = array('MainController', 'gen_sitemap', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//
////generate routes & controllers. Use with the sitemap tool.
//$route['post']['/gen_sitemap_controller'] = array('MainController', 'gen_sitemap_controller', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//
////generate Controllers automatically
//$route['*']['/gen_site'] = array('MainController', 'gen_site', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//
////generate Models automatically
//$route['*']['/gen_model'] = array('MainController', 'gen_model', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//

?>