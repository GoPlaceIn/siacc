<?php
//--utf8_encode --
session_start();
include_once 'cls/conteudo.class.php';
include_once 'cls/usuario.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$codcaso = ($_SESSION['caso'] > 0 ? $_SESSION['caso'] : $_SESSION['casores']);
	
	if ($codcaso > 0)
	{
		$codconteudo = $_GET['k'];
		
		$cont = new Conteudo();
		if ($cont->Carrega($codcaso, $codconteudo))
		{
			echo($cont->getTexto());
		}
		else
		{
			echo($cont->getErro());
		}
	}
	else
	{
		echo("@lng[Caso de estudo não encontrado]");
	}
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}
?>