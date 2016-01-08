<?php

//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/components/hashtable.class.php';
include_once 'cls/exame.class.php';

header('Content-Type: text/html; charset=iso-8859-1');

function fntMostraRelacoesExame()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$codexame = base64_decode($_POST['r']);
		
		$ex = new Exame();
		$hipoteses = $ex->ListaRelacoesExame($_SESSION['caso'], $codexame);
		
		if ($hipoteses != false)
		{
			if (count($hipoteses) > 0)
			{
				$cont = 1;
				foreach ($hipoteses as $hipo)
				{
					$checks .= '<input type="checkbox" name="chkExames" id="chkExames_' . $cont . '" value="' . base64_encode($hipo->CodHipotese) . '" ' . (($hipo->TemRelacao == 0) ? "": 'checked="checked"') . ' class="checkrels" />' . $hipo->Descricao . '<br />';
					$cont++;
				}
			}
			else
			{
				$checks = "Nenhuma hipótese diagnóstica cadastrada";
			}
			return $checks;
		}
		else
		{
			throw new ErrorException($ex->getErro(), 1001);
		}
	}
	else
	{
		throw new ErrorException("Caso de estudo não encontrado", 1000);
	}
}

function Main()
{
	$dados = new HashTable();
	
	switch ($_POST['tipo'])
	{
		case "exames":
			$rels = fntMostraRelacoesExame();
			$dados->AddItem("relacoes", $rels);
			break;
	}
	
	echo($dados->ToXML());
}

Main();

?>