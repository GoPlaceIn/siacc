<?php
session_start();
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';
include_once 'cls/components/botao.class.php';

function Main()
{
	$tpl = file_get_contents("tpl/frm-acessos-detalhes.html");
	$usu = unserialize($_SESSION['usu']);
	
	$DtIni = $_POST['txtDtIni'];
	$DtFin = $_POST['txtDtFin'];
	$Usu = $_POST['txtUsuario'];
	$IdUsu = $_POST['idusuario'];
	$Pagina = $_POST['hidPagina'];
	$idacesso = $_POST['hidAcesso'];
	
	$detalhes = Log::DetalhaLog($idacesso);
	
	$tpl = str_replace("<!--txtDtIni-->", $DtIni, $tpl);
	$tpl = str_replace("<!--txtDtFin-->", $DtFin, $tpl);
	$tpl = str_replace("<!--txtUsuario-->", $Usu, $tpl);
	$tpl = str_replace("<!--id-usuario-->", $IdUsu, $tpl);
	$tpl = str_replace("<!--hidPagina-->", $Pagina, $tpl);
	
	$tpl = str_replace("<!--nome-usuario-->", "", $tpl);
	$tpl = str_replace("<!--acessos-detalhes-->", $detalhes, $tpl);
	
	$botoes = Botao::BotaoVoltar("fntVoltarAcessos();", "@lng[Voltar para os acessos]");
	
	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($usu), $tpl);
	$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
	
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