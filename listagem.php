<?php

//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/conexao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/permissao.class.php';
include_once 'cls/grupo.class.php';
include_once 'cls/classes.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/area.class.php';
include_once 'cls/caso.class.php';
include_once 'cls/tipoexame.class.php';
include_once 'cls/grupopergunta.class.php';
include_once 'cls/instituicao.class.php';
include_once 'cls/log.class.php';

function Main()
{
	$codTPL = $_GET["t"];
	$codPagina = $_GET["p"];
	$codMax = $_GET["m"];
	$mensagem = $_GET['msg'];

	if ( ! is_numeric( $codTPL ) )
	{
		$msg = "@lng[A URL acesada é inválida]";
		header("Location:index.php?msg=" . base64_encode($msg));
	}

	if ( ! is_numeric($codPagina))
	{
		$codPagina = 1;
	}

	$u = unserialize($_SESSION['usu']);

	$cnn = new Conexao();

	$sql = "SELECT Arquivo FROM mestemplates WHERE Codigo = 2;";
	$rs = $cnn->Consulta($sql);
	$tpl = file_get_contents(mysql_result($rs, 0, "Arquivo"));

	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
	$tpl = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl);

	$sql = "SELECT Classe, jsLoad, linkNovoRegistro, QtdPadListagem FROM mestemplates WHERE Codigo = " . $codTPL . ";";
	$rs = $cnn->Consulta($sql);

	if ( $rs != 0 )
	{
		// Classe que será instanciada
		$classe = mysql_result($rs, 0, 0);
		$frm = new $classe;
		
		if ( ! is_numeric($codMax))
		{
			$codMax = mysql_result($rs, 0, 3); // Quantidade padrão para listagem: 15 (exceto listam de Caso que é 10)
		}
		
		Log::RegistraLog("Acessou a tela de " . $frm->RetornaDescricaoTela('lista'));
		
		$where = fntConstroiWhere($codTPL, $_GET);
		$lista = $frm->ListaTabela($codPagina, $codMax, $_SESSION['usu'], $where);

		$tpl = str_replace("##Lista##", $lista, $tpl);
		$tpl = str_replace("##CodTpl##", $codTPL, $tpl);

		if ((is_null(mysql_result($rs, 0, 2))) || (trim(mysql_result($rs, 0, 2)) == ""))
		{
			$tpl = str_replace("##linkNovo##", "cadastro.php?t=" . $codTPL, $tpl);
		}
		else
		{
			$tpl = str_replace("##linkNovo##", mysql_result($rs, 0, 2), $tpl);
		}

		$tpl = str_replace("##FuncoesJS##", mysql_result($rs, 0, 1), $tpl);
		
		$cnnFiltros = Conexao2::getInstance();
		$sqlFiltro  = "select TipoFiltro, NomeCampoTela, DscCampoTela, ComandoFill, CampoSelValue, CampoSelText, CSSClassCampoTela ";
		$sqlFiltro .= "from mestemplatesfiltros where CodTemplate = " . $codTPL . ";";
		
		$cmd = $cnnFiltros->prepare($sqlFiltro);
		
		$cmd->execute();
		$tplFiltro = "";
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$tplFiltro .= '<label id="lbl' . $linha->NomeCampoTela . '" for="' . $linha->NomeCampoTela . '">';
					$tplFiltro .= '    @lng[' . $linha->DscCampoTela . ']<br />';
					switch($linha->TipoFiltro)
					{
						case "TEXTO":
							$tplFiltro .= '    <input type="text" name="' . $linha->NomeCampoTela . '" id="' . $linha->NomeCampoTela . '" class="'. $linha->CSSClassCampoTela .'" value="' . ($_GET[$linha->NomeCampoTela] ? $_GET[$linha->NomeCampoTela] : "") . '" />';
							break;
						case "COMBO":
							$arr = null;
							Comuns::ArrayObj($linha->ComandoFill, $arr);
							$combo = new ComboBox($linha->NomeCampoTela, $arr, $linha->CampoSelValue, $linha->CampoSelText);
							$combo->cssClass($linha->CSSClassCampoTela);
							$combo->setDefaultValue("");
							$combo->setDefaultText("@lng[Todos]");
							$tplFiltro .= $combo->RenderHTML();
							break;
						default:
							$tplFiltro .= '    <input type="text" name="' . $linha->NomeCampoTela . '" id="' . $linha->NomeCampoTela . '" class="'. $linha->CSSClassCampoTela .'" value="' . ($_GET[$linha->NomeCampoTela] ? $_GET[$linha->NomeCampoTela] : "") . '" />';
					}
					$tplFiltro .= '</label><br /><br />';
				}
				
				$tpl = str_replace("##Filtros##", $tplFiltro, $tpl);
			}
			else
			{
				$tpl = str_replace("##Filtros##", "@lng[Esta tela não possui filtros para serem aplicados]", $tpl);
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			echo($msg[2]);
		}
	}

	//header('Content-Type: text/html; charset=iso-8859-1');
	echo( Comuns::Idioma($tpl) );
}

function fntConstroiWhere($codTPL, $filtros)
{
	$where = "";
	
	$sql = "select Tabela, AliasTabela, Campo, HTMLEncode, NomeCampoTela, TipoFiltro from mestemplatesfiltros where CodTemplate = :pCodTpl;";
	$cnn = Conexao2::getInstance();
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pCodTpl", $codTPL, PDO::PARAM_INT);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			while ($filtro = $cmd->fetch(PDO::FETCH_OBJ))
			{
				if ($filtros[$filtro->NomeCampoTela] != "")
				{
					$where .= " AND " . ($filtro->AliasTabela == null ? $filtro->Tabela : $filtro->AliasTabela) . "." . $filtro->Campo . " " . ($filtro->TipoFiltro == "TEXTO" ? "LIKE '%" . ($filtro->HTMLEncode == 0 ? $filtros[$filtro->NomeCampoTela] : htmlentities($filtros[$filtro->NomeCampoTela], ENT_COMPAT, "ISO-8859-1")) . "%'" : " = '" . ($filtro->HTMLEncode == 0 ? $filtros[$filtro->NomeCampoTela] : htmlentities($filtros[$filtro->NomeCampoTela], ENT_COMPAT, "ISO-8859-1")) . "'");
				}
			}
		}
	}
	
	return $where;
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}
?>