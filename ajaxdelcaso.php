<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/caso.class.php';
include_once 'cls/objetivo.class.php';
include_once 'cls/anamnese.class.php';
include_once 'cls/examefisico.class.php';
include_once 'cls/hipoteses.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/tratamento.class.php';
include_once 'cls/desfecho.class.php';
include_once 'cls/conteudo.class.php';

include_once 'cls/area.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		if(Caso::ConsultaSituacao($_SESSION['caso']) == 0)
		{
			$secao = $_POST['etapa'];
			$retorno = "";
		
			switch ($secao)
			{
				case "basicos":
					//fntProcessaDadosBasicos();
					break;
				case "objetivos":
					$retorno = fntDeletaObjetivos();
					break;
				case "anamnese":
					//fntProcessaDadosAnamnese();
					break;
				case "examefisico":
					//fntProcessaDadosExameFisico();
					break;
				case "hipoteses":
					$retorno = fntDeletaHipoteses();
					break;
				case "exames":
					$retorno = fntDeletaExames();
					break;
				case "diagnosticos":
					$retorno = fntDeletaDiagnosticos();
					break;
				case "tratamentos":
					$retorno = fntDeletaTratamentos();
					break;
				case "desfechos":
					$retorno = fntDeletaDesfechos();
					break;
				case "conteudos":
					$retorno = fntDeletaConteudos();
					break;
				case "exercicios":
					//fntProcessaDadosExercicios();
					break;
				case "montagem":
					//fntProcessaDadosMontagem();
					break;
			}
			echo(Comuns::Idioma($retorno));
		}
		else
		{
			echo(Comuns::Idioma("ERRO. @lng[Este caso está publicado, não será possível modificar seus dados.]"));
		}
	}
	else
	{
		echo(Comuns::Idioma("ERRO. @lng[Não foi possível excluir os dados.]"));
	}
}

function fntDeletaTratamentos()
{
	$t = new Tratamento();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCodtratamento(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Tratamento deletado com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir o tratamento.] ".$t->getErro();
	}
}

function fntDeletaDiagnosticos()
{
	$t = new Diagnostico();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCoddiagnostico(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Diagnóstico deletado com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir o diagnóstico.] ".$t->getErro();
	}
}

function fntDeletaDesfechos()
{
	$t = new Desfecho();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCoddesfecho(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Desfecho deletado com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir o desfecho.] ".$t->getErro();
	}
}

function fntDeletaConteudos()
{
	$t = new Conteudo();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCodconteudo(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Conteúdo deletado com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir o conteúdo.] ".$t->getErro();
	}
}

function fntDeletaHipoteses()
{
	$t = new Hipoteses();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCodhipotese(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Hipótese diagnóstica deletada com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir a hipótese diagnóstica.] " . $t->getErro();
	}
}

function fntDeletaExames()
{
	$t = new Exame();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCodexame(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Exame deletado com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir o exame.] ".$t->getErro();
	}
}

function fntDeletaObjetivos()
{
	$t = new Objetivo();
	$t->setCodcaso($_SESSION['caso']);
	$t->setCoditem(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		return "@lng[Objetivo deletado com sucesso!]";
	}
	else
	{
		return "ERRO. @lng[Não foi possível excluir o objetivo.] ".$t->getErro();
	}
}

Main();
?>