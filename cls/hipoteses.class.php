<?php
//--utf8_encode --
include_once 'cls/conexao.class.php';
include_once 'cls/simnao.class.php';
include_once 'inc/comuns.inc.php';

class Hipoteses
{
	private $codcaso;
	private $codhipotese;
	private $descricao;
	private $correto;
	private $justificativa;
	private $conteudoadicional;

	private $msg_erro;

	// get's ------------------------------------------------------------
	public function getCodcaso()
	{
		return $this->codcaso;
	}

	public function getCodhipotese()
	{
		return $this->codhipotese;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getCorreto()
	{
		return $this->correto;
	}

	public function getJustificativa()
	{
		return $this->justificativa;
	}

	public function getConteudoadicional()
	{
		return $this->conteudoadicional;
	}

	public function getErro()
	{
		return $this->msg_erro;
	}
	// fim get's --------------------------------------------------------

	// set's ------------------------------------------------------------
	public function setCodcaso($p_codcaso)
	{
		if (isset($p_codcaso) && (! is_null($p_codcaso)))
		{
			$this->codcaso = $p_codcaso;
		}
		else
		{
			throw new Exception("@lng[O caso não foi informado]", 999);
		}
	}

	public function setCodhipotese($p_codhipotese)
	{
		$this->codhipotese = $p_codhipotese;
	}

	public function setDescricao($p_descricao)
	{
		if (isset($p_descricao) && (! is_null($p_descricao)))
		{
			$this->descricao = $p_descricao;
		}
		else
		{
			throw new Exception("@lng[A descrição é obrigatória]", 1000);
		}
	}

	public function setCorreto($p_correto)
	{
		if (isset($p_correto) && (! is_null($p_correto)))
		{
			$this->correto = $p_correto;
		}
		else
		{
			throw new Exception("@lng[Informe se esta hipótese diagnóstica está correta ou não]", 1001);
		}
	}

	public function setJustificativa($p_justificativa)
	{
		if (isset($p_justificativa) && (! is_null($p_justificativa)))
		{
			$this->justificativa = $p_justificativa;
		}
		else
		{
			throw new Exception("@lng[A justificativa é obrigatória]", 1002);
		}
	}

	public function setConteudoadicional($p_conteudoadicional)
	{
		$this->conteudoadicional = $p_conteudoadicional;
	}
	// fim set's --------------------------------------------------------

	// funções ----------------------------------------------------------
	public function Insere()
	{
		try
		{
			if (isset($this->codcaso))
			{
				if (isset($this->descricao))
				{
					if (isset($this->correto))
					{
						if (isset($this->justificativa))
						{
							$sql  = "insert into mescasohipotdiagn(CodCaso, Descricao, Correto, Justificativa, ConteudoAdicional) ";
							$sql .= "values(:pCodCaso, :pDescricao, :pCorreto, :pJustificativa, :pConteudoAdicional);";
								
							$cnn = Conexao2::getInstance();
								
							$cmd = $cnn->prepare($sql);
				
							$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
							$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
							$cmd->bindParam(":pCorreto", $this->correto, PDO::PARAM_INT);
							$cmd->bindParam(":pJustificativa", $this->justificativa, PDO::PARAM_STR);
							$cmd->bindParam(":pConteudoAdicional", $this->conteudoadicional, PDO::PARAM_STR);
								
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
							$this->msg_erro = "@lng[Justificativa não informada]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Campo Correto não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Descrição da hipótese não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Caso de estudo não informado]";
				return false;
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			return false;
		}
	}

	public function Atualiza()
	{
		try
		{
			if (isset($this->codcaso))
			{
				if (isset($this->descricao))
				{
					if (isset($this->correto))
					{
						if (isset($this->justificativa))
						{
							$sql  = "UPDATE mescasohipotdiagn ";
							$sql .= "SET Descricao = :pDescricao, ";
							$sql .= "    Correto = :pCorreto, ";
							$sql .= "    Justificativa = :pJustificativa, ";
							$sql .= "    ConteudoAdicional = :pConteudoAdicional ";
							$sql .= "where CodCaso = :pCodCaso AND CodHipotese = :pCodHipotese;";
								
							$cnn = Conexao2::getInstance();
								
							$cmd = $cnn->prepare($sql);
								
							$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
							$cmd->bindParam(":pCorreto", $this->correto, PDO::PARAM_INT);
							$cmd->bindParam(":pJustificativa", $this->justificativa, PDO::PARAM_STR);
							$cmd->bindParam(":pConteudoAdicional", $this->conteudoadicional, PDO::PARAM_STR);
							$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
							$cmd->bindParam(":pCodHipotese", $this->codhipotese, PDO::PARAM_INT);
								
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
							$this->msg_erro = "@lng[Justificativa não informada]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Campo Correto não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Descrição da hipótese não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Caso de estudo não informado]";
				return false;
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			return false;
		}
	}

	public function Deleta()
	{
		try
		{
			$sql = "DELETE FROM mescasohipotdiagn WHERE CodCaso = :pCodCaso AND CodHipotese = :pCodHipotese;";
				
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodHipotese", $this->codhipotese, PDO::PARAM_INT);
				
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
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			return false;
		}
	}

	public function Carrega($codcaso, $codhipotese)
	{
		try
		{
			$sql  = "select  CodCaso ";
			$sql .= "		,CodHipotese ";
			$sql .= "		,Descricao ";
			$sql .= "		,Correto ";
			$sql .= "		,Justificativa ";
			$sql .= "		,ConteudoAdicional ";
			$sql .= "from mescasohipotdiagn ";
			$sql .= "where CodCaso = :pCodCaso AND CodHipotese = :pCodHipotese;";
				
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodHipotese", $codhipotese, PDO::PARAM_INT);
				
			$cmd->execute();
				
			if ($cmd->rowCount() > 0)
			{
				$hip = $cmd->fetch(PDO::FETCH_OBJ);
				$this->setCodcaso($hip->CodCaso);
				$this->setCodhipotese($hip->CodHipotese);
				$this->setDescricao($hip->Descricao);
				$this->setCorreto($hip->Correto);
				$this->setJustificativa($hip->Justificativa);
				$this->setConteudoadicional($hip->ConteudoAdicional);
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			return false;
		}
	}

	public function ListaHipotesesCaso($codcaso)
	{
		try
		{
			$sql  = "select CodHipotese, Descricao, Correto, Justificativa, ConteudoAdicional ";
			$sql .= "from mescasohipotdiagn hip ";
			$sql .= "where hip.CodCaso = :pCodCaso;";
				
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
				
			$cmd->execute();
				
			if ($cmd->rowCount() > 0)
			{
				$tiporesp = Caso::BuscaConfiguracao($codcaso, "hipoteses", "TipoResp");
				
				switch ($tiporesp)
				{
					case "CE":
						$labelResposta = "Correto";
						break;
					case "ORD":
						$labelResposta = "Ordem de chance";
						break;
				}
				
				$tabela = Comuns::TopoTabelaListagem(
					"Hipóteses cadastradas", 
					"hipoteses",
					array("Nome", $labelResposta, "Ações")
				);

				while ($hipotese = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$tabela .= '<tr>';
					$tabela .= '  <td>' . $hipotese->Descricao . "</td>";
					$tabela .= '  <td>' . (($tiporesp == "CE") ? SimNao::Descreve($hipotese->Correto) : $hipotese->Correto) . "</td>";
					$tabela .= '  <td>';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . base64_encode($hipotese->CodHipotese) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntDeletaHipotese(\'' . base64_encode($hipotese->CodHipotese) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
					$tabela .= '  </td>';
					$tabela = str_replace("##id##", "", $tabela);
						
					$tabela .= "</tr>";
				}

				$tabela .= "</tbody></table>";
			}
			else
			{
				$tabela = "@lng[Nenhuma hipótese cadastrada até o momento]";
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			$tabela = $this->msg_erro;
		}

		header('Content-Type: text/html; charset=iso-8859-1');

		return $tabela;
	}

	public function ListaRecordSet($codcaso, $codgrupo = 0)
	{
		$sql  = "select CodHipotese, Descricao, Correto, Justificativa, ConteudoAdicional ";
		$sql .= "from mescasohipotdiagn hip ";
		$sql .= "where hip.CodCaso = :pCodCaso ";
		
		if ($codgrupo != 0)
		{
			$sql .= "and hip.Sequencia = " . $codgrupo . ";";
		}
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
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
	
	public function CarregaPerguntaNorteadora($codcaso)
	{
		$sql  = "SELECT TextoHipoteses FROM mescaso ";
		$sql .= "WHERE Codigo = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$per = $cmd->fetch(PDO::FETCH_OBJ);
				return (is_null($per->TextoHipoteses) ? "" : $per->TextoHipoteses);
			}
			else
			{
				return "";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function SalvaPerguntaNorteadora($codcaso, $texto)
	{
		$sql  = "UPDATE mescaso set TextoHipoteses = :pTexto ";
		$sql .= "WHERE Codigo = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pTexto", $texto, PDO::PARAM_STR);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
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

	public function getNHipoteses()
	{
		$sql  = "select case when count(codhipotese) is null then 0 else count(codhipotese) end as Hipoteses ";
		$sql .= "from mescasohipotdiagn where CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$ret = $cmd->fetchColumn();
			return $ret;
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