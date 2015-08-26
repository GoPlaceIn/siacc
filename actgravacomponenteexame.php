<?php
include_once 'cls/componenteexame.class.php';

function Main()
{
	$exame = base64_decode($_POST["hdnCodigoExame"]);
	$comp = $_POST["hdnCodigoComp"] ? base64_decode($_POST["hdnCodigoComp"]) : '';
	$descricao = urldecode($_POST["txtDescricao"]);
	
	header('Content-Type: text/html; charset=iso-8859-1');
	
	try
	{
		if (($_POST['act']) && ($_POST['act'] == 'novaordem'))
		{
			$c = new Componente();
			if ($c->ReordenaComponente($_POST['ids']))
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
			$c = new Componente();
			
			if ($exame != "") { $c->setCodexame($exame); }
			if ($comp != "") { $c->setCodcomponente($comp); }
			if ($descricao != "") { $c->setDescricao($descricao); }
			
			$ret = "";
			
			if ($comp == "")
			{
				$ret = $c->Insere();
			}
			else
			{
				$ret = $c->Altera();
			}
			
			if ($ret === true)
			{
				echo("GRAVADO");
			}
			else
			{
				echo($c->getErro());
			}
		}
	}
	catch (PDOException $ex)
	{
		echo($ex->getMessage());	
	}
}

Main();

?>