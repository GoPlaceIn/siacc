<?php
//--utf8_encode --
require_once 'conexao.class.php';
require_once 'inc/comuns.inc.php';

class Permissao
{
	private $codigo;
	private $descricao;
	private $form;

	public function __construct()
	{
		$this->codigo = null;
		$this->descricao = null;
		$this->form = 4;
	}

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
				throw new Exception("@lng[Código informado inválido]", 1009);
			}
		}
		else
		{
			throw new Exception("@lng[Código não informádo]", 1010);
		}
	}

	public function setDescricao($d)
	{
		if (isset($d) && ($d != ""))
		{
			$this->descricao = $d;
		}
	}

	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de permissões do sistema";
				break;
			case "cadastro":
				$ret = "cadastro de permissões do sistema";
		}
		
		return $ret;
	}
	
	public function AdicionaPermissao()
	{
		if (isset($this->descricao))
		{
			$sql  = "INSERT INTO mespermissao(Descricao) ";
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
				throw new Exception("@lng[Erro ao inserir a permissão].", 1011);
			}
		}
		else
		{
			throw new Exception("@lng[Descrição não informada]", 1012);
		}
	}

	public function DeletaPermissao()
	{
		$sql = "DELETE FROM mespermissao WHERE Codigo = " . $this->codigo . ";";
		$cnn = new Conexao();
		if($cnn->Instrucao($sql, false))
		{
			$cnn->Desconecta();
			return true;
		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Erro ao excluir a permissão]", 1013);
		}
	}

	public function AtualizaPermissao()
	{
		if (isset($this->descricao))
		{
			$sql  = "UPDATE mespermissao ";
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
				throw new Exception("@lng[Erro ao atualizar a descrição da permissão]", 1014);
			}

		}
		else
		{
			$cnn->Desconecta();
			throw new Exception("@lng[Você deve informar uma descrição para a permissão]", 1015);
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
			$tpl = "@lng[Erro ao criar a tela de cadastro de permissões].";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql = "SELECT Descricao FROM mespermissao WHERE Codigo = " . $this->codigo;
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
			$tpl = "@lng[Erro ao criar a tela de edição de permissões].";
		}
		return $tpl;
	}

	public function ListaTabela($pagina = 1, $nporpagina = 10)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mespermissao LIMIT " . $ini . ", " . $nporpagina . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if (mysql_num_rows($rs))
		{
			$ret = Comuns::TopoTabelaListagem(
					"Lista de Permissões do sistema",
					"permissoessis",
			array('Descrição', 'Ações')
			);
				
			while ($linha = mysql_fetch_array($rs))
			{
				$cod = base64_encode($linha["Codigo"]);

				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["Descricao"] . '</td>';
				$ret .= '      <td><a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;<a href="javascript:void(0);" onclick="javascript:fntExcluiPermissao(\'' . $cod . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a></td>';
				$ret .= '    </tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
				
			$registros = Comuns::NRegistros("mespermissao");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhuma permissão cadastrado]";
		}

		return $ret;
	}

	public function ListaRecordSet()
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mespermissao;";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if ($rs != 0)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}
}

?>