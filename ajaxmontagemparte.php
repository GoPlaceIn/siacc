<?php

//--utf8_encode --
session_start();
include_once('cls/hipoteses.class.php');
include_once('cls/exame.class.php');
include_once('cls/diagnostico.class.php');
include_once('cls/tratamento.class.php');
include_once('cls/desfecho.class.php');
include_once('cls/conteudo.class.php');
include_once('cls/pergunta.class.php');
include_once('cls/grupopergunta.class.php');
include_once('cls/midia.class.php');
include_once('cls/simnao.class.php');
include_once('inc/comuns.inc.php');

function fntRetornaHipoteses()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$hipoteses = new Hipoteses();
		$lista = $hipoteses->ListaRecordSet($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabHipoteses", array('&nbsp;', 'Hipótese diagnóstica', 'Correto'));
			
			foreach ($lista as $hip)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_hip_' . $hip->CodHipotese . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_hip_' . $hip->CodHipotese . '">' . $hip->Descricao . '</span></td>';
				$html .= '<td>' . SimNao::Descreve($hip->Correto) . '</td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhuma hipótese diagnóstica cadastrada]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaExames($tipo)
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$exames = new Exame();
		$lista = $exames->ListaRecordSet($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabExames", array('&nbsp;', 'Exame', 'Correto'));
			
			foreach ($lista as $exa)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_' . $tipo . '_' . $exa->CodExame . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_' . $tipo . '_' . $exa->CodExame . '">' . $exa->Descricao . '</span></td>';
				$html .= '<td>' . SimNao::Descreve($exa->Correto) . '</td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum exame cadastrado]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaDiagnosticos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$diagnosticos = new Diagnostico();
		$lista = $diagnosticos->ListaRecordSet($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabDiagnosticos", array('&nbsp', 'Diagnósticos', 'Correto'));
			
			foreach ($lista as $diag)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_diag_' . $diag->CodDiagnostico . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_diag_' . $diag->CodDiagnostico . '">' . $diag->Descricao . '</span></td>';
				$html .= '<td>' . SimNao::Descreve($diag->Correto) . '</td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum diagnóstico cadastrada]";
		}
	}
	else
	{
		return "Caso não encontrado";
	}
}

function fntRetornaTratamentos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$tratamentos = new Tratamento();
		$lista = $tratamentos->ListaRecordSet($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabTratamentos", array('&nbsp;', 'Tratamento', 'Correto'));
			
			foreach ($lista as $trat)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_trat_' . $trat->CodTratamento . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_trat_' . $trat->CodTratamento . '">' . $trat->Titulo . '</span></td>';
				$html .= '<td>' . SimNao::Descreve($trat->Correto) . '</td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum tratamento cadastrado]";
		}
	}
	else
	{
		return "Caso não encontrado";
	}
}

