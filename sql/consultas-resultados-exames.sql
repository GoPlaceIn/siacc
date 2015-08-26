select distinct hipperg.CodCaso, hipperg.GrupoHipotese, hipperg.Chave, hipperg.Texto
from mescasohipotdiagn hip
inner join mescasohipotdiagnperguntaguia hipperg
		on hipperg.CodCaso = hip.CodCaso
	   and hipperg.GrupoHipotese = hip.Sequencia
where hip.codcaso = 5


select GrupoHipotese, Texto
from mescasohipotdiagnperguntaguia
where CodCaso = 5 and chave = 'BA30BDB5D0F9D196744BBD9B99FD7D9F'

SELECT DISTINCT 'HIP' as Prefixo, Chave
		,LEFT(Texto, 50) as Item, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao
FROM mescasohipotdiagnperguntaguia hipperg
WHERE hipperg.codcaso = 5


select * from meschavesitens ch where Padrao = 1

select * from mescasoordenacao where codcaso = 5


select * from mescasoexameschaves
where codcaso = 5 and numbateria = 1

select hip.CodHipotese
		,hip.Descricao
		,hip.Correto
		,hip.Justificativa
		,hip.ConteudoAdicional
from mescasohipotdiagnperguntaguia hippg
inner join mescasohipotdiagn hip
		on hip.codcaso = hippg.codcaso
	   and hip.sequencia = hippg.grupohipotese
where hippg.CodCaso = 5
  and hippg.Chave = 'BA30BDB5D0F9D196744BBD9B99FD7D9F'




select 	 ex.CodCaso
		,ex.NumBateria
		,ex.TipoRegistro
		,case when ex.TipoRegistro = 1 then 
			expg.Texto 
		 else 
			concat('Resultados da ', ex.NumBateria, 'ª bateria de exames') end as Texto
from mescasoexameschaves ex
left join mescasoexamesperguntaguia expg
		on expg.CodCaso = ex.CodCaso
	   and expg.NumBateria = ex.NumBateria
where ex.CodCaso = 5
  and chave = 'D86D7AA8AC69573FF45C022470FE32F5'


select * from mescasoexameschaves
select * from mescasoexames
select * from mescasoexamesperguntaguia




select * from mescasoexames where codcaso = 5 and numbateria = 1 and mostraquando = 0



select ex.CodCaso
		,ex.NumBateria
		,ex.TipoRegistro
		,ex.Agrupado
		,case when ex.TipoRegistro = 1 then expg.Texto else concat('Resultados da ', ex.NumBateria, 'ª bateria de exames') end as Texto
		,ex.codexame
		,ex.chave
from mescasoexameschaves ex
left join mescasoexamesperguntaguia expg
		on expg.CodCaso = ex.CodCaso and expg.NumBateria = ex.NumBateria
where ex.CodCaso = 5
--and chave = '061E8DFD8F87804E0A4213D37A716FF5';


/* Busca se alternativas ofertadas nos exames estão certas ou erradas */
select ex.CodExame
		,ex.Descricao
		,ex.Correto
		,ex.Justificativa
		,ex.ConteudoAdicional
from mescasoexameschaves ech
inner join mescasoexames ex
		on ex.codcaso = ech.codcaso
	   and ex.numbateria = ech.numbateria
	   and ex.codexame = case when ech.codexame = -1 then ex.codexame else ech.CodExame end
	   and ex.MostraQuando = case when ech.tiporegistro = 1 then 0 else ex.MostraQuando end
where ech.codcaso = 5
  and ech.chave = 'D86D7AA8AC69573FF45C022470FE32F5'


select 	 ex.CodCaso
		,ex.CodExame
		,ex.Descricao as Exame
		,te.Descricao as TipoExame
		,itens.descricao as Componente
		,case when (itens.tipoitem = 'vlr' and itens.descricao <> 0) then
			(select Descricao
				from mestipoexamecomponente comp
				where comp.codexame = te.codigo
				  and comp.codigo = itens.descricao)
		 else null end as DescComponente
		,itens.tipoitem
		,itens.Valor
from mescasoexameschaves exch
inner join mescasoexames ex
		on ex.codcaso = exch.codcaso
	   and ex.numbateria = exch.numbateria
inner join mestipoexame te
		on te.Codigo = ex.Tipo
inner join mescasoexamesitens itens
		on itens.codcaso = ex.codcaso
	   and itens.codexame = ex.codexame
where exch.Codcaso = 5
  and exch.chave = '061E8DFD8F87804E0A4213D37A716FF5'
  and 	(
			(exch.Agrupado = 0 and ex.codexame = exch.codexame)
			or
			(
				exch.Agrupado = 1
				and
				ex.codexame not in	(
									select distinct codexame
									from mescasoexameschaves exch2
									where exch2.codcaso = exch.codcaso
									  and exch2.NumBateria = exch.NumBateria
									  and exch2.Agrupado = 0
									  and exch2.CodExame <> -1
									  and exch2.TipoRegistro = 2
									)
			)
		)