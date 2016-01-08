<?php
//--utf8_encode --
session_start();
include_once 'cls/resolucao.class.php';

function Main()
{
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		//$arrNodo = split('_', $_POST['k']);
		
		$res = new Resolucao();
		$res->setCodcaso($_SESSION['casores']);
		$res->setCodresolucao($_SESSION['codresolucao']);
		$salto = $res->BuscaSaltosConteudo($_POST['k']);
		if ($salto !== false)
		{
			echo($salto);
		}
		else
		{
			echo("ERRO: " . $res->getErro());
		}
	}
	else
	{
		echo("@lng[Caso não encontrado]");
	}
}

Main();

?>