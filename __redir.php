<?php
//--utf8_encode --
session_start();

include_once 'inc/comuns.inc.php';

function Main()
{
	$paginas = array('7ki04F2_xVm0t6lpY4' => 'vwcaso.php');
	$secoes = array('7ki04F2_xVm0t6lpY4' => 'exames');
	
	$destino = $_GET['k'];
	
	if ((array_key_exists($destino, $paginas)) && (array_key_exists($destino, $secoes)))
	{
		$redirect = $paginas[$destino] . "?cod=" . base64_encode($_SESSION['caso']);
		$_SESSION['load_content_from_redir'] = $secoes[$destino];
		
		Header("Location:" . $redirect);
	}
	else
	{
		echo("Informações incorretas");
	}
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("Você deve estar logado para acessar esta tela");
	header("Location:index.php?m=" . $msg);
}

Main();

?>