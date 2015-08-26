<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class GrupoPergunta
{
	private $Codgrupo;
	private $Texto;
	private $Explicacao;
	private $Chave;
	private $perguntas;
	
	private $msg_erro;
	private $form;
	
	public function getCodgrupo()
	{
		return $this->Codgrupo;
	}
	
	public function getTexto()
	{
		return $this->Texto;
	}
	
	public function getExplicacao()
	{
		return $this->Explicacao;
	}
	
	public function getChave()
	{
		return $this->Chave;
	}
	
	public function getPerguntas()
	{
		return $this->perguntas;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	

	public function setCodgrupo($p_Codgrupo)
	{
		if ((isset($p_Codgrupo)) && (!is_null($p_Codgrupo)))
		{
			$this->Codgrupo = $p_Codgrupo;
		}
		else
		{
			throw new Exception("", 1000);
		}
	}
	
	public function setTexto($p_Texto)
	{
		if ((isset($p_Texto)) && (!is_null($p_Texto)))
		{
			$this->Texto = $p_Texto;
		}
		else
		{
			throw new Exception("", 1010);
		}
	}

	public function setExplicacao($p_Explicacao)
	{
		if ((isset($p_Explicacao)) && (!is_null($p_Explicacao)))
		{
			$this->Explicacao = $p_Explicacao;
		}
		else
		{
			throw new Exception("", 1020);
		}
	}
	
	public function __construct()
	{
		$this->Codgrupo = 0;
		$this->Texto = null;
		$this->Explicacao = null;
		$this->Chave = null;
		$this->perguntas = null;
		$this->form = 12;
	}
	
	public function Insere()
	{
		if (isset($this->Texto))
		{
			$sql  = "INSERT INTO mesperguntaagrupador(Texto, Explicacao, Chave) ";
			$sql .= "VALUES(:pTexto, :pExplicacao, :pChave)";
			
			$chave = Comuns::CodigoUnico();
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pTexto", $this->Texto, PDO::PARAM_STR);
			$cmd->bindParam(":pExplicacao", $this->Explicacao, PDO::PARAM_STR);
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
			$this->msg_erro = "@lng[Texto do agrupador não informado]";
			return false;
		}
	}
	
	public function Atualiza()
	{
		if (isset($this->Codgrupo))
		{
			if (isset($this->Texto))
			{
				$sql  = "UPDATE mesperguntaagrupador SET Texto = :pTexto, Explicacao = :pExplicacao ";
				$sql .= "WHERE Codigo = :pCodigo;";
				
				$cnn = Conexao2::getInstance();
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pTexto", $this->Texto, PDO::PARAM_STR);
				$cmd->bindParam(":pExplicacao", $this->Explicacao, PDO::PARAM_STR);
				$cmd->bindParam(":pCodigo", $this->Codgrupo, PDO::PARAM_INT);
				
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
				$this->msg_erro = "@lng[Texto do agrupador não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código do agrupador não informado]";
			return false;
		}
	}
	
	public function Deleta()
	{
		if (isset($this->Codgrupo))
		{
			$sql  = "DELETE FROM mesperguntaagrupador ";
			$sql .= "WHERE Codigo = :pCodigo;";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodigo", $this->Codgrupo, PDO::PARAM_INT);
			
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
			$this->msg_erro = "@lng[Código do agrupador não informado]";
			return false;
		}
	}
	
	public function Carrega($codigo)
	{
		$this->Codgrupo = $codigo;
		
		$sql  = "SELECT Codigo, Texto, Explicacao, Chave ";
		$sql .= "FROM mesperguntaagrupador ";
		$sql .= "WHERE Codigo = :pCodigo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $codigo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			
			$this->Codgrupo = $rs->Codigo;
			$this->Texto = $rs->Texto;
			$this->Explicacao = $rs->Explicacao;
			$this->Chave = $rs->Chave;
			
			if ($this->CarregaPerguntas())
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
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	private function CarregaPerguntas()
	{
		unset($this->perguntas);
		
		$sql  = "SELECT CodAgrupador, CodPergunta FROM mesperguntaagrupamentos ";
		$sql .= "WHERE CodAgrupador = :pCodAgrupador;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodAgrupador", $this->Codgrupo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$this->perguntas[] = $linha->CodPergunta;
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
	
	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$tpl = str_replace("<!--txtCodigo-->", "", $tpl);
			$tpl = str_replace("<!--txtTexto-->", "", $tpl);
			$tpl = str_replace("<!--txtExplicacao-->", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de agrupadores de pergunta.]";
		}
		return $tpl;
	}
	
	public function FormEdita($cod)
	{
		$this->Codgrupo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql  = "SELECT Codigo, Texto, Explicacao ";
			$sql .= "FROM mesperguntaagrupador ";
			$sql .= "WHERE Codigo = :pCodigo;";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodigo", $this->Codgrupo, PDO::PARAM_INT);
			
			$cmd->execute();
			
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			
			$tpl = str_replace("<!--txtCodigo-->", $this->Codgrupo, $tpl);
			$tpl = str_replace("<!--txtTexto-->", $rs->Texto, $tpl);
			$tpl = str_replace("<!--txtExplicacao-->", $rs->Explicacao, $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de agrupadores de pergunta.]";
		}
		return $tpl;
	}
	
	public function ListaTabela($pagina = 1, $nporpagina = 20)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		
		$sql  = "SELECT Codigo, Texto ";
		$sql .= "FROM mesperguntaagrupador LIMIT " . $ini . ", " . $nporpagina . ";";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de agrupadores de pergunta",
				"AgrupPerg",
			array('Texto', 'Ações')
			);
			
			while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$cod = base64_encode($linha->Codigo);
				
				$ret .= '<tr>';
				$ret .= '  <td>' . $linha->Texto . '</td>';
				$ret .= '  <td>';
				$ret .= '    <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;';
				$ret .= '    <a href="vwagrupador.php?c=' . $cod . '">' . Comuns::IMG_ACAO_COMPONENTES . '</a>&nbsp;';
				$ret .= '    <a href="javascript:void(0);" onclick="javascript:fntDeletaGrupoPergunta(\'' . $cod . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>&nbsp;';
				$ret = str_replace("##id##", 'id="' . $cod . '"', $ret);
				$ret .= '  </td>';
				$ret .= '</tr>';
			}
			
			$ret .= '  </tbody>';
			$ret .= '</table>';
			
			$registros = Comuns::NRegistros("mesperguntaagrupador");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhum agrupador de pergunta cadastrado]";
		}
		
		return $ret;
	}
	
	public function ListaRecordSet()
	{
		$sql = "select Codigo, Texto, Explicacao, Chave from mesperguntaagrupador;";
	
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return $cmd->fetchAll(PDO::FETCH_OBJ);
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function ListaAgrupamentosCaso($codcaso)
	{
		$sql  = "select ac.CodCaso, ac.CodAgrupamento, a.Texto, ";
		$sql .= "		(select count(pa.CodPergunta) ";
		$sql .= "        from mesperguntaagrupamentos pa ";
		$sql .= "        where pa.CodAgrupador = ac.CodAgrupamento) as Perguntas ";
		$sql .= "from mescasoagrupamentos ac ";
		$sql .= "inner join mesperguntaagrupador a on a.Codigo = ac.CodAgrupamento ";
		$sql .= "where ac.CodCaso = :pCodCaso;";
		
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
	
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de agrupadores de pergunta do sistema";
				break;
			case "cadastro":
				$ret = "cadastro de agrupadores de pergunta do sistema";
		}
		
		return $ret;
	}
}

?>