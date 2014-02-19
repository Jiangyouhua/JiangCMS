<?php
class Url {
	protected static $root;
	static function out(array $array) {
		$parameter = null;
		if (empty ( $array ['menu'] ) && ! empty ( $_GET ['menu'] )) {
			$array ['menu'] = $_GET ['menu'];
		}
		if (empty ( $array ['item'] ) && ! empty ( $_GET ['item'] )) {
			$array ['item'] = $_GET ['item'];
		}
		foreach ( $array as $key => $value ) {
			$parameter .= "$key=$value";
		}
		return "http://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['SCRIPT_NAME'] . "?" . $parameter;
	}
}