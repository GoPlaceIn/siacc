<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/area.class.php';
include_once 'cls/hipoteses.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/examefisico.class.php';
include_once 'cls/tratamento.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/simnao.class.php';
include_once 'cls/components/hashtable.class.php';

class Caso
{
	private $codigo;
	private $nome;
	private $descricao;
	private $dtcadastro;
	private $codniveldif;
	private $codarea;
	private $objetivos;
	private $feedback;
	private $ativo;
	private $sexopac;
	private $idadepac;
	private $idpac;
	private $etnia;
	private $nomepac;
	private $imgpac;
	private $cid10;
	private $configs;
	private $codautor;
	private $publico;
	private $exigelogin;
	private $form;
	
	public $msg_erro;

	// get's ------------------------------------------------------------
	public function getCodigo()
	{
		return $this->codigo;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getDataCadastro()
	{
		return $this->dtcadastro;
	}

	public function getNivelDificuldade()
	{
		return $this->codniveldif;
	}

	public function getArea()
	{
		return $this->codarea;
	}

	public function getObjetivos()
	{
		return $this->objetivos;
	}

	public function getConfiguracoes($config)
	{
		if (array_key_exists($config, $this->configs))
		{
			return $this->configs[$config];
		}
		else
		{
			return null;
		}
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}

	public function getFeedback()
	{
		return $this->feedback;
	}

	public function getAtivo()
	{
		return $this->ativo;
	}
	
	public function getSexoPac()
	{
		return $this->sexopac;
	}
	
	public function getIdadePac()
	{
		return $this->idadepac;
	}
	
	public function getIdPac()
	{
		return $this->idpac;
	}
	
	public function getEtnia()
	{
		return $this->etnia;
	}
	
	public function getNomePaciente()
	{
		return $this->nomepac;
	}
	
	public function getImagemPaciente()
	{
		return $this->imgpac;
	}
	
	public function getCid10()
	{
		return $this->cid10;
	}
	
	public function getCodAutor()
	{
		return $this->codautor;
	}
	
	public function getPublico()
	{
		return $this->publico;
	}
	
	public function getExigeLogin()
	{
		return $this->exigelogin;
	}
	// fim get's --------------------------------------------------------

	// set's ------------------------------------------------------------
	public function setCodigo($c)
	{
		if (isset($c) && ($c != ""))
		{
			$this->codigo = $c;
		}
	}

	public function setNome($n)
	{
		if (isset($n) && ($n != ""))
		{
			$this->nome = $n;
		}
		else
		{
			throw new Exception("@lng[Nome obrigatório]", 1000);
		}
	}

	public function setDescricao($d)
	{
		if (isset($d) && ($d != ""))
		{
			$this->descricao = $d;
		}
	}

	public function setNivelDificuldade($n)
	{
		if (isset($n) && (! is_null($n)))
		{
			$this->codniveldif = $n;
		}
		else
		{
			throw new Exception("@lng[Nível de dificuldade obrigatório]", 1001);
		}
	}

	public function setArea($a)
	{
		if (isset($a) && (! is_null($a)))
		{
			$this->codarea = $a;
		}
		else
		{
			throw new Exception("@lng[Área de conhecimento obrigatória]", 1002);
		}
	}

	public function setObjetivos($p_objetivos)
	{
		$this->objetivos = $p_objetivos;
	}

	public function setFeedback($p_feedback)
	{
		if (isset($p_feedback) && (! is_null($p_feedback)))
		{
			$this->feedback = $p_feedback;
		}
		else
		{
			throw new Exception("@lng[Selecione a opção de feedback para o aluno]", 1003);
		}
	}

	public function setAtivo($p_ativo)
	{
		if (isset($p_ativo) && (! is_null($p_ativo)))
		{
			$this->ativo = $p_ativo;
		}
		else
		{
			throw new Exception("@lng[Ativo Sim ou Não obrigatório]", 1004);
		}
	}
	
	public function setSexoPac($p_sexo)
	{
		if ((isset($p_sexo)) && (! is_null($p_sexo)))
		{
			$this->sexopac = $p_sexo;
		}
		else
		{
			throw new Exception("@lng[Sexo não informado]", 1005);
		}
	}
	
	public function setIdadePac($p_idade)
	{
		if ((isset($p_idade)) && (! is_null($p_idade)))
		{
			$this->idadepac = $p_idade;
		}
		else
		{
			throw new Exception("@lng[Idade não informada]", 1006);
		}
	}
	
	public function setIdPac($p_id)
	{
		$this->idpac = $p_id;
	}
	
	public function setEtnia($p_etnia)
	{
		if ((isset($p_etnia)) && (! is_null($p_etnia)))
		{
			$this->etnia = $p_etnia;
		}
		else
		{
			throw new Exception("@lng[Etnia não informada]", 1007);
		}
	}
	
	public function setNomePaciente($p_nome)
	{
		$this->nomepac = $p_nome;
	}
	
	public function setImagemPaciente($p_imagem)
	{
		$this->imgpac = $p_imagem;
	}
	
	public function setCid10($p_cid)
	{
		$this->cid10 = $p_cid;
	}
	
	public function setConfiguracoes($p_config)
	{
		$this->configs = $p_config;
	}
	
	public function setCodAutor($p_codautor)
	{
		$this->codautor = $p_codautor;
	}
	
	public function setPublico($p_publico)
	{
		$this->publico = $p_publico;
	}
	
	public function setExigeLogin($p_exigelogin)
	{
		$this->exigelogin = $p_exigelogin;
	}
	// fim set's --------------------------------------------------------

	// funções ----------------------------------------------------------
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "lista de casos de estudo cadastrados";
				break;
		}
		
		return $ret;
	}
	
	public function Insere()
	{
		if (isset($this->nome))
		{
			if (isset($this->codniveldif))
			{
				if (isset($this->codarea))
				{
					if (isset($this->sexopac))
					{
						if (isset($this->idadepac))
						{
							if (isset($this->etnia))
							{
								$sql  = "INSERT INTO mescaso(Nome, Descricao, DtCadastro, CodNivelDif, CodArea, DaResposta, Ativo, Sexo, Idade, IDPaciente, Cid10, CodAutor, Publico, ExigeLogin, Etnia, NomePaciente, ImgPaciente) ";
								$sql .= "VALUES(:pNome, :pDescricao, current_timestamp(), :pCodNivelDif, :pCodArea, :pDaResposta, :pAtivo, :pSexo, :pIdade, :pIDPaciente, :pCid10, :pCodAutor, :pPublico, :pExigeLogin, :pEtnia, :pNomePaciente, :pImgPaciente);";
								
								$cnn = Conexao2::getInstance();
								
								try
								{
									$cnn->beginTransaction();
									$cmd = $cnn->prepare($sql);
			
									$cmd->bindParam(":pNome", $this->nome, PDO::PARAM_STR, 100);
									$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
									$cmd->bindParam(":pCodNivelDif", $this->codniveldif->getCodigo(), PDO::PARAM_INT);
									$cmd->bindParam(":pCodArea", $this->codarea->getCodigo(), PDO::PARAM_INT);
									$cmd->bindParam(":pDaResposta", $this->feedback, PDO::PARAM_INT);
									$cmd->bindParam(":pAtivo", $this->ativo, PDO::PARAM_INT);
									$cmd->bindParam(":pSexo", $this->sexopac, PDO::PARAM_STR);
									$cmd->bindParam(":pIdade", $this->idadepac, PDO::PARAM_INT);
									$cmd->bindParam(":pIDPaciente", $this->idpac, PDO::PARAM_STR);
									$cmd->bindParam(":pCid10", $this->cid10, PDO::PARAM_STR);
									$cmd->bindParam(":pCodAutor", $this->codautor, PDO::PARAM_INT);
									$cmd->bindParam(":pPublico", $this->publico, PDO::PARAM_INT);
									$cmd->bindParam(":pExigeLogin", $this->exigelogin, PDO::PARAM_INT);
									$cmd->bindParam(":pEtnia", $this->etnia, PDO::PARAM_INT);
									$cmd->bindParam(":pNomePaciente", $this->nomepac, PDO::PARAM_STR);
									$cmd->bindParam(":pImgPaciente", $this->imgpac, PDO::PARAM_INT);
									$cmd->execute();
									$codi = $cnn->lastInsertId();
									$cnn->commit();
									
									if ($cmd->errorCode() != Comuns::QUERY_OK)
									{
										return false;
									}
									else
									{
										$this->codigo = $codi;
										return true;
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
								$this->msg_erro = "@lng[Etnia do paciente não informada]";
								return false;
							}
						}
						else
						{
							$this->msg_erro = "@lng[Idade do paciente não informada]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Sexo não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Área de conhecimento não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Nível de dificuldade não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Nome do caso não informado]";
			return false;
		}
	}

	public function Deteta()
	{
		if (isset($this->codigo) && ($this->codigo != ""))
		{
			try
			{
				$sql = "DELETE FROM mescaso WHERE Codigo = :pCodigo;";

				$cnn = Conexao2::getInstance();

				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodigo", $this->codigo);
				$cmd->execute();

				return true;
			}
			catch (PDOException $ex)
			{
				$this->msg_erro = $ex->getMessage();
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código não informado]";
			return false;
		}
	}

	public function Atualiza()
	{
		if (isset($this->codigo) && ($this->codigo != ""))
		{
			if (isset($this->nome) && ($this->nome != ""))
			{
				if ($this->codarea != "")
				{
					if ($this->codniveldif != "")
					{
						if (isset($this->sexopac))
						{
							if (isset($this->idadepac))
							{
								if (isset($this->etnia))
								{
									$sql  = "UPDATE mescaso ";
									$sql .= "SET Nome = :pNome, ";
									$sql .= "    Descricao = :pDescricao, ";
									$sql .= "    CodNivelDif = :pCodNivelDif, ";
									$sql .= "    CodArea = :pCodArea, ";
									$sql .= "    DaResposta = :pDaResposta, ";
									$sql .= "    Ativo = :pAtivo, ";
									$sql .= "    Sexo = :pSexo, ";
									$sql .= "    Idade = :pIdade, ";
									$sql .= "    IDPaciente = :pIDPaciente, ";
									$sql .= "    Cid10 = :pCid10, ";
									$sql .= "    Publico = :pPublico, ";
									$sql .= "    ExigeLogin = :pExigeLogin, ";
									$sql .= "	 Etnia = :pEtnia, ";
									$sql .= "	 NomePaciente = :pNomePaciente, "; 
									$sql .= "	 ImgPaciente = :pImgPaciente ";
									$sql .= "WHERE Codigo = :pCodigo;";
										
									$cnn = Conexao2::getInstance();
										
									$cmd = $cnn->prepare($sql);
										
									$cmd->bindParam(":pNome", $this->nome, PDO::PARAM_STR);
									$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
									$cmd->bindParam(":pCodNivelDif", $this->codniveldif->getCodigo(), PDO::PARAM_INT);
									$cmd->bindParam(":pCodArea", $this->codarea->getCodigo(), PDO::PARAM_INT);
									$cmd->bindParam(":pDaResposta", $this->feedback, PDO::PARAM_INT);
									$cmd->bindParam(":pAtivo", $this->ativo, PDO::PARAM_INT);
									$cmd->bindParam(":pSexo", $this->sexopac, PDO::PARAM_STR);
									$cmd->bindParam(":pIdade", $this->idadepac, PDO::PARAM_INT);
									$cmd->bindParam(":pIDPaciente", $this->idpac, PDO::PARAM_STR);
									$cmd->bindParam(":pCid10", $this->cid10, PDO::PARAM_STR);
									$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
									$cmd->bindParam(":pPublico", $this->publico, PDO::PARAM_INT);
									$cmd->bindParam(":pExigeLogin", $this->exigelogin, PDO::PARAM_INT);
									$cmd->bindParam(":pEtnia", $this->etnia, PDO::PARAM_INT);
									$cmd->bindParam(":pNomePaciente", $this->nomepac, PDO::PARAM_STR);
									$cmd->bindParam(":pImgPaciente", $this->imgpac, PDO::PARAM_INT);
									
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
									$this->msg_erro = "@lng[Etnia não informada]";
									return false;
								}
							}
							else
							{
								$this->msg_erro = "@lng[Idade não informada]";
								return false;
							}
						}
						else
						{
							$this->msg_erro = "@lng[Sexo não informado]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Nível de dificuldade não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Área de conhecimento não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Nome não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código não foi informado]";
			return false;
		}
	}

	public function __construct()
	{
		$this->codigo = 0;
		$this->nome = null;
		$this->descricao = null;
		$this->dtcadastro = null;
		$this->codniveldif = 0;
		$this->codarea = 0;
		$this->etnia = null;
		$this->imgpac = null;
		$this->nomepac = null;
		$this->cid10 = null;
		$this->form = 10;
	}

	public function CarregarCaso()
	{
		if ($this->codigo != 0)
		{
			$sql  = "SELECT Codigo, Nome, Descricao, DtCadastro, CodNivelDif, CodArea, DaResposta, Ativo, Sexo, Idade, ";
			$sql .= "		IDPaciente, Cid10, CodAutor, Publico, Etnia, NomePaciente, ImgPaciente, ExigeLogin ";
			$sql .= "FROM mescaso WHERE Codigo = :pCodigo;";
				
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
				
			$cmd->execute();
				
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
				
			if (count($rs) > 0)
			{
				$this->nome = $rs->Nome;
				$this->descricao = $rs->Descricao;
				$this->dtcadastro = $rs->DtCadastro;
				$this->codniveldif = NivelPergunta::RetornaNivel($rs->CodNivelDif);
				$this->codarea = AreaConhecimento::RetornaArea($rs->CodArea);
				$this->feedback = $rs->DaResposta;
				$this->ativo = $rs->Ativo;
				$this->sexopac = $rs->Sexo;
				$this->idadepac = $rs->Idade;
				$this->idpac = $rs->IDPaciente;
				$this->cid10 = $rs->Cid10;
				$this->codautor = $rs->CodAutor;
				$this->publico = $rs->Publico;
				$this->etnia = $rs->Etnia;
				$this->nomepac = $rs->NomePaciente;
				$this->imgpac = $rs->ImgPaciente;
				$this->exigelogin = $rs->ExigeLogin;
				
				$sqlconfigs  = "SELECT CONCAT(secao, '_', configuracao) as Configuracao, Valor ";
				$sqlconfigs .= "FROM mescasoconfigs conf WHERE CodCaso = :pCodCaso;";
				
				$cmdconfigs = $cnn->prepare($sqlconfigs);
				$cmdconfigs->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
				
				$cmdconfigs->execute();
				
				while ($rsconfigs = $cmdconfigs->fetch(PDO::FETCH_OBJ))
				{
					$this->configs[$rsconfigs->Configuracao] = $rsconfigs->Valor;
				}
				
				$cmdconfigs->closeCursor();
				$cmd->closeCursor();
			}
		}
	}

	public function ListaTabela($pagina = 1, $nporpagina = 10, $usuario = "", $filtros = "")
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);

		$sql  = "select  c.Codigo ";
		$sql .= "		,c.Nome ";
		$sql .= "		,c.Descricao ";
		$sql .= "		,concat(c.CodArea, ' - ', a.Descricao) as AreaConhecimento ";
		$sql .= "		,n.Descricao as Dificuldade ";
		$sql .= "		,c.DaResposta ";
		$sql .= "		,c.Ativo ";
		$sql .= "from mescaso c ";
		$sql .= "inner join mesnivelpergunta n ";
		$sql .= "		on n.Codigo = c.CodNivelDif ";
		$sql .= "inner join mesarea a ";
		$sql .= "		on a.Codigo = c.CodArea ";
		$sql .= "where c.Excluido = 0 " . $filtros;
		
		$sqlcount = "select COUNT(*) FROM mescaso c where c.Excluido = 0 " . $filtros;
		
		if($usuario != "")
		{
			$usuario = unserialize($usuario);
			$isAdmin = $usuario->TemGrupo(1); /* Verifica se tem permissão de Administrador */
			
			$sql .= "  AND (c.Publico = 1 ";
			$sql .= "	OR (c.Publico = 0 AND c.CodAutor = " . $usuario->getCodigo() . ") ";
			$sql .= "	OR c.Codigo IN (SELECT CodCaso FROM mescasocolaborador mcol WHERE mcol.CodUsuario = " . $usuario->getCodigo() . ") ";
			$sql .= $isAdmin ? "   OR c.Codigo = c.Codigo) " : ")";

			$sqlcount .= "  AND (c.Publico = 1 ";
			$sqlcount .= "	 OR (c.Publico = 0 AND c.CodAutor = " . $usuario->getCodigo() . ") ";
			$sqlcount .= "	 OR c.Codigo IN (SELECT CodCaso FROM mescasocolaborador mcol WHERE mcol.CodUsuario = " . $usuario->getCodigo() . ") ";
			$sqlcount .= $isAdmin ? "   OR c.Codigo = c.Codigo) " : ")";
		}
		
		$sql .= "LIMIT " . $ini . ", " . $nporpagina . ";";

		Log::RegistraLog("Comando SQL: " . $sql);
		
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->execute();

		if ($cmd->rowCount() > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Casos de estudo cadastrados",
				"casos",
			array('Nome', 'Descrição', 'Área de conhecimento', 'Nível Dif.', 'Ativo', 'Ações')
			);
				
			while ($rs = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$cod = base64_encode($rs->Codigo);

				$ret .= '<tr>';
				$ret .= '  <td>' . $rs->Nome . '</td>';
				$ret .= '  <td>' . $rs->Descricao . '</td>';
				$ret .= '  <td>' . $rs->AreaConhecimento . '</td>';
				$ret .= '  <td>' . $rs->Dificuldade . '</td>';
				//$ret .= '  <td>' . SimNao::Descreve($rs->DaResposta) . '</td>';

				if ($rs->Ativo == 1)
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAE\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_ATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}
				else
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAE\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_INATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}

				$ret .= '  <td><a href="vwcaso.php?cod=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a></td>';
				$ret = str_replace("##id##", "", $ret);

				$ret .= '</tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
			
			$registros = Comuns::NRegistros("mescaso", $sqlcount);
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
	
	public function SalvaExercicios(array $exerc)
	{
		$sqldel  = "DELETE FROM mescasoperguntas ";
		$sqldel .= "WHERE CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmddel = $cnn->prepare($sqldel);
		$cmddel->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmddel->execute();
		
		if ($cmddel->errorCode() == Comuns::QUERY_OK)
		{
			$sql  = "INSERT INTO mescasoperguntas(CodCaso, CodPergunta) ";
			$sql .= "VALUES(:pCodCaso, :pCodPergunta);";
			
			$cnn = Conexao2::getInstance();
			
			foreach ($exerc as $exe)
			{
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
				$cmd->bindParam(":pCodPergunta", base64_decode($exe), PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					$cmd->closeCursor();
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function SalvaAgrupamentos(array $agrups)
	{
		$sqldel  = "DELETE FROM mescasoagrupamentos ";
		$sqldel .= "WHERE CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmddel = $cnn->prepare($sqldel);
		$cmddel->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmddel->execute();
		
		if ($cmddel->errorCode() == Comuns::QUERY_OK)
		{
			$sql  = "INSERT INTO mescasoagrupamentos(CodCaso, CodAgrupamento) ";
			$sql .= "VALUES(:pCodCaso, :pCodAgrupamento);";
			
			$cnn = Conexao2::getInstance();
			
			foreach ($agrups as $agru)
			{
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
				$cmd->bindParam(":pCodAgrupamento", base64_decode($agru), PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					$cmd->closeCursor();
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public static function RetornaArrayExercicios($codcaso)
	{
		$sql  = "SELECT CodPergunta FROM mescasoperguntas ";
		$sql .= "WHERE CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$perguntas = null;
			while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$perguntas[] = $linha->CodPergunta;
			}
			
			return $perguntas;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public static function RetornaArrayAgrupadores($codcaso)
	{
		$sql  = "SELECT CodAgrupamento FROM mescasoagrupamentos ";
		$sql .= "WHERE CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$agrups = null;
			while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$agrups[] = $linha->CodAgrupamento;
			}
			
			return $agrups;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	private function jaOrdenado($codcaso)
	{
		$sql  = "SELECT 1 AS Ja FROM mescasoordenacao ";
		$sql .= "WHERE CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
				return true;
			else
				return false;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function CarregaMontagem($codcaso)
	{
		if ($this->jaOrdenado($codcaso))
		{
			$sql .= "select Itens.Prefixo, Itens.Chave, Itens.Item, Itens.Fixo, Itens.OrdemFixo, Itens.Padrao from( ";
			$sql .= "select ch.*  ";
			$sql .= "from meschavesitens ch where Padrao = 1 and Prefixo NOT IN('EXA','HIP') ";
			$sql .= "union ";
			$sql .= "select 'EXE' AS Prefixo, pe.Chave, concat('Exercício - ', pete.Texto) as Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mespergunta pe  ";
			$sql .= "inner join mesperguntatexto pete "; 
			$sql .= "		on pete.CodPergunta = pe.Codigo ";
			$sql .= "	   and pete.Linha = 1 ";
			$sql .= "inner join mescasoperguntas cape ";
			$sql .= "		on cape.CodPergunta = pe.Codigo ";
			$sql .= "	   and cape.CodCaso = :pCodCaso ";
			$sql .= "UNION ";
			$sql .= "select 'AGR' as Prefixo, peag.Chave, concat('Agrupadores - ', peag.Texto) as Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mesperguntaagrupador peag ";
			$sql .= "inner join mescasoagrupamentos caag ";
			$sql .= "		on caag.CodAgrupamento = peag.Codigo ";
			$sql .= "	   and caag.CodCaso = :pCodCaso ";
			$sql .= "UNION ";
			$sql .= "select 'CON' AS Prefixo, co.Chave, concat('Conteúdo - ', co.Descricao) as Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mescasoconteudo co ";
			$sql .= "where CodCaso = :pCodCaso AND NaoExibeNaMontagem = 0 ";
			$sql .= "UNION ";
			$sql .= "select 'EXA' as Prefixo, ech.Chave, case when ech.TipoRegistro = 1 then ";
			$sql .= "			concat('Exames - ', ech.NumBateria, 'ª bateria: opções') ";
			$sql .= "		 else case when ech.CodExame = -1 then ";
			$sql .= "		    concat('Exames - ', ech.NumBateria, 'ª bateria: resultado') ";
			$sql .= "		 else concat('Exame - ', ex.Descricao, ' (', ech.NumBateria, 'ª bat.): resultado') end end as Texto, 0 as Fixo, ";
			$sql .= "			0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mescasoexameschaves ech ";
			$sql .= "left join mescasoexames ex ";
			$sql .= "		on ex.CodCaso = ech.CodCaso ";
			$sql .= "	   and ex.CodExame = ech.CodExame ";
			$sql .= "where ech.CodCaso = :pCodCaso ";
			$sql .= "UNION ";
			$sql .= "SELECT DISTINCT 'HIP' as Prefixo, Chave ";
			$sql .= "		,CONCAT('Hipóteses - ', Texto), 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "FROM mescasohipotdiagnperguntaguia hipperg ";
			$sql .= "WHERE hipperg.codcaso = :pCodCaso";
			$sql .= ") Itens ";
			$sql .= "left outer join mescasoordenacao o ";
			$sql .= "			 on o.Prefixo = Itens.Prefixo ";
			$sql .= "			and o.Chave = Itens.Chave ";
			$sql .= "			and o.CodCaso = :pCodCaso ";
			$sql .= "order by o.Ordem ";
		}
		else
		{
			$sql .= "select Prefixo, Chave, Item, Fixo, OrdemFixo, Padrao from( ";
			$sql .= "select ch.*  ";
			$sql .= "from meschavesitens ch where Padrao = 1 AND Prefixo NOT IN('EXA','HIP') ";
			$sql .= "union ";
			$sql .= "select 'EXE' AS Prefixo, pe.Chave, concat('Exercício - ', pete.Texto) as Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mespergunta pe ";
			$sql .= "inner join mesperguntatexto pete "; 
			$sql .= "		on pete.CodPergunta = pe.Codigo ";
			$sql .= "	   and pete.Linha = 1 ";
			$sql .= "inner join mescasoperguntas cape ";
			$sql .= "		on cape.CodPergunta = pe.Codigo ";
			$sql .= "	   and cape.CodCaso = :pCodCaso ";
			$sql .= "union ";
			$sql .= "select 'AGR' as Prefixo, peag.Chave, concat('Agrupadores - ', peag.Texto) as Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mesperguntaagrupador peag ";
			$sql .= "inner join mescasoagrupamentos caag ";
			$sql .= "		on caag.CodAgrupamento = peag.Codigo ";
			$sql .= "	   and caag.CodCaso = :pCodCaso ";
			$sql .= "union ";
			$sql .= "select 'EXA' as Prefixo, ech.Chave, case when ech.TipoRegistro = 1 then ";
			$sql .= "			concat('Exames - ', ech.NumBateria, 'ª bateria: opções') ";
			$sql .= "		 else case when ech.CodExame = -1 then ";
			$sql .= "		    concat('Exames - ', ech.NumBateria, 'ª bateria: resultados') ";
			$sql .= "		 else concat('Exame - ', ex.Descricao, ' (', ech.NumBateria, 'ª bat.): resultado') end end as Texto, 0 as Fixo, ";
			$sql .= "			0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mescasoexameschaves ech ";
			$sql .= "left join mescasoexames ex ";
			$sql .= "		on ex.CodCaso = ech.CodCaso ";
			$sql .= "	   and ex.CodExame = ech.CodExame ";
			$sql .= "where ech.CodCaso = :pCodCaso ";
			$sql .= "union ";
			$sql .= "select 'CON' AS Prefixo, co.Chave, concat('Conteúdo - ', co.Descricao) as Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "from mescasoconteudo co ";
			$sql .= "where CodCaso = :pCodCaso AND NaoExibeNaMontagem = 0 ";
			$sql .= "UNION ";
			$sql .= "SELECT DISTINCT 'HIP' as Prefixo, Chave ";
			$sql .= "		,CONCAT('Hipóteses - ', Texto) as Item, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao ";
			$sql .= "FROM mescasohipotdiagnperguntaguia hipperg ";
			$sql .= "WHERE hipperg.codcaso = :pCodCaso";
			$sql .= ") Itens ";
			$sql .= "order by Fixo desc, OrdemFixo, Padrao desc";
		}
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$itens = $cmd->fetchAll(PDO::FETCH_OBJ);
			return $itens;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function SalvaMontagem($itens)
	{
		$sqldel  = "DELETE FROM mescasoordenacao ";
		$sqldel .= "WHERE CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		$cnn->beginTransaction();
		
		$cmddel = $cnn->prepare($sqldel);
		$cmddel->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmddel->execute();
		
		if ($cmddel->errorCode() == Comuns::QUERY_OK)
		{
			$sql  = "INSERT INTO mescasoordenacao(CodCaso, Prefixo, Chave, Ordem) ";
			$sql .= "VALUES(:pCodCaso, :pPrefixo, :pChave, :pOrdem)";
			
			$cnn = Conexao2::getInstance();
			$i = 0;
			foreach ($itens as $item)
			{
				$i++;
				$prefi = substr($item, 0, 3);
				$chave = substr($item, 3);
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
				$cmd->bindParam(":pPrefixo", $prefi, PDO::PARAM_STR);
				$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
				$cmd->bindParam(":pOrdem", $i, PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					$cmd->closeCursor();
				}
				else
				{
					$cnn->rollBack();
					$msg = $cmd->errorInfo();
					$this->msg_erro = "aha" . $msg[2];
					$ret = false;
					break;
				}
			}
			
			$cnn->commit();
			$ret = true;
		}
		else
		{
			$cnn->rollBack();
			$msg = $cmddel->errorInfo();
			$this->msg_erro = "acho" . $msg[2];
			$ret = false;
		}
		return $ret;
	}
	
	public static function ERespostaImediata($codcaso)
	{
		$sql = "select DaResposta from mescaso where Codigo = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		$feedback = $cmd->fetchColumn(0);
		if ($feedback == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public static function BuscaConfiguracao($codcaso, $secao, $config)
	{
		$sql  = "select Valor from mescasoconfigs ";
		$sql .= "where CodCaso = :pCodCaso and Secao = :pSecao and configuracao = :pConfiguracao;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pSecao", $secao, PDO::PARAM_STR);
		$cmd->bindParam(":pConfiguracao", $config, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			$config = $cmd->fetchColumn();
		}
		else
		{
			// Se não encontrou a configuração, retorna o valor padrão definido aqui.
			switch ($config)
			{
				case "TipoResp":
					$config = "CE";
					break;
			}
		}
		
		$cmd->closeCursor();
		
		return $config;
	}
	
	public function ListaRecordSet($usuario = 0)
	{
		$sql  = "SELECT caso.Codigo, caso.Nome, caso.Descricao, nivel.Descricao as NivelDif ";
		if ($usuario > 0)
		{
			$sql .= ", res.CodResolucao, IFNULL(res.CodSituacao, 1) AS CodSituacao, IFNULL(sit.Descricao, 'Não iniciado') as Situacao ";
		}
		$sql .= "FROM mescaso caso ";
		$sql .= "INNER JOIN mesnivelpergunta nivel ON nivel.Codigo = caso.CodNivelDif ";
		
		if ($usuario > 0)
		{
			$sql .= "LEFT OUTER JOIN mesresolucao res ON res.CodCaso = caso.Codigo AND res.CodUsuario = :pCodUsuario ";
			$sql .= " AND res.CodResolucao = (SELECT MAX(CodResolucao) as CodResolucao ";
			$sql .= " FROM mesresolucao res2 WHERE res2.CodCaso = caso.Codigo AND res2.CodUsuario = :pCodUsuario) ";
			$sql .= "LEFT OUTER JOIN mesresolucaosituacao sit ON sit.CodSituacao = res.CodSituacao ";
		}
		$sql .= "WHERE caso.publicado = 1 AND caso.ativo = 1 AND caso.Excluido = 0 AND EXISTS( ";
		$sql .= "SELECT 1 FROM vwarvorecaso ac WHERE ac.CodCaso = caso.Codigo) ";
		if ($usuario > 0)
		{
			$sql .= "AND case when ((select 1 from mescasousuario where CodUsuario = :pCodUsuario) = 1) then ";
			$sql .= "caso.Codigo in (select CodCaso from mescasousuario where CodUsuario = :pCodUsuario) else caso.Codigo = caso.Codigo end;";
		}
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		if ($usuario > 0)
		{
			$cmd->bindParam(":pCodUsuario", $usuario, PDO::PARAM_INT);
		}
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$casos = $cmd->fetchAll(PDO::FETCH_OBJ);
			return $casos;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	/**
	 * Retorna um resultset com todos os usuarios do sistema vinculados ao grupo.
	 */
	public function ListaUsuariosColaboradores()
	{
		$sql  = "select u.Codigo, u.NomeCompleto, u.NomeUsuario, u.Ativo ";
		$sql .= "from mescasocolaborador ug ";
		$sql .= "inner join mesusuario u ";
		$sql .= "	on u.Codigo = ug.CodUsuario ";
		//$sql .= "       and (current_date() <= ug.DtVigencia or ug.DtVigencia = '1900-12-31') ";
		//$sql .= "       and (u.ativo = 1) ";
		$sql .= " where ug.CodCaso = " . $this->codigo;
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if ($rs != 0)
		{
			$cnn->Desconecta();
			return $rs;
		}
		else
		{
			$cnn->Desconecta();
			return false;
		}
	}	
	
	/**
	 * @param: $publicar bool Se true, publica o caso. Se false despublica o caso. Default = true
	 * */
	public function PublicaCaso($publicar = true)
	{
		if ($publicar === true)
			$pub = 1;
		else if ($publicar === false)
			$pub = 0;
		
		$sql = "UPDATE mescaso SET Publicado = :pPublicado WHERE Codigo = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		$cmd->bindParam(":pPublicado", $pub, PDO::PARAM_INT);
		
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
	
	public static function ConsultaSituacao($codcaso)
	{
		$sql  = "SELECT Publicado FROM mescaso WHERE Codigo = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		return $cmd->fetchColumn();
	}
	
	public static function CasoValido($codcaso)
	{
		$sql  = "SELECT Codigo FROM mescaso WHERE Codigo = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $codcaso, PDO::PARAM_INT);
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
	
	/**
	 * Retorna um array com os campos "codigo" e "nome" do caso clínico
	 * */
	public static function ConsultaInfosCaso($codcaso)
	{
		$sql = "SELECT Codigo, Nome FROM mescaso WHERE Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		$rs = $cmd->fetch(PDO::FETCH_OBJ);
		
		return array('codigo' => $rs->Codigo, 'nome' => $rs->Nome);
	}
	
	private function MontaAcoesVisualizacaoCaso($fase, $tipocaso, $chave)
	{
		$sqlbotoes  = "SELECT Item, Imagem, Texto, TipoCaso ";
		$sqlbotoes .= "FROM mesitensmenuresolucao ";
		$sqlbotoes .= "WHERE Fase = :pCodFase AND TipoCaso = :pTipoCaso ORDER BY Ordem;";
		
		$cnn = Conexao2::getInstance();
		
		$cmdbotoes = $cnn->prepare($sqlbotoes);
		$cmdbotoes->bindParam(":pCodFase", $fase, PDO::PARAM_STR);
		$cmdbotoes->bindParam(":pTipoCaso", $tipocaso, PDO::PARAM_INT);
		
		$cmdbotoes->execute();
		
		if ($cmdbotoes->errorCode() == Comuns::QUERY_OK)
		{
			while ($bot = $cmdbotoes->fetch(PDO::FETCH_OBJ))
			{
				$comandos .= '<a href="javascript:void(0);" onclick="javascript:' . $this->FuncaoBotao($bot->Item, $chave) . '" title="' . $bot->Texto . '">';
				$comandos .= '<img src="' . $bot->Imagem . '" class="botao" />';
				$comandos .= '</a>';
			}
			
			return $comandos;
		}
		else
		{
			$msg = $cmdbotoes->errorInfo();
			$this->msg_erro += "; " . $msg[2];
			return false;
		}
	}
	
	/*
	 * Cada botão de ação do topo da tela de visualização dos casos tem que ter uma entrada nesta função
	 * */
	private function FuncaoBotao($tipobotao, $chave)
	{
		switch ($tipobotao)
		{
			case "AVANCAR":
				$html = "fntAvanca('" . $chave . "');";
				break;
			case "VOLTAR":
				$html = "fntVolta('" . $chave . "');";
				break;
			case "AVALIAR":
				$html = "fntVerifica();";
				break;
			case "AVALAGRUP":
				$html = "fntVerificaEtapa();";
			case "AVALTRAT":
				$html = "fntVerificaTrat();";
		}
		
		return $html;
	}
	
	public function BuscaProximoConteudo($chaveatual = "", $direcao = "f")
	{
		if ($chaveatual == "")
		{
			$chaveatual = "609CFD70ED664FDEF1060604D4699672";
		}
		
		$tipocaso = $this->feedback;	//Feedback imediato (0 ou 1);
		
		$sql  = "SELECT CodCaso, Prefixo, Chave ";
		$sql .= "FROM mescasoordenacao ";
		$sql .= "WHERE CodCaso = :pCodCaso ";
		$sql .= "ORDER BY Ordem";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$chaveanterior = '';
				$chavememo = '';
				$prefixomemo = '';
				
				while ($reg = $cmd->fetch(PDO::FETCH_OBJ))
				{
					if (($reg->Chave == $chaveatual))
					{
						if ($direcao == "p")	// Voltar
						{
							$novachave = $chavememo;
							$prefixo = $prefixomemo;
							break;
						}
						else	// Avançar
						{
							$chaveanterior = $chaveatual;
						}
					}
					else
					{
						$chavememo = $reg->Chave;
						$prefixomemo = $reg->Prefixo;
						
						if ($chaveanterior != "")
						{
							$novachave = $reg->Chave;
							$prefixo = $reg->Prefixo;
							break;
						}
					}
				}
				
				switch ($prefixo)
				{
					case "OBJ":
						$ret = $this->BuscaConteudoObjetivos($prefixo, $novachave, $tipocaso);
						break;
					case "ANA":
						$ret = $this->BuscaConteudoAnamnese($prefixo, $novachave, $tipocaso);
						break;
					case "EFI":
						$ret = $this->BuscaConteudoExameFisico($prefixo, $novachave, $tipocaso);
						break;
					case "HIP":
						$ret = $this->BuscaConteudoHipoteses($prefixo, $novachave, $tipocaso);
						break;
					case "EXA":
						$ret = $this->BuscaConteudoExames($prefixo, $novachave, $tipocaso);
						break;
					case "EXE":
						$ret = $this->BuscaConteudoExercicios($prefixo, $novachave, $tipocaso);
						break;
					case "AGR":
						$ret = $this->BuscaConteudoAgrupamentos($prefixo, $novachave, $tipocaso);
						break;
					case "CON":
						$ret = $this->BuscaConteudoConteudo($prefixo, $novachave, $tipocaso);
						break;
					case "DIA":
						$ret = $this->BuscaConteudoDiagnosticos($prefixo, $novachave, $tipocaso);
						break;
					case "TRA":
						$ret = $this->BuscaConteudoTratamento($prefixo, $novachave, $tipocaso);
						break;
					case "DES":
						$ret = $this->BuscaConteudoDesfecho($prefixo, $novachave, $tipocaso);
						break;
				}
				
				$ret->AddItem("chave", $novachave);
				return $ret;
			}
			else
			{
				$this->msg_erro = "@lng[Este caso ainda não foi ordenado]";
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
	
	private function BuscaConteudoObjetivos($prefixo, $chave, $tipocaso)
	{
		$sql  = "SELECT CodObjetivo, Descricao ";
		$sql .= "FROM mescasoobjetivos ";
		$sql .= "WHERE CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$hash = new HashTable();
			
			$conteudo .= "<ul>";
			
			while ($reg = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$conteudo .= '<li>' . $reg->Descricao . '</li>';
			}
			
			$conteudo .= "</ul>";
			
			$hash->AddItem("titulosecao", "@lng[Este caso de estudo tem como objetivo:]");
			$hash->AddItem("conteudo", $conteudo);
			
			$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
			$hash->AddItem("menu", $comandos);

			return $hash;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	# Reescrita na classe resolucao.class.php
	private function BuscaConteudoAnamnese($prefixo, $chave, $tipocaso)
	{
		$sql  = "SELECT CodCaso, Identificacao, QueixaPri, HistAtual, HistPregressa ";
		$sql .= "		,HistFamiliar, PerfilPsicoSocial, RevSistemas ";
		$sql .= "FROM mescasoanamnese WHERE CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$hash = new HashTable();
			
			$reg = $cmd->fetch(PDO::FETCH_OBJ);
			
			$conteudo .= '<div class="item-cont">@lng[Identificação]</div>';
			$conteudo .= $reg->Identificacao;
			
			$conteudo .= '<div class="item-cont">@lng[Queixa principal]</div>';
			$conteudo .= $reg->QueixaPri;

			$conteudo .= '<div class="item-cont">@lng[História atual]</div>';
			$conteudo .= $reg->HistAtual;

			$conteudo .= '<div class="item-cont">@lng[História pregressa]</div>';
			$conteudo .= $reg->HistPregressa;

			$conteudo .= '<div class="item-cont">@lng[História familiar]</div>';
			$conteudo .= $reg->HistFamiliar;

			if ($reg->PerfilPsicoSocial != null)
			{
				$conteudo .= '<div class="item-cont">@lng[Perfil psicosocial]</div>';
				$conteudo .= $reg->PerfilPsicoSocial;
			}
			
			$conteudo .= '<div class="item-cont">@lng[Revisão de sistemas]</div>';
			$conteudo .= $reg->RevSistemas;
			
			$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
			
			$hash->AddItem("titulosecao", "Anamnese");
			$hash->AddItem("conteudo", $conteudo);
			$hash->AddItem("menu", $comandos);
			
			return $hash;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
		
	}

	private function BuscaConteudoExameFisico($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		
		$conteudo = file_get_contents("tpl/aluno/exame-fisico.html");
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", "@lng[Exame Físico]");
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("javascript", "fntInstanciaToolTip();");
		
		return $hash;
	}
	
	private function BuscaConteudoHipoteses($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		$hip = new Hipoteses();
		
		$sql  = "select GrupoHipotese, Texto ";
		$sql .= "from mescasohipotdiagnperguntaguia ";
		$sql .= "where CodCaso = :pCodCaso and chave = :pChave;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
		
		$cmd->execute();
		$rs = $cmd->fetch(PDO::FETCH_OBJ);
		
		$pergunta = $rs->Texto;
		$grupohip = $rs->GrupoHipotese;
		
		//$hip->CarregaPerguntaNorteadora($this->codigo, $chave);
		
		$hipoteses = $hip->ListaRecordSet($this->codigo, $grupohip);
		
		if (count($hipoteses) > 0)
		{
			$conteudo .= '<div class="item-cont">' . $pergunta . "</div>";
			$cont = 0;
			
			$conteudo .= '<div class="options">';
			
			foreach ($hipoteses as $reg)
			{
				$cont ++;
				$conteudo .= '<div class="item-option"><label for="chkRespHip_' . $cont . '"><input type="checkbox" name="chkRespHip[]" id="chkRespHip_' . $cont . '" value="' . base64_encode($reg->CodHipotese) . '" onclick="javascript:fntMarcaDesmarca(\'chkRespHip_' . $cont . '\');" class="opcao-resposta" /> ' . $reg->Descricao . '</label></div>';
			}
			
			$conteudo .= '</div>';
			$conteudo .= '<div class="organizador"></div>';
		}
		else
		{
			$conteudo = "Erro";
		}
		
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", "@lng[Hipóteses diagnósticas]");
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", true);
		
		return $hash;
	}
	
	private function BuscaConteudoExames($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		$exa = new Exame();
		
		$sql  = "select ex.CodCaso ";
		$sql .= "		,ex.NumBateria ";
		$sql .= "		,ex.TipoRegistro ";
		$sql .= "		,ex.Agrupado ";
		$sql .= "		,case when ex.TipoRegistro = 1 then expg.Texto else concat('Resultados da ', ex.NumBateria, 'ª bateria de exames') end as Texto ";
		$sql .= "from mescasoexameschaves ex ";
		$sql .= "left join mescasoexamesperguntaguia expg ";
		$sql .= "		on expg.CodCaso = ex.CodCaso and expg.NumBateria = ex.NumBateria ";
		$sql .= "where ex.CodCaso = :pCodCaso and chave = :pChave;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
		
		$cmd->execute();
		
		$rs = $cmd->fetch(PDO::FETCH_OBJ);
		
		$pergunta = $rs->Texto;
		$bateria = $rs->NumBateria;
		$tipoetapa = $rs->TipoRegistro;
		
		if ($tipoetapa == 1)
		{
			// É um teste...
			$exames = $exa->ListaRecordSet($this->codigo, $bateria, "S");
			
			if (count($exames) > 0)
			{
				$conteudo .= '<div class="item-cont">' . $pergunta . "</div>";
				$cont = 0;
				
				
				$conteudo .= '<div class="options">';
				
				foreach ($exames as $reg)
				{
					$cont ++;
					$conteudo .= '<div class="item-option"><label for="chkRespExa_' . $cont . '"><input type="checkbox" name="chkRespExa[]" id="chkRespExa_' . $cont . '" value="' . base64_encode($reg->CodExame) . '" onclick="javascript:fntMarcaDesmarca(\'chkRespExa_' . $cont . '\');" class="opcao-resposta" /> ' . $reg->Descricao . '</label></div>';
				}
				
				$conteudo .= '</div>';
				$conteudo .= '<div class="organizador"></div>';
				
				$hash->AddItem("Obrigatorio", true);
			}
			else
			{
				$conteudo = "Erro";
			}
		}
		else
		{
			// São os resultados
			//$exames = $exa->ListaRecordSet($this->codigo, $bateria);
			
			$sql  = "select  ex.CodCaso ";
			$sql .= "		,ex.CodExame ";
			$sql .= "		,ex.Descricao as Exame ";
			$sql .= "		,ex.Laudo ";
			$sql .= "		,te.Descricao as TipoExame ";
			$sql .= "		,itens.descricao as Componente ";
			$sql .= "		,case when (itens.tipoitem = 'vlr' and itens.descricao <> 0) then ";
			$sql .= "			(select Descricao ";
			$sql .= "				from mestipoexamecomponente comp ";
			$sql .= "				where comp.codexame = te.codigo ";
			$sql .= "				  and comp.codigo = itens.descricao) ";
			$sql .= "		 else null end as DescComponente ";
			$sql .= "		,itens.TipoItem ";
			$sql .= "		,itens.Valor ";
			$sql .= "		,itens.Complemento ";
			$sql .= "from mescasoexameschaves exch ";
			$sql .= "inner join mescasoexames ex ";
			$sql .= "		on ex.codcaso = exch.codcaso ";
			$sql .= "	   and ex.numbateria = exch.numbateria ";
			$sql .= "inner join mestipoexame te ";
			$sql .= "		on te.Codigo = ex.Tipo ";
			$sql .= "inner join mescasoexamesitens itens ";
			$sql .= "		on itens.codcaso = ex.codcaso ";
			$sql .= "	   and itens.codexame = ex.codexame ";
			$sql .= "where exch.CodCaso = :pCodCaso and exch.chave = :pCodChave ";
			$sql .= "  and 	( ";
			$sql .= "			(exch.Agrupado = 0 and ex.codexame = exch.codexame) ";
			$sql .= "			or ";
			$sql .= "			( ";
			$sql .= "				exch.Agrupado = 1 ";
			$sql .= "				and ";
			$sql .= "				ex.codexame not in	( ";
			$sql .= "									select distinct codexame ";
			$sql .= "									from mescasoexameschaves exch2 ";
			$sql .= "									where exch2.codcaso = exch.codcaso ";
			$sql .= "									  and exch2.NumBateria = exch.NumBateria ";
			$sql .= "									  and exch2.Agrupado = 0 ";
			$sql .= "									  and exch2.CodExame <> -1 ";
			$sql .= "									  and exch2.TipoRegistro = 2 ";
			$sql .= "									) ";
			$sql .= "			) ";
			$sql .= "		);";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
			$cmd->bindParam(":pCodChave", $chave, PDO::PARAM_STR);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$conteudo = '<div class="item-cont">' . $pergunta . '</div>';
					$conteudotab = "";
					$conteudoimg = "";
					$exameatual = "";
					$cont = 1;
					while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
					{
						if ($linha->TipoItem == 'vlr')
						{
							if ($linha->CodExame != $exameatual)
							{
								if ($linha->Componente != 0)
								{
									$conteudotab .= '<tr class="linha-exame"><td colspan="2" class="tab-tipo-exame">' . $linha->Exame . '</td></tr>';
									if (($linha->Laudo != null) && ($linha->Laudo != ""))
									{
										$conteudotab .= '<tr class="linha-laudo"><td colspan="2" class="tab-laudo-exame"><strong>@lng[Laudo]</strong>: ' . $linha->Laudo . '</td></tr>';
									}
								}
								else
								{
									$conteudotab .= '<tr class="tab-espacador"><td colspan="2">&nbsp;</td></tr>';
								}
								$exameatual = $linha->CodExame;
							}
							
							$conteudotab .= '<tr ' . (($linha->Componente != 0) ? 'class="linha-componente' . ((($cont % 2) == 0) ? ' claro' : '') . '"' : 'class="linha-exame"') . '>';
							$conteudotab .= '  <td ' . (($linha->Componente != 0) ? 'class="tab-tipo-componente"' : 'class="tab-tipo-exame"') . '>' . (($linha->Componente != 0) ? $linha->DescComponente : $linha->Exame) . '</td>';
							$conteudotab .= '  <td ' . (($linha->Componente == 0) ? 'class="claro-resp"' : '') . '>' . $linha->Valor . '</td>';
							$conteudotab .= '</tr>';
						}
						else if ($linha->TipoItem == 'img')
						{
							if ($exameatual != $linha->CodExame)
							{
								$conteudoimg .= '<div class="nome-exame"><strong>@lng[Exame:]</strong> ' . $linha->Exame . '</div>';
								$conteudoimg .= '<div class="laudo-exame"><strong>@lng[Laudo:]</strong> ' . $linha->Laudo . '</div>';
								$exameatual = $linha->CodExame;
							}
							
							$conteudoimg .= '<div class="resultado-exame-img">';
							$conteudoimg .= '  <div class="exp-imagem">' . $linha->Componente . '</div>';
							$conteudoimg .= '  <div class="img-exame-img">';
							$conteudoimg .= '    <img src="' . $linha->Valor . '" alt="' . $linha->Componente . '" title="' . $linha->Componente . '" class="view-img-exame-img" />';
							$conteudoimg .= '  </div>';
							
							if (($linha->Complemento != null) && ($linha->Complemento != ""))
							{
								$conteudoimg .= '  <div class="complemento-exame-img">' . $linha->Complemento . '</div>';
							}
							$conteudoimg .= '</div>';
						}
						$cont++;
					}
					
					if ($conteudotab != "")
					{
						$conteudo .= '<table class="res-exame-tab">' . $conteudotab . '</table>';
					}
					$conteudo .= $conteudoimg;
				}
				$hash->AddItem("Obrigatorio", false);
			}
			else
			{
				$msg = $cmd->errorInfo();
				$conteudo = $msg[2];
			}
		}
		
		if ($tipoetapa == 2)
		{
			$contanexados = $exa->ListaRecordSetConteudosVinculados($this->codigo, $chave);
			
			if (($contanexados !== false) && (count($contanexados) > 0))
			{
				$conteudo .= '<div class="caixa-saiba-mais">';
				$conteudo .= '  <div class="titulo-saiba-mais">@lng[Saiba mais]</div><br />';
				
				foreach ($contanexados as $ajuda)
				{
					$conteudo .= '<a href="javascript:void(0);" id="lnk-conteudo-' . $ajuda->CodConteudo . '" class="cor-avermelhada" onclick="javascript:fntApresentaConteudo(' . $ajuda->CodConteudo . ');">' . $ajuda->Descricao . '</a>';
					$conteudo .= '<div id="mais-conteudo-' . $ajuda->CodConteudo . '" class="content-saiba-mais">' . $ajuda->Texto . '</div>';
				}
				
				$conteudo .= '</div>';
			}
		}
		
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", "Exames");
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		
		return $hash;
	}
	
	private function BuscaConteudoConteudo($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		
		$sql  = "select Descricao, Texto ";
		$sql .= "from mescasoconteudo ";
		$sql .= "where CodCaso = :pCodCaso and Chave = :pChave";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$reg = $cmd->fetch(PDO::FETCH_OBJ);
				$titulo = $reg->Descricao;
				$conteudo = $reg->Texto;
			}
			else
			{
				$titulo = "";
				$conteudo = "@lng[Nenhum registro encontrado]";
			}
		}
		else
		{
			$titulo = "";
			$conteudo = "Erro";
		}

		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", $titulo);
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", false);
		
		return $hash;
	}
	
	private function BuscaConteudoDiagnosticos($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		$diag = new Diagnostico();
		
		$pergunta = $diag->CarregaPerguntaNorteadora($this->codigo);
		$diagnosticos = $diag->ListaRecordSet($this->codigo);
		
		if (count($diagnosticos) > 0)
		{
			$conteudo .= '<div class="item-cont">' . $pergunta . "</div>";
			$cont = 0;
			
			$conteudo .= '<div class="options">';
			
			foreach ($diagnosticos as $reg)
			{
				$cont++;
				$conteudo .= '<div class="item-option"><label for="chkRespDiag_' . $cont . '"><input type="checkbox" name="chkRespDiag[]" id="chkRespDiag_' . $cont . '" value="' . base64_encode($reg->CodDiagnostico) . '" onclick="javascript:fntMarcaDesmarca(\'chkRespDiag_' . $cont . '\');" class="opcao-resposta" /> ' . $reg->Descricao . '</label></div>';
			}
			
			$conteudo .= '</div>';
			$conteudo .= '<div class="organizador"></div>';
		}
		
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", "@lng[Diagnóstico(s)]");
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", true);
		
		return $hash;
	}
	
	private function MontaConteudoPerguntas($codpergunta, $dica = true, $agrupar = false)
	{
		$perg = new Pergunta();
		$perg->Carregar($codpergunta);
		
		$conteudo .= '<div class="pergunta">';
		$conteudo .= '  <div id="pergunta-texto">';
		$conteudo .= '    <img id="img_perg_' . $codpergunta . '" src="img/question.png" alt="@lng[Pergunta]" title="@lng[Pergunta]" class="img-pergunta atualizar-resp">' . $perg->getTexto();
		$conteudo .= '  </div>';
		
		if ($dica)
		{
			switch($perg->getTipo()->getCodigo())
			{
				case 1:
				case 3:
					$conteudo .= '<div id="pergunta-instr">@lng[Escolha uma das alternativas]</div>';
					break;
				case 2:
					$conteudo .= '<div id="pergunta-instr">@lng[Você pode escolher mais de uma alternativa se achar necessário]</div>';
					break;
			}
		}
		
		$alternativas = $perg->getAlternativas();
		$cont = 1;
		$letra = 65;
		foreach ($alternativas as $alt)
		{
			switch ($perg->getTipo()->getCodigo())
			{
				case 1:
					$conteudo .= '<div class="alt-img">';
					$conteudo .= '  <div class="alt-img-radio">';
					$conteudo .= '    ' . chr($letra) . ') <input type="radio" name="rdoAlternativa' . (($agrupar) ? ('_' . $perg->getCodigo()) : '') . '[]" id="rdoAlt_' . $cont . '" value="' . $alt->getCodUnico() . '" class="opcao-resposta" />';
					$conteudo .= '  </div>';
					$conteudo .= '  <div id="img"><img src="' . $alt->getImagem() . '" alt="' . $alt->getTexto() . '" title="' . $alt->getTexto() . '" /></div>';
					$conteudo .= '</div>';
					break;
				case 2:
					$conteudo .= '<div class="alt-txt">';
					$conteudo .= '  ' . chr($letra) . ') <input type="checkbox" name="rdoAlternativa' . (($agrupar) ? ('_' . $perg->getCodigo()) : '') . '[]" id="rdoAlt_' . $cont . '" value="' . $alt->getCodUnico() . '" class="opcao-resposta" />' . $alt->getTexto();
					$conteudo .= '</div>';
					break;
				case 3:
					$conteudo .= '<div class="alt-txt">';
					$conteudo .= '  ' . chr($letra) . ') <input type="radio" name="rdoAlternativa' . (($agrupar) ? ('_' . $perg->getCodigo()) : '') . '[]" id="rdoAlt_' . $cont . '" value="' . $alt->getCodUnico() . '" class="opcao-resposta" />' . $alt->getTexto();
					$conteudo .= '</div>';
					break;
			}
			$cont++;
			$letra++;
		}
		$conteudo .= '</div>';
		
		return $conteudo;
	}
	
	private function BuscaConteudoExercicios($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		
		$sqlcodigo = "SELECT Codigo FROM mespergunta WHERE Chave = :pChave;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sqlcodigo);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$codpergunta = $cmd->fetchColumn();
				
				$cmd->closeCursor();
				
				$conteudo = $this->MontaConteudoPerguntas($codpergunta);
				$conteudo .= '<div class="organizador" style="clear: both;"></div>';
			}
			else
			{
				$conteudo = "@lng[Nenhum registro encontrado]";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			
			$conteudo = $this->msg_erro;
		}
		
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", "Exercício");
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", true);
		
		return $hash;
	}
	
	private function BuscaConteudoAgrupamentos($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		
		$sql  = "select agru.Codigo ";
		$sql .= "		,agru.Texto ";
		$sql .= "		,ap.CodPergunta ";
		$sql .= "from mesperguntaagrupador agru ";
		$sql .= "inner join mesperguntaagrupamentos ap ";
		$sql .= "		on ap.CodAgrupador = agru.codigo ";
		$sql .= "where chave = :pChave;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$cont = 1;
				$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
				
				$conteudo .= '<div class="todas-perguntas">';
				
				foreach ($rs as $registro)
				{
					if ($cont == 1)
						$conteudo .= '<div id="pergunta-agrup">' . $registro->Texto . '</div>';
					
					$conteudo .= $this->MontaConteudoPerguntas($registro->CodPergunta, false, true);
					$cont++;
				}
				$conteudo .= '</div>';
				$conteudo .= '<div class="organizador" style="float:right;width:470px;margin-top:10px;"></div>';
			}
			else
			{
				$conteudo = "@lng[Nenhum registro encontrado]";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			$conteudo = $this->msg_erro;
		}
		
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", "@lng[Exercício]");
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", true);
		
		return $hash;
	}
	
	private function BuscaConteudoTratamento($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		$trat = new Tratamento();
		
		$pergunta = $trat->CarregaPerguntaNorteadora($this->codigo);
		$tratamentos = $trat->ListaRecordSet($this->codigo);

		if (count($tratamentos) > 0)
		{
			$titulo = "@lng[Tratamento]";
			
			$conteudo .= '<div class="item-cont">' . $pergunta . "</div>";
			
			$cont = 0;
			foreach ($tratamentos as $item)
			{
				$conteudo .= '<div class="tratamento-opcao" id="trat_' . $cont . '">';
				$conteudo .= '  <div class="tratamento-titulo">';

				$conteudo .= '    <span style="float:left;"><input type="checkbox" name="chkRespTrat[]" id="chkRespTrat_' . $cont . '" value="' . base64_encode($item->CodTratamento) . '" class="opcao-resposta" />';
				$conteudo .= '    ' . $item->Titulo;
				$conteudo .= '    </span><span style="float:right;"><span id="rt_' . $cont . '" class="vazio">&nbsp;</span><img src="img/pergunta.png"></span>';
				$conteudo .= '  </div>';
				
				$conteudo .= '  <div class="tratamento-opcoes">Opções: ';
				$conteudo .= '   <span id="spnAbreFecha_' . $cont . '"><a href="javascript:void(0);" onclick="javascript:fntMaxiMini(' . $cont . ');">@lng[Detalhes]</a></span>';
				
				if (($item->ConteudoAdicional != null) && ($item->ConteudoAdicional != ""))
					$conteudo .= '   <span id="spnMaisInfo_' . $cont . '">| <a href="javascript:void(0);" onclick="javascript:fntCAT(' . $cont . ');">@lng[Mais informações]</a></span>';
				
				$conteudo .= '   <span id="spnJust_' . $cont . '" style="display:none;">| <a href="javascript:void(0);" onclick="javascript:fntJustTrat(' . $cont . ');">@lng[Justificativa]</a></span>';
				$conteudo .= '  </div>';
				
				
				$conteudo .= '  <div class="tratamento-descricao" id="trat_des_' . $cont . '" style="display:none;">' . $item->Descricao . '</div>';
				
				if (($item->ConteudoAdicional != null) && ($item->ConteudoAdicional != ""))
					$conteudo .= '  <div class="tratamento-descricao" id="mais_des_' . $cont . '" style="display:none;">' . $item->ConteudoAdicional . '</div>';
					
				$conteudo .= '  <div class="tratamento-descricao" id="just_des_' . $cont . '" style="display:none;"></div>';
				$conteudo .= '</div>';
				
				$cont++;
			}
		}
		else
		{
			$titulo = "@lng[Erro tratamentos]";
			$conteudo = "@lng[Nenum registro encontrado.] " . $trat->getErro();
		}
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", $titulo);
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", true);
		
		return $hash;
	}
	
	private function BuscaConteudoDesfecho($prefixo, $chave, $tipocaso)
	{
		$hash = new HashTable();
		
		if ($tipocaso == 1)
		{
			$sql  = "SELECT Titulo, Desfecho FROM mescasodesfecho ";
			$sql .= "WHERE CodCaso = :pCodCaso;";
		}
		else
		{
			$sql  = "SELECT Titulo, Desfecho FROM mescasodesfecho ";
			$sql .= "WHERE CodCaso = :pCodCaso;";
		}

		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$reg = $cmd->fetch(PDO::FETCH_OBJ);
				$titulo = $reg->Titulo;
				$conteudo = $reg->Desfecho;
			}
			else
			{
				$titulo = "";
				$conteudo = "@lng[Nenhum registro encontrado]";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			
			$titulo = "@lng[Erro defecho]";
			$conteudo = "Erro: " . $this->msg_erro;
		}
		
		$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		
		$hash->AddItem("titulosecao", $titulo);
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("Obrigatorio", false);
		
		return $hash;
	}
	
	function DeletaTodosOsColaboradores()
	{
		if (isset($this->codigo))
		{
			$sql  = "DELETE FROM mescasocolaborador ";
			$sql .= "WHERE CodCaso = :pCodCaso;";
								
			$cnn = Conexao2::getInstance();
				
			$cnn->beginTransaction();
			$cmd = $cnn->prepare($sql);

			$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);

			$cmd->execute();
			if($cmd->errorCode() == Comuns::QUERY_OK)
			{
				$cnn->commit();
				return true;
			}
			else
			{
				$cnn->rollBack();
				$this->msg_erro = "@lng[Não foi possível excluir os colaboradores.]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código do caso não informado]";
			return false;
		}
	}
	
	function AdicionaColaboradorAoCaso($p_codusuario)
	{
		if (isset($this->codigo))
		{
			$sql  = "INSERT INTO mescasocolaborador(CodCaso, CodUsuario) ";
			$sql .= "VALUES(:pCodCaso, :pCodUsuario);";
								
			$cnn = Conexao2::getInstance();
				
			try
			{
				$cnn->beginTransaction();
				$cmd = $cnn->prepare($sql);

				$cmd->bindParam(":pCodCaso", $this->codigo, PDO::PARAM_INT);
				$cmd->bindParam(":pCodUsuario", $p_codusuario, PDO::PARAM_INT);

				$cmd->execute();
				$cnn->commit();
				
				if ($cmd->errorCode() != "")
				{
					return false;
				}
				else
				{
					return true;
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
			$this->msg_erro = "@lng[Código do caso não informado]";
			return false;
		}
	}
	
	private function ReplicaDadosBasicos()
	{
		$sql  = "INSERT INTO mescaso(Nome, Descricao, DtCadastro, CodNivelDif, CodArea, Ativo, Publicado, Sexo, Idade, IDPaciente, Cid10, CodAutor, Publicado, Etnia, NomePaciente, ImgPaciente, Excluido) ";
		$sql .= "select ";
		$sql .= "	 Nome ";
		$sql .= "	,Descricao ";
		$sql .= "	,current_timestamp as DtCadastro ";
		$sql .= "	,CodNivelDif ";
		$sql .= "	,CodArea ";
		$sql .= "	,1 as Ativo ";
		$sql .= "	,0 as Publicado ";
		$sql .= "	,Sexo ";
		$sql .= "	,Idade ";
		$sql .= "	,IDPaciente ";
		$sql .= "	,Cid10 ";
		$sql .= "	,CodAutor ";
		$sql .= "	,Publico ";
		$sql .= "	,Etnia ";
		$sql .= "	,NomePaciente ";
		$sql .= "	,ImgPaciente ";
		$sql .= "	,0 as Excluido ";
		$sql .= "from mescaso ";
		$sql .= "where Codigo = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		$cnn->beginTransaction();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$intCasoNovo = $cnn->lastInsertId();
			$cnn->commit();
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			$cnn->rollBack();
			return false;
		}
	}

	private function fntRegistraReplicacao($intCodNovo)
	{
		$sqlNumVer = "SELECT IFNULL(MAX(NumVersao), 1) + 1 AS NumVersao FROM mescasoversao WHERE CodCasoOrigem = :pCodOrigem";
		
		$cnn = Conexao2::getInstance();
		
		$cmdNumVer = $cnn->prepare($sqlNumVer);
		$cmdNumVer->bindParam(":pCodOrigem", $this->codigo, PDO::PARAM_INT);
		$cmdNumVer->execute();
		
		$intNumVer = $cmd->fetchColumn(0);
		
		$sql  = "INSERT INTO mescasoversao(CodCasoOrigem, CodCasoNovo, NumVersao, DtVersao, CodUsuario) ";
		$sql .= "VALUES(:pCodCasoOrigem, :pCodCasoNovo, :pNumVersao, CURRENT_TIMESTAMP, :pCodUsuario); ";
		
		//$cmd = $cnn->prepare($sql);
		//$cmd->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT); 
		//$cmd->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
		//$cmd->bindParam(":pNumVersao", 
		//$cmd->bindParam(":pCodUsuario"
		
		//$cmd->execute();
	}
	
	public function CriaNovaVersao()
	{
		$intCodigo = $this->ReplicaDadosBasicos();
		
		if ($intCodigo !== false)
		{
			
		}
	}
	// fim funções ------------------------------------------------------

}

?>