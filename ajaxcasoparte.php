<?php
session_start();
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
include_once 'cls/pergunta.class.php';
include_once 'cls/grupopergunta.class.php';

include_once 'cls/usuario.class.php';
include_once 'cls/area.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/simnao.class.php';
include_once 'cls/sexo.class.php';
include_once 'cls/etnia.class.php';
include_once 'cls/imgpaciente.class.php';
include_once 'cls/tiporesposta.class.php';
include_once 'cls/menus.class.php';
include_once 'cls/caminhos.class.php';
include_once 'cls/midia.class.php';

include_once 'cls/grupo.class.php';

include_once 'cls/components/botao.class.php';
include_once 'cls/components/hashtable.class.php';
include_once 'cls/components/selectnumerico.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');

	$tela = $_POST['t'];
	//$tela = $_REQUEST['t'];
	$xml = "";

	if ($tela != "")
	{
		switch($tela)
		{
			case "inicio":
				$tpl = file_get_contents("tpl/casos-inicio-2.html");
				$xml = "<conteudo>" . $tpl . "</conteudo>";
				break;
			case "configs":
				$tpl = file_get_contents("tpl/casos-configs.html");
				$tpl = TratarDadosConfiguracoes($tpl);
				$mnu = Menus::MenusConfiguracoes();
				$caminho = Caminhos::MontaCaminhoConfiguracoes();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "basicos":
				$tpl = file_get_contents("tpl/casos-basicos.html");
				$tpl = TrataDadosBasicos($tpl);
				//$mnu = MenusBasicos();
				$mnu = Menus::MenusBasicos();
				$caminho = Caminhos::MontaCaminhoDadosBasicos();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "colaborador":
				$tpl = file_get_contents("tpl/casos-colaborador.html");
				$tpl = TrataDadosColaborador($tpl);
				//$mnu = MenusBasicos();
				$mnu = Menus::MenusColaborador();
				$caminho = Caminhos::MontaCaminhoColaborador();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "objetivos":
				$tpl = file_get_contents("tpl/casos-objetivos.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TrataDadosObjetivosDlg();
				}
				else
				{
					$tpl = TrataDadosObjetivos($tpl);
					//$mnu = MenusObjetivos();
					$mnu = Menus::MenusObjetivos();
					$caminho = Caminhos::MontaCaminhoObjetivos();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				break;
			case "anamnese":
				$tpl = file_get_contents("tpl/casos-anamnese.html");
				$tpl = TrataDadosAnamnese($tpl);
				//$mnu = MenusAnamnese();
				$mnu = Menus::MenusAnamnese();
				$caminho = Caminhos::MontaCaminhoAnamnese();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "examefisico":
				$tpl = file_get_contents("tpl/casos-examefisico.html");
				$tpl = TratarDadosExameFisico($tpl);
				$mnu = Menus::MenusExameFisico();
				$caminho = Caminhos::MontaCaminhoExameFisico();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "hipoteses":
				$tpl = file_get_contents("tpl/casos-hipoteses.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TrataDadosHipotesesDlg();
				}
				else
				{
					$tpl = TrataDadosHipoteses($tpl);
					//$mnu = MenusHipoteses();
					$mnu = Menus::MenusHipoteses();
					$caminho = Caminhos::MontaCaminhoHipoteses();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				break;
			case "exames":
				$tpl = file_get_contents("tpl/casos-exames.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TratarDadosExamesDlg();
				}
				else if (! ($_POST['d'] == 1))
				{
					$tpl = TrataDadosExames($tpl);
					//$mnu = MenusExames();
					$mnu = Menus::MenusExames();
					$caminho = Caminhos::MontaCaminhoExames();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				else
				{
					$tpl = file_get_contents("tpl/casos-exames-detalhes.html");
					$tpl = TrataDadosExamesDetalhes($tpl);
					$mnu = Menus::MenusExamesDetalhes();
					$caminho = Caminhos::MontaCaminhoExamesDetalhes();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				break;
			case "examesconteudos":
				$tpl = file_get_contents("tpl/casos-examesconteudos.html");
				$mnu = Menus::MenusExamesConteudos();
				$caminho = Caminhos::MontaCaminhoExamesDetalhes();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "diagnosticos":
				$tpl = file_get_contents("tpl/casos-diagnosticos.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TrataDadosDiagnosticosDlg();
				}
				else
				{
					$tpl = TrataDadosDiagnosticos($tpl);
					//$mnu = MenusDiagnosticos();
					$mnu = Menus::MenusDiagnosticos();
					$caminho = Caminhos::MontaCaminhoDiagnosticos();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				break;
			case "tratamentos":
				$tpl = file_get_contents("tpl/casos-tratamentos.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TratarDadosTratamentosDlg();
				}
				else
				{
					$tpl = TrataDadosTratamentos($tpl);
					//$mnu = MenusTratamentos();
					$mnu = Menus::MenusTratamentos();
					$caminho = Caminhos::MontaCaminhoTratamentos();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				break;
			case "desfechos":
				$tpl = file_get_contents("tpl/casos-desfechos.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TratarDadosDesfechosDlg();
				}
				else
				{
					$tpl = TrataDadosDesfechos($tpl);
					//$mnu = MenusDesfechos();
					$mnu = Menus::MenusDesfechos();
					$caminho = Caminhos::MontaCaminhoDesfechos();
					$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				}
				break;
			case "veimagemexame":
				$tpl = file_get_contents("tpl/casos-exames-ve-imagem.html");
				$tpl = TrataDadosExamesDetalhesImagem($tpl);
				//$mnu = MenusExamesDetalhesImagem();
				$mnu = Menus::MenusExamesDetalhesImagem();
				$caminho = Caminhos::MontaCaminhoExamesDetalhesImagem();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "atualizaexame":
			case "atualizaexamedoc":
				$tpl = file_get_contents("tpl/casos-exames-iframe-atualizacao.html");
				$tpl = str_replace("<!-- complemento -->",(($tela == "atualizaexamedoc") ? "?type=doc" : ""),$tpl);
				TrataDadosExamesDetalhesAtualizacao();
				//$mnu = MenusExamesDetalhesAtualizacao();
				$mnu = Menus::MenusExamesDetalhesAtualizacao();
				$caminho = Caminhos::MontaCaminhoExamesDetalhesAtualizacao();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "conteudos":
				$tpl = file_get_contents("tpl/casos-conteudos.html");
				if ($_POST['dlg'] == 1)
				{
					$xml = TrataDadosConteudosDlg();
				}
				else
				{
					if ($_POST['img'])
					{
						$tpl = file_get_contents("tpl/casos-conteudos-imagem.html");
					}
					else
					{
						$tpl = TrataDadosConteudos($tpl);
						$mnu = Menus::MenusConteudos();
						$caminho = Caminhos::MontaCaminhoConteudos();
						$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
					}
				}
				break;
			case "exercicios":
				$tpl = file_get_contents("tpl/casos-exercicios.html");
				$tpl = TrataDadosExercicios($tpl);
				$mnu = Menus::MenusExercicios();
				$caminho = Caminhos::MontaCaminhoExercicios();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
			case "montagem":
				$tpl = file_get_contents("tpl/casos-montagem.html");
				$tpl = TrataDadosMontagem($tpl);
				$mnu = Menus::MenusMontagem();
				$caminho = Caminhos::MontaCaminhoMontagem();
				$xml = "<conteudo>" . $tpl . "</conteudo><menu>" . $mnu . "</menu><caminho>" . $caminho . "</caminho>";
				break;
		}

		$xml .= (($_POST['localUpdate'] != "") ? "<localUpdate>" . $_POST['localUpdate'] . "</localUpdate>" : "");
		
		// prevent browser from caching
		//header('pragma: no-cache');
		//header('expires: 0'); // i.e. contents have already expired
		
		echo( Comuns::Idioma($xml) );
	}
	else
	{
		throw new Exception(Comuns::Idioma("@lng[Erro ao carregar tela do sistema]"), 1001);
	}
}

// Basicos -------------------------------------------------
function TrataDadosBasicos($template)
{
	header('Content-Type: text/html; charset=iso-8859-1');

	if (isset($_SESSION['caso']) && ($_SESSION['caso'] != 0))
	{
		$c = new Caso();
		$c->setCodigo($_SESSION['caso']);
		$c->CarregarCaso();

		$selAreas = AreaConhecimento::MontaSelect($c->getArea()->getCodigo());
		$selNiveis = NivelPergunta::MontaSelect($c->getNivelDificuldade()->getCodigo());

		$template = str_replace("<!--txtnome-->", $c->getNome(), $template);
		$template = str_replace("<!--txtdescricao-->", $c->getDescricao(), $template);
		$template = str_replace("<!--opcoesarea-->", $selAreas, $template);
		$template = str_replace("<!--opcoesnivel-->", $selNiveis, $template);
		$template = str_replace("<!--opcoesativo-->", SimNao::SelectSimNao($c->getAtivo()), $template);
		$template = str_replace("<!--txtidade-->", $c->getIdadePac(), $template);
		$template = str_replace("<!--opcoessexo-->", Sexo::SelectSexo($c->getSexoPac()), $template);
		$template = str_replace("<!--txtidpaciente-->", $c->getIdPac(), $template);
		$template = str_replace("<!--opcoesetnia-->", Etnia::SelectEtnia($c->getEtnia()), $template);
		$template = str_replace("<!--txtNomePac-->", $c->getNomePaciente(), $template);
		$template = str_replace("<!--opcoesimagem-->", ImgPaciente::SelectImagem($c->getImagemPaciente()), $template);
		$template = str_replace("<!--txtcid10-->", $c->getCid10(), $template);
		$template = str_replace("<!--chkPublico-->", (($c->getPublico() == "1") ? "checked=\"checked\"" : ""), $template);
		$template = str_replace("<!--chkExigeLogin-->", (($c->getExigeLogin() == "0") ? "checked=\"checked\"" : ""), $template);
	}
	else
	{
		$template = str_replace("<!--txtnome-->", "", $template);
		$template = str_replace("<!--txtdescricao-->", "", $template);
		$template = str_replace("<!--opcoesarea-->", AreaConhecimento::MontaSelect(), $template);
		$template = str_replace("<!--opcoesnivel-->", NivelPergunta::MontaSelect(), $template);
		$template = str_replace("<!--opcoesativo-->", SimNao::SelectSimNao(), $template);
		$template = str_replace("<!--txtidade-->", "", $template);
		$template = str_replace("<!--opcoessexo-->", Sexo::SelectSexo(), $template);
		$template = str_replace("<!--txtidpaciente-->", "", $template);
		$template = str_replace("<!--opcoesetnia-->", Etnia::SelectEtnia(), $template);
		$template = str_replace("<!--txtNomePac-->", "", $template);
		$template = str_replace("<!--opcoesimagem-->", ImgPaciente::SelectImagem(), $template);
		$template = str_replace("<!--txtcid10-->", "", $template);
		$template = str_replace("<!--chkPublico-->", "", $template);
		$template = str_replace("<!--chkExigeLogin-->", "", $template);
	}

	return $template;
}

function TrataDadosColaborador($template)
{
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

	$template = str_replace("##OptsGrupos##", $opts, $template);
	$template = str_replace("##OptsTU##", "", $template);
	$template = str_replace("##OptsUDG##", "", $template);
	
	return $template;
}

function TratarDadosConfiguracoes($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso'] != 0))
	{
		$c = new Caso();
		$c->setCodigo($_SESSION['caso']);
		$c->CarregarCaso();
		
		$template = str_replace("<!--opcoesfeed-->", SimNao::SelectSimNao($c->getFeedback()), $template);
		$template = str_replace("<!--hipoteses_TipoResp-->", TipoResposta::SelectTipoResposta((is_null($c->getConfiguracoes("hipoteses_TipoResp")) ? "SEL" : $c->getConfiguracoes("hipoteses_TipoResp"))), $template);
		$template = str_replace("<!--exames_TipoResp-->", TipoResposta::SelectTipoResposta((is_null($c->getConfiguracoes("exames_TipoResp")) ? "SEL" : $c->getConfiguracoes("exames_TipoResp"))), $template);
		$template = str_replace("<!--diagnosticos_TipoResp-->", TipoResposta::SelectTipoResposta((is_null($c->getConfiguracoes("diagnosticos_TipoResp")) ? "SEL" : $c->getConfiguracoes("diagnosticos_TipoResp"))), $template);
		$template = str_replace("<!--tratamentos_TipoResp-->", TipoResposta::SelectTipoResposta((is_null($c->getConfiguracoes("tratamentos_TipoResp")) ? "SEL" : $c->getConfiguracoes("tratamentos_TipoResp"))), $template);
	}
	else
	{
		$template = str_replace("<!--opcoesfeed-->", SimNao::SelectSimNao(0), $template);
		$template = str_replace("<!--hipoteses_TipoResp-->", TipoResposta::SelectTipoResposta("SEL"), $template);
		$template = str_replace("<!--exames_TipoResp-->", TipoResposta::SelectTipoResposta("SEL"), $template);
		$template = str_replace("<!--diagnosticos_TipoResp-->", TipoResposta::SelectTipoResposta("SEL"), $template);
		$template = str_replace("<!--tratamentos_TipoResp-->", TipoResposta::SelectTipoResposta("SEL"), $template);
	}
	
	return $template;
}

// Objetivos -----------------------------------------------
function TrataDadosObjetivos($template)
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$ob = new Objetivo();
		$ob->setCodcaso($_SESSION['caso']);
		
		$template = str_replace("<!--tabobjetivos-->", $ob->Lista(), $template);
		
	}
	else
	{
		$template = "@lng[Erro ao localilzar o caso de estudo]";
	}
	return $template;
}

function TrataDadosObjetivosDlg()
{
	$h = new HashTable();
	
	if ((isset($_SESSION['caso'])) && (($_SESSION['caso']) != 0))
	{
		$o = new Objetivo();
		
		if ($_POST['r'] != "")
		{
			$codobj = base64_decode($_POST['r']);
			$_SESSION['objetivo'] = $codobj;
			
			$o->setCodcaso($_SESSION['caso']);
			$o->setCoditem($codobj);
			$obj = $o->Carrega();
			
			$h->AddItem("txtDescricao", $obj->getDescricao());
		}
		else
		{
			$h->AddItem("txtDescricao", "");
		}
		return $h->ToXML();
	}
	else
	{
		return "@lng[Erro ao localilzar o caso de estudo]";
	}
}

// Anamnese ------------------------------------------------
function TrataDadosAnamnese($template)
{
	header('Content-Type: text/html; charset=iso-8859-1');

	if (isset($_SESSION['caso']) && ($_SESSION['caso'] != 0))
	{
		$a = new Anamnese();
		$a->Carrega($_SESSION['caso']);

		$template = str_replace("<!--txtid-->", $a->getIdentificacao(), $template);
		$template = str_replace("<!--txtqp-->", $a->getQueixapri(), $template);
		$template = str_replace("<!--txthda-->", $a->getHistatual(), $template);
		$template = str_replace("<!--txthmp-->", $a->getHistpregressa(), $template);
		$template = str_replace("<!--txthf-->", $a->getHistfamiliar(), $template);
		$template = str_replace("<!--txtpps-->", $a->getPerfilpsicosocial(), $template);
		$template = str_replace("<!--txtrs-->", $a->getRevsistemas(), $template);
		$template = str_replace("<!--optionsURL-->", $a->ListaConteudos(), $template);
		//$template = str_replace("<!--txtef-->", $a->getExamefisico(), $template);
	}
	else
	{
		$template = str_replace("<!--txtid-->", "", $template);
		$template = str_replace("<!--txtqp-->", "", $template);
		$template = str_replace("<!--txthda-->", "", $template);
		$template = str_replace("<!--txthmp-->", "", $template);
		$template = str_replace("<!--txthf-->", "", $template);
		$template = str_replace("<!--txtpps-->", "", $template);
		$template = str_replace("<!--txtrs-->", "", $template);
		//$template = str_replace("<!--txtef-->", "", $template);
	}

	return $template;
}

function TratarDadosExameFisico($template)
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$ef = new ExameFisico();
		$mid = new Midia();
		
		$ef->Carrega($_SESSION['caso']);
		
		$template = str_replace("<!--txtExaFisCabeca-->", $ef->getCabeca(), $template);
		$template = str_replace("<!--txtExaFisPescoco-->", $ef->getPescoco(), $template);
		$template = str_replace("<!--txtExaFisAusPulmonar-->", $ef->getAuscultapulmonar(), $template);
		$template = str_replace("<!--txtExaFisAusCardiaca-->", $ef->getAuscultacardiaca(), $template);
		$template = str_replace("<!--txtExaFisSinVit-->", $ef->getSinaisvitais(), $template);
		$template = str_replace("<!--txtExaFisAbdomen-->", $ef->getAbdomen(), $template);
		$template = str_replace("<!--txtExaFisPele-->", $ef->getPele(), $template);
		$template = str_replace("<!--txtExaFisExtrem-->", $ef->getExtremidades(), $template);
		$template = str_replace("<!--txtExaFisGeral-->", $ef->getEstadoGeral(), $template);
		$template = str_replace("<!--midCabeca-->", $ef->getMidiasCabeca(), $template);
		$template = str_replace("<!--midPescoco-->", $ef->getMidiasPescoco(), $template);
		$template = str_replace("<!--midAusPulmonar-->", $ef->getMidiasAuscultaPulmonar(), $template);
		$template = str_replace("<!--midAusCardiaca-->", $ef->getMidiasAuscultaCardiaca(), $template);
		$template = str_replace("<!--midAbdomen-->", $ef->getMidiasAbdomen(), $template);
		$template = str_replace("<!--midExtrem-->", $ef->getMidiasExtremidades(), $template);
		$template = str_replace("<!--midPele-->", $ef->getMidiasPele(), $template);
		$template = str_replace("<!--midSinVit-->", $ef->getMidiasSinaisVitais(), $template);
		$template = str_replace("<!--midGeral-->", $ef->getMidiasEstadoGeral(), $template);
		
		$mid->setCodCaso($_SESSION['caso']);
		$lista_midias = $mid->ListaRecordSet();
		
		if ($lista_midias)
		{
			$tabmidias = Comuns::TopoTabelaListagem("", "tabMidias", array('&nbsp;', 'Mídia', 'Tipo'));
			
			foreach ($lista_midias as $midia)
			{
				$tabmidias .= '<tr>';
				$tabmidias .= '<td><input type="checkbox" name="chkMidia[]" id="chkMidia_' . $midia->CodMidia . '" value="' . $midia->CodMidia . '" class="chkmidias"></td>';
				$tabmidias .= '<td>' . $midia->Descricao . '</td>';
				$tabmidias .= '<td>' . ($midia->CodTipo == 1 ? Comuns::IMG_MIDIA_IMAGEM : ($midia->CodTipo == 2 ? Comuns::IMG_MIDIA_VIDEO : Comuns::IMG_MIDIA_AUDIO)) . '</td>';
				$tabmidias .= '</tr>';
			}
			
			$tabmidias .= '</body></table>';
			
			$template = str_replace("<!--midias-->", $tabmidias, $template);
		}
		else
		{
			$template = str_replace("<!--midias-->", $mid->getErro(), $template);
		}
	}
	else
	{
		$template = str_replace("<!--txtExaFisCabeca-->", "", $template);
		$template = str_replace("<!--txtExaFisPescoco-->", "", $template);
		$template = str_replace("<!--txtExaFisAusPulmonar-->", "", $template);
		$template = str_replace("<!--txtExaFisAusCardiaca-->", "", $template);
		$template = str_replace("<!--txtExaFisSinVit-->", "", $template);
		$template = str_replace("<!--txtExaFisAbdomen-->", "", $template);
		$template = str_replace("<!--txtExaFisPele-->", "", $template);
		$template = str_replace("<!--txtExaFisExtrem-->", "", $template);
		$template = str_replace("<!--txtExaFisGeral-->", "", $template);
		$template = str_replace("<!--midCabeca-->", "0", $template);
		$template = str_replace("<!--midPescoco-->", "0", $template);
		$template = str_replace("<!--midAusPulmonar-->", "0", $template);
		$template = str_replace("<!--midAusCardiaca-->", "0", $template);
		$template = str_replace("<!--midAbdomen-->", "0", $template);
		$template = str_replace("<!--midExtrem-->", "0", $template);
		$template = str_replace("<!--midPele-->", "0", $template);
		$template = str_replace("<!--midSinVit-->", "0", $template);
		$template = str_replace("<!--midGeral-->", "0", $template);
	}
	
	return $template;
}

function TrataDadosHipoteses($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$h = new Hipoteses();
		$template = str_replace("<!--tabhipoteses-->", $h->ListaHipotesesCaso($_SESSION['caso']), $template);
		$template = str_replace("<!--perguntanorteadora-->", $h->CarregaPerguntaNorteadora($_SESSION['caso']), $template);
	}
	else
	{
		$template = "@lng[Erro ao localizar o caso de estudo]";
	}
	return $template;
}

