select * from mescasoconteudo

INSERT INTO mescasomontagem(CodCaso, CodMontagem, Chave, TipoConteudo, Ordem, ChavePai, Organizador, ContReferencia, ValorOpt)
SELECT
	 15
	,CodMontagem
	,Chave
	,TipoConteudo
	,Ordem
	,ChavePai
	,Organizador
	,case when Organizador = 'cont' then
         case when TipoConteudo = 'html' then
		(select CodConteudo from mescasoconteudo where CodConteudoOrigem = ContReferencia)
	 else
		case when TipoConteudo in ('resex', 'optex') then
			(select CodExame from mescasoexames where CodExameOrigem = ContReferencia)
		else
			case when TipoConteudo in('vid', 'aud', 'img', 'doc', 'perg', 'grupo-perg', 'an', 'aninv', 'exfis') then
				ContReferencia
			else
				case when TipoConteudo = 'hip' then
					(select CodHipotese from mescasohipotdiagn where CodHipoteseOrigem = ContReferencia)
				else
					case when TipoConteudo = 'diag' then
						(select CodDiagnostico from mescasodiagnostico where CodDiagnosticoOrigem = ContReferencia)
					else
						case when TipoConteudo = 'trat' then
							(select CodTratamento from mescasotratamento where CodTratamentoOrigem = ContReferencia)
						else
							case when TipoConteudo = 'des' then
								(select CodDesfecho from mescasodesfecho where CodDesfechoOrigem = ContReferencia)
							else
								-1
							end
						end
					end
				end
			end
		end
	 end
	else
 		0
	end as ContReferenciaNovo
,ValorOpt
FROM mescasomontagem
where CodCaso = 8
order by Ordem