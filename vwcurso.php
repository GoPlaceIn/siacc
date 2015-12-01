<?php
session_start();

include_once 'cls/caso.class.php';
include_once 'cls/anamnese.class.php';
include_once 'cls/area.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/components/botao.class.php';
include_once 'cls/log.class.php';
include_once 'cls/curso.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	//header('Content-Type: text/html; charset=iso-8859-1');

	$acao = $_GET['act'];
	$acaoload = false;
	$tpl = file_get_contents("tpl/cad-curso.html");
	
	$u = unserialize($_SESSION["usu"]);
	$mensagem = $_GET["m"];

	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
	
	echo( Comuns::Idioma($tpl) );
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