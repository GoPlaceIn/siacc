<?php

//--utf8_encode --
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/usuario.class.php';

function Main()
{
	$u = unserialize($_SESSION["usu"]);
	$u->CarregaPermissoes();
	$_SESSION["usu"] = serialize($u);
	header("Location:interna.php");
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