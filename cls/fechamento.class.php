<?php
//--utf8_encode --
session_start();
include_once 'cls/conexao.class.php';

class Fechamento
{
	private $codresolucao;
	private $codcaso;
	private $codusuario;
	private $codsituacao;
	private $msg_erro;
	
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
	
	public function getCodsituacao()
	{
		return $this->codsituacao;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	
	public function setCodresolucao($p_codresolucao)
	{
		$this->codresolucao = $p_codresolucao;
	}
	
	public function setCodcaso($p_codcaso)
	{
		$this->codcaso = $p_codcaso;
	}
	
	public function setCodusuario($p_codusuario)
	{
		$this->codusuario = $p_codusuario;
	}
	
	public function setCodsituacao($p_codsituacao)
	{
		$this->codsituacao = $p_codsituacao;
	}

	public function __construct()
	{
		$this->codcaso = 0;
		$this->codresolucao = 0;
		$this->codsituacao = 3;
		$this->codusuario = 0;
	}
	
	public function RetornaDadosBasicos()
	{
		$sql  = "select ";
		$sql .= "	 u.NomeCompleto ";
		$sql .= "	,r.CodCaso ";
		$sql .= "	,c.Nome as Caso";
		$sql .= "	,r.DataInicio ";
		$sql .= "	,r.DataFim ";
		$sql .= "	,count(distinct ra.CodAcesso) as NumAcessos ";
		$sql .= "	,count(distinct v.CodChave) as ConteudosVistos ";
		$sql .= "from mesresolucao r ";
		$sql .= "inner join mescaso c ";
		$sql .= "		on c.Codigo = r.CodCaso ";
		$sql .= "inner join mesresolucaoacesso ra ";
		$sql .= "		on ra.CodResolucao = r.CodResolucao ";
		$sql .= "inner join mesresolucaovisconteudo v ";
		$sql .= "		on v.CodResolucao = ra.CodResolucao ";
		$sql .= "	   and v.CodAcesso = ra.CodAcesso ";
		$sql .= "inner join mesacessousuario au ";
		$sql .= "		on au.NumAcesso = ra.CodAcesso ";
		$sql .= "inner join mesusuario u ";
		$sql .= "		on u.Codigo = au.CodUsuario ";
		$sql .= "where r.CodResolucao = :pCodResolucao ";
		$sql .= "  and r.CodSituacao = :pCodSituacao ";
		$sql .= "  and r.CodCaso = :pCodCaso ";
		$sql .= "group by u.NomeCompleto ";
		$sql .= "		,r.CodCaso ";
		$sql .= "		,c.Nome ";
		$sql .= "		,r.DataInicio ";
		$sql .= "		,r.DataFim;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSituacao", $this->codsituacao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetch(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum item encontrado]";
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
	
	public function RetornaTrajetoria()
	{
		$sql  = "select ";
		$sql .= "	 v.CodChave ";
		$sql .= "	,vw.Conteudo ";
		$sql .= "	,v.DataHora ";
		$sql .= "	,m.TipoConteudo ";
		$sql .= "from mesresolucaovisconteudo v ";
		$sql .= "inner join mesresolucaoacesso ra ";
		$sql .= "		on ra.CodResolucao = v.CodResolucao ";
		$sql .= "	   and ra.CodAcesso = v.CodAcesso ";
		$sql .= "inner join mesresolucao r ";
		$sql .= "		on r.CodResolucao = ra.CodResolucao ";
		$sql .= "inner join mescasomontagem m ";
		$sql .= "		on m.CodCaso = v.CodCaso ";
		$sql .= "	   and m.CodMontagem = v.CodMontagem ";
		$sql .= "	   and m.Chave = v.CodChave ";
		$sql .= "inner join vwarvorecaso vw ";
		$sql .= "		on vw.CodCaso = m.CodCaso ";
		$sql .= "	   and vw.CodMontagem = m.CodMontagem ";
		$sql .= "	   and vw.Chave = m.Chave ";
		$sql .= "where r.CodResolucao = :pCodResolucao ";
		$sql .= "  and r.CodSituacao = :pCodSituacao ";
		$sql .= "  and r.CodCaso = :pCodCaso ";
		$sql .= "order by v.DataHora;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSituacao", $this->codsituacao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum item encontrado]";
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
	
	public function RetornaAcessosDatas()
	{
		$sql  = "select "; 
		$sql .= "	 au.NumAcesso ";
		$sql .= "	,au.Data ";
		$sql .= "from mesresolucaoacesso ra ";
		$sql .= "inner join mesresolucao r ";
		$sql .= "		on r.CodResolucao = ra.CodResolucao ";
		$sql .= "inner join mesacessousuario au ";
		$sql .= "		on au.NumAcesso = ra.CodAcesso ";
		$sql .= "where r.CodResolucao = :pCodResolucao ";
		$sql .= "  and r.CodSituacao = :pCodSituacao ";
		$sql .= "  and r.CodCaso = :pCodCaso ";
				
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSituacao", $this->codsituacao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum item encontrado]";
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

	public function RetornaEtapasInterativas()
	{
		$sql  = "select  ";
		$sql .= "	 r.CodResolucao ";
		$sql .= "	,r.CodCaso ";
		$sql .= "	,rr.ChaveItem ";
		$sql .= "	,rr.CodPergunta ";
		$sql .= "	,vw.TipoConteudo ";
		$sql .= "	,vw.ContReferencia ";
		$sql .= "	,case when rr.CodPergunta is null then vw.Conteudo else perg.Texto end as Conteudo ";
		$sql .= "	,max(rr.NumTentativa) as Tentativas ";
		$sql .= "from mesresolucaoresposta rr ";
		$sql .= "inner join mesresolucao r ";
		$sql .= "		on r.CodResolucao = rr.CodResolucao ";
		$sql .= "inner join vwarvorecaso vw ";
		$sql .= "		on vw.CodCaso = r.CodCaso ";
		$sql .= "	   and vw.CodMontagem = 1 ";
		$sql .= "	   and vw.Chave = rr.ChaveItem ";
		$sql .= "left outer join vwperguntasativas perg ";
		$sql .= "			 on perg.Codigo = rr.CodPergunta ";
		$sql .= "where r.codcaso = :pCodCaso ";
		$sql .= "  and r.CodResolucao = :pCodResolucao ";
		$sql .= "  and r.CodSituacao = :pCodSituacao ";
		$sql .= "group by r.CodResolucao ";
		$sql .= "	,r.CodCaso ";
		$sql .= "	,rr.ChaveItem ";
		$sql .= "	,vw.Conteudo ";
		$sql .= "order by Identificador";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodResolucao", $this->codresolucao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSituacao", $this->codsituacao, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum item encontrado]";
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
	
	public function RetornaConteudosDoItemDaMontagem($chave, $tipo)
	{
		$sql  = "select ";
		$sql .= "	 m.CodCaso ";
		$sql .= "	,m.CodMontagem ";
		$sql .= "	,m.TipoConteudo ";
		$sql .= "	,m.Chave ";
		$sql .= "	,m.ContReferencia ";
		$sql .= "	,vwc.Titulo ";
		$sql .= "	,vwc.Correto ";
		$sql .= "	,vwc.Justificativa ";
		$sql .= "	,vwc.ConteudoAdicional ";
		$sql .= "	,m.ValorOpt ";
		$sql .= "from mescasomontagem m ";
		$sql .= "inner join vwconteudoscaso vwc ";
		$sql .= "		on vwc.CodCaso = m.CodCaso ";
		$sql .= "	   and vwc.CodConteudo = m.ContReferencia ";
		$sql .= "	   and vwc.Tipo = m.TipoConteudo ";
		$sql .= "where m.CodCaso = :pCodCaso  ";
		$sql .= "  AND m.CodMontagem = 1 "; 
		$sql .= "  AND m.ChavePai = :pChaveItem ";
		$sql .= "  AND m.Organizador = 'cont' ";
		$sql .= "ORDER BY m.Ordem";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveItem", $chave, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = '@lng[Nenhum registro encontrado]';
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
	
	public function RetornaAlternativasDaPergunta($intCodPergunta)
	{
		$sql  = "SELECT ";
		$sql .= "	 Codigo as CodPergunta ";
		$sql .= "	,Sequencia ";
		$sql .= "	,case when CodTipo = 1 then concat('<img src=\"', Imagem, '\" alt=\"', TextoAlternativa, '\"', '\" title=\"', TextoAlternativa, '\" class=\"thumb-resp\" />') else TextoAlternativa end as Alternativa ";
		$sql .= "	,Correto ";
		$sql .= "	,Explicacao ";
		$sql .= "	,CodBinario as ValorOpt ";
		$sql .= "FROM vwperguntasalternativas ";
		$sql .= "WHERE Codigo = :pCodPergunta ";
		$sql .= "ORDER BY Sequencia;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodPergunta", $intCodPergunta, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum item encontrado]";
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