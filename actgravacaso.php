<?php
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/caso.class.php';
include_once 'cls/objetivo.class.php';
include_once 'cls/anamnese.class.php';
include_once 'cls/examefisico.class.php';
include_once 'cls/hipoteses.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/tratamento.class.php';
include_once 'cls/desfecho.class.php';
include_once 'cls/conteudo.class.php';

include_once 'cls/area.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{
	$secao = $_POST['etapa'];

	switch ($secao)
	{
		case "basicos":
			fntProcessaDadosBasicos();
			break;
		case "objetivos":
			fntProcessaDadosObjetivos();
			break;
		case "anamnese":
			fntProcessaDadosAnamnese();
			break;
		case "examefisico":
			fntProcessaDadosExameFisico();
			break;
		case "hipoteses":
			fntProcessaDadosHipoteses();
			break;
		case "exames":
			fntProcessaDadosExames();
			break;
		case "diagnosticos":
			fntProcessaDadosDiagnosticos();
			break;
		case "tratamentos":
			fntProcessaDadosTratamentos();
			break;
		case "desfechos":
			fntProcessaDadosDesfechos();
			break;
		case "conteudos":
			fntProcessaDadosConteudos();
			break;
		case "exercicios":
			fntProcessaDadosExercicios();
			break;
		case "montagem":
			fntProcessaDadosMontagem();
			break;
	}
}

function fntProcessaDadosBasicos()
{
	$codcaso = $_SESSION['caso'];

	$nome = $_POST['txtNome'];
	$descricao = stripslashes(urldecode($_POST['txtDescricao']));
	$area = $_POST['selArea'];
	$nivel = $_POST['selNivelDif'];
	$feed = $_POST['selFeedback'];
	$ativo = $_POST['selAtivo'];
	$sexo = $_POST['selSexo'];
	$idade = $_POST['txtIdade'];
	$idpac = $_POST['txtIdPaciente'];
	$etnia = $_POST['selEtnia'];
	$nomepac = $_POST['txtNomePac'];
	$imgpac = $_POST['selImagem'];
	$cid10 = $_POST['txtCid10'];
	$publico = ((($_POST['chkPublico'] == "on") || ($_POST['chkPublico'] == "1")) ? 1 : 0);
	$exigelogin = ((($_POST['chkExigeLogin'] == "on") || ($_POST['chkExigeLogin'] == "1")) ? 0 : 1); /* é o contrário */

	$c = new Caso();

	if (trim($nome) != "") { $c->setNome($nome); }
	if (trim($descricao) != "") { $c->setDescricao($descricao); }

	if (($area != "") && ($area > 0))
	{
		$c->setArea(AreaConhecimento::RetornaArea($area));
	}

	if (($nivel != "") && ($nivel > 0))
	{
		$c->setNivelDificuldade(NivelPergunta::RetornaNivel($nivel));
	}

	if ($feed != "") { $c->setFeedback($feed); }
	if ($ativo != "") { $c->setAtivo($ativo); }
	if ($sexo != "") { $c->setSexoPac($sexo); }
	if ($idade != "") { $c->setIdadePac($idade); }
	if ($idpac != "") { $c->setIdPac($idpac); }
	if ($etnia != "") { $c->setEtnia($etnia); }
	if ($nomepac != "") { $c->setNomePaciente($nomepac); }
	if ($imgpac != "") { $c->setImagemPaciente($imgpac); }
	if ($cid10 != "") { $c->setCid10($cid10); }
	$c->setPublico($publico);
	$c->setExigeLogin($exigelogin);
	
	$ret = "";

	if ($codcaso == 0)
	{
		$u = unserialize($_SESSION['usu']);
		//Caso novo
		$c->setCodAutor($u->getCodigo());
		$ret = $c->Insere();
		$codigo = $c->getCodigo();
		$_SESSION['caso'] = $codigo;
		Log::RegistraLog('Criou o caso de estudo ' . $c->getNome() . ' (Código ' . $codigo . ')');
	}
	else if ($codcaso > 0)
	{
		$c->setCodigo($codcaso);
		$ret = $c->Atualiza();
		Log::RegistraLog('Atualizou os dados basicos do caso de estudo ' . $c->getNome() . ' (Código ' . $codigo . ')');
	}

	if ($ret == true)
	{
		echo("OK" . (($codcaso == 0) ? base64_encode($_SESSION['caso']) : ""));
	}
	else
	{
		Log::RegistraLog('ERRO. Acusado erro ao executar ultima operação. DADOS BASICOS. Descrição: ' . $c->getErro());
		echo($c->getErro());
	}
}

