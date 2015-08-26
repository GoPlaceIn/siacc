ALTER VIEW vwarvorecaso

AS

SELECT m.CodCaso
	, CodMontagem
	, m.Chave
	, m.TipoConteudo
	, case when ContReferencia = 0 and Organizador <> 'cont' then
	    t.Descricao
	  else
	    case when TipoConteudo IN('an','aninv','exfis') then
			t.Descricao
		else
			case when TipoConteudo = 'diag' then
				mdiag.Descricao
			else
				case when TipoConteudo IN('optex', 'resex') then
					mexame.Descricao
				else
					case when TipoConteudo = 'hip' then
						mhip.Descricao
					else
						case when TipoConteudo = 'perg' then
							mvwperg.Texto
						else
							case when TipoConteudo = 'html' then
								html.Descricao
							else
								case when TipoConteudo = 'grupo-perg' then
									agrup.Texto
								else
									case when TipoConteudo IN('img', 'vid', 'aud', 'doc') then
										case when midia.Descricao is null then '<span class="msg-erro">Item removido</span>' else midia.Descricao end
									else
										case when TipoConteudo IN('trat') then
											trat.Titulo
										else
											case when TipoConteudo IN('des') then
												des.Titulo
											else
												'Outro'
											end
										end
									end
								end
							end
						end
					end
				end
			end
		end
	  end as Conteudo
	, Ordem
	, ChavePai
	, Organizador
	, ContReferencia
FROM mescasomontagem m
INNER JOIN mestipoitem t
		ON t.Codigo = m.TipoConteudo
LEFT OUTER JOIN mescasodiagnostico mdiag
			 ON mdiag.CodCaso = m.CodCaso
			AND mdiag.CodDiagnostico = m.ContReferencia
LEFT OUTER JOIN mescasoexames mexame
			 ON mexame.CodCaso = m.CodCaso
			AND mexame.CodExame = m.ContReferencia
LEFT OUTER JOIN mescasohipotdiagn mhip
			 ON mhip.CodCaso = m.CodCaso
			AND mhip.CodHipotese = m.ContReferencia
LEFT OUTER JOIN vwperguntasativas mvwperg
			 ON mvwperg.Codigo = m.ContReferencia
LEFT OUTER JOIN mescasoconteudo html
			 ON html.CodCaso = m.CodCaso
			AND html.CodConteudo = m.ContReferencia
LEFT OUTER JOIN mesmidia midia
			 ON midia.CodCaso = m.CodCaso
			AND midia.CodMidia = m.ContReferencia
LEFT OUTER JOIN mescasoagrupamentos casoagrup
			 ON casoagrup.CodCaso = m.CodCaso
			AND casoagrup.CodAgrupamento = m.ContReferencia
LEFT OUTER JOIN mesperguntaagrupador agrup
			 ON agrup.Codigo = casoagrup.CodAgrupamento
LEFT OUTER JOIN mescasodesfecho des
			 ON des.CodCaso = m.CodCaso
			AND des.CodDesfecho = m.ContReferencia
LEFT OUTER JOIN mescasotratamento trat
			 ON trat.CodCaso = m.CodCaso
			AND trat.Codtratamento = m.ContReferencia