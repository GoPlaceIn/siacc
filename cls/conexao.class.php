<?php

class Conexao
{
	var $usuario = "root";
	var $senha = "root";
	var $sid = "localhost";
	var $banco = "mestrado";
	var $comando = "";
	var $link = "";

	function Conexao()
	{
		$this->Conecta();
	}

	function Conecta()
	{
		$this->link = mysql_connect($this->sid,$this->usuario,$this->senha);
		if (!$this->link)
		{
			die("@lng[Problema na Conexão com o Banco de Dados]");
		}
		elseif (!mysql_select_db($this->banco,$this->link))
		{
			die("@lng[Problema na Conexão com o Banco de Dados]");
		}
	}

	function Desconecta()
	{
		return mysql_close($this->link);
	}

	/**
	 * Executa uma instrução no banco de dados e retorna um recordset ou 0 em caso de erro.
	 */
	function Consulta($consulta)
	{
		$this->comando = $consulta;
		mysql_query("set names 'utf8'");
		if ($resultado = mysql_query($this->comando, $this->link))
		{
			return $resultado;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Executa uma instrução no banco de dados e se o parametro $retid for verdadeiro, o id resultate
	 * da instrução será retornado caso contrário, será retornado true em caso de sucesso ou 0 em caso de erro.
	 */
	function Instrucao($sql, $retid = false)
	{
		$this->comando = $sql;

		$ret = mysql_query($this->comando,$this->link);
		if (!$ret)
		{
			return 0;
		}
		else
		{
			if ($retid)
			{
				return mysql_insert_id();
			}
			else
			{
				return true;
			}
		}
	}
}

class Conexao2
{
	private static $instance;

	public static function getInstance()
	{
		if (!isset(self::$instance))
		{
			self::$instance = new PDO("mysql:host=localhost;dbname=mestrado","root","root");
			self::$instance->exec("set names utf8");
		}
		return self::$instance;
	}
}

?>