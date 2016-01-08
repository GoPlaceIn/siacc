<?php
//--utf8_encode --
include_once 'conexao.class.php';
include_once './inc/comuns.inc.php';
include_once 'cls/components/combobox.php';

class Instituicao
{
	private $Codigo;
	private $NomeCompleto;
	private $Sigla;
	private $Endereco;
	private $Complemento;
	private $Numero;
	private $Bairro;
	private $Cidade;
	private $CEP;
	private $UF;
	private $Pais;
	private $FoneContato;
	private $Site;
	private $Email;
	private $ObrigaEmail;
	private $DominioEmail;
	private $Ativo;
	private $DtCadastro;
	private $CodUsuario;
	private $NomeResponsavel;
	private $EmailResponsavel;
	private $FoneResponsavel;
	private $form;
	private $msg_erro;
	
	public function getCodigo()
	{
		return $this->Codigo;
	}
	
	public function getNomeCompleto()
	{
		return $this->NomeCompleto;
	}
	
	public function getSigla()
	{
		return $this->Sigla;
	}
	
	public function getEndereco()
	{
		return $this->Endereco;
	}
	
	public function getComplemento()
	{
		return $this->Complemento;
	}
	
	public function getNumero()
	{
		return $this->Numero;
	}
	
	public function getBairro()
	{
		return $this->Bairro;
	}
	
	public function getCidade()
	{
		return $this->Cidade;
	}
	
	public function getCEP()
	{
		return $this->CEP;
	}
	
	public function getUF()
	{
		return $this->UF;
	}
	
	public function getPais()
	{
		return $this->Pais;
	}
	
	public function getFoneContato()
	{
		return $this->FoneContato;
	}
	
	public function getSite()
	{
		return $this->Site;
	}
	
	public function getObrigaEmail()
	{
		return $this->ObrigaEmail;
	}
	
	public function getDominioEmail()
	{
		return $this->DominioEmail;
	}
	
	public function getAtivo()
	{
		return $this->Ativo;
	}
	
	public function getNomeResponsavel()
	{
		return $this->NomeResponsavel;
	}
	
	public function getEmailResponsavel()
	{
		return $this->EmailResponsavel;
	}
	
	public function getFoneResponsavel()
	{
		return $this->FoneResponsavel;
	}
	
	public function getDtCadastro()
	{
		return $this->DtCadastro;
	}
	
