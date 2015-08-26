select Prefixo, Chave, Item, Fixo, OrdemFixo, Padrao from(
select ch.* 
from meschavesitens ch where Padrao = 1
union
/* Perguntas */
select 'EXE' AS Prefixo, pe.Chave, left(pete.Texto, 50) as Item, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao
from mespergunta pe 
inner join mesperguntatexto pete 
		on pete.CodPergunta = pe.Codigo
	   and pete.Linha = 1
inner join mescasoperguntas cape
		on cape.CodPergunta = pe.Codigo
	   and cape.CodCaso = 5
union
select 'AGR' as Prefixo, peag.Chave, peag.Texto, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao
from mesperguntaagrupador peag
inner join mescasoagrupamentos caag
		on caag.CodAgrupamento = peag.Codigo
	   and caag.CodCaso = 5
union
select 'CON' AS Prefixo, co.Chave, co.Descricao, 0 as Fixo, 0 as OrdemFixo, 0 as Padrao
from mescasoconteudo co
where CodCaso = 5
) Itens
order by Fixo desc, OrdemFixo, Padrao desc