function TrataDadosHipotesesDlg()
{
	$dados = new HashTable();
	
	if ((isset($_SESSION['caso'])) && (($_SESSION['caso']) != 0))
	{
		$h = new Hipoteses();
		$tiporesp = Caso::BuscaConfiguracao($_SESSION['caso'], "hipoteses", "TipoResp");
		
		if ($_POST['r'] != "")
		{
			$codhipotese = base64_decode($_POST['r']);
			$_SESSION['hipotese'] = $codhipotese;
			
			$h->Carrega($_SESSION['caso'], $codhipotese);
			
			$dados->AddItem("txtDescricao", $h->getDescricao());
			$dados->AddItem("txtJustificativa", $h->getJustificativa());
			$dados->AddItem("txtAdicional", $h->getConteudoadicional());
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao($h->getCorreto()));
			}
			else if ($tiporesp == "ORD")
			{
				$n = $h->getNHipoteses();
				$opcoes = SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]", $h->getCorreto());
				$dados->AddItem("selCorreto", $opcoes);
			}
		}
		else
		{
			$_SESSION['hipotese'] = 0;
			$dados->AddItem("txtDescricao", "");
			$dados->AddItem("txtJustificativa", "");
			$dados->AddItem("txtAdicional", "");
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao());
			}
			else if ($tiporesp == "ORD")
			{
				$h->setCodcaso($_SESSION['caso']);
				$n = $h->getNHipoteses()+1;
				$dados->AddItem("selCorreto", SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]"));
			}
		}
		return $dados->ToXML();
	}
	else
	{
		return "@lng[Erro ao localilzar o caso de estudo]";
	}
}

