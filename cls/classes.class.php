<?php
//--utf8_encode --
require_once "conexao.class.php";

class Classes
{

	private $codigo;
	private $descricao;
	private $complemento;
	private $form;

	function __construct()
	{
		$this->codigo = null;
		$this->descricao = null;
		$this->complemento = null;
		$this->form = 6;
	}

	public function getCodigo()
	{
		return $this->codigo;
	}

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

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function setDescricao($d)
	{
		if (isset($d) && ($d != ""))
		{
			$this->descricao = $d;
		}
		else
		{
			throw new Exception("@lng[A descrição é obrigatória]", 1011);
		}
	}

	public function getComplemento()
	{
		return $this->complemento;
	}

	public function setComplemento($c)
	{
		if (isset($c))
		{
			$this->complemento = $c;
		}
	}

	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "@lng[listagem de classificações das questões]";
				break;
			case "cadastro":
				$ret = "@lng[cadastro de classificações das questões]";
		}
		
		return $ret;
	}
	
	/**
	 * @abstract: Adiciona uma classe nova ao banco de dados retornando true em caso de sucesso ou gera uma exception em cso de erro
	 */
	public function AdicionarClassePergunta()
	{
		if (isset($this->descricao))
		{
			$sql  = "INSERT INTO mesclassepergunta(Descricao, Complemento) ";
			$sql .= "VALUES('" . $this->descricao . "', " . ((is_null($this->complemento)) ? "NULL" : ("'" . $this->complemento . "'")) . ");";

			$cnn = new Conexao();
			if ($codigo = $cnn->Instrucao($sql, true))
			{
				$this->codigo = $codigo;
				$cnn->Desconecta();
				return true;
			}
			else
			{
				$cnn->Desconecta();
				throw new Exception("@lng[Erro ao inserir a classe de perguntas]", 1011);
			}
		}
	}

	public function DeletarClassePergunta()
	{
		if ($this->PodeExcluir())
		{
			$sql = "DELETE FROM mesclassepergunta WHERE Codigo = " . $this->codigo . ";";
			$cnn = new Conexao();
			if($qts = $cnn->Instrucao($sql, false))
			{
				$cnn->Desconecta();
				return true;
			}
			else
			{
				$cnn->Desconecta();
				throw new Exception("@lng[Erro ao excluir a classe de perguntas]", 1013);
			}
		}
		else
		{
			throw new Exception("@lng[Esta classificação de exercício não pode ser excluída pois está sendo utilizada.]", 1016);
		}
	}

	public function AtualizaClassePerguntas()
	{
		if (isset($this->descricao))
		{
			$sql  = "UPDATE mesclassepergunta ";
			$sql .= "SET Descricao = '" . $this->descricao . "', ";
			$sql .= "    Complemento = " . (is_null($this->complemento) ? "NULL" : ("'" . $this->complemento . "'")) . " ";
			$sql .= "WHERE Codigo = " . $this->codigo . ";";

			$cnn = new Conexao();
			if ($cnn->Instrucao($sql, false))
			{
				$cnn->Desconecta();
				return true;
			}
			else
			{
				$cnn->Desconecta();
				throw new Exception("@lng[Erro ao atualizar a classe de perguntas]", 1014);
			}

		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Você deve informar uma descrição para a classe de perguntas]", 1015);
		}
	}

	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$tpl = str_replace("##txtCodigo##", "", $tpl);
			$tpl = str_replace("##txtDescricao##", "", $tpl);
			$tpl = str_replace("##txtComplemento##", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de classes de pergunta.]";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql = "SELECT Descricao, Complemento FROM mesclassepergunta WHERE Codigo = " . $this->codigo;
			$cnn = new Conexao();
			$rs = $cnn->Consulta($sql);
			if ($rs != 0)
			{
				$classep = mysql_fetch_object($rs);
				$tpl = str_replace("##txtCodigo##", $this->codigo, $tpl);
				$tpl = str_replace("##txtDescricao##", $classep->Descricao, $tpl);
				$tpl = str_replace("##txtComplemento##", is_null($classep->Complemento) ? "" : $classep->Complemento, $tpl);
			}
			else
			{
				echo("@lng[Registro não encontrado]");
			}
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de edição de classes de perguntas.]";
		}
		return $tpl;
	}

	/**
	 * Retorna uma string em formato de tabela com os registros de Grupos de usuários limitado pelo paginador.
	 */
	public function ListaTabela($pagina = 1, $nporpagina = 10)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mesclassepergunta LIMIT " . $ini . ", " . $nporpagina . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if (mysql_num_rows($rs) > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de Classificações de exercícios",
				"ClassesPergunta",
			array('Descrição', 'Ações')
			);
				
			while ($linha = mysql_fetch_array($rs))
			{
				$cod = base64_encode($linha["Codigo"]);

				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["Descricao"] . '</td>';
				$ret .= '      <td>';
				$ret .= '        <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;';
				
				$ret = str_replace("##id##", "", $ret);
				
				$ret .= '        <a href="javascript:void(0);" onclick="javascript:fntExcluiClassePergunta(\'' . $cod . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a></td>';
				$ret .= '    </tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
				
			$registros = Comuns::NRegistros("mesclassepergunta");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhuma classe de pergunta cadastrada]";
		}

		return $ret;
	}

	/**
	 * Retorna um resultset com todos os registros de classes de pergunta cadastrados (Codigo e Descricao).
	 */
	function ListaRecordSet()
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mesclassepergunta;";

		$cnn = Conexao2::getInstance();
		$rs = $cnn->prepare($sql);
		$rs->execute();

		$rs = $rs->fetchAll(PDO::FETCH_OBJ);

		if ($rs != 0)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}
	
	private function PodeExcluir()
	{
		$sql = "select 1 as Tem from mespergunta where CodClass = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return false;
			}
			else
			{
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
}

?>