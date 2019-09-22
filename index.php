<?php
define('SITE', true);
define('PAGE_BR', '<br/>');

require_once('db.php');
require_once('restaurant.php');

$r = new test\Restaurant();


$data = $r->generateSchema();
$schema = json_encode($data);
$print_schema = print_r($data, true);


$htmlFile = file_get_contents('template.html');
$htmlFile = str_ireplace('{schema}', $schema, $htmlFile);
$htmlFile = str_ireplace('{print_schema}', $schema, $htmlFile);
echo $htmlFile;