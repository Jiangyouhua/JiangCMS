<?php
include("../autoload.php");
if (! $_POST) {
	header ( '' );
}

$class = "Admin_Model_" . $_REQUEST ['jcms_modle'];
$model = Factory::getInstance ( $class );
$model->handle();
$back = $model->back();

switch ($back) {
	case 1 :
		echo 1;
		break;
	case 2 :
		echo 2;
		break;
	default :
		echo 0;
		break;
}


