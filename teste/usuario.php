<?php
include_once 'c/controlerUsuario.php';

function Main()
{
	$obj = new controlerUsuario();

	if (!$_REQUEST['a'])
	{
		$act = "l";
	}
	else
	{
		$act = $_REQUEST['a'];
	}

	$cod = (isset($_REQUEST['c']) ? $_REQUEST['c'] : null);

	$obj->Faz($act, $cod);
}


Main();
?>