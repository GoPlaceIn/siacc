<?php
//--utf8_encode --
include_once 'cls/conexao.class.php';
include_once 'cls/simnao.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/log.class.php';

class TipoExame
{
	private $codigo;
	private $descricao;
	private $metodo;
	private $condicao;
	private $informacoes;
	private $conservacao;
	private $temcomponentes;
	private $ativo;
	private $podeimg;
	private $podedoc;
	private $podeval;
	
	private $msg_erro;
	private $form;

	public function getCodigo()
	{
		return $this->codigo;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getMetodo()
	{
		return $this->metodo;
	}
	
	public function getCondicao()
	{
		return $this->condicao;
	}
	
	public function getInformacoes()
	{
		return $this->informacoes;
	}
	
	public function getConservacao()
	{
		return $this->conservacao;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function getTemComponentes()
	{
		return $this->temcomponentes;
	}
	
	public function getAtivo()
	{
		return $this->ativo;
	}
	
	public function getPodeImgs()
	{
		return $this->podeimg;
	}
	
	public function getPodeDocs()
	{
		return $this->podedoc;
	}
	
	public function getPodeVals()
	{
		return $this->podeval;
	}
	
	
	public function setCodigo($p_codigo)
	{
		if ((isset($p_codigo)) && (!is_null($p_codigo)))
		{
			$this->codigo = $p_codigo;
		}
		else
		{
			throw new Exception("@lng[Código não informado]", 1000);
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
			throw new Exception("@lng[Descrição não informada]", 1010);
		}
	}
	
	public function setMetodo($p_metodo)
	{
		if ((isset($p_metodo)) && (!is_null($p_metodo)))
		{
			$this->metodo = $p_metodo;
		}
		else
		{
			throw new Exception("@lng[Método não informado]", 1020);
		}
	}
	
	public function setCondicao($p_condicao)
	{
		if ((isset($p_condicao)) && (!is_null($p_condicao)))
		{
			$this->condicao = $p_condicao;
		}
		else
		{
			throw new Exception("@lng[Condição não informada]", 1030);
		}
	}
	
	public function setInformacoes($p_informacoes)
	{
		if ((isset($p_informacoes)) && (!is_null($p_informacoes)))
		{
			$this->informacoes = $p_informacoes;
		}
		else
		{
			throw new Exception("@lng[Informações não informadas]", 1040);
		}
	}
	
	public function setConservacao($p_conservacao)
	{
		if ((isset($p_conservacao)) && (!is_null($p_conservacao)))
		{
			$this->conservacao = $p_conservacao;
		}
		else
		{
			throw new Exception("@lng[Conservação não informada]", 1050);
		}
	}

	public function setComponentes($p_temcomponentes)
	{
		if ((isset($p_temcomponentes)) && (!is_null($p_temcomponentes)))
		{
			$this->temcomponentes = $p_temcomponentes;
		}
		else
		{
			throw new Exception("@lng[Informe se tem ou não componentes]", 1070);
		}
	}
	
	public function setAtivo($p_ativo)
	{
		if ((isset($p_ativo)) && (!is_null($p_ativo)))
		{
			$this->ativo = $p_ativo;
		}
		else
		{
			throw new Exception("@lng[Ativo não selecionado]", 1060);
		}
	}
	
	public function setPodeImgs($p_podeimgs)
	{
		$this->podeimg = $p_podeimgs;
	}
	
	public function setPodeDocs($p_podedocs)
	{
		$this->podedoc = $p_podedocs;
	}
	
	public function setPodeVals($p_podevals)
	{
		$this->podeval = $p_podevals;
	}
	
	
	public function __construct()
	{
		$this->codigo = 0;
		$this->descricao = null;
		$this->metodo = null;
		$this->condicao = null;
		$this->informacoes = null;
		$this->conservacao = null;
		$this->temcomponentes = 0;
		$this->ativo = 1;
		$this->podeimg = 1;
		$this->podedoc = 1;
		$this->podeval = 1;
		$this->form = 11;
	}
	
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de tipos de exames cadastrados";
				break;
			case "cadastro":
				$ret = "cadastro de tipos de exames";
		}
		
		return $ret;
	}
	
