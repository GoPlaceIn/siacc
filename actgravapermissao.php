<?php
//--utf8_encode --
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/permissao.class.php';

function Main()
{
	$cod = $_POST["c"];
	$des = urldecode($_POST["d"]);

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$p = new Permissao();
		if ($cod != "") { $p->setCodigo($cod); }
		if ($des != "") { $p->setDescricao($des); }
		if ($cod == "")
		{
			if($p->AdicionaPermissao())
			{
				echo("GRAVADO");
			}
		}
		else
		{
			if($p->AtualizaPermissao())
			{
				echo("GRAVADO");
			}
		}
	}
	catch (Exception $ex)
	{
		echo($ex->getMessage());
	}
}

Main();
?>