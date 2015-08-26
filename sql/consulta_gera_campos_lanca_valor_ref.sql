select 	 e.CodCaso
		,e.CodExame
		,c.codigo as CodComponente
		,c.descricao as DesComponente
		,v.Agrupador
		,case when v.tipo = 1 then
			concat(tvr.Descricao, ' ', v.valmin, ' e ', v.valmax)
		 else
			case when v.tipo = 4 then
				v.valmin
			else
				concat(Simbolo, ' ', case when v.tipo = 2 then ValMin else ValMax end)
			end
		 end as Padrao
		,i.Valor
		,i.Complemento
from mescasoexames e
inner join mestipoexame t
		on t.codigo = e.tipo
inner join mestipoexamecomponente c
		on c.codexame = t.codigo
left join mestipoexamevalref v
		on v.codexame = c.codexame
	   and v.codcomponente = c.codigo
left join mestipovalorreferencia tvr
		on tvr.Codigo = v.Tipo
left join mescasoexamesitens i
		on i.codcaso = e.codcaso
	   and i.codexame = e.codexame
	   and i.descricao = c.codigo
where e.codcaso = 4
  and e.codexame = 10


select distinct e.codcaso
				,e.codexame
				,t.Codigo as CodComponente
				,t.Descricao as DesComponente
				,v.Agrupador
				,case when v.tipo = 1 then
					concat(tvr.Descricao, ' ', v.valmin, ' e ', v.valmax)
				 else
					case when v.tipo = 4 then
						v.valmin
					else
						concat(Simbolo, ' ', case when v.tipo = 2 then ValMin else ValMax end)
					end
				 end as Padrao
				,i.Valor
				,i.Complemento
from mescasoexames e
inner join mestipoexame t
		on t.Codigo = e.tipo
left join mestipoexamevalref v
		on v.codexame = t.Codigo
left join mestipovalorreferencia tvr
		on tvr.Codigo = v.Tipo
left join mescasoexamesitens i
		on i.codcaso = e.codcaso
	   and i.codexame = e.codexame
where e.codcaso = 4
  and e.codexame = 11



/*
select * from mestipoexame
select * from mestipoexamevalref
select * from mestipoexamecomponente
select * from mestipovalorreferencia
select * from mescasoexames
select * from mescasoexamesitens
*/


select * from mescasoexames
select * from mescasoexamesitens