<?php

//--utf8_encode --
session_start();
include_once 'cls/montagem.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$mon = new Montagem();
		$mon->setCodCaso($_SESSION['caso']);
		
		if ($_REQUEST['a'] == "inc")
		{
			$ok = true;
			$erro = "";
			$sTipo = $_POST['item'];
			$sIdPai = split("_", $_POST['pai']);
			$sOrg = $_POST['org'];
			$iOrd = $_POST['ord'];
			
			$sRegPai = $sIdPai[3];
			
			if ((isset($_POST['cont'])) && (!is_null($_POST['cont'])) && ($_POST['cont'] != ""))
			{
				$iContRefe = $_POST['cont'];
			}
			else
			{
				$iContRefe = $sIdPai[1];
			}
			
			$sChave = $mon->AddItem($sTipo, $iOrd, $sRegPai, $iContRefe, $sOrg);
			
			if ($sChave != false)
			{
				Log::RegistraLog("Adicionado o item " . $sChave . " à montagem do caso clínico");
				echo($sChave);
			}
			else
			{
				Log::RegistraLog("Erro ao tentar adicionado um item à montagem do caso clínico. Detalhes: " . $mon->getErro());
				echo("ERRO: " . $mon->getErro());
			}
		}
		else if ($_REQUEST['a'] == "rem")
		{
			$idNodo = $_POST['nodo'];
			$itens = split("_", $idNodo);
			$chave = $itens[3];
			
			if ($mon->ExcluiItem($chave))
			{
				Log::RegistraLog("Removido o item " . $chave . " da montagem do caso clínico");
				echo("OK");
			}
			else
			{
				Log::RegistraLog("Erro ao tentar remover o item " . $chave . " da montagem do caso clínico. Detalhes: " . $mon->getErro());
				echo("ERRO: " . $mon->getErro());
			}
		}
		else if ($_REQUEST['a'] == "mov")
		{
			$idNodo = $_POST['nodo'];
			$idNodoPai = $_POST['nodopai'];
			$posAnt = $_POST['posant'];
			$posNova = $_POST['posnova'];
			$itens = split("_", $idNodo);
			$itensPai = split("_", $idNodoPai);
			$chave = $itens[3];
			$chavePai = $itensPai[3];
			
			if ($mon->ReordenaItem($chave, $chavePai, $posAnt, $posNova))
			{
				Log::RegistraLog("O item " . $chave . " foi reordenado da posição " . $posAnt . " para a posição " . $posNova . " na montagem do caso clínico");
				echo("OK");
			}
			else
			{
				Log::RegistraLog("Erro ao tentar mover o item " . $chave . " na montagem do caso clínico. Detalhes: " . $mon->getErro());
				echo("ERRO: " . $mon->getErro());
			}
		}
		else if ($_REQUEST['a'] == "par")
		{
			$idNodo = $_POST['nodo'];
			$itens = split("_", $idNodo);
			$chave = $itens[3];
			
			$erro = false;
			$deserro = "";
			
			foreach ($_POST as $campo => $valor)
			{
				if (stripos($campo, "Config") !== false)
				{
					$campo = split("_", $campo);
					$config = $campo[1];

					if (substr($campo[0], 0, 3) == "txt")
					{
						$valor = urldecode($valor);
					}
					
					if (!$mon->SalvaParamItem($chave, $config, $valor))
					{
						$erro = true;
						Log::RegistraLog("Erro ao tentar gravar a configuração. Caso: " . $_SESSION['caso'] . ". Item: " . $chave . ". Config: " . $config . ". Valor: " . $valor . ". Erro: " . $mon->getErro());
						$deserro .= ($deserro != "" ? "\r\n" : "") . $mon->getErro();
					}
					else
					{
						Log::RegistraLog("Gravada configuração para o item " . $chave . " na montagem do caso " . $_SESSION['caso'] . ". Config: " . $config . ". Valor: " . $valor);
					}
				}
			}
			
			if ($erro)
			{
				echo("ERRO: " . $deserro);
			}
			else
			{
				echo("OK");
			}
		}
		else if ($_REQUEST['a'] == "retpar")
		{
			//cont_an_0_129120D92796F7AF13882551731A996C
			
			$idNodo = $_POST['nodo'];
			$itens = split("_", $idNodo);
			$tipo = $itens[1];
			$chave = $itens[3];
			
			Log::RegistraLog("Tipo do item informado: " . $tipo . ". Chave informada: " . $chave);
			
			$xmlconfigs = $mon->RetornaConfigs($tipo, $chave);
			$saltos = $mon->RetornaListaConfSaltos($chave);
			$anexos = $mon->RetornaListaConfAnexos($chave);
			
			$ret = "";
			
			if ($xmlconfigs !== false)
			{
				$ret = $xmlconfigs;
			}
			
			if ($saltos !== false)
			{
				$ret .= '<divDesviosSalvos>' . $saltos . '</divDesviosSalvos>';
			}
			
			if ($anexos !== false)
			{
				$ret .= '<divAnexosSalvos>' . $anexos . '</divAnexosSalvos>';
			}
			echo(Comuns::Idioma($ret));
		}
	}
	else
	{
		echo("ERRO: @lng[Caso não informado]");
	}
}

Main();

?>