// Exames --------------------------------------------------
function TrataDadosExames($template)
{
	if ($_REQUEST['k'] == 'E6117D81D00D25AA591D46468847915F')
	{
		$_SESSION['caso'] = base64_decode(urldecode($_REQUEST['m']));
	}
	
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$e = new Exame();
		$_SESSION['exame'] = 0;
		
		$template = str_replace("<!--tabexames-->", $e->ListaExamesCaso($_SESSION['caso']), $template);
		$template = str_replace("<!--perguntanorteadora-->", $e->CarregaPerguntaNorteadora($_SESSION['caso']), $template);
	}
	else
	{
		$template = "@lng[Erro ao localizar o caso de estudo. Caso] = " . $_REQUEST["k"];
	}

	return $template;
}

function TratarDadosExamesDlg()
{
	$dados = new HashTable();
	
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$e = new Exame();
		$tiporesp = Caso::BuscaConfiguracao($_SESSION['caso'], "exames", "TipoResp");
		
		if ($_POST['r'] != "")
		{
			$codexame = base64_decode($_POST['r']);
			$_SESSION['exame'] = $codexame;
			
			$e->Carrega($_SESSION['caso'], $codexame);
			
			$dados->AddItem("txtDescricao", $e->getDescricao());
			$dados->AddItem("selTipoExame", TipoExame::RetornaSelect($e->getTipo()));
			$dados->AddItem("txtBateria", $e->getBateria());
			$dados->AddItem("txtJustificativa", $e->getJustificativa());
			$dados->AddItem("txtAdicional", $e->getConteudoadicional());
			$dados->AddItem("divRelacoes", $e->ListaRelacoesExame($_SESSION['caso'], $codexame));
			$dados->AddItem("selMostraQuando", MostraQuando::SelectMostraQuando($e->getMostraQuando()));
			$dados->AddItem("chkMostraIsolado", (($e->getMostrarAgrupado() == 0) ? "1" : "0"));
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao($e->getCorreto()));
			}
			else if ($tiporesp == "ORD")
			{
				$n = $e->getNExames();
				$opcoes = SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]", $e->getCorreto());
				$dados->AddItem("selCorreto", $opcoes);
			}
		}
		else
		{
			$_SESSION['exame'] = 0;
			
			$dados->AddItem("txtDescricao", "");
			$dados->AddItem("selTipoExame", TipoExame::RetornaSelect());
			$dados->AddItem("txtBateria", "1");
			$dados->AddItem("txtJustificativa", "");
			$dados->AddItem("txtAdicional", "");
			$dados->AddItem("divRelacoes", $e->ListaRelacoesExame($_SESSION['caso'], 0));
			$dados->AddItem("selMostraQuando", MostraQuando::SelectMostraQuando());
			$dados->AddItem("chkMostraIsolado", "0");
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao());
			}
			else
			{
				$e->setCodcaso($_SESSION['caso']);
				$n = $e->getNExames()+1;
				$dados->AddItem("selCorreto", SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]"));
			}
		}
		return $dados->ToXML();
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

