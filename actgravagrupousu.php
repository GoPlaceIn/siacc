<?php
//--utf8_encode --
session_start();
require_once 'cls/grupo.class.php';
require_once 'inc/comuns.inc.php';

function Main()
{
	$cod = $_POST["c"];
	$des = urldecode($_POST["d"]);

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$g = new Grupo();
		if ($cod != "") { $g->setCodigo($cod); }
		if ($des != "") { $g->setDescricao($des); }
		if ($cod == "")
		{
			if($g->AdicionaGrupoUsuario())
			{
				echo("GRAVADO");
			}
		}
		else
		{
			if($g->AtualizaGrupoUsuario())
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