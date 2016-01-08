<?php
//--utf8_encode --
session_start();

include_once 'cls/pergunta.class.php';
include_once 'cls/components/botao.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	$codigo = isset($_POST['txtCodigo']) ? base64_decode($_POST['txtCodigo']) : null;
	$txt = urldecode($_POST['txtDescricao']);
	$clsAtual = $_POST['selClasse'];
	$nivAtual = $_POST['selNivel'];
	$tipAtual = $_POST['selTipo'];
	$ativo = $_POST['selAtivo'];
	$act = isset($_POST['act']) ? base64_decode($_POST['act']) : null;
	$expGeral = $_POST['txtExplicacaoGeral'];

	$u = unserialize($_SESSION['usu']);

	// Ação veio vazio. Sendo assim monta o formulário.
	if (!$act)
	{
		// Busca o template
		$tpl = file_get_contents('tpl/perguntas-E1.html');
		$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
		
		$botoes  = Botao::BotaoSalvar("fntGravaE1();", "@lng[Salvar pergunta e cadastrar/editar alternativas]");
		$botoes .= Botao::BotaoCancelar("fntNavega('listagem.php?t=8');", "@lng[Cancelar edição]");
		
		$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
		$tpl = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl);
		
		// Verifica se veio um registro informado via GET
		if ( is_null($codigo) )
		{
			$codigo = isset($_GET['r']) ? base64_decode($_GET['r']) : null;
		}

		// Instancia classe
		$p = new Pergunta();

		// Se veio um código via GET, entende-se que o mesmo deva ser editado.
		if (! is_null($codigo))
		{
			$p->Carregar($codigo);
		}

		$tipos = $p->tipos->ListaRecordSet();
		$classes = $p->classes->ListaRecordSet();
		$niveis = $p->niveis->ListaRecordSet();

		$strtipos = "";
		$strclasses = "";
		$strniveis = "";

		foreach ($tipos as $linhat)
		{
			$strtipos .= '<option ' . ($linhat->Codigo == (($p->getTipo()!=null) ? $p->getTipo()->getCodigo() : 0) ? 'selected="selected"' : '') . ' value="' . $linhat->Codigo . '">' . $linhat->Descricao . '</option>';
		}

		foreach ($classes as $linhac)
		{
			$strclasses .= '<option ' . ($linhac->Codigo == $p->getClasse() ? 'selected="selected"' : '') . ' value="' . $linhac->Codigo . '">' . $linhac->Descricao . '</option>';
		}

		foreach ($niveis as $linhan)
		{
			$strniveis .= '<option ' . ($linhan->Codigo == $p->getNivel() ? 'selected="selected"' : '') . ' value="' . $linhan->Codigo . '">' . $linhan->Descricao . '</option>';
		}

		$strAtivo = '<option ' . ($p->getAtivo() == 1 ? 'selected="selected"' : "") . ' value="1">@lng[Sim]</option><option ' . ($p->getAtivo() == 0 ? 'selected="selected"' : "") . ' value="0">@lng[Não]</option>';

		$tpl = str_replace("<!--txtCodigo-->", ($p->getCodigo() == 0 ? "" : base64_encode($p->getCodigo())), $tpl);
		$tpl = str_replace("<!--TextoPergunta-->", $p->getTexto(), $tpl);
		$tpl = str_replace("<!--txtExplicacaoGeral-->", (is_null($p->getTextoExplicacaoGeral()) ? "" : $p->getTextoExplicacaoGeral()), $tpl);
		$tpl = str_replace("<!--ListaClasses-->", $strclasses, $tpl);
		$tpl = str_replace("<!--ListaNiveis-->", $strniveis, $tpl);
		$tpl = str_replace("<!--ListaAtivo-->", $strAtivo, $tpl);
		$tpl = str_replace("<!--ListaTipos-->", $strtipos, $tpl);
	}
	else if($act == "ins")
	{
		$p = new Pergunta();
		if ( ! is_null($codigo) ) { $p->setCodigo($codigo); }
		$p->setTexto($txt);
		$p->setClasse($clsAtual);
		$p->setNivel($nivAtual);
		$p->setTipo($tipAtual);
		$p->setAtivo($ativo);
		if ($expGeral != "") { $p->setTextoExplicacaoGeral($expGeral); }

		if ($p->getCodigo() === 0)
		{
			if ($p->AdicionaPergunta() === true)
			{
				$_SESSION['perg'] = serialize($p);
				header("Location:alternativas.php");
			}
			else
			{
				$_SESSION['perg'] = "";
				echo("@lng[Erro ao adicionar a pergunta:]");
			}
		}
		else
		{
			if ($p->AtualizaPergunta() === true)
			{
				$_SESSION['perg'] = serialize($p);
			}
		}
	}

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