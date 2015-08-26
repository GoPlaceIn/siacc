<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class Tratamento
{
	private $codcaso;
	private $codtratamento;
	private $titulo;
	private $descricao;
	private $correto;
	private $justificativa;
	private $conteudoadicional;
	private $msg_erro;
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCodtratamento()
	{
		return $this->codtratamento;
	}
	
	public function getTitulo()
	{
		return $this->titulo;
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
	
	
	public function setCodcaso($p_codcaso)
	{
		if ((isset($p_codcaso)) && (!is_null($p_codcaso)))
		{
			$this->codcaso = $p_codcaso;
		}
		else
		{
			throw new Exception("@lng[Caso não encontrado]", 1000);
		}
	}
	
	public function setCodtratamento($p_codtratamento)
	{
		if ((isset($p_codtratamento)) && (!is_null($p_codtratamento)))
		{
			$this->codtratamento = $p_codtratamento;
		}
		else
		{
			throw new Exception("@lng[Tratamento não informado]", 1010);
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
	
	public function setTitulo($p_titulo)
	{
		if ((isset($p_titulo)) && (!is_null($p_titulo)))
		{
			$this->titulo = $p_titulo;
		}
		else
		{
			throw new Exception("@lng[Título não informado]", 1020);
		}
	}
	
	public function setCorreto($p_correto)
	{
		if ((isset($p_correto)) && (!is_null($p_correto)))
		{
			$this->correto = $p_correto;
		}
		else
		{
			throw new Exception("@lng[Correto/incorreto não informado]", 1030);
		}
	}
	
	public function setJustificativa($p_justificativa)
	{
		if ((isset($p_justificativa)) && (!is_null($p_justificativa)))
		{
			$this->justificativa = $p_justificativa;
		}
		else
		{
			throw new Exception("@lng[Justificativa não informada]", 1040);
		}
	}
	
	public function setConteudoadicional($p_conteudoadicional)
	{
		$this->conteudoadicional = $p_conteudoadicional;
	}
	
	
	public function __construct()
	{
		$this->codcaso = 0;
		$this->codtratamento = 0;
		$this->descricao = null;
		$this->titulo = null;
		$this->correto = null;
		$this->justificativa = null;
		$this->conteudoadicional = null;
	}
	
	
	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->titulo))
			{
				if (isset($this->descricao))
				{
					if (isset($this->correto))
					{
						if (isset($this->justificativa))
						{
							$sql  = "insert into mescasotratamento(CodCaso, Titulo, Descricao, Correto, Justificativa, ConteudoAdicional) ";
							$sql .= "values(:pCodCaso, :pTitulo, :pDescricao, :pCorreto, :pJustificativa, :pConteudoAdicional);";
							
							$cnn = Conexao2::getInstance();
							
							$cmd = $cnn->prepare($sql);
							$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
							$cmd->bindParam(":pTitulo", $this->titulo, PDO::PARAM_STR);
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
						$this->msg_erro = "@lng[Correto/incorreto não informado]";
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
				$this->msg_erro = "@lng[Título não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não informado]";
			return false;
		}
	}
	
	public function Atualiza()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->codtratamento))
			{
				if (isset($this->titulo))
				{
					if (isset($this->descricao))
					{
						if (isset($this->correto))
						{
							if (isset($this->justificativa))
							{
								$sql  = "update mescasotratamento ";
								$sql .= "set Titulo = :pTitulo, Descricao = :pDescricao, Correto = :pCorreto, ";
								$sql .= "    Justificativa = :pJustificativa, ConteudoAdicional = :pConteudoAdicional ";
								$sql .= "where CodCaso = :pCodCaso and Codtratamento = :pCodTratamento;";
								
								$cnn = Conexao2::getInstance();
								
								$cmd = $cnn->prepare($sql);
								$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
								$cmd->bindParam(":pCodTratamento", $this->codtratamento, PDO::PARAM_INT);
								$cmd->bindParam(":pTitulo", $this->titulo, PDO::PARAM_STR);
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
							$this->msg_erro = "@lng[Correto/incorreto não informado]";
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
					$this->msg_erro = "@lng[Título não informado]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Tratamento não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não informado]";
			return false;
		}
	}
	
	public function Deleta()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->codtratamento))
			{
				$sql  = "delete from mescasotratamento ";
				$sql .= "where CodCaso = :pCodCaso and Codtratamento = :pCodTratamento;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodTratamento", $this->codtratamento, PDO::PARAM_INT);
				
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
				$this->msg_erro = "@lng[Tratamento não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não informado]";
			return false;
		}
	}
	
	public function Carrega($codcaso, $codtratamento)
	{
		try
		{
			$sql  = "select CodCaso, Codtratamento, Titulo, Descricao, Correto, Justificativa, ConteudoAdicional ";
			$sql .= "from mescasotratamento ";
			$sql .= "where CodCaso = :pCodCaso AND Codtratamento = :pCodTratamento;";

			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodTratamento", $codtratamento, PDO::PARAM_INT);
			
			$cmd->execute();
				
			if ($cmd->rowCount() > 0)
			{
				$tratamento = $cmd->fetch(PDO::FETCH_OBJ);
				$this->setCodcaso($tratamento->CodCaso);
				$this->setCodtratamento($tratamento->Codtratamento);
				$this->setTitulo($tratamento->Titulo);
				$this->setDescricao($tratamento->Descricao);
				$this->setCorreto($tratamento->Correto);
				$this->setJustificativa($tratamento->Justificativa);
				$this->setConteudoadicional($tratamento->ConteudoAdicional);
			}
		}
		catch(PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			return false;
		}
	}
	
	public function Lista($codcaso)
	{
		try
		{
			$sql  = "select CodCaso, CodTratamento, ";
			$sql .= "case when length(Titulo) > 75 then concat(left(Titulo, 75), '...') else Titulo end as Descricao, ";
			$sql .= "Correto, Justificativa, ConteudoAdicional ";
			$sql .= "from mescasotratamento ";
			$sql .= "where CodCaso = :pCodCaso;";
			
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
				
			$cmd->execute();
				
			if ($cmd->rowCount() > 0)
			{
				$tiporesp = Caso::BuscaConfiguracao($codcaso, "tratamentos", "TipoResp");
				
				switch ($tiporesp)
				{
					case "CE":
						$labelResposta = "@lng[Correto]";
						break;
					case "ORD":
						$labelResposta = "@lng[Indicação (ordem)]";
						break;
				}
				
				$tabela = Comuns::TopoTabelaListagem(
					"Tratamentos cadastrados", 
					"tratcad",
				array("Descrição", $labelResposta, "Ações")
				);

				while ($tratamento = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$tabela .= '<tr>';
					$tabela .= '  <td>' . $tratamento->Descricao . '</td>';
					$tabela .= '  <td>' . (($tiporesp == "CE") ? SimNao::Descreve($tratamento->Correto) : $tratamento->Correto) . '</td>';
					$tabela .= '  <td>';
					$tabela .= '    <a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . base64_encode($tratamento->CodTratamento) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
					$tabela .= '    <a href="javascript:void(0);" onclick="javascript:fntDeletaTratamento(\'' . base64_encode($tratamento->CodTratamento) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
					$tabela .= '  </td>';
					$tabela = str_replace("##id##", "", $tabela);
						
					$tabela .= "</tr>";
				}

				$tabela .= "</tbody></table>";
			}
			else
			{
				$tabela = "@lng[Nenhum tratamento cadastrado até o momento]";
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

	public function ListaRecordSet($codcaso)
	{
		$sql  = "SELECT CodTratamento, Titulo, Descricao, Correto, Justificativa, ConteudoAdicional ";
		$sql .= "FROM mescasotratamento WHERE CodCaso = :pCodCaso;";
		
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
		$sql  = "SELECT TextoTratamentos FROM mescaso ";
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
				return (is_null($per->TextoTratamentos) ? "" : $per->TextoTratamentos);
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
		$sql  = "UPDATE mescaso set TextoTratamentos = :pTexto ";
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

	public function ListaRelacoesTratamento($codcaso, $codtratamento)
	{
		if (Caso::ERespostaImediata($codcaso) == false)
		{
			$sql  = "select diag.CodDiagnostico, diag.Descricao ";
			$sql .= ",case when trat.CodTratamento is null then 0 else 1 end as TemRelacao ";
			$sql .= "from mescasodiagnostico diag ";
			$sql .= "left outer join mesreldiagnosticotratamento trat ";
			$sql .= "			 on trat.CodCaso = diag.CodCaso ";
			$sql .= "			and trat.CodDiagnostico = diag.CodDiagnostico ";
			$sql .= "			and trat.CodTratamento = :pCodTratamento ";
			$sql .= "where diag.CodCaso = :pCodCaso;";

			$cnn = Conexao2::getInstance();

			$cmd = $cnn->prepare($sql);

			$cmd->bindParam(":pCodTratamento", $codtratamento, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

			$cmd->execute();

			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$cont = 1;
					while ($diag = $cmd->fetch(PDO::FETCH_OBJ))
					{
						$checks .= '<input type="checkbox" name="chkDiagnXTrat[]" id="chkDiagnXTrat_' . $cont . '" value="' . base64_encode($diag->CodDiagnostico) . '" ' . (($diag->TemRelacao == 0) ? "": 'checked="checked"') . ' class="checkrels campo" />' . $diag->Descricao . '<br />';
						$cont++;
					}
				}
				else
				{
					$checks = "@lng[Nenhum diagnóstico cadastrado]";
				}
				return $checks;
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = $msg[2];
				return $this->msg_erro;
			}
		}
		else
		{
			$checks = "Este Caso de estudo é do tipo Feedback instantaneo e por isso não possui relações";
			return $checks;
		}
	}

	public function SalvaRelacoesTratamento(array $diagnosticos)
	{
		$sqlDel  = "DELETE FROM mesreldiagnosticotratamento ";
		$sqlDel .= "WHERE CodCaso = :pCodCaso AND CodTratamento = :pCodTratamento;";

		$cnn = Conexao2::getInstance();

		$cmdDel = $cnn->prepare($sqlDel);
		$cmdDel->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdDel->bindParam(":pCodTratamento", $this->codtratamento, PDO::PARAM_INT);

		$cmdDel->execute();

		if ($cmdDel->errorCode() == Comuns::QUERY_OK)
		{
			$sqlIns  = "insert into mesreldiagnosticotratamento(CodCaso, CodDiagnostico, CodTratamento) ";
			$sqlIns .= "values(:pCodCaso, :pCodDiagnostico, :pCodTratamento); ";

			foreach ($diagnosticos as $diag)
			{
				$cmdIns = $cnn->prepare($sqlIns);
				$cmdIns->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodTratamento", $this->codtratamento, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodDiagnostico", base64_decode($diag), PDO::PARAM_INT);
				
				$cmdIns->execute();

				if ($cmdIns->errorCode() == Comuns::QUERY_OK)
				{
					$cmdIns->closeCursor();
				}
				else
				{
					$msg = $cmdIns->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			return true;
		}
		else
		{
			$msg = $cmdIns->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function getNTratamentos()
	{
		$sql  = "select case when count(codtratamento) is null then 0 else count(codtratamento) end as Tratamentos ";
		$sql .= "from mescasotratamento where CodCaso = :pCodCaso";
		
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