INSERT INTO mestipoitem VALUES('vid', 'V�deo');
INSERT INTO mestipoitem VALUES('aud', '�udio');

ALTER TABLE mestipoitem
ADD COLUMN CodBinario BIGINT NOT NULL COMMENT 'C�digo binario para mostrar campos de configura��o ou n�o'

UPDATE mestipoitem SET CodBinario = 1 WHERE Codigo = 'raiz';
UPDATE mestipoitem SET CodBinario = 2 WHERE Codigo = 'an';
UPDATE mestipoitem SET CodBinario = 4 WHERE Codigo = 'exfis';
UPDATE mestipoitem SET CodBinario = 8 WHERE Codigo = 'hip';
UPDATE mestipoitem SET CodBinario = 16 WHERE Codigo = 'optex';
UPDATE mestipoitem SET CodBinario = 32 WHERE Codigo = 'resex';
UPDATE mestipoitem SET CodBinario = 64 WHERE Codigo = 'diag';
UPDATE mestipoitem SET CodBinario = 128 WHERE Codigo = 'trat';
UPDATE mestipoitem SET CodBinario = 256 WHERE Codigo = 'des';
UPDATE mestipoitem SET CodBinario = 516 WHERE Codigo = 'html';
UPDATE mestipoitem SET CodBinario = 1024 WHERE Codigo = 'img';
UPDATE mestipoitem SET CodBinario = 2048 WHERE Codigo = 'vid';
UPDATE mestipoitem SET CodBinario = 4096 WHERE Codigo = 'aud';
UPDATE mestipoitem SET CodBinario = 8192 WHERE Codigo = 'perg';
UPDATE mestipoitem SET CodBinario = 16384 WHERE Codigo = 'grupo-perg';

ALTER TABLE mescasomontagem
ADD COLUMN ValorOpt BIGINT NOT NULL DEFAULT 0 COMMENT 'Dos c�digos bin�rios para gravar a resposta do aluno'

CREATE TABLE mesresolucaoresposta
(
	CodResolucao int(11) NOT NULL COMMENT 'N�mero da resolu��o',
	CodAcesso int(11) NOT NULL COMMENT 'C�digo do acesso da resposta',
	ChaveItem varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do conte�do da resposta',
	NumTentativa int(11) NOT NULL COMMENT 'N�mero da tentativa',
	Resposta bigint(20) NOT NULL COMMENT 'Resposta do aluno',
	PRIMARY KEY (CodResolucao,CodAcesso,ChaveItem,NumTentativa)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Salva as respostas dadas pelos alunos'