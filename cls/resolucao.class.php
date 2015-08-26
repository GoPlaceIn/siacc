<?php
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/objetivo.class.php';
include_once 'cls/caso.class.php';
include_once 'cls/anamnese.class.php';
include_once 'cls/examefisico.class.php';
include_once 'cls/conteudo.class.php';
include_once 'cls/montagem.class.php';
include_once 'cls/midia.class.php';
include_once 'cls/videoplayer.class.php';
include_once 'cls/audioplayer.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/desfecho.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/grupopergunta.class.php';
include_once 'cls/log.class.php';

class Resolucao
{
	private $codresolucao;
	private $codcaso;
	private $codusuario;
	private $datainicio;
	private $datafim;
	private $codsituacao;
	private $msg_erro;
	
	# gets ------------------------------------------------
	public function getCodresolucao()
	{
		return $this->codresolucao;
	}
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCodusuario()
	{
		return $this->codusuario;
	}
	
	public function getDatainicio()
	{
		return $this->datainicio;
	}
	
	public function getDatafim()
	{
		return $this->datafim;
	}
	
	public function getCodsituacao()
	{
		return $this->codsituacao;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	# fim dos gets ----------------------------------------
	
	
	# sets ------------------------------------------------
	public function setCodresolucao($p_codresolucao)
	{
		if ((isset($p_codresolucao)) && (!is_null($p_codresolucao)))
		{
			$this->codresolucao = $p_codresolucao;
		}
		else
		{
			throw new Exception("@lng[Resolução não informada]", 1000);
		}
	}
	
	public function setCodcaso($p_codcaso)
	{
		if ((isset($p_codcaso)) && (!is_null($p_codcaso)))
		{
			$this->codcaso = $p_codcaso;
		}
		else
		{
			throw new Exception("@lng[Código do caso não informado]", 1010);
		}
	}
	
	public function setCodusuario($p_codusuario)
	{
		if ((isset($p_codusuario)) && (!is_null($p_codusuario)))
		{
			$this->codusuario = $p_codusuario;
		}
		else
		{
			throw new Exception("@lng[Código do usuário não informado]", 1020);
		}
	}
	
	public function setDatainicio($p_datainicio)
	{
		if ((isset($p_datainicio)) && (!is_null($p_datainicio)))
		{
			$this->datainicio = $p_datainicio;
		}
		else
		{
			throw new Exception("@lng[Data de início não informada]", 1030);
		}
	}
	
	public function setDatafim($p_datafim)
	{
		if ((isset($p_datafim)) && (!is_null($p_datafim)))
		{
			$this->datafim = $p_datafim;
		}
		else
		{
			throw new Exception("@lng[Data de termino não informada]", 1040);
		}
	}
	
	public function setCodsituacao($p_codsituacao)
	{
		if ((isset($p_codsituacao)) && (!is_null($p_codsituacao)))
		{
			$this->codsituacao = $p_codsituacao;
		}
		else
		{
			throw new Exception("@lng[Situação não informada]", 1050);
		}
	}
	# fim dos sets ----------------------------------------
	
	
	# funções de acesso, início e termino da resolução ----------------
	public function Insere()
	{
		$sql  = "INSERT INTO mesresolucao(CodCaso, CodUsuario, DataInicio, CodSituacao) ";
		$sql .= "VALUES(:pCodCaso, :pCodUsuario, CURRENT_TIMESTAMP, :pCodSituacao);";
		
		$cnn = Conexao2::getInstance();
		$cnn->beginTransaction();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSituacao", $this->codsituacao, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$this->codresolucao = $cnn->lastInsertId();
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
	
	public function Altera()
	{
		$sql  = "UPDATE mesresolucao ";
		$sql .= "SET DataFim = :pDataFim, CodSituacao = :pCodSituacao ";
		$sql .= "WHERE CodResolucao = :pCodResolucao ";
		$sql .= "  AND CodCaso = :pCodCaso ";
		$sql .= "  AND CodUsuario = :pCodUsuario;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pDataFim", $this->datafim, PDO::PARAM_STR);
		$cmd->bindParam(":pCodSituacao", $this->codsituacao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
		
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
	
	public function Carrega()
	{
		$sql  = "SELECT CodResolucao, CodCaso, CodUsuario, DataInicio, DataFim, CodSituacao ";
		$sql .= "FROM mesresolucao WHERE CodResolucao = :pCodResolucao ";
		$sql .= "AND CodCaso = :pCodCaso AND CodUsuario = :pCodUsuario;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);

		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$resolucao = $cmd->fetch(PDO::FETCH_OBJ);
			
			$this->datainicio = $resolucao->DataInicio;
			$this->datafim = $resolucao->DataFim;
			$this->codsituacao = $resolucao->CodSituacao;
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function IniciaResolucao()
	{
		$this->codsituacao = 2;
		if ($this->Insere())
		{
			$u = unserialize($_SESSION['usu']);
			
			$this->RegistraAcesso($u->getIdAcessoAtual());
			$_SESSION['codresolucao'] = $this->codresolucao;
			//Log::RegistraLog("Caso de estudos " . $this->codcaso . " iniciado pelo usuário " . $u->getNome() . " (" . $u->getCodigo() . ") em " . date("Y-m-d H:i:s"));
		}
		else
		{
			return false;
		}
	}
	
	public function RegistraAcesso($codacesso)
	{
		$sql  = "INSERT INTO mesresolucaoacesso(CodResolucao, CodAcesso) ";
		$sql .= "VALUES(:pCodResolucao, :pCodAcesso);";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodAcesso", $codacesso, PDO::PARAM_INT);
		
		$u = unserialize($_SESSION['usu']);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			//Log::RegistraLog("Novo acesso do usuário " . $u->getNome() . " (" . $u->getCodigo() . ") ao caso de estudo " . $this->codcaso . " em " . date("Y-m-d H:i:s"));
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function ConcluiResolucao()
	{
		$this->datafim = date("Y-m-d H:i:s");
		$this->codsituacao = 3;
		return $this->Altera();
	}
	# fim das funções de acesso, início e termino da resolução --------
	

	# funções privadas que buscam os próximos conteudos pelas chaves
	/**
	 * Retorna Objeto com Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, Ordem
	 * */
	private function BuscaProximoConteudoIrmao($chaveatual)
	{
		$sql  = "SELECT Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, Ordem ";
		$sql .= "FROM mescasomontagem mont ";
		$sql .= "WHERE codcaso = :pCodCaso ";
		$sql .= "  AND CodMontagem = 1 ";
		$sql .= "  AND ChavePai =(SELECT ChavePai FROM mescasomontagem mont2 ";
		$sql .= "  		WHERE mont2.CodCaso = mont.CodCaso ";
		$sql .= "		AND mont2.CodMontagem = mont.CodMontagem ";
		$sql .= "		AND mont2.Chave = :pChaveAtual) ";
		$sql .= "  AND Ordem > (select Ordem from mescasomontagem ordenacao ";
		$sql .= "				where ordenacao.CodCaso = mont.CodCaso ";
		$sql .= "				  and ordenacao.CodMontagem = mont.CodMontagem ";
		$sql .= "				  and ordenacao.Chave = :pChaveAtual) ";
		$sql .= "ORDER BY Ordem LIMIT 0,1";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $chaveatual, PDO::PARAM_STR);
		$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetch(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum conteúdo encontrado]";
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
	
	/**
	 * Retorna Objeto com Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, Ordem
	 * */
	private function BuscaProximoConteudoFilho($chaveatual)
	{
		$sql  = "select Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, Ordem ";
		$sql .= "from mescasomontagem ";
		$sql .= "where CodCaso = :pCodCaso and CodMontagem = 1 and ChavePai = :pChaveAtual ";
		$sql .= "order by Ordem limit 0,1";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $chaveatual, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetch(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[NENHUM REGISTRO FILHO]";
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
	
	/**
	 * Retrona Objeto com ChavePai, TipoConteudo, Organizador, Ordem, CodVisita, DataHora, SoControle
	 * */
	private function BuscaNodopai($chaveatual)
	{
		$sql  = "SELECT mon.ChavePai, mon.TipoConteudo, mon.Organizador, mon.Ordem, vis.CodVisita, vis.DataHora, vis.SoControle ";
		$sql .= "FROM mescasomontagem mon ";
		$sql .= "LEFT OUTER JOIN mesresolucaovisconteudo vis ";
		$sql .= "		ON vis.CodCaso = mon.CodCaso ";
		$sql .= "		AND vis.CodMontagem = mon.CodMontagem ";
		$sql .= "		AND vis.CodChave = mon.ChavePai ";
		$sql .= "		AND vis.CodResolucao = :pCodResolucao ";
		$sql .= "WHERE mon.CodCaso = :pCodCaso ";
		$sql .= "  AND mon.CodMontagem = 1 ";
		$sql .= "  AND mon.Chave = :pChaveAtual;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $_SESSION['codresolucao'], PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $chaveatual, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	/**
	 * Retorna Array de Objetos com Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, ValorOpt, Ordem
	 * @param $chaveagrupador string : Chave agrupadora das opções
	 * @param $filtro int : [opcional] Valor usado para filtrar as opções com o and binario
	 * */
	public function BuscaConteudosAgrupador($chaveagrupador, $filtro = null)
	{
		$sql  = "SELECT Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, ValorOpt, Ordem ";
		$sql .= "FROM mescasomontagem ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodMontagem = 1 AND ChavePai = :pChaveAgrup ";
		$sql .= "  AND Organizador = 'cont' ";
		
		if (! is_null($filtro))
		{
			$sql .= "  AND ((ValorOpt & " . $filtro . ") > 0) ";
		}
		
		$sql .= "ORDER BY mescasomontagem.Ordem;";

		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAgrup", $chaveagrupador, PDO::PARAM_STR);

		
		//Log::RegistraLog("DEBUG REGIS 19 - Realizada consulta de itens com os parametros: CodCaso: " . $this->codcaso . "; chaveagrupador: " . $chaveagrupador . "; SQL: " . $sql);
		
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				//Log::RegistraLog('DEBUG ORDENACAO - ' . print_r($cmd->fetchAll(PDO::FETCH_OBJ), true));
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[NENHUM REGISTRO agrupador]";
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

	/**
	 * Retorna um Array de objetos com Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, ValorOpt, Ordem
	 * */
	private function BuscaAgrupadoresAgrupador($chaveagrupador)
	{
		$sql  = "SELECT Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, ValorOpt, Ordem ";
		$sql .= "FROM mescasomontagem ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodMontagem = 1 AND ChavePai = :pChaveAgrup ";
		$sql .= "  AND Organizador = 'agr';";

		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAgrup", $chaveagrupador, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[NENHUM REGISTRO agrupador filho]";
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
	
	
	/**
	 * Retorna Objeto com Chave, Organizador, TipoConteudo, Ordem
	 * */
	private function BuscaConteudoRaiz()
	{
		$sql  = "SELECT Chave, Organizador, TipoConteudo, Ordem FROM mescasomontagem mont ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodMontagem = 1 AND TipoConteudo = 'raiz';";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $_SESSION['casores']);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return $cmd->fetch(PDO::FETCH_OBJ);
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	/**
	 * Busca as respostas já gravadas pelo aluno
	 * @param $chaveagrupador string : Chave do conteúdo na montagem do caso
	 * @param $codpergunta int : [opcional] caso for a resposta de uma pergunta que se queira. Default: null
	 * */
	public function BuscaRespostas($chaveagrupador, $codpergunta = null)
	{
		// Busca as ultimas respostas que o aluno deu para esta etapa do caso
		
		$sqlresp  = "select Resposta ";
		$sqlresp .= "from mesresolucaoresposta resp ";
		$sqlresp .= "where CodResolucao = :pCodResolucao ";
		$sqlresp .= "  and ChaveItem = :pChaveAgrupador ";
		$sqlresp .= "  and CodPergunta " . (is_null($codpergunta) ? 'IS NULL' : ('= ' . $codpergunta));
		$sqlresp .= "  and NumTentativa =( ";
		$sqlresp .= "					select max(NumTentativa) ";
		$sqlresp .= "					from mesresolucaoresposta respAnt ";
		$sqlresp .= "					where respAnt.CodResolucao = resp.CodResolucao ";
		$sqlresp .= "					  and respAnt.ChaveItem = resp.ChaveItem ";
		$sqlresp .= "					  and ((respAnt.CodPergunta is null) or (respAnt.CodPergunta is not null and respAnt.CodPergunta = resp.CodPergunta)) ";
		$sqlresp .= "					) ";
		
		$cnn = Conexao2::getInstance();
		
		$cmdresp = $cnn->prepare($sqlresp);
		$cmdresp->bindParam(":pCodResolucao", $_SESSION['codresolucao'], PDO::PARAM_INT);
		$cmdresp->bindParam(":pChaveAgrupador", $chaveagrupador, PDO::PARAM_STR);
		$cmdresp->execute();
		
		if ($cmdresp->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmdresp->rowCount() > 0)
			{
				$respostas = $cmdresp->fetchColumn();
			}
			else
			{
				$respostas = 0;
			}
			return $respostas;
		}
		else
		{
			$msg = $cmdresp->errorInfo();
			$this->msg_erro = $msg[2];
			Log::RegistraLog("Erro na consulta das repostas: " . $this->msg_erro, true);
			return false;
		}
	}
	
	public function SalvaResposta($strChave, $intCodPergunta, $intResposta)
	{
		$sqlult  = "select Resposta ";
		$sqlult .= "from mesresolucaoresposta resp ";
		$sqlult .= "where resp.CodResolucao = :pCodResolucao ";
		$sqlult .= "  and resp.ChaveItem = :pChaveItem ";
		$sqlult .= "  and 	( ";
		$sqlult .= "			(resp.CodPergunta is null) ";
		$sqlult .= "			or ";
		$sqlult .= "			(resp.CodPergunta is not null and resp.CodPergunta = :pCodPergunta) ";
		$sqlult .= "		) ";
		$sqlult .= "  and NumTentativa =( ";
		$sqlult .= "					select max(NumTentativa) ";
		$sqlult .= "					from mesresolucaoresposta ult ";
		$sqlult .= "					where ult.CodResolucao = resp.CodResolucao ";
		$sqlult .= "					  and ult.ChaveItem = resp.ChaveItem ";
		$sqlult .= "					  and ( (resp.CodPergunta is null)  ";
		$sqlult .= "							or ";
		$sqlult .= "							(resp.CodPergunta is not null and ult.CodPergunta = resp.CodPergunta)) ";
		$sqlult .= "					)";
		
		$cnn = Conexao2::getInstance();
		
		$cmdult = $cnn->prepare($sqlult);
		$cmdult->bindParam(":pCodResolucao", $_SESSION['codresolucao'], PDO::PARAM_INT);
		$cmdult->bindParam(":pChaveItem", $strChave, PDO::PARAM_STR);
		$cmdult->bindParam(":pCodPergunta", $intCodPergunta, PDO::PARAM_INT);
		$cmdult->execute();
		
		if ($cmdult->errorCode() == Comuns::QUERY_OK)
		{
			if (($cmdult->rowCount() == 0) || (intval($cmdult->fetchColumn()) != intval($intResposta)))
			{
				$sql  = "insert into mesresolucaoresposta(CodResolucao, CodAcesso, ChaveItem, CodPergunta, NumTentativa, Resposta) ";
				$sql .= "select :pCodResolucao, ";
				$sql .= "		:pCodAcesso, ";
				$sql .= "		:pChaveItem, ";
				$sql .= "		:pCodPergunta, ";
				$sql .= "		(select ifnull(max(NumTentativa), 0) + 1 ";
				$sql .= "		 from mesresolucaoresposta ant ";
				$sql .= "		 where ant.CodResolucao = :pCodResolucao ";
				$sql .= "		   and ant.ChaveItem = :pChaveItem ";
				$sql .= "		   and ((ant.CodPergunta is null) or (not ant.CodPergunta is null and ant.CodPergunta = :pCodPergunta))), ";
				$sql .= "		:pResposta;";
				//$sql .= "values(:pCodResolucao, :pCodAcesso, :pChaveItem, :pCodPergunta, :pNumTentativa, :pResposta)";
				
				$u = unserialize($_SESSION['usu']);
				//$u = new Usuario();
				
				/*
				Log::RegistraLog("Vai executar o comando INSERT INTO mesresolucaoresposta(CodResolucao = " . $_SESSION['codresolucao'] . 
								 ", CodAcesso = " . $u->getIdAcessoAtual() . 
								 ", ChaveItem = " . $strChave . 
								 ", CodPergunta = " . $intCodPergunta . 
								 ", Resposta = " . $intResposta . ")");
				*/
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodResolucao", $_SESSION['codresolucao'], PDO::PARAM_INT);
				$cmd->bindParam(":pCodAcesso", $u->getIdAcessoAtual(), PDO::PARAM_INT);
				$cmd->bindParam(":pChaveItem", $strChave, PDO::PARAM_STR);
				$cmd->bindParam(":pCodPergunta", $intCodPergunta, PDO::PARAM_INT);
				$cmd->bindParam(":pResposta", $intResposta, PDO::PARAM_INT);
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
				// Não precisa salvar porque é igual a ultima resposta
				return true;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	#######################################################
	# funções privadas que retornam o html dos conteúdos
	# tela mostrando a anamnese do paciente
	private function RenderAnamnese($parte = 1)
	{
		$an = new Anamnese();
		if ($an->Carrega($this->codcaso))
		{
			$hash = new HashTable();
			$ca = new Caso();
			$ca->setCodigo($this->codcaso);
			$ca->CarregarCaso();
			
			if ($parte == 1)
			{
				if (! is_null($ca->getImagemPaciente()))
				{
					$html .= '<img src="img/pe_' . $ca->getImagemPaciente() . '.png" class="img-paciente" alt="@lng[Imagem: Paciente]" title="@lng[Imagem: Paciente]" />';
				}
				$html .= '<div class="item-cont">@lng[Identificação]</div>';
				$html .= nl2br($an->getIdentificacao());
				
				$html .= '<div class="item-cont">@lng[Queixa principal]</div>';
				$html .= nl2br($an->getQueixapri());
	
				$html .= '<div class="item-cont">@lng[História atual]</div>';
				$html .= nl2br($an->getHistatual());
				
				$comandos = $this->BuscaMenusItem('an');
			}
			else if ($parte == 2)
			{
				$html .= '<div class="item-cont">@lng[História pregressa]</div>';
				$html .= nl2br($an->getHistpregressa());
	
				$html .= '<div class="item-cont">@lng[História familiar]</div>';
				$html .= nl2br($an->getHistfamiliar());
	
				if (strip_tags($an->getPerfilpsicosocial()) != '')
				{
					$html .= '<div class="item-cont">@lng[Perfil psicosocial]</div>';
					$html .= nl2br($an->getPerfilpsicosocial());
				}
				
				$html .= '<div class="item-cont">@lng[Revisão de sistemas]</div>';
				$html .= nl2br($an->getRevsistemas());
				
				$comandos = $this->BuscaMenusItem('aninv');
			}
			
			//$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
			
			$hash->AddItem("titulosecao", ($parte == 1 ? "@lng[Anamnese (identificação)]" : "@lng[Anamnese (investigação)]"));
			$hash->AddItem("conteudo", $html);
			$hash->AddItem("menu", $comandos);
			$hash->AddItem("save", 'N');
			
			return $hash;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	# tela mostrando o exame físico do paciente
	private function RenderExameFisico()
	{
		$hash = new HashTable();
		
		$html = file_get_contents("tpl/aluno/exame-fisico.html");
		//$comandos = $this->MontaAcoesVisualizacaoCaso($prefixo, $tipocaso, $chave);
		$comandos = $this->BuscaMenusItem('exfis');
		
		$hash->AddItem("titulosecao", "@lng[Exame Físico]");
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("menu", $comandos);
		$hash->AddItem("eval", "fntInstanciaToolTip();");
		$hash->AddItem("save", 'N');
		
		return $hash;
	}
	
	# tela mostrando as hipóteses diagnósticas
	private function RenderItensHipotesesDiagnosticas($itens, $chaveagrupador, $bolListagemSimples = false)
	{
		$u = unserialize($_SESSION['usu']);
		
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		if (!$configs)
		{
			$configs = $this->BuscaConfiguracoesDetault();
		}
		
		// Monta o IN para saber quais hipóteses deve apresentar conforme montagem
		$in = "";
		$arrvalores = array();
		foreach ($itens as $hip)
		{
			//$in .= ($in == "" ? $hip->ContReferencia : ", " . $hip->ContReferencia);
			$in .= ($in == "" ? '' : ' union all ') . 'select ' . $hip->ContReferencia . ' AS CodHipotese, ' . $hip->Ordem . ' AS Ordem';
			$arrvalores[$hip->ContReferencia] = $hip->ValorOpt;
		}
		//$in = "IN(" . $in . ")";
		
		$cnn = Conexao2::getInstance();
		$respostas = $this->BuscaRespostas($chaveagrupador);
		//Log::RegistraLog("Respostas do aluno: " . $respostas);
		
		// Busca descrição das hipóteses
		$sql  = "SELECT mescasohipotdiagn.CodHipotese, mescasohipotdiagn.Descricao ";
		$sql .= "FROM mescasohipotdiagn ";
		$sql .= "INNER JOIN(" . $in . ") Ordem ON Ordem.CodHipotese = mescasohipotdiagn.CodHipotese ";
		$sql .= "WHERE CodCaso = :pCodCaso ORDER BY Ordem.Ordem;";
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			die(print_r($cmd->errorInfo()));
		}
		
		$hipoteses = $cmd->fetchAll(PDO::FETCH_OBJ);
		
		if (count($hipoteses) > 0)
		{
			$cont = 0;
			if ((! is_null($configs[2])) && ($bolListagemSimples === false))
			{
				$html .= '<div class="item-cont">' . $configs[2] . "</div>";	/* Texto, pergunta ou mensagem para o aluno */
				$html .= '<div class="options">';
			}
			
			foreach ($hipoteses as $reg)
			{
				$cont ++;
				$html .= '<div class="item-option">';
				
				if (($configs[1] == 1) || ($bolListagemSimples))	/* Opções de marcação (somente uma ou várias alternativas) */
				{
					$html .= '<label for="chkRespHip_' . $cont . '">';
					$html .= '<input type="checkbox" name="chkRespHip_' . $chaveagrupador . '[]" id="chkRespHip_' . $cont . '" value="' . $arrvalores[$reg->CodHipotese] . '" ' . (((intval($arrvalores[$reg->CodHipotese], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' onclick="javascript:fntMarcaDesmarca(\'chkRespHip_' . $cont . '\');" class="opcao-resposta" /> ' . $reg->Descricao;
				}
				else
				{
					$html .= '<label for="chkRespHip_' . $cont . '">';
					$html .= '<input type="radio" name="chkRespHip_' . $chaveagrupador . '[]" id="chkRespHip_' . $cont . '" value="' . $arrvalores[$reg->CodHipotese] . '" ' . (((intval($arrvalores[$reg->CodHipotese], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" /> ' . $reg->Descricao;
				}
				$html .= '</label></div>';
			}
			
			if ($bolListagemSimples === false)
			{
				$html .= '</div>';
			}
		}
		else
		{
			$html = "Erro";
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Hipóteses diagnósticas]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("menu", $this->BuscaMenusItem('hip', false, $configs));
		$hash->AddItem("save", 'S');
		
		return $hash;
	}
	
	private function RenderItensDiagnostico($itens, $chaveagrupador, $bolListagemSimples = false)
	{
		$u = unserialize($_SESSION['usu']);
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		$configs[1] = (is_null($configs[1]) ? "1" : $configs[1]);
		// Monta o IN para saber quais os diagnósticos deve apresentar conforme montagem
		$in = "";
		$arrvalores = array();
		foreach ($itens as $diags)
		{
			//$in .= ($in == "" ? $diags->ContReferencia : ", " . $diags->ContReferencia);
			$in .= ($in == "" ? '' : ' union all ') . 'select ' . $diags->ContReferencia . ' AS CodDiagnostico, ' . $diags->Ordem . ' AS Ordem';
			$arrvalores[$diags->ContReferencia] = $diags->ValorOpt;
		}
		//$in = "IN(" . $in . ")";
		
		$cnn = Conexao2::getInstance();
		$respostas = $this->BuscaRespostas($chaveagrupador);
		//Log::RegistraLog("Respostas do aluno: " . $respostas);
		
		// Busca descrição dos diagnósticos
		$sql  = "SELECT mescasodiagnostico.CodDiagnostico, mescasodiagnostico.Descricao ";
		$sql .= "FROM mescasodiagnostico ";
		$sql .= "INNER JOIN(" . $in . ") Ordem ON Ordem.CodDiagnostico = mescasodiagnostico.CodDiagnostico ";
		$sql .= "WHERE CodCaso = :pCodCaso ORDER BY Ordem.Ordem;";
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			die(print_r($cmd->errorInfo()));
		}
		
		$diagnosticos = $cmd->fetchAll(PDO::FETCH_OBJ);
		
		if (count($diagnosticos) > 0)
		{
			$cont = 0;
			
			if ($bolListagemSimples === false)
			{
				$html .= '<div class="item-cont">' . $configs[2] . "</div>";	/* Texto, pergunta ou mensagem para o aluno */
				$html .= '<div class="options">';
			}
			
			//Log::DetalhaLog("Respostas do aluno: " . $respostas);
			
			foreach ($diagnosticos as $reg)
			{
				$cont ++;
				$html .= '<div class="item-option">';
				
				if (($configs[1] == 1) || ($bolListagemSimples))	/* Opções de marcação (somente uma ou várias alternativas) */
				{
					$html .= '<label for="chkRespDiag_' . $cont . '">';
					$html .= '<input type="checkbox" name="chkRespDiag_' . $chaveagrupador . '[]" id="chkRespDiag_' . $cont . '" value="' . $arrvalores[$reg->CodDiagnostico] . '" ' . (((intval($arrvalores[$reg->CodDiagnostico], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' onclick="javascript:fntMarcaDesmarca(\'chkRespHip_' . $cont . '\');" class="opcao-resposta" /> ' . $reg->Descricao;
				}
				else
				{
					$html .= '<label for="chkRespDiag_' . $cont . '">';
					$html .= '<input type="radio" name="chkRespDiag_' . $chaveagrupador . '[]" id="chkRespDiag_' . $cont . '" value="' . $arrvalores[$reg->CodDiagnostico] . '" ' . (((intval($arrvalores[$reg->CodDiagnostico], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" /> ' . $reg->Descricao;
				}
				$html .= '</label></div>';
			}
			
			if ($bolListagemSimples === false)
			{
				$html .= '</div>';
				$html .= '<div class="organizador"></div>';
			}
		}
		else
		{
			$html = "Erro";
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Diagnósticos]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("menu", $this->BuscaMenusItem('diag', false, $configs));
		$hash->AddItem("save", 'S');
		
		return $hash;
	}
	
	private function RenderItensOpcoesExame($itens, $chaveagrupador, $bolListagemSimples = false)
	{
		//$u = unserialize($_SESSION['usu']);
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		$configs[1] = (is_null($configs[1]) ? "1" : $configs[1]);
		
		// Monta o IN para saber quais os diagnósticos deve apresentar conforme montagem
		$in = "";
		$arrvalores = array();
		foreach ($itens as $exams)
		{
			//$in .= ($in == "" ? $exams->ContReferencia : ", " . $exams->ContReferencia);
			$in .= ($in == "" ? '' : ' union all ') . 'select ' . $exams->ContReferencia . ' AS CodExame, ' . $exams->Ordem . ' AS Ordem';
			$arrvalores[$exams->ContReferencia] = $exams->ValorOpt;
		}
		//$in = "IN(" . $in . ")";
		
		$cnn = Conexao2::getInstance();
		$respostas = $this->BuscaRespostas($chaveagrupador);
		//Log::RegistraLog("Respostas do aluno: " . $respostas);
		
		// Busca descrição dos exames
		$sql  = "SELECT mescasoexames.CodExame, mescasoexames.Descricao ";
		$sql .= "FROM mescasoexames ";
		$sql .= "INNER JOIN(" . $in . ") Ordem ON Ordem.CodExame = mescasoexames.CodExame ";
		$sql .= "WHERE CodCaso = :pCodCaso ORDER BY Ordem.Ordem;";
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			die(print_r($cmd->errorInfo()));
		}
		
		$exames = $cmd->fetchAll(PDO::FETCH_OBJ);
		
		if (count($exames) > 0)
		{
			$cont = 0;
			
			if ((! is_null($configs[2])) && ($bolListagemSimples === false))
			{
				$html .= '<div class="item-cont">' . $configs[2] . "</div>";	/* Texto, pergunta ou mensagem para o aluno */
				$html .= '<div class="options">';
			}
			
			foreach ($exames as $reg)
			{
				$cont ++;
				$html .= '<div class="item-option">';
				
				if (($configs[1] == 1) || ($bolListagemSimples))	/* Opções de marcação (somente uma ou várias alternativas) */
				{
					$html .= '<label for="chkRespExa_' . $cont . '">';
					$html .= '<input type="checkbox" name="chkRespExa_' . $chaveagrupador . '[]" id="chkRespExa_' . $cont . '" value="' . $arrvalores[$reg->CodExame] . '" ' . (((intval($arrvalores[$reg->CodExame], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' onclick="javascript:fntMarcaDesmarca(\'chkRespExa_' . $cont . '\');" class="opcao-resposta" /> ' . $reg->Descricao;
				}
				else
				{
					$html .= '<label for="chkRespDiag_' . $cont . '">';
					$html .= '<input type="radio" name="chkRespExa_' . $chaveagrupador . '[]" id="chkRespExa_' . $cont . '" value="' . $arrvalores[$reg->CodExame] . '" ' . (((intval($arrvalores[$reg->CodExame], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" /> ' . $reg->Descricao;
				}
				$html .= '</label></div>';
			}
			
			if ($bolListagemSimples === false)
			{
				$html .= '</div>';
			}
		}
		else
		{
			$html = "Erro";
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Exames complementares]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("menu", $this->BuscaMenusItem('optex', false, $configs));
		$hash->AddItem("save", 'S');
		
		return $hash;
	}
	
	private function RenderResultadoExame($codexame, $confs)
	{
		//Log::RegistraLog("DEBUG REGIS 19 - Ordem render exame. CodCaso: " . $this->codcaso . "; CodExame: " . $codexame);
		
		$exame = new Exame();
		$exame->setCodcaso($this->codcaso);
		if ($exame->Carrega($this->codcaso, $codexame))
		{
			$temimgs = false;
			$temlabs = false;
			$temdocs = false;
			
			$html .= '<div class="tit-exame">' . $exame->getDescricao() . ' - resultado</div>';
			
			// Se foi cadastrado laudo, mostra o laudo
			if ($exame->getLaudo() != null)
			{
				$html .= '<div class="tit-item">@lng[Laudo]</div>';
				$html .= '<span>' . $exame->getLaudo() . '</span><br />';
			}
			
			// Busca as imagens do exame se tiver
			$imagens = $exame->ListaRecordSetImagensItensExame();
			
			if ($imagens !== false)
			{
				$html .= '<div class="recuo">';
				
				// se encontrou... mostra elas
				foreach ($imagens as $imgexame)
				{
					$midia = new Midia();
					$midia->setCodCaso($this->codcaso);
					$midia->setCodMidia($imgexame->Valor);
					$midia->CarregaPorCodigoEspecifico();
					
					$html .= '<div class="descr-img"><strong>@lng[Descrição]</strong></div><div>' . $midia->getDescricao() . '</div>';
					$html .= '<img class="img-apres thumbatual" src="viewimagem.php?img=' . base64_encode($imgexame->Valor) . '" title="@lng[Imagem]: ' . $midia->getDescricao() . '" alt="@lng[Imagem]: ' . $midia->getDescricao() . '">';
					
					if ((! is_null($midia->getComplemento())) && (strip_tags($midia->getComplemento()) != ''))
					{
						$html .= '<div class="descr-img"><strong>@lng[Complemento]: </strong>' . $midia->getComplemento() . '</div>';
					}
				}
				$temimgs = true;
				$html .= '</div>';
			}
			
			$documentos = $exame->ListaRecordSetDocumentosItensExame();
			
			if ($documentos !== false)
			{
				$html .= '<div class="recuo">';
				if ($temimgs)
				{
					$html .= '<div class="separador"></div>';
				}
				
				// se encontrou... mostra eles
				foreach ($documentos as $docexame)
				{
					$midia = new Midia();
					$midia->setCodCaso($this->codcaso);
					$midia->setCodMidia($docexame->Valor);
					$midia->CarregaPorCodigoEspecifico();
					
					$html .= '<img src="img/documento.png" title="' . $midia->getDescricao() . '" />';
					$html .= '<a class="lnk-doc" href="' . $midia->getURL() . '" title="@lng[Clique para abrir/baixar o documento]">' . $midia->getDescricao() . '</a>';
					if (strip_tags($midia->getComplemento()) != '')
					{
						$html .= '<div class="descr-img"><strong>@lng[Complemento]: </strong>' . $midia->getComplemento() . '</div>';
					}
				}
				$temdocs = true;
				$html .= '</div>';
			}
			
			// Exames laboratoriais
			$laboratoriais = $exame->ListaRecordSetResultadosExamesLaboratoriais();
			if ($laboratoriais !== false)
			{
				$html .= '<div class="recuo">';
				if (($temdocs) || ($temimgs))
				{
					$html .= '<div class="separador"></div>';
				}
				
				if ($exame->getTemComponentes() == 1)
				{
					$html .= '<div class="tit-item">@lng[Resultados do exame]</div>';
					$html .= '<table class="tab-result-exame">';
					$html .= '<tr>';
					$html .= '<th>@lng[Item]</th>';
					$html .= '<th>@lng[Valor]</th>';
					$html .= '<th>@lng[Complemento]</th>';
					$html .= '</tr>';
					foreach ($laboratoriais as $componente)
					{
						//CodComponente, NomeComponente e Valor
						
						$html .= '<tr>';
						$html .= '<td>' . $componente->NomeComponente . '</td>';
						$html .= '<td>' . $componente->Valor . '</td>';
						$html .= '<td>' . ($componente->Complemento != null ? $componente->Complemento : '') . '</td>';
						$html .= '</tr>';
					}
					$html .= '</table>';
				}
				else
				{
					$html .= '<div class="tit-item">@lng[Resultados do exame]</div>';
					$html .= '<span>' . $laboratoriais[0]->Valor . ($componente->Complemento != null ? (' (' . $componente->Complemento . ')') : '') . '</span>';
				}
				$html .= '</div>';
				$temlabs = true;
			}
			
			if ((!$temdocs) && (!$temimgs) && (!$temlabs) && ($exame->getLaudo() == null))
			{
				$html .= '<div class="recuo">';
				$html .= '<div class="tit-item"><span style="color:#ff0000;">@lng[Este exame não foi solicitado para este caso clínico].</span></div>';
				$html .= '</div>';
			}
			
			// Colocar o saiba mais aqui
			
			return $html;
		}
		else
		{
			return "@lng[Erro ao carregar o exame]" . $codexame;
		}
		
	}
	
	private function ContemExameNaLista($intCodExame, $arrTodosExames)
	{
		foreach ($arrTodosExames as $exame)
		{
			if ($exame->ContReferencia == $intCodExame)
			{
				return $exame;
			}
		}
		return null;
	}
	
	private function RenderItensResultadosExames($itens, $chaveagrupador)
	{
		//$u = unserialize($_SESSION['usu']);
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		
		if (! is_null($configs[3]))
		{
			$strChave = split("_", $configs[3]);
			$respostas = $this->BuscaRespostas($strChave[3]);
			$itensOpcoesExames = $this->BuscaConteudosAgrupador($strChave[3]);
		}
		
		if (! is_null($configs[2]))
			$html .= '<div class="item-cont">' . $configs[2] . "</div>";	/* Texto, pergunta ou mensagem para o aluno */
		
		foreach ($itens as $exams)
		{
			$bolMostrar = true;
			if (!is_null($configs[3]))
			{
				$ExameNaOutraLista = $this->ContemExameNaLista($exams->ContReferencia, $itensOpcoesExames);
				if (!is_null($ExameNaOutraLista))
				{
					if ((intval($ExameNaOutraLista->ValorOpt, 10) & intval($respostas, 10)) < intval(1, 10))
					{
						$bolMostrar = false;
					}
					else
					{
						$bolMostrar = true;
						$exams->ContReferencia = $ExameNaOutraLista->ContReferencia;
						//Log::RegistraLog("DEBUG REGIS 19 Deve mostrar o exame com ValorOpt: " . $exams->ValorOpt . " e código de referência: " . $exams->ContReferencia);
					}
				}
				else
				{
					$bolMostrar = false;
				}
			}
			if ($bolMostrar === true)
			{
				$ConfExame = $this->BuscaConfiguracoesItem($exams->Chave);
				$html .= ($html != '' ? '<div class="separador"></div>' : '');
				$html .= $this->RenderResultadoExame($exams->ContReferencia, $ConfExame);
			}
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Resultados dos exames solicitados]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("save", 'N');
		if (! is_null($configs[4]))
		{
			$hash->AddItem("fim", 'S');
			$hash->AddItem("menu", $this->BuscaMenusItem("resex", true));
		}
		else
		{
			$hash->AddItem("fim", 'N');
			$hash->AddItem("menu", $this->BuscaMenusItem("resex"));
		}
		
		return $hash;
	}
	
	private function RenderItensTratamento($itens, $chaveagrupador, $bolListagemSimples = false)
	{
		$u = unserialize($_SESSION['usu']);
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		$configs[1] = (is_null($configs[1]) ? "1" : $configs[1]);
		// Monta o IN para saber quais os diagnósticos deve apresentar conforme montagem
		$in = "";
		$arrvalores = array();
		foreach ($itens as $trats)
		{
			$in .= ($in == "" ? $trats->ContReferencia : ", " . $trats->ContReferencia);
			$arrvalores[$trats->ContReferencia] = $trats->ValorOpt;
		}
		$in = "IN(" . $in . ")";
		
		$cnn = Conexao2::getInstance();
		$respostas = $this->BuscaRespostas($chaveagrupador);
		//Log::RegistraLog("Respostas do aluno: " . $respostas);
		
		// Busca dados dos tratamentos
		$sql  = "SELECT CodTratamento, Titulo, Descricao, ConteudoAdicional FROM mescasotratamento ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodTratamento " . $in . ";";
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			die(print_r($cmd->errorInfo()));
		}
		
		$tratamentos = $cmd->fetchAll(PDO::FETCH_OBJ);

		if (count($tratamentos) > 0)
		{
			$titulo = (is_null($ConfGerais[5]) ? "@lng[Tratamento]" : $ConfGerais[5]);

			if ($bolListagemSimples === false)
			{
				$conteudo .= '<div class="item-cont">' . $configs[2] . "</div>";	/* Texto, pergunta ou mensagem para o aluno */
			}
			
			$cont = 0;
			foreach ($tratamentos as $item)
			{
				if ($bolListagemSimples === false)
				{
					$conteudo .= '<div class="tratamento-opcao" id="trat_' . $cont . '">';
					$conteudo .= '  <div class="tratamento-titulo">';
					$conteudo .= '    <span style="float:left;">';
				}
				else
				{
					$conteudo .= '<div class="tratamento-opcao" id="trat_' . $cont . '">';
				}
				
				if (($configs[1] == 1) || ($bolListagemSimples))	/* Opções de marcação (somente uma ou várias alternativas) */
					$conteudo .= '      <input type="checkbox" name="chkRespTrat[]" id="chkRespTrat_' . $cont . '" value="' . $arrvalores[$item->CodTratamento] . '" ' . (((intval($arrvalores[$item->CodTratamento], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" />';
				else
					$conteudo .= '      <input type="radio" name="chkRespTrat[]" id="chkRespTrat_' . $cont . '" value="' . $arrvalores[$item->CodTratamento] . '" ' . (((intval($arrvalores[$item->CodTratamento], 10) & intval($respostas, 10)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" />';
				$conteudo .= '    ' . $item->Titulo;
				
				if ($bolListagemSimples === false)
				{
					$conteudo .= '    </span><span style="float:right;"><span id="rt_' . $cont . '" class="vazio">&nbsp;</span><img src="img/pergunta.png"></span>';
					$conteudo .= '  </div>';
					
					$conteudo .= '  <div class="tratamento-opcoes">@lng[Opções]: ';
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
				}
				else
				{
					$conteudo .= '</div>';
				}
				
				$cont++;
			}
		}
		else
		{
			$titulo = "@lng[Erro tratamentos]";
			$conteudo = "@lng[Nenum registro encontrado]. " . $trat->getErro();
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", $titulo);
		$hash->AddItem("conteudo", $conteudo);
		$hash->AddItem("menu", $this->BuscaMenusItem("trat", false, $configs));
		$hash->AddItem("save", 'S');
		
		return $hash;
	}
	
	private function RenderPergunta($chaveagrupador, $codpergunta, $confs, $bolListagemSimples = false)
	{
		//Log::RegistraLog("Chamou o renderPergunta passando o pergunta " . $codpergunta);
		$pergunta = new Pergunta();
		if ($pergunta->Carregar($codpergunta))
		{
			$respostas = $this->BuscaRespostas($chaveagrupador, $codpergunta);
			
			$html .= '<div class="pergunta">';
			$html .= '  <div id="pergunta-texto">';
			$html .= '    <img id="img_perg_' . $codpergunta . '" src="img/question.png" alt="@lng[Pergunta]" title="@lng[Pergunta]" class="img-pergunta atualizar-resp">' . $pergunta->getTexto();
			$html .= '  </div>';
			
			$alternativas = $pergunta->getAlternativas();
			
			$cont = 1;
			$letra = 65;
			$agrupar = true;
			foreach ($alternativas as $alt)
			{
				switch ($pergunta->getTipo()->getCodigo())
				{
					case 1:
						$html .= '<div class="alt-img">';
						$html .= '  <div class="alt-img-radio">';
						$html .= '    ' . chr($letra) . ') <input type="' . ($bolListagemSimples ? 'checkbox' : 'radio') . '" name="rdoAlternativa_' . $pergunta->getCodigo() . '[]" id="rdoAlt_' . $pergunta->getCodigo() . '_' . $cont . '" value="' . $alt->getCodBinario() . '" ' . (((intval($alt->getCodBinario()) & intval($respostas)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" />';
						$html .= '  </div>';
						$html .= '  <div id="img"><img src="' . $alt->getImagem() . '" alt="' . $alt->getTexto() . '" title="' . $alt->getTexto() . '" /></div>';
						$html .= '</div>';
						break;
					case 2:
						$html .= '<div class="alt-txt">';
						$html .= '  ' . chr($letra) . ') <input type="checkbox" name="rdoAlternativa_' . $pergunta->getCodigo() . '[]" id="rdoAlt_' . $pergunta->getCodigo() . '_' . $cont . '" value="' . $alt->getCodBinario() . '" ' . (((intval($alt->getCodBinario()) & intval($respostas)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" />' . $alt->getTexto();
						$html .= '</div>';
						break;
					case 3:
						$html .= '<div class="alt-txt">';
						$html .= '  ' . chr($letra) . ') <input type="' . ($bolListagemSimples ? 'checkbox' : 'radio') . '" name="rdoAlternativa' . (($agrupar) ? ('_' . $pergunta->getCodigo()) : '') . '[]" id="rdoAlt_' . $pergunta->getCodigo() . '_' . $cont . '" value="' . $alt->getCodBinario() . '" ' . (((intval($alt->getCodBinario()) & intval($respostas)) > 0) ? 'checked="checked"' : '') . ' class="opcao-resposta" />' . $alt->getTexto();
						$html .= '</div>';
						break;
				}
				$cont++;
				$letra++;
			}
			$html .= '</div>';
		}
		else
		{
			$html = "Erro: " . $pergunta->msg_erro;
		}
		return $html;
	}
	
	private function RenderItensPergunta($itens, $chaveagrupador, $bolListagemSimples = false)
	{
		//Log::RegistraLog("Chamou o renderItensPergunta");
		$ConfGerais = $this->BuscaConfiguracoesItem($chaveagrupador);
		
		foreach ($itens as $perg)
		{
			$ConfPerg = $this->BuscaConfiguracoesItem($perg->Chave);
			$html .= $this->RenderPergunta($chaveagrupador, $perg->ContReferencia, $ConfPerg, $bolListagemSimples);
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($ConfGerais[5]) ? "@lng[Pergunta]" : $ConfGerais[5]));
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("menu", $this->BuscaMenusItem("perg", false, $ConfGerais));
		$hash->AddItem("save", 'S');
		
		return $hash;
	}
	
	private function RenderAgrupamento($chaveagrupador, $codgrupo, $confs, $bolListagemSimples = false)
	{
		//Log::RegistraLog("Chamou o RenderAgrupamentos passando o agrupamento " . $codgrupo);
		$agrupamento = new GrupoPergunta();
		if ($agrupamento->Carrega($codgrupo))
		{
			$html .= '<div class="todas-perguntas">';
			$html .= '<div class="tit-item">' . $agrupamento->getTexto() . '</div>';
			$perguntas = $agrupamento->getPerguntas();
			foreach ($perguntas as $pergunta)
			{
				$html .= $this->RenderPergunta($chaveagrupador, $pergunta, null, $bolListagemSimples);
			}
			$html .= '</div>';
			$html .= '<div class="organizador" style="float:right;width:470px;margin-top:10px;"></div>';
		}
		else
		{
			$html = "Erro: " . $agrupamento->getErro();
		}
		return $html;
	}
	
	private function RenderItensAgrupamentos($itens, $chaveagrupador, $bolListagemSimples = false)
	{
		//Log::RegistraLog("Chamou o RenderItensAgrupamentos com a chave de agrupamento " . $chaveagrupador);
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		foreach ($itens as $item)
		{
			$ConfAgrupamento = $this->BuscaConfiguracoesItem($item->Chave);
			$html .= ($html != '' ? '<div class="separador"></div>' : '');
			$html .= $this->RenderAgrupamento($chaveagrupador, $item->ContReferencia, $confs, $bolListagemSimples);
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Exercícios]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		$hash->AddItem("menu", $this->BuscaMenusItem("grupo-perg", false, $configs));
		$hash->AddItem("save", 'S');
		
		return $hash;
	}
	
	private function RenderHTML($codconteudo)
	{
		//Log::RegistraLog("Chamou o renderHTML passando o conteúdo " . $codconteudo);
		$conteudo = new Conteudo();
		if ($conteudo->Carrega($this->codcaso, $codconteudo))
		{
			$tit = $conteudo->getDescricao();
			$cont = $conteudo->getTexto();
		}
		else
		{
			$cont = "@lng[Conteúdo] " . $codconteudo . " @lng[não encontrado]";
		}
		
		$html = '<div class="tit-item">' . $tit . '</div>' . $cont;
		return $html;
	}
	
	private function RenderItensHTML($itens, $chaveagrupador)
	{
		//Log::RegistraLog("Chamou o renderItensHTML");
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		if (!$configs)
		{
			$configs = $this->BuscaConfiguracoesDetault();
		}
		
		foreach ($itens as $item)
		{
			$html .= (($html != '') ? '<div class="separador"></div>' : '');
			$html .= $this->RenderHTML($item->ContReferencia);
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Conteúdo]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		//$hash->AddItem("menu", $this->BuscaMenusItem("html"));
		$hash->AddItem("save", 'N');
		//Log::RegistraLog("Configuração de finalizar o caso: " . $configs[4]);
		if (! is_null($configs[4]))
		{
			$hash->AddItem("fim", 'S');
			$hash->AddItem("menu", $this->BuscaMenusItem("html", true));
		}
		else
		{
			$hash->AddItem("fim", 'N');
			$hash->AddItem("menu", $this->BuscaMenusItem("html"));
		}
		return $hash;
	}
	
	private function RenderImagem($codmidia, $confs)
	{
		//Log::RegistraLog("Chamou o RenderImagem passando a imagem " . $codmidia);
		$midia = new Midia();
		$midia->setCodCaso($this->codcaso);
		$midia->setCodMidia($codmidia);
		if ($midia->CarregaPorCodigoEspecifico())
		{
			if ((!is_null($confs[5])) && ($confs[5] != ''))
			{
				$html .= '<div class="tit-item">' . $confs[5] . '</div>';
			}
			$html .= '<img class="img-apres" src="viewimagem.php?img=' . base64_encode($codmidia) . '" title="' . $midia->getDescricao() . '" alt="' . $midia->getDescricao() . '" /><br />';
			$html .= '<div class="descr-img"><strong>@lng[Descrição]: </strong>' . $midia->getDescricao() . '</div>';
			$html .= '<div class="descr-img"><strong>@lng[Complemento]: </strong>' . $midia->getComplemento() . '</div>';
			$html .= '<div class="separador"></div>';
		}
		else
		{
			$html .= '@lng[Erro ao carregar mídia]: ' . $midia->getErro();
		}
		return $html;
	}
	
	private function RenderItensImagem($itens, $chaveagrupador)
	{
		//Log::RegistraLog("Chamou o renderItensImagem");
		$ConfGerais = $this->BuscaConfiguracoesItem($chaveagrupador);
		if (!$ConfGerais)
		{
			$ConfGerais = $this->BuscaConfiguracoesDetault();
		}
		
		foreach ($itens as $imgs)
		{
			$ConfImg = $this->BuscaConfiguracoesItem($imgs->Chave);
			if (!$ConfImg)
			{
				$ConfImg = $this->BuscaConfiguracoesDetault();
			}
			$html .= $this->RenderImagem($imgs->ContReferencia, $ConfImg);
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($ConfGerais[5]) ? "@lng[Imagens]" : $ConfGerais[5]));
		$hash->AddItem("conteudo", $html);
		//$hash->AddItem("menu", $this->BuscaMenusItem("img"));
		$hash->AddItem("save", 'N');
		if (! is_null($ConfGerais[4]))
		{
			$hash->AddItem("fim", 'S');
			$hash->AddItem("menu", $this->BuscaMenusItem("img", true));
		}
		else
		{
			$hash->AddItem("fim", 'N');
			$hash->AddItem("menu", $this->BuscaMenusItem("img"));
		}
		
		return $hash;
	}
	
	private function RenderVideo($codmidia, $confs)
	{
		//Log::RegistraLog("Chamou o RenderVideo passando o vídeo " . $codmidia);
		$midia = new Midia();
		$midia->setCodCaso($this->codcaso);
		$midia->setCodMidia($codmidia);
		if ($midia->CarregaPorCodigoEspecifico())
		{
			$player = new VideoPlayer($midia->getURL() , 320, 290, 'false', 'true');
			if ($player)
			{
				if ((!is_null($confs[5])) && ($confs[5] != ''))
				{
					$html .= '<div class="tit-item">' . $confs[5] . '</div>';
				}
				$html .= $player->player();
				$html .= '<div class="descr-img"><strong>@lng[Descrição]: </strong>' . $midia->getDescricao() . '</div>';
				$html .= '<div class="descr-img"><strong>@lng[Complemento]: </strong>' . $midia->getComplemento() . '</div>';
				$html .= '<div class="separador"></div>';
			}
			else
			{
				$html .= '@lng[Erro ao carregar mídia]: ' .$player->getLastError();
			}
		}
		else
		{
			$html .= '@lng[Erro ao carregar mídia]: ' . $midia->getErro();
		}
		return $html;
	}
	
	private function RenderAudio($codmidia, $confs)
	{
		//Log::RegistraLog("Chamou o RenderAudio passando o audio " . $codmidia);
		$midia = new Midia();
		$midia->setCodCaso($this->codcaso);
		$midia->setCodMidia($codmidia);
		if ($midia->CarregaPorCodigoEspecifico())
		{
			$player = new AudioPlayer($midia->getURL());
			if ($player)
			{
				if ((!is_null($confs[5])) && ($confs[5] != ''))
				{
					$html .= '<div class="tit-item">' . $confs[5] . '</div>';
				}
				$html .= $player->player();
				$html .= '<div class="descr-img"><strong>@lng[Descrição]: </strong>' . $midia->getDescricao() . '</div>';
				$html .= '<div class="descr-img"><strong>@lng[Complemento]: </strong>' . $midia->getComplemento() . '</div>';
				$html .= '<div class="separador"></div>';
			}
			else
			{
				$html .= '@lng[Erro ao carregar mídia]: ' .$player->getLastError();
			}
		}
		else
		{
			$html .= '@lng[Erro ao carregar mídia]: ' . $midia->getErro();
		}
		return $html;
	}
	
	private function RenderDocumento($codmidia, $confs)
	{
		Log::RegistraLog("Chamou o RenderDocumento passando o documento " . $codmidia . " e Código do caso " . ($this->codcaso ? $this->codcaso : "nullo"));
		$midia = new Midia();
		$midia->setCodCaso($this->codcaso);
		$midia->setCodMidia($codmidia);
		if ($midia->CarregaPorCodigoEspecifico())
		{
			$html .= '<div class="descr-img"><a href="' . $midia->getURL() . '" title="@lng[Clique para acessar o arquivo]"><strong>' . $midia->getDescricao() . '</strong></a></div>';
			$html .= '<div class="descr-img"><strong>@lng[Complemento]: </strong>' . $midia->getComplemento() . '</div>';
			$html .= '<div class="separador"></div>';
		}
		else
		{
			$html .= '@lng[Erro ao carregar mídia]: ' . $midia->getErro();
		}
		return $html;
	}
	
	private function RenderItensMidia($tipo, $itens, $chaveagrupador)
	{
		Log::RegistraLog("Chamou o RenderItensMidia com o tipo: " . $tipo);
		$ConfGerais = $this->BuscaConfiguracoesItem($chaveagrupador);
		if (!$ConfGerais)
		{
			$ConfGerais = $this->BuscaConfiguracoesDetault();
		}
		
		foreach ($itens as $midia)
		{
			$ConfImg = $this->BuscaConfiguracoesItem($midia->Chave);
			if (!$ConfImg)
			{
				$ConfImg = $this->BuscaConfiguracoesDetault();
			}
			if ($tipo == 'vid')
			{
				$html .= $this->RenderVideo($midia->ContReferencia, $ConfImg);
			}
			else if ($tipo == 'aud')
			{
				$html .= $this->RenderAudio($midia->ContReferencia, $ConfImg);
			}
			else if ($tipo == 'doc')
			{
				$html .= $this->RenderDocumento($midia->ContReferencia, $ConfImg);
			}
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($ConfGerais[5]) ? "@lng[Mídia]" : $ConfGerais[5]));
		$hash->AddItem("conteudo", $html);
		//$hash->AddItem("menu", $this->BuscaMenusItem($tipo));
		$hash->AddItem("save", 'N');
		if (! is_null($ConfGerais[4]))
		{
			$hash->AddItem("fim", 'S');
			$hash->AddItem("menu", $this->BuscaMenusItem($tipo, true));
		}
		else
		{
			$hash->AddItem("fim", 'N');
			$hash->AddItem("menu", $this->BuscaMenusItem($tipo));
		}
		
		return $hash;
	}
	
	private function RenderDesfecho($coddes, $confs)
	{
		$desfecho = new Desfecho();
		if ($desfecho->Carrega($this->codcaso, $coddes))
		{
			$html .= '<div class="tit-item">' . $desfecho->getTitulo() . '</div>';
			$html .= $desfecho->getDesfecho();
		}
		else
		{
			//Log::RegistraLog("NÃO carregou o desfecho. Erro: " . $desfecho->getErro());
			$html = $desfecho->getErro();
		}
		return $html;
	}
	
	private function RenderItensDesfecho($itens, $chaveagrupador)
	{
		//Log::RegistraLog("Chamou o renderItensDesfecho");
		$configs = $this->BuscaConfiguracoesItem($chaveagrupador);
		
		foreach ($itens as $des)
		{
			$html .= (($html != '') ? '<div class="separador"></div>' : '');
			$html .= $this->RenderDesfecho($des->ContReferencia, $configs);
		}
		
		$hash = new HashTable();
		$hash->AddItem("titulosecao", (is_null($configs[5]) ? "@lng[Desfechos]" : $configs[5]));
		$hash->AddItem("conteudo", $html);
		//$hash->AddItem("menu", $this->BuscaMenusItem("des"));
		$hash->AddItem("save", 'N');
		if (is_null($configs[6]))
		{
			//Log::RegistraLog("DEBUG DESF - Configuração 6 não é nula. valor: " . $configs[6]);
			$hash->AddItem("fim", 'S');
			$hash->AddItem("menu", $this->BuscaMenusItem("des", true));
		}
		else
		{
			//Log::RegistraLog("DEBUG DESF - Configuração 6 É NULLA. valor: " . $configs[6]);
			$hash->AddItem("fim", 'N');
			$hash->AddItem("menu", $this->BuscaMenusItem("des"));
		}
		return $hash;
	}
	
	private function renderPadrao($mensagem)
	{
		$hash = new HashTable();
		
		$hash->AddItem("titulosecao", "@lng[Visualização de conteúdo. Teste navegação]");
		$hash->AddItem("conteudo", $mensagem);
		$hash->AddItem("menu", $this->BuscaMenusItem('exfis'));
		
		return $hash;
	}
	
	public function MontaTelaExibicaoAgrupador($itens, $tipocontagrupador, $chaveagrupador, $bolListagemSimples = false)
	{
		switch ($tipocontagrupador)
		{
			case "hip":
				$htcont = $this->RenderItensHipotesesDiagnosticas($itens, $chaveagrupador, $bolListagemSimples);
				break;
			case "optex":
				$htcont = $this->RenderItensOpcoesExame($itens, $chaveagrupador, $bolListagemSimples);
				break;
			case "resex":
				$htcont = $this->RenderItensResultadosExames($itens, $chaveagrupador);
				break;
			case "diag":
				$htcont = $this->RenderItensDiagnostico($itens, $chaveagrupador, $bolListagemSimples);
				break;
			case "trat":
				$htcont = $this->RenderItensTratamento($itens, $chaveagrupador, $bolListagemSimples);
				break;
			case "des":
				$htcont = $this->RenderItensDesfecho($itens, $chaveagrupador);
				break;
			case "html":
				$htcont = $this->RenderItensHTML($itens, $chaveagrupador);
				break;
			case "img":
				$htcont = $this->RenderItensImagem($itens, $chaveagrupador);
				break;
			case "vid":
				$htcont = $this->RenderItensMidia('vid', $itens, $chaveagrupador);
				break;
			case "aud":
				$htcont = $this->RenderItensMidia('aud', $itens, $chaveagrupador);
				break;
			case "doc":
				$htcont = $this->RenderItensMidia('doc', $itens, $chaveagrupador);
				break;
			case "perg":
				$htcont = $this->RenderItensPergunta($itens, $chaveagrupador, $bolListagemSimples);
				break;
			case "grupo-perg":
				$htcont = $this->RenderItensAgrupamentos($itens, $chaveagrupador, $bolListagemSimples);
				break;
		}
		$htcont->AddItem("saibamais", $this->BuscaDadosSaibaMais($chaveagrupador));
		return $htcont;
	}
	
	public function MontaTelaExibicao($organizador, $tipo, $chavemostrar, $codcontref)
	{
		$html = "";
		$htcont = new HashTable();
		
		if ($organizador == "raiz")
		{
			// Se for a raiz, exibo os objetivos.
			$objetivos = new Objetivo();
			$objetivos->setCodcaso($_SESSION['casores']);
			$lista = $objetivos->ListaRecordSet();
			
			if ($lista)
			{
				$html = '<ul class="objetivos-caso">';
				
				foreach ($lista as $objetivo)
				{
					$html .= '<li>' . $objetivo->Descricao . '</li>';
				}
				$html .= '</ul>';
				
				$htcont->AddItem("conteudo", $html);
			}
			else
			{
				$htcont->AddItem("conteudo", "@lng[Não foi possível recuperar o conteudo. Detalhes:] " . $objetivos->getErro());
			}
			
			$htcont->AddItem("titulosecao", "@lng[Objetivos do caso]");
			$htcont->AddItem("chave", $chavemostrar);
			$htcont->AddItem("menu", $this->BuscaMenusItem($tipo));
			$htcont->AddItem("saibamais", $this->BuscaDadosSaibaMais($chavemostrar));
		}
		else if ($organizador == "cont")
		{
			//Log::RegistraLog("Organizador enviado: " . $organizador);
			switch ($tipo)
			{
				case 'an':
					$htcont = $this->RenderAnamnese(1);
					if ($htcont)
					{
						$htcont->AddItem("chave", $chavemostrar);
					}
					else
					{
						$htcont = new HashTable();
						$htcont->AddItem("conteudo", "@lng[Não foi possível recuperar o conteudo. Detalhes:] " . $this->getErro());
					}
					break;
				case 'aninv':
					$htcont = $this->RenderAnamnese(2);
					if ($htcont)
					{
						$htcont->AddItem("chave", $chavemostrar);
					}
					else
					{
						$htcont = new HashTable();
						$htcont->AddItem("conteudo", "@lng[Não foi possível recuperar o conteúdo. Detalhes:] " . $this->getErro());
					}
					break;
				case 'exfis':
					$htcont = $this->RenderExameFisico();
					if ($htcont)
					{
						$htcont->AddItem("chave", $chavemostrar);
					}
					break;
				case "optex":
					$htcont = $this->renderPadrao('optex telaexibicao');
					break;
				case "resex":
					$htcont = $this->renderPadrao('resex telaexibicao');
					break;
				case "diag":
					$htcont = $this->renderPadrao('diag telaexibicao');
					break;
				case "trat":
					$htcont = $this->renderPadrao('trat telaexibicao');
					break;
				case "des":
					$htcont = $this->renderPadrao('des telaexibicao');
					break;
				case 'html':
					$htcont = $this->renderHTML($codcontref);
					break;
				case 'img':
					$htcont = $this->renderPadrao('img telaexibicao');
					break;
				case 'vid':
					$htcont = $this->renderPadrao('vid telaexibicao');
					break;
				case 'aud':
					$htcont = $this->renderPadrao('aud telaexibicao');
					break;
				case "perg":
					$htcont = $this->renderPadrao('perg telaexibicao');
					break;
				case "grupo-perg":
					$htcont = $this->renderPadrao('grupo-perg telaexibicao');
					break;
			}
			$htcont->AddItem("saibamais", $this->BuscaDadosSaibaMais($chavemostrar));
		}
		else if ($organizador == "agr")
		{
			$htcont->AddItem("conteudo", "Aguarde");
		}
		return $htcont;
	}
	#######################################################
	
	public function RegistraVisitaNodo($chave, $controle = 0)
	{
		$chave = split("_", $chave);
		$codmontagem = 1;
		$insere = true;
		$u = unserialize($_SESSION['usu']);
		
		$this->setCodresolucao($_SESSION['codresolucao']);
		$ultimo = $this->BuscaUltimoNodoVisitado();
		
		if (($ultimo !== false) && ($ultimo != -1))
		{
			$ultimo = split("_", $ultimo);
			if ($ultimo[3] == $chave[3])
			{
				$insere = false;
			}
		}
		
		if ($insere)
		{
			$sql  = "INSERT INTO mesresolucaovisconteudo(CodResolucao, CodAcesso, CodCaso, CodMontagem, CodChave, DataHora, SoControle) ";
			$sql .= "VALUES(:pCodResolucao, :pCodAcesso, :pCodCaso, :pCodMontagem, :pCodChave, CURRENT_TIMESTAMP, :pSoControle);";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodResolucao", $_SESSION['codresolucao'], PDO::PARAM_INT);
			$cmd->bindParam(":pCodAcesso", $u->getIdAcessoAtual(), PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodMontagem", $codmontagem, PDO::PARAM_INT);
			$cmd->bindParam(":pCodChave", $chave[3], PDO::PARAM_STR);
			$cmd->bindParam(":pSoControle", $controle, PDO::PARAM_INT);
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
			return true;
		}
	}
	
	public function BuscaConfiguracoesItem($chaveitem)
	{
		$sql  = "SELECT CodConfig, CASE WHEN Valor = '' THEN NULL ELSE Valor END AS Valor ";
		$sql .= "FROM mescasomontagemvalconfigs ";
		$sql .= "WHERE CodCaso = :pCodCaso ";
		$sql .= "  AND CodMontagem = 1 ";
		$sql .= "  AND Chave = :pChaveItem;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveItem", $chaveitem, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_KEY_PAIR);
			}
			else
			{
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
	
	public function BuscaConfiguracoesDetault()
	{
		$configs = array();
		$configs[1] = 1;		// Opção de multipla escolha
		$configs[2] = "";		// Pensamento/reflexão
		$configs[3] = null;		// Desvio condicional
		$configs[4] = false;	// Fim do caso
		$configs[5] = "&nbsp;";	// Título da seção
		$configs[6] = true;		// Não é o fim do caso
		$configs[7] = false;	// Resposta imediata
	}
	
	private function BuscaMenusItem($tipoconteudo, $bolFim = false, $arrConfigs = null)
	{
		$sql  = "select Texto, Imagem, Acao ";
		$sql .= "from mesresolucaomenu ";
		$sql .= "where (Telas & (select CodBinario from mestipoitem where Codigo = :pTipoConteudo)) > 0 ";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pTipoConteudo", $tipoconteudo, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				while ($item = $cmd->fetch(PDO::FETCH_OBJ))
				{
					if (strtoupper($item->Texto) != "AVANÇAR")
					{
						$html .= '<a href="javascript:void(0);" onclick="' . $item->Acao . '" title="' . $item->Texto . '">';
						$html .= '<img src="' . $item->Imagem . '" class="botao" />';
						$html .= '</a>';
					}
					else
					{
						if ($bolFim !== true)
						{
							$html .= '<a href="javascript:void(0);" onclick="' . $item->Acao . '" title="' . $item->Texto . '">';
							$html .= '<img src="' . $item->Imagem . '" class="botao" />';
							$html .= '</a>';
						}
					}
				}
				
				if ((($tipoconteudo == 'des') && ($bolFim === true)) || (($tipoconteudo != 'des') && ($bolFim === true)))
				{
					$html .= '<a href="javascript:void(0);" onclick="javascript:fntMostraResumo();" title="@lng[Ver resumo do caso]">';
					$html .= '<img src="img/resumo.png" class="botao" />';
					$html .= '</a>';
				}
				
				$html .= '<a href="javascript:void(0);" onclick="javascript:fntMostraSaibaMais();" title="@lng[Saiba Mais]" class="btnSaibaMais" style="display:none;">';
				$html .= '<img src="img/saiba_mais_texto.png" class="botao" />';
				$html .= '</a>';
				
				if (! is_null($arrConfigs))
				{
					if (! is_null($arrConfigs[7]))
					{
						$html .= '<a href="javascript:void(0);" onclick="javascript:fntResponde();" title="@lng[Verificar as respostas corretas]">';
						$html .= '<img src="img/resp_certas.png" class="botao" />';
						$html .= '</a>';
					}
				}
			}
			else
			{
				$html = '<strong>@lng[Nenhum item encontrado]</strong>';
			}
			return $html;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return $this->msg_erro;
		}
	}
	
	private function BuscaDadosSaibaMais($chaveAtual)
	{
		$sql  = "select mescasomontagemanexos.TipoConteudo, mescasomontagemanexos.CodConteudo ";
		$sql .= "	, mesmidia.Descricao as DescricaoMidia, mesmidia.Complemento as ComplementoMidia, mesmidia.url as UrlMidia, mesmidia.CodTipo as CodTipoMidia ";
		$sql .= "	, mescasoconteudo.Descricao as DescricaoConteudo, mescasoconteudo.Texto as TextoConteudo, mescasoconteudo.Tipo as CodTipoConteudo ";
		$sql .= "from mescasomontagemanexos ";
		$sql .= "left outer join mesmidia ";
		$sql .= " 	ON mesmidia.CodCaso = mescasomontagemanexos.CodCaso ";
		$sql .= " 	AND mesmidia.CodMidia = mescasomontagemanexos.CodConteudo ";
		$sql .= "left outer join mescasoconteudo ";
		$sql .= " 	ON mescasoconteudo.CodCaso = mescasomontagemanexos.CodCaso ";
		$sql .= " 	AND mescasoconteudo.CodConteudo = mescasomontagemanexos.CodConteudo ";
		$sql .= "where CodChave = :pCodChave ";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodChave", $chaveAtual, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$html = '';
				while ($item = $cmd->fetch(PDO::FETCH_OBJ))
				{
					if (strtoupper($item->TipoConteudo) == "C")
					{
						$html .= '<strong>' . $item->DescricaoConteudo . '</strong>';
						$html .= '<br />' . $item->TextoConteudo;
					}
					else
					{
						if ($item->CodTipoMidia == Comuns::TIPO_MIDIA_VIDEO)
						{
							$vidplayer = new VideoPlayer($item->UrlMidia, 320, 290, 'false', 'true');
							if ($vidplayer)
							{
								$html .= '<strong>' . $item->DescricaoMidia . '</strong>';
								$html .= '<p>' . $item->ComplementoMidia . '</p>';
								$html .= '<br />' . $vidplayer->player();
							}
							else
							{
								$html = "@lng[ERRO ao gerar vídeo]";
							}
						}
						else if ($item->CodTipoMidia == Comuns::TIPO_MIDIA_AUDIO)
						{
							$audplayer = new AudioPlayer($item->UrlMidia, 'false', 'true');
							if ($audplayer)
							{
								$html .= '<strong>' . $item->DescricaoMidia . '</strong>';
								$html .= '<p>' . $item->ComplementoMidia . '</p>';
								$html .= '<br />' . $audplayer->player();
							}
							else
							{
								$html = "ERRO";
							}
						}
						else if ($item->CodTipoMidia == Comuns::TIPO_MIDIA_IMAGEM)
						{
							$html .= '<strong>' . $item->DescricaoMidia . '</strong>';
							$html .= '<p>' . $item->ComplementoMidia . '</p>';
							$html .= '<br /><img src="viewimagem.php?img=' . base64_encode($item->CodConteudo) . '&ex=f" alt="' . $item->DescricaoMidia . '" title="' . $item->DescricaoMidia . '" /></player>';
						}
						else
						{
							$html .= '<strong>' . $item->DescricaoMidia . '</strong>';
							$html .= '<p>' . $item->ComplementoMidia . '</p>';
							$html .= '<a href="' . $item->UrlMidia . '">Download</a>';
						}
					}
				}
			}
			return $html;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			//return false;
			return $this->msg_erro;
		}
	}
	
	public function BuscaStatusAndamento()
	{
		$sql  = "SELECT CodSituacao ";
		$sql .= "FROM mesresolucao res ";
		$sql .= "WHERE CodCaso = :pCodCaso ";
		$sql .= "  AND CodUsuario = :pCodUsuario ";
		$sql .= "  AND CodResolucao = (	SELECT MAX(CodResolucao) as Resolucao ";
		$sql .= "						FROM mesresolucao res2 ";
		$sql .= "						WHERE res2.CodCaso = res.CodCaso ";
		$sql .= "						  AND res2.CodUsuario = res.CodUsuario);";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
				return $cmd->fetchColumn();
			else
				return 1;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function BuscaConteudoPelaChave($idnodo, $bolListagemSimples = false)
	{
		$idnodo = split("_", $idnodo);
		$organizador = $idnodo[0];
		$tipocotneudo = $idnodo[1];
		$conteudoref = $idnodo[2];
		$chave = $idnodo[3];
		
		if ($organizador == "agr")
		{
			$itens = $this->BuscaConteudosAgrupador($chave);
			
			$ht = $this->MontaTelaExibicaoAgrupador($itens, $tipocotneudo, $chave, $bolListagemSimples);
			foreach ($itens as $item)
			{
				//Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, ValorOpt, Ordem
				$marcar .= ($marcar != "" ? ';' : '') . 
					$item->Organizador . '_' . 
					$item->TipoConteudo . '_' . 
					$item->ContReferencia . '_' . 
					$item->Chave;
			}
			$ht->AddItem("visitados", $marcar);
		}
		else
		{
			$ht = $this->MontaTelaExibicao($organizador, $tipocotneudo, $chave, $conteudoref);
		}
		return $ht;
	}
	
	public function BuscaSaltosConteudo($strChaveAtual)
	{
		$sql  = "select ";
		$sql .= "	 concat(dest.Organizador, '_', dest.TipoConteudo, '_', dest.ContReferencia, '_', salt.ChaveDestino) as ChaveDestino ";
		$sql .= "	,salt.ChaveCond ";
		$sql .= "	,cond.TipoConteudo as TipoContCond ";
		$sql .= "	,salt.CodPergunta ";
		$sql .= "	,salt.RespostaCond ";
		$sql .= "from mescasomontagemsaltos salt ";
		$sql .= "inner join mescasomontagem mont ";
		$sql .= "		on mont.CodCaso = salt.CodCaso ";
		$sql .= "	   and mont.CodMontagem = salt.CodMontagem ";
		$sql .= "	   and mont.Chave = salt.ChaveAtual ";
		$sql .= "inner join mescasomontagem dest ";
		$sql .= "		on dest.CodCaso = salt.CodCaso ";
		$sql .= "	   and dest.CodMontagem = salt.CodMontagem ";
		$sql .= "	   and dest.Chave = salt.ChaveDestino ";
		$sql .= "left outer join mescasomontagem cond ";
		$sql .= "			 on cond.CodCaso = salt.CodCaso ";
		$sql .= "			and cond.CodMontagem = salt.CodMontagem ";
		$sql .= "			and cond.Chave = salt.ChaveCond ";
		$sql .= "where salt.CodCaso = :pCodCaso ";
		$sql .= "  and salt.CodMontagem = 1 ";
		$sql .= "  and salt.ChaveAtual = :pChaveAtual;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $strChaveAtual, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$strProximoItem = "";
				$sair = false;
				
				while ($salto = $cmd->fetch(PDO::FETCH_OBJ))
				{
					if (is_null($salto->ChaveCond))
					{
						$strProximoItem = $salto->ChaveDestino;
						break;
					}
					else
					{
						if (($salto->TipoContCond != 'perg') && ($salto->TipoContCond != 'grupo-perg'))
						{
							$respostas = $this->BuscaRespostas($salto->ChaveCond);
							$itens = $this->BuscaConteudosAgrupador($salto->ChaveCond, $salto->RespostaCond);
							
							foreach ($itens as $opcao)
							{
								if ((intval($opcao->ValorOpt, 10) & intval($respostas, 10)) > 0)
								{
									$strProximoItem = $salto->ChaveDestino;
									$sair = true;
									break;
								}
							}
						}
						else
						{
							$respostas = $this->BuscaRespostas($salto->ChaveCond, $salto->CodPergunta);
							
							$p = new Pergunta();
							$p->setCodigo($salto->CodPergunta);
							$itens = $p->BuscaAlternativasFiltradas($salto->RespostaCond);
							
							if (count($itens) > 0)
							{
								foreach ($itens as $opcao)
								{
									if ((intval($opcao->getCodBinario(), 10) & intval($respostas, 10)) > 0)
									{
										$strProximoItem = $salto->ChaveDestino;
										$sair = true;
										break;
									}
								}
							}
							else
							{
								return 0;
							}
						}
						if ($sair)
						{
							break;
						}
					}
				}
				
				if ($strProximoItem != "")
				{
					return $strProximoItem;
				}
				else
				{
					return 0;
				}
			}
			else
			{
				return 0;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function BuscaNodoRaiz()
	{
		$sql  = "select Chave "; 
		$sql .= "from mescasomontagem ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodMontagem = 1 ";
		$sql .= "  and TipoConteudo = 'raiz' ";
		$sql .= "  and Organizador = 'raiz'";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchColumn();
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

	public function BuscaUltimoNodoVisitado()
	{
		$sql  = "select mon.Chave, mon.TipoConteudo, mon.Organizador, mon.ContReferencia, vis.DataHora ";
		$sql .= "from mesresolucaovisconteudo vis ";
		$sql .= "inner join mescasomontagem mon ";
		$sql .= "		on mon.CodCaso = vis.CodCaso ";
		$sql .= "	   and mon.CodMontagem = vis.CodMontagem ";
		$sql .= "	   and mon.Chave = vis.CodChave ";
		$sql .= "where vis.CodResolucao = :pCodResolucao ";
		$sql .= "  and vis.CodCaso = :pCodCaso ";
		$sql .= "order by vis.DataHora desc ";
		$sql .= "limit 0,1;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$linha = $cmd->fetch(PDO::FETCH_OBJ);
				$ret = $linha->Organizador . '_' . $linha->TipoConteudo . '_' . $linha->ContReferencia . '_' . $linha->Chave;
				return $ret;
			}
			else
			{
				return -1;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function BuscaTodosMenosUltimoVisitado()
	{
		$sql  = "select concat(mon.Organizador, '_', mon.TipoConteudo, '_', mon.ContReferencia, '_', vis.CodChave) as Chave ";
		$sql .= "from mesresolucaovisconteudo vis ";
		$sql .= "inner join mescasomontagem mon ";
		$sql .= "		on mon.CodCaso = vis.CodCaso ";
		$sql .= "	   and mon.CodMontagem = vis.CodMontagem ";
		$sql .= "	   and mon.Chave = vis.CodChave ";
		$sql .= "where vis.CodResolucao = :pCodResolucao ";
		$sql .= "  and vis.CodCaso = :pCodCaso ";
		$sql .= "  and vis.CodChave <> ( ";
		$sql .= "	select CodChave ";
		$sql .= "	from mesresolucaovisconteudo vis2 ";
		$sql .= "	where vis2.CodResolucao = vis.CodResolucao ";
		$sql .= "	  and vis2.CodCaso = vis.CodCaso ";
		$sql .= "	order by vis2.DataHora desc ";
		$sql .= "	limit 0,1 ";
		$sql .= "	) ";
		$sql .= "order by vis.DataHora asc";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$arr = $cmd->fetchAll(pdo::FETCH_COLUMN);
				return implode(";", $arr);
			}
			else
			{
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
	
	public function BuscaTodosNodosVisitados()
	{
		$sql  = "select concat(mon.Organizador, '_', mon.TipoConteudo, '_', mon.ContReferencia, '_', vis.CodChave) as Chave ";
		$sql .= "from mesresolucaovisconteudo vis ";
		$sql .= "inner join mescasomontagem mon ";
		$sql .= "		on mon.CodCaso = vis.CodCaso ";
		$sql .= "	   and mon.CodMontagem = vis.CodMontagem ";
		$sql .= "	   and mon.Chave = vis.CodChave ";
		$sql .= "where vis.CodResolucao = :pCodResolucao ";
		$sql .= "  and vis.CodCaso = :pCodCaso ";
		$sql .= "order by vis.DataHora asc";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$arr = $cmd->fetchAll(pdo::FETCH_COLUMN);
				return implode(";", $arr);
			}
			else
			{
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
	
	public static function ResolucaoValida($intCodCaso, $intCodUsuario, $intCodResolucao)
	{
		$sql  = "select CodResolucao from mesresolucao ";
		$sql .= "where codresolucao = :pCodResolucao and codcaso = :pCodCaso and codusuario = :pCodUsuario;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $intCodResolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $intCodCaso , PDO::PARAM_INT);
		$cmd->bindParam(":pCodUsuario", $intCodUsuario, PDO::PARAM_INT);
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

	public static function BuscaUltimaResolucaoCaso($intCodCaso, $intCodUsuario, $intStatus)
	{
		$sql  = "select max(CodResolucao) as CodResolucao ";
		$sql .= "from mesresolucao ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodUsuario = :pCodUsuario ";
		$sql .= "  and CodSituacao = :pCodSituacao;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $intCodCaso , PDO::PARAM_INT);
		$cmd->bindParam(":pCodUsuario", $intCodUsuario, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSituacao", $intStatus, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			return $cmd->fetchColumn();
		}
		else
		{
			return false;
		}
	}
	
	public function LimpaResolucao()
	{
		$sql1 = "delete from mesresolucaoresposta where CodResolucao in(select CodResolucao from mesresolucao where CodCaso = :pCodCaso);";
		$sql2 = "delete from mesresolucaovisconteudo where CodResolucao in(select CodResolucao from mesresolucao where CodCaso = :pCodCaso)";
		$sql3 = "delete from mesresolucaoacesso where CodResolucao in(select CodResolucao from mesresolucao where CodCaso = :pCodCaso);";
		$sql4 = "delete from mesresolucao where CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		$cnn->beginTransaction();
		
		$cmd = $cnn->prepare($sql1);
		//$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$cmd->closeCursor();
			$cmd = $cnn->prepare($sql2);
			//$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				$cmd->closeCursor();
				$cmd = $cnn->prepare($sql3);
				//$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					$cmd->closeCursor();
					$cmd = $cnn->prepare($sql4);
					//$cmd->bindParam(":pCodUsuario", $this->codusuario, PDO::PARAM_INT);
					$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
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
						$cnn->rollback();
						return false;
					}
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					$cnn->rollback();
					return false;
				}
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = $msg[2];
				$cnn->rollback();
				return false;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			$cnn->rollback();
			return false;
		}
	}
}

?>