function fntProcessaDadosObjetivos()
{
	if ($_SESSION['caso'] > 0)
	{
		$codcaso = $_SESSION['caso'];
		
		$des = urldecode($_POST['txtDescricao']);
		
		$ob = new Objetivo();
		
		if (trim($des) != "") { $ob->setDescricao($des); }
		
		$ob->setCodcaso($codcaso);
		
		$ret = "";
		
		if ($_SESSION['objetivo'] > 0)
		{
			$ob->setCoditem($_SESSION['objetivo']);
			$ret = $ob->Atualiza();
			$_SESSION['objetivo'] = 0;
			Log::RegistraLog('Atualizou o objetivo ' . $ob->getCoditem() . ' do caso de estudo ' . $codcaso);
		}
		else
		{
			$ret = $ob->Insere();
			Log::RegistraLog('Inseriu um objetivo para o caso de estudo.');
		}
		
		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			Log::RegistraLog('ERRO. Acusado erro ao executar ultima operação. OBJETIVOS. Descrição: ' . $ob->getErro());
			echo($ob->getErro());
		}
	}
}

function fntProcessaDadosAnamnese()
{
	if ($_SESSION['caso'] > 0)
	{
		$codcaso = $_SESSION['caso'];

		$id = stripslashes(urldecode($_POST['txtID']));
		$qp = stripslashes(urldecode($_POST['txtQP']));
		$hda = stripslashes(urldecode($_POST['txtHDA']));
		$hmp = stripslashes(urldecode($_POST['txtHMP']));
		$hf = stripslashes(urldecode($_POST['txtHF']));
		$pps = stripslashes(urldecode($_POST['txtPPS']));
		$rs = stripslashes(urldecode($_POST['txtRS']));
		//$ef = $_POST['txtEF'];

		$a = new Anamnese();

		if (trim($id) != "") { $a->setIdentificacao($id); }
		if (trim($qp) != "") { $a->setQueixapri($qp); }
		if (trim($hda) != "") { $a->setHistatual($hda); }
		if (trim($hmp) != "") { $a->setHistpregressa($hmp); }
		if (trim($hf) != "") { $a->setHistfamiliar($hf); }
		if (trim($pps) != "") { $a->setPerfilpsicosocial($pps); }
		if (trim($rs) != "") { $a->setRevsistemas($rs); }
		//if (trim($ef) != "") { $a->setExamefisico($ef); }

		$ret = "";

		$a->setCodcaso($codcaso);

		if ($a->VerificaCodigo() == false)
		{
			$ret = $a->Insere();
			Log::RegistraLog('Inseriu a anamnese do caso ' . $codcaso . ')');
		}
		else
		{
			$ret = $a->Atualiza();
			Log::RegistraLog('Atualizou a anamnese do caso ' . $codcaso . ')');
		}

		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			Log::RegistraLog('ERRO. Acusado erro ao executar ultima operaçao. ANAMNESE. Descrição: ' . $a->getErro());
			echo($a->getErro());
		}
	}
	else
	{
		$msg = base64_encode("@lng[Nenhum caso clínico vinculado]");
		header("Location:vwcaso.php?m=" . $msg);
	}
}

