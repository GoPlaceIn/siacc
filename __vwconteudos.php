<?php

//--utf8_encode --
session_start();
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/montagem.class.php';
include_once 'cls/components/botao.class.php';
include_once 'cls/menus.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	$u = unserialize($_SESSION['usu']);

	$tpl = file_get_contents("tpl/casos-conteudos.html");
	$mnu = Menus::MenusConteudos();
	$caminho = Caminhos::MontaCaminhoConteudos();
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("Voc?deve estar logado para acessar esta tela");
	header("Location:index.php?m=" . $msg);
}

?>