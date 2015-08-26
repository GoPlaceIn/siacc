CREATE TABLE mescasoconfigs
(
	CodCaso int(11) NOT NULL COMMENT 'Código do caso clínico',
	Secao varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Parte do caso clínico',
	Configuracao varchar(40) COLLATE latin1_general_ci NOT NULL COMMENT 'O que será configurado',
	Valor varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Valor da configuração',
	PRIMARY KEY (CodCaso,Secao,Configuracao),
	CONSTRAINT FK_mescasoconfigs_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela com as configurações do caso clínico';

INSERT INTO mescasoconfigs(CodCaso, Secao, Configuracao, Valor)
VALUES(4, 'diagnosticos', 'TipoResp', 'CE');

INSERT INTO mescasoconfigs(CodCaso, Secao, Configuracao, Valor)
VALUES(4, 'exames', 'TipoResp', 'CE');

INSERT INTO mescasoconfigs(CodCaso, Secao, Configuracao, Valor)
VALUES(4, 'hipoteses', 'TipoResp', 'CE');

INSERT INTO mescasoconfigs(CodCaso, Secao, Configuracao, Valor)
VALUES(4, 'tratamentos', 'TipoResp', 'CE');

ALTER TABLE mesacessousuario
ADD Host VARCHAR(300) NULL COMMENT 'Host de origem do acesso';