<?php

function Main()
{
	$filename = "C:\\temp\\areas.txt";
	
	$handle = fopen($filename, "r");
	$linhas = file($filename);
	
	$verifica = true;
	
	for ($x=0; $x < count($linhas); $x++)
	{
		$dados = explode('#',$linhas[$x]);
		
		if (substr_count($linhas[$x], "#") == 2)
		{
			$matrizDeDados[] = $dados;
		}
		else
		{
			$y = $x +1;
			$erro .= 'Erro na linha ' . $y . ' do arquivo importado; ';
			$verifica = false;
		}
	}
	
	if($verifica)
	{
		$mostrar = true;
		
		foreach ($matrizDeDados as $linhas)
		{
			if ($mostrar)
				if (is_null($linhas[2]))
					echo("É nullo");
				else
					echo($linhas[2]);
			
			$sql .= "INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) " . "\r\n";
			$sql .= "VALUES('" . trim($linhas[0]) . "', '" . trim($linhas[1]) . "', " . ((trim($linhas[2]) == "null") ? "NULL" : ("'" . trim($linhas[2]) . "'")) . ", 1);" . "\r\n\r\n";
		}
		file_put_contents("C:\\temp\\dadosimportacao.txt", $sql);
		
		echo("Arquivo gerado com sucesso");
	}
	else
	{
		file_put_contents("C:\\temp\\dadosimportacao.txt", $erro);
		echo("Erros no processamento do arquivo");
	}
}

Main();

?>