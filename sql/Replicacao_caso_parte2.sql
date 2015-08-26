-- replica��o das m�dias
INSERT INTO mesmidia
SELECT 15, CodMidia, Descricao, Complemento, CodTipo, current_timestamp, url, Largura, Altura, Origem
FROM mesmidia
where codcaso = 8
order by codmidia

-- replica��o dos itens do exame
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

-- Replica��o das perguntas do caso
INSERT INTO mescasoperguntas
SELECT 15, CodPergunta
FROM mescasoperguntas WHERE codcaso = 8

-- Replica��o das hip�teses diagn�sticas
INSERT INTO mescasohipotdiagn(CodCaso, CodHipotese, Descricao, Correto, Justificativa, ConteudoAdicional, Sequencia, CodHipoteseOrigem)
SELECT 15, null, Descricao, Correto, Justificativa, ConteudoAdicional, Sequencia, CodHipotese as CodHipoteseOrigem
FROM mescasohipotdiagn
where codcaso = 8
order by CodHipotese

-- Adi��o do campo para replica��o das hip�teses diagn�sticas
alter table mescasohipotdiagn
add column CodHipoteseOrigem int null comment 'Na replica��o � a hip�tese diagn�stica que deu origem ao registro';

alter table mescasoexames
add column CodExameOrigem int null comment 'Na replica��o � o exame que deu origem ao registro';

alter table mescasoexamesitens
add column CodItemOrigem int null comment 'Na replica��o � o item do exame que deu origem ao registro';

alter table mescasodiagnostico
add column CodDiagnosticoOrigem int null comment 'Na replica��o � o diagn�stico que deu origem ao registro';

alter table mescasodesfecho
add column CodDesfechoOrigem int null comment 'Na replica��o � o desfecho que deu origem ao registro';

alter table mescasoconteudo
add column CodConteudoOrigem int null comment 'Na replica��o � o conteudo que deu origem ao registro';

alter table mescasotratamento
add column CodTratamentoOrigem int null comment 'Na replica��o � o tratamento que deu origem ao registro'