<?php

//--utf8_encode --
session_start();

include_once 'cls/pergunta.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	$codigo = base64_decode($_POST['txtCodigo']);
	$txt = urldecode($_POST['txtDescricao']);
	$clsAtual = $_POST['selClasse'];
	$nivAtual = $_POST['selNivel'];
	$tipAtual = $_POST['selTipo'];
	$ativo = $_POST['selAtivo'];
	$expGeral = urldecode($_POST['txtExplicacaoGeral']);

	if (trim($codigo) == "")
	{
		$codigo = null;
	}
	else if(! is_numeric($codigo))
	{
		echo(Comuns::Idioma("@lng[Código informado não é válido]"));
	}

	$p = new Pergunta();
	if (! is_null($codigo)) { $p->setCodigo($codigo); }
	$p->setTexto($txt);
	$p->setClasse($clsAtual);
	$p->setNivel($nivAtual);
	$p->setTipo(TipoPergunta::RetornaTipo($tipAtual));
	$p->setAtivo($ativo);
	if ($expGeral != "") { $p->setTextoExplicacaoGeral($expGeral); }

	if ($p->getCodigo() === 0)
	{
		if ($p->AdicionaPergunta() === true)
		{
			$_SESSION['perg'] = $p->getCodigo();
			echo("OK");
		}
		else
		{
			$_SESSION['perg'] = 0;
			echo(Comuns::Idioma("@lng[Erro ao adicionar a pergunta:]"));
		}
	}
	else
	{
		if ($p->AtualizaPergunta() === true)
		{
			$_SESSION['perg'] = $p->getCodigo();
			echo("OK");
		}
		else
		{
			$erros = "@lng[Erros ocorreram.]";
			foreach ($p->msg_erro as $err)
			{
				$erros .= "<br />" . $err;
			}
			echo(Comuns::Idioma($erros));
		}
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