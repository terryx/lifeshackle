<?php

$route['*']['/'] = array('HomeController', 'index');
$route['*']['/home'] = array('HomeController', 'home');
$route['*']['/article'] = array('HomeController', 'article');
$route['*']['/picture'] = array('HomeController', 'picture');
$route['*']['/video'] = array('HomeController', 'video');
$route['*']['/about'] = array('AboutController', 'index');
$route['*']['/signin'] = array('HomeController', 'signin');

$route['post']['/login'] = array('LoginController', 'login');
$route['*']['/logout'] = array('LoginController', 'logout');
$route['*']['/super_admin'] = array('SuperAdminController', 'index');
$route['*']['/finance'] = array('FinanceController', 'index');

//Article
$route['*']['/manage-article'] = array('ArticleController', 'manageArticlePage');
$route['post']['/article/save_article'] = array('ArticleController', 'saveArticle');
$route['get']['/article/get_article_list'] = array('ArticleController', 'getArticleList');
$route['get']['/article/get_one_article/:id'] = array('ArticleController', 'getOneArticle');
$route['delete']['/article/delete_article/:id'] = array('ArticleController', 'deleteArticle');
$route['get']['/article/count-page'] = array('ArticleController', 'countPage');
$route['get']['/article/get-pagination/:page'] = array('ArticleController', 'getPagination');
$route['get']['/article/archive'] = array('ArticleController', 'archive');
$route['get']['/article/filter-by-archive/:date'] = array('ArticleController', 'filterByArchive');
//Expense
$route['*']['/manage-expense'] = array('ExpenseController', 'manageExpensePage');
$route['post']['/expense/save-expense'] = array('ExpenseController', 'saveExpense');

//Finance
$route['*']['/manage-finance'] = array('FinanceController', 'manageFinancePage');

//Super Administrator rights
$route['*']['/manage-user'] = array('SuperAdminController', 'manageUserPage');
$route['post']['/super_admin/save_user'] = array('SuperAdminController', 'saveUser');
$route['get']['/super_admin/get_user_list'] = array('SuperAdminController', 'getUserList');
$route['get']['/super_admin/get_one_user/:id'] = array('SuperAdminController', 'getOneUser');

//Picture Gallery
$route['*']['/manage-picture'] = array('PictureController', 'managePicturePage');
$route['post']['/picture/save_picture'] = array('PictureController', 'savePicture');
$route['get']['/picture/get_picture_list'] = array('PictureController', 'getPictureList');
$route['get']['/picture/get_one_picture/:id'] = array('PictureController', 'getOnePicture');
$route['get']['/picture/get_picture_gallery'] = array('PictureController', 'getPictureGallery');
$route['delete']['/picture/delete_picture/:id'] = array('PictureController', 'deletePicture');

//Comic
$route['*']['/manage_comic'] = array('ComicController', 'manageComicPage');

//Video
$route['*']['/manage-video'] = array('VideoController', 'manageVideoPage');
$route['post']['/video/save_video'] = array('VideoController', 'saveVideo');
$route['get']['/video/get_video_list'] = array('VideoController', 'getVideoList');
$route['get']['/video/get_one_video/:id'] = array('VideoController', 'getOneVideo');
$route['delete']['/video/delete_video/:id'] = array('VideoController', 'deleteVideo');
$route['get']['/video/count-page'] = array('VideoController', 'countPage');
$route['get']['/video/get-pagination/:page'] = array('VideoController', 'getPagination');

//Validation
$route['*']['/validate/check_username'] = array('ValidateController', 'checkUsername');
$route['*']['/validate/check_email'] = array('ValidateController', 'checkEmail');

//Error page
$route['*']['/error'] = array('ErrorController', 'index');
$route['*']['/deny_access'] = array('ErrorController', 'banUser');

//Test page
$route['*']['/test-page'] = array('TestController', 'testPage');


//---------- Delete if not needed ------------


?>