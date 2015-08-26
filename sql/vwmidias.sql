CREATE VIEW vwmidias

AS

select CodCaso, CodConteudo, Descricao, 3 as CodTipo, 'Hipertexto' as Tipo
from mescasoconteudo
union all
select m.CodCaso, m.CodMidia as CodConteudo, m.Descricao, t.CodTipo, t.Descricao as Tipo
from mesmidia m
inner join mestipomidia t on t.CodTipo = m.CodTipo