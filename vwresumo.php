<?php
//--utf8_encode --
session_start();

include_once 'cls/usuario.class.php';
include_once 'cls/fechamento.class.php';
include_once 'cls/resolucao.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		$u = unserialize($_SESSION['usu']);
		
		$intCodCaso = $_SESSION['casores'];
		$intResolucao = Resolucao::BuscaUltimaResolucaoCaso($intCodCaso, $u->getCodigo(), 3);
		$_SESSION['codresolucao'] = $intResolucao;
		
		$tpl = file_get_contents("tpl/aluno/resumo.html");
		
		$fe = new Fechamento();
		$fe->setCodcaso($intCodCaso);
		$fe->setCodresolucao($intResolucao);
				
		$basicos = $fe->RetornaDadosBasicos();
		if ($basicos !== false)
		{
			$strNome = split(' ', $basicos->NomeCompleto);
			
			$tpl = str_replace('<!--titulocaso-->', $basicos->Caso, $tpl);
			$tpl = str_replace('<!--NomeUsuario-->', $strNome[0], $tpl);
			$tpl = str_replace('<!--DataInicial-->', date("d/m/Y H:i:s", strtotime($basicos->DataInicio)), $tpl);
			$tpl = str_replace('<!--DataFinal-->', date("d/m/Y H:i:s", strtotime($basicos->DataFim)), $tpl);
			$tpl = str_replace('<!--NumAcessos-->', $basicos->NumAcessos, $tpl);
			$tpl = str_replace('<!--ConteudosVistos-->', $basicos->ConteudosVistos, $tpl);
			
			$trajetoria = $fe->RetornaTrajetoria();
			if ($trajetoria)
			{
				$caminho = '<table><tr><td class="dado">@lng[Item]</td><td class="dado">@lng[Data/Hora]</td></tr>';
				foreach ($trajetoria as $etapa)
				{
					$caminho .= '<tr>';
					$caminho .= '<td><img src="img/' . $etapa->TipoConteudo . '_mini.png" />' . $etapa->Conteudo . '</td><td>' . date("d/m/Y H:i:s", strtotime($etapa->DataHora)) . '</td>';
					$caminho .= '</tr>';
				}
				$caminho .= '</table>';
				
				$tpl = str_replace('<!--ListaTrajeto-->', $caminho, $tpl);
				
				$interativas = $fe->RetornaEtapasInterativas();
				if ($interativas)
				{
					$intNumCertas = 0;
					$intNumErradas = 0;
					$intNumTotalAlt = 0;
					
					$tpl = str_replace('<!--NumEtapasInterativas-->', count($interativas), $tpl);
					$contInt = 1;
					$contUnico = 1;
					$res = new Resolucao();
					foreach ($interativas as $item)
					{
						//$res = new Resolucao();
						//$respostas = $res->BuscaRespostas($item->ChaveItem);
						
						if (($item->TipoConteudo != 'perg') && ($item->TipoConteudo != 'grupo-perg'))
						{
							$htmlInterativas .= '<div class="item-interativo">@lng[Etapa:] <strong>' . $item->Conteudo . '</strong></div>';
							$htmlInterativas .= '<div class="det-etapa-int">@lng[Número de tentivas de resposta:] <span class="dado">' . $item->Tentativas . '</span></div>';
							
							$respostas = $res->BuscaRespostas($item->ChaveItem);
							
							$alternativas = $fe->RetornaConteudosDoItemDaMontagem($item->ChaveItem, $item->TipoConteudo);
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
									$htmlInterativas .= '<td class="dado td-col-alt">' . $alternativa->Titulo . '</td>';
									$htmlInterativas .= '<td class="td-col-correto">' . ($alternativa->Correto == 1 ? Comuns::IMG_STATUS_CERTO : Comuns::IMG_STATUS_ERRADO) . '</td>';
									$htmlInterativas .= '<td class="td-col-escolha">' . (((intval($respostas) & intval($alternativa->ValorOpt)) > 0) ? Comuns::IMG_ITEM_PINO : '') . '</td>';
									$htmlInterativas .= '<td class="td-col-jus">' . (strip_tags($alternativa->Justificativa) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'j\', \'' . $contInt . '\', \'' . $contAlt . '\');">@lng[Ver detalhes]</a>' : '') . '</td>';
									$htmlInterativas .= '<td class="td-col-compl">' . (strip_tags($alternativa->ConteudoAdicional) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'c\', \'' . $contInt . '\', \'' . $contAlt . '\');">@lng[Ver complemento]</a>' : '') . '</td>';
									$htmlInterativas .= '</tr>';
									if (strip_tags($alternativa->Justificativa) != '')
									{
										$htmlInterativas .= '<tr style="display:none;" id="jus-' . $contInt . '-' . $contAlt . '">';
										$htmlInterativas .= '<td colspan="5" class="apre-just"><div class="cont-just">' . $alternativa->Justificativa . '</div></td>';
										$htmlInterativas .= '</tr>';
									}
									if (strip_tags($alternativa->ConteudoAdicional) != '')
									{
										$htmlInterativas .= '<tr style="display:none;" id="contadi-' . $contInt . '-' . $contAlt . '">';
										$htmlInterativas .= '<td colspan="5" class="apre-compl"><div class="cont-compl">' . $alternativa->ConteudoAdicional . '</div></td>';
										$htmlInterativas .= '</tr>';
									}
									
									// Contabilização das respostas certas ou erradas
									if ($alternativa->Correto == 1)
									{
										if ((intval($respostas) & intval($alternativa->ValorOpt)) > 0)
										{
											$intNumCertas++;
										}
										else
										{
											$intNumErradas++;
										}
									}
									else
									{
										if ((intval($respostas) & intval($alternativa->ValorOpt)) > 0)
										{
											$intNumErradas++;
										}
										else
										{
											$intNumCertas++;
										}
									}
									$contAlt++;
									$contUnico++;
								}
								
								$intNumTotalAlt += $contAlt;
								
								$htmlInterativas .= '</table>';
								$htmlInterativas .= '</div>';
							}
							else
							{
								die($fe->getErro() . ' Alternativas');
							}
							
							$htmlInterativas .= '<div class="espacador"></div>';
						}
						else if ($item->TipoConteudo == 'perg')
						{
							$perg = new Pergunta();
							$perg->Carregar($item->CodPergunta);
							
							if ((! is_null($perg->getTextoExplicacaoGeral())) && ($perg->getTextoExplicacaoGeral() != ''))
							{
								$boolExplicacao = true;
							}
							else
							{
								$boolExplicacao = false;
							}
							
							$htmlInterativas .= '<div class="item-interativo">@lng[Etapa:] <strong>' . $item->Conteudo . '</strong>' . ($boolExplicacao ? '<span style="float:right;"><a href="javascript:void(0);" onclick="javascript:fntMostraOculta(\'exp-' . $perg->getCodigo() . '\');"><img src="img/info.gif" alt="@lng[Mais informações]" title="@lng[Mais informações]" /></a></span>' : '') . '</div>';
							if ($boolExplicacao)
							{
								$htmlInterativas .= '<div class="explicacao-item" id="exp-' . $perg->getCodigo() . '" style="display:none;">' . $perg->getTextoExplicacaoGeral() . '</div>';
							}
							$htmlInterativas .= '<div class="det-etapa-int">@lng[Número de tentivas de resposta:] <span class="dado">' . $item->Tentativas . '</span></div>';
							
							$respostas = $res->BuscaRespostas($item->ChaveItem, $item->CodPergunta);
							
							$alternativas = $fe->RetornaAlternativasDaPergunta($item->CodPergunta);
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
									$htmlInterativas .= '<td class="td-col-jus">' . (strip_tags($alternativa->Explicacao) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'j\', \'' . $contInt . '\', \'' . $contAlt . '\');">@lng[Ver detalhes]</a>' : '') . '</td>';
									$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
									$htmlInterativas .= '</tr>';
									if (strip_tags($alternativa->Explicacao) != '')
									{
										$htmlInterativas .= '<tr style="display:none;" id="jus-' . $contInt . '-' . $contAlt . '">';
										$htmlInterativas .= '<td colspan="5" class="apre-just"><div class="cont-just">' . $alternativa->Explicacao . '</div></td>';
										$htmlInterativas .= '</tr>';
									}
									
									// Contabilização das respostas certas ou erradas
									if ($alternativa->Correto == 1)
									{
										if ((intval($respostas) & intval($alternativa->ValorOpt)) > 0)
										{
											$intNumCertas++;
										}
										else
										{
											$intNumErradas++;
										}
									}
									else
									{
										if ((intval($respostas) & intval($alternativa->ValorOpt)) > 0)
										{
											$intNumErradas++;
										}
										else
										{
											$intNumCertas++;
										}
									}
									
									$contAlt++;
									$contUnico++;
								}
								
								$intNumTotalAlt == $contAlt;
								
								$htmlInterativas .= '</table>';
								$htmlInterativas .= '</div>';
							}
							else
							{
								die($fe->getErro() . ' Alternativas pergunta');
							}
							
							$htmlInterativas .= '<div class="espacador"></div>';
						}
						else if ($item->TipoConteudo == 'grupo-perg')
						{
							$res->setCodcaso($intCodCaso);
							$agrupadores = $res->BuscaConteudosAgrupador($item->ChaveItem);
							if ($agrupadores)
							{
								foreach ($agrupadores as $agrup)
								{
									$grupo = new GrupoPergunta();
									if ($grupo->Carrega($agrup->ContReferencia))
									{
										$perguntas = $grupo->getPerguntas();
										
										if ((! is_null($grupo->getExplicacao())) && (strip_tags($grupo->getExplicacao()) != ''))
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
									
									$htmlInterativas .= '<div class="item-interativo">Etapa: <strong>' . $grupo->getTexto() . '</strong>' . ($boolExplicacao ? '<span style="float:right"><a href="javascript:void(0);" onclick="javascript:fntMostraOculta(\'exp-' . $grupo->getCodgrupo() . '\');"><img src="img/info.gif" alt="@lng[Mais informações]" title="@lng[Mais informações]" /></a></span>' : '') . '</div>';
									if ($boolExplicacao)
									{
										$htmlInterativas .= '<div class="explicacao-item" id="exp-' . $grupo->getCodgrupo() . '" style="display:none;">' . $grupo->getExplicacao() . '</div>';
									}
									$htmlInterativas .= '<div class="det-etapa-int">@lng[Número de tentivas de resposta:] <span class="dado">' . $item->Tentativas . '</span></div>';
									
									foreach ($perguntas as $perg)
									{
										$p = new Pergunta();
										$p->Carregar($perg);
										
										$respostas = $res->BuscaRespostas($item->ChaveItem, $perg);
										
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
												$htmlInterativas .= '<td class="td-col-jus">' . (strip_tags($alternativa->Explicacao) != '' ? '<a href="javascript:void(0);" onclick="javascript:fntDetItem(\'j\', \'' . $contUnico . '\', \'' . $contAlt . '\');">@lng[Ver detalhes]</a>' : '') . '</td>';
												$htmlInterativas .= '<td class="td-col-compl">&nbsp;</td>';
												$htmlInterativas .= '</tr>';
												if (strip_tags($alternativa->Explicacao) != '')
												{
													$htmlInterativas .= '<tr style="display:none;" id="jus-' . $contUnico . '-' . $contAlt . '">';
													$htmlInterativas .= '<td colspan="5" class="apre-just"><div class="cont-just">' . $alternativa->Explicacao . '</div></td>';
													$htmlInterativas .= '</tr>';
												}
												
												// Contabilização das respostas certas ou erradas
												if ($alternativa->Correto == 1)
												{
													if ((intval($respostas) & intval($alternativa->ValorOpt)) > 0)
													{
														$intNumCertas++;
													}
													else
													{
														$intNumErradas++;
													}
												}
												else
												{
													if ((intval($respostas) & intval($alternativa->ValorOpt)) > 0)
													{
														$intNumErradas++;
													}
													else
													{
														$intNumCertas++;
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
								die($res->getErro() . " agrupadores");
							}
						}
						$contInt++;
					}
					
					$dblNota = round((($intNumCertas / $intNumTotalAlt) * 10), 2);
					
					$tpl = str_replace('<!--DescricaoInterativas-->', $htmlInterativas, $tpl);
					$tpl = str_replace('<!--DescricaoNota-->', $dblNota, $tpl);
				}
				else
				{
					die($fe->getErro() . ' Interativas');
				}
			}
			else
			{
				die($fe->getErro() . ' Trajetórias');
			}
		}
		else
		{
			die($fe->getErro() . ' Basicos');
		}
		echo($tpl);
	}
	else
	{
		$msg = base64_encode("@lng[Caso não informado]");
		header("Location:aluno.php?msg=" . $msg);
	}
}

Main();

?>