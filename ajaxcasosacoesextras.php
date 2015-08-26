<?php
session_start();
include_once 'cls/caso.class.php';
include_once 'cls/hipoteses.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/tratamento.class.php';
include_once 'cls/desfecho.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/grupo.class.php';
include_once 'cls/permissao.class.php';

include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

header('Content-Type: text/html; charset=iso-8859-1');

// Funções de salvar dados ----------
function fntSalvaTextoHipoteses()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$hip = new Hipoteses();
		$texto = ((isset($_POST['txtPerguntaGuia'])) && $_POST['txtPerguntaGuia'] != "") ? urldecode($_POST['txtPerguntaGuia']) : null;

		$ret = $hip->SalvaPerguntaNorteadora($_SESSION['caso'] , $texto);
		if ($ret == false)
		{
			throw new Exception(Comuns::Idioma("@lng[Erro ao salvar.] ") + $hip->getErro(), 1002);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntSalvaTextoExames()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$ex = new Exame();
		$texto = ((isset($_POST['txtPerguntaGuia'])) && $_POST['txtPerguntaGuia'] != "") ? urldecode($_POST['txtPerguntaGuia']) : null;

		$ret = $ex->SalvaPerguntaNorteadora($_SESSION['caso'] , $texto);
		if ($ret == false)
		{
			throw new Exception(Comuns::Idioma("@lng[Erro ao salvar.] ") + $ex->getErro(), 1002);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntSalvaTextoDiagnosticos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$d = new Diagnostico();
		$texto = ((isset($_POST['txtPerguntaGuia'])) && $_POST['txtPerguntaGuia'] != "") ? urldecode($_POST['txtPerguntaGuia']) : null;

		$ret = $d->SalvaPerguntaNorteadora($_SESSION['caso'] , $texto);
		if ($ret == false)
		{
			throw new Exception(Comuns::Idioma("@lng[Erro ao salvar.] ") + $ex->getErro(), 1002);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntSalvaTextoTratamentos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$t = new Tratamento();
		$texto = ((isset($_POST['txtPerguntaGuia'])) && $_POST['txtPerguntaGuia'] != "") ? urldecode($_POST['txtPerguntaGuia']) : null;

		$ret = $t->SalvaPerguntaNorteadora($_SESSION['caso'] , $texto);
		if ($ret == false)
		{
			throw new Exception(Comuns::Idioma("@lng[Erro ao salvar.] ") + $ex->getErro(), 1002);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntSalvaTextoDesfechos()
{
if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$d = new Desfecho();
		$texto = ((isset($_POST['txtPerguntaGuia'])) && $_POST['txtPerguntaGuia'] != "") ? urldecode($_POST['txtPerguntaGuia']) : null;

		$ret = $d->SalvaPerguntaNorteadora($_SESSION['caso'] , $texto);
		if ($ret == false)
		{
			throw new Exception(Comuns::Idioma("@lng[Erro ao salvar.] ") + $d->getErro(), 1002);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}
// Fim funções de salvar dados ------

// Funções de exclusão --------------
function fntDeletaImagemExame()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		if ((isset($_SESSION['exame'])) && ($_SESSION['exame'] > 0))
		{
			$coditem = base64_decode($_POST['r']);
			
			$e = new Exame();
			$ret = $e->DetelaImagemExame($_SESSION['caso'], $_SESSION['exame'], $coditem);
			if ($ret == false)
			{
				throw new Exception(Comuns::Idioma("@lng[Erro ao excluir.] " + $e->getErro()), 1004);
			}
		}
		else
		{
			throw new Exception(Comuns::Idioma("@lng[Exame não selecionado]"), 1005);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntDeletaDocumentoExame()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		if ((isset($_SESSION['exame'])) && ($_SESSION['exame'] > 0))
		{
			$coditem = base64_decode($_POST['r']);
			
			$e = new Exame();
			$ret = $e->DetelaDocumentoExame($_SESSION['caso'], $_SESSION['exame'], $coditem);
			if ($ret == false)
			{
				throw new Exception(Comuns::Idioma("@lng[Erro ao excluir.] " + $e->getErro()), 1004);
			}
		}
		else
		{
			throw new Exception(Comuns::Idioma("@lng[Exame não selecionado]"), 1005);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntSalvaResultadoExame()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		if ((isset($_SESSION['exame'])) && ($_SESSION['exame'] > 0))
		{
			$e = new Exame();
			$e->setCodcaso($_SESSION['caso']);
			$e->setCodexame($_SESSION['exame']);
			
			foreach ($_POST as $campo => $valor)
			{
				if (substr($campo, 0, 8) == "txtValRe")
				{
					$componente = split("_", $campo);
					$componente = $componente[1];
					$resultado = $valor;
					
					$observacao = $_POST["txtObsRe_" . $componente];
					$observacao = (($observacao == "") ? null : $observacao);
					
					$ret = $e->SalvaResultados($componente, $resultado, $observacao);
					if ($ret == false)
					{
						throw new Exception(Comuns::Idioma("@lng[Erro ao gravar resultados do exame.] " . $e->getErro()), 1234);
					}
				}
				else if(substr($campo, 0, 8) == "txtLaudo")
				{
					$e->setLaudo($valor);
					$ret = $e->SalvaLaudo();
					
					if ($ret == false)
					{
						throw new Exception(Comuns::Idioma("@lng[Erro ao salvar o laudo do exame.] " . $e->getErro()), 1235);
					}
				}
			}
		}
		else
		{
			throw new Exception(Comuns::Idioma("@lng[Exame não selecionado]"), 1005);
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntExcluirUsuarioSistema()
{
	$codusuario = base64_decode($_POST['r']);
	
	$u = new Usuario();
	$u->setCodigo($codusuario);
	$ret = $u->DeletaUsuario();
	
	echo($ret);
}

function fntProcessaExamesCaso()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$e = new Exame();
		$e->setCodcaso($_SESSION['caso']);
		$ret = $e->ProcessarExames();
		
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
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntReprocessaExamesCaso()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$e = new Exame();
		$e->setCodcaso($_SESSION['caso']);
		$ret = $e->ReprocessarExames();
		
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
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntSalvaVinculoConteudosExames()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$e = new Exame();
		
		$codconteudo = $_POST['selConteudos'];
		$tipoIns = substr($codconteudo,0,1);
		$codconteudo = substr($codconteudo,1);
		
		//$numbateria = $_POST['selBaterias'];
		$codexame = $_POST['selExames'];
		$codconteudo = base64_decode($codconteudo);
		
		if ($codexame == "-1")
			$codexame = null;
		else
			$codexame = base64_decode($codexame);
		
		//$ret = $e->SalvaVinculoConteudoExame($_SESSION['caso'], $numbateria, $codexame, $codconteudo);
		if($tipoIns == "C")
			$ret = $e->SalvaVinculoConteudoExame($_SESSION['caso'], 0, $codexame, $codconteudo);
		else
			$ret = $e->SalvaVinculoMidiaExame($_SESSION['caso'], 0, $codexame, $codconteudo);
		
		if ($ret == true)
		{
			$ret = $e->ListaConteudosVinculados($_SESSION['caso']);
			$ret .= $e->ListaMidiasVinculados($_SESSION['caso']);
			
			if ($ret != false)
			{
				echo($ret);
			}
			else
			{
				echo("ERRO - " . $e->getErro());
			}
		}
		else
		{
			echo("ERRO - " . $e->getErro());
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntDesvincularConteudoExame()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$e = new Exame();
		
		$codconteudo = $_POST['selConteudo'];
		$tipoIns = substr($codconteudo,0,1);
		$codconteudo = substr($codconteudo,1);
		//$numbateria = $_POST['selBaterias'];
		$codconteudo = base64_decode($codconteudo);
		
		//$ret = $e->SalvaVinculoConteudoExame($_SESSION['caso'], $numbateria, $codexame, $codconteudo);
		$ret = $e->DesvincularMidiaExame($_SESSION['caso'], 0, $codconteudo);
		
		if ($ret == true)
		{
			$ret = $e->ListaConteudosVinculados($_SESSION['caso']);
			$ret .= $e->ListaMidiasVinculados($_SESSION['caso']);
			
			if ($ret != false)
			{
				echo($ret);
			}
			else
			{
				echo("ERRO - " . $e->getErro());
			}
		}
		else
		{
			echo("ERRO - " . $e->getErro());
		}
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Caso não encontrado]"), 1003);
	}
}

function fntDeletaMidia()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$mid = new Midia();
		$mid->setCodCaso($_SESSION['caso']);
		$mid->setCodMidia(base64_decode($_POST['img']));
		if($mid->Deteta(true))
		{
			echo(Comuns::Idioma("@lng[Mídia excluída com sucesso!]"));
		}
		else
		{
			echo(Comuns::Idioma("ERRO @lng[Erro ao excluir a mídia!]"));
		}
	}
	else
	{
		echo(Comuns::Idioma("ERRO @lng[Não foi possível atualizar os dados.]"));
	}
}

function fntDeletaGrupoUsuario()
{
	$codgrupo = base64_decode($_POST['r']);
	
	try
	{
		$u = new Grupo();
		$u->setCodigo($codgrupo);
		if($u->DeletaGrupoUsuario())
			echo("SUCESSO");
		else
			echo("ERRO");
	}
	catch (Exception $e)
	{
		echo($e->getMessage());
	}
}

function fntDeletaPermissaoSistema()
{
	$codgrupo = base64_decode($_POST['r']);
	
	$u = new Permissao();
	$u->setCodigo($codgrupo);
	if($u->DeletaPermissao())
		echo("SUCESSO");
	else
		echo("ERRO");
}

function fntListaValoresReferenciaExames()
{
	$te = new TipoExame();
	
	$rsValores = $te->ListaValoresReferencia(base64_decode($_POST['te']), base64_decode($_POST['cc']));
	if ($rsValores !== false)
	{
		$cont = 0;
		foreach ($rsValores as $ValRef)
		{
			if ($cont == 0)
			{
				$html .= '<div class="tit-valref">' . $ValRef->Descricao . '</div>';
			}
			
			if ($ValRef->Agrupador != '')
			{
				$html .= '<div class="tit-val-ref-descricao">' . $ValRef->Agrupador . '</div>';
			}
			$html .= '<div class="desc-val-ref">' . $ValRef->Padrao . ' ' . $ValRef->UnidadeMedida . '</div>';
			$cont++;
		}
	}
	else
	{
		if ($te->getErro() == 'ZERO')
		{
			$html = "@lng[Nenhum valor de referência cadastrado]";
		}
		else
		{
			$html = "ERRO: " . $te->getErro();
		}
	}
	echo(Comuns::Idioma($html));
}

function fntGeraNovaVersaoCaso()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$c = new Caso();
		$c->setCodigo($_SESSION['caso']);
		if ($c->CriaNovaVersao())
		{
			echo("SUCESSO");
		}
		else
		{
			echo("ERRO: " . $c->getErro());
		}
	}
	else
	{
		echo(Comuns::Idioma("ERRO @lng[Não foi possível atualizar os dados.]"));
	}
}

function Padrao()
{
	echo(Comuns::Idioma("ERRO: @lng[Requisição enviada inválida]"));
}

function Main()
{
	$acao = $_POST['act'];
	
	if (!isset($acao))
	{
		throw new Exception("@lng[Ação não informada]", 1000);
		return;
	}
	
	switch ($acao)
	{
		case "sth":	/* salvar texto hipoteses */
			fntSalvaTextoHipoteses();
			break;
		case "ste":
			fntSalvaTextoExames();
			break;
		case "stt":
			fntSalvaTextoTratamentos();
			break;
		case "std":
			fntSalvaTextoDesfechos();
			break;
		case "stdi":
			fntSalvaTextoDiagnosticos();
			break;
		case "delimgexame":
			fntDeletaImagemExame();
			break;
		case "deldocexame":
			fntDeletaDocumentoExame();
			break;
		case "salvaresexame":
			fntSalvaResultadoExame();
			break;
		case "eus":
			fntExcluirUsuarioSistema();
			break;
		case "pec":
			fntProcessaExamesCaso();
			break;
		case "rec":
			fntReprocessaExamesCaso();
			break;
		case "svce":
			fntSalvaVinculoConteudosExames();
			break;
		case "rvce":
			fntDesvincularConteudoExame();
			break;
		case "delmidia":
			fntDeletaMidia();
			break;
		case "egrpusu":
			fntDeletaGrupoUsuario();
			break;
		case "delperm":
			fntDeletaPermissaoSistema();
			break;
		case "vre":
			fntListaValoresReferenciaExames();
			break;
		case "nvc":
			fntGeraNovaVersaoCaso();
			break;
		default:
			Padrao();
	}
}

Main();

?>