function fntProcessaDadosExameFisico()
{
	if ($_SESSION['caso'] > 0)
	{
		$codcaso = $_SESSION['caso'];
		
		$cabeca = $_POST['txtExaFisCabeca'];
		$pescoco = $_POST['txtExaFisPescoco'];
		$auspulmonar = $_POST['txtExaFisAusPulmonar'];
		$auscardiaca = $_POST['txtExaFisAusCardiaca'];
		$sinvit = $_POST['txtExaFisSinVit'];
		$abdomen = $_POST['txtExaFisAbdomen'];
		$pele = $_POST['txtExaFisPele'];
		$extrem = $_POST['txtExaFisExtrem'];
		$geral = $_POST['txtExaFisGeral'];
		
		$midcabeca = $_POST['midCabeca'];
		$midpescoco = $_POST['midPescoco'];
		$midauspulmonar = $_POST['midAusPulmonar'];
		$midauscardiaca = $_POST['midAusCardiaca'];
		$midabdomen = $_POST['midAbdomen'];
		$midextrem = $_POST['midExtrem'];
		$midpele = $_POST['midPele'];
		$midsinvit = $_POST['midSinVit'];
		$midgeral = $_POST['midGeral'];
		
		$ef = new ExameFisico();
		
		if (trim($cabeca) != "") { $ef->setCabeca($cabeca); }
		if (trim($pescoco) != "") { $ef->setPescoco($pescoco); }
		if (trim($auspulmonar) != "") { $ef->setAuscultapulmonar($auspulmonar); }
		if (trim($auscardiaca) != "") { $ef->setAuscultacardiaca($auscardiaca); }
		if (trim($sinvit) != "") { $ef->setSinaisvitais($sinvit); }
		if (trim($abdomen) != "") { $ef->setAbdomen($abdomen); }
		if (trim($pele) != "") { $ef->setPele($pele); }
		if (trim($extrem) != "") { $ef->setExtremidades($extrem); }
		if (trim($geral) != "") { $ef->setEstadoGeral($geral); }
		
		if (trim($midcabeca) != "") { $ef->setMidiasCabeca($midcabeca); }
		if (trim($midpescoco) != "") { $ef->setMidiasPescoco($midpescoco); }
		if (trim($midauspulmonar) != "") { $ef->setMidiasAuscultaPulmonar($midauspulmonar); }
		if (trim($midauscardiaca) != "") { $ef->setMidiasAuscultaCardiaca($midauscardiaca); }
		if (trim($midabdomen) != "") { $ef->setMidiasAbdomen($midabdomen); }
		if (trim($midextrem) != "") { $ef->setMidiasExtremidades($midextrem); }
		if (trim($midpele) != "") { $ef->setMidiasPele($midpele); }
		if (trim($midsinvit) != "") { $ef->setMidiasSinaisVitais($midsinvit); }
		if (trim($midgeral) != "") { $ef->setMidiasEstadoGeral($midgeral); }
		
		$ret = "";
		$ef->setCodcaso($codcaso);
		
		if ($ef->VerificaCodigo() == false)
		{
			$ret = $ef->Insere();
		}
		else
		{
			$ret = $ef->Atualiza();
		}
		
		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			echo($ef->getErro());
		}
	}
	else
	{
		$msg = base64_encode("@lng[Nenhum caso clínico vinculado]");
		header("Location:vwcaso.php?m=" . $msg);
	}
}

function fntProcessaDadosHipoteses()
{
	if ($_SESSION['caso'] > 0)
	{
		$descricao = urldecode($_POST['txtDescricao']);
		$correto = $_POST['selCorreto'];
		$justificativa = stripcslashes(urldecode($_POST['txtJustificativa']));
		$adicional = stripcslashes(urldecode($_POST['txtAdicional']));

		$h = new Hipoteses();

		$h->setCodcaso($_SESSION['caso']);

		if ($descricao != "") { $h->setDescricao($descricao); }
		if ($correto != "") { $h->setCorreto($correto); }
		if ($justificativa != "") { $h->setJustificativa($justificativa); }
		if ($adicional != "") { $h->setConteudoadicional($adicional); }

		$ret = "";

		if ($_SESSION['hipotese'] > 0)
		{
			$h->setCodhipotese($_SESSION['hipotese']);
			$ret = $h->Atualiza();
			$_SESSION['hipotese'] = 0;
		}
		else
		{
			$ret = $h->Insere();
			$_SESSION['hipotese'] = 0;
		}

		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			echo($h->getErro());
		}
	}
}