function TrataDadosExamesDetalhes($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso'] != 0))
	{
		$codexame = base64_decode($_POST['r']);
		$_SESSION['exame'] = $codexame;
		$e = new Exame();
		$t = new TipoExame();
		
		$e->Carrega($_SESSION['caso'], $codexame);
		$t->Carrega($e->getTipo());
		
		if ($t->getPodeImgs())
		{
			$listaimgs  = '<h4>@lng[Imagens anexadas ao exame] <span class="nomeexame">"' . $e->getDescricao() . '"</span></h4>';
			$listaimgs .= '<div id="lista-imgs">';
			$listaimgs .= $e->ListaArquivosExame($_SESSION['caso'], $codexame, "img");
			$listaimgs .= '</div>';
			
			$template = str_replace("<!--listaimagens-->", $listaimgs, $template);
		}
		else
		{
			$template = str_replace("<!--listaimagens-->", "", $template);
		}
		
		if ($t->getPodeDocs())
		{
			$listadocs  = '<h4>@lng[Documentos anexados ao exame] <span class="nomeexame">"' . $e->getDescricao() . '"</span></h4>';
			$listadocs .= '<div id="lista-docs">';
			$listadocs .= $e->ListaArquivosExame($_SESSION['caso'], $codexame, "doc");
			$listadocs .= '</div>';
			
			$template = str_replace("<!--listadocs-->", $listadocs, $template);
		}
		else
		{
			$template = str_replace("<!--listadocs-->", "", $template);
		}
		
		if ($t->getPodeVals())
		{
			$listavalref  = '<div id="divLancaValores">';
			$listavalref .= $e->ListaValoresReferencia($_SESSION['caso'], $codexame);
			$listavalref .= '</div>';
			
			$template = str_replace("<!--lancavaloresrefexame-->", $listavalref, $template);
		}
		else
		{
			$template = str_replace("<!--lancavaloresrefexame-->", "", $template);
		}
		
		$template = str_replace("<!--laudo-->", ((is_null($e->getLaudo())) ? "" : $e->getLaudo()), $template);
		return $template;
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

function TrataDadosExamesDetalhesImagem($template)
{
	if ($_POST['r'] != "")
	{
		$imagem = '<img src="viewimagem.php?img=' . $_POST['r'] . '" />';
		$template = str_replace("<!--caminhoimagem-->", $imagem, $template);
		return $template;
	}
	else
	{
		return "@lng[Erro ao carregar imagem]";
	}
}

function TrataDadosExamesDetalhesAtualizacao()
{
	$msg = "";
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		if ((isset($_SESSION['exame'])) && ($_SESSION['exame'] > 0))
		{
			if ($_POST['r'] != "")
			{
				// Instancia para uma seção o código do item que está sendo carregado
				// para ser recuperado no arquivo do iframe.
				$_SESSION['itemexame'] = base64_decode($_POST['r']);
			}
			else
			{
				$msg = "@lng[Erro ao carregar detalhes do item do exame]";
			} 
		}
		else
		{
			$msg = "@lng[Erro ao localizar o exame]";
		}
	}
	else
	{
		$msg = "@lng[Erro ao localizar o caso de estudo]";
	}
	return $msg;
}

// Diagnósticos --------------------------------------------
function TrataDadosDiagnosticos($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$d = new Diagnostico();
		$template = str_replace("<!--tabdiagnosticos-->", $d->Lista($_SESSION['caso']), $template);
		$template = str_replace("<!--perguntanorteadora-->", $d->CarregaPerguntaNorteadora($_SESSION['caso']), $template);
	}
	else
	{
		$template = "@lng[Erro ao localizar o caso de estudo]";
	}

	return $template;
}

