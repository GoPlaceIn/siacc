<?php
//--utf8_encode --
include_once 'cls/pergunta.class.php';
include_once 'cls/grupopergunta.class.php';
include_once 'cls/resolucao.class.php';
include_once 'cls/fechamento.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$arrInfos = split('_', $_POST['chave']);
	
	$fe = new Fechamento();
	$fe->setCodcaso($_SESSION['casores']);
	$contUnico = 1;
	
	if (($arrInfos[1] != 'perg') && ($arrInfos[1] != 'grupo-perg'))
	{
		$res = new Resolucao();
		$res->setCodcaso($_SESSION['casores']);
		
		$respostas = $res->BuscaRespostas($arrInfos[3]);
		$alternativas = $fe->RetornaConteudosDoItemDaMontagem($arrInfos[3], $arrInfos[1]);
		
		if ($alternativas)
		{
			$htmlInterativas .= '<div><strong>' . Montagem::RetornaDescricaoItem($_SESSION['casores'], 1, $arrInfos[3]) . '</strong></div>';
			$htmlInterativas .= '<div class="det-etapa-int">';
			$htmlInterativas .= '<table class="listadados">';
			$htmlInterativas .= '<tr class="head">';
			$htmlInterativas .= '<td class="td-col-alt">@lng[Alternativa]</td>';
			$htmlInterativas .= '<td class="td-col-correto">@lng[Gabarito]</td>';
			$htmlInterativas .= '<td class="td-col-escolha">@lng[Você marcou]</td>';
			$htmlInterativas .= '<td class="td-col-jus">&nbsp;</td>';
			$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
			$htmlInterativas .= '</tr>';
			
			$contAlt = 1;
			foreach ($alternativas as $alternativa)
			{
				$htmlInterativas .= '<tr class="norm">';
				$htmlInterativas .= '<td class="dado td-col-alt">' . $alternativa->Titulo . '</td>';
				$htmlInterativas .= '<td class="td-col-correto">' . ($alternativa->Correto == 1 ? Comuns::IMG_STATUS_CERTO : Comuns::IMG_STATUS_ERRADO) . '</td>';
				$htmlInterativas .= '<td class="td-col-escolha">' . (((intval($respostas) & intval($alternativa->ValorOpt)) > 0) ? Comuns::IMG_ITEM_PINO : '') . '</td>';
				$htmlInterativas .= '<td class="td-col-jus">' . trim((strip_tags(nl2br($alternativa->Justificativa))) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'j\', \'' . $contUnico . '\', \'' . $contAlt . '\');">@lng[Ver detalhes]</a>' : '') . '</td>';
				$htmlInterativas .= '<td class="td-col-compl">' . trim((strip_tags(nl2br($alternativa->ConteudoAdicional))) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'c\', \'' . $contUnico . '\', \'' . $contAlt . '\');">@lng[Ver complemento]</a>' : '') . '</td>';
				$htmlInterativas .= '</tr>';
				if (trim(strip_tags($alternativa->Justificativa)) != '')
				{
					$htmlInterativas .= '<tr style="display:none;" id="jus-' . $contUnico . '-' . $contAlt . '">';
					$htmlInterativas .= '<td colspan="5" class="apre-just"><div class="cont-just">' . $alternativa->Justificativa . '</div></td>';
					$htmlInterativas .= '</tr>';
				}
				if (trim(strip_tags($alternativa->ConteudoAdicional)) != '')
				{
					$htmlInterativas .= '<tr style="display:none;" id="contadi-' . $contUnico . '-' . $contAlt . '">';
					$htmlInterativas .= '<td colspan="5" class="apre-compl"><div class="cont-compl">' . $alternativa->ConteudoAdicional . '</div></td>';
					$htmlInterativas .= '</tr>';
				}
				$contAlt++;
				$contUnico++;
			}
			$htmlInterativas .= '</table>';
			$htmlInterativas .= '</div>';
		}
		else
		{
			die($fe->getErro() . ' Alternativas');
		}
		
		$htmlInterativas .= '<div class="espacador"></div>';
	}
	else if ($arrInfos[1] == 'perg')
	{
		$res = new Resolucao();
		$res->setCodcaso($_SESSION['casores']);
		
		$itens = $res->BuscaConteudosAgrupador($arrInfos[3]);
		if ($itens)
		{
			foreach ($itens as $p)
			{
				// Chave, TipoConteudo, ChavePai, Organizador, ContReferencia, ValorOpt, Ordem
				
				$perg = new Pergunta();
				$perg->Carregar($p->ContReferencia);
				
				if ((! is_null($perg->getTextoExplicacaoGeral())) && ($perg->getTextoExplicacaoGeral() != ''))
				{
					$boolExplicacao = true;
				}
				else
				{
					$boolExplicacao = false;
				}
				
				$htmlInterativas .= '<div>@lng[Etapa:] <strong>' . $perg->getTexto() . '</strong>' . ($boolExplicacao ? '<span style="float:right;"><a href="javascript:void(0);" onclick="javascript:fntMostraOculta(\'exp-' . $perg->getCodigo() . '\');"><img src="img/info.gif" alt="@lng[Mais informações]" title="@lng[Mais informações]" /></a></span>' : '') . '</div>';
				if ($boolExplicacao)
				{
					$htmlInterativas .= '<div class="explicacao-item" id="exp-' . $perg->getCodigo() . '" style="display:none;">' . $perg->getTextoExplicacaoGeral() . '</div>';
				}
				
				$respostas = $res->BuscaRespostas($arrInfos[3], $perg->getCodigo());
				$alternativas = $fe->RetornaAlternativasDaPergunta($perg->getCodigo());
				if ($alternativas)
				{
					$htmlInterativas .= '<div class="det-etapa-int">';
					$htmlInterativas .= '<table class="listadados">';
					$htmlInterativas .= '<tr class="head">';
					$htmlInterativas .= '<td class="td-col-alt">@lng[Alternativa]</td>';
					$htmlInterativas .= '<td class="td-col-correto">@lng[Gabarito]</td>';
					$htmlInterativas .= '<td class="td-col-escolha">@lng[Você marcou]</td>';
					$htmlInterativas .= '<td class="td-col-jus">&nbsp;</td>';
					$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
					$htmlInterativas .= '</tr>';
					
					$contAlt = 1;
					foreach ($alternativas as $alternativa)
					{
						$htmlInterativas .= '<tr class="norm">';
						$htmlInterativas .= '<td class="dado td-col-alt">' . $alternativa->Alternativa . '</td>';
						$htmlInterativas .= '<td class="td-col-correto">' . ($alternativa->Correto == 1 ? Comuns::IMG_STATUS_CERTO : Comuns::IMG_STATUS_ERRADO) . '</td>';
						$htmlInterativas .= '<td class="td-col-escolha">' . (((intval($respostas) & intval($alternativa->ValorOpt)) > 0) ? Comuns::IMG_ITEM_PINO : '') . '</td>';
						$htmlInterativas .= '<td class="td-col-jus">' . (((!is_null($alternativa->Explicacao)) && (strip_tags(trim(nl2br($alternativa->Explicacao))) != '')) ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'j\', \'' . $contUnico . '\', \'' . $contAlt . '\');">@lng[Ver detalhes]</a>' : '') . '</td>';
						$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
						$htmlInterativas .= '</tr>';
						if (trim(strip_tags($alternativa->Explicacao)) != '')
						{
							$htmlInterativas .= '<tr style="display:none;" id="jus-' . $contUnico . '-' . $contAlt . '">';
							$htmlInterativas .= '<td colspan="5" class="apre-just"><div class="cont-just">' . $alternativa->Explicacao . '</div></td>';
							$htmlInterativas .= '</tr>';
						}
						$contAlt++;
						$contUnico++;
					}
					$htmlInterativas .= '</table>';
					$htmlInterativas .= '</div>';
				}
				else
				{
					die($fe->getErro() . ' Alternativas pergunta');
				}
				
				$htmlInterativas .= '<div class="espacador"></div>';
			}
		}
		else
		{
			$htmlInterativas = "Erro linha 34";
		}
	}
	else if ($arrInfos[1] == 'grupo-perg')
	{
		$res = new Resolucao();
		$res->setCodcaso($_SESSION['casores']);
		$agrupadores = $res->BuscaConteudosAgrupador($arrInfos[3]);
		if ($agrupadores)
		{
			foreach ($agrupadores as $agrup)
			{
				$grupo = new GrupoPergunta();
				if ($grupo->Carrega($agrup->ContReferencia))
				{
					$perguntas = $grupo->getPerguntas();
					
					if ((! is_null($grupo->getExplicacao())) && (trim(strip_tags($grupo->getExplicacao())) != ''))
					{
						$boolExplicacao = true;
					}
					else
					{
						$boolExplicacao = false;
					}
				}
				else
				{
					die($grupo->getErro());
				}
				
				$htmlInterativas .= '<div class="item-interativo">@lng[Etapa:] <strong>' . $grupo->getTexto() . '</strong>' . ($boolExplicacao ? '<span style="float:right"><a href="javascript:void(0);" onclick="javascript:fntMostraOculta(\'exp-' . $grupo->getCodgrupo() . '\');"><img src="img/info.gif" alt="@lng[Mais informações]" title="@lng[Mais informações]" /></a></span>' : '') . '</div>';
				if ($boolExplicacao)
				{
					$htmlInterativas .= '<div class="explicacao-item" id="exp-' . $grupo->getCodgrupo() . '" style="display:none;">' . $grupo->getExplicacao() . '</div>';
				}
				
				foreach ($perguntas as $perg)
				{
					$p = new Pergunta();
					$p->Carregar($perg);
					
					$respostas = $res->BuscaRespostas($arrInfos[3], $perg);
					
					$alternativas = $fe->RetornaAlternativasDaPergunta($perg);
					if ($alternativas)
					{
						$htmlInterativas .= '<div class="sub-etapa">' . $p->getTexto() . '</div>';
						$htmlInterativas .= '<div class="det-etapa-int">';
						$htmlInterativas .= '<table class="listadados">';
						$htmlInterativas .= '<tr class="head">';
						$htmlInterativas .= '<td class="td-col-alt">@lng[Alternativa]</td>';
						$htmlInterativas .= '<td class="td-col-correto">@lng[Gabarito]</td>';
						$htmlInterativas .= '<td class="td-col-escolha">@lng[Você marcou]</td>';
						$htmlInterativas .= '<td class="td-col-jus">&nbsp;</td>';
						$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
						$htmlInterativas .= '</tr>';
						
						$contAlt = 1;
						foreach ($alternativas as $alternativa)
						{
							$htmlInterativas .= '<tr class="norm">';
							$htmlInterativas .= '<td class="dado td-col-alt">' . $alternativa->Alternativa . '</td>';
							$htmlInterativas .= '<td class="td-col-correto">' . ($alternativa->Correto == 1 ? Comuns::IMG_STATUS_CERTO : Comuns::IMG_STATUS_ERRADO) . '</td>';
							$htmlInterativas .= '<td class="td-col-escolha">' . (((intval($respostas) & intval($alternativa->ValorOpt)) > 0) ? Comuns::IMG_ITEM_PINO : '') . '</td>';
							$htmlInterativas .= '<td class="td-col-jus">' . (trim(strip_tags(nl2br($alternativa->Explicacao))) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'j\', \'' . $contUnico . '\', \'' . $contAlt . '\');">@lng[Ver detalhes]</a>' : '') . '</td>';
							$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
							$htmlInterativas .= '</tr>';
							if (trim(strip_tags($alternativa->Explicacao)) != '')
							{
								if (!is_null($alternativa->Explicacao))
								{
									$htmlInterativas .= '<tr style="display:none;" id="jus-' . $contUnico . '-' . $contAlt . '">';
									$htmlInterativas .= '<td colspan="5" class="apre-just"><div class="cont-just">' . $alternativa->Explicacao . '</div></td>';
									$htmlInterativas .= '</tr>';
								}
							}
							$contAlt++;
							$contUnico++;
						}
						$htmlInterativas .= '</table>';
						$htmlInterativas .= '</div>';
					}
					else
					{
						die($fe->getErro() . ' alternativas grupo pergunta');
					}
					
					$htmlInterativas .= '<div class="espacador"></div>';
				}
			}
		}
		else
		{
			$htmlInterativas = "Erro linha 122";
		}
	}
	
	echo(Comuns::Idioma($htmlInterativas));
	
}

Main();

?>