function fntProcessaDadosExames()
{
	header('Content-Type: text/html; charset=iso-8859-1');

	if ($_SESSION['caso'] > 0)
	{
		$descricao = urldecode($_POST['txtDescricao']);
		$tipo = $_POST['selTipoExame'];
		$correto = $_POST['selCorreto'];
		$bateria = $_POST['txtBateria'];
		$justificativa = stripslashes(urldecode($_POST['txtJustificativa']));
		$complemento = stripslashes(urldecode($_POST['txtAdicional']));
		$vinculos = (isset($_POST['chkHipXExames']) ? $_POST['chkHipXExames'] : null);
		$mostraquando = $_POST['selMostraQuando'];
		$agrupar = (($_POST['chkMostraIsolado'] == "1") ? "0" : "1");	// No banco o campo se chama AgrupaComABateria (biela froxa)

		$e = new Exame();

		$e->setCodcaso($_SESSION['caso']);

		if ($descricao != "") { $e->setDescricao($descricao); }
		if ($tipo != "") { $e->setTipo($tipo); }
		if ($correto != "") { $e->setCorreto($correto); }
		if ($bateria != "") { $e->setBateria($bateria); }
		if ($justificativa != "") { $e->setJustificativa($justificativa); }
		if ($complemento != "") { $e->setConteudoadicional($complemento); }
		if ($mostraquando != "") { $e->setMostraQuando($mostraquando); }
		if ($agrupar != "") { $e->setMostrarAgrupado($agrupar); }

		$ret = "";

		if ($_SESSION['exame'] > 0)
		{
			$e->setCodexame($_SESSION['exame']);
			$ret = $e->Atualiza();
			$_SESSION['exame'] = 0;
		}
		else
		{
			$ret = $e->Insere();
			$_SESSION['exame'] = 0;
		}

		if ($ret == true)
		{
			if ($vinculos != null)
			{
				$ret = $e->SalvaRelacoesExame($vinculos);
				if ($ret == true)
				{
					echo("OK");
				}
				else
				{
					echo($e->getErro());
				}
			}
			else
			{
				echo("OK");
			}
		}
		else
		{
			echo($e->getErro());
		}
	}
}

function fntProcessaDadosDiagnosticos()
{
	if ($_SESSION['caso'] > 0)
	{
		$descricao = urldecode($_POST['txtDescricao']);
		$correto = $_POST['selCorreto'];
		$justificativa = stripslashes(urldecode($_POST['txtJustificativa']));
		$adicional = stripslashes(urldecode($_POST['txtAdicional']));
		$vinculos = (isset($_POST['chkExamesXDiagn']) ? $_POST['chkExamesXDiagn'] : null);

		$d = new Diagnostico();

		$d->setCodcaso($_SESSION['caso']);

		if ($descricao != "") { $d->setDescricao($descricao); }
		if ($correto != "") { $d->setCorreto($correto); }
		if ($justificativa != "") { $d->setJustificativa($justificativa); }
		if ($adicional != "") { $d->setConteudoadicional($adicional); }

		$ret = "";

		if ($_SESSION['diagnostico'] > 0)
		{
			$d->setCoddiagnostico($_SESSION['diagnostico']);
			$ret = $d->Altera();
			$_SESSION['diagnostico'] = 0;
		}
		else
		{
			$ret = $d->Insere();
			$_SESSION['diagnostico'] = 0;
		}

		if ($ret == true)
		{
			if ($vinculos != null)
			{
				$ret = $d->SalvaRelacoesDiagnostico($vinculos);
				if ($ret == true)
				{
					echo("OK");
				}
				else
				{
					echo($d->getErro());
				}
			}
			else
			{
				echo("OK");
			}
		}
		else
		{
			echo($d->getErro());
		}
	}
}

function fntProcessaDadosTratamentos()
{
	header('Content-Type: text/html; charset=iso-8859-1');

	if ($_SESSION['caso'] > 0)
	{
		$titulo = urldecode($_POST['txtTitulo']);
		$descricao = stripslashes(urldecode($_POST['txtDescricao']));
		$correto = $_POST['selCorreto'];
		$justificativa = stripslashes(urldecode($_POST['txtJustificativa']));
		$complemento = stripslashes(urldecode($_POST['txtAdicional']));
		$vinculos = (isset($_POST['chkDiagnXTrat']) ? $_POST['chkDiagnXTrat'] : null);

		$t = new Tratamento();

		$t->setCodcaso($_SESSION['caso']);

		if ($titulo != "") { $t->setTitulo($titulo); }
		if ($descricao != "") { $t->setDescricao($descricao); }
		if ($correto != "") { $t->setCorreto($correto); }
		if ($justificativa != "") { $t->setJustificativa($justificativa); }
		if ($complemento != "") { $t->setConteudoadicional($complemento); }

		$ret = "";

		if ($_SESSION['tratamento'] > 0)
		{
			$t->setCodtratamento($_SESSION['tratamento']);
			$ret = $t->Atualiza();
			$_SESSION['tratamento'] = 0;
		}
		else
		{
			$ret = $t->Insere();
			$_SESSION['tratamento'] = 0;
		}

		if ($ret == true)
		{
			if ($vinculos != null)
			{
				$ret = $t->SalvaRelacoesTratamento($vinculos);
				if ($ret == true)
				{
					echo("OK");
				}
				else
				{
					echo($t->getErro());
				}
			}
			else
			{
				echo("OK");
			}
		}
		else
		{
			echo($e->getErro());
		}
	}
}

