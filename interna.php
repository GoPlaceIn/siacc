<?php

//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{
	//header('Content-Type: text/html; charset=iso-8859-1');
	/*header('Content-Type: text/html; charset=utf-8');*/
	
	$u = unserialize($_SESSION["usu"]);

	log::RegistraLog("Acessou a tela inicial do sistema");
	
	$mensagem = $_GET["msg"];
	$tpl = file_get_contents("tpl/interna.html");

	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
	$tpl = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl);

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