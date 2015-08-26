<?php

include_once 'cls/conexao.class.php';

echo("Iniciando publica��o dos scripts de banco");

$sql  = "ALTER TABLE mescaso ";
$sql .= "ADD Etnia INT NULL COMMENT 'Etnia do paciente', ";
$sql .= "ADD NomePaciente VARCHAR(50) NULL COMMENT 'Iniciais do nome do paciente', ";
$sql .= "ADD ImgPaciente INT NULL COMMENT 'Imagem a ser usada (homem, mulher, crian�a, etc)'; ";

$cnn = Conexao2::getInstance();

$cmd = $cnn->prepare($sql);
$cmd->execute();

if ($cmd->errorCode() == Comuns::QUERY_OK)
{
	echo("<br />Iniciando publica��o do segundo script");
	$cmd->closeCursor();
	
	$sql  = "INSERT INTO mescasomontagemconfigs(Nome, Descricao, Grupo, Prefixo) ";
	$sql .= "VALUES('Resposta imediata','Permite ao aluno consultar a resposta imediatamente',24792,'chk');";
	
	$cmd = $cnn->prepare($sql);
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		echo("<br />Publica��o dos scripts conclu�da com sucesso");
	}
	else
	{
		$msg = $cmd->errorInfo();
		echo("Erro na publica��o do segundo script: " . $msg[2]);
	}
}
else
{
	$msg = $cmd->errorInfo();
	echo("Erro na publica��o do primeiro script: " . $msg[2]);
}

?>