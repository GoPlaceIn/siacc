<?php
//--utf8_encode --
session_start();

include_once 'inc/comuns.inc.php';
include_once 'cls/upload.class.php';
include_once 'cls/midia.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/log.class.php';

header('Content-Type: text/html; charset=iso-8859-1');

function Main()
{
	if (isset($_FILES["realupload"]))
	{
		$up = new Upload();
		$m = new Midia();
		
		$up->setArquivo($_FILES["realupload"]);
		
		if ($up->ValidaDocumento($up->getTipo()))
		{
			// Gera onde o arquivo será armazenado
			if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
			{
				// Gera o nome do arquivo
				$nome = Comuns::CodigoUnico();
				$destino = "files/" . $_SESSION['caso'] . "/documentos";
				
				$up->setNome($nome);
				$up->setDestino($destino);
				
				if ($up->RealizaUpload())
				{
					$descricao = (($_POST['txtDesArquivo'] != "") ? $_POST['txtDesArquivo'] : null);
					$complemento = (($_POST['txtComplementoDocumento'] != "") ? urldecode($_POST['txtComplementoDocumento']) : null);
					$origem = $_POST['txtOrigem'];
					$tipo = $_POST['txtTipo'];
					
					$m->setCodCaso($_SESSION['caso']);
					$m->setDescricao($descricao);
					$m->setComplemento($complemento);
					$m->setTipoMidia(Comuns::TIPO_MIDIA_DOCUMENTO);
					$m->setURL($up->getFullPath());
					$m->setOrigem("upload");
					if ($m->Insere())
					{
						// Se tem alguma indicaão de que seja um exame, então grava na tabela de exames
						if ((isset($_SESSION['exame'])) && ($_SESSION['exame'] != 0))
						{
							$e = new Exame();
							if ($e->InsereMidiaExame($_SESSION['caso'], $_SESSION['exame'], $m->getCodMidia(), $descricao, $complemento, "doc"))
							{
								Log::RegistraLog('Realizado vinculo do documento com exame',true);
							}
							else
							{
								Log::RegistraLog('Falha ao realizar vinculo do documento com exame', true);
								echo(Comuns::Idioma('@lng[Não foi possível realizar vinculo do documento com exame]<br /><br /><a href="vwuploaddetalhe.php?type=doc">@lng[Voltar]</a>'));
							}
						}
						Log::RegistraLog('Realizado upload do arquivo ' . $up->getFullPath() . ' - ' . $descricao);
						echo(file_get_contents("tpl/caso-upload-documento.html"));
					}
					else
					{
						$up->DeletaArquivo($up->getFullPath());
						Log::RegistraLog('Falha ao realizar upload do arquivo ' . $up->getFullPath() . ' - ' . $descricao . '. Detalhes: ' . $m->getErro(), true);
						echo(Comuns::Idioma('@lng[Não foi possível enviar o arquivo. Detalhes:]' . ' ' . $m->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=doc">@lng[Voltar]</a>'));
					}
				}
				else
				{
					Log::RegistraLog('Falha ao realizar upload do arquivo ' . $up->getFullPath() . ' - ' . $_POST['txtDesArquivo'] . '. Detalhes: ' . $up->getStatus(), true);
					echo(Comuns::Idioma('@lng[Problemas ao enviar o arquivo:]' . ' ' . $up->getStatus() . '<br /><br /><a href="vwuploaddetalhe.php?type=doc">@lng[Voltar]</a>'));
				}
			}
		}
		else
		{
			Log::RegistraLog("Falha ao tentar enviar arquivo. Detalhes: " . $up->getStatus(), true);
			echo($up->getStatus() . '<br /><br /><a href="vwuploaddetalhe.php?type=doc">@lng[Voltar]</a>');
		}
	}
	else if(isset($_REQUEST['chkDasMidias']))
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
				if ($e->InsereMidiaExame($_SESSION['caso'], $_SESSION['exame'], $m->getCodMidia(), $m->getDescricao(), $m->getComplemento(), "doc"))
				{
					Log::RegistraLog('Realizado vinculo do documento ' . $m->getURL() . ' - ' . $m->getDescricao());
					echo(Comuns::Idioma('@lng[Realizado vinculo do documento]' . ' ' . $m->getURL() . ' - ' . $m->getDescricao()));
				}
				else
				{
					Log::RegistraLog('Falha ao realizar vinculo do documento ' . $m->getURL() . ' - ' . $m->getDescricao() . '. Detalhes: ' . $e->getErro(), true);
					echo(Comuns::Idioma('@lng[Falha ao realizar vinculo do documento]' . ' ' . $m->getURL() . '. @lng[Detalhes:]' . ' ' . $e->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>'));
				}
			}
			else
			{
				Log::RegistraLog('Não foi possível localizar a mídia ' . $value, true);
				echo(Comuns::Idioma('@lng[Não foi possível localizar a mídia]' . ' ' . $value));	
			}
		}
	}
}

Main();

?>