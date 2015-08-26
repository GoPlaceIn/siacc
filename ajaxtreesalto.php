<?php
session_start();

include_once 'cls/conexao.class.php';
include_once 'cls/montagem.class.php';
include_once 'cls/resolucao.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/components/hashtable.class.php';
include_once 'cls/log.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		if ($_POST['tip'] == "tree")
		{
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			
			$html = $mon->RetornaArvoreLista();
			if ($html)
			{
				$html = str_replace('<div id="tree">', '<div id="' . $_POST['id'] . '">', $html);
			}
			else
			{
				$html = "ERRO: " . $mon->getErro();
			}
			echo($html);
		}
		else if ($_POST['tip'] == "opts")
		{
			if (!$_POST['perg'])
			{
				$res = new Resolucao();
				$res->setCodcaso($_SESSION['caso']);
				$hash = $res->BuscaConteudoPelaChave($_POST['nodo'], true);
				if ($hash != false)
				{
					echo($hash->ToXML());
				}
				else
				{
					echo("ERRO. Hash voltou false");
				}
			}
			else
			{
				$pergunta = new Pergunta();
				$pergunta->Carregar($_POST['perg']);
				if ($pergunta->getTipo()->getCodigo() == 1)
				{
					$cont = 1;
					foreach ($pergunta->getAlternativas() as $alternativa)
					{
						$html .= '<div class="alt-img">';
						$html .= '<input type="checkbox" name="rdoAlternativa_' . $pergunta->getCodigo() . '[]" id="rdoAlt_' . $pergunta->getCodigo() . '_' . $cont . '" value="' . $alternativa->getCodBinario() . '" class="opcao-resposta" />' . $alternativa->getTexto();
						$html .= '<div id="img"><img src="' . $alt->getImagem() . '" alt="' . $alt->getTexto() . '" title="' . $alt->getTexto() . '" class="img-preview" /></div>';
						$html .= '</div>';
						$cont++;
					}
				}
				else
				{
					$cont = 1;
					foreach ($pergunta->getAlternativas() as $alternativa)
					{
						$html .= '<div class="alt-txt">';
						$html .= '<input type="checkbox" name="rdoAlternativa_' . $pergunta->getCodigo() . '[]" id="rdoAlt_' . $pergunta->getCodigo() . '_' . $cont . '" value="' . $alternativa->getCodBinario() . '" class="opcao-resposta" />' . $alternativa->getTexto();
						$html .= '</div>';
						$cont++;
					}
				}
				echo('<conteudo>' . $html . '</conteudo>');
			}
		}
		else if ($_POST['tip'] == 'pergs')
		{
			//$arrNodo = split("_", $_POST['nodo']);
			
			Log::RegistraLog("Vai consultas as perguntas vinculadas ao nodo: " . $arrNodo[3]);
			
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			$lista = $mon->ListaPerguntasNodo($_POST['nodo']);
			if ($lista)
			{
				$html .= '<option value="-1">@lng[Selecione]</option>';
				foreach ($lista as $perg)
				{
					$html .= '<option value="' . $perg->Codigo . '">' . substr($perg->Texto, 0, 100) . '</option>';
				}
			}
			else
			{
				$html .= '<option>' . $mon->getErro() . '</option>';
			}
			echo($html);
		}
		else if ($_POST['tip'] == 'salvacond')
		{
			$arrNodoAtual = split("_", $_POST['nodoatual']);
			$arrNodoDestino = split("_", $_POST['nododes']);
			
			if ($_POST['nodocond'])
			{
				$arrNodoCond = split("_", $_POST['nodocond']);
				$strChaveCond = $arrNodoCond[3];
				if ($_POST['perg'])
				{
					$intPerg = $_POST['perg'];
				}
				else
				{
					$intPerg = null;
				}
				$intResp = $_POST['resp'];
			}
			else
			{
				$strChaveCond = null;
				$intResp = null;
				$intPerg = null;
			}
			$strChaveAtual = $arrNodoAtual[3];
			$strChaveDestino = $arrNodoDestino[3];
			
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			$desvio = $mon->InsereSalto($strChaveAtual, $strChaveDestino, $strChaveCond, $intPerg, $intResp);
			if ($desvio)
			{
				$html = $mon->RetornaListaConfSaltos($strChaveAtual);
				if ($html)
				{
					echo($html);
				}
				else
				{
					echo("ERRO: " . $mon->getErro());
				}
			}
			else
			{
				echo("ERRO: " . $mon->getErro());
			}
		}
		else if ($_POST['tip'] == 'mudaprior')
		{
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			if ($mon->AlteraPrioridadeSalto($_POST['mm'], base64_decode($_POST['chaveOri']), base64_decode($_POST['chaveDest'])))
			{
				echo($mon->RetornaListaConfSaltos(base64_decode($_POST['chaveOri'])));
			}
			else
			{
				echo("ERRO: " . $mon->getErro());
			}
		}
		else if ($_POST['tip'] == 'delsalto')
		{
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			if ($mon->DeletaSalto(base64_decode($_POST['chaveOri']), base64_decode($_POST['chaveDest'])))
			{
				echo($mon->RetornaListaConfSaltos(base64_decode($_POST['chaveOri'])));
			}
			else
			{
				echo("ERRO: " . $mon->getErro());
			}
		}
		else if ($_POST['tip'] == 'vincanexo')
		{
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			
			$nodo = $_POST['item'];
			$cont = $_POST['cont'];
			$strTipoCont = substr($cont, 0, 1); 
			$arr = split("_", $nodo);
			$u = unserialize($_SESSION['usu']);
			
			if ($mon->InsereAnexo($arr[3], base64_decode(substr($cont, 1)), $strTipoCont, $u->getCodigo()))
			{
				echo($mon->RetornaListaConfAnexos($arr[3]));
			}
			else
			{
				echo('ERRO: ' . $mon->getErro());
			}
		}
		else if ($_POST['tip'] == 'delanexo')
		{
			$mon = new Montagem();
			$mon->setCodCaso($_SESSION['caso']);
			
			$nodo = base64_decode($_POST['item']);
			$cont = $_POST['cont'];
			$strTipoCont = substr($cont, 0, 1); 
			//$arr = split("_", $nodo);
			
			//die("ERRO: " . $nodo . ' ' . base64_decode(substr($cont, 1)));
			
			if ($mon->DeletaAnexo($nodo, base64_decode(substr($cont, 1)), $strTipoCont))
			{
				$listagem = $mon->RetornaListaConfAnexos($nodo);
				if ($listagem !== false)
				{
					echo($listagem);
				}
				else
				{
					echo("ERRO: " . $mon->getErro());
				}
			}
			else
			{
				echo('ERRO: ' . $mon->getErro());
			}
		}
	}
	else
	{
		echo("ERRO: @lng[Caso não informado]");
	}
}

Main();

?>