<?php
session_start();
include_once 'cls/exame.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/components/hashtable.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$ht = new HashTable();
	$e = new Exame();
	$retorno = "";
	
	if ($_POST['context'] == 'N')
	{
		$ht->AddItem("imgs", $e->ListaArquivosExame($_SESSION['caso'], $_SESSION['exame'], "img"));
		$ht->AddItem("docs", $e->ListaArquivosExame($_SESSION['caso'], $_SESSION['exame'], "doc"));
	
		$retorno = $ht->ToXML();
	}
	else
	{
		$c = new Conteudo();
		$retorno = $c->Lista($_SESSION['caso']);
	}
	
	echo( Comuns::Idioma($retorno) );
}

Main();

?>