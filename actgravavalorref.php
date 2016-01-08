<?php
//--utf8_encode --
include_once 'cls/valref.class.php';

function Main()
{
	$codexame = base64_decode($_POST["hdnCodigoExame"]);
	$codcompo = base64_decode($_POST["hdnCodigoCompo"]);
	$temagrup = ((trim($_POST["txtAgrupador"]) != "") && (!isset($_POST["chkSemAgrupador"]))) ? 1 : 0;
	$agrupador = urldecode($_POST["txtAgrupador"]);
	$tipovalor = $_POST["selTipoValor"];
	$valminimo = urldecode($_POST["txtValMin"]);
	$valmaximo = urldecode($_POST["txtValMax"]);
	$valigual = urldecode($_POST["txtValIgual"]);
	$unmedida = urldecode($_POST["txtUnidMedida"]);
	
	header('Content-Type: text/html; charset=iso-8859-1');
	
	try
	{
		$v = new ValorReferencia();
		
		if ($codexame != "") { $v->setCodexame($codexame); }
		if ($codcompo != "") { $v->setCodcomponente($codcompo); }
		$v->setTemagrupador($temagrup);
		if ($temagrup == 1)
			$v->setAgrupador($agrupador);
		else
			$v->setAgrupador("");
		
		switch ($tipovalor)
		{
			case 1:
				if ($valminimo != "") { $v->setVlrminimo($valminimo); }
				if ($valmaximo != "") { $v->setVlrmaximo($valmaximo); }
				break;
			case 2:
			case 6:
				if ($valminimo != "") { $v->setVlrminimo($valminimo); }
				break;
			case 3:
			case 5:
				if ($valmaximo != "") { $v->setVlrmaximo($valmaximo); }
				break;
			case 4:
				if ($valigual != "") { $v->setVlrminimo($valigual); }
				break;
		}
		$v->setTipo($tipovalor);
		if ($unmedida != "") { $v->setUnidadeMedida($unmedida); }
		
		$ret = "";
		
		if (! $v->ExisteChave())
		{
			$ret = $v->Insere();
		}
		else
		{
			$ret = $v->Altera();
		}
		
		if ($ret == true)
		{
			echo("GRAVADO");
		}
		else
		{
			echo($v->getErro());
		}
	}
	catch (PDOException $ex)
	{
		echo($ex->getMessage());	
	}
}

Main();

?>