<?php

//set access control level for different users
$acl['master']['allow'] = '*';

$acl['inactive']['failRoute'] = array('ErrorController' => array('banUser'));

$acl['visitor']['allow'] = array(
	'HomeController' => '*',
	'PaginationController' => '*',
	'PictureController' => array('getPictureGallery'),
	'ProfileController' => array('profile', 'get'),
	'ArticleController' => array('countPage', 'getPagination', 'arhive', 'filterbyArchive'),
	'VideoController' => array('countPage', 'getPagination')
);
?>