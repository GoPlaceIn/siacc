<?php
session_start();

include_once 'cls/caso.class.php';
include_once 'cls/anamnese.class.php';
include_once 'cls/area.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/components/botao.class.php';
include_once 'cls/log.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	//header('Content-Type: text/html; charset=iso-8859-1');

	$acao = $_GET['act'];
	$acaoload = false;
	$tpl = file_get_contents("tpl/casos-inicio.html");
	
	if ($acao == "new")
	{
		$_SESSION['caso'] = 0;
	}
	else if ($acao == "")
	{
		if (($_GET['cod'] != "") && (is_numeric(base64_decode($_GET['cod'])) == true))
		{
			$_SESSION['caso'] = base64_decode($_GET['cod']);
		}
		else
		{
			if (! isset($_SESSION['caso']))
			{
				$_SESSION['caso'] = 0;
			}
		}
	}
	
	$tpl = str_replace("<!--javaonload-->", (($acao == "new") ? "fntLoadTela('basicos');" : ""), $tpl);

	if (isset($_SESSION['caso']) && $_SESSION['caso'] > 0)
	{
		if (Caso::ConsultaSituacao($_SESSION['caso']) == 0)
		{
			$botoes = Botao::BotaoPublicar("fntPublicaCaso();", "@lng[Publicar o caso clínico]");
		}
		else
		{
			$botoes = Botao::BotaoDespublicar("fntDespublicaCaso();", "@lng[Cancelar publicação]");
		}
		$botoes .= Botao::BotaoVisualizar("fntInstanciaPreview('" . base64_encode($_SESSION['caso']) . "');", "@lng[Visualizar o caso clínico]");
		
		$tpl = str_replace("caso-estilo", '', $tpl);
		
		$infoscaso = Caso::ConsultaInfosCaso($_SESSION['caso']);
		$evento = "Acessou o caso clínico " . $infoscaso['nome'] . " (código " . $infoscaso['codigo'] . ")";
		Log::RegistraLog($evento);
	}
	else
	{
		$tpl = str_replace("caso-estilo", 'style="display:none;"', $tpl);
		$botoes = "";
	}

	$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
	$tpl = str_replace("<!--CodCaso-->", base64_encode($_SESSION['caso']), $tpl);
	$tpl = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl);

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