function TrataDadosDiagnosticosDlg()
{
	$dados = new HashTable();
	
	if ((isset($_SESSION['caso'])) && (($_SESSION['caso']) != 0))
	{
		$d = new Diagnostico();
		$tiporesp = Caso::BuscaConfiguracao($_SESSION['caso'], "diagnosticos", "TipoResp");
		if ($_POST['r'] != "")
		{
			$coddiagnostico = base64_decode($_POST['r']);
			$_SESSION['diagnostico'] = $coddiagnostico;
			
			$d->Carrega($_SESSION['caso'], $coddiagnostico);
			
			$dados->AddItem("txtDescricao", $d->getDescricao());
			$dados->AddItem("txtJustificativa", $d->getJustificativa());
			$dados->AddItem("txtAdicional", $d->getConteudoadicional());
			$dados->AddItem("divRelacoes", $d->ListaRelacoesDiagnostico($_SESSION['caso'], $coddiagnostico));
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao($d->getCorreto()));
			}
			else
			{
				$n = $d->getNDiagnosticos();
				$opcoes = SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]", $d->getCorreto());
				$dados->AddItem("selCorreto", $opcoes);
			}
		}
		else
		{
			$_SESSION['diagnostico'] = 0;
			$dados->AddItem("txtDescricao", "");
			$dados->AddItem("txtJustificativa", "");
			$dados->AddItem("txtAdicional", "");
			$dados->AddItem("divRelacoes", $d->ListaRelacoesDiagnostico($_SESSION['caso'], 0));
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao());
			}
			else
			{
				$d->setCodcaso($_SESSION['caso']);
				$n = $d->getNDiagnosticos()+1;
				$dados->AddItem("selCorreto", SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]"));
			}
		}
		return $dados->ToXML();
	}
	else
	{
		return "@lng[Erro ao localilzar o caso de estudo]";
	}
}

