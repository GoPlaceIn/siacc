<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class Objetivo
{
	private $codcaso;
	private $coditem;
	private $descricao;
	private $msg_erro;
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCoditem()
	{
		return $this->coditem;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	
	public function setCodcaso($p_codcaso)
	{
		if ((isset($p_codcaso)) && (!is_null($p_codcaso)))
		{
			$this->codcaso = $p_codcaso;
		}
		else
		{
			throw new Exception("@lng[Caso não informado]", 1000);
		}
	}
	
	public function setCoditem($p_coditem)
	{
		if ((isset($p_coditem)) && (!is_null($p_coditem)))
		{
			$this->coditem = $p_coditem;
		}
		else
		{
			throw new Exception("@lng[Item não informado]", 1010);
		}
	}
	
	public function setDescricao($p_descricao)
	{
		if ((isset($p_descricao)) && (!is_null($p_descricao)))
		{
			$this->descricao = $p_descricao;
		}
		else
		{
			throw new Exception("@lng[Descrição não informada]", 1020);
		}
	}
	
	
	public function __construct()
	{
		$this->codcaso = 0;
		$this->coditem = 0;
		$this->descricao = null;
	}
	
	
	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->descricao))
			{
				$sql  = "insert into mescasoobjetivos(CodCaso, Descricao) ";
				$sql .= "values(:pCodCaso, :pDescricao);";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
				
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
				$this->msg_erro = "@lng[Descrição não informada]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}
	}
	
	public function Atualiza()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->coditem))
			{
				if (isset($this->descricao))
				{
					$sql  = "update mescasoobjetivos set Descricao = :pDescricao ";
					$sql .= "where CodCaso = :pCodCaso and CodObjetivo = :pCodItem;";
					
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
					$cmd->bindParam(":pCodItem", $this->coditem, PDO::PARAM_INT);
					$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
					
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
					$this->msg_erro = "@lng[Descrição não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Item não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}
	}
	
	public function Deleta()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->coditem))
			{
				$sql  = "delete from mescasoobjetivos ";
				$sql .= "where CodCaso = :pCodCaso and CodObjetivo = :pCodItem;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodItem", $this->coditem, PDO::PARAM_INT);
				
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
				$this->msg_erro = "@lng[Item não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}
	}
	
	public function Carrega()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->coditem))
			{
				$sql  = "select CodCaso, CodObjetivo, Descricao ";
				$sql .= "from mescasoobjetivos where CodCaso = :pCodCaso and CodObjetivo = :pCodItem;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodItem", $this->coditem, PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					$rs = $cmd->fetch(PDO::FETCH_OBJ);
					
					$obj = new Objetivo();
					$obj->setCodcaso($rs->CodCaso);
					$obj->setCoditem($rs->CodObjetivo);
					$obj->setDescricao($rs->Descricao);
					
					return $obj;
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
				$this->msg_erro = "@lng[Item não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}	
	}
	
	public function Lista()
	{
		if (isset($this->codcaso))
		{
			$sql  = "select CodObjetivo, Descricao ";
			$sql .= "from mescasoobjetivos where CodCaso = :pCodCaso;";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$ret .= Comuns::TopoTabelaListagem(
						"Objetivos cadastrados",
						"tabobjetivos",
						array("Objetivo", "Ações")
					);
					
					while ($objetivo = $cmd->fetch(PDO::FETCH_OBJ))
					{
						$codigo = base64_encode($objetivo->CodObjetivo);
						$ret .= '<tr>';
						$ret .= '<td>' . $objetivo->Descricao . '</td>';
						$ret .= '<td>';
						$ret .= '<a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . $codigo . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
						$ret .= '<a href="javascript:void(0);" onclick="javascript:fntExcluiObjetivo(\'' . $codigo . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
						$ret = str_replace("##id##", "", $ret);
						$ret .= '</td>';
						$ret .= '</tr>';
					}
					$ret .= "</tbody></table>";
				}
				else
				{
					$ret = "@lng[Nenhum objetivo cadastrado]";
				}
				return $ret;
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
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}
	}

	public function ListaRecordSet()
	{
		$sql  = "select CodObjetivo, Descricao ";
		$sql .= "from mescasoobjetivos where CodCaso = :pCodCaso;";
		
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
				$this->msg_erro = "@lng[Nenhum objetivo cadastrado]";
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