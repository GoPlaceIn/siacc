<?php

//--utf8_encode --
session_start();
include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		$codigos = base64_decode($_POST['midias']);
		$mid = new Midia();
		
		$mid->setCodCaso($_SESSION['casores']);
		$lista_midias = $mid->ListaPorCodigoCombinado($codigos);
		if ($lista_midias)
		{
			foreach($lista_midias as $midia)
			{
				$imgtipo = ($midia->CodTipo == 1 ? 'img/imagem.png' : ($midia->CodTipo == 2 ? 'img/video.png' : ($midia->CodTipo == 4 ? 'img/audio.png' : 'img/multimidia.png')));
				$html .= '<img src="' . $imgtipo . '" class="item-galeria-midia" alt="' . $midia->Tipo . ': ' . $midia->Descricao . '" title="' . $midia->Tipo . ': ' . $midia->Descricao . '" onclick="javascript:fntLoadMidia(\'' . base64_encode($midia->CodMidia) . '\');" />';
			}
		}
		else
		{
			$html = "ERRO: " . $mid->getErro();
		}
	}
	else
	{
		$html = "ERRO: @lng[Não foi informado o caso clínico]";
	}
	
	echo(Comuns::Idioma($html));
}

Main();

?>