// Tratamentos ---------------------------------------------
function TrataDadosTratamentos($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$t = new Tratamento();
		$_SESSION['tratamento'] = 0;
		
		$template = str_replace("<!--tabtratamentos-->", $t->Lista($_SESSION['caso']), $template);
		$template = str_replace("<!--perguntanorteadora-->", $t->CarregaPerguntaNorteadora($_SESSION['caso']), $template);
	}
	else
	{
		$template = "@lng[Erro ao localizar o caso de estudo]";
	}

	return $template;
}

function TratarDadosTratamentosDlg()
{
	$dados = new HashTable();
	
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$t = new Tratamento();
		$tiporesp = Caso::BuscaConfiguracao($_SESSION['caso'], "diagnosticos", "TipoResp");
		
		if ($_POST['r'] != "")
		{
			$codtratamento = base64_decode($_POST['r']);
			$_SESSION['tratamento'] = $codtratamento;
			
			$t->Carrega($_SESSION['caso'], $codtratamento);
			
			$dados->AddItem("txtTitulo", $t->getTitulo());
			$dados->AddItem("txtDescricao", $t->getDescricao());
			$dados->AddItem("txtJustificativa", $t->getJustificativa());
			$dados->AddItem("txtAdicional", $t->getConteudoadicional());
			$dados->AddItem("divRelacoes", $t->ListaRelacoesTratamento($_SESSION['caso'], $codtratamento));
			
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao($t->getCorreto()));
			}
			else
			{
				$n = $t->getNTratamentos();
				$opcoes = SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]", $t->getCorreto());
				$dados->AddItem("selCorreto", $opcoes);
			}
		}
		else
		{
			$_SESSION['tratamento'] = 0;
			
			$dados->AddItem("txtTitulo", "");
			$dados->AddItem("txtDescricao", "");
			$dados->AddItem("txtJustificativa", "");
			$dados->AddItem("txtAdicional", "");
			$dados->AddItem("divRelacoes", $t->ListaRelacoesTratamento($_SESSION['caso'], 0));
			
			if ($tiporesp == "CE")
			{
				$dados->AddItem("selCorreto", SimNao::SelectSimNao());
			}
			else
			{
				$t->setCodcaso($_SESSION['caso']);
				$n = $t->getNTratamentos()+1;
				$dados->AddItem("selCorreto", SelectNumerico::MontaSelect($n, 1, "@lng[Selecione]"));
			}
		}
		return $dados->ToXML();
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