	public function getCodUsuario()
	{
		return $this->CodUsuario;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
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
	
	public function setNomeCompleto($p_NomeCompleto)
	{
		if ((isset($p_NomeCompleto)) && (!is_null($p_NomeCompleto)))
		{
			$this->NomeCompleto = $p_NomeCompleto;
		}
		else
		{
			throw new Exception("@lng[Nome completo não informado]", 1010);
		}
	}
	
	public function setSigla($p_Sigla)
	{
		if ((isset($p_Sigla)) && (!is_null($p_Sigla)))
		{
			$this->Sigla = $p_Sigla;
		}
		else
		{
			throw new Exception("@lng[Sigla não informada]", 1020);
		}
	}
	
	public function setEndereco($p_Endereco)
	{
		if ((isset($p_Endereco)) && (!is_null($p_Endereco)))
		{
			$this->Endereco = $p_Endereco;
		}
		else
		{
			throw new Exception("@lng[Endereço não informado]", 1020);
		}
	}

	public function setComplemento($p_Complemento)
	{
		if ((isset($p_Complemento)) && (!is_null($p_Complemento)))
		{
			$this->Complemento = $p_Complemento;
		}
		else
		{
			throw new Exception("@lng[Complemento não informado]", 1020);
		}
	}
	
	public function setNumero($p_Numero)
	{
		if ((isset($p_Numero)) && (!is_null($p_Numero)))
		{
			$this->Numero = $p_Numero;
		}
		else
		{
			throw new Exception("@lng[Número não informado]", 1020);
		}
	}
	
	public function setBairro($p_Bairro)
	{
		if ((isset($p_Bairro)) && (!is_null($p_Bairro)))
		{
			$this->Numero = $p_Bairro;
		}
		else
		{
			throw new Exception("@lng[Bairro não informado]", 1020);
		}
	}
	
	public function setCidade($p_Cidade)
	{
		if ((isset($p_Cidade)) && (!is_null($p_Cidade)))
		{
			$this->Cidade = $p_Cidade;
		}
		else
		{
			throw new Exception("@lng[Cidade não informada]", 1070);
		}
	}
	
	public function setCEP($p_CEP)
	{
		if ((isset($p_CEP)) && (!is_null($p_CEP)))
		{
			$this->CEP = $p_CEP;
		}
		else
		{
			throw new Exception("@lng[CEP não informado]", 1070);
		}
	}
	
	public function setUF($p_UF)
	{
		if ((isset($p_UF)) && (!is_null($p_UF)))
		{
			$this->UF = $p_UF;
		}
		else
		{
			throw new Exception("@lng[Estado não informado]", 1060);
		}
	}
		
	public function setPais($p_Pais)
	{
		if ((isset($p_Pais)) && (!is_null($p_Pais)))
		{
			$this->Pais = $p_Pais;
		}
		else
		{
			throw new Exception("@lng[País não informado]", 1080);
		}
	}
	
	public function setFoneContato($p_FoneContato)
	{
		if ((isset($p_FoneContato)) && (!is_null($p_FoneContato)))
		{
			$this->FoneContato = $p_FoneContato;
		}
		else
		{
			throw new Exception("@lng[Telefone de contato não informado]", 1090);
		}
	}
	
	public function setSite($p_Site)
	{
		if ((isset($p_Site)) && (!is_null($p_Site)))
		{
			$this->Site = $p_Site;
		}
		else
		{
			throw new Exception("@lng[Site não informado]", 1100);
		}
	}
	
	public function setEmail($p_Email)
	{
		if ((isset($p_Email)) && (!is_null($p_Email)))
		{
			$this->Site = $p_Email;
		}
		else
		{
			throw new Exception("@lng[E-mail não informado]", 1100);
		}
	}
	
	public function setObrigaEmail($p_ObrigaEmail)
	{
		if ((isset($p_ObrigaEmail)) && (!is_null($p_ObrigaEmail)))
		{
			$this->ObrigaEmail = $p_ObrigaEmail;
		}
		else
		{
			throw new Exception("@lng[Se obriga e-mail próprio não informado]", 1110);
		}
	}
	
	public function setDominioEmail($p_DominioEmail)
	{
		if ((isset($p_DominioEmail)) && (!is_null($p_DominioEmail)))
		{
			$this->DominioEmail = $p_DominioEmail;
		}
		else
		{
			throw new Exception("@lng[Domínio do e-mail próprio não informado]", 1120);
		}
	}
	
	public function setAtivo($p_Ativo)
	{
		if ((isset($p_Ativo)) && (!is_null($p_Ativo)))
		{
			$this->Ativo = $p_Ativo;
		}
		else
		{
			throw new Exception("@lng[Se a instituição esta ativa ou não, não informado]", 1130);
		}
	}
	
	public function setNomeResponsavel($p_NomeResponsavel)
	{
		if ((isset($p_NomeResponsavel)) && (!is_null($p_NomeResponsavel)))
		{
			$this->NomeResponsavel = $p_NomeResponsavel;
		}
		else
		{
			throw new Exception("@lng[Nome do responsavel não informado]", 1030);
		}
	}
	
	public function setEmailResponsavel($p_EmailResponsavel)
	{
		if ((isset($p_EmailResponsavel)) && (!is_null($p_EmailResponsavel)))
		{
			$this->EmailResponsavel = $p_EmailResponsavel;
		}
		else
		{
			throw new Exception("@lng[E-mail do responsavel não informado]", 1040);
		}
	}
	
	public function setFoneResponsavel($p_FoneResponsavel)
	{
		if ((isset($p_FoneResponsavel)) && (!is_null($p_FoneResponsavel)))
		{
			$this->FoneResponsavel = $p_FoneResponsavel;
		}
		else
		{
			throw new Exception("@lng[Telefone do responsavel não informado]", 1050);
		}
	}
	
	public function setDtCadastro($p_DtCadastro)
	{
		if ((isset($p_DtCadastro)) && (!is_null($p_DtCadastro)))
		{
			$this->DtCadastro = $p_DtCadastro;
		}
		else
		{
			throw new Exception("@lng[Data de cadastro não informada]", 1140);
		}
	}
	
	public function setCodUsuario($p_CodUsuario)
	{
		if ((isset($p_CodUsuario)) && (!is_null($p_CodUsuario)))
		{
			$this->CodUsuario = $p_CodUsuario;
		}
		else
		{
			throw new Exception("@lng[Código do usuário não informado]", 1150);
		}
	}
	
	public function __construct()
	{
		$this->Codigo = null;
		$this->NomeCompleto = null;
		$this->Sigla = null;
		$this->NomeResponsavel = null;
		$this->EmailResponsavel = null;
		$this->FoneResponsavel = null;
		$this->UF = null;
		$this->Cidade = null;
		$this->Pais = null;
		$this->FoneContato = null;
		$this->Site = null;
		$this->ObrigaEmail = 0;
		$this->DominioEmail = null;
		$this->Ativo = 1;
		$this->DtCadastro = null;
		$this->CodUsuario = null;
		$this->form = 13;
		$this->msg_erro = null;
	}
	
	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$cnn = Conexao2::getInstance();
			
			$cmdUF = $cnn->prepare("SELECT Sigla, Descricao FROM mesestados ORDER BY Descricao;");
			$cmdUF->execute();
			$dsEstados = $cmdUF->fetchAll(PDO::FETCH_OBJ);
			
			$cmdPais = $cnn->prepare("SELECT Codigo, Nome FROM mespaises ORDER BY Nome");
			$cmdPais->execute();
			$dsPaises = $cmdPais->fetchAll(PDO::FETCH_OBJ);
			
			$cmbUFs = new ComboBox();
			$cmbUFs->ID("selUF");
			$cmbUFs->cssClass("campo requerido");
			$cmbUFs->setDataSet($dsEstados);
			$cmbUFs->setDataValueField("Sigla");
			$cmbUFs->setDataTextField("Descricao");
			$cmbUFs->setDefaultText("Selecione");
			$cmbUFs->setDefaultValue("");
			
			$cmbPaises = new ComboBox();
			$cmbPaises->ID("selPaises");
			$cmbPaises->cssClass("campo requerido");
			$cmbPaises->setDataSet($dsPaises);
			$cmbPaises->setDataValueField("Codigo");
			$cmbPaises->setDataTextField("Nome");
			$cmbPaises->setDefaultText("Selecione");
			$cmbPaises->setDefaultValue("");
			
			$tpl = str_replace("<!--txtCodigo-->", "", $tpl);
			$tpl = str_replace("<!--txtNomeCompleto-->", "", $tpl);
			$tpl = str_replace("<!--txtSigla-->", "", $tpl);
			$tpl = str_replace("<!--txtEndereco-->", "", $tpl);
			$tpl = str_replace("<!--txtComplemento-->", "", $tpl);
			$tpl = str_replace("<!--txtNumero-->", "", $tpl);
			$tpl = str_replace("<!--txtBairro-->", "", $tpl);
			$tpl = str_replace("<!--txtCidade-->", "", $tpl);
			$tpl = str_replace("<!--txtCEP-->", "", $tpl);
			$tpl = str_replace("<!--selUF-->", $cmbUFs->RenderHTML(), $tpl);
			$tpl = str_replace("<!--selPaises-->", $cmbPaises->RenderHTML(), $tpl);
			$tpl = str_replace("<!--txtFoneContato-->", "", $tpl);
			$tpl = str_replace("<!--txtSite-->", "", $tpl);
			$tpl = str_replace("<!--txtEmail-->", "", $tpl);
			$tpl = str_replace("<!--chkObrigaEmail-->", "", $tpl);
			$tpl = str_replace("<!--txtDominioEmail-->", "", $tpl);
			$tpl = str_replace("<!--chkAtivo-->", "", $tpl);
			$tpl = str_replace("<!--txtNomeResponsavel-->", "", $tpl);
			$tpl = str_replace("<!--txtEmailResponsavel-->", "", $tpl);
			$tpl = str_replace("<!--txtFoneResponsavel-->", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de instituições.]";
		}
		return $tpl;
	}
	
	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$cnn = Conexao2::getInstance();
			
			$cmdUF = $cnn->prepare("SELECT Sigla, Descricao FROM mesestados ORDER BY Descricao;");
			$cmdUF->execute();
			$dsEstados = $cmdUF->fetchAll(PDO::FETCH_OBJ);
			
			$cmdPais = $cnn->prepare("SELECT Codigo, Nome FROM mespaises ORDER BY Nome");
			$cmdPais->execute();
			$dsPaises = $cmdPais->fetchAll(PDO::FETCH_OBJ);
			
			$cmbUFs = new ComboBox();
			$cmbUFs->ID("selUF");
			$cmbUFs->cssClass("campo requerido");
			$cmbUFs->setDataSet($dsEstados);
			$cmbUFs->setDataValueField("Sigla");
			$cmbUFs->setDataTextField("Descricao");
			$cmbUFs->setDefaultText("Selecione");
			$cmbUFs->setDefaultValue("");
			
			$cmbPaises = new ComboBox();
			$cmbPaises->ID("selPaises");
			$cmbPaises->cssClass("campo requerido");
			$cmbPaises->setDataSet($dsPaises);
			$cmbPaises->setDataValueField("Codigo");
			$cmbPaises->setDataTextField("Nome");
			$cmbPaises->setDefaultText("Selecione");
			$cmbPaises->setDefaultValue("");
			
			$sql  = "SELECT Codigo, NomeCompleto, Sigla, Endereco, Complemento, Numero, Bairro, Cidade, CEP, UF, Cidade ";
			$sql .= "	, Pais, FoneContato, Site, Email, ObrigaEmail, DominioEmail, Ativo, NomeResponsavel, EmailResponsavel ";
			$sql .= "	, FoneResponsavel, DtCadastro, CodUsuario ";
			$sql .= "FROM mesinstituicao WHERE Codigo = " . $this->codigo;
			
			$cmd = $cnn->prepare($sql);
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					
					$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
					
					foreach ($rs as $linha)
					{
						$tpl = str_replace("<!--txtCodigo-->", $linha->Codigo, $tpl);
						$tpl = str_replace("<!--txtNomeCompleto-->", $linha->NomeCompleto, $tpl);
						$tpl = str_replace("<!--txtSigla-->", $linha->Sigla, $tpl);
						$tpl = str_replace("<!--txtEndereco-->", $linha->Endereco, $tpl);
						$tpl = str_replace("<!--txtComplemento-->", $linha->Complemento, $tpl);
						$tpl = str_replace("<!--txtNumero-->", $linha->Numero, $tpl);
						$tpl = str_replace("<!--txtBairro-->", $linha->Bairro, $tpl);
						$tpl = str_replace("<!--txtCidade-->", $linha->Cidade, $tpl);
						$tpl = str_replace("<!--txtCEP-->", $linha->CEP, $tpl);
						$tpl = str_replace("<!--selUF-->", $cmbUFs->RenderHTML($linha->UF), $tpl);
						$tpl = str_replace("<!--selPaises-->", $cmbPaises->RenderHTML($linha->Pais), $tpl);
						$tpl = str_replace("<!--txtFoneContato-->", $linha->FoneContato, $tpl);
						$tpl = str_replace("<!--txtSite-->", $linha->Site, $tpl);
						$tpl = str_replace("<!--txtEmail-->", $linha->Email, $tpl);
						$tpl = str_replace("<!--chkObrigaEmail-->", ($linha->ObrigaEmail == 1 ? 'checked="checked"' : ''), $tpl);
						$tpl = str_replace("<!--txtDominioEmail-->", $linha->DominioEmail, $tpl);
						$tpl = str_replace("<!--chkAtivo-->", ($linha->Ativo == 1 ? 'checked="checked"' : ''), $tpl);
						$tpl = str_replace("<!--txtNomeResponsavel-->", $linha->NomeResponsavel, $tpl);
						$tpl = str_replace("<!--txtEmailResponsavel-->", $linha->EmailResponsavel, $tpl);
						$tpl = str_replace("<!--txtFoneResponsavel-->", $linha->FoneResponsavel, $tpl);
					}
				}
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
			$tpl = "@lng[Erro ao criar a tela de cadastro de usuário.]";
		}
		return $tpl;
	}
	
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de instituições de ensino";
				break;
			case "cadastro":
				$ret = "cadastro de instituições de ensino";
		}
		
		return $ret;
	}

	public function ListaTabela($pagina = 1, $nporpagina = 15)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT i.Codigo, i.NomeCompleto, i.Sigla, i.UF, i.Cidade, i.Pais, p.Nome as NomePais, i.NomeResponsavel, i.Ativo ";
		$sql .= "FROM mesinstituicao i INNER JOIN mespaises p ON p.Codigo = i.Pais LIMIT " . $ini . ", " . $nporpagina . ";";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$ret = Comuns::TopoTabelaListagem(
					"Lista de Instituições de ensino",
					"Instituicoes",
					array('Nome', 'Sigla', 'Estado', 'Cidade', 'País', 'Responsável', 'Ativo', 'Ações')
				);
				
				while ($rs = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$cod = base64_encode($rs->Codigo);
					
					$ret .= '<tr>';
					$ret .= '<td>' . $rs->NomeCompleto . '</td>';
					$ret .= '<td>' . $rs->Sigla . '</td>';
					$ret .= '<td>' . $rs->UF . '</td>';
					$ret .= '<td>' . $rs->Cidade . '</td>';
					$ret .= '<td>' . $rs->NomePais . '</td>';
					$ret .= '<td>' . $rs->NomeResponsavel . '</td>';
					
					$ret .= '<td>';
					$ret .= '<a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAG\', \'' . $cod . '\')">' . ($rs->Ativo == 1 ? Comuns::IMG_STATUS_ATIVO : Comuns::IMG_STATUS_INATIVO) . '</a>';
					$ret = str_replace("##id##", 'id="' . $cod . '"', $ret);
					$ret .= '</td>';
					$ret .= '<td>';
					$ret .= '<a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;';
					$ret .= '<a href="javascript:void(0);" onclick="javascript:fntExcluiInstituicao(\'' . $cod . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
					$ret = str_replace("##id##", "", $ret);
					$ret .= '</td>';
					$ret .= '</tr>';
				}
			}
			else
			{
				$ret = "@lng[Nenhuma instituição cadastrada]";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			$ret = $this->msg_erro;
		}
		
		return $ret;
	}
	
	public function Insere()
	{
		$sql  = "insert into mesinstituicao(NomeCompleto, Sigla, NomeResponsavel, EmailResponsavel, FoneResponsavel, Endereco, Complemento, Numero, Bairro, Cidade, UF, Pais, FoneContato, Site, Email, ObrigaEmail, DominioEmail, Ativo, DtCadastro, CodUsuario, CEP) ";
		$sql .= "values(:pNomeCompleto, :pSigla, :pNomeResponsavel, :pEmailResponsavel, :pFoneResponsavel, :pEndereco, :pComplemento, :pNumero, :pBairro, :pCidade, :pUF, :pPais, :pFoneContato, :pSite, :pEmail, :pObrigaEmail, :pDominioEmail, :pAtivo, :pDtCadastro, :pCodUsuario, :pCEP)";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pNomeCompleto", $this->NomeCompleto, PDO::PARAM_STR);
		$cmd->bindParam(":pSigla", $this->Sigla, PDO::PARAM_STR);
		$cmd->bindParam(":pNomeResponsavel", $this->NomeResponsavel, PDO::PARAM_STR);
		$cmd->bindParam(":pEmailResponsavel", $this->EmailResponsavel, PDO::PARAM_STR);
		$cmd->bindParam(":pFoneResponsavel", $this->FoneResponsavel, PDO::PARAM_STR);
		$cmd->bindParam(":pEndereco", $this->Endereco, PDO::PARAM_STR);
		$cmd->bindParam(":pComplemento", $this->Complemento, PDO::PARAM_STR);
		$cmd->bindParam(":pNumero", $this->Numero, PDO::PARAM_STR);
		$cmd->bindParam(":pBairro", $this->Bairro, PDO::PARAM_STR);
		$cmd->bindParam(":pCidade", $this->Cidade, PDO::PARAM_STR);
		$cmd->bindParam(":pUF", $this->UF, PDO::PARAM_STR);
		$cmd->bindParam(":pPais", $this->Pais, PDO::PARAM_INT);
		$cmd->bindParam(":pFoneContato", $this->FoneContato, PDO::PARAM_STR);
		$cmd->bindParam(":pSite", $this->Site, PDO::PARAM_STR);
		$cmd->bindParam(":pEmail", $this->Email, PDO::PARAM_STR);
		$cmd->bindParam(":pObrigaEmail", $this->ObrigaEmail, PDO::PARAM_INT);
		$cmd->bindParam(":pDominioEmail", $this->DominioEmail, PDO::PARAM_STR);
		$cmd->bindParam(":pAtivo", $this->Ativo, PDO::PARAM_INT);
		$cmd->bindParam(":pDtCadastro", $this->DtCadastro, PDO::PARAM_STR);
		$cmd->bindParam(":pCodUsuario", $this->CodUsuario, PDO::PARAM_INT);
		$cmd->bindParam(":pCEP", $this->CEP, PDO::PARAM_STR);
		
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
	
	public function Altera()
	{
		$sql  = "update mesinstituicao ";
		$sql .= "set NomeCompleto = :pNomeCompleto, Sigla = :pSigla, Endereco = :pEndereco, Complemento = :pComplemento, Numero = :pNumero, ";
		$sql .= "	 Bairro = :pBairro, CEP = :pCEP, Cidade = :pCidade, UF = :pUF, Pais = :pPais, FoneContato = :pFoneContato, Site = :pSite, ";
		$sql .= "	 Email = :pEmail, ObrigaEmail = :pObrigaEmail, DominioEmail = :pDominioEmail, Ativo = :pAtivo, ";
		$sql .= "	 NomeResponsavel = :pNomeResponsavel, EmailResponsavel = :pEmailResponsavel, FoneResponsavel = :pFoneResponsavel ";
		$sql .= "WHERE Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pNomeCompleto", $this->NomeCompleto, PDO::PARAM_STR);
		$cmd->bindParam(":pSigla", $this->Sigla, PDO::PARAM_STR);
		$cmd->bindParam(":pEndereco", $this->Endereco, PDO::PARAM_STR);
		$cmd->bindParam(":pComplemento", $this->Complemento, PDO::PARAM_STR);
		$cmd->bindParam(":pNumero", $this->Numero, PDO::PARAM_STR);
		$cmd->bindParam(":pBairro", $this->Bairro, PDO::PARAM_STR);
		$cmd->bindParam(":pCEP", $this->CEP, PDO::PARAM_STR);
		$cmd->bindParam(":pCidade", $this->Cidade, PDO::PARAM_STR);
		$cmd->bindParam(":pUF", $this->UF, PDO::PARAM_STR);
		$cmd->bindParam(":pPais", $this->Pais, PDO::PARAM_INT);
		$cmd->bindParam(":pFoneContato", $this->FoneContato, PDO::PARAM_STR);
		$cmd->bindParam(":pSite", $this->Site, PDO::PARAM_STR);
		$cmd->bindParam(":pEmail", $this->Email, PDO::PARAM_STR);
		$cmd->bindParam(":pObrigaEmail", $this->ObrigaEmail, PDO::PARAM_INT);
		$cmd->bindParam(":pDominioEmail", $this->DominioEmail, PDO::PARAM_STR);
		$cmd->bindParam(":pAtivo", $this->Ativo, PDO::PARAM_INT);
		$cmd->bindParam(":pNomeResponsavel", $this->NomeResponsavel, PDO::PARAM_STR);
		$cmd->bindParam(":pEmailResponsavel", $this->EmailResponsavel, PDO::PARAM_STR);
		$cmd->bindParam(":pFoneResponsavel", $this->FoneResponsavel, PDO::PARAM_STR);
		$cmd->bindParam(":pCodigo", $this->Codigo, PDO::PARAM_INT);
		
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
		$sql  = "SELECT NomeCompleto, Sigla, NomeResponsavel, EmailResponsavel, FoneResponsavel, Endereco, Complemento, Numero, Bairro, ";
		$sql .= "Cidade, UF, Pais, FoneContato, Site, Email, ObrigaEmail, DominioEmail, Ativo, DtCadastro, CodUsuario, CEP ";
		$sql .= "FROM mesinstituicao WHERE Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $this->Codigo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			$this->NomeCompleto = $rs->NomeCompleto;
			$this->Sigla = $rs->Sigla;
			$this->Endereco = $rs->Endereco;
			$this->Complemento = $rs->Complemento;
			$this->Numero = $rs->Numero;
			$this->Bairro = $rs->Bairro;
			$this->Cidade = $rs->Cidade;
			$this->UF = $rs->UF;
			$this->CEP = $rs->CEP;
			$this->Pais = $rs->Pais;
			$this->FoneContato = $rs->FoneContato;
			$this->Site = $rs->Site;
			$this->Email = $rs->Email;
			
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