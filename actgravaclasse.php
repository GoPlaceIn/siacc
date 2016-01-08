<?php
//--utf8_encode --
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/classes.class.php';

function Main()
{
	$cod = $_POST["c"];
	$des = urldecode($_POST["d"]);
	$com = urldecode($_POST["com"]);

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$c = new Classes();
		if ($cod != "") { $c->setCodigo($cod); }
		if ($des != "") { $c->setDescricao($des); }
		if ($com != "") { $c->setComplemento($com); }
		if ($cod == "")
		{
			if($c->AdicionarClassePergunta())
			{
				echo("GRAVADO");
			}
		}
		else
		{
			if($c->AtualizaClassePerguntas())
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