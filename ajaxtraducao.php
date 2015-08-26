<?php
session_start();

include_once "cls/conexao.class.php";
include_once 'cls/lingua.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	$idLingua = $_POST['langid'];
	$idExpressao = $_POST['expid'];
	$traducao = $_POST['trad'];
	
	$l = new Lingua();
	$l->setCodigoIdioma($idLingua);
	$l->setCodExpressao($idExpressao);
	$l->setExpressao($traducao);
	
	if ($l->SalvaTraducao())
	{
		echo($l->PercentualTraduzido());
	}
	else
	{
		echo("ERRO! " . $l->getErro());
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