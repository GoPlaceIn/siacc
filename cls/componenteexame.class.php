<?php
//--utf8_encode --
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class Componente
{
	private $codexame;
	private $codcomponente;
	private $descricao;
	
	private $msg_erro;
	
	public function getCodexame()
	{
		return $this->codexame;
	}
	
	public function getCodcomponente()
	{
		return $this->codcomponente;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	
	public function setCodexame($p_codexame)
	{
		if ((isset($p_codexame)) && (!is_null($p_codexame)))
		{
			$this->codexame = $p_codexame;
		}
		else
		{
			throw new Exception("@lng[Exame não informado]", 1000);
		}
	}
	
	public function setCodcomponente($p_codcomponente)
	{
		if ((isset($p_codcomponente)) && (!is_null($p_codcomponente)))
		{
			$this->codcomponente = $p_codcomponente;
		}
		else
		{
			throw new Exception("@lng[Código do componente não informado]", 1010);
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
			throw new Exception("@lng[Descrição do componente não informado]", 1020);
		}
	}

	
	public function __construct()
	{
		$this->codexame = 0;
		$this->codcomponente = 0;
		$this->descricao = 0;
	}

	
	/**
	 * Insere um Componente de um exame
	 * @return bool : true ou false
	 * */
	public function Insere()
	{
		if (isset($this->codexame))
		{
			if (isset($this->descricao))
			{
				$sql  = "insert into mestipoexamecomponente(CodExame, Descricao, Ordem) ";
				$sql .= "SELECT :pCodExame, :pDescricao, ";
				$sql .= "(SELECT IFNULL(MAX(Ordem), 0)+1 FROM mestipoexamecomponente WHERE CodExame = :pCodExame) ";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				
				$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
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
			$this->msg_erro = "@lng[Exame não informado]";
			return false;
		}
	}
	
	/**
	 * Altera um Componente de um exame
	 * @return bool : true ou false
	 * */
	public function Altera()
	{
		if (isset($this->codexame))
		{
			if (isset($this->codcomponente))
			{
				if (isset($this->descricao))
				{
					$sql  = "UPDATE mestipoexamecomponente ";
					$sql .= "SET Descricao = :pDescricao ";
					$sql .= "WHERE CodExame = :pCodExame AND Codigo = :pCodigo;";
			
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
					$cmd->bindParam(":pCodigo", $this->codcomponente, PDO::PARAM_INT);
					$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
					
					$cmd->execute();
					
					if ($cmd->errorCode() == Comuns::QUERY_OK)
					{
						return true;
					}
					else
					{
						$this->msg_erro = $cmd->errorInfo();
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
				$this->msg_erro = "@lng[Componente não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Exame não informado]";
			return false;
		}
	}
	
	/**
	 * Exclui um Componente de um exame
	 * @return bool : true ou false
	 * */
	public function Deleta()
	{
		if (isset($this->codexame))
		{
			if (isset($this->codcomponente))
			{
				$sql  = "delete from mestipoexamecomponente ";
				$sql .= "WHERE CodExame = :pCodExame AND Codigo = :pCodigo;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				
				$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
				$cmd->bindParam(":pCodigo", $this->codcomponente , PDO::PARAM_INT);
						
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					return true;
				}
				else
				{
					$this->msg_erro = $cmd->errorInfo();
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Componente não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Exame não informado]";
			return false;
		}
	}
	
	public function ReordenaComponente($seqCorreta)
	{
		try
		{
			$idsUnicos = explode(",", $seqCorreta);
			
			for($i = 0; $i < count($idsUnicos); $i++)
			{
				// Exclui a alternativa do banco de dados
				$sql  = "UPDATE mestipoexamecomponente ";
				$sql .= "SET Ordem = ".($i+1)." ";
				$sql .= "WHERE CodExame = :pCodExame AND Codigo = :pCodigo;";
	
				$cnn = Conexao2::getInstance();
	
				$q = $cnn->prepare($sql);
	
				$reg = explode("_",$idsUnicos[$i]);
				$q->bindParam(":pCodExame", base64_decode($reg[0]), PDO::PARAM_INT);
				$q->bindParam(":pCodigo", base64_decode($reg[1]), PDO::PARAM_INT);
	
				$q->execute();
				
				if ($q->errorCode() != Comuns::QUERY_OK)
				{
					$msg = $q->errorInfo();
					throw new Exception("Erro: " . $msg[2], 1002);
				}
				
				$q->closeCursor();
			}
			
			return true;
		}
		catch (PDOException $ex)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex->getMessage();
			return false;
		}
		catch (Exception $ex2)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex2->getMessage();
			return false;
		}
	}
	
	/**
	 * Retorna um array de objetos do tipo Componente com todos os componentes de um exame
	 * @return array : Componentes ou false
	 * */
	public function Lista()
	{
		$sql  = "SELECT CodExame, Codigo, Descricao ";
		$sql .= "FROM mestipoexamecomponente ";
		$sql .= "WHERE CodExame = :pCodExame ";
		$sql .= "ORDER BY Ordem;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
			return $rs;
		}
		else
		{
			$this->msg_erro = $cmd->errorInfo();
			return false;
		}
	}
	
	/**
	 * Retorna um objeto do tipo Componente com o registro selecionado
	 * @return objeto : Componente ou false
	 * */
	public function Carrega()
	{
		$sql  = "SELECT CodExame, Codigo, Descricao ";
		$sql .= "FROM mestipoexamecomponente ";
		$sql .= "WHERE CodExame = :pCodExame AND Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodigo", $this->codcomponente, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$comp = new Componente();
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			
			$comp->setCodexame($rs->CodExame);
			$comp->setCodcomponente($rs->Codigo);
			$comp->setDescricao($rs->Descricao);
			
			$cmd->closeCursor();
			
			return $comp;
		}
		else
		{
			$this->msg_erro = $cmd->errorInfo();
			return false;
		}
		
	}

	public static function ConsultaNomeComponente($codexame, $codcompo)
	{
		$sql  = "SELECT Descricao ";
		$sql .= "FROM mestipoexamecomponente ";
		$sql .= "WHERE CodExame = :pCodExame AND Codigo = :pCodCompo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCompo", $codcompo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			return $rs->Descricao;
		}
		else
		{
			$erro = $cmd->errorInfo();
			return $erro[2];
		}
	}
	
	public function PodeExcluir()
	{
		return true;
	}
}

?>