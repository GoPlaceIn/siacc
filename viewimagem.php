<?php
//--utf8_encode --
session_start();
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	if (($_SESSION['caso']) || ($_SESSION['casores']))
	{
		$img = $_GET['img'];
		$caminho = "";
		
		if ($img != "")
		{
			$img = base64_decode($img);
			$codcaso = ($_SESSION['caso'] ? $_SESSION['caso'] : ($_SESSION['casores'] ? $_SESSION['casores'] : null));
			
			$cnn = Conexao2::getInstance();
			$sql = "SELECT url FROM mesmidia WHERE CodMidia = :pCodMidia AND CodCaso = :pCodCaso;";
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodMidia", $img, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$caminho = $cmd->fetchColumn();
				}
			}
			else
			{
				$msg = $cmd->errorInfo();
				echo($msg[2]);
			}
			if ($caminho != "")
			{
				@$imagem = imagecreatefromjpeg($caminho);
				if ($imagem != false)
				{
					header('Content-Type: image/jpeg; charset=iso-8859-1');
					imagejpeg($image = $imagem, $filename = null, $quality = 100);
				}
				else
				{
					@$imagem = imagecreatefrompng($caminho);
					if ($imagem != false)
					{
						header('Content-Type: image/png; charset=iso-8859-1');
						imagepng($image = $imagem, $filename = null, $quality = 0);
					}
					else
					{
						@$imagem = imagecreatefromgif($caminho);
						if ($imagem != false)
						{
							header('Content-Type: image/gif; charset=iso-8859-1');
							imagegif($image = $imagem, $filename = null);
						}
						else
						{
							echo("@lng[Não foi possível carregar a imagem]");
						}
					}
				}
			}
			else
			{
				echo("@lng[Caminho não encontrado]");
			}
		}
		else
		{
			echo("@lng[Informe uma imagem]");
		}
	}
	else
	{
		echo("@lng[Caso não encontrado]");
	}
}


Main();

?>