<?php

//--utf8_encode --
session_start();

include_once 'cls/pergunta.class.php';
include_once 'cls/alternativa.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	if (isset($_SESSION['perg']))
	{
		$p = new Pergunta();
		$p->Carregar($_SESSION['perg']);
		$a = new Alternativa();

		$acao = (isset($_GET['act']) && (! is_null($_GET['act']))) ? $_GET['act'] : "";
		
		if($acao == "novaordem")
		{
			if($p->ReordenaAlternativa($_POST['ids']))
			{
				echo "OK";
			}
			else
			{
				$erros = "@lng[Erros ocorreram.]";
				foreach ($p->msg_erro as $err)
				{
					$erros .= "<br />" . $err;
				}
				echo $erros;
			}
		}
		else
		{
			// Nao recebe o codigo da pergunta pois este ja esta informado na session 'perg'
			// O recebimento da sequencia eh só pra decidir se insere ou atualiza a alternativa
	
			if ($p->getTipo()->getCodigo() == 1)
			{
				$seq = (isset($_POST['hidSeq']) && $_POST['hidSeq'] != "") ? $_POST['hidSeq'] : null;
				$txt = urldecode($_POST['txtTextoAdicional']);
				$car = $_POST['selCorreta'];
				$m_explicacao = (isset($_POST['chkMostra'])) ? $_POST['chkMostra'] : 0;
				$explicacao = $_POST['txtExplicacao'];
				$origem = ((isset($_POST['hdnOrigem']) && $_POST['hdnOrigem'] != "") ? $_POST['hdnOrigem'] : "");
				$acao = $_POST['selConsequencia'];
				$qual_acao = $_POST['selValorConsequencia'];
			}
			else
			{
				$seq = (isset($_POST['hidSeq']) && $_POST['hidSeq'] != "") ? $_POST['hidSeq'] : null;
				$txt = urldecode($_POST['txtAlternativa']);
				$car = $_POST['selCorretoTxt'];
				$explicacao = $_POST['txtJustTxt'];
				$origem = ((isset($_POST['hdnOrigem']) && $_POST['hdnOrigem'] != "") ? $_POST['hdnOrigem'] : "");
			}
	
			if ($acao == 1)
			{
				$qual_acao = 0;
			}
	
			if (!is_integer($qual_acao))
			{
				if (!is_null($qual_acao))
				{
					$qual_acao = base64_decode($qual_acao);
				}
			}
	
			if (! is_null($seq)) { $a->setSequencia($seq); }
			$a->setTexto($txt);
			$a->setCorreto($car);
			$a->setExplicacao($explicacao);
			$a->setExibirExplicacao($m_explicacao);
			$a->setTipoConsequencia($acao);
			$a->setValorConsequencia($qual_acao);
			$a->setOrigem($origem);
	
			if (is_null($seq))
			{
				if ($p->AdicionaAlternativa($a) === true)
				{
					$_SESSION['perg'] = $p->getCodigo();
					header("Location:vwalternativas.php?p=" . base64_encode($p->getCodigo()));
				}
				else
				{
					$erros = "@lng[Erros ocorreram.]";
					foreach ($p->msg_erro as $erro)
					{
						$erros .= "<br />" . $erro;
					}
					header("Location:vwalternativas.php?p=" . base64_encode($p->getCodigo()) . "&m=" . base64_encode($erros));
				}
			}
			else
			{
				if ($p->AtualizaAlternativa($a) === true)
				{
					$_SESSION['perg'] = $p->getCodigo();
					header("Location:vwalternativas.php?p=" . base64_encode($p->getCodigo()));
				}
				else
				{
					$erros = "@lng[Erros ocorreram.]";
					foreach ($p->msg_erro as $err)
					{
						$erros .= "<br />" . $err;
					}
					header("Location:vwalternativas.php?p=" . base64_encode($p->getCodigo()) . "&m=" . base64_encode($erros));
				}
			}
		}
	}
	else
	{
		echo("@lng[Pergunta não definida]");
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