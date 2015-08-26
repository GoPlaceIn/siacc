<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/log.class.php';

class Conteudo
{
	private $codcaso;
	private $codconteudo;
	private $descricao;
	private $texto;
	private $chave;
	private $dtcadastro;
	private $msg_erro;
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCodconteudo()
	{
		return $this->codconteudo;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getTexto()
	{
		return $this->texto;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function getChave()
	{
		return $this->chave;
	}
	
	public function getDtCadastro()
	{
		return $this->dtcadastro;
	}
	
	public function setCodcaso($p_codcaso)
	{
		if ((isset($p_codcaso)) && (!is_null($p_codcaso)))
		{
			$this->codcaso = $p_codcaso;
		}
		else
		{
			throw new Exception("@lng[Código do caso não informado]", 1000);
		}
	}
	
	public function setCodconteudo($p_codconteudo)
	{
		if ((isset($p_codconteudo)) && (!is_null($p_codconteudo)))
		{
			$this->codconteudo = $p_codconteudo;
		}
		else
		{
			throw new Exception("@lng[Código do conteúdo não informado]", 1010);
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
			throw new Exception("@lng[Descrição do conteúdo não informado]", 1020);
		}
	}
	
	public function setTexto($p_texto)
	{
		if ((isset($p_texto)) && (!is_null($p_texto)))
		{
			$this->texto = $p_texto;
		}
		else
		{
			throw new Exception("@lng[Texto do conteúdo não informado]", 1020);
		}
	}

	public function __construct()
	{
		$this->codcaso = 0;
		$this->codconteudo = 0;
		$this->descricao = null;
		$this->texto = null;
	}
	
	
	public function Insere()
	{
		if ($this->codcaso > 0)
		{
			if (isset($this->descricao))
			{
				if (isset($this->texto))
				{
					$sql  = "insert into mescasoconteudo(CodCaso, Descricao, Texto, Chave, DtCadastro) ";
					$sql .= "values(:pCodCaso, :pDescricao, :pTexto, :pChave, current_timestamp())";
					
					$chave = Comuns::CodigoUnico();
					
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
					$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
					$cmd->bindParam(":pTexto", $this->texto, PDO::PARAM_STR);
					$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
					
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
					$this->msg_erro = "@lng[Conteúdo não informado]";
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
			$this->msg_erro = "@lng[Código do caso de estudo não informado]";
			return false;
		}
	}
	
	public function Atualiza()
	{
		if ($this->codcaso > 0)
		{
			if ($this->codconteudo != 0)
			{
				if (isset($this->descricao))
				{
					if (isset($this->texto))
					{
						$sql  = "update mescasoconteudo ";
						$sql .= "set Descricao = :pDescricao, Texto = :pTexto ";
						$sql .= "where CodCaso = :pCodCaso and CodConteudo = :pCodConteudo;";
						
						$cnn = Conexao2::getInstance();
						
						$cmd = $cnn->prepare($sql);
						$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
						$cmd->bindParam(":pTexto", $this->texto, PDO::PARAM_STR);
						$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pCodConteudo", $this->codconteudo, PDO::PARAM_INT);
						
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
						$this->msg_erro = "@lng[Conteúdo não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Descrição do conteúdo não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Código do conteúdo não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código do caso de estudo não informado]";
			return false;
		}
	}
	
	public function Deleta()
	{
		if ($this->codcaso > 0)
		{
			if ($this->codconteudo != 0)
			{
				$sql  = "delete from mescasoconteudo ";
				$sql .= "where CodCaso = :pCodCaso and CodConteudo = :pCodConteudo;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodConteudo", $this->codconteudo, PDO::PARAM_INT);
				
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
				$this->msg_erro = "@lng[Código do conteúdo não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código do caso de estudo não informado]";
			return false;
		}
	}

	/**
	 * Retorna o conteúdo HTML cadastrado no banco de dados
	 * @param codcaso int <p>Código do caso de estudo</p>
	 * @param codconteudo mixed <p>Código do conteúdo ou chave do conteúdo</p>
	 * */
	public function Carrega($codcaso, $codconteudo)
	{
		if (is_numeric($codconteudo))
		{
			$sql  = "select CodCaso, CodConteudo, Descricao, Texto, Chave ";
			$sql .= "from mescasoconteudo ";
			$sql .= "where CodCaso = :pCodCaso and CodConteudo = :pCodConteudo;";
		}
		else
		{
			$sql  = "select CodCaso, CodConteudo, Descricao, Texto, Chave ";
			$sql .= "from mescasoconteudo ";
			$sql .= "where CodCaso = :pCodCaso and CodConteudo = (select CodConteudo from mescasoconteudo where Chave = :pCodConteudo and CodCaso = :pCodCaso);";
		}
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodConteudo", $codconteudo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$conte = $cmd->fetch(PDO::FETCH_OBJ);
				$this->setCodcaso($conte->CodCaso);
				$this->setCodconteudo($conte->CodConteudo);
				$this->setDescricao($conte->Descricao);
				$this->setTexto($conte->Texto);
				$this->chave = $conte->Chave;
				
				return true;
			}
			else
			{
				$this->msg_erro = "@lng[Registro não encontrado]";
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
		$sql  = "select CodCaso, CodConteudo, case when length(Descricao) > 100 then concat(left(Descricao, 100), '...') else Descricao end as Descricao, Chave, DtCadastro ";
		$sql .= "from mescasoconteudo ";
		$sql .= "where CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
			
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			
		$cmd->execute();
			
		if ($cmd->rowCount() > 0)
		{
			$tabela = Comuns::TopoTabelaListagem(
				"Hipertexto", 
				"contcad",
				array("Conteúdo", "Dt. Cadastro", "Ações")
			);

			while ($conteudo = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$tabela .= '<tr>';
				$tabela .= '<td>' . $conteudo->Descricao . '</td>';
				$tabela .= '<td width="150">' . date("d/m/Y H:i:s", strtotime($conteudo->DtCadastro)) . '</td>';
				$tabela .= '<td width="100">';
				$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . base64_encode($conteudo->CodConteudo) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
				$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntDeletaConteudosHipertexto(\'' . base64_encode($conteudo->CodConteudo) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				$tabela .= '</td>';
				$tabela = str_replace("##id##", "", $tabela);
					
				$tabela .= "</tr>";
			}

			$tabela .= "</tbody></table>";
		}
		
		$sql =  "SELECT m.CodCaso, m.CodMidia, m.Descricao, m.Complemento, m.CodTipo, tm.Descricao as TipoMidia, m.DtCadastro, m.url ";
		$sql .= "FROM mesmidia m INNER JOIN mestipomidia tm ON tm.CodTipo = m.CodTipo ";
		$sql .= "where CodCaso = :pCodCaso ORDER BY m.CodTipo, DtCadastro DESC;";
		
		$codtipo = 0;
		$tababerta = false;
		
		$cmd->closeCursor();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
			
		if ($cmd->rowCount() > 0)
		{
			$obj = new ReflectionClass("Comuns");
			
			while ($midia = $cmd->fetch(PDO::FETCH_OBJ))
			{
				if ($codtipo != $midia->CodTipo)
				{
					$codtipo = $midia->CodTipo;
					if ($tababerta == true)
					{
						$tabela .= "</tbody></table>";
						$tababerta = false; 
					}
					
					$tabela .= Comuns::TopoTabelaListagem(
						($midia->TipoMidia), 
						"contcad_" + $midia->CodTipo,
						array("Tipo", "Descrição", "Dt. Cadastro", "Ações")
					);
					$tababerta = true;
				}
				
				$icone = "IMG_MIDIA_" . strtoupper(Comuns::Limpa($midia->TipoMidia));
				
				$tabela .= '<tr>';
				$tabela .= '<td width="50">' . $obj->getConstant($icone) . '</td>';
				$tabela .= '<td>' . $midia->Descricao . '</td>';
				$tabela .= '<td width="150">' . date('d/m/Y H:i:s', strtotime($midia->DtCadastro)) . '</td>';
				$tabela .= '<td width="100">';
				$tabela .= '<a href="javascript:void(0);" onclick="fntAtualizaMidia(\'' . base64_encode($midia->CodMidia) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
				if(strtoupper($midia->TipoMidia) == "DOCUMENTO")
				{
					$tabela .= '<a href="' . $midia->url . '" target="_blank">';
				}
				else
				{
					$tabela .= '<a href="javascript:void(0);" onclick="';
					$tabela .= ((strtoupper($midia->TipoMidia) == "IMAGEM") ? 'fntViewImagem' : 'fntLoadMidia');
					$tabela .= '(\'' . base64_encode($midia->CodMidia) . '\');';
					$tabela .= '">';
				}
				$tabela .= Comuns::IMG_ACAO_VISUALIZAR . '</a>';
				$tabela .= '<a href="javascript:void(0);" onclick="fntRemoveMidia(\'' . base64_encode($midia->CodMidia) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				$tabela .= '</td>';
				$tabela .= '</tr>';
			}
			
			if ($tababerta == true)
			{
				$tabela .= "</tbody></table>";
			}
		}
		
		//else
		//{
		//	$tabela = "Nenhum conteúdo adicional cadastrado até o momento";
		//}
		
		return $tabela;
	}

	public function ListaRecordSet($codcaso)
	{
		$sql  = "select CodCaso, CodConteudo, case when length(Descricao) > 100 then concat(left(Descricao, 100), '...') else Descricao end as Descricao, Chave ";
		$sql .= "from mescasoconteudo ";
		$sql .= "where CodCaso = :pCodCaso;";
		
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
}

?>