<?php

include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

$commit = true;

$cnn = Conexao2::getInstance();
$cnn->beginTransaction();

for ($i = 101; $i < 201; $i++)
{
	echo("<br /> Criando usuário " . $i);
	
	$sql  = "INSERT INTO mesusuario(NomeCompleto, NomeUsuario, Senha, Email, DtCadastro, Ativo, OrigemCadastro, CodInstituicao) ";
	$sql .= "VALUES('Usuário " . $i . "', 'usuario" . $i . "', '" . md5("usuario" . $i) . "', 'regisl@ufcspa.edu.br', current_timestamp, 1, 1, 1);";
	
	$cmd = $cnn->prepare($sql);
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		$codigo = $cnn->lastInsertId();
	
		$cmd->closeCursor();
		$sql = "INSERT INTO mesusuariogrupo(CodUsuario, CodGrupoUsuario, DtVigencia) VALUES(" . $codigo . ", 2, '1900-12-31 00:00:00');";
	
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		
		$cmd->closeCursor();
		$sql = "INSERT INTO mesusuariogrupo(CodUsuario, CodGrupoUsuario, DtVigencia) VALUES(" . $codigo . ", 4, '1900-12-31 00:00:00');";
	
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		$cmd->closeCursor();	
	}
	else
	{
		$msg = $cmd->errorInfo();
		echo("Erro no usuário " . $i . ". " . $msg[2]);
		$cnn->rollBack();
		$commit = false;
		break;
	}
}

if ($commit)
{
	$cnn->commit();
	echo("Pronto");
}

?>