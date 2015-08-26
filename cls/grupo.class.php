<?php
/**
 * @author Regis Leandro Sebastiani
 * @copyright Copyright (c) 2011 Regis Leandro Sebastiani
 * @version 2011090401
 * */

include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';
include_once 'inc/comuns.inc.php';

class Grupo
{
	private $codigo;
	private $descricao;
	private $pagina;
	private $form;
	private $msg_erro;

	public function __construct()
	{
		$this->codigo = null;
		$this->descricao = null;
		$this->pagina = null;
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
			throw new Exception("@lng[Código não informádo]", 1010);
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

	public function getPagina()
	{
		return $this->pagina;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "@lng[listagem de grupos de usuários do sistema]";
				break;
			case "cadastro":
				$ret = "@lng[cadastro de grupos de usuários do sistema]";
		}
		
		return $ret;
	}
	
	public function AdicionaGrupoUsuario()
	{
		if (isset($this->descricao))
		{
			$sql  = "INSERT INTO mesgrupousuario(Descricao) ";
			$sql .= "VALUES('" . $this->descricao . "')";

			$cnn = new Conexao();
			if ($codigo = $cnn->Instrucao($sql, true))
			{
				$this->codigo = $codigo;
				$cnn->Desconecta();
				Log::RegistraLog("Cadastrou novo grupo de usuários: " . $this->getDescricao() . ". Código: " . $this->getCodigo());
				return true;
			}
			else
			{
				$cnn->Desconecta();
				throw new Exception("@lng[Erro ao inserir o grupo de usuários].", 1011);
			}
		}
		else
		{
			throw new Exception("@lng[Descrição não informada]", 1012);
		}
	}