function fntRetornaDesfechos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$desfechos = new Desfecho();
		$lista = $desfechos->ListaRecordSet($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabDesfechos", array('&nbsp;', 'Desfecho'));
			
			foreach ($lista as $des)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_des_' . $des->CodDesfecho . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_des_' . $des->CodDesfecho . '">' . $des->Titulo . '</span></td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum desfecho cadastrado]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaHTMLs()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$con = new Conteudo();
		$lista = $con->ListaRecordSet($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabConteudos", array('&nbsp;', 'Conteúdo'));
			
			foreach ($lista as $cont)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_html_' . $cont->CodConteudo . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_html_' . $cont->CodConteudo . '">' . $cont->Descricao . '</span></td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum conteúdo cadastrado]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaImagens()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$mid = new Midia();
		$mid->setCodCaso($_SESSION['caso']);
		$lista = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_IMAGEM);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabImagens", array('&nbsp;', 'Imagem'));
			
			foreach ($lista as $img)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_img_' . $img->CodMidia . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_img_' . $img->CodMidia . '">' . $img->Descricao . '</span></td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhuma imagem cadastrada]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaVideos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$mid = new Midia();
		$mid->setCodCaso($_SESSION['caso']);
		$lista = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_VIDEO);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabVideos", array('&nbsp;', 'Vídeo'));
			
			foreach ($lista as $vid)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_vid_' . $vid->CodMidia . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_vid_' . $vid->CodMidia . '">' . $vid->Descricao . '</span></td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum vídeo cadastrada]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaAudios()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$mid = new Midia();
		$mid->setCodCaso($_SESSION['caso']);
		$lista = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_AUDIO);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabAudios", array('&nbsp;', 'Áudio'));
			
			foreach ($lista as $aud)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_aud_' . $aud->CodMidia . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_aud_' . $aud->CodMidia . '">' . $aud->Descricao . '</span></td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum áudio cadastrada]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaDocumentos()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$mid = new Midia();
		$mid->setCodCaso($_SESSION['caso']);
		$lista = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_DOCUMENTO);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabDocumentos", array('&nbsp;', 'Documento'));
			
			foreach ($lista as $doc)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_doc_' . $doc->CodMidia . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_doc_' . $doc->CodMidia . '">' . $doc->Descricao . '</span></td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum documento cadastrado]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaExercicios()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$per = new Pergunta();
		$lista = $per->ListaPerguntasCaso($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabExercicios", array('&nbsp;', 'Exercício', 'Classe', 'Núm. Alternativas'));
			
			foreach ($lista as $perg)
			{
				$html .= '<tr title="Tipo: ' . $perg->Tipo . '">';
				$html .= '<td><input type="checkbox" id="chk_perg_' . $perg->CodPergunta . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_perg_' . $perg->CodPergunta . '">' . $perg->Texto . '</span></td>';
				$html .= '<td>' . $perg->Classe . '</td>';
				$html .= '<td>' . $perg->Alternativas . '</td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lg[Nenhum exercício cadastrado ou nenhum exercício vinculado ao caso clínico]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function fntRetornaAgrupadoresDePerguntas()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$gp = new GrupoPergunta();
		$lista = $gp->ListaAgrupamentosCaso($_SESSION['caso']);
		
		if (($lista != false) && (count($lista) > 0))
		{
			$html = Comuns::TopoTabelaListagem("", "tabAgrupadores", array('&nbsp;', 'Agrupador', 'Núm. exercícios'));
			
			foreach ($lista as $gperg)
			{
				$html .= '<tr>';
				$html .= '<td><input type="checkbox" id="chk_grupo-perg_' . $gperg->CodAgrupamento . '" class="item_arvore"></td>';
				$html .= '<td><span id="spn_grupo-perg_' . $gperg->CodAgrupamento . '">' . $gperg->Texto . '</span></td>';
				$html .= '<td>' . $gperg->Perguntas . '</td>';
				$html .= '</tr>';
			}
			
			$html .= "</tbody></table>";
			
			return $html;
		}
		else
		{
			return "@lng[Nenhum agrupamento de exercícios cadastrado/vinculado ao caso clínico]";
		}
	}
	else
	{
		return "@lng[Caso não encontrado]";
	}
}

function Main()
{
	switch ($_POST['idnodo'])
	{
		case "hip":
			$retorno = fntRetornaHipoteses();
			break;
		case "optex":
		case "resex":
			$retorno = fntRetornaExames($_POST['idnodo']);
			break;
		case "diag":
			$retorno = fntRetornaDiagnosticos();
			break;
		case "trat":
			$retorno = fntRetornaTratamentos();
			break;
		case "des":
			$retorno = fntRetornaDesfechos();
			break;
		case "html":
			$retorno = fntRetornaHTMLs();
			break;
		case "img":
			$retorno = fntRetornaImagens();
			break;
		case "vid":
			$retorno = fntRetornaVideos();
			break;
		case "aud":
			$retorno = fntRetornaAudios();
			break;
		case "doc":
			$retorno = fntRetornaDocumentos();
			break;
		case "perg":
			$retorno = fntRetornaExercicios();
			break;
		case "grupo-perg":
			$retorno = fntRetornaAgrupadoresDePerguntas();
			break;
	}
	
	header('Content-Type: text/html; charset=iso-8859-1');
	echo(Comuns::Idioma($retorno));
}

Main();

?>