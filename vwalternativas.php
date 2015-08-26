<?php
session_start();

include_once 'inc/comuns.inc.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/simnao.class.php';
include_once 'cls/components/botao.class.php';

function Main()
{
	$u = unserialize($_SESSION['usu']);

	if (isset($_SESSION['perg']) && (! is_null($_SESSION['perg'])) && ($_SESSION['perg'] != ""))
	{
		// Verifica se já tem uma sessão iniciada para uma pergunta. Se tiver...
		if (isset($_GET['p']))
		{
			// Se tiver mas vier via GET algum código, limpa a sessão e recarrega os dados
			unset($_SESSION['perg']);
			$cod = base64_decode($_GET['p']);
				
			$p = new Pergunta();
			$p->Carregar($cod);
		}
		else
		{
			$p = new Pergunta();
			$p->Carregar($_SESSION['perg']);
		}
	}
	else
	{
		// Se não tiver sessão iniciada...
		if (isset($_GET['p']))
		{
			// Deve vir obrigatoriamente um código informado via GET. Caso veio, instancia a pergunta
			$cod = base64_decode($_GET['p']);
				
			$p = new Pergunta();
			$p->Carregar($cod);
		}
		else
		{
			// Se não veio código é porque alguma coisa saiu errado ou o usuário não deveria estar acessando a página
			$msg = base64_encode("Algo saiu errado.");
			header("Location:listagem.php?t=8&m=" . $msg);
		}
	}

	$tpl = file_get_contents('tpl/alternativas.html');
	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
	
	$botoes  = Botao::BotaoSalvar("fntGravaAlternativa();", "@lng[Salvar a alternativa]");
	$botoes .= Botao::BotaoCancelar("fntNavega('listagem.php?t=8');", "@lng[Cancelar edição]");
	$botoes .= Botao::BotaoVoltar("fntNavega('vwpergunta.php?r=" . base64_encode($p->getCodigo()) . "');");
	
	$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
	$tpl = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl);
	
	$tipconsatual = 1;
	$valconsatual = -1;
	
	if (count($p->getAlternativas()) > 0)
	{
		$arquivotpl = 'tpl/alternativas-comp' . $p->getTipo()->getCodigo() . '.html';
		//$item_padrao = file_get_contents('tpl/alternativas-comp1.html');
		$item_padrao = file_get_contents($arquivotpl);
		$itens = '';

		foreach ($p->getAlternativas() as $alt)
		{
			$copia = $item_padrao;
			
			$copia = str_replace("<!--perg-->", base64_encode($p->getCodigo()), $copia);
			$copia = str_replace("<!--seq-->", base64_encode($alt->getSequencia()), $copia);
			$copia = str_replace("<!--correta-->", ($alt->getCorreto() == 1 ? "SIM" : "NÃO"), $copia);
			$copia = str_replace("<!--ordem-->", $alt->getSequencia(), $copia);
			$copia = str_replace("<!--ordem-ex-->", base64_encode($alt->getSequencia()), $copia);
			$copia = str_replace("<!--codunico-->", base64_encode($alt->getCodUnico()), $copia);
			$copia = str_replace("<!--excluir-->", "", $copia);
			if ($p->getTipo()->getCodigo() == 1)
			{
				$copia = str_replace("<!--img-preview-->", $alt->getImagem(), $copia);
			}
			else
			{
				$copia = str_replace("<!--textoalternativa-->", ((strlen($alt->getTexto()) > 100) ? substr($alt->getTexto(), 0, 97) . "..." : $alt->getTexto()), $copia);
			}

			$itens .= $copia;
			
			if ((isset($_GET['s'])) && ($_GET['s'] != ""))
			{
				// Se foi informado um segundo parâmetro, contendo a sequência da alternativa,
				// quer dizer que deve ser carregada a alternativa para edição.
				if (base64_decode($_GET['s']) == $alt->getCodUnico())
				{
					if ($p->getTipo()->getCodigo() == 1)
					{
						$tpl = str_replace("<!--hidSeq-->", $alt->getSequencia(), $tpl);
						//$tpl = str_replace("<!--nomeimg-->", $alt->getImagem(), $tpl);
						$tpl = str_replace("<!--nomeimg-->", "", $tpl);
						$tpl = str_replace("<!--txtTextoAdicional-->", $alt->getTexto(), $tpl);
						$tpl = str_replace("<!--opcoescorreto-->", SimNao::SelectSimNao($alt->getCorreto()), $tpl);
						$tpl = str_replace("<!--txtExplicacao-->", $alt->getExplicacao(), $tpl);
						$tpl = str_replace("<!--hidocultar-->", "N", $tpl);
					}
					else if (($p->getTipo()->getCodigo() == 2) || ($p->getTipo()->getCodigo() == 3))
					{
						$tpl = str_replace("<!--hidSeq-->", $alt->getSequencia(), $tpl);
						$tpl = str_replace("<!--txtAlternativa-->", $alt->getTexto(), $tpl);
						$tpl = str_replace("<!--selcorretotxt-->", SimNao::SelectSimNao($alt->getCorreto()), $tpl);
						$tpl = str_replace("<!--txtJustTxt-->", $alt->getExplicacao(), $tpl);
						$tpl = str_replace("<!--hidocultar-->", "N", $tpl);
					}
				}
				else
				{
					$tpl = str_replace("<!--hidocultar-->", "S", $tpl);
				}
			}
			else
			{
				$tpl = str_replace("<!--hidocultar-->", "S", $tpl);
			}
		}

		$itens .= '<div id="addAlt" class="box-alternativa box-zero-alternativa">';
		$itens .= '    <span style="line-height:43px;">@lng[Adiciona alternativa]</span>';
		$itens .= '</div>';
	}
	else
	{
		$itens  = '<div id="addAlt" class="box-alternativa box-zero-alternativa">';
		$itens .= '    @lng[Nenhuma alternativa cadastrada]<br />';
		$itens .= '    @lng[Adiciona alternativa]';
		$itens .= '</div>';
	}

	// Se não foi informado nenhum registro, limpa o que ficou pra traz
	$tpl = str_replace("<!--hidSeq-->", "", $tpl);
	$tpl = str_replace("<!--nomeimg-->", "", $tpl);
	$tpl = str_replace("<!--txtTextoAdicional-->", "", $tpl);
	$tpl = str_replace("<!--txtExplicacao-->", "", $tpl);
	$tpl = str_replace("<!--opcoescorreto-->", SimNao::SelectSimNao(), $tpl);
	
	$tpl = str_replace("<!--txtAlternativa-->", "", $tpl);
	$tpl = str_replace("<!--selcorretotxt-->", SimNao::SelectSimNao(), $tpl);
	
	
	$tips = '<option value="0">@lng[Todos]</option>';
	foreach ($p->tipos->ListaRecordSet() as $tipo)
	{
		$tips .= '<option value="' . $tipo->Codigo . '">' . $tipo->Descricao . '</option>';
	}

	$cls = '<option value="0">@lng[Todos]</option>';
	foreach ($p->classes->ListaRecordSet() as $classe)
	{
		$cls .= '<option value="' . $classe->Codigo. '">' . $classe->Descricao . '</option>';
	}

	$tpl = str_replace('<!--descricao-->', $p->getTexto(), $tpl);
	$tpl = str_replace('<!--alternativas-->', $itens, $tpl);
	$tpl = str_replace('<!--tipo-->', $p->getTipo()->getDescricao() , $tpl);
	$tpl = str_replace('<!--hidtipo-->', $p->getTipo()->getCodigo(), $tpl);
	$tpl = str_replace("<!--classespergunta-->", $cls, $tpl);
	$tpl = str_replace("<!--tipospergunta-->", $tips, $tpl);

	$_SESSION['perg'] = $p->getCodigo();
	echo(Comuns::Idioma($tpl));
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