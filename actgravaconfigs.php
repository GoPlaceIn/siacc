<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/conexao.class.php';

function Main()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$cnn = Conexao2::getInstance();
		
		$erro = false;
		$deserro = "";
		$caso = $_SESSION['caso'];
		
		foreach ($_POST as $campo => $valor)
		{
			if (($campo != "selFeedback") && ($campo != "etapa"))
			{
				$campo = split("_", $campo);
				
				$secao = $campo[0];
				$config = $campo[1];
				
				$sqlConsulta  = "SELECT 1 as Tem FROM mescasoconfigs ";
				$sqlConsulta .= "WHERE CodCaso = :pCodCaso AND Secao = :pSecao and Configuracao = :pConfig;";
				
				$cmdConsulta = $cnn->prepare($sqlConsulta);
				$cmdConsulta->bindParam(":pCodCaso", $caso, PDO::PARAM_INT);
				$cmdConsulta->bindParam(":pSecao", $secao, PDO::PARAM_STR);
				$cmdConsulta->bindParam(":pConfig", $config, PDO::PARAM_STR);
				
				$cmdConsulta->execute();
				
				if ($cmdConsulta->rowCount() > 0)
				{
					$sqlComando  = "UPDATE mescasoconfigs SET Valor = :pValor ";
					$sqlComando .= "WHERE CodCaso = :pCodCaso AND Secao = :pSecao AND Configuracao = :pConfig ";
				}
				else
				{
					$sqlComando  = "INSERT INTO mescasoconfigs(CodCaso, Secao, Configuracao, Valor) ";
					$sqlComando .= "VALUES(:pCodCaso, :pSecao, :pConfig, :pValor);";	
				}
	
				$cmdComando = $cnn->prepare($sqlComando);
				$cmdComando->bindParam(":pCodCaso", $caso, PDO::PARAM_INT);
				$cmdComando->bindParam(":pSecao", $secao, PDO::PARAM_STR);
				$cmdComando->bindParam(":pConfig", $config, PDO::PARAM_STR);
				$cmdComando->bindParam(":pValor", $valor, PDO::PARAM_STR);
				
				$cmdComando->execute();
				
				if ($cmdComando->errorCode() != Comuns::QUERY_OK)
				{
					$msg = $cmdComando->errorInfo();
					$erro = true;
					$deserro .= "Erro " . $msg[2];
				}
			}
			else
			{
				$sql = "UPDATE mescaso SET DaResposta = :pResposta WHERE Codigo = :pCodCaso;";
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pResposta", $valor, PDO::PARAM_INT);
				$cmd->bindParam(":pCodCaso", $caso, PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() != Comuns::QUERY_OK)
				{
					$msg = $cmd->errorInfo();
					$erro = true;
					$deserro .= "Erro " . $msg[2];
				}
			}
		}
		
		if ($erro == false)
		{
			echo("OK");
		}
		else
		{
			echo($deserro);
		}
	}
	else
	{
		echo(Comuns::Idioma("@lng[Erro ao locallizar o caso clínico]"));
	}
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}

?>