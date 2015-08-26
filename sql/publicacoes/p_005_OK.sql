/*
ALTER TABLE mesusuariologacoes
ADD COLUMN Erro TINYINT NOT NULL DEFAULT 0 COMMENT 'Indica se foi um erro ou n�o';

CREATE TABLE mestipomidia (
    CodTipo int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo do tipo da m�dia',
    Descricao varchar(300) COLLATE latin1_general_ci NOT NULL COMMENT 'Descricao da m�dia',
    Ativo tinyint(4) NOT NULL COMMENT 'Indica se est� ativo para usar ou n�o',
    PRIMARY KEY (CodTipo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tipos de m�dia';

INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Imagem', 1);
INSERT INTO mestipomidia(Descricao, Ativo) VALUES('V�deo', 1);
INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Hipertexto', 1);
INSERT INTO mestipomidia(Descricao, Ativo) VALUES('�udio', 1);

CREATE TABLE mesmidia (
	CodCaso int(11) NOT NULL COMMENT 'C�digo do caso',
	CodMidia bigint(11) NOT NULL COMMENT 'C�digo identificador da m�dida (usado para compara��o binaria)',
	Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o da m�dia',
	Complemento varchar(500) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Informa��es complementares',
	CodTipo int(11) NOT NULL COMMENT 'Tipo de m�dia',
	DtCadastro datetime NOT NULL COMMENT 'Data de cadastro',
	url varchar(2000) COLLATE latin1_general_ci NOT NULL COMMENT 'url de acesso a midia',
	Largura int(11) DEFAULT NULL COMMENT 'Para os v�deos deve ser informado',
	Altura int(11) DEFAULT NULL COMMENT 'Para os v�deos deve ser informado',
	Origem varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Origem da m�dia (banco, upload, web)',
	PRIMARY KEY (CodMidia,CodCaso),
	KEY FK_mesmidia (CodTipo),
	KEY idx_mesmidia_url (CodCaso,url(767)),
	CONSTRAINT FK_mesmidia FOREIGN KEY (CodTipo) REFERENCES mestipomidia (CodTipo),
	CONSTRAINT FK_mesmidia_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de m�dias'

CREATE TABLE siscachetipoconsulta (
    CodTipo int(11) NOT NULL COMMENT 'C�digo do tipo da consulta',
    Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o do tipo de consulta',
    DataHora datetime NOT NULL COMMENT 'Data e hora do cache',
    PRIMARY KEY (CodTipo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Cache dos tipos de pesquisa do banco de imagens';

CREATE TABLE siscachesubtipoconsulta (
    CodTipo int(11) NOT NULL COMMENT 'C�digo do tipo ao qual o subtipo est� vinculado',
    CodSubTipo int(11) NOT NULL COMMENT 'C�digo do subtipo da consulta',
    DescricaoSubTipo varchar(400) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o do subtipo',
     DataHora datetime NOT NULL COMMENT 'Data e hora do cache',
     PRIMARY KEY (CodTipo,CodSubTipo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Cache dos subtipos de pesquisa';

CREATE TABLE mestipomidiaextensao (                                                                                                                    
    CodTipoMidia int(11) NOT NULL COMMENT 'C�digo da m�dia',                                                                                           
    Extensao varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Extens�o do arquivo',                                                              
    Icone varchar(300) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Icone do tipo de arquivo',                                                        
    TamMaxUpload double NOT NULL COMMENT 'Tamanho m�ximo do upload',                                                                                    
    Descricao varchar(200) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Nome por extenso da extensao',                                                
    PRIMARY KEY (CodTipoMidia,Extensao),                                                                                                               
    CONSTRAINT FK_mestipomidiaextensao_mestipomidia FOREIGN KEY (CodTipoMidia) REFERENCES mestipomidia (CodTipo)                                   
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Extensoes dos tipos de midia';

insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('1','gif',NULL,'3000','Imagem gif');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('1','jpg',NULL,'3000','Imagem jpg');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('1','png',NULL,'3000','Imagem pgn');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('3','doc',NULL,'3000','Documento de texto');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('3','docx',NULL,'3000','Documento de texto');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('3','html',NULL,'1024','Hipetext Markup Language');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('3','pdf',NULL,'4000','Documento PDF');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('4','mp3',NULL,'5000','Arquivo de �udio');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('4','wav',NULL,'5000','Arquivo de �udio');

CREATE TABLE mestipoitem (
    Codigo varchar(15) COLLATE latin1_general_ci NOT NULL COMMENT 'C�digo dos tipos de itens da montagem',
    Descricao varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o dos tipos de itens da montagem',
    PRIMARY KEY (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tipos de itens da montagem';

insert into mestipoitem (Codigo, Descricao) values('an','Anamnese');
insert into mestipoitem (Codigo, Descricao) values('des','Desfecho');
insert into mestipoitem (Codigo, Descricao) values('diag','Diagn�sticos');
insert into mestipoitem (Codigo, Descricao) values('optex','Op��es de exames');
insert into mestipoitem (Codigo, Descricao) values('resex','Resultados de exames');
insert into mestipoitem (Codigo, Descricao) values('exfis','Exame f�sico');
insert into mestipoitem (Codigo, Descricao) values('grupo-perg','Grupo de exerc�cios');
insert into mestipoitem (Codigo, Descricao) values('hip','Hip�teses diagn�sticas');
insert into mestipoitem (Codigo, Descricao) values('html','Conteudo HTML');
insert into mestipoitem (Codigo, Descricao) values('img','Imagem');
insert into mestipoitem (Codigo, Descricao) values('perg','Exerc�cio');
insert into mestipoitem (Codigo, Descricao) values('raiz','Caso de estudo');
insert into mestipoitem (Codigo, Descricao) values('trat','Tratamento');
*/
/* verificar as permiss�es j� existentes no banco antes de inserir essa nova permiss�o */

/*
INSERT INTO mespermissao(Descricao) values('Cadastrar imagens no caso');

CREATE TABLE mesexamefisicoetapas (
    Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo da etapa do exame f�sico',
    Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o da etapa do exame f�sico',
    PRIMARY KEY (Codigo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Etapas do exame f�sico';

insert into mesexamefisicoetapas (Codigo, Descricao) values('1','Cabe�a');
insert into mesexamefisicoetapas (Codigo, Descricao) values('2','Pesco�o');
insert into mesexamefisicoetapas (Codigo, Descricao) values('3','Ausculta pulmonar');
insert into mesexamefisicoetapas (Codigo, Descricao) values('4','Ausculta card�aca');
insert into mesexamefisicoetapas (Codigo, Descricao) values('5','Abdomen');
insert into mesexamefisicoetapas (Codigo, Descricao) values('6','Extremidades');
insert into mesexamefisicoetapas (Codigo, Descricao) values('7','Pele');
insert into mesexamefisicoetapas (Codigo, Descricao) values('8','Sinais vitais');

ALTER TABLE mescasoexamefisico
ADD COLUMN midCabeca BIGINT NOT NULL COMMENT 'Soma dos c�digos das m�dias vinculadas a cabe�a',
ADD COLUMN midPescoco bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas ao pesco�o',
ADD COLUMN midAusPulmonar bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas a ausculta pulmonar',
ADD COLUMN midAusCardiaca bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas a ausculta cardiaca',
ADD COLUMN midSinaisVitais bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas aos sinais vitais',
ADD COLUMN midAbdomen bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas ao abdobem',
ADD COLUMN midPele bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas a pele',
ADD COLUMN midExtremidades bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos c�digos das m�dias vinculadas as extremidades';

ALTER TABLE mesacessousuario
ADD COLUMN Navegador VARCHAR(1000) NULL COMMENT 'Tipo de navegador do usu�rio';

ALTER TABLE mesmidia
ADD COLUMN Origem VARCHAR(100) NULL COMMENT 'Origem da m�dia (banco, upload, web)';
*/

CREATE TABLE mescasomontagem (
    CodCaso int(11) NOT NULL COMMENT 'C�digo do caso',
    CodMontagem int(11) NOT NULL COMMENT 'C�digo da montagem (pode ter mais de uma)',
    Chave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave grande individual',
    TipoConteudo varchar(15) COLLATE latin1_general_ci NOT NULL COMMENT 'O tipo de conteudo que pode ser adicionado (hip, trat, exafis, etc...)',
    Ordem int(11) NOT NULL COMMENT 'Ordena��o',
    ChavePai varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Chave do item pai',
    Organizador varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT '???',
    ContReferencia int(11) NOT NULL COMMENT 'Conteudo para o qual realmente aponta essa chave',
    PRIMARY KEY (CodMontagem,Chave,CodCaso),
    KEY FK_mescasomontagem_mescaso (CodCaso),
    KEY IDX_ChavePai (ChavePai),
    CONSTRAINT FK_mescasomontagem_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de montagem do caso cl�nico';

CREATE TABLE mescasomontagemconfigs (
    CodConfig int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo da configura��o',
    Nome varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Usado para fazer o label do campo',
    Descricao varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o da configura��o',
    Grupo varchar(20) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Usar para fazer agrupamentos (vai virar fieldsets)',
    Prefixo varchar(3) COLLATE latin1_general_ci NOT NULL COMMENT 'Tipo. txt sel chk etc',
    PRIMARY KEY (CodConfig)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Poss�veis configura��es dos nodos da montagem';

insert into mescasomontagemconfigs (CodConfig, Nome, Descricao, Grupo, Prefixo) values('1','Tipo de escolha','Se o aluno poder� optar por mais de uma op��o ou somente uma','escolha','sel');
insert into mescasomontagemconfigs (CodConfig, Nome, Descricao, Grupo, Prefixo) values('2','Reflex�o','Sobre o que o aluno deve pensar ao ver as op��es','reflexao','txt');
insert into mescasomontagemconfigs (CodConfig, Nome, Descricao, Grupo, Prefixo) values('3','Desvio condicional','Se o aluno chegou a determinado ponto o fluxo do caso pode ser desviado','desvio','sel');

CREATE TABLE mescasomontagemvalconfigs (
    CodCaso int(11) NOT NULL COMMENT 'C�digo do caso',
    CodMontagem int(11) NOT NULL COMMENT 'C�digo da montagem',
    Chave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do item na montagem',
    CodConfig int(11) NOT NULL COMMENT 'C�digo da configura��o',
    Valor varchar(5000) COLLATE latin1_general_ci NOT NULL COMMENT 'Valor configurado',
    PRIMARY KEY (CodCaso,CodMontagem,Chave,CodConfig),
    KEY FK_mescasomontagemvalconfigs_mescasomontagem (CodMontagem,Chave,CodCaso),
    KEY FK_mescasomontagemvalconfigs_mescasomontagemconfigs (CodConfig),
    CONSTRAINT FK_mescasomontagemvalconfigs_mescasomontagem FOREIGN KEY (CodMontagem, Chave, CodCaso) REFERENCES mescasomontagem (CodMontagem, Chave, CodCaso),
    CONSTRAINT FK_mescasomontagemvalconfigs_mescasomontagemconfigs FOREIGN KEY (CodConfig) REFERENCES mescasomontagemconfigs (CodConfig)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Valores configurados para cada uma dos nodos da montagem';

/*
publicar a vwarvorecaso
*/