// Desfechos -----------------------------------------------
function TrataDadosDesfechos($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$d = new Desfecho();
		$_SESSION['desfecho'] = 0;
		
		$template = str_replace("<!--tabdesfechos-->", $d->Lista($_SESSION['caso']), $template);
		$template = str_replace("<!--perguntanorteadora-->", $d->CarregaPerguntaNorteadora($_SESSION['caso']), $template);
	}
	else
	{
		$template = "@lng[Erro ao localizar o caso de estudo]";
	}

	return $template;
}

function TratarDadosDesfechosDlg()
{
	$dados = new HashTable();
	
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$d = new Desfecho();
		if ($_POST['r'] != "")
		{
			$coddesfecho = base64_decode($_POST['r']);
			$_SESSION['desfecho'] = $coddesfecho;
			
			$d->Carrega($_SESSION['caso'], $coddesfecho);
			
			$dados->AddItem("txtTitulo", $d->getTitulo());
			$dados->AddItem("txtDesfecho", $d->getDesfecho());
			$dados->AddItem("divRelacoes", $d->ListaRelacoesDesfecho($_SESSION['caso'], $coddesfecho));
		}
		else
		{
			$_SESSION['desfecho'] = 0;
			
			$dados->AddItem("txtTitulo", "");
			$dados->AddItem("txtDesfecho", "");
			$dados->AddItem("divRelacoes", $d->ListaRelacoesDesfecho($_SESSION['caso'], 0));
		}
		return $dados->ToXML();
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

function TrataDadosConteudos($template)
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$c = new Conteudo();
		$_SESSION['conteudo'] = 0;
		
		$template = str_replace("<!--tabconteudos-->", $c->Lista($_SESSION['caso']), $template);
	}
	else
	{
		$template = "@lng[Erro ao localizar o caso de estudo]";
	}

	return $template;
}

