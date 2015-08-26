<?php
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/grupopergunta.class.php';

function Main()
{
	$perguntas = $_POST['perg'];
	
	if ($perguntas != "")
		$perguntas = split(";", $perguntas);
	
	$agrup = $_SESSION['agruperg'];
	
	$sqldel = "DELETE FROM mesperguntaagrupamentos WHERE CodAgrupador = :pCodAgrupador;";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sqldel);
	$cmd->bindParam(":pCodAgrupador", $agrup, PDO::PARAM_INT);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		$cmd->closeCursor();
		
		if (is_array($perguntas))
		{
			$sqlins  = "INSERT INTO mesperguntaagrupamentos(CodAgrupador, CodPergunta) ";
			$sqlins .= "VALUES(:pCodAgrupador, :pCodPergunta);";
			
			foreach ($perguntas as $pergunta)
			{
				$codperg = base64_decode($pergunta);
				
				$cmd = $cnn->prepare($sqlins);
				$cmd->bindParam(":pCodAgrupador", $agrup, PDO::PARAM_INT);
				$cmd->bindParam(":pCodPergunta", $codperg, PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() != Comuns::QUERY_OK)
				{
					$msg = $cmd->errorInfo();
					echo($msg[2]);
					return;
				}
				
				$cmd->closeCursor();
			}
			
			echo("OK");
		}
		else
		{
			echo("OK");
		}
	}
	else
	{
		$msg = $cmd->errorInfo();
		echo($msg[2]);
	}
}

Main();
?>