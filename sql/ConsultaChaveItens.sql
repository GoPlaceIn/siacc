select * from(
	select ch.* from meschavesitens ch
	where Padrao = 1
	union
	select ch.* from meschavesitens ch
	inner join mespergunta pe on pe.Chave = ch.Chave
	inner join mescasoperguntas cape on cape.CodPergunta = pe.Codigo and cape.CodCaso = 4
	union
	select ch.* from meschavesitens ch
	inner join mescasoconteudo co on co.Chave = ch.Chave and co.CodCaso = 4
	) Itens
order by Fixo desc, OrdemFixo, Padrao desc