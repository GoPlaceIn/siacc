<?php
require_once 'cls/conexao.class.php';
require_once 'inc/comuns.inc.php';

class NivelPergunta
{
	private $codigo;
	private $descricao;
	private $form;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function getDescricao()
	{
		return $this->descricao;
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
				throw new Exception("@lng[C�digo informado inv�lido]", 1009);
			}
		}
		else
		{
			throw new Exception("@lng[C�digo n�o informado]", 1010);
		}
	}

	public function setDescricao($d)
	{
		if (isset($d) && ($d != ""))
		{
			$this->descricao = $d;
		}
		else
		{
			throw new Exception("@lng[A descri��o � obrigat�ria]", 1011);
		}
	}

	public function __construct()
	{
		$this->codigo = null;
		$this->descricao = null;
		$this->form = 7;
	}
	
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de n�veis de dificuldade do sistema";
				break;
			case "cadastro":
				$ret = "cadastro de n�veis de dificuldade do sistema";
		}
		
		return $ret;
	}
	
	public function AdicionaNivelPergunta()
	{
		if (isset($this->descricao))
		{
			$sql  = "INSERT INTO mesnivelpergunta(Descricao) ";
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
				throw new Exception("@lng[Erro ao inserir o n�vel de dificuldade.]", 1011);
			}
		}
		else
		{
			throw new Exception("@lng[Descri��o n�o informada]", 1012);
		}
	}

	public function DeletaNivelPergunta()
	{
		$sql = "DELETE FROM mesnivelpergunta WHERE Codigo = " . $this->codigo . ";";
		$cnn = new Conexao();
		if($cnn->Instrucao($sql, false))
		{
			$cnn->Desconecta();
			return true;
		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Erro ao excluir o n�vel de dificuldade]", 1013);
		}
	}

	public function AtualizaNivelPergunta()
	{
		if (isset($this->descricao))
		{
			$sql  = "UPDATE mesnivelpergunta ";
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
				throw new Exception("@lng[Erro ao atualizar a descri��o do n�vel de dificuldade]", 1014);
			}

		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Voc� deve informar uma descri��o para o n�vel de dificuldade]", 1015);
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
			$tpl = "@lng[Erro ao criar a tela de cadastro de n�veis de dificuldade].";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql = "SELECT Descricao FROM mesnivelpergunta WHERE Codigo = " . $this->codigo;
			$cnn = new Conexao();
			$rs = $cnn->Consulta($sql);
			if ($rs != 0)
			{
				$tpl = str_replace("##txtCodigo##", $this->codigo, $tpl);
				$tpl = str_replace("##txtDescricao##", mysql_result($rs, 0, "Descricao"), $tpl);
			}
			else
			{
				echo("@lng[Registro n�o encontrado]");
			}
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de n�veis de dificuldade].";
		}
		return $tpl;
	}

	/**
	 * Retorna uma string em formato de tabela com os registros de Grupos de usu�rios limitado pelo paginador.
	 */
	public function ListaTabela($pagina = 1, $nporpagina = 10)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mesnivelpergunta LIMIT " . $ini . ", " . $nporpagina . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if (mysql_num_rows($rs))
		{
			$ret = Comuns::TopoTabelaListagem(
					"Lista de n�veis de dificuldade do sistema",
					"nivdif",
					array('Descri��o', 'A��es')
			);
			
			while ($linha = mysql_fetch_array($rs))
			{
				$cod = base64_encode($linha["Codigo"]);

				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["Descricao"] . '</td>';
				$ret .= '      <td>';
				$ret .= '      <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;';
				$ret .= '      <a href="javascript:void(0);" onclick="javascript:fntDeletaNivelDificuldade(\'' . $cod . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				$ret .= '      </td>';
				$ret .= '    </tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
				
			$registros = Comuns::NRegistros("mesnivelpergunta");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhum n�vel de dificuldade cadastrado at� o momento]";
		}

		return $ret;
	}

	/**
	 * Retorna um resultset com todos os registros de niveis cadastrados (Codigo e Descricao).
	 */
	function ListaRecordSet()
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mesnivelpergunta;";

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

	public static function MontaSelect($sel = 0)
	{
		$rs = self::ListaRecordSet();

		if ( count($rs) > 0)
		{
			$options = '<option value="-1">@lng[Selecione]</option>';
				
			foreach ($rs as $linha)
			{
				if ($linha->Codigo != $sel)
				{
					$options .= '<option value="' . $linha->Codigo . '">' . $linha->Descricao . '</option>';
				}
				else
				{
					$options .= '<option selected value="' . $linha->Codigo . '">' . $linha->Descricao . '</option>';
				}
			}
		}
		else
		{
			$options .= '<option value="-1">@lng[Nenhum item cadastrado]</option>';
		}

		return $options;
	}


	public static function RetornaNivel($p_codigo)
	{
		$sql = "SELECT Codigo, Descricao FROM mesnivelpergunta WHERE Codigo = :pCodigo;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $p_codigo, PDO::PARAM_INT);
		$cmd->execute();

		$rs = $cmd->fetch(PDO::FETCH_OBJ);

		$nivel = new NivelPergunta();

		$nivel->setCodigo($rs->Codigo);
		$nivel->setDescricao($rs->Descricao);

		return $nivel;
	}
	/**
	 * Retorna um resultset com todas as permiss�es do sistema indicando se o grupo tem ou n�o aquela permiss�o.
	 */
}
?>