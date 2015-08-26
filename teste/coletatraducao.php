<?php

include_once '../cls/conexao.class.php';
include_once '../inc/comuns.inc.php';

function Coleta($url)
{
	echo($url);
	$dir = dir($url);
	
	while($item = $dir->read())
	{
		if ($item != "." && $item != "..")
		{
			$file_name = $url . "\\" . $item;
			if (is_file($file_name))
			{
				$content = file_get_contents($file_name);
				$array = preg_match_all('/@lng\[.*?\]/', $content, $matches);
	
				$sqlValida  = "select 1 from sisexpressoes where Expressao = :pExpressao;";
				$sqlIns  = "insert into sisexpressoes(Codigo, Expressao, Grupo) ";
				$sqlIns += "select ifnull(max(Codigo), 0) + 1 as Proximo, :pExpressao, :pGrupo from sisexpressoes;";
	
				$cnn = Conexao2::getInstance();
	
				foreach ($matches as $match)
				{
					foreach ($match as $expressao)
					{
						$valor = substr($expressao, 5, -1);
	
						$cmd = $cnn->prepare($sqlValida);
						$cmd->bindParam(":pExpressao", $valor, PDO::PARAM_STR);
						$cmd->execute();
	
						if ($cmd->errorCode() == Comuns::QUERY_OK)
						{
							if ($cmd->rowCount() == 0)
							{
								$grupo = "GENERICO";
	
								$cmd->closeCursor();
								$cmd = $cnn->prepare($sqlIns);
								$cmd->bindParam(":pExpressao", $valor, PDO::PARAM_STR);
								$cmd->bindParam(":pGrupo", $grupo, PDO::PARAM_STR);
								$cmd->execute();
								echo("SUCESSO: Expressão " . $valor . " gravada com sucesso<br />");
							}
						}
						else
						{
							$msg = $cmd->errorInfo();
							$msg_erro = $msg[2];
							echo("ERRO: " . $msg_erro);
						}
						$cmd->closeCursor();
					}
						
				}
			}
			else
			{
				if (is_dir($file_name))
				{
					echo("Dir: " . $item . "<br />");
					Coleta($file_name);
				}
			}
		}
	}
}

function Main()
{
	//$dir = dir("c:\\xampp\\htdocs\\projeto\\tpl");
	$dirbase = "c:\\xampp\\htdocs\\projeto";
	
	Coleta($dirbase);
}

Main();
?>