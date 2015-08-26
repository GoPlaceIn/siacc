create view vwarvoredescextra
as
select pai.codcaso
	, pai.Chave
	, pai.CodMontagem
	, group_concat(vw.Conteudo order by vw.Ordem separator ', ') as DescricaoFilhos
from mescasomontagem pai
inner join mescasomontagem filho
	on filho.ChavePai = pai.Chave
	and filho.CodCaso = pai.CodCaso
	and filho.CodMontagem = pai.CodMontagem
inner join vwarvorecaso vw
	on vw.CodCaso = filho.codCaso
	and vw.CodMontagem = filho.CodMontagem
	and vw.Chave = filho.Chave
where vw.Organizador = 'cont'
group by pai.codcaso
	,pai.CodMontagem
	,pai.Chave