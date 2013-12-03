<?php
include ("../autoload.php");
if (! $_POST) {
	header ( '' );
}

$modelname = "Admin_Model_" . $_REQUEST ['jcms_model'];
$model = Factory::getInstance ( $modelname );
if (empty ( $_REQUEST ['jcms_function'] )) {
	$model->handle ();
}else{
	$function=$_REQUEST ['jcms_function'];
	$model->$function();
}
$back = $model->back ();

switch ($back) {
	case 1 :
		echo 1;
		break;
	case 2 :
		echo 2;
		break;
	default :
		echo $back;
		break;
}


