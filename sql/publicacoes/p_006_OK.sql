INSERT INTO mestipoitem VALUES('vid', 'Vídeo');
INSERT INTO mestipoitem VALUES('aud', 'Áudio');

ALTER TABLE mestipoitem
ADD COLUMN CodBinario BIGINT NOT NULL COMMENT 'Código binario para mostrar campos de configuração ou não'

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
ADD COLUMN ValorOpt BIGINT NOT NULL DEFAULT 0 COMMENT 'Dos códigos binários para gravar a resposta do aluno'

CREATE TABLE mesresolucaoresposta
(
	CodResolucao int(11) NOT NULL COMMENT 'Número da resolução',
	CodAcesso int(11) NOT NULL COMMENT 'Código do acesso da resposta',
	ChaveItem varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do conteúdo da resposta',
	NumTentativa int(11) NOT NULL COMMENT 'Número da tentativa',
	Resposta bigint(20) NOT NULL COMMENT 'Resposta do aluno',
	PRIMARY KEY (CodResolucao,CodAcesso,ChaveItem,NumTentativa)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Salva as respostas dadas pelos alunos'