function fntProcessaDadosDesfechos()
{
	header('Content-Type: text/html; charset=iso-8859-1');

	if ($_SESSION['caso'] > 0)
	{
		$desfecho = stripslashes(urldecode($_POST['txtDesfecho']));
		$titulo = urldecode($_POST['txtTitulo']);
		$vinculos = (isset($_POST['chkTratXDesf']) ? $_POST['chkTratXDesf'] : null);

		$d = new Desfecho();

		$d->setCodcaso($_SESSION['caso']);

		if ($desfecho != "") { $d->setDesfecho($desfecho); }
		if ($titulo != "") { $d->setTitulo($titulo); }

		$ret = "";

		if ($_SESSION['desfecho'] > 0)
		{
			$d->setCoddesfecho($_SESSION['desfecho']);
			$ret = $d->Atualiza();
			$_SESSION['desfecho'] = 0;
		}
		else
		{
			$ret = $d->Insere();
			$_SESSION['desfecho'] = 0;
		}

		if ($ret == true)
		{
			if ($vinculos != null)
			{
				$ret = $d->SalvaRelacoesDesfecho($vinculos);
				if ($ret == true)
				{
					echo("OK");
				}
				else
				{
					echo($d->getErro());
				}
			}
			else
			{
				echo("OK");
			}
		}
		else
		{
			echo($d->getErro());
		}
	}
}

function fntProcessaDadosConteudos()
{
	if ($_SESSION['caso'] > 0)
	{
		$conteudo = stripslashes(urldecode($_POST['txtTexto']));
		$descricao = urldecode($_POST['txtDescricao']);
		
		$con = new Conteudo();
		
		$con->setCodcaso($_SESSION['caso']);
		if ($conteudo != "") { $con->setTexto($conteudo); }
		if ($descricao != "") { $con->setDescricao($descricao); }
		
		$ret = "";
		
		if ($_SESSION['conteudo'] > 0)
		{
			$con->setCodconteudo($_SESSION['conteudo']);
			$ret = $con->Atualiza();
			$_SESSION['conteudo'] = 0;
		}
		else
		{
			$ret = $con->Insere();
			$_SESSION['conteudo'] = 0;
		}
		
		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			echo($con->getErro());
		}
	}
}

function fntProcessaDadosExercicios()
{
	if ($_SESSION['caso'] > 0)
	{
		$exes = $_POST['chkRelPergCaso'];
		$agrups = $_POST['chkRelAgrupCaso'];
		
		$c = new Caso();
		$c->setCodigo($_SESSION['caso']);
		
		$ret = $c->SalvaExercicios($exes);
		
		if ($ret == true)
		{
			if ($agrups != null)
			{
				$ret = $c->SalvaAgrupamentos($agrups);
				
				if ($ret == true)
				{
					echo("OK");
				}
				else
				{
					echo($c->getErro());
				}
			}
			else
			{
				echo("OK");
			}
		}
		else
		{
			echo($c->getErro());
		}
	}
}

function fntProcessaDadosMontagem()
{
	if ($_SESSION['caso'] > 0)
	{
		$itens = $_POST['item'];
		$c = new Caso();
		$c->setCodigo($_SESSION['caso']);
		
		$ret = $c->SalvaMontagem($itens);
		
		if ($ret == true)
		{
			echo("OK");
		}
		else
		{
			echo($c->getErro());
		}
	}
}

Main();

?>