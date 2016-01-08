<?php
//--utf8_encode --
session_start();
require_once 'cls/usuario.class.php';

function main()
{
	if ($_POST["pA"] && $_POST["pN"] && $_POST["pC"])
	{
		$usu = unserialize($_SESSION['usu']);
		if ($usu->AlteraSenha(md5($_POST['pN']), "-999"))
		{
			echo("OK");
		}
		else
		{
			echo($usu->getErro());
		}
	}
	else
	{
		echo("Informe todos os campos");
	}
}

Main();
?>