<?php
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/grupo.class.php';
include_once 'cls/permissao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/components/botao.class.php';

function Main()
{
	try
	{
		$u = unserialize($_SESSION["usu"]);

		$mensagem = $_GET["m"];
		$tpl = file_get_contents("tpl/usuariosgrupos.html");
		$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
		$tpl = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl);
		
		$botoes = Botao::BotaoSalvar("fntGravaUsuariosGrupo();", "@lng[Salvar as alterações]");
		
		$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
		
		$grupos = new Grupo();
		$rs = $grupos->ListaRecordSet();

		if ($rs != 0)
		{
			if (mysql_num_rows($rs) > 0)
			{
				$opts .= '<option value="">@lng[Selecione]</option>';

				while ($linha = mysql_fetch_array($rs))
				{
					$opts .= '<option value="' . $linha["Codigo"] . '">' . $linha["Descricao"] . '</option>';
				}
			}
			else
			{
				$opts = '<option value="-1">@lng[Nenhum grupo cadastrado]</option>';
			}
		}
		else
		{
			$opts = '<option value="-1">@lng[Erro ao carregar]</option>';
		}

		$tpl = str_replace("##OptsGrupos##", $opts, $tpl);
		$tpl = str_replace("##OptsTU##", "", $tpl);
		$tpl = str_replace("##OptsUDG##", "", $tpl);

		echo( Comuns::Idioma($tpl) );
	}
	catch (Exception $ex)
	{
		$msg = base64_encode($ex->getMessage());
		header("Location:vwerro.php?m=" . $msg);
	}
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