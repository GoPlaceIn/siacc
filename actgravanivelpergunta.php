<?php
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/nivelpergunta.class.php';

function Main()
{
	$cod = $_POST["c"];
	$des = urldecode($_POST["d"]);

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$n = new NivelPergunta();
		if ($cod != "") { $n->setCodigo($cod); }
		if ($des != "") { $n->setDescricao($des); }
		if ($cod == "")
		{
			if($n->AdicionaNivelPergunta())
			{
				echo("GRAVADO");
			}
		}
		else
		{
			if($n->AtualizaNivelPergunta())
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