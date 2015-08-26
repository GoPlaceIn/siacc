<?php
session_start();

include_once 'cls/upload.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/midia.class.php';
include_once 'cls/log.class.php';

header('Content-Type: text/html; charset=iso-8859-1');

function Main()
{
	if (isset($_FILES["realupload"]))
	{
		$up = new Upload();
		$m = new Midia();
		
		$up->setArquivo($_FILES["realupload"]);
		
		if ($up->ValidaVideo($up->getTipo()))
		{
			// Gera onde o arquivo será armazenado
			if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
			{
				// Gera o nome do arquivo
				$nome = Comuns::CodigoUnico();
				$destino = "files/" . $_SESSION['caso'] . "/videos";
				
				$up->setNome($nome);
				$up->setDestino($destino);
				
				if ($up->RealizaUpload())
				{
					$descricao = (($_POST['txtDesArquivo'] != "") ? $_POST['txtDesArquivo'] : null);
					$complemento = (($_POST['txtComplementoVideo'] != "") ? urldecode($_POST['txtComplementoVideo']) : null);
					$origem = $_POST['txtOrigem'];
					$tipo = $_POST['txtTipo'];
					
					$m->setCodCaso($_SESSION['caso']);
					$m->setDescricao($descricao);
					$m->setComplemento($complemento);
					$m->setTipoMidia(Comuns::TIPO_MIDIA_VIDEO);
					$m->setURL($up->getFullPath());
					$m->setOrigem("upload");
					if ($m->Insere())
					{
						Log::RegistraLog('Realizado upload do arquivo de vídeo ' . $up->getFullPath() . ' - ' . $descricao);
						$tpl = file_get_contents("tpl/caso-upload-video.html");
						$tpl = str_replace("<!--Listararquivos-->", "fntReloadConteudos();", $tpl);
						echo($tpl);
					}
					else
					{
						$up->DeletaArquivo($up->getFullPath());
						Log::RegistraLog('Falha ao realizar upload do arquivo de vídeo ' . $up->getFullPath() . ' - ' . $descricao . '. Detalhes: ' . $m->getErro(), true);
						echo(Comuns::Idioma('@lng[Não foi possível enviar o arquivo. Detalhes:]' . ' ' . $m->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=vid">@lng[Voltar]</a>'));
					}
				}
				else
				{
					Log::RegistraLog('Falha ao realizar upload do arquivo de vídeo ' . $up->getFullPath() . ' - ' . $_POST['txtDesArquivo'] . '. Detalhes: ' . $up->getStatus(), true);
					echo(Comuns::Idioma('@lng[Problemas ao enviar o arquivo:]' . ' ' . $up->getStatus() . '<br /><br /><a href="vwuploaddetalhe.php?type=vid">@lng[Voltar]</a>'));
				}
			}
		}
		else
		{
			Log::RegistraLog("Falha ao tentar enviar arquivo de vídeo. Detalhes: " . $up->getStatus(), true);
			echo(Comuns::Idioma($up->getStatus() . '<br /><br /><a href="vwuploaddetalhe.php?type=vid">@lng[Voltar]</a>'));
		}
	}
}

Main();

?>