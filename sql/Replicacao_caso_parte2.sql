-- replicação das mídias
INSERT INTO mesmidia
SELECT 15, CodMidia, Descricao, Complemento, CodTipo, current_timestamp, url, Largura, Altura, Origem
FROM mesmidia
where codcaso = 8
order by codmidia

-- replicação dos itens do exame
INSERT INTO mescasoexamesitens
SELECT
	 15
	,mescasoexames.CodExame
	,null
	,mescasoexamesitens.Descricao
	,mescasoexamesitens.Valor
	,mescasoexamesitens.TipoItem
	,mescasoexamesitens.Complemento
	,mescasoexamesitens.DtCadastro
	,mescasoexamesitens.CodItem as CodItemOrigem
FROM mescasoexamesitens
INNER JOIN mescasoexames
		ON mescasoexames.CodCaso = 15
	   AND mescasoexames.CodExameOrigem = mescasoexamesitens.CodExame
WHERE mescasoexamesitens.CodCaso = 8

-- Replicação das perguntas do caso
INSERT INTO mescasoperguntas
SELECT 15, CodPergunta
FROM mescasoperguntas WHERE codcaso = 8

-- Replicação das hipóteses diagnósticas
INSERT INTO mescasohipotdiagn(CodCaso, CodHipotese, Descricao, Correto, Justificativa, ConteudoAdicional, Sequencia, CodHipoteseOrigem)
SELECT 15, null, Descricao, Correto, Justificativa, ConteudoAdicional, Sequencia, CodHipotese as CodHipoteseOrigem
FROM mescasohipotdiagn
where codcaso = 8
order by CodHipotese

-- Adição do campo para replicação das hipóteses diagnósticas
alter table mescasohipotdiagn
add column CodHipoteseOrigem int null comment 'Na replicação é a hipótese diagnóstica que deu origem ao registro';

alter table mescasoexames
add column CodExameOrigem int null comment 'Na replicação é o exame que deu origem ao registro';

alter table mescasoexamesitens
add column CodItemOrigem int null comment 'Na replicação é o item do exame que deu origem ao registro';

alter table mescasodiagnostico
add column CodDiagnosticoOrigem int null comment 'Na replicação é o diagnóstico que deu origem ao registro';

alter table mescasodesfecho
add column CodDesfechoOrigem int null comment 'Na replicação é o desfecho que deu origem ao registro';

alter table mescasoconteudo
add column CodConteudoOrigem int null comment 'Na replicação é o conteudo que deu origem ao registro';

alter table mescasotratamento
add column CodTratamentoOrigem int null comment 'Na replicação é o tratamento que deu origem ao registro'