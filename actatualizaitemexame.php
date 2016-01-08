<?php

//--utf8_encode --
session_start();
include_once 'cls/exame.class.php';
include_once 'cls/upload.class.php';
include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

header('Content-Type: text/html; charset=iso-8859-1');

function Main()
{
	try
	{
		$up = new Upload();
		$e = new Exame();
		
		$descricao = (($_POST["txtDesArquivo"] != "") ? $_POST["txtDesArquivo"] : null);
		$complemento = (($_POST["txtComplementoImagem"] != "") ? urldecode($_POST["txtComplementoImagem"]) : null);
		
		if ($e->AtualizaImagemExame($_SESSION['caso'], $_SESSION['exame'], $_SESSION['itemexame'], $descricao, $complemento))
		{
			$img = $e->CarregaImagemExame($_SESSION['caso'], $_SESSION['exame'], $_SESSION['itemexame']);
			$m = new Midia();
			$m->setCodCaso($_SESSION['caso']);
			$m->setCodMidia($img->Valor);
			$m->setDescricao($descricao);
			$m->setComplemento($complemento);
			if(isset($_GET["type"]) && ($_GET["type"] == "doc"))
			{
				//nada de diferente...
			}
			else
			{
				$m->setURL($img->Url);
				$m->setLargura($img->Largura);
				$m->setAltura($img->Altura);
			}
			$m->Atualiza();
			
			//doc não tem realupload
			if ((isset($_FILES["realupload"])) && ($_FILES["realupload"] != ""))
			{
				$up->setArquivo($_FILES["realupload"]);
				
				if ($up->ValidaImagem($up->getTipo()))
				{
					$imgatual = $e->CarregaImagemExame($_SESSION['caso'], $_SESSION['exame'], $_SESSION['itemexame']);
					if ($imgatual != false)
					{
						if ($up->RealizaTrocaImagem($imgatual->Valor))
						{
							$retorno = "OK";
						}
						else
						{
							$retorno = $up->getStatus();
						}
					}
					else
					{
						$retorno = $e->getErro();
					}
				}
				else
				{
					$retorno = "@lng[A descrição e o complemento foram atualizados porem o arquivo enviado não é uma imagem válida e a imagem antiga não foi substituída]";
				}
			}
			else
			{
				$retorno = "OK";
			}
		}
		else
		{
			$retorno = $e->getErro();
		}
	}
	catch (Exception $ex)
	{
		$retorno = $ex->getMessage();
	}
	
	if ($retorno == "OK")
		header("Location:vwatualizadetalhe.php?act=redir&reg=" . base64_encode($_SESSION['itemexame']));
	else
		header("Location:vwatualizadetalhe.php?act=fica&ret=" . base64_encode($retorno));
}

Main();
?>