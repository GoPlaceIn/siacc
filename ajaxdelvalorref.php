<?php

//--utf8_encode --
include_once 'inc/comuns.inc.php';
include_once 'cls/valref.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
		
	$codexame = base64_decode($_POST["e"]);
	$codcompo = base64_decode($_POST["c"]);
	$agrupador = base64_decode($_POST["r"]);
	
	$v = new ValorReferencia();
	
	$v->setCodexame($codexame);
	$v->setCodcomponente($codcompo);
	$v->setAgrupador($agrupador);

	if ($v->PodeExcluir())
	{
		$ret = "";
		$ret = $v->Deleta();
	
		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			echo($v->getErro());
		}
	}
	else
	{
		echo(Comuns::Idioma("@lng[O registro não pode ser excluido pois está sendo usado por outro registro]"));
	}
}

Main();

?>