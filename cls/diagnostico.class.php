<?php
//--utf8_encode --
include_once 'cls/conexao.class.php';
include_once 'cls/simnao.class.php';
include_once 'inc/comuns.inc.php';


class Diagnostico
{
	private $codcaso;
	private $coddiagnostico;
	private $descricao;
	private $correto;
	private $justificativa;
	private $conteudoadicional;
	private $msg_erro;
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCoddiagnostico()
	{
		return $this->coddiagnostico;
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
			throw new Exception("@lng[Caso não informado]", 1000);
		}
	}
	
	public function setCoddiagnostico($p_coddiagnostico)
	{
		if ((isset($p_coddiagnostico)) && (!is_null($p_coddiagnostico)))
		{
			$this->coddiagnostico = $p_coddiagnostico;
		}
		else
		{
			throw new Exception("@lng[Diagnostico não informado]", 1010);
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
	
	public function setCorreto($p_correto)
	{
		if ((isset($p_correto)) && (!is_null($p_correto)))
		{
			$this->correto = $p_correto;
		}
		else
		{
			throw new Exception("@lng[Campo Correto não informado]", 1030);
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
		if ((isset($p_conteudoadicional)) && (!is_null($p_conteudoadicional)))
		{
			$this->conteudoadicional = $p_conteudoadicional;
		}
		else
		{
			throw new Exception("@lng[Complemento não informado]", 1050);
		}
	}
	
	
	public function __construct()
	{
		$this->codcaso = 0;
		$this->coddiagnostico = 0;
		$this->descricao = null;
		$this->correto = null;
		$this->justificativa = null;
		$this->conteudoadicional = null;
	}
	
	
	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->descricao))
			{
				if (isset($this->correto))
				{
					if (isset($this->justificativa))
					{
						$sql  = "insert into mescasodiagnostico(CodCaso, Descricao, Correto, Justificativa, ConteudoAdicional) ";
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
	
	public function Altera()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->coddiagnostico))
			{
				if (isset($this->descricao))
				{
					if (isset($this->correto))
					{
						if (isset($this->justificativa))
						{
							$sql  = "UPDATE mescasodiagnostico ";
							$sql .= "SET Descricao = :pDescricao, ";
							$sql .= "    Correto = :pCorreto, ";
							$sql .= "    Justificativa = :pJustificativa, ";
							$sql .= "    ConteudoAdicional = :pConteudoAdicional ";
							$sql .= "where CodCaso = :pCodCaso AND CodDiagnostico = :pCodDiagnostico;";
								
							$cnn = Conexao2::getInstance();
								
							$cmd = $cnn->prepare($sql);
								
							$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
							$cmd->bindParam(":pCorreto", $this->correto, PDO::PARAM_INT);
							$cmd->bindParam(":pJustificativa", $this->justificativa, PDO::PARAM_STR);
							$cmd->bindParam(":pConteudoAdicional", $this->conteudoadicional, PDO::PARAM_STR);
							$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
							$cmd->bindParam(":pCodDiagnostico", $this->coddiagnostico, PDO::PARAM_INT);
								
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
					$this->msg_erro = "@lng[Descrição não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Diagnóstico não informado]";
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
		$sql = "DELETE FROM mescasodiagnostico WHERE CodCaso = :pCodCaso AND CodDiagnostico = :pCodDiagnostico;";
			
		$cnn = Conexao2::getInstance();
			
		$cmd = $cnn->prepare($sql);
			
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodDiagnostico", $this->coddiagnostico, PDO::PARAM_INT);
			
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
	
	public function Carrega($codcaso, $coddiagnostico)
	{
		$sql  = "select  CodCaso ";
		$sql .= "		,CodDiagnostico ";
		$sql .= "		,Descricao ";
		$sql .= "		,Correto ";
		$sql .= "		,Justificativa ";
		$sql .= "		,ConteudoAdicional ";
		$sql .= "from mescasodiagnostico ";
		$sql .= "where CodCaso = :pCodCaso AND CodDiagnostico = :pCodDiagnostico;";
			
		$cnn = Conexao2::getInstance();
			
		$cmd = $cnn->prepare($sql);
			
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodDiagnostico", $coddiagnostico, PDO::PARAM_INT);
			
		$cmd->execute();
			
		if ($cmd->rowCount() > 0)
		{
			$diag = $cmd->fetch(PDO::FETCH_OBJ);
			$this->setCodcaso($diag->CodCaso);
			$this->setCoddiagnostico($diag->CodDiagnostico);
			$this->setDescricao($diag->Descricao);
			$this->setCorreto($diag->Correto);
			$this->setJustificativa($diag->Justificativa);
			if (!is_null($diag->ConteudoAdicional)) { $this->setConteudoadicional($diag->ConteudoAdicional); }
		}
	}
	
	public function Lista($codcaso)
	{
		$sql  = "select CodDiagnostico, Descricao, Correto, Justificativa, ConteudoAdicional ";
		$sql .= "from mescasodiagnostico diag ";
		$sql .= "where diag.CodCaso = :pCodCaso;";
			
		$cnn = Conexao2::getInstance();
			
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			
		$cmd->execute();
			
		if ($cmd->rowCount() > 0)
		{
			$tiporesp = Caso::BuscaConfiguracao($codcaso, "diagnosticos", "TipoResp");
			
			switch ($tiporesp)
			{
				case "CE":
					$labelResposta = "Correto";
					break;
				case "ORD":
					$labelResposta = "Chance";
					break;
			}
			
			$tabela = Comuns::TopoTabelaListagem(
				"Diagnósticos cadastradas", 
				"diags",
				array("Descrição", $labelResposta, "Ações")
			);

			while ($diagnostico = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$tabela .= '<tr>';
				$tabela .= '  <td>' . $diagnostico->Descricao . "</td>";
				$tabela .= '  <td>' . (($tiporesp == "CE") ? SimNao::Descreve($diagnostico->Correto) : $diagnostico->Correto) . "</td>";
				$tabela .= '  <td>';
				$tabela .= '    <a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . base64_encode($diagnostico->CodDiagnostico) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
				$tabela .= '    <a href="javascript:void(0);" onclick="javascript:fntDeletaDiagnostico(\'' . base64_encode($diagnostico->CodDiagnostico) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				$tabela .= '  </td>';
				$tabela = str_replace("##id##", "", $tabela);
					
				$tabela .= "</tr>";
			}

			$tabela .= "</tbody></table>";
		}
		else
		{
			$tabela = "@lng[Nenhum diagnóstico cadastrado até o momento]";
		}
		return $tabela;
	}

	public function ListaRecordSet($codcaso)
	{
		$sql  = "SELECT CodDiagnostico, Descricao, Correto, Justificativa, ConteudoAdicional ";
		$sql .= "FROM mescasodiagnostico WHERE CodCaso = :pCodCaso;";
		
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
		$sql  = "SELECT TextoDiagnosticos FROM mescaso ";
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
				return (is_null($per->TextoDiagnosticos) ? "" : $per->TextoDiagnosticos);
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
		$sql  = "UPDATE mescaso set TextoDiagnosticos = :pTexto ";
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
	
	public function ListaRelacoesDiagnostico($codcaso, $coddiagnostico)
	{
		if (Caso::ERespostaImediata($codcaso) == false)
		{
			$sql  = "select exa.CodExame, exa.Descricao ";
			$sql .= ",case when diag.CodDiagnostico is null then 0 else 1 end as TemRelacao ";
			$sql .= "from mescasoexames exa ";
			$sql .= "left outer join mesrelexamediagnostico diag ";
			$sql .= "			 on diag.CodCaso = exa.codCaso ";
			$sql .= "			and diag.CodExame = exa.CodExame ";
			$sql .= "			and diag.CodDiagnostico = :pCodDiagnostico ";
			$sql .= "where exa.CodCaso = :pCodCaso;";

			$cnn = Conexao2::getInstance();

			$cmd = $cnn->prepare($sql);

			$cmd->bindParam(":pCodDiagnostico", $coddiagnostico, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

			$cmd->execute();

			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$cont = 1;
					while ($exa = $cmd->fetch(PDO::FETCH_OBJ))
					{
						$checks .= '<input type="checkbox" name="chkExamesXDiagn[]" id="chkExamesXDiagn_' . $cont . '" value="' . base64_encode($exa->CodExame) . '" ' . (($exa->TemRelacao == 0) ? "": 'checked="checked"') . ' class="checkrels campo" />' . $exa->Descricao . '<br />';
						$cont++;
					}
				}
				else
				{
					$checks = "@lng[Nenhum exame cadastrado]";
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

	public function SalvaRelacoesDiagnostico(array $exames)
	{
		$sqlDel  = "DELETE FROM mesrelexamediagnostico ";
		$sqlDel .= "WHERE CodCaso = :pCodCaso AND CodDiagnostico = :pCodDiagnostico;";

		$cnn = Conexao2::getInstance();

		$cmdDel = $cnn->prepare($sqlDel);
		$cmdDel->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdDel->bindParam(":pCodDiagnostico", $this->coddiagnostico, PDO::PARAM_INT);

		$cmdDel->execute();

		if ($cmdDel->errorCode() == Comuns::QUERY_OK)
		{
			$sqlIns  = "insert into mesrelexamediagnostico(CodCaso, CodExame, CodDiagnostico) ";
			$sqlIns .= "values(:pCodCaso, :pCodExame, :pCodDiagnostico); ";

			foreach ($exames as $ex)
			{
				$cmdIns = $cnn->prepare($sqlIns);
				$cmdIns->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodDiagnostico", $this->coddiagnostico, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodExame", base64_decode($ex), PDO::PARAM_INT);
				
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
	
	public function getNDiagnosticos()
	{
		$sql  = "select case when count(coddiagnostico) is null then 0 else count(coddiagnostico) end as Diagnosticos ";
		$sql .= "from mescasodiagnostico where CodCaso = :pCodCaso";
		
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