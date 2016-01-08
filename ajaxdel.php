<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';

include_once 'cls/area.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/grupopergunta.class.php';
include_once 'cls/classes.class.php';
include_once 'cls/tipoexame.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	$secao = $_POST['etapa'];

	switch ($secao)
	{
		case "niveldif":
			fntDeletaNivelDificuldade();
			break;
			
		case "grupopergunta":
			fntDeletaGrupoPergunta();
			break;
			
		case "classepergunta":
			fntDeletaClassePergunta();
			break;
			
		case "tipoexame":
			fntDeletaTipoExame();
			break;
	}
}

function fntDeletaNivelDificuldade()
{
	$t = new NivelPergunta();
	$t->setCodigo(base64_decode($_POST['id']));
	if($t->DeletaNivelPergunta())
	{
		echo(Comuns::Idioma("@lng[Excluído com sucesso.]"));
	}
	else
	{
		echo(Comuns::Idioma("@lng[Não foi possível deletar o nível da pergunta.] ".$t->getErro()));
	}
}

function fntDeletaGrupoPergunta()
{
	$t = new GrupoPergunta();
	$t->setCodgrupo(base64_decode($_POST['id']));
	if($t->Deleta())
	{
		echo(Comuns::Idioma("@lng[Excluído com sucesso.]"));
	}
	else
	{
		echo(Comuns::Idioma("@lng[Não foi possível deletar o agrupador de pergunta.] ".$t->getErro()));
	}
}

function fntDeletaClassePergunta()
{
	try
	{
		$t = new Classes();
		$t->setCodigo(base64_decode($_POST['id']));
		if($t->DeletarClassePergunta())
		{
			echo(Comuns::Idioma("@lng[Classificação de exercício excluída com sucesso.]"));
		}
		else
		{
			echo(Comuns::Idioma("@lng[Não foi possível excluír a classificação de exercícios.] ".$t->getErro()));
		}
	}
	catch (Exception $ex)
	{
		echo($ex->getMessage());
	}
}

function fntDeletaTipoExame()
{
	$t = new TipoExame();
	$t->setCodigo(base64_decode($_POST['id']));
	if($t->Deletar())
	{
		echo(Comuns::Idioma("@lng[Excluído com sucesso.]"));
	}
	else
	{
		echo(Comuns::Idioma("@lng[Não foi possível deletar tipo de exame.] ".$t->getErro()));
	}
}


Main();
?>