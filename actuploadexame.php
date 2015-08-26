<?php
session_start();

include_once 'cls/upload.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/exame.class.php';
include_once 'cls/midia.class.php';

header('Content-Type: text/html; charset=iso-8859-1');

function Main()
{
	if((((!isset($_POST["txtOrigem"])) || (is_null($_POST["txtOrigem"])) || ($_POST["txtOrigem"] == "")) ? "" : $_POST["txtOrigem"]) == "midia")
	{
		foreach ($_REQUEST['chkDasMidias'] as $imagem)
		{
			$value = base64_decode($imagem);
			
			$m = new Midia();
			$m->setCodCaso($_SESSION['caso']);
			$m->setCodMidia($value);
			
			if($m->CarregaPorCodigoEspecifico())
			{
				$e = new Exame();
				// Se tem alguma indicação de que seja um exame, então grava na tabela de exames
				if ($e->InsereImagemExame($_SESSION['caso'], $_SESSION['exame'], $m->getCodMidia(), $m->getDescricao(), $m->getComplemento(), $m->getOrigem()))
				{
					Log::RegistraLog('Realizado upload da imagem ' . $m->getURL() . ' - ' . $m->getDescricao());
					echo(Comuns::Idioma('@lng[Realizado upload da imagem]' . ' ' . $m->getURL() . ' - ' . $m->getDescricao()));
				}
				else
				{
					Log::RegistraLog('Falha ao realizar upload da imagem' . $m->getURL() . ' - ' . $m->getDescricao() . '. Detalhes: ' . $e->getErro(), true);
					echo(Comuns::Idioma('@lng[Não foi possível cadastrar a imagem]' . ' ' . $m->getURL() . '. @lng[Detalhes:]' . ' ' . $e->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>'));
				}
			}
			else
			{
				Log::RegistraLog('Não foi possível localizar a mídia ' . $value, true);
				echo(Comuns::Idioma('@lng[Não foi possível localizar a mídia]' , ' ' . $value));	
			}
		}
	}
	else if (isset($_FILES["realupload"]))
	{
		$up = new Upload();
		$e = new Exame();
		$m = new Midia();
		
		$up->setArquivo($_FILES["realupload"]);
		
		if ($up->ValidaImagem($up->getTipo()))
		{
			// Gera onde o arquivo será armazenado
			if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
			{
				// Gera o nome do exame
				$nome = Comuns::CodigoUnico();
				$destino = "files/" . $_SESSION['caso'] . "/imgs";
				
				$up->setNome($nome);
				$up->setDestino($destino);
				
				if ($up->RealizaUpload())
				{
					$descricao = (($_POST['txtDesArquivo'] != "") ? $_POST['txtDesArquivo'] : null);
					$complemento = (($_POST['txtComplementoImagem'] != "") ? urldecode($_POST['txtComplementoImagem']) : null);
					$origem = $_POST['txtOrigem'];
					$tipo = $_POST['txtTipo'];
					
					$m->setCodCaso($_SESSION['caso']);
					$m->setDescricao($descricao);
					$m->setComplemento($complemento);
					$m->setTipoMidia(Comuns::TIPO_MIDIA_IMAGEM);
					$m->setURL($up->getFullPath());
					$m->setOrigem($origem);
					if ($m->Insere())
					{
						if ($tipo == "exame")
						{
							// Se tem alguma indicação de que seja um exame, então grava na tabela de exames
							if ($e->InsereImagemExame($_SESSION['caso'], $_SESSION['exame'], $m->getCodMidia(), $descricao, $complemento, $origem))
							{
								Log::RegistraLog('Realizado upload da imagem ' . $up->getFullPath() . ' - ' . $descricao);
								echo(file_get_contents("tpl/caso-upload-exame.html"));
							}
							else
							{
								Log::RegistraLog('Falha ao realizar upload da imagem' . $up->getFullPath() . ' - ' . $descricao . '. Detalhes: ' . $e->getErro(), true);
								$m->Deteta();
								$up->DeletaArquivo($up->getFullPath());
								echo(Comuns::Idioma('@lng[Não foi cadastrar a imagem]' . ' ' . $up->getFullPath() . '. @lng[Detalhes:]' . ' ' . $e->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>'));
							}
						}
						else
						{
							Log::RegistraLog('Realizado upload da imagem ' . $up->getFullPath() . ' - ' . $descricao);
							echo(file_get_contents("tpl/caso-upload-exame.html"));
						}
					}
					else
					{
						$up->DeletaArquivo($up->getFullPath());
						Log::RegistraLog('Falha ao realizar upload da imagem ' . $up->getFullPath() . ' - ' . $descricao . '. Detalhes: ' . $m->getErro(), true);
						echo(Comuns::Idioma('@lng[Não foi possível enviar o arquivo. Detalhes:]' . ' ' . $m->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>'));
					}
				}
				else
				{
					Log::RegistraLog('Falha ao tentar enviar imagem ' . $up->getFullPath() . ' - ' . $_POST['txtDesArquivo'] . '. Detalhes: ' . $up->getStatus(), true);
					echo(Comuns::Idioma($up->getStatus() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>'));
				}
			}
		}
		else
		{
			Log::RegistraLog("Falha ao tentar enviar imagem. Detalhes: " . $up->getStatus(), true);
			echo(Comuns::Idioma($up->getStatus() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>'));
		}
	}
}

Main();
?>