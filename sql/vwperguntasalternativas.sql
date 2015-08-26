CREATE VIEW vwperguntasalternativas

AS

SELECT
	 p.Codigo
	,p.CodTipo
	,p.Tipo
	,p.Texto
	,a.Sequencia
	,a.Texto as TextoAlternativa
	,a.Imagem
	,a.Correto
	,a.Explicacao
	,a.CodBinario
FROM vwperguntasativas p
INNER JOIN mesalternativa a
		ON a.CodPergunta = p.Codigo