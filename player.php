<?php
//--utf8_encode --
session_start();
include_once 'cls/videoplayer.class.php';
include_once 'cls/audioplayer.class.php';
include_once 'cls/midia.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$session = ($_SESSION['casores'] ? $_SESSION['casores'] : $_SESSION['caso']);
	
	//if (((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0)) || ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0)))
	if ($session)
	{
		$midia = $_POST['midia'];
		
		$clsmid = new Midia();
		//$clsmid->setCodCaso($_SESSION['casores']);
		$clsmid->setCodCaso($session);
		$clsmid->setCodMidia(base64_decode($midia));
		
		if ($clsmid->CarregaPorCodigoEspecifico())
		{
			if ($clsmid->getTipoMidia() == Comuns::TIPO_MIDIA_VIDEO)
			{
				$vidplayer = new VideoPlayer($clsmid->getURL(), (!is_null($clsmid->getLargura()) ? $clsmid->getLargura() : 320), (!is_null($clsmid->getAltura()) ? $clsmid->getAltura() : 290), 'false', 'true');
				if ($vidplayer)
				{
					$html  = '<player>' . ($vidplayer->player() != "" ? $vidplayer->player() : $vidplayer->getLastError()) . '</player>';
					$html .= '<descricao>' . (is_null($clsmid->getDescricao()) ? '' : $clsmid->getDescricao()) . '</descricao>';
					$html .= '<complemento>' . (is_null($clsmid->getComplemento()) ? '' : $clsmid->getComplemento()) . '</complemento>';
					$html .= '<btnfechar><a href="javascript:void(0);" onclick="jQuery(\'#view-midia\').html(\'\');" class="btnFecharMidia">@lng[Fechar]</a></btnfechar>';
				}
				else
				{
					$html = "ERRO";
				}
			}
			else if ($clsmid->getTipoMidia() == Comuns::TIPO_MIDIA_AUDIO)
			{
				$audplayer = new AudioPlayer($clsmid->getURL(), 'false', 'true');
				if ($audplayer)
				{
					$html  = '<player>' . $audplayer->player() . '</player>';
					$html .= '<descricao>' . (is_null($clsmid->getDescricao()) ? '' : $clsmid->getDescricao()) . '</descricao>';
					$html .= '<complemento>' . (is_null($clsmid->getComplemento()) ? '' : $clsmid->getComplemento()) . '</complemento>';
					$html .= '<btnfechar><a href="javascript:void(0);" onclick="fntFechaMidia();" class="btnFecharMidia">@lng[Fechar]</a></btnfechar>';
				}
				else
				{
					$html = "ERRO";
				}
			}
			else if ($clsmid->getTipoMidia() == Comuns::TIPO_MIDIA_IMAGEM)
			{
				$html  = '<player><img src="viewimagem.php?img=' . base64_encode($clsmid->getCodMidia()) . '&ex=f" alt="' . $clsmid->getDescricao() . '" title="' . $clsmid->getDescricao() . '" /></player>';
				$html .= '<descricao>' . (is_null($clsmid->getDescricao()) ? '' : $clsmid->getDescricao()) . '</descricao>';
				$html .= '<complemento>' . (is_null($clsmid->getComplemento()) ? '' : $clsmid->getComplemento()) . '</complemento>';
			}
		}
		
		echo($html);
	}
	else
	{
		echo("ERRO. @lng[Seção não definida]");
	}
}

Main();
?>