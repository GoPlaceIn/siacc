<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/grupopergunta.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/components/botao.class.php';

function Main()
{
	$tpl = file_get_contents("tpl/cad-perg-agrup.html");
	
	$ag = new GrupoPergunta();
	$p = new Pergunta();
	$u = unserialize($_SESSION['usu']);
	
	$codigo = base64_decode($_GET['c']);
	
	if ($ag->Carrega($codigo))
	{
		$_SESSION['agruperg'] = $ag->getCodgrupo();
		
		$perguntas = $p->ListaPerguntasAtivas(null, null, "", 0, $u->getCodigo());
		
		if (count($perguntas) > 0)
		{
			$retorno = "<h4>@lng[As perguntas marcadas são as já vinculadas a este agrupamento]</h4>";
			$cont = 0;
			
			foreach ($perguntas as $perg)
			{
				$cont++;
				if ((! is_null($ag->getPerguntas())) && (in_array($perg->Codigo, $ag->getPerguntas())))
				{
					$retorno .= '<input type="checkbox" name="chkPerguntas[]" id="chkRelPergCaso_' . $cont . '" value="' . base64_encode($perg->Codigo) . '" class="campo" checked="checked" />' . $perg->Texto . '<br />';
				}
				else
				{
					$retorno .= '<input type="checkbox" name="chkPerguntas[]" id="chkRelPergCaso_' . $cont . '" value="' . base64_encode($perg->Codigo) . '" class="campo" />' . $perg->Texto . '<br />';
				}
			}
		}
		else
		{
			$retorno = "@lng[Nenhum pergunta cadastrada no sistema]";
		}
		
		$botoes = Botao::BotaoSalvar("fntSalvaAgrupamento();", "@lng[Salvar as alterações do agrupamento]");
		$botoes .= Botao::BotaoVoltar("fntVoltar();", "@lng[Voltar para a listagem de agrupadores de pergunta]");
		
		$tpl = str_replace("<!--textoagrupador-->", $ag->getTexto(), $tpl);
		$tpl = str_replace("<!--listaexercicios-->", $retorno, $tpl);
		$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
		$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
		
		echo($tpl);
	}
	else
	{
		echo("ERRO inesperado! " . $ag->getErro());
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