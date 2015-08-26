CREATE VIEW vwperguntasativas

as

select p.Codigo AS Codigo
		,ptip.Codigo AS CodTipo
		,ptip.Descricao AS Tipo
		,pclass.Codigo AS CodClass
		,pclass.Descricao AS Classe
		,group_concat(pt.Texto order by pt.Linha ASC separator '') AS Texto
		,(select count(*) from mesalternativa ma where ma.CodPergunta = p.Codigo) as Alternativas
		,p.DtCadastro
		,p.CodUsuario as Autor
from mespergunta p
join mesperguntatexto pt on pt.CodPergunta = p.Codigo
join mestipopergunta ptip on ptip.Codigo = p.CodTipo
join mesclassepergunta pclass on pclass.Codigo = p.CodClass
where (p.Ativo = 1)
group by p.Codigo
		,ptip.Codigo
		,ptip.Descricao
		,pclass.Codigo
		,pclass.Descricao
		,p.CodUsuario