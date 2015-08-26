<?php
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/area.class.php';

function Main()
{
	$cod = $_POST["c"];
	$des = urldecode($_POST["d"]);
	$pai = $_POST["p"];

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$n = new AreaConhecimento();
		if ($cod != "") { $n->setCodigo($cod); }
		if ($des != "") { $n->setDescricao($des); }
		if ($pai != "") { $n->setAreaPai($pai); }

		if ($n->VerificaCodigo() == false)
		{
			if($n->AdicionaAreaConhecimento())
			{
				echo("GRAVADO");
			}
			else
			{
				echo($n->msg_erro);
			}
		}
		else
		{
			if($n->AtualizaAreaConhecimento())
			{
				echo("GRAVADO");
			}
			else
			{
				echo($n->msg_erro);
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