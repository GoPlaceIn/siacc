<?php

class TipoMidia
{
	private $codtipo;
	private $descricao;
	private $ativo;
	private $extensoes;
	
	public function getCodigo()
	{
		return $this->codtipo;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getAtivo()
	{
		return $this->ativo;
	}
	
	public function setCodigo($p_codtipo)
	{
		$this->codtipo = $p_codtipo;
	}
	
	public function setDescricao($p_descricao)
	{
		$this->descricao = $p_descricao;
	}
	
	public function setAtivo($p_ativo)
	{
		$this->ativo = $p_ativo;
	}
	
	public function getExtensoes()
	{
		return $this->extensoes;
	}
	
	public function __construct()
	{
		$this->codtipo = 0;
		$this->descricao = "";
		$this->ativo = 1;
		$this->extensoes = null;
	}
	
	public function Carrega()
	{
		$sql  = "SELECT CodTipo, Descricao, Ativo ";
		$sql .= "FROM mestipomidia where CodTipo = :pCodTipo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodTipo", $this->codtipo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$tipo = $cmd->fetch(PDO::FETCH_OBJ);
			
			$this->descricao = $tipo->Descricao;
			$this->ativo = $tipo->Ativo;
			$this->extensoes = $this->CarregaExtensoes();
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	private function CarregaExtensoes()
	{
		$sql  = "";
		$sql .= "";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->execute();
	}
}

?>