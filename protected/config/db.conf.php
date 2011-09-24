<?php
/**
 * Example Database connection settings and DB relationship mapping
 * $dbmap[Table A]['has_one'][Table B] = array('foreign_key'=> Table B's column that links to Table A );
 * $dbmap[Table B]['belongs_to'][Table A] = array('foreign_key'=> Table A's column where Table B links to );


//Food relationship
$dbmap['Food']['belongs_to']['FoodType'] = array('foreign_key'=>'id');
$dbmap['Food']['has_many']['Article'] = array('foreign_key'=>'food_id');
$dbmap['Food']['has_one']['Recipe'] = array('foreign_key'=>'food_id');
$dbmap['Food']['has_many']['Ingredient'] = array('foreign_key'=>'food_id', 'through'=>'food_has_ingredient');

//Food Type
$dbmap['FoodType']['has_many']['Food'] = array('foreign_key'=>'food_type_id');

//Article
$dbmap['Article']['belongs_to']['Food'] = array('foreign_key'=>'id');

//Recipe
$dbmap['Recipe']['belongs_to']['Food'] = array('foreign_key'=>'id');

//Ingredient
$dbmap['Ingredient']['has_many']['Food'] = array('foreign_key'=>'ingredient_id', 'through'=>'food_has_ingredient');

*/

//$dbconfig[ Environment or connection name] = array(Host, Database, User, Password, DB Driver, Make Persistent Connection?);
/**
 * Database settings are case sensitive.
 * To set collation and charset of the db connection, use the key 'collate' and 'charset'
 * array('localhost', 'database', 'root', '1234', 'mysql', true, 'collate'=>'utf8_unicode_ci', 'charset'=>'utf8');
 */

/* $dbconfig['dev'] = array('localhost', 'database', 'root', '1234', 'mysql', true);
 * $dbconfig['prod'] = array('localhost', 'database', 'root', '1234', 'mysql', true);
 */


//Article
$dbmap['Article']['belongs_to']['Tag'] = array('foreign_key' => 'tag_id');
$dbmap['Tag']['has_one']['Article'] = array('foreign_key' => 'tag_id');
$dbmap['Article']['belongs_to']['Users'] = array('foreign_key' => 'id');
$dbmap['Users']['has_many']['Article'] = array('foreign_key' => 'user_id');
$dbmap['Article']['belongs_to']['LatestUpdate'] = array('foreign_key' => 'latest_id');
$dbmap['LatestUpdate']['has_one']['Article'] = array('foreign_key' => 'latest_id');

//$dbconfig['dev'] = array('localhost', 'lifeshac_terryxbase', 'lifeshac', 'terryX1314???', 'mysql', true, 'collate'=>'utf8_general_ci', 'charset'=>'utf8');
$dbconfig['dev'] = array('localhost', 'terryxbase', 'root', 'root', 'mysql', true);
?>
