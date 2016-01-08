<?php
//--utf8_encode --
session_start();
include_once('cls/conteudo.class.php');
include_once('inc/comuns.inc.php');

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$cont = new Conteudo();
	$conteudos = $cont->ListaRecordSet($_SESSION['caso']);
	
	if ($conteudos)
	{
		$ret .= '<option value="">@lng[Selecione]</option>';
		foreach ($conteudos as $html)
		{
			$ret .= '<option value="vwcont.php?k=' . $html->Chave . '">' . $html->Descricao . '</option>';
		}
	}
	else
	{
		$ret = '<option value="">@lng[Nenhum item encontrado]</option>';
	}
	
	echo(Comuns::Idioma($ret));
}

Main();
?>