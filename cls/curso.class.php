<?php

include_once 'conexao.class.php';
include_once './inc/comuns.inc.php';
include_once 'cls/components/combobox.php';

class CadCurso
{
	private $Codigo;
	private $NomeCurso;
	
	public function getCodigo()
	{
		return $this->Codigo;
	}
	
	public function getNomeCurso()
	{
		return $this->NomeCurso;
	}
		
	public function setCodigo($p_Codigo)
	{
		if ((isset($p_Codigo)) && (!is_null($p_Codigo)))
		{
			$this->Codigo = $p_Codigo;
		}
		else
		{
			throw new Exception("@lng[Código não informado]", 1000);
		}
	}

	public function setNomeCurso($p_NomeCurso)
	{
		if ((isset($p_NomeCurso)) && (!is_null($p_NomeCurso)))
		{
			$this->NomeCurso = $p_NomeCurso;
		}
		else
		{
			throw new Exception("@lng[Nome não informado]", 1000);
		}
	}

	
	
	public function Insere()
	{
		$sql  = "insert into mesinstituicao(NomeCompleto, Sigla, NomeResponsavel, EmailResponsavel, FoneResponsavel, Endereco, Complemento, Numero, Bairro, Cidade, UF, Pais, FoneContato, Site, Email, ObrigaEmail, DominioEmail, Ativo, DtCadastro, CodUsuario, CEP) ";
		$sql .= "values(:pNomeCompleto, :pSigla, :pNomeResponsavel, :pEmailResponsavel, :pFoneResponsavel, :pEndereco, :pComplemento, :pNumero, :pBairro, :pCidade, :pUF, :pPais, :pFoneContato, :pSite, :pEmail, :pObrigaEmail, :pDominioEmail, :pAtivo, :pDtCadastro, :pCodUsuario, :pCEP)";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pNomeCompleto", $this->NomeCompleto, PDO::PARAM_STR);
		$cmd->bindParam(":pSigla", $this->Sigla, PDO::PARAM_STR);
		
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
	
	
}

?>