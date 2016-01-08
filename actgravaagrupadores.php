<?php

//--utf8_encode --
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/grupopergunta.class.php';

function Main()
{
	$cod = $_POST["txtCodigo"];
	$des = urldecode($_POST["txtTexto"]);
	$exp = urldecode($_POST["txtExplicacao"]);

	header('Content-Type: text/html; charset=iso-8859-1');

	$gp = new GrupoPergunta();
	if ($cod != "") { $gp->setCodgrupo($cod); }
	if ($des != "") { $gp->setTexto($des); }
	if ($exp != "") { $gp->setExplicacao($exp); }
	if ($cod == "")
	{
		if($gp->Insere())
		{
			echo("OK");
		}
		else
		{
			echo($gp->getErro());
		}
	}
	else
	{
		if($gp->Atualiza())
		{
			echo("OK");
		}
		else
		{
			echo($gp->getErro());
		}
	}
}

Main();
?>