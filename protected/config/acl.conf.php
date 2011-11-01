<?php

//set access control level for different users
$acl['master']['allow'] = '*';

$acl['inactive']['failRoute'] = array('ErrorController' => array('banUser'));

$acl['visitor']['allow'] = array(
	'ChatController' => array('publicPage', 'saveUser', 'saveChat', 'fetchChatList', 'poolChat'),
	'HomeController' => '*',
	'PaginationController' => '*',
	'PictureController' => array('getPictureGallery'),
	'ProfileController' => array('profile', 'get'),
	'ArticleController' => array('countPage', 'getPagination', 'arhive', 'filterbyArchive', 'fetchArticleList'),
	'VideoController' => array('countPage', 'getPagination')
);

$acl['visitor']['deny'] = array(
	'ChatController' => array('editPage', 'deleteChatPost')
);
?>