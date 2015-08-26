<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class Midia
{
	private $codcaso;
	private $codmidia;
	private $descricao;
	private $complemento;
	private $codtipo;
	private $url;
	private $largura;
	private $altura;
	private $origem;
	private $msg_erro;
	
	public function getCodCaso()
	{
		return $this->codcaso;
	}
	
	public function getCodMidia()
	{
		return $this->codmidia;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getComplemento()
	{
		return $this->complemento;
	}
	
	public function getTipoMidia()
	{
		return $this->codtipo;
	}
	
	public function getURL()
	{
		return $this->url;
	}
	
	public function getLargura()
	{
		return $this->largura;
	}
	
	public function getAltura()
	{
		return $this->altura;
	}
	
	public function getOrigem()
	{
		return $this->origem;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function setCodCaso($p_codcaso)
	{
		$this->codcaso = $p_codcaso;
	}
	
	public function setCodMidia($p_codmidia)
	{
		$this->codmidia = $p_codmidia;
	}
	
	public function setDescricao($p_descricao)
	{
		$this->descricao = $p_descricao;
	}
	
	public function setComplemento($p_complemento)
	{
		$this->complemento = $p_complemento;
	}
	
	public function setTipoMidia($p_codtipo)
	{
		$this->codtipo = $p_codtipo;
	}
	
	public function setURL($p_url)
	{
		$this->url = $p_url;
	}
	
	public function setLargura($p_largura)
	{
		$this->largura = $p_largura;
	}
	
	public function setAltura($p_altura)
	{
		$this->altura = $p_altura;
	}
	
	public function setOrigem($p_origem)
	{
		$this->origem = $p_origem;
	}
	
	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->descricao))
			{
				if (isset($this->url))
				{
					if (isset($this->codtipo))
					{
						$sql  = "INSERT INTO mesmidia(CodCaso, CodMidia, Descricao, Complemento, CodTipo, DtCadastro, url, Largura, Altura, Origem)";
						$sql .= "SELECT :pCodCaso, ";
						$sql .= "		IFNULL(((SELECT MAX(CodMidia) FROM mesmidia WHERE CodCaso = :pCodCaso) * 2), 1), ";
						$sql .= "		:pDescricao, ";
						$sql .= "		:pComplemento, ";
						$sql .= "		:pCodTipo, ";
						$sql .= "		CURRENT_TIMESTAMP, ";
						$sql .= "		:purl, ";
						$sql .= "		:pLargura, ";
						$sql .= "		:pAltura, ";
						$sql .= "		:pOrigem;";
						
						$cnn = Conexao2::getInstance();
						
						$cmd = $cnn->prepare($sql);
						$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
						$cmd->bindParam(":pComplemento", $this->complemento, PDO::PARAM_STR);
						$cmd->bindParam(":pCodTipo", $this->codtipo, PDO::PARAM_INT);
						$cmd->bindParam(":purl", $this->url, PDO::PARAM_STR);
						$cmd->bindParam(":pLargura", $this->largura, PDO::PARAM_INT);
						$cmd->bindParam(":pAltura", $this->altura, PDO::PARAM_INT);
						$cmd->bindParam(":pOrigem", $this->origem, PDO::PARAM_STR);
						$cmd->execute();
						
						if ($cmd->errorCode() == Comuns::QUERY_OK)
						{
							$sqlcod = "SELECT CodMidia FROM mesmidia WHERE CodCaso = :pCodCaso AND url = :purl";
							
							$cmdcod = $cnn->prepare($sqlcod);
							$cmdcod->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
							$cmdcod->bindParam(":purl", $this->url, PDO::PARAM_STR);
							
							$cmdcod->execute();
							
							if ($cmdcod->errorCode() == Comuns::QUERY_OK)
							{
								$this->codmidia = $cmdcod->fetchColumn();
							}
							
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
						$this->msg_erro = "@lng[Tipo da mнdia nгo informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[URL da mнdia nгo informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Descriзгo nгo informada]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso clнnico nгo informado]";
			return false;
		}
	}
	
	public function Atualiza()
	{
		if (isset($this->descricao))
		{
			if (isset($this->codcaso))
			{
				if (isset($this->codmidia))
				{
					if (isset($this->url))
					{
						$sql  = "UPDATE mesmidia ";
						$sql .= "SET Descricao = :pDescricao, ";
						$sql .= "    Complemento = :pComplemento, ";
						$sql .= "    url = :purl, ";
						$sql .= "    Largura = :pLargura, ";
						$sql .= "    Altura = :pAltura ";
						$sql .= "WHERE CodCaso = :pCodCaso AND CodMidia = :pCodMidia;";
						
						$cnn = Conexao2::getInstance();
						
						$cmd = $cnn->prepare($sql);
						$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
						$cmd->bindParam(":pComplemento", $this->complemento, PDO::PARAM_STR);
						$cmd->bindParam(":purl", $this->url, PDO::PARAM_STR);
						$cmd->bindParam(":pLargura", $this->largura, PDO::PARAM_INT);
						$cmd->bindParam(":pAltura", $this->altura, PDO::PARAM_INT);
						$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pCodMidia", $this->codmidia, PDO::PARAM_INT);
						
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
				}
			}
		}
	}
	
	public function Deteta($del_file = false)
	{
		if ($del_file)
		{
			$midia = new Midia();
			$midia->setCodCaso($this->codcaso);
			$midia->setCodMidia($this->codmidia);
			
			$midia->CarregaPorCodigoEspecifico();
			
			if ($midia->getOrigem() == "upload")
			{
				$up = new Upload();
				$up->DeletaArquivo($midia->getURL());
			}
		}
		
		$sql  = "DELETE FROM mesmidia ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodMidia = :pCodMidia;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMidia", $this->codmidia, PDO::PARAM_INT);
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
	
	public function ListaRecordSet()
	{
		$sql  = "SELECT CodCaso, CodMidia, Descricao, Complemento, CodTipo, DtCadastro, url, Largura, Altura, Origem ";
		$sql .= "FROM mesmidia WHERE CodCaso = :pCodCaso ORDER BY CodTipo, Descricao;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhuma mнdia cadastrada no sistema]";
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
	
	public function ListaRecordSetPorTipo($tipo)
	{
		$sql  = "SELECT CodCaso, CodMidia, Descricao, Complemento, CodTipo, DtCadastro, url, Largura, Altura, Origem ";
		$sql .= "FROM mesmidia WHERE CodCaso = :pCodCaso AND CodTipo = :pCodTipo ";
		$sql .= "ORDER BY Descricao;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodTipo", $tipo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhuma mнdia cadastrada no sistema]";
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
	
	public function CarregaPorCodigoEspecifico()
	{
		$sql  = "SELECT CodCaso, CodMidia, Descricao, Complemento, CodTipo, DtCadastro, url, Largura, Altura, Origem ";
		$sql .= "FROM mesmidia WHERE CodMidia = :pCodMidia AND CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMidia", $this->codmidia, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$midia = $cmd->fetch(PDO::FETCH_OBJ);
				
				$this->codtipo = $midia->CodTipo;
				$this->descricao = $midia->Descricao;
				$this->complemento = $midia->Complemento;
				$this->largura = $midia->Largura;
				$this->altura = $midia->Altura;
				$this->url = $midia->url;
				$this->origem = $midia->Origem;
				
				return true;
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum registro encontrado]";
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
	
	public function ListaPorCodigoCombinado($combinacao)
	{
		$sql  = "SELECT mesmidia.CodCaso, mesmidia.CodMidia, mesmidia.Descricao, mesmidia.Complemento, ";
		$sql .= "		mesmidia.CodTipo, mestipomidia.Descricao as Tipo, mesmidia.DtCadastro, mesmidia.url, ";
		$sql .= "		mesmidia.Largura, mesmidia.Altura, mesmidia.Origem ";
		$sql .= "FROM mesmidia INNER JOIN mestipomidia ON mestipomidia.CodTipo = mesmidia.CodTipo ";
		$sql .= "WHERE CodCaso = :pCodCaso AND ((CodMidia & :pCodMidia) > 0)";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMidia", $combinacao, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum registro encontrado]";
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
	
	public function CarregaPorURL()
	{
		$sql  = "SELECT CodCaso, CodMidia, Descricao, Complemento, CodTipo, DtCadastro, url, Largura, Altura, Origem ";
		$sql .= "FROM mesmidia WHERE url = :purl AND CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":purl", $this->url, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$midia = $cmd->fetch(PDO::FETCH_OBJ);
				
				$this->codmidia = $midia->CodMidia;
				$this->codtipo = $midia->CodTipo;
				$this->descricao = $midia->Descricao;
				$this->complemento = $midia->Complemento;
				$this->largura = $midia->Largura;
				$this->altura = $midia->Altura;
				$this->origem = $midia->Origem;
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum registro encontrado]";
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
}

?>