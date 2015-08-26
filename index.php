<?php
include_once 'cls/conexao.class.php';
include_once "cls/pergunta.class.php";
include_once 'cls/components/combobox.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=utf-8');
	
	if (!isset($_COOKIE['siacc_lang']))
		$_COOKIE['siacc_lang'] = '1';
	
	$mensagem = $_GET["m"];
	$tpl = file_get_contents("tpl/index.html");

	$rs = null;
	if (!Comuns::ArrayObj("select Codigo, Nome from sisidiomas /*where publicado = 1*/", $rs))
		echo($rs);
	
	$cmb = new ComboBox("selIdioma", $rs, "Codigo", "Nome");
	$tpl = str_replace("<!--selIdioma-->", $cmb->RenderHTML($_COOKIE['siacc_lang']), $tpl);
	
	if (isset($mensagem) && $mensagem != "")
	{
		$msg = '<div id="errologin">' . base64_decode($mensagem) . '</div>';
		$tpl = str_replace("<!--Mensagem-->", $msg, $tpl);
	}
	else
	{
		$tpl = str_replace("<!--Mensagem-->", "", $tpl);
	}

	if (strpos(strtolower($_SERVER['HTTP_HOST']), "localhost") === false)
		$tpl = str_replace("<!--analytics-->", Comuns::GOOGLE_ANALYTICS, $tpl);
	else
		$tpl = str_replace("<!--analytics-->", "", $tpl);
	
	echo(  Comuns::Idioma($tpl, "login") );
}

Main();
?>