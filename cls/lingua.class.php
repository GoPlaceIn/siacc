<?php

class Lingua
{
	private $codigo;
	private $simbolo;
	private $nome;
	private $padrao;
	private $publicado;
	
	private $codexpressao;
	private $expressao;
	
	private $msg_erro;
	
	public function getCodigoIdioma()
	{
		return $this->codigo;
	}
	
	public function setCodigoIdioma($p_codigo)
	{
		$this->codigo = $p_codigo;
	}
	
	public function getSimbolo()
	{
		return $this->simbolo;
	}
	
	public function setSimbolo($p_simbolo)
	{
		$this->simbolo = $p_simbolo;
	}
	
	public function getNomeIdioma()
	{
		return $this->nome;
	}
	
	public function setNomeIdioma($p_nome)
	{
		$this->nome = $p_nome;
	}
	
	public function getPadrao()
	{
		return $this->padrao;
	}
	
	public function setPadrao($p_padrao)
	{
		$this->padrao = $p_padrao;
	}
	
	public function getPublicado()
	{
		return $this->publicado;
	}
	
	public function setPublicado($p_publicado)
	{
		$this->publicado = $p_publicado;
	}
	
	public function getCodExpressao()
	{
		return $this->codexpressao;
	}
	
	public function setCodExpressao($p_codexpressao)
	{
		$this->codexpressao = $p_codexpressao;
	}
	
	public function getExpressao()
	{
		return $this->expressao;
	}
	
	public function setExpressao($p_expressao)
	{
		$this->expressao = $p_expressao;
	}
	
	public function getErro()
	{
		return $msg_erro;
	}
	
	public function SalvaTraducao()
	{
		$sql  = "select 1 as Tem from sistraducoes where CodIdioma = :pCodIdioma and CodExpressao = :pCodExpressao;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodIdioma", $this->getCodigoIdioma(), PDO::PARAM_INT);
		$cmd->bindParam(":pCodExpressao", $this->getCodExpressao(), PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$del = false;
			if ($cmd->rowCount() > 0)
			{
				if ($this->expressao == null || $this->expressao == "")
				{
					$sql2  = "DELETE FROM sistraducoes WHERE CodIdioma = :pCodIdioma and CodExpressao = :pCodExpressao;";
					$del = true;
				}
				else
				{
					$sql2  = "UPDATE sistraducoes SET Expressao = :pExpressao ";
					$sql2 .= "WHERE CodIdioma = :pCodIdioma and CodExpressao = :pCodExpressao;";
				}
			}
			else
			{
				if ($this->expressao != null && $this->expressao != "")
				{
					$sql2  = "INSERT INTO sistraducoes(CodIdioma, CodExpressao, Expressao) ";
					$sql2 .= "VALUES(:pCodIdioma, :pCodExpressao, :pExpressao);";
				}
				else
				{
					return true;
				}
			}
			
			$cmd->closeCursor();
			
			$cmd = $cnn->prepare($sql2);
			$cmd->bindParam(":pCodIdioma", $this->getCodigoIdioma(), PDO::PARAM_INT);
			$cmd->bindParam(":pCodExpressao", $this->getCodExpressao(), PDO::PARAM_INT);
			if (!$del)
				$cmd->bindParam(":pExpressao", $this->getExpressao(), PDO::PARAM_STR);
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				return true;
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = $msg[2];
				return false;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function PercentualTraduzido()
	{
		$sql  = "select ";
		$sql .= "	 count(e.Codigo) as Total ";
		$sql .= "	,count(t.CodExpressao) as Traduzidos ";
		$sql .= "from sisexpressoes e ";
		$sql .= "left outer join sistraducoes t ";
		$sql .= "			 on t.CodExpressao = e.Codigo ";
		$sql .= "			and t.CodIdioma = :pCodIdioma";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodIdioma", $this->getCodigoIdioma(), PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$linha = $cmd->fetch(PDO::FETCH_OBJ);
			return (($linha->Traduzidos / $linha->Total) * 100) . "%";
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
}

?>