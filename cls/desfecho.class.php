<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class Desfecho
{
	private $codcaso;
	private $coddesfecho;
	private $titulo;
	private $desfecho;
	private $msg_erro;
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCoddesfecho()
	{
		return $this->coddesfecho;
	}
	
	public function getTitulo()
	{
		return $this->titulo;
	}
	
	public function getDesfecho()
	{
		return $this->desfecho;
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
			throw new Exception("@lng[Caso de estudo não informado]", 1000);
		}
	}
	
	public function setCoddesfecho($p_coddesfecho)
	{
		if ((isset($p_coddesfecho)) && (!is_null($p_coddesfecho)))
		{
			$this->coddesfecho = $p_coddesfecho;
		}
		else
		{
			throw new Exception("@lng[Desfecho não informado]", 1010);
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
	
	public function setDesfecho($p_desfecho)
	{
		if ((isset($p_desfecho)) && (!is_null($p_desfecho)))
		{
			$this->desfecho = $p_desfecho;
		}
		else
		{
			throw new Exception("@lng[Descrição não informada]", 1030);
		}
	}
	
	public function __construct()
	{
		$this->codcaso = 0;
		$this->coddesfecho = 0;
		$this->titulo = null;
		$this->desfecho = null;
		$this->msg_erro = null;
	}
	
	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->titulo))
			{
				if (isset($this->desfecho))
				{
					$sql  = "insert into mescasodesfecho(CodCaso, Titulo, Desfecho) ";
					$sql .= "values(:pCodCaso, :pTitulo, :pDesfecho);";
					
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
					$cmd->bindParam(":pTitulo", $this->titulo, PDO::PARAM_STR);
					$cmd->bindParam(":pDesfecho", $this->desfecho, PDO::PARAM_STR);
					
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
					$this->msg_erro = "@lng[Desfecho não informado]";
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
			if (isset($this->coddesfecho))
			{
				if (isset($this->titulo))
				{
					if (isset($this->desfecho))
					{
						$sql  = "update mescasodesfecho set Titulo = :pTitulo, Desfecho = :pDesfecho ";
						$sql .= "where CodCaso = :pCodCaso and CodDesfecho = :pCodDesfecho;";
						
						$cnn = Conexao2::getInstance();
						
						$cmd = $cnn->prepare($sql);
						$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pCodDesfecho", $this->coddesfecho, PDO::PARAM_INT);
						$cmd->bindParam(":pTitulo", $this->titulo, PDO::PARAM_STR);
						$cmd->bindParam(":pDesfecho", $this->desfecho, PDO::PARAM_STR);
						
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
						$this->msg_erro = "@lng[Desfecho não informado]";
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
				$this->msg_erro = "@lng[Desfecho não informado]";
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
			if (isset($this->coddesfecho))
			{
				$sql  = "delete from mescasodesfecho ";
				$sql .= "where CodCaso = :pCodCaso and CodDesfecho = :pCodeDesfecho;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodeDesfecho", $this->coddesfecho, PDO::PARAM_INT);
				
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
				$this->msg_erro = "@lng[Desfecho não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não informado]";
			return false;
		}
	}
	
	public function Carrega($codcaso, $coddesfecho)
	{
		$sql  = "select CodCaso, CodDesfecho, Titulo, Desfecho as DesDesfecho ";
		$sql .= "from mescasodesfecho ";
		$sql .= "where CodCaso = :pCodCaso AND CodDesfecho = :pCodDesfecho";

		$cnn = Conexao2::getInstance();
			
		$cmd = $cnn->prepare($sql);
			
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodDesfecho", $coddesfecho, PDO::PARAM_INT);
		
		$cmd->execute();
			
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$desfecho = $cmd->fetch(PDO::FETCH_OBJ);
				$this->setCodcaso($desfecho->CodCaso);
				$this->setCoddesfecho($desfecho->CodDesfecho);
				$this->setTitulo($desfecho->Titulo);
				$this->setDesfecho($desfecho->DesDesfecho);
				
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
	
	public function Lista($codcaso)
	{
		try
		{
			$sql  = "select CodCaso, CodDesfecho, ";
			$sql .= "case when length(Titulo) > 40 then concat(left(Titulo, 40), '...') else Titulo end as Desfecho ";
			$sql .= "from mescasodesfecho ";
			$sql .= "where CodCaso = :pCodCaso;";
			
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
				
			$cmd->execute();
				
			if ($cmd->rowCount() > 0)
			{
				$tabela = Comuns::TopoTabelaListagem(
					"Desfechos cadastrados", 
					"desfcad",
				array("Descrição", "Ações")
				);

				while ($desfecho = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$tabela .= '<tr>';
					$tabela .= '<td>' . $desfecho->Desfecho . "</td>";
					$tabela .= '<td>';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . base64_encode($desfecho->CodDesfecho) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntDeletaDesfecho(\'' . base64_encode($desfecho->CodDesfecho) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
					$tabela .= '</td>';
					$tabela = str_replace("##id##", "", $tabela);
						
					$tabela .= "</tr>";
				}

				$tabela .= "</tbody></table>";
			}
			else
			{
				$tabela = "@lng[Nenhum desfecho cadastrado até o momento]";
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
		$sql  = "select CodDesfecho, Titulo, Desfecho as DesDesfecho ";
		$sql .= "from mescasodesfecho ";
		$sql .= "where CodCaso = :pCodCaso";
		
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
		$sql  = "SELECT TextoDesfechos FROM mescaso ";
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
				return (is_null($per->TextoDesfechos) ? "" : $per->TextoDesfechos);
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
		$sql  = "UPDATE mescaso set TextoDesfechos = :pTexto ";
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

	public function ListaRelacoesDesfecho($codcaso, $coddesfecho)
	{
		if (Caso::ERespostaImediata($codcaso) == false)
		{
			$sql  = "select trat.CodTratamento, trat.Titulo ";
			$sql .= ",case when des.CodDesfecho is null then 0 else 1 end as TemRelacao ";
			$sql .= "from mescasotratamento trat ";
			$sql .= "left outer join mesreltratamentodesfecho des ";
			$sql .= "			 on des.CodCaso = trat.CodCaso ";
			$sql .= "			and des.CodTratamento = trat.CodTratamento ";
			$sql .= "			and des.CodDesfecho = :pCodDesfecho ";
			$sql .= "where trat.CodCaso = :pCodCaso;";

			$cnn = Conexao2::getInstance();

			$cmd = $cnn->prepare($sql);

			$cmd->bindParam(":pCodDesfecho", $coddesfecho, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

			$cmd->execute();

			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$cont = 1;
					while ($trat = $cmd->fetch(PDO::FETCH_OBJ))
					{
						$checks .= '<input type="checkbox" name="chkTratXDesf[]" id="chkTratXDesf_' . $cont . '" value="' . base64_encode($trat->CodTratamento) . '" ' . (($trat->TemRelacao == 0) ? "": 'checked="checked"') . ' class="checkrels campo" />' . $trat->Titulo . '<br />';
						$cont++;
					}
				}
				else
				{
					$checks = "@lng[Nenhum tratamento cadastrado]";
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
			$checks = "@lng[Este Caso de estudo é do tipo Feedback instantaneo e por isso não possui relações]";
			return $checks;
		}
	}

	public function SalvaRelacoesDesfecho(array $tratamentos)
	{
		$sqlDel  = "DELETE FROM mesreltratamentodesfecho ";
		$sqlDel .= "WHERE CodCaso = :pCodCaso AND CodDesfecho = :pCodDesfecho;";

		$cnn = Conexao2::getInstance();

		$cmdDel = $cnn->prepare($sqlDel);
		$cmdDel->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdDel->bindParam(":pCodDesfecho", $this->coddesfecho, PDO::PARAM_INT);

		$cmdDel->execute();

		if ($cmdDel->errorCode() == Comuns::QUERY_OK)
		{
			$sqlIns  = "insert into mesreltratamentodesfecho(CodCaso, CodTratamento, CodDesfecho) ";
			$sqlIns .= "values(:pCodCaso, :pCodTratamento, :pCodDesfecho); ";

			foreach ($tratamentos as $trat)
			{
				$cmdIns = $cnn->prepare($sqlIns);
				$cmdIns->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodTratamento", $this->codtratamento, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodDesfecho", base64_decode($trat), PDO::PARAM_INT);
				
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
}

?>