	// Funções de banco --------------------
	public function Inserir()
	{
		if (isset($this->descricao))
		{
			if (isset($this->temcomponentes))
			{
				$sql  = "INSERT INTO mestipoexame(Descricao, Metodo, Condicao, Informacoes, Conservacao, TemComponentes, Ativo, PermiteImagem, PermiteDocs, PermiteValores) ";
				$sql .= "VALUES(:pDescricao, :pMetodo, :pCondicao, :pInformacoes, :pConservacao, :pTemComponentes, :pAtivo, :pPermiteImagem, :pPermiteDocs, :pPermiteValores);";
				
				$cnn = Conexao2::getInstance();
				
				try
				{
					$cnn->beginTransaction();
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
					$cmd->bindParam(":pMetodo", $this->metodo, PDO::PARAM_STR);
					$cmd->bindParam(":pCondicao", $this->condicao, PDO::PARAM_STR);
					$cmd->bindParam(":pInformacoes", $this->informacoes, PDO::PARAM_STR);
					$cmd->bindParam(":pConservacao", $this->conservacao, PDO::PARAM_STR);
					$cmd->bindParam(":pTemComponentes", $this->temcomponentes, PDO::PARAM_INT);
					$cmd->bindParam(":pAtivo", $this->ativo, PDO::PARAM_INT);
					$cmd->bindParam(":pPermiteImagem", $this->podeimg, PDO::PARAM_INT);
					$cmd->bindParam(":pPermiteDocs", $this->podedoc, PDO::PARAM_INT);
					$cmd->bindParam(":pPermiteValores", $this->podeval, PDO::PARAM_INT);
					
					$cmd->execute();
					$codi = $cnn->lastInsertId();
					$cnn->commit();
					
					if ($cmd->errorCode() == "00000")
					{
						$this->codigo = $codi;
						return true;
					}
					else
					{
						$this->msg_erro = $cmd->errorCode();
						return false;
					}
				}
				catch (PDOException $ex)
				{
					$cnn->rollBack();
					$this->msg_erro = $ex->getMessage();
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Informe se o exame tem componentes ou não]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Descrição não informada]";
			return false;
		}
	}
	
