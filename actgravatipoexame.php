<?php
//--utf8_encode --
session_start();
require_once 'inc/comuns.inc.php';
require_once 'cls/tipoexame.class.php';

function Main()
{
	$codigo = $_POST["txtCodigo"];
	$descricao = urldecode($_POST["txtDescricao"]);
	$metodo = urldecode($_POST["txtMetodo"]);
	$condicao = urldecode($_POST["txtCondicao"]);
	$informacoes = urldecode($_POST["txtInformacoes"]);
	$conservacao = urldecode($_POST["txtConservacao"]);
	$temcomponentes = $_POST["selComponentes"];
	$ativo = $_POST["selAtivo"];
	$podeimg = $_POST["chkImgs"];
	$podedoc = $_POST["chkDocs"];
	$podeval = $_POST["chkVals"];

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$n = new TipoExame();
		if ($codigo != "") { $n->setCodigo($codigo); }
		if ($descricao != "") { $n->setDescricao($descricao); }
		if ($metodo != "") { $n->setMetodo($metodo); }
		if ($condicao != "") { $n->setCondicao($condicao); }
		if ($informacoes != "") { $n->setInformacoes($informacoes); }
		if ($conservacao != "") { $n->setConservacao($conservacao); }
		if ($temcomponentes != "") { $n->setComponentes($temcomponentes); }
		if ($ativo != "") { $n->setAtivo($ativo); }
		if ($podeimg !== null) { $n->setPodeImgs(1); } else { $n->setPodeImgs(0); }
		if ($podedoc !== null) { $n->setPodeDocs(1); } else { $n->setPodeDocs(0); }
		if ($podeval !== null) { $n->setPodeVals(1); } else { $n->setPodeVals(0); }

		if ($codigo == "")
		{
			if($n->Inserir())
			{
				echo("GRAVADO");
			}
			else
			{
				echo($n->getErro());
			}
		}
		else
		{
			if($n->Alterar())
			{
				echo("GRAVADO");
			}
			else
			{
				echo($n->getErro());
			}
		}
	}
	catch (Exception $ex)
	{
		echo($ex->getMessage());
	}
}

Main();
?>