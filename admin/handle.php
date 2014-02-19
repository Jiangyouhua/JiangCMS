<?php
include ("../library/Include.php");
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
$model->back ();