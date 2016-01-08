<?php
//--utf8_encode --
session_start();

include_once 'inc/comuns.inc.php';
include_once 'cls/resolucao.class.php';
include_once 'cls/caso.class.php';

function Main()
{
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		$tpl = file_get_contents("tpl/aluno/opcoescaso.html");
		
		$infos = Caso::ConsultaInfosCaso($_SESSION['casores']);
		
		$tpl = str_replace('<!--titulocaso-->', $infos['nome'], $tpl);
		$tpl = str_replace('<!--codcaso-->', base64_encode($infos['codigo']), $tpl);
		
		echo($tpl);
	}
	else
	{
		$msg = base64_encode("@lng[Caso não informado]");
		header("Location:aluno.php?msg=" . $msg);
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