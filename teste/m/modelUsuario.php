<?php

//--utf8_encode --

include_once '../cls/conexao.class.php';

class modelUsuario
{
	private $codigo;
	private $nome;

	public function ConsultaUsuario($codigo = null)
	{
		$sql = "SELECT Codigo, NomeCompleto FROM mesUsuario";
		$sql .= ($codigo != null) ? " WHERE Codigo = " . $codigo . ";" : ";";

		$cnn = Conexao2::getInstance();

		$q = $cnn->prepare($sql);
		$q->execute();

		$ret = $q->fetchAll(PDO::FETCH_OBJ);

		return $ret;
	}

	public function AtualizaUsuario($codigo, $nome)
	{
		try
		{
			$sql = "UPDATE mesUsuario SET NomeCompleto = '" . $nome . "' WHERE Codigo = " . $codigo . ";";
				
			$cnn = Conexao2::getInstance();
			$q = $cnn->prepare($sql);
			$q->execute();
				
			return true;
		}
		catch (PDOException $ex)
		{
			return false;
		}
	}
}

?>