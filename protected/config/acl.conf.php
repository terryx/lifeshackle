<?php

//set access control level for different users
$acl['super_admin']['allow'] = '*';

$acl['inactive']['failRoute'] = array('ErrorController' => array('banUser'));

$acl['visitor']['allow'] = array(
    'HomeController' => '*',
    'PictureController' => array('getPictureGallery'),
    'ArticleController' => array('countPage', 'getPagination', 'arhive', 'filterbyArchive'),
    'VideoController'   => array('countPage', 'getPagination')
);
?>