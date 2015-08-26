<?php
require_once 'cls/conexao.class.php';
require_once 'inc/comuns.inc.php';

class AreaConhecimento
{
	private $codigo;
	private $descricao;
	private $codpai;
	private $ativo;

	private $form;
	public $msg_erro;

	public function __construct()
	{
		$this->codigo = null;
		$this->descricao = null;
		$this->codpai = null;
		$this->ativo = 1;
		$this->form = 9;
	}

	// get's ------------------------------------------------------------
	public function getCodigo()
	{
		return $this->codigo;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getAreaPai()
	{
		return $this->codpai;
	}

	public function getAtivo()
	{
		return $this->ativo;
	}
	// fim get's --------------------------------------------------------

	// set's ------------------------------------------------------------
	public function setCodigo($c)
	{
		if (isset($c) && ($c != ""))
		{
			$this->codigo = $c;
		}
		else
		{
			throw new Exception("Código não informado", 1002);
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
			throw new Exception("Descrição obrigatória", 1001);
		}
	}

	public function setAreaPai($a)
	{
		if (isset($a) && (! is_null($a)))
		{
			$this->codpai = $a;
		}
	}

	public function setAtivo($p_ativo = 1)
	{
		$this->ativo = $p_ativo;
	}
	// fim get's --------------------------------------------------------

	// funções ----------------------------------------------------------
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "@lng[listagem de áreas de conhecimento]";
				break;
			case "cadastro":
				$ret = "@lng[cadastro de áreas de conhecimento]";
		}
		
		return $ret;
	}
	
	public function AdicionaAreaConhecimento()
	{
		if (isset($this->codigo))
		{
			if (isset($this->descricao))
			{
				$sql  = "INSERT INTO mesarea(Codigo, Descricao, CodAreaPai) ";
				$sql .= "VALUES(:pCodigo, :pDescricao, :pCodAreaPai); ";

				$cnn = Conexao2::getInstance();

				try
				{
					$cmd = $cnn->prepare($sql);
						
					$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
					$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
					$cmd->bindParam(":pCodAreaPai", $this->codpai, PDO::PARAM_INT);
						
					$cmd->execute();
					return true;
				}
				catch (PDOException $ex)
				{
					$this->msg_erro = $ex->getMessage();
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Descrição não informada]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Código não informado]";
			return false;
		}
	}

	public function AtualizaAreaConhecimento()
	{
		if (isset($this->descricao))
		{
			$sql  = "UPDATE mesarea SET Descricao = :pDescricao, CodAreaPai = :pCodAreaPai ";
			$sql .= "WHERE Codigo = :pCodigo; ";
				
			$cnn = Conexao2::getInstance();
				
			try
			{
				$cmd = $cnn->prepare($sql);

				$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
				$cmd->bindParam(":pCodAreaPai", $this->codpai, PDO::PARAM_INT);
				$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);

				$cmd->execute();
				return true;
			}
			catch (PDOException $ex)
			{
				$this->msg_erro = $ex->getMessage();
				return false;
			}
		}
	}

	public function DeletaAreaConhecimento()
	{
		if (isset($this->codigo))
		{
			$sql = "DELETE FROM mesarea WHERE Codigo = :pCodigo;";
				
			$cnn = Conexao2::getInstance();
				
			try
			{
				$cmd = $cnn->prepare($sql);

				$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);

				$cmd->execute();

				return true;
			}
			catch (PDOException $ex)
			{
				$this->msg_erro = $ex->getMessage();
			}
		}
	}

	public function FormNovo()
	{
		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$tpl = str_replace("<!--txtCodigo-->", "", $tpl);
			$tpl = str_replace("<!--txtDescricao-->", "", $tpl);
			$tpl = str_replace("<!--selAreaPai-->", self::MontaAreasPai(), $tpl);
			$tpl = str_replace("<!--readonly-->", "", $tpl);
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de áreas de conhecimento.]";
		}
		return $tpl;
	}

	public function FormEdita($cod)
	{
		$this->codigo = $cod;

		$tpl = Comuns::BuscaForm($this->form);
		if ($tpl)
		{
			$sql = "SELECT Descricao, CodAreaPai FROM mesarea WHERE Codigo = :pCodigo;";
				
			$cnn = Conexao2::getInstance();
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
			$cmd->execute();
			$rs = $cmd->fetch(PDO::FETCH_OBJ);
			if (count($rs) != 0)
			{
				$tpl = str_replace("<!--txtCodigo-->", $this->codigo, $tpl);
				$tpl = str_replace("<!--txtDescricao-->", $rs->Descricao, $tpl);
				$tpl = str_replace("<!--selAreaPai-->", self::MontaAreasPai($rs->CodAreaPai), $tpl);
				$tpl = str_replace("<!--readonly-->", 'readonly="readonly"', $tpl);
			}
			else
			{
				$tpl = "@lng[Registro não encontrado]";
			}
		}
		else
		{
			$tpl = "@lng[Erro ao criar a tela de cadastro de níveis de dificuldade.]";
		}
		return $tpl;
	}

	public function ListaTabela($pagina = 1, $nporpagina = 10)
	{
		$ini = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "SELECT Codigo, Descricao, CodAreaPai, Ativo ";
		$sql .= "FROM mesarea LIMIT " . $ini . ", " . $nporpagina . ";";

		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->execute();

		if ($cmd->rowCount() > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de Áreas de conhecimento",
				"AreasCad",
			array('Descrição', 'Área principal', 'Ativo', 'Ações')
			);
				
			while ($rs = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$cod = base64_encode($rs->Codigo);

				if (! is_null($rs->CodAreaPai) && ($rs->CodAreaPai > 0))
				{
					$areapai = self::RetornaArea($rs->CodAreaPai);
					$descricao = $areapai->getCodigo() . " - " .$areapai->getDescricao();
				}
				else
				{
					$descricao = "&nbsp;";
				}

				$ret .= '<tr>';
				$ret .= '  <td>' . $rs->Descricao . '</td>';
				$ret .= '  <td>' . $descricao . '</td>';

				// Exibe o status atual da pergunta.
				if ($rs->Ativo == 1)
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAD\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_ATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}
				else
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAD\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_INATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}

				$ret .= '  <td>';
				$ret .= '    <a href="cadastro.php?t=' . $this->form . '&r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>';
				$ret = str_replace("##id##", "", $ret);
				$ret .= '  </td>';

				$ret .= '</tr>';
			}
				
			$ret .= '  </tbody>';
			$ret .= '</table>';
			
			$registros = Comuns::NRegistros("mesarea");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhum item cadastrado até o momento]";
		}

		return $ret;
	}

	public function ListaRecordSet($SoAtivos = false)
	{
		$sql  = "SELECT Codigo, Descricao, Ativo ";
		$sql .= "FROM mesarea ";
		
		if ($SoAtivos === true)
		{
			$sql .= "WHERE Ativo = 1 ";
		}
		
		$sql .= "ORDER BY Descricao;";

		$cnn = Conexao2::getInstance();

		try
		{
			$cmd = $cnn->prepare($sql);
			$cmd->execute();
			$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
			return $rs;
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
		}
	}

	private function MontaAreasPai($sel = 0)
	{
		$rs = self::ListaRecordSet(true);

		if ( count($rs) > 0)
		{
			$options = '<option value="-1">@lng[Nenhuma]</option>';
				
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

	public static function RetornaArea($p_codigo)
	{
		$sql = "SELECT Codigo, Descricao, CodAreaPai FROM mesarea WHERE Codigo = :pCodigo;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $p_codigo, PDO::PARAM_INT);
		$cmd->execute();

		$rs = $cmd->fetch(PDO::FETCH_OBJ);

		$ar = new AreaConhecimento();

		$ar->setCodigo($rs->Codigo);
		$ar->setDescricao($rs->Descricao);
		if (! is_null($rs->CodAreaPai))
		{
			if ($rs->CodAreaPai > 0)
			{
				$ar->setAreaPai( self::RetornaArea($rs->CodAreaPai) );
			}
		}

		return $ar;
	}

	public function VerificaCodigo()
	{
		$sql = "SELECT Codigo FROM mesarea WHERE Codigo = :pCodigo;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $this->codigo, PDO::PARAM_INT);
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

	public static function MontaSelect($sel = 0)
	{
		return self::MontaAreasPai($sel);
	}
}

?>