function TrataDadosConteudosDlg()
{
	$dados = new HashTable();
	
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$c = new Conteudo();
		if ($_POST['r'] != "")
		{
			$codconteudo = base64_decode($_POST['r']);
			$_SESSION['conteudo'] = $codconteudo;
			
			$c->Carrega($_SESSION['caso'], $codconteudo);
			
			$dados->AddItem("txtTexto", $c->getTexto());
			$dados->AddItem("txtDescricao", $c->getDescricao());
		}
		else
		{
			$_SESSION['conteudo'] = 0;
			
			$dados->AddItem("txtTexto", "");
			$dados->AddItem("txtDescricao", "");
		}
		return $dados->ToXML();
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

function TrataDadosExercicios($template)
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$p = new Pergunta();
		$gp = new GrupoPergunta();
		$u = unserialize($_SESSION['usu']);
		
		// Perguntas
		$perguntas = $p->ListaPerguntasAtivas(null, null, "", 0, $u->getCodigo());
		
		if (count($perguntas) > 0)
		{
			$retorno = "<h4>@lng[Marque abaixo quais perguntas cadastradas no sistema você deseja vincular a este caso de estudos]</h4>";
			$cont = 0;
			
			$pergcaso = Caso::RetornaArrayExercicios($_SESSION['caso']);
			
			foreach ($perguntas as $perg)
			{
				$cont++;
				if ((! is_null($pergcaso)) && (in_array($perg->Codigo, $pergcaso)))
				{
					$retorno .= '<input type="checkbox" name="chkRelPergCaso[]" id="chkRelPergCaso_' . $cont . '" value="' . base64_encode($perg->Codigo) . '" class="campo" checked="checked" />' . $perg->Texto . '<br />';
				}
				else
				{
					$retorno .= '<input type="checkbox" name="chkRelPergCaso[]" id="chkRelPergCaso_' . $cont . '" value="' . base64_encode($perg->Codigo) . '" class="campo" />' . $perg->Texto . '<br />';
				}
			}
		}
		else
		{
			$debug .= "perguntas <= 0\r\n";
			$retorno = "@lng[Nenhum pergunta cadastrada no sistema]";
		}
		
		
		// Agrupamentos de perguntas
		$agrupamentos = $gp->ListaRecordSet();
		
		if (count($agrupamentos) > 0)
		{
			$retorno .= '<h4>@lng[Marque abaixo quais agrupamentos de perguntas você deseja vincular ao caso. As perguntas dos agrupamentos não precisam ser marcadas na lista acima]</h4>';
			$cont = 0;
			
			$agrupscaso = Caso::RetornaArrayAgrupadores($_SESSION['caso']);
			
			foreach ($agrupamentos as $agrup)
			{
				$cont++;
				if ((! is_null($agrupscaso)) && (in_array($agrup->Codigo, $agrupscaso)))
				{
					$retorno .= '<input type="checkbox" name="chkRelAgrupCaso[]" id="chkRelAgrupCaso_' . $cont . '" value="' . base64_encode($agrup->Codigo) . '" class="campo" checked="checked" />' . $agrup->Texto . '<br />';
				}
				else
				{
					$retorno .= '<input type="checkbox" name="chkRelAgrupCaso[]" id="chkRelAgrupCaso_' . $cont . '" value="' . base64_encode($agrup->Codigo) . '" class="campo" />' . $agrup->Texto . '<br />';
				}
			}
		}

		$template = str_replace("<!--listaexercicios-->", $retorno, $template);
		return $template;
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

function TrataDadosMontagem($template)
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$cas = new Caso();
		$itens = $cas->CarregaMontagem($_SESSION['caso']);
		
		if ($itens != false)
		{
			foreach ($itens as $item)
			{
				//$html .= '<li class="ui-state-default' . (($item->Fixo == 1) ? ' fixo' : '') . '" id="' . $item->Prefixo . $item->Chave . '">' . $item->Item . (($item->Fixo == 1) ? ' (Fixo)' : '') . '</li>';
				$html .= '<li class="conteudo-caso '. (($item->Fixo == 1) ? 'ui-state-default' : 'ui-state-hover') . ' " id="' . $item->Prefixo . $item->Chave . '" title="' . strip_tags($item->Item) . '">' . strip_tags(substr($item->Item, 0, 90)) . '</li>';
			}
			$template = str_replace("<!--montagemcaso-->", $html, $template);
			return $template;
		}
		else
		{
			return $cas->getErro();
		}
	}
	else
	{
		return "@lng[Erro ao localizar o caso de estudo]";
	}
}

Main();
?>