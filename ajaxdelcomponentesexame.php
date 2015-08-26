<?php
include_once 'inc/comuns.inc.php';
include_once 'cls/componenteexame.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
		
	$codexame = base64_decode($_POST["c"]);
	$codcomp = base64_decode($_POST["r"]);
	
	$c = new Componente();
	
	$c->setCodexame($codexame);
	$c->setCodcomponente($codcomp);

	if ($c->PodeExcluir())
	{
		$ret = "";
		$ret = $c->Deleta();
	
		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			echo($c->getErro());
		}
	}
	else
	{
		echo(Comuns::Idioma("@lng[O registro não pode ser excluido pois está sendo usado por outro registro]"));
	}
}

Main();

?>