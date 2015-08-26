<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/log.class.php';

class ValorReferencia
{
	private $codexame;
	private $codcomponente;
	private $temagrup;
	private $agrupador;
	private $vlrminimo;
	private $vlrmaximo;
	private $unidmedida;
	private $tipo;
	
	private $msg_erro;
	
	
	public function getCodexame()
	{
		return $this->codexame;
	}
	
	public function getCodcomponente()
	{
		return $this->codcomponente;
	}
	
	public function getTemagrupador()
	{
		return $this->temagrup;
	}
	
	public function getAgrupador()
	{
		return $this->agrupador;
	}
	
	public function getVlrminimo()
	{
		return $this->vlrminimo;
	}
	
	public function getVlrmaximo()
	{
		return $this->vlrmaximo;
	}
	
	public function getUnidadeMedida()
	{
		return $this->unidmedida;
	}
	
	public function getTipo()
	{
		return $this->tipo;
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
			throw new Exception("@lng[Componente não informado]", 1010);
		}
	}
	
	public function setTemagrupador($p_temagrup)
	{
		if ((isset($p_temagrup)) && (!is_null($p_temagrup)))
		{
			$this->temagrup = $p_temagrup;
		}
		else
		{
			throw new Exception("@lng[Informe se tem ou não agrupador]", 1020);
		}
	}
	
	public function setAgrupador($p_agrupador)
	{
		if ((isset($p_agrupador)) && (!is_null($p_agrupador)))
		{
			$this->agrupador = $p_agrupador;
		}
		else
		{
			throw new Exception("@lng[Agrupador não informado]", 1020);
		}
	}
	
	public function setVlrminimo($p_vlrminimo)
	{
		if ((isset($p_vlrminimo)) && (!is_null($p_vlrminimo)))
		{
			$this->vlrminimo = $p_vlrminimo;
		}
		else
		{
			throw new Exception("@lng[Valor de referência mínimo não informado]", 1030);
		}
	}
	
	public function setVlrmaximo($p_vlrmaximo)
	{
		if ((isset($p_vlrmaximo)) && (!is_null($p_vlrmaximo)))
		{
			$this->vlrmaximo = $p_vlrmaximo;
		}
		else
		{
			throw new Exception("@lng[Valor de referência máximo não informado]", 1040);
		}
	}
	
	public function setUnidadeMedida($p_unidmedida)
	{
		if ((isset($p_unidmedida)) && (!is_null($p_unidmedida)))
		{
			$this->unidmedida = $p_unidmedida;
		}
		else
		{
			throw new Exception("@lng[Unidade de medida não informada]", 1050);
		}
	}
	
	public function setTipo($p_tipo)
	{
		if ((isset($p_tipo)) && (!is_null($p_tipo)))
		{
			$this->tipo = $p_tipo;
		}
		else
		{
			throw new Exception("@lng[Tipo não informado]", 1060);
		}
	}

	
	public function __construct()
	{
		$this->codexame = 0;
		$this->codcomponente = 0;
		$this->temagrup = null;
		$this->agrupador = null;
		$this->vlrminimo = null;
		$this->vlrmaximo = null;
		$this->tipo = null;
		$this->msg_erro = null;
	}

	
	/**
	 * Insere um Valor de referencia de um exame/componente
	 * @return bool : true ou false
	 * */
	public function Insere()
	{
		if (isset($this->codexame))
		{
			if (isset($this->codcomponente))
			{
				if (isset($this->temagrup))
				{
					$sql  = "insert into mestipoexamevalref(CodExame, CodComponente, TemAgrupador, Agrupador, Tipo, ValMin, ValMax, UnidadeMedida)";
					$sql .= "values(:pCodExame, :pCodComponente, :pTemAgrupador, :pAgrupador, :pTipo, :pValMin, :pValMax, :pUnidadeMedida);";
					
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
					$cmd->bindParam(":pCodComponente", $this->codcomponente, PDO::PARAM_INT);
					$cmd->bindParam(":pTemAgrupador", $this->temagrup, PDO::PARAM_INT);
					$cmd->bindParam(":pAgrupador", $this->agrupador, PDO::PARAM_STR);
					$cmd->bindParam(":pTipo", $this->tipo, PDO::PARAM_INT);
					$cmd->bindParam(":pValMin", $this->vlrminimo, PDO::PARAM_STR);
					$cmd->bindParam(":pValMax", $this->vlrmaximo, PDO::PARAM_STR);
					$cmd->bindParam(":pUnidadeMedida", $this->unidmedida, PDO::PARAM_STR);
					
					$cmd->execute();
					
					if ($cmd->errorCode() == Comuns::QUERY_OK)
					{
						Log::RegistraLog("Inserido valor de referência no exame " . $this->codexame . " componente " . $this->codcomponente . ".");
						return true;
					}
					else
					{
						Log::RegistraLog("Falha ao inserir valor de referência no exame " . $this->codexame . " componente " . $this->codcomponente . ".", true);
						$msg = $cmd->errorInfo();
						$this->msg_erro = $msg[2];
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Não foi informado se tem ou não agrupador]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Agrupador não informado. Caso não exista deve ser 0 (zero)]";
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
	 * Altera um Valor de referência de um exame/componente
	 * @return bool : true ou false
	 * */
	public function Altera()
	{
		if (isset($this->codexame))
		{
			if (isset($this->codcomponente))
			{
				if (isset($this->agrupador))
				{
					$sql  = "UPDATE mestipoexamevalref ";
					$sql .= "SET Tipo = :pTipo, ";
					$sql .= "	 ValMin = :pValMin, ";
					$sql .= "	 ValMax = :pValMax, ";
					$sql .= "	 UnidadeMedida = :pUnidadeMedida ";
					$sql .= "WHERE CodExame = :pCodExame ";
					$sql .= "  AND CodComponente = :pCodComponente ";
					$sql .= "  AND Agrupador = :pAgrupador;";
			
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
					$cmd->bindParam(":pCodComponente", $this->codcomponente, PDO::PARAM_INT);
					$cmd->bindParam(":pAgrupador", $this->agrupador, PDO::PARAM_STR);
					$cmd->bindParam(":pTipo", $this->tipo, PDO::PARAM_INT);
					$cmd->bindParam(":pValMin", $this->vlrminimo, PDO::PARAM_STR);
					$cmd->bindParam(":pValMax", $this->vlrmaximo, PDO::PARAM_STR);
					$cmd->bindParam(":pUnidadeMedida", $this->unidmedida, PDO::PARAM_STR);
													
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
					$this->msg_erro = "@lng[Não foi informado se tem ou não agrupador]";
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
	 * Exclui um Valor de referência de um exame/componente
	 * @return bool : true ou false
	 * */
	public function Deleta()
	{
		if (isset($this->codexame))
		{
			if (isset($this->codcomponente))
			{
				if (isset($this->agrupador))
				{
					$this->agrupador = ($this->agrupador == '--' ? '' : $this->agrupador);
					
					$sql  = "DELETE FROM mestipoexamevalref ";
					$sql .= "WHERE CodExame = :pCodExame ";
					$sql .= "  AND CodComponente = :pCodComponente ";
					$sql .= "  AND Agrupador = :pAgrupador;";
					
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
					$cmd->bindParam(":pCodComponente", $this->codcomponente, PDO::PARAM_INT);
					$cmd->bindParam(":pAgrupador", $this->agrupador, PDO::PARAM_STR);
											
					$cmd->execute();
					
					if ($cmd->errorCode() == Comuns::QUERY_OK)
					{
						Log::RegistraLog("Excluido valor de referência do exame " . $this->codexame . ", componente " . $this->codcomponente . " agrupador: " . $this->agrupador);
						return true;
					}
					else
					{
						$msg = $cmd->errorInfo();
						$this->msg_erro = $msg[2];
						Log::RegistraLog("Falha ao excluir valor de referência do exame " . $this->codexame . ", componente " . $this->codcomponente . " agrupador: " . $this->agrupador . ". Erro: " . $this->msg_erro, true);
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Agrupador não informado]";
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
	 * Retorna um array de objetos do tipo ValorReferencia com todos os valores de um exame/componente
	 * @return array : Valores ou false
	 * */
	public function Lista()
	{
		//$sql  = "select CodExame, CodComponente, Agrupador, ValMin, ValMax, UnidadeMedida ";
		//$sql .= "from mestipoexamevalref ";
		//$sql .= "where CodExame = :pCodExame AND CodComponente = :pCodComponente;";

		$sql  = "SELECT  CodExame, CodComponente ";
		$sql .= "		,CASE WHEN TemAgrupador = 1 then Agrupador else '--' end as Agrupador ";
		$sql .= "		,CASE WHEN Tipo = 1 THEN ";
		$sql .= "			CONCAT(Descricao, ' ', ValMin, ' e ', ValMax) ";
		$sql .= "		 ELSE ";
		$sql .= "			CASE WHEN Tipo = 4 THEN ";
		$sql .= "				ValMin ";
		$sql .= "			ELSE ";
		$sql .= "				CONCAT(Simbolo, ' ', CASE WHEN Tipo in(2,6) THEN ValMin ELSE ValMax END) ";
		$sql .= "			END ";
		$sql .= "		 END AS Descricao ";
		$sql .= "		,CASE WHEN ValMin IS NULL THEN '' ELSE ValMin END AS ValMin ";
		$sql .= "		,CASE WHEN ValMax IS NULL THEN '' ELSE ValMax END AS ValMax ";
		$sql .= "		,CASE WHEN UnidadeMedida IS NULL THEN '' ELSE UnidadeMedida END AS UnidadeMedida ";
		$sql .= "FROM mestipoexamevalref vr ";
		$sql .= "INNER JOIN mestipovalorreferencia tvr ";
		$sql .= "		on tvr.codigo = vr.tipo ";
		$sql .= "WHERE CodExame = :pCodExame ";
		$sql .= "  AND CodComponente = :pCodComponente ";
		$sql .= "ORDER BY TemAgrupador";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodComponente", $this->codcomponente, PDO::PARAM_INT);
		
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
	 * Retorna um objeto do tipo ValorReferencia com o registro selecionado
	 * @return objeto : ValorReferencia ou false
	 * */
	public function Carrega()
	{
		$sql  = "SELECT CodExame, CodComponente, TemAgrupador, Agrupador, Tipo, CASE WHEN ValMin IS NULL THEN '' ELSE ValMin END AS ValMin, CASE WHEN ValMax IS NULL THEN '' ELSE ValMax END AS ValMax, UnidadeMedida ";
		$sql .= "FROM mestipoexamevalref ";
		$sql .= "WHERE CodExame = :pCodExame AND CodComponente = :pCodComponente AND Agrupador = :pAgrupador;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodComponente", $this->codcomponente, PDO::PARAM_INT);
		$cmd->bindParam(":pAgrupador", $this->agrupador, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$vlr = new ValorReferencia();
			$rs = $cmd->fetch(PDO::FETCH_OBJ);

			$vlr->setCodexame($rs->CodExame);
			$vlr->setCodcomponente($rs->CodComponente);
			$vlr->setTemagrupador($rs->TemAgrupador);
			$vlr->setAgrupador($rs->Agrupador);
			$vlr->setTipo($rs->Tipo);
			$vlr->setVlrminimo($rs->ValMin);
			$vlr->setVlrmaximo($rs->ValMax);
			$vlr->setUnidadeMedida((is_null($rs->UnidadeMedida) ? '' : $rs->UnidadeMedida));
			
			$cmd->closeCursor();
			
			return $vlr;
		}
		else
		{
			$erro = $cmd->errorInfo();
			echo($erro[2]);
			return false;
		}
	}

	public function ExisteChave()
	{
		$sql  = "SELECT Agrupador FROM mestipoexamevalref ";
		$sql .= "WHERE CodExame = :pCodExame AND CodComponente = :pCodComponente AND Agrupador = :pAgrupador;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodComponente", $this->codcomponente, PDO::PARAM_INT);
		$cmd->bindParam(":pAgrupador", $this->agrupador, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function PodeExcluir()
	{
		return true;
	}
}

?>