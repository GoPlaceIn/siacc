<?php
session_start();
include_once 'cls/exame.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		if ((isset($_SESSION['exame'])) && ($_SESSION['exame'] > 0))
		{
			if ((isset($_SESSION['itemexame'])) && ($_SESSION['itemexame'] > 0))
			{
				if(isset($_GET["type"]) && ($_GET["type"] == "doc"))
					$tpl = file_get_contents("tpl/caso-atualiza-item-doc-exame.html");
				else
					$tpl = file_get_contents("tpl/caso-atualiza-item-exame.html");
				$e = new Exame();
				$item = $e->CarregaImagemExame($_SESSION['caso'], $_SESSION['exame'], $_SESSION['itemexame']);
				
				if ($item != false)
				{
					$urlimg = '<img class="thumbatual" src="viewimagem.php?img=' . base64_encode($item->Valor) . '">';
					$tpl = str_replace('<!--caminhoimagem-->', $urlimg, $tpl);
					$tpl = str_replace('<!--txtDesArquivo-->', $item->Descricao, $tpl);
					$tpl = str_replace('<!--txtComplementoImagem-->', $item->Complemento, $tpl);
					$tpl = str_replace('<!--tipo-->', $item->TipoItem, $tpl);
					
					if ($_GET['act'] == "redir")
					{
						$tpl = str_replace('<!--retornoacao-->', "fntExibeRetorno('OK', '" . base64_encode($_SESSION['exame']) . "');", $tpl);
					}
					else if ($_GET['act'] == "fica")
					{
						$tpl = str_replace('<!--retornoacao-->', "fntExibeRetorno('" . base64_decode($_GET['act']) . "', '" . base64_decode($_GET['ret']) . "');", $tpl);
					}
					else
					{
						$tpl = str_replace('<!--retornoacao-->', "", $tpl);
					}
				}
				else
				{
					$tpl = $e->getErro();
				}
			}
			else
			{
				$tpl = "@lng[Item não encontrado]";
			}
		}
		else
		{
			$tpl = "@lng[Exame não encontrado]";
		}
	}
	else
	{
		$tpl = "@lng[Caso de estudo não encontrado]";
	}
	
	echo( Comuns::Idioma($tpl) );
}

Main();

?>