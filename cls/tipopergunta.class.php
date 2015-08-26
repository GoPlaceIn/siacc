<?php
require_once 'cls/conexao.class.php';
require_once 'inc/comuns.inc.php';

class TipoPergunta
{
	private $codigo;
	private $descricao;
	private $form;

	public function __construct()
	{
		$this->codigo = null;
		$this->descricao = null;
		$this->form = 5;
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

	public function AdicionaTipoPergunta()
	{
		if (isset($this->descricao))
		{
			$sql  = "INSERT INTO mestipopergunta(Descricao) ";
			$sql .= "VALUES('" . $this->descricao . "')";

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
				throw new Exception("@lng[Erro ao inserir o tipo de pergunta].", 1011);
			}
		}
		else
		{
			throw new Exception("@lng[Descrição não informada]", 1012);
		}
	}

	public function DeletaTipoPergunta()
	{
		$sql = "DELETE FROM mestipopergunta WHERE Codigo = " . $this->codigo . ";";
		$cnn = new Conexao();
		if($cnn->Instrucao($sql, false))
		{
			$cnn->Desconecta();
			return true;
		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Erro ao excluir o tipo de pergunta]", 1013);
		}
	}

	public function AtualizaTipoPergunta()
	{
		if (isset($this->descricao))
		{
			$sql  = "UPDATE mestipopergunta ";
			$sql .= "SET Descricao = '" . $this->descricao . "' ";
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
				throw new Exception("@lng[Erro ao atualizar a descrição do tipo de pergunta]", 1014);
			}

		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Você deve informar uma descrição para o tipo de pergunta]", 1015);
		}
	}

	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$tpl = str_replace("##txtCodigo##", "", $tpl);
			$tpl = str_replace("##txtDescricao##", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de tipos de pergunta].";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql = "SELECT Descricao FROM mestipopergunta WHERE Codigo = " . $this->codigo;
			$cnn = new Conexao();
			$rs = $cnn->Consulta($sql);
			if ($rs != 0)
			{
				$tpl = str_replace("##txtCodigo##", $this->codigo, $tpl);
				$tpl = str_replace("##txtDescricao##", mysql_result($rs, 0, "Descricao"), $tpl);
			}
			else
			{
				echo("@lng[Registro não encontrado]");
			}
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de tipos de pergunta].";
		}
		return $tpl;
	}

	/**
	 * Retorna uma string em formato de tabela com os registros de Tipos de pergunta limitado pelo paginador.
	 */
	public function ListaTabela($pagina = 1, $nporpagina = 10)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mestipopergunta LIMIT " . $ini . ", " . $nporpagina . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if (mysql_num_rows($rs))
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de Tipos de pergunta",
				"TiposPergunta",
			array('Descrição', 'Ações')
			);
				
			while ($linha = mysql_fetch_array($rs))
			{
				$cod = base64_encode($linha["Codigo"]);

				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["Descricao"] . '</td>';
				$ret .= '      <td><a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">E</a> | <a href="javascript:void(0);" onclick="javascript:fntExcluiGrupoUsuario(' . $cod . ')">X</a></td>';
				$ret .= '    </tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
				
			$registros = Comuns::NRegistros("mesGrupoUsuario");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhum tipo de pergunta cadastrado]";
		}

		return $ret;
	}

	/**
	 * Retorna um resultset com todos os registros de Tipos de pergunta cadastrados (Codigo e Descricao).
	 */
	function ListaRecordSet()
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mestipopergunta;";

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

	public static function RetornaTipo($codigo)
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mestipopergunta WHERE Codigo = :pCod;";

		$cnn = Conexao2::getInstance();
		$rs = $cnn->prepare($sql);

		$rs->bindParam(":pCod", $codigo, PDO::PARAM_INT);
		$rs->execute();

		$t = new TipoPergunta();

		while ($tip = $rs->fetch(PDO::FETCH_OBJ))
		{
			$t->setCodigo($tip->Codigo);
			$t->setDescricao($tip->Descricao);
		}

		return $t;
	}
}
?>