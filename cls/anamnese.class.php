<?php
//--utf8_encode --
require_once 'cls/conexao.class.php';
require_once 'inc/comuns.inc.php';

class Anamnese
{
	private $codcaso;
	private $identificacao;
	private $queixapri;
	private $histatual;
	private $histpregressa;
	private $histfamiliar;
	private $perfilpsicosocial;
	private $revsistemas;
	private $examefisico;

	private $msg_erro;

	// get's ------------------------------------------------------------
	public function getCodcaso()
	{
		return $this->codcaso;
	}

	public function getIdentificacao()
	{
		return $this->identificacao;
	}

	public function getQueixapri()
	{
		return $this->queixapri;
	}

	public function getHistatual()
	{
		return $this->histatual;
	}

	public function getHistpregressa()
	{
		return $this->histpregressa;
	}

	public function getHistfamiliar()
	{
		return $this->histfamiliar;
	}

	public function getPerfilpsicosocial()
	{
		return $this->perfilpsicosocial;
	}

	public function getRevsistemas()
	{
		return $this->revsistemas;
	}

	public function getExamefisico()
	{
		return $this->examefisico;
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
			throw new Exception("@lng[O caso clínico não foi informado]", 999);
		}
	}

	public function setIdentificacao($p_identificacao)
	{
		if (isset($p_identificacao) && (! is_null($p_identificacao)))
		{
			$this->identificacao = $p_identificacao;
		}
		else
		{
			throw new Exception("@lng[A identificação é obrigatória]", 1000);
		}
	}

	public function setQueixapri($p_queixapri)
	{
		if (isset($p_queixapri) && (! is_null($p_queixapri)))
		{
			$this->queixapri = $p_queixapri;
		}
		else
		{
			throw new Exception("@lng[A queixa principal é obrigatória]", 1001);
		}
	}

	public function setHistatual($p_histatual)
	{
		if (isset($p_histatual) && (! is_null($p_histatual)))
		{
			$this->histatual = $p_histatual;
		}
		else
		{
			throw new Exception("@lng[A história da doença atual (HDA) é obrigatória]", 1002);
		}
	}

	public function setHistpregressa($p_histpregressa)
	{
		if (isset($p_histpregressa) && (! is_null($p_histpregressa)))
		{
			$this->histpregressa = $p_histpregressa;
		}
		else
		{
			throw new Exception("@lng[A história médica pregressa (HMP) é obrigatória]", 1003);
		}
	}

	public function setHistfamiliar($p_histfamiliar)
	{
		if (isset($p_histfamiliar) && (! is_null($p_histfamiliar)))
		{
			$this->histfamiliar = $p_histfamiliar;
		}
		else
		{
			throw new Exception("@lng[A história familiar (HF) é obrigatória]", 1004);
		}
	}

	public function setPerfilpsicosocial($p_perfilpsicosocial)
	{
		if (isset($p_perfilpsicosocial) && (! is_null($p_perfilpsicosocial)))
		{
			$this->perfilpsicosocial = $p_perfilpsicosocial;
		}
		else
		{
			throw new Exception("@lng[O perfil psicosocial é obrigatório]", 1005);
		}
	}

	public function setRevsistemas($p_revsistemas)
	{
		if (isset($p_revsistemas) && (! is_null($p_revsistemas)))
		{
			$this->revsistemas = $p_revsistemas;
		}
		else
		{
			throw new Exception("@lng[A revisão de sistemas é obrigatória]", 1006);
		}
	}

	public function setExamefisico($p_examefisico)
	{
		if (isset($p_examefisico) && (! is_null($p_examefisico)))
		{
			$this->examefisico = $p_examefisico;
		}
		else
		{
			throw new Exception("@lng[O exame físico é obrigatório]", 1007);
		}
	}
	// fim set's --------------------------------------------------------

	// funções ----------------------------------------------------------
	public function __construct()
	{
		$this->codcaso = 0;
		$this->identificacao = null;
		$this->queixapri = null;
		$this->histatual = null;
		$this->histpregressa = null;
		$this->histfamiliar = null;
		$this->perfilpsicosocial = null;
		$this->revsistemas = null;
		$this->examefisico = null;
	}

	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->identificacao))
			{
				if (isset($this->queixapri))
				{
					if (isset($this->histatual))
					{
						if (isset($this->histpregressa))
						{
							if (isset($this->histfamiliar))
							{
								if (isset($this->revsistemas))
								{
									$sql  = "INSERT INTO mescasoanamnese(CodCaso, Identificacao, QueixaPri, HistAtual, HistPregressa, HistFamiliar, PerfilPsicoSocial, RevSistemas, ExameFisico) ";
									$sql .= "VALUES (:pCodCaso, :pIdentificacao, :pQueixaPri, :pHistAtual, :pHistPregressa, :pHistFamiliar, :pPerfilPsicoSocial, :pRevSistemas, :pExameFisico);";
										
									$cnn = Conexao2::getInstance();
										
									$cmd = $cnn->prepare($sql);
							
									$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
									$cmd->bindParam(":pIdentificacao", $this->identificacao, PDO::PARAM_STR);
									$cmd->bindParam(":pQueixaPri", $this->queixapri, PDO::PARAM_STR);
									$cmd->bindParam(":pHistAtual", $this->histatual, PDO::PARAM_STR);
									$cmd->bindParam(":pHistPregressa", $this->histpregressa, PDO::PARAM_STR);
									$cmd->bindParam(":pHistFamiliar", $this->histfamiliar, PDO::PARAM_STR);
									$cmd->bindParam(":pPerfilPsicoSocial", $this->perfilpsicosocial, PDO::PARAM_STR);
									$cmd->bindParam(":pRevSistemas", $this->revsistemas, PDO::PARAM_STR);
									$cmd->bindParam(":pExameFisico", $this->examefisico, PDO::PARAM_STR);
										
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
									$this->msg_erro = "@lng[Revisão de sistemas não informada]";
									return false;
								}
							}
							else
							{
								$this->msg_erro = "@lng[História familiar não informada]";
								return false;
							}
						}
						else
						{
							$this->msg_erro = "@lng[História médica pregressa não informada]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[História da doença atual não informada]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Queixa principal não informada]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Identificação não informada]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}
	}

	public function Atualiza()
	{
		try
		{
			$sql  = "UPDATE mescasoanamnese ";
			$sql .= "SET Identificacao = :pIdentificacao, ";
			$sql .= "    QueixaPri = :pQueixaPri, ";
			$sql .= "    HistAtual = :pHistAtual, ";
			$sql .= "    HistPregressa = :pHistPregressa, ";
			$sql .= "    HistFamiliar = :pHistFamiliar, ";
			$sql .= "    PerfilPsicoSocial = :pPerfilPsicoSocial, ";
			$sql .= "    RevSistemas = :pRevSistemas, ";
			$sql .= "    ExameFisico = :pExameFisico ";
			$sql .= "WHERE CodCaso = :pCodCaso;";
				
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pIdentificacao", $this->identificacao, PDO::PARAM_STR);
			$cmd->bindParam(":pQueixaPri", $this->queixapri, PDO::PARAM_STR);
			$cmd->bindParam(":pHistAtual", $this->histatual, PDO::PARAM_STR);
			$cmd->bindParam(":pHistPregressa", $this->histpregressa, PDO::PARAM_STR);
			$cmd->bindParam(":pHistFamiliar", $this->histfamiliar, PDO::PARAM_STR);
			$cmd->bindParam(":pPerfilPsicoSocial", $this->perfilpsicosocial, PDO::PARAM_STR);
			$cmd->bindParam(":pRevSistemas", $this->revsistemas, PDO::PARAM_STR);
			$cmd->bindParam(":pExameFisico", $this->examefisico, PDO::PARAM_STR);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				
			$cmd->execute();

			return true;
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
			$sql = "DELETE FROM mescasoanamnese WHERE CodCaso = :pCodCaso;";
				
			$cnn = Conexao2::getInstance();
				
			$cmd = $cnn->prepare($sql);
				
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				
			$cmd->execute();
				
			return true;
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			return false;
		}
	}

	public function Carrega($codcaso)
	{
		$sql  = "select	 CodCaso, Identificacao, QueixaPri, HistAtual, HistPregressa ";
		$sql .= "		,HistFamiliar, PerfilPsicoSocial, RevSistemas, ExameFisico ";
		$sql .= "from mescasoanamnese ";
		$sql .= "where CodCaso = :pCodCaso;";

		$cnn = Conexao2::getInstance();
			
		$cmd = $cnn->prepare($sql);
			
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$rs = $cmd->fetch(PDO::FETCH_OBJ);
	
				$this->codcaso = $rs->CodCaso;
				$this->identificacao = $rs->Identificacao;
				$this->queixapri = $rs->QueixaPri;
				$this->histatual = $rs->HistAtual;
				$this->histpregressa = $rs->HistPregressa;
				$this->histfamiliar = $rs->HistFamiliar;
				$this->perfilpsicosocial = $rs->PerfilPsicoSocial;
				$this->revsistemas = $rs->RevSistemas;
				$this->examefisico = $rs->ExameFisico;
				
				return true;
			}
			else
			{
				$this->msg_erro = "@lng[Anamnese não cadastrada]";
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

	public function VerificaCodigo()
	{
		$sql = "SELECT CodCaso FROM mescasoanamnese WHERE CodCaso = :pCodCaso;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
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

	public function ListaConteudos()
	{
		$cont = new Conteudo();
		$conteudos = $cont->ListaRecordSet($this->codcaso);
		
		if ($conteudos)
		{
			$ret .= '<option value="">@lng[Selecione]</option>';
			foreach ($conteudos as $html)
			{
				$ret .= '<option value="vwcont.php?k=' . $html->Chave . '">' . $html->Descricao . '</option>';
			}
		}
		else
		{
			$ret = '<option value="">@lng[Nenhum item encontrado]</option>';
		}
		
		return $ret;
	}
}

?>