	public function Alterar()
	{
		if ((isset($this->codigo)) && ($this->codigo != 0))
		{
			if (isset($this->descricao))
			{
				if (isset($this->temcomponentes))
				{
					$sql  = "UPDATE mestipoexame ";
					$sql .= "SET Descricao = :pDescricao, ";
					$sql .= "	 Metodo = :pMetodo, ";
					$sql .= "	 Condicao = :pCondicao, ";
					$sql .= "	 Informacoes = :pInformacoes, ";
					$sql .= "	 Conservacao = :pConservacao, ";
					$sql .= "	 TemComponentes = :pTemComponentes, ";
					$sql .= "	 Ativo = :pAtivo, ";
					$sql .= "	 PermiteImagem = :pPermiteImagem, ";
					$sql .= "	 PermiteDocs = :pPermiteDocs, ";
					$sql .= "	 PermiteValores = :pPermiteValores ";
					$sql .= "WHERE Codigo = :pCodigo;";
					
					$cnn = Conexao2::getInstance();
					
					$cmd = $cnn->prepare($sql);
					
					$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
					$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
					$cmd->bindParam(":pMetodo", $this->metodo, PDO::PARAM_STR);
					$cmd->bindParam(":pCondicao", $this->condicao, PDO::PARAM_STR);
					$cmd->bindParam(":pInformacoes", $this->informacoes, PDO::PARAM_STR);
					$cmd->bindParam(":pConservacao", $this->conservacao, PDO::PARAM_STR);
					$cmd->bindParam(":pTemComponentes", $this->temcomponentes, PDO::PARAM_INT);
					$cmd->bindParam(":pAtivo", $this->ativo, PDO::PARAM_INT);
					$cmd->bindParam(":pPermiteImagem", $this->podeimg, PDO::PARAM_INT);
					$cmd->bindParam(":pPermiteDocs", $this->podedoc, PDO::PARAM_INT);
					$cmd->bindParam(":pPermiteValores", $this->podeval, PDO::PARAM_INT);
					
					$cmd->execute();
					
					if ($cmd->errorCode() == "00000")
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
					$this->msg_erro = "@lng[Informe se o exame tem componentes ou não]";
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
			$this->msg_erro = "@lng[Código não informado]";
			return false;
		}
	}
	
	public function Deletar()
	{
		if ((isset($this->codigo)) && ($this->codigo != 9))
		{
			$sql  = "DELETE FROM mestipoexame ";
			$sql .= "WHERE Codigo = :pCodigo";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == "00000")
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
			$this->msg_erro = "@lng[O código não foi informado]";
			return false;
		}
	}

	public function Lista()
	{
		$sql  = "select Codigo, Descricao, Ativo, TemComponentes ";
		$sql .= "from mestipoexame ORDER BY Descricao";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		
		$ret = $cmd->fetchAll(PDO::FETCH_OBJ);
		return $ret;
	}
	
	public function ListaValoresReferencia($intTipoExame, $intCodComponente)
	{
		$sql  = "select ";
		$sql .= "	  v.tipo ";
		$sql .= "	, v.Agrupador ";
		$sql .= "	, v.UnidadeMedida ";
		$sql .= "	, case when v.tipo = 1 then ";
		$sql .= "			concat(tvr.Descricao, ' ', v.valmin, ' e ', v.valmax) ";
		$sql .= "		 else ";
		$sql .= "			case when v.tipo = 4 then ";
		$sql .= "				v.valmin ";
		$sql .= "			else ";
		$sql .= "				concat(Simbolo, ' ', case when v.tipo in(2, 6) then ValMin else ValMax end) ";
		$sql .= "			end ";
		$sql .= "		 end as Padrao ";
		$sql .= "	, IFNULL(c.Descricao, te.Descricao) AS Descricao ";
		$sql .= "from mestipoexamevalref v ";
		$sql .= "inner join mestipovalorreferencia tvr ";
		$sql .= "		on tvr.Codigo = v.Tipo ";
		$sql .= "inner join mestipoexame te ";
		$sql .= "		on te.Codigo = v.CodExame ";
		$sql .= "left outer join mestipoexamecomponente c ";
		$sql .= "			 on c.codexame = v.CodExame ";
		$sql .= "			and c.Codigo = v.CodComponente ";
		$sql .= "where v.CodExame = :pCodTipoExame ";
		$sql .= "  and v.CodComponente = :pCodComponente";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodTipoExame", $intTipoExame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodComponente", $intCodComponente, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "ZERO";
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
	
	public static function ConsultaNomeExame($codigo)
	{
		$sql  = "SELECT Descricao ";
		$sql .= "FROM mestipoexame ";
		$sql .= "WHERE Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			return $rs->Descricao;
		}
		else
		{
			$this->msg_erro = $cmd->errorInfo();
			return false;
		}
	}

	public function Carrega($cod = null)
	{
		if ($cod)
			$this->codigo = $cod;
		
		$sql = "SELECT Descricao, Metodo, Condicao, Informacoes, Conservacao, Ativo, TemComponentes, PermiteImagem, PermiteDocs, PermiteValores ";
		$sql .= "FROM mestipoexame WHERE Codigo = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$tipo = $cmd->fetch(PDO::FETCH_OBJ);
				$this->descricao = $tipo->Descricao;
				$this->metodo = $tipo->Metodo;
				$this->condicao = $tipo->Condicao;
				$this->informacoes = $tipo->Informacoes;
				$this->conservacao = $tipo->Conservacao;
				$this->ativo = $tipo->Ativo;
				$this->temcomponentes = $tipo->TemComponentes;
				$this->podeimg = $tipo->PermiteImagem;
				$this->podedoc = $tipo->PermiteDocs;
				$this->podeval = $tipo->PermiteValores;
				
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
	// Fim funções de banco ----------------
	
	
	// Funções de tela ---------------------
	public function ListaTabela($pagina = 1, $nporpagina = 10, $usu = null, $filtros = "")
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		
		$sql  = "select Codigo, Descricao, Ativo, TemComponentes ";
		$sql .= "from mestipoexame WHERE 1=1 " . $filtros . " ORDER BY Descricao LIMIT " . $ini . ", " . $nporpagina . ";";
		
		Log::RegistraLog($sql);
		
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->execute();

		if ($cmd->rowCount() > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Tipos de exames cadastrados",
				"exames",
				array('Descrição', 'Ativo', 'Ações')
			);
			
			while ($rs = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$cod = base64_encode($rs->Codigo);

				$ret .= '<tr>';
				$ret .= '  <td>' . $rs->Descricao . '</td>';

				if ($rs->Ativo == 1)
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAF\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_ATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}
				else
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAF\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_INATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}
				
				
				$ret .= '  <td>';
				$ret .= '    <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>';
				$ret = str_replace("##id##", "", $ret);

				if ($rs->TemComponentes == 1)
				{
					$ret .= '  <a href="javascript:void(0);" onclick="javascript:fntAbreComponentes(\'' . $cod . '\');">' . Comuns::IMG_ACAO_COMPONENTES . '</a>';
				}
				else
				{
					$ret .= '  <a href="javascript:void(0);" onclick="javascript:fntAbreValorRef(\'' . $cod . '\', \'' . base64_encode("0") . '\');">' . Comuns::IMG_ACAO_VALORES_REF . '</a>';
				}
				
				$ret .= '		<a href="javascript:void(0);" onclick="javascript:fntExcluiTipoExame(\'' . $cod . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				$ret .= '  </td>';
				$ret .= '</tr>';
			}
			
			$ret .= '  </tbody>';
			$ret .= '</table>';
			
			if ($filtros != "")
				$sqlCount = "SELECT COUNT(*) AS Registros FROM mestipoexame WHERE 1=1 " . $filtros . ";";
			else
				$sqlCount = null;
			
			$registros = Comuns::NRegistros("mestipoexame", $sqlCount);
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form, "fntNavegaTab", true);
			}
		}
		else
		{
			$ret = "@lng[Nenhum item cadastrado até o momento]";
		}
		
		return $ret;
	}	

	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$tpl = str_replace("<!--txtCodigo-->", "", $tpl);
			$tpl = str_replace("<!--txtDescricao-->", "", $tpl);
			$tpl = str_replace("<!--txtMetodo-->", "", $tpl);
			$tpl = str_replace("<!--txtCondicao-->", "", $tpl);
			$tpl = str_replace("<!--txtInformacoes-->", "", $tpl);
			$tpl = str_replace("<!--txtConservacao-->", "", $tpl);
			$tpl = str_replace("<!--selComponentes-->", SimNao::SelectSimNao(0), $tpl);
			$tpl = str_replace("<!--selAtivo-->", SimNao::SelectSimNao(1), $tpl);
			$tpl = str_replace("<!--chkImgs-->", "", $tpl);
			$tpl = str_replace("<!--chkDocs-->", "", $tpl);
			$tpl = str_replace("<!--chkVals-->", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de areas de conhecimento].";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql  = "SELECT Descricao, Metodo, Condicao, Informacoes, Conservacao, TemComponentes, 	Ativo, PermiteImagem, PermiteDocs, PermiteValores ";
			$sql .= "FROM mestipoexame WHERE Codigo = :pCodigo;";
				
			$cnn = Conexao2::getInstance();
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
			$cmd->execute();
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			if (count($rs) != 0)
			{
				$tpl = str_replace("<!--txtCodigo-->", $this->codigo, $tpl);
				$tpl = str_replace("<!--txtDescricao-->", $rs->Descricao, $tpl);
				$tpl = str_replace("<!--txtMetodo-->", $rs->Metodo, $tpl);
				$tpl = str_replace("<!--txtCondicao-->", $rs->Condicao, $tpl);
				$tpl = str_replace("<!--txtInformacoes-->", $rs->Informacoes, $tpl);
				$tpl = str_replace("<!--txtConservacao-->", $rs->Conservacao, $tpl);
				$tpl = str_replace("<!--selComponentes-->", SimNao::SelectSimNao($rs->TemComponentes), $tpl);
				$tpl = str_replace("<!--selAtivo-->", SimNao::SelectSimNao($rs->Ativo), $tpl);
				$tpl = str_replace("<!--chkImgs-->", $rs->PermiteImagem == 1 ? 'checked="checked"' : "" , $tpl);
				$tpl = str_replace("<!--chkDocs-->", $rs->PermiteDocs == 1 ? 'checked="checked"' : "", $tpl);
				$tpl = str_replace("<!--chkVals-->", $rs->PermiteValores == 1 ? 'checked="checked"' : "", $tpl);
			}
			else
			{
				echo("@lng[Registro não encontrado]");
			}
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de tipos de exame].";
		}
		return $tpl;
	}

	public static function RetornaSelect($sel = 0)
	{
		$exames = self::Lista();
		
		$opcoes = '<option value="">@lng[Selecione]</option>';
		foreach ($exames as $exame)
		{
			if ($exame->Ativo == 1)
			{
				if ($exame->Codigo != $sel)
				{
					$opcoes .= '<option value="' . $exame->Codigo . '">' . $exame->Descricao . '</option>';
				}
				else
				{
					$opcoes .= '<option selected value="' . $exame->Codigo . '">' . $exame->Descricao . '</option>';
				}
			}
		}
		
		return "opcoes:" . $opcoes;
		
		return $opcoes;
	}

	// Fim funções de tela -----------------
}

?>