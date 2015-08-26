INSERT INTO mescaso(Nome, Descricao, DtCadastro, CodNivelDif, CodArea, Ativo, Publicado, Sexo, Idade, IDPaciente, Cid10, CodAutor, Publicado, Etnia, NomePaciente, ImgPaciente, Excluido)
select
	 Nome
	,Descricao
	,current_timestamp as DtCadastro
	,CodNivelDif
	,CodArea
	,1 as Ativo
	,0 as Publicado
	,Sexo
	,Idade
	,IDPaciente
	,Cid10
	,CodAutor
	,Publico
	,Etnia
	,NomePaciente
	,ImgPaciente
	,0 as Excluido
from mescaso
where Codigo = 8

INSERT INTO mescasoversao(CodCasoOrigem, CodCasoNovo, NumVersao, DtVersao, CodUsuario, Motivo)
VALUES(CodCasoOrigem, CodCasoNovo, NumVersao, CURRENT_TIMESTAMP, CodUsuario, Motivo)

select * from mescasocolaborador where CodCaso = 8
select * from mescasoanamnese where CodCaso = 8
select * from mescasoexamefisico where CodCaso = 8
select * from mescasohipotdiagn where codcaso = 8
select * from mescasodiagnostico where codcaso = 8
select * from mescasotratamento where codcaso = 8
select * from mescasodesfecho where codcaso = 8
select * from mesmidia where codcaso = 8
select * from mescasoconteudo where codcaso = 8
select * from mescasoperguntas where codcaso = 8
select * from mescasomontagem where codcaso = 8
select * from mescasoexames where codcaso = 8
select * from mescasoexamesitens where codcaso = 8


SELECT IFNULL(MAX(NumVersao), 1) + 1 AS NumVersao FROM mescasoversao WHERE CodCasoOrigem = 8



