CREATE TABLE mesetnia (
	Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código da etnia',
	Nome varchar(100) NOT NULL COMMENT 'Nome da etnia',
	Ativo tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Se a etnia pode ser usada em novos casos',
	PRIMARY KEY (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de etnias';

INSERT INTO mesetnia(Nome, Ativo)
VALUES
	('Branco', 1),
	('Negro', 2),
	('Pardo', 3);

CREATE TABLE mespersonagem (
	Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Codigo do personagem',
	Sexo char(1) NOT NULL COMMENT 'M = Masculino e F = feminino',
	Imagem varchar(500) NOT NULL COMMENT 'URL da imagem do personagem',
	CodEtnia int(11) NOT NULL COMMENT 'Código da etnia',
	PRIMARY KEY (Codigo),
	KEY FK_mespersonagem_mesetnia (CodEtnia),
	CONSTRAINT FK_mespersonagem_mesetnia FOREIGN KEY (CodEtnia) REFERENCES mesetnia (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela com a figura dos personagens';


alter table mesusuario add Situacao tinyint null default 0;

update mesusuario set Situacao = 1;
update mesitensmenu set Texto = 'Gerenciar usuários' where Codigo = 14;