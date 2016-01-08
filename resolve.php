<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/components/hashtable.class.php';

include_once 'cls/usuario.class.php';
include_once 'cls/caso.class.php';
include_once 'cls/resolucao.class.php';

function Main()
{
	$codcaso = $_GET['c'];
	$direcao = $_POST['d'];
	$codcaso = is_null($codcaso) ? "" : $codcaso;
	$direcao = is_null($direcao) ? "f" : $direcao;
	
	if (($direcao != "p") && ($direcao != "f"))
	{
		$direcao = "p";
	}
	
	if ($codcaso == "")
	{
		if ((!isset($_SESSION['casores'])) || (is_null('casores')))
		{
			$msg = base64_encode("@lng[Não foi informado nenhum caso de estudos]");
			header("Location:aluno.php?msg=" . $msg);
		}
	}
	else
	{
		$_SESSION['casores'] = base64_decode($codcaso);
		$_SESSION['status'] = false;
		$_SESSION['codresolucao'] = null;
		$_SESSION['chaveanterior'] = null;
		$_SESSION['chaveatual'] = null;
		$_SESSION['tipocont'] = null;
		$_SESSION['organizador'] = null;
		$_SESSION['ordem'] = null;
	}
	
	$chave = $_GET['k'];
	if (is_null($chave))
		$chave = "";
	
	$tpl = file_get_contents("tpl/aluno/resolve.html");

	$u = unserialize($_SESSION["usu"]);
	//$u = new Usuario();
	$res = new Resolucao();
	$res->setCodcaso($_SESSION['casores']);
	$res->setCodusuario($u->getCodigo());
	
	if (!$_SESSION['status'])
	{
		$_SESSION['status'] = $res->BuscaStatusAndamento();
		
		if ($_SESSION['status'] == 1)
		{
			$res->IniciaResolucao();
		}
		else if ($_SESSION['status'] == 2)
		{
			if ($_SESSION['codresolucao'] == null)
				$_SESSION['codresolucao'] = base64_decode($_GET['r']);
			
			$res->setCodresolucao($_SESSION['codresolucao']);
			$res->RegistraAcesso($u->getIdAcessoAtual());
		}
		else if ($_SESSION['status'] == 3)
		{
			$res->IniciaResolucao();
		}
		else
		{
			$_SESSION['status'] = false;
			die("Inconsistencia localizada. " . $res->getErro());
		}
	}
	
	if ($_SESSION['status'] !== false)
	{
		$c = new Caso();
		$c->setCodigo($_SESSION['casores']);
		$c->CarregarCaso();
		
		//$conteudo = $c->BuscaProximoConteudo($chave, $direcao);
		$conteudo = $res->BuscaProximoConteudo($direcao);
		
		if (!$conteudo)
		{
			echo($res->getErro());
			return;
		}
		
		$tpl = str_replace("<!--titulocaso-->", $c->getNome(), $tpl);
		$tpl = str_replace("<!--titulosecao-->", $conteudo->getValue("titulosecao"), $tpl);
		$tpl = str_replace("<!--menusecao-->", $conteudo->getValue("menu"), $tpl);
		$tpl = str_replace("<!--conteudosecao-->", $conteudo->getValue("conteudo"), $tpl);
		$tpl = str_replace("<!--chave-->", $conteudo->getValue("chave"), $tpl);
		//$tpl = str_replace("<!--of-->", $conteudo->getValue("Obrigatorio"), $tpl);
		
		if ($conteudo->ContainsKey("javascript"))
		{
			$tpl = str_replace("<!--javascriptload-->", $conteudo->getValue("javascript"), $tpl);
		}
		else
		{
			$tpl = str_replace("<!--javascriptload-->", "", $tpl);
		}
		
		echo($tpl);
	}
	else
	{
		die("@lng[Status do caso não pode ser localizado. Detalhes:] " . $res->getErro());
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