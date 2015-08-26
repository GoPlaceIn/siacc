CREATE VIEW vwconteudoscaso

AS

SELECT 
	 CodCaso
	,CodHipotese as CodConteudo
	,(select Codigo from mestipoitem where Codigo = 'hip') AS Tipo
	,Descricao as Titulo
	,Correto
	,Justificativa
	,ConteudoAdicional
FROM mescasohipotdiagn

union all

SELECT 
	 CodCaso
	,CodExame as CodConteudo
	,(select Codigo from mestipoitem where Codigo = 'optex') AS Tipo
	,Descricao as Titulo
	,Correto
	,Justificativa
	,ConteudoAdicional
FROM mescasoexames

union all

SELECT 
	 CodCaso
	,CodDiagnostico as CodConteudo
	,(select Codigo from mestipoitem where Codigo = 'diag') AS Tipo
	,Descricao as Titulo
	,Correto
	,Justificativa
	,ConteudoAdicional
FROM mescasodiagnostico

union all

SELECT 
	 CodCaso
	,CodTratamento as CodConteudo
	,(select Codigo from mestipoitem where Codigo = 'trat') AS Tipo
	,Titulo
	,Correto
	,Justificativa
	,ConteudoAdicional
FROM mescasotratamento