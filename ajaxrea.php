<?php

//--utf8_encode --
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/resolucao.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		$intSoma = $_POST['s'];
		$chave = $_POST['k'];
		if ($intSoma > 0)
		{
			$resolucao = new Resolucao();
			$resolucao->setCodcaso($_SESSION['casores']);
			if ($resolucao->BuscaStatusAndamento() != 3)
			{
				if ($_POST['p'])
				{
					$ret = $resolucao->SalvaResposta($chave, $_POST['p'], $intSoma);
				}
				else
				{
					$ret = $resolucao->SalvaResposta($chave, null, $intSoma);
				}
			}
			else
			{
				$ret = true;
			}
			
			if ($ret)
			{
				echo("OK");
			}
			else
			{
				echo("ERRO: " . $resolucao->getErro());
			}
		}
		else
		{
			echo("ERRO: @lng[Resposta não informada]");
		}
	}
	else
	{
		die("ERRO: @lng[Caso não informado]");
	}
}

Main();
?>