<?php
if (! isset ( $_SESSION )) {
	session_start ();
}
$_SESSION ['role'] = array (
		0 
);
/* 硬盘地址 */
defined ( "DIR" ) || define ( "DIR", str_ireplace ( 'library', '', __DIR__ ) );

/* 请求基址 */
$host = 'http://';
if ($_SERVER ['HTTPS'] == 'on') {
	$host = 'https://';
}
$host .= isset ( $_SERVER ['HTTP_X_FORWARDED_HOST'] ) ? $_SERVER ['HTTP_X_FORWARDED_HOST'] : (isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : '');
$root = $host;
$host .= str_ireplace ( $_SERVER ['DOCUMENT_ROOT'], '', DIR );
$host = str_ireplace ( '\\', '/', $host );
defined ( "ROOT" ) || define ( "ROOT", $host );
unset ( $host );

/* 请求页面 */
$array = explode ( '/', $_SERVER ['REQUEST_URI'] );
$page = array_pop ( $array );
if (! $page) {
	$page = 'index';
} else {
	$page = substr ( $page, 0, strripos ( $page, '.' ) );
}
$file = array_pop ( $array );
if (! stripos ( DIR, $file )) {
	$page = $file . '/' . $page;
}
defined ( "PAGE" ) || define ( "PAGE", $page );

unset ( $page );
unset ( $file );

/* 当前请求 */
if (empty ( $_SESSION ['url'] )) {
	$_SESSION ['pre'] = ROOT;
} else {
	$_SESSION ['pre'] = $_SESSION ['url'];
}
$_SESSION ['url'] = $root . $_SERVER ["REQUEST_URI"];
unset ( $root );

/* 自动加载 */
include (DIR . "/library/Autoload.php");

/* LANG */
$lang = Admin_Config_Admin::$lang;
$re = Admin_Db_Layout::getByName ( PAGE );
if ($re) {
	$lang = $re ['lang'];
}
defined ( 'LANG' ) || define ( 'LANG', $lang );

unset ($lang);

if (! Role::layout ()) {
	exit ();
}
