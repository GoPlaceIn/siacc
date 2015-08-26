update mestipoitem set Descricao = 'Anamnese (identificação)' where Codigo = 'an'
insert into mestipoitem(Codigo, Descricao, CodBinario) values('aninv', 'Anamnese (investigação)', 65536)

update mesresolucaomenu set Telas = Telas + 65536 where CodItemMenu in(1, 2)

insert into mestipovalorreferencia(Descricao, Simbolo) values('Menor que', '<')
insert into mestipovalorreferencia(Descricao, Simbolo) values('Maior que', '>')

update mescasomontagemconfigs set Grupo = Grupo + 65536 where CodConfig = 5

ALTER TABLE mescasoexamefisico
ADD Geral VARCHAR(7000) NULL COMMENT 'Estado geral',
ADD midGeral BIGINT NOT NULL COMMENT 'Mídias do estado geral'

#alterar a vwarvorecaso