	public function DeletaTodasPermissoes()
	{
		if (isset($this->codigo))
		{
			try
			{
				$sql = "DELETE FROM mesgrupopermissao WHERE CodGrupoUsuario = " . $this->codigo . ";";

				$cnn = new Conexao();
				$cnn->Instrucao($sql);
				$cnn->Desconecta();
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
			return true;
		}
		else
		{
			throw new Exception("@lng[Grupo não informado]", 1024);
		}
	}

	public function DeletaTodosOsUsuarios()
	{
		if (isset($this->codigo))
		{
			try
			{
				$sql = "DELETE FROM mesusuariogrupo WHERE CodGrupoUsuario = " . $this->codigo . ";";

				$cnn = new Conexao();
				$cnn->Instrucao($sql);
				$cnn->Desconecta();
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
			return true;
		}
		else
		{
			throw new Exception("@lng[Grupo não informado]", 1025);
		}
	}

	public function AdicionaPermissaoGrupoUsuario($permissao)
	{
		if (isset($this->codigo))
		{
			try
			{
				$sql  = "INSERT INTO mesgrupopermissao(CodGrupoUsuario, CodPermissao, Ativo) ";
				$sql .= "VALUES(" . $this->codigo . ", " . $permissao . ", 1);";

				$cnn = new Conexao();
				$cnn->Instrucao($sql);
				$cnn->Desconecta();
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
			return true;
		}
		else
		{
			throw new Exception("@lng[Grupo não informado]", 1024);
		}
	}

	public function AdicionaUsuarioAoGrupo($usuario)
	{
		if (isset($this->codigo))
		{
			try
			{
				$sql  = "INSERT INTO mesusuariogrupo(CodUsuario, CodGrupoUsuario) ";
				$sql .= "VALUES(" . $usuario . ", " . $this->codigo . ");";

				$cnn = new Conexao();
				$cnn->Instrucao($sql);
				$cnn->Desconecta();
				
				return true;
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
		}
		else
		{
			throw new Exception("@lng[Grupo não informado]", 1024);
		}
	}


	public function DeletaGrupoUsuario()
	{
		if ($this->PodeDeletar($this->codigo))
		{
			$sql = "DELETE FROM mesgrupousuario WHERE Codigo = " . $this->codigo . ";";
			$cnn = new Conexao();
			if($cnn->Instrucao($sql, false))
			{
				$cnn->Desconecta();
				return true;
			}
			else
			{
				$cnn->Desconecta();
				throw new Exception("ERRO @lng[ao excluir o grupo de usuários]", 1013);
			}
		}
		else
		{
			throw new Exception("@lng[Este grupo de usuários não pode ser excluido pois existem usuários vinculados a ele].", 1014);
		}
	}

	public function PodeDeletar($intCodGrupo)
	{
		$sql = "select * from mesusuariogrupo where CodGrupoUsuario = :pCodGrupo";
		
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodGrupo", $intCodGrupo, PDO::PARAM_INT);
		
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
			return false;
		}
	}
	
	public function AtualizaGrupoUsuario()
	{
		if (isset($this->descricao))
		{
			$sql  = "UPDATE mesgrupousuario ";
			$sql .= "SET Descricao = '" . $this->descricao . "' ";
			$sql .= "WHERE Codigo = " . $this->codigo . ";";

			$cnn = new Conexao();
			if ($cnn->Instrucao($sql, false))
			{
				$cnn->Desconecta();
				Log::RegistraLog("Alterou o grupo de usuários " . $this->getCodigo() . " para " . $this->getDescricao());
				return true;
			}
			else
			{
				$cnn->Desconecta();
				throw new Exception("@lng[Erro ao atualizar a descrição do grupo de usuários]", 1014);
			}

		}
		else
		{
			throw new Exception("@lng[Você deve informar uma descrição para o grupo de usuários]", 1015);
		}
	}

	public function CarregaGrupoUsuario()
	{
		$sql  = "select Codigo, Descricao, PaginaInicial ";
		$sql .= "from mesgrupousuario where Codigo = :pCodigo";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rsGrupo = $cmd->fetch(PDO::FETCH_OBJ);
			$this->descricao = $rsGrupo->Descricao;
			$this->pagina = $rsGrupo->PaginaInicial;
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
			$tpl = str_replace("##txtCodigo##", "", $tpl);
			$tpl = str_replace("##txtDescricao##", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de grupos de usuários].";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql = "SELECT Descricao FROM mesgrupousuario WHERE Codigo = " . $this->codigo;
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
			$tpl = "@lng[Erro ao criar a tela de cadastro de edição de grupos de usuário.]";
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
		$sql .= "FROM mesgrupousuario LIMIT " . $ini . ", " . $nporpagina . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if (mysql_num_rows($rs))
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de Grupos de Usuários do sistema",
				"GruposUsu",
			array('Descrição', 'Ações')
			);
				
			while ($linha = mysql_fetch_array($rs))
			{
				$cod = base64_encode($linha["Codigo"]);

				$ret .= '    <tr>';
				$ret .= '      <td>' . $linha["Descricao"] . '</td>';
				$ret .= '      <td>';
				$ret .= '        <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>&nbsp;';
				$ret .= '        <a href="javascript:void(0);" onclick="javascript:fntExcluiGrupoUsuario(\'' . $cod . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
				
				$ret = str_replace("##id##", "", $ret);
				
				$ret .= '      </td>';
				$ret .= '    </tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
				
			$registros = Comuns::NRegistros("mesgrupousuario");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhuma grupo de usuários cadastrado]";
		}

		return $ret;
	}

	/**
	 * Retorna um resultset com todos os registros de grupos cadastrados (Codigo e Descricao).
	 */
	function ListaRecordSet()
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mesgrupousuario;";

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

	/**
	 * Retorna um resultset com todas as permissões do sistema indicando se o grupo tem ou não aquela permissão.
	 */
	public static function ListaPermissoesTodas($codgrupo)
	{
		$sql  = "select p.Codigo, p.Descricao, case when gp.CodGrupoUsuario is null then 0 else 1 end as Pode ";
		$sql .= "from mespermissao p ";
		$sql .= "left outer join mesgrupopermissao gp ";
		$sql .= "	     on gp.CodPermissao = p.Codigo ";
		$sql .= "	    and gp.ativo = 1 ";
		$sql .= "	    and gp.CodGrupoUsuario = " . $codgrupo . ";";

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


	/**
	 * Retorna um resultset com todos os usuarios do sistema vinculados ao grupo.
	 */
	public static function ListaUsuariosGrupo($codgrupo)
	{
		$sql  = "select u.Codigo, u.NomeCompleto, u.NomeUsuario, u.Ativo ";
		$sql .= "from mesusuariogrupo ug ";
		$sql .= "inner join mesusuario u ";
		$sql .= "	on u.Codigo = ug.CodUsuario ";
		$sql .= "       and (current_date() <= ug.DtVigencia or ug.DtVigencia = '1900-12-31') ";
		$sql .= "       and (u.ativo = 1) ";
		$sql .= "where ug.CodGrupoUsuario = " . $codgrupo . " order by u.NomeCompleto;";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if ($rs != 0)
		{
			$cnn->Desconecta();
			return $rs;
		}
		else
		{
			$cnn->Desconecta();
			return false;
		}
	}

	public static function ListaUsuariosForaDoGrupo($codgrupo)
	{
		$sql  = "select u.Codigo, u.NomeCompleto, u.NomeUsuario, u.Ativo ";
		$sql .= "from mesusuario u ";
		$sql .= "left outer join mesusuariogrupo ug ";
		$sql .= "	     on ug.codusuario = u.codigo ";
		$sql .= "	    and ug.CodGrupoUsuario = " . $codgrupo . " ";
		$sql .= "where (ug.CodGrupoUsuario is null or (ug.DtVigencia <> '1900-12-31' and ug.DtVigencia < current_date())) ";
		$sql .= "order by u.NomeCompleto;";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if ($rs != 0)
		{
			$cnn->Desconecta();
			return $rs;
		}
		else
		{
			$cnn->Desconecta();
			return false;
		}
	}
}

?>