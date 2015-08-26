<?php
session_start();
include_once 'cls/exame.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$bateria = $_POST['nb'];
		
		$e = new Exame();
		
		$rsexames = $e->ListaExamesDaBateria($_SESSION['caso'], $bateria);
		
		if (count($rsexames) > 0)
		{
			$optsexames = '<option value="-1">Nenhum em específico</option>';
			
			foreach ($rsexames as $item)
			{
				$optsexames .= '<option value="' . base64_encode($item->CodExame) . '">' . $item->Descricao . '</option>';
			}
			echo($optsexames);
		}
		else
		{
			echo("ERRO - Nenhum caso encontrado");
		}
	}
	else
	{
		echo("ERRO - Caso de estudo não encontrado");
	}
}

Main();
?>