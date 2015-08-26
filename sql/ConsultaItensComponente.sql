select 	 te.Codigo as CodExame
		,te.descricao
		,tec.codigo as CodComp
		,tec.descricao as DescComp
		,tevr.Agrupador
		,tevr.valmin
		,tevr.valmax
		,tevr.unidademedida
		,tevr.tipo
from mestipoexame te
left outer join mestipoexamecomponente tec
			 on tec.codexame = te.codigo
left outer join mestipoexamevalref tevr
			 on tevr.codexame = te.codigo
			and tevr.codcomponente = case when tevr.codcomponente = 0 then 0 else tec.codigo end
where te.codigo = 7
  and te.ativo = 1


SELECT 	 CodExame
		,CodComponente
		,CASE WHEN TemAgrupador = 1 then Agrupador else '--' end as Agrupador
		,CASE WHEN Tipo = 1 THEN
			CONCAT(Descricao, ' ', ValMin, ' e ', ValMax)
		 ELSE
			CASE WHEN Tipo = 4 THEN
				ValMin
			ELSE
				CONCAT(Simbolo, ' ', CASE WHEN Tipo = 2 THEN ValMin ELSE ValMax END)
			END
		 END AS Descricao
		,CASE WHEN ValMin IS NULL THEN '' ELSE ValMin END AS ValMin
		,CASE WHEN ValMax IS NULL THEN '' ELSE ValMax END AS ValMax
		,CASE WHEN UnidadeMedida IS NULL THEN '' ELSE UnidadeMedida END AS UnidadeMedida
FROM mestipoexamevalref vr
INNER JOIN mestipovalorreferencia tvr
		on tvr.codigo = vr.tipo
WHERE CodExame = 6
/*  AND CodComponente = 0*/
ORDER BY TemAgrupador
