<?php
session_start(); 
include_once 'inc/comuns.inc.php';
include_once 'cls/conexao.class.php';


class ExameFisico
{
	const ETAPA_CABECA = 1;
	const ETAPA_PESCOCO = 2;
	const ETAPA_AUSCULTA_PULMONAR = 3;
	const ETAPA_AUSCULTA_CARDIACA = 4;
	const ETAPA_ABDOBEM = 5;
	const ETAPA_EXTREMIDADES = 6;
	const ETAPA_PELE = 7;
	const ETAPA_SINAIS_VITAIS = 8;
	const ETAPA_ESTADO_GERAL = 9;
	
	private $codcaso;
	private $cabeca;
	private $pescoco;
	private $auscultapulmonar;
	private $auscultacardiaca;
	private $sinaisvitais;
	private $abdomen;
	private $pele;
	private $extremidades;
	private $estadogeral;
	
	private $midcabeca;
	private $midpescoco;
	private $midauscpulmonar;
	private $midausccardiaca;
	private $midsinaisvitais;
	private $midabdomen;
	private $midpele;
	private $midextremidades;
	private $midestadogeral;
	
	private $msg_erro;
	
	public function getCodcaso()
	{
		return $this->codcaso;
	}
	
	public function getCabeca()
	{
		return $this->cabeca;
	}
	
	public function getPescoco()
	{
		return $this->pescoco;
	}
	
	public function getAuscultapulmonar()
	{
		return $this->auscultapulmonar;
	}
	
	public function getAuscultacardiaca()
	{
		return $this->auscultacardiaca;
	}
	
	public function getSinaisvitais()
	{
		return $this->sinaisvitais;
	}
	
	public function getAbdomen()
	{
		return $this->abdomen;
	}
	
	public function getPele()
	{
		return $this->pele;
	}
	
	public function getExtremidades()
	{
		return $this->extremidades;
	}
	
	public function getEstadoGeral()
	{
		return $this->estadogeral;
	}
	
	public function getMidiasCabeca()
	{
		return $this->midcabeca;
	}
	
	public function getMidiasPescoco()
	{
		return $this->midpescoco;
	}
	
	public function getMidiasAuscultaPulmonar()
	{
		return $this->midauscpulmonar;
	}
	
	public function getMidiasAuscultaCardiaca()
	{
		return $this->midausccardiaca;
	}
	
	public function getMidiasSinaisVitais()
	{
		return $this->midsinaisvitais;
	}
	
	public function getMidiasAbdomen()
	{
		return $this->midabdomen;
	}
	
	public function getMidiasPele()
	{
		return $this->midpele;
	}
	
	public function getMidiasExtremidades()
	{
		return $this->midextremidades;
	}
	
	public function getMidiasEstadoGeral()
	{
		return $this->midestadogeral;
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
			throw new Exception("@lng[Caso clínico não informado]", 1000);
		}
	}
	
	public function setCabeca($p_cabeca)
	{
		if ((isset($p_cabeca)) && (!is_null($p_cabeca)))
		{
			$this->cabeca = $p_cabeca;
		}
		else
		{
			throw new Exception("@lng[Exame da cabeça não informado]", 1010);
		}
	}
	
	public function setPescoco($p_pescoco)
	{
		if ((isset($p_pescoco)) && (!is_null($p_pescoco)))
		{
			$this->pescoco = $p_pescoco;
		}
		else
		{
			throw new Exception("@lng[Exame do pescoço não informado]", 1020);
		}
	}
	
	public function setAuscultapulmonar($p_auscultapulmonar)
	{
		if ((isset($p_auscultapulmonar)) && (!is_null($p_auscultapulmonar)))
		{
			$this->auscultapulmonar = $p_auscultapulmonar;
		}
		else
		{
			throw new Exception("@lng[Ausculta pulmonar não informada]", 1030);
		}
	}
	
	public function setAuscultacardiaca($p_auscultacardiaca)
	{
		if ((isset($p_auscultacardiaca)) && (!is_null($p_auscultacardiaca)))
		{
			$this->auscultacardiaca = $p_auscultacardiaca;
		}
		else
		{
			throw new Exception("@lng[Ausculta cardiaca não informada]", 1040);
		}
	}
	
	public function setSinaisvitais($p_sinaisvitais)
	{
		if ((isset($p_sinaisvitais)) && (!is_null($p_sinaisvitais)))
		{
			$this->sinaisvitais = $p_sinaisvitais;
		}
		else
		{
			throw new Exception("@lng[Sinais vitais não informados]", 1050);
		}
	}
	
	public function setAbdomen($p_abdomen)
	{
		if ((isset($p_abdomen)) && (!is_null($p_abdomen)))
		{
			$this->abdomen = $p_abdomen;
		}
		else
		{
			throw new Exception("@lng[Exame da abdomem não informado]", 1060);
		}
	}
	
	public function setPele($p_pele)
	{
		if ((isset($p_pele)) && (!is_null($p_pele)))
		{
			$this->pele = $p_pele;
		}
		else
		{
			throw new Exception("@lng[Exame da pele não informado]", 1070);
		}
	}
	
	public function setExtremidades($p_extremidades)
	{
		if ((isset($p_extremidades)) && (!is_null($p_extremidades)))
		{
			$this->extremidades = $p_extremidades;
		}
		else
		{
			throw new Exception("@lng[Exame das extremidades não informado]", 1080);
		}
	}
	
	public function setEstadoGeral($p_estadogeral)
	{
		if ((isset($p_estadogeral)) && (!is_null($p_estadogeral)))
		{
			$this->estadogeral = $p_estadogeral;
		}
		else
		{
			throw new Exception("@lng[Estado geral não informado]", 1090);
		}
	}
	
	public function setMidiasCabeca($p_cabeca)
	{
		if ((isset($p_cabeca)) && (!is_null($p_cabeca)))
			$this->midcabeca = $p_cabeca;
		else
			throw new Exception("@lng[Midias vinculadas a cabeça não informadas]", 1090);
	}
	
	public function setMidiasPescoco($p_pescoco)
	{
		if ((isset($p_pescoco)) && (!is_null($p_pescoco)))
			$this->midpescoco = $p_pescoco;
		else
			throw new Exception("@lng[Midias vinculadas ao pescoço não informadas]", 2000);
	}
	
	public function setMidiasAuscultaPulmonar($p_auscpul)
	{
		if ((isset($p_auscpul)) && (!is_null($p_auscpul)))
			$this->midauscpulmonar = $p_auscpul;
		else
			throw new Exception("@lng[Midias vinculadas a ausculta pulmonnar não informadas]", 2010);
	}
	
	public function setMidiasAuscultaCardiaca($p_ausccar)
	{
		if ((isset($p_ausccar)) && (!is_null($p_ausccar)))
			$this->midausccardiaca = $p_ausccar;
		else
			throw new Exception("@lng[Midias vinculadas a ausculta cardiaca não informadas]", 2010);
	}
	
	public function setMidiasSinaisVitais($p_sinvit)
	{
		if ((isset($p_sinvit)) && (!is_null($p_sinvit)))
			$this->midsinaisvitais = $p_sinvit;
		else
			throw new Exception("@lng[Midias vinculadas aos sinais vitais não informadas]", 2010);
	}
	
	public function setMidiasAbdomen($p_abdomen)
	{
		if ((isset($p_abdomen)) && (!is_null($p_abdomen)))
			$this->midabdomen = $p_abdomen;
		else
			throw new Exception("@lng[Midias vinculadas ao abdomen não informadas]", 2010);
	}
	
	public function setMidiasPele($p_pele)
	{
		if ((isset($p_pele)) && (!is_null($p_pele)))
			$this->midpele = $p_pele;
		else
			throw new Exception("@lng[Midias vinculadas a pele não informadas]", 2010);
	}
	
	public function setMidiasExtremidades($p_extremidades)
	{
		if ((isset($p_extremidades)) && (!is_null($p_extremidades)))
			$this->midextremidades = $p_extremidades;
		else
			throw new Exception("@lng[Midias vinculadas as extremidades não informadas]", 2010);
	}
	
	public function setMidiasEstadoGeral($p_estadogeral)
	{
		if ((isset($p_estadogeral)) && (!is_null($p_estadogeral)))
			$this->midestadogeral = $p_estadogeral;
		else
			throw new Exception("@lng[Midias vinculadas ao estado geral não informadas]", 2020);
	}
	
	public function __construct()
	{
		$this->codcaso = 0;
		$this->cabeca = null;
		$this->pescoco = null;
		$this->auscultapulmonar = null;
		$this->auscultacardiaca = null;
		$this->abdomen = null;
		$this->sinaisvitais = null;
		$this->extremidades = null;
		$this->pele = null;
		$this->estadogeral = null;
		$this->midcabeca = 0;
		$this->midpescoco = 0;
		$this->midauscpulmonar = 0;
		$this->midausccardiaca = 0;
		$this->midabdomen = 0;
		$this->midsinaisvitais = 0;
		$this->midextremidades = 0;
		$this->midpele = 0;
		$this->midestadogeral = 0;
	}
	
	public function Insere()
	{
		if (isset($this->codcaso))
		{
			$sql  = "INSERT INTO mescasoexamefisico (CodCaso, Cabeca, Pescoco, AuscultaPulmonar, AuscultaCardiaca, SinaisVitais, Abdomen, Pele, Extremidades, Geral, midCabeca, midPescoco, midAusPulmonar, midAusCardiaca, midSinaisVitais, midAbdomen, midPele, midExtremidades, midGeral) ";
			$sql .= "VALUES(:pCodCaso, :pCabeca, :pPescoco, :pAuscultaPulmonar, :pAuscultaCardiaca, :pSinaisVitais, :pAbdomen, :pPele, :pExtremidades, :pGeral, :pmidCabeca, :pmidPescoco, :pmidAusPulmonar, :pmidAusCardiaca, :pmidSinaisVitais, :pmidAbdomen, :pmidPele, :pmidExtremidades, :pmidGeral)";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT); 
			$cmd->bindParam(":pCabeca", $this->cabeca, PDO::PARAM_STR);
			$cmd->bindParam(":pPescoco", $this->pescoco, PDO::PARAM_STR);
			$cmd->bindParam(":pAuscultaPulmonar", $this->auscultapulmonar, PDO::PARAM_STR);
			$cmd->bindParam(":pAuscultaCardiaca", $this->auscultacardiaca, PDO::PARAM_STR);
			$cmd->bindParam(":pSinaisVitais", $this->sinaisvitais, PDO::PARAM_STR);
			$cmd->bindParam(":pAbdomen", $this->abdomen, PDO::PARAM_STR);
			$cmd->bindParam(":pPele", $this->pele, PDO::PARAM_STR);
			$cmd->bindParam(":pExtremidades", $this->extremidades, PDO::PARAM_STR);
			$cmd->bindParam(":pGeral", $this->estadogeral, PDO::PARAM_STR);
			$cmd->bindParam(":pmidCabeca", $this->midcabeca, PDO::PARAM_INT);
			$cmd->bindParam(":pmidPescoco", $this->midpescoco, PDO::PARAM_INT);
			$cmd->bindParam(":pmidAusPulmonar", $this->midauscpulmonar, PDO::PARAM_INT);
			$cmd->bindParam(":pmidAusCardiaca", $this->midausccardiaca, PDO::PARAM_INT);
			$cmd->bindParam(":pmidSinaisVitais", $this->midsinaisvitais, PDO::PARAM_INT);
			$cmd->bindParam(":pmidAbdomen", $this->midabdomen, PDO::PARAM_INT);
			$cmd->bindParam(":pmidPele", $this->midpele, PDO::PARAM_INT);
			$cmd->bindParam(":pmidExtremidades", $this->midextremidades, PDO::PARAM_INT);
			$cmd->bindParam(":pmidGeral", $this->midestadogeral, PDO::PARAM_INT);
			
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
			$this->msg_erro = "@lng[Caso clínico não informado]";
			return false;
		}
	}
	
	public function Atualiza()
	{
		if (isset($this->codcaso))
		{
			$sql  = "UPDATE mescasoexamefisico ";
			$sql .= "SET Cabeca = :pCabeca, ";
			$sql .= "    Pescoco = :pPescoco, ";
			$sql .= "    AuscultaPulmonar = :pAuscultaPulmonar, ";
			$sql .= "    AuscultaCardiaca = :pAuscultaCardiaca, ";
			$sql .= "    SinaisVitais = :pSinaisVitais, ";
			$sql .= "    Abdomen = :pAbdomen, ";
			$sql .= "    Pele = :pPele, ";
			$sql .= "    Extremidades = :pExtremidades, ";
			$sql .= "    Geral = :pGeral, ";
			$sql .= "    midCabeca = :pmidCabeca, ";
			$sql .= "    midPescoco = :pmidPescoco, ";
			$sql .= "    midAusPulmonar = :pmidAusPulmonar, ";
			$sql .= "    midAusCardiaca = :pmidAusCardiaca, ";
			$sql .= "    midSinaisVitais = :pmidSinaisVitais, ";
			$sql .= "    midAbdomen = :pmidAbdomen, ";
			$sql .= "    midPele = :pmidPele, ";
			$sql .= "    midExtremidades = :pmidExtremidades, ";
			$sql .= "    midGeral = :pmidGeral ";
			$sql .= "WHERE CodCaso = :pCodCaso";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCabeca", $this->cabeca, PDO::PARAM_STR);
			$cmd->bindParam(":pPescoco", $this->pescoco, PDO::PARAM_STR);
			$cmd->bindParam(":pAuscultaPulmonar", $this->auscultapulmonar, PDO::PARAM_STR);
			$cmd->bindParam(":pAuscultaCardiaca", $this->auscultacardiaca, PDO::PARAM_STR);
			$cmd->bindParam(":pSinaisVitais", $this->sinaisvitais, PDO::PARAM_STR);
			$cmd->bindParam(":pAbdomen", $this->abdomen, PDO::PARAM_STR);
			$cmd->bindParam(":pPele", $this->pele, PDO::PARAM_STR);
			$cmd->bindParam(":pExtremidades", $this->extremidades, PDO::PARAM_STR);
			$cmd->bindParam(":pGeral", $this->estadogeral, PDO::PARAM_STR);
			$cmd->bindParam(":pmidCabeca", $this->midcabeca, PDO::PARAM_INT);
			$cmd->bindParam(":pmidPescoco", $this->midpescoco, PDO::PARAM_INT);
			$cmd->bindParam(":pmidAusPulmonar", $this->midauscpulmonar, PDO::PARAM_INT);
			$cmd->bindParam(":pmidAusCardiaca", $this->midausccardiaca, PDO::PARAM_INT);
			$cmd->bindParam(":pmidSinaisVitais", $this->midsinaisvitais, PDO::PARAM_INT);
			$cmd->bindParam(":pmidAbdomen", $this->midabdomen, PDO::PARAM_INT);
			$cmd->bindParam(":pmidPele", $this->midpele, PDO::PARAM_INT);
			$cmd->bindParam(":pmidExtremidades", $this->midextremidades, PDO::PARAM_INT);
			$cmd->bindParam(":pmidGeral", $this->midestadogeral, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			
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
			$this->msg_erro = "Caso clínico não informado";
			return false;
		}
	}
	
	public function Carrega($codcaso)
	{
		$sql  = "SELECT CodCaso, Cabeca, Pescoco, AuscultaPulmonar, AuscultaCardiaca, SinaisVitais, Abdomen, Pele, Extremidades, Geral ";
		$sql .= " ,midCabeca, midPescoco, midAusPulmonar, midAusCardiaca, midSinaisVitais, midAbdomen, midPele, midExtremidades, midGeral ";
		$sql .= "FROM mescasoexamefisico WHERE CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$examefisico = $cmd->fetch(PDO::FETCH_OBJ);
				$this->setCodcaso($examefisico->CodCaso);
				$this->setCabeca((is_null($examefisico->Cabeca) ? "" : $examefisico->Cabeca));
				$this->setPescoco((is_null($examefisico->Pescoco) ? "" : $examefisico->Pescoco));
				$this->setAuscultapulmonar((is_null($examefisico->AuscultaPulmonar) ? "" : $examefisico->AuscultaPulmonar));
				$this->setAuscultacardiaca((is_null($examefisico->AuscultaCardiaca) ? "" : $examefisico->AuscultaCardiaca));
				$this->setSinaisvitais((is_null($examefisico->SinaisVitais) ? "" : $examefisico->SinaisVitais));
				$this->setAbdomen((is_null($examefisico->Abdomen) ? "" : $examefisico->Abdomen));
				$this->setPele((is_null($examefisico->Pele) ? "" : $examefisico->Pele));
				$this->setExtremidades((is_null($examefisico->Extremidades) ? "" : $examefisico->Extremidades));
				$this->setEstadoGeral((is_null($examefisico->Geral) ? "" : $examefisico->Geral));
				$this->setMidiasCabeca((is_null($examefisico->midCabeca) ? "" : $examefisico->midCabeca));
				$this->setMidiasPescoco((is_null($examefisico->midPescoco) ? "" : $examefisico->midPescoco));
				$this->setMidiasAuscultaPulmonar((is_null($examefisico->midAusPulmonar) ? "" : $examefisico->midAusPulmonar));
				$this->setMidiasAuscultaCardiaca((is_null($examefisico->midAusCardiaca) ? "" : $examefisico->midAusCardiaca));
				$this->setMidiasSinaisVitais((is_null($examefisico->midSinaisVitais) ? "" : $examefisico->midSinaisVitais));
				$this->setMidiasAbdomen((is_null($examefisico->midAbdomen) ? "" : $examefisico->midAbdomen));
				$this->setMidiasPele((is_null($examefisico->midPele) ? "" : $examefisico->midPele));
				$this->setMidiasExtremidades((is_null($examefisico->midExtremidades) ? "" : $examefisico->midExtremidades));
				$this->setMidiasEstadoGeral((is_null($examefisico->midGeral) ? "" : $examefisico->midGeral));
				
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

	public function VerificaCodigo()
	{
		$sql  = "SELECT CodCaso ";
		$sql .= "FROM mescasoexamefisico WHERE CodCaso = :pCodCaso";
		
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
	
	public function TemMidia($CodEtapa)
	{
		$sql  = "SELECT midia.CodTipo, tipom.Descricao, COUNT(fis.CodMidia) as Midias ";
		$sql .= "FROM mescasoexamefisicomidias fis ";
		$sql .= "INNER JOIN mesmidia midia ON midia.CodCaso = fis.CodCaso AND midia.CodMidia = fis.CodMidia ";
		$sql .= "INNER JOIN mestipomidia tipom ON tipom.CodTipo = midia.CodTipo ";
		$sql .= "WHERE fis.CodCaso = :pCodCaso AND fis.EtapaExame = :pEtapaExame ";
		$sql .= "GROUP BY midia.CodTipo, tipom.Descricao ";
		
		$cnn = Conexao2::getInstance();
		$cnn->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cnn->bindParam(":pEtapaExame", $CodEtapa, PDO::PARAM_INT);
		$cmd = $cnn->prepare($sql);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount())
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
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
}

?>