/*
ALTER TABLE mesusuariologacoes
ADD COLUMN Erro TINYINT NOT NULL DEFAULT 0 COMMENT 'Indica se foi um erro ou não';

CREATE TABLE mestipomidia (
    CodTipo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código do tipo da mídia',
    Descricao varchar(300) COLLATE latin1_general_ci NOT NULL COMMENT 'Descricao da mídia',
    Ativo tinyint(4) NOT NULL COMMENT 'Indica se está ativo para usar ou não',
    PRIMARY KEY (CodTipo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tipos de mídia';

INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Imagem', 1);
INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Vídeo', 1);
INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Hipertexto', 1);
INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Áudio', 1);

CREATE TABLE mesmidia (
	CodCaso int(11) NOT NULL COMMENT 'Código do caso',
	CodMidia bigint(11) NOT NULL COMMENT 'Código identificador da mídida (usado para comparação binaria)',
	Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição da mídia',
	Complemento varchar(500) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Informações complementares',
	CodTipo int(11) NOT NULL COMMENT 'Tipo de mídia',
	DtCadastro datetime NOT NULL COMMENT 'Data de cadastro',
	url varchar(2000) COLLATE latin1_general_ci NOT NULL COMMENT 'url de acesso a midia',
	Largura int(11) DEFAULT NULL COMMENT 'Para os vídeos deve ser informado',
	Altura int(11) DEFAULT NULL COMMENT 'Para os vídeos deve ser informado',
	Origem varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Origem da mídia (banco, upload, web)',
	PRIMARY KEY (CodMidia,CodCaso),
	KEY FK_mesmidia (CodTipo),
	KEY idx_mesmidia_url (CodCaso,url(767)),
	CONSTRAINT FK_mesmidia FOREIGN KEY (CodTipo) REFERENCES mestipomidia (CodTipo),
	CONSTRAINT FK_mesmidia_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de mídias'

CREATE TABLE siscachetipoconsulta (
    CodTipo int(11) NOT NULL COMMENT 'Código do tipo da consulta',
    Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição do tipo de consulta',
    DataHora datetime NOT NULL COMMENT 'Data e hora do cache',
    PRIMARY KEY (CodTipo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Cache dos tipos de pesquisa do banco de imagens';

CREATE TABLE siscachesubtipoconsulta (
    CodTipo int(11) NOT NULL COMMENT 'Código do tipo ao qual o subtipo está vinculado',
    CodSubTipo int(11) NOT NULL COMMENT 'Código do subtipo da consulta',
    DescricaoSubTipo varchar(400) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição do subtipo',
     DataHora datetime NOT NULL COMMENT 'Data e hora do cache',
     PRIMARY KEY (CodTipo,CodSubTipo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Cache dos subtipos de pesquisa';

CREATE TABLE mestipomidiaextensao (                                                                                                                    
    CodTipoMidia int(11) NOT NULL COMMENT 'Código da mídia',                                                                                           
    Extensao varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Extensão do arquivo',                                                              
    Icone varchar(300) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Icone do tipo de arquivo',                                                        
    TamMaxUpload double NOT NULL COMMENT 'Tamanho máximo do upload',                                                                                    
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
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('4','mp3',NULL,'5000','Arquivo de áudio');
insert into mestipomidiaextensao (CodTipoMidia, Extensao, Icone, TamMaxUpload, Descricao) values('4','wav',NULL,'5000','Arquivo de áudio');

CREATE TABLE mestipoitem (
    Codigo varchar(15) COLLATE latin1_general_ci NOT NULL COMMENT 'Código dos tipos de itens da montagem',
    Descricao varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição dos tipos de itens da montagem',
    PRIMARY KEY (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tipos de itens da montagem';

insert into mestipoitem (Codigo, Descricao) values('an','Anamnese');
insert into mestipoitem (Codigo, Descricao) values('des','Desfecho');
insert into mestipoitem (Codigo, Descricao) values('diag','Diagnósticos');
insert into mestipoitem (Codigo, Descricao) values('optex','Opções de exames');
insert into mestipoitem (Codigo, Descricao) values('resex','Resultados de exames');
insert into mestipoitem (Codigo, Descricao) values('exfis','Exame físico');
insert into mestipoitem (Codigo, Descricao) values('grupo-perg','Grupo de exercícios');
insert into mestipoitem (Codigo, Descricao) values('hip','Hipóteses diagnósticas');
insert into mestipoitem (Codigo, Descricao) values('html','Conteudo HTML');
insert into mestipoitem (Codigo, Descricao) values('img','Imagem');
insert into mestipoitem (Codigo, Descricao) values('perg','Exercício');
insert into mestipoitem (Codigo, Descricao) values('raiz','Caso de estudo');
insert into mestipoitem (Codigo, Descricao) values('trat','Tratamento');
*/
/* verificar as permissões já existentes no banco antes de inserir essa nova permissão */

/*
INSERT INTO mespermissao(Descricao) values('Cadastrar imagens no caso');

CREATE TABLE mesexamefisicoetapas (
    Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código da etapa do exame físico',
    Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição da etapa do exame físico',
    PRIMARY KEY (Codigo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Etapas do exame físico';

insert into mesexamefisicoetapas (Codigo, Descricao) values('1','Cabeça');
insert into mesexamefisicoetapas (Codigo, Descricao) values('2','Pescoço');
insert into mesexamefisicoetapas (Codigo, Descricao) values('3','Ausculta pulmonar');
insert into mesexamefisicoetapas (Codigo, Descricao) values('4','Ausculta cardíaca');
insert into mesexamefisicoetapas (Codigo, Descricao) values('5','Abdomen');
insert into mesexamefisicoetapas (Codigo, Descricao) values('6','Extremidades');
insert into mesexamefisicoetapas (Codigo, Descricao) values('7','Pele');
insert into mesexamefisicoetapas (Codigo, Descricao) values('8','Sinais vitais');

ALTER TABLE mescasoexamefisico
ADD COLUMN midCabeca BIGINT NOT NULL COMMENT 'Soma dos códigos das mídias vinculadas a cabeça',
ADD COLUMN midPescoco bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas ao pescoço',
ADD COLUMN midAusPulmonar bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas a ausculta pulmonar',
ADD COLUMN midAusCardiaca bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas a ausculta cardiaca',
ADD COLUMN midSinaisVitais bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas aos sinais vitais',
ADD COLUMN midAbdomen bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas ao abdobem',
ADD COLUMN midPele bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas a pele',
ADD COLUMN midExtremidades bigint(20) NOT NULL DEFAULT 0 COMMENT 'Soma dos códigos das mídias vinculadas as extremidades';

ALTER TABLE mesacessousuario
ADD COLUMN Navegador VARCHAR(1000) NULL COMMENT 'Tipo de navegador do usuário';

ALTER TABLE mesmidia
ADD COLUMN Origem VARCHAR(100) NULL COMMENT 'Origem da mídia (banco, upload, web)';
*/

CREATE TABLE mescasomontagem (
    CodCaso int(11) NOT NULL COMMENT 'Código do caso',
    CodMontagem int(11) NOT NULL COMMENT 'Código da montagem (pode ter mais de uma)',
    Chave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave grande individual',
    TipoConteudo varchar(15) COLLATE latin1_general_ci NOT NULL COMMENT 'O tipo de conteudo que pode ser adicionado (hip, trat, exafis, etc...)',
    Ordem int(11) NOT NULL COMMENT 'Ordenação',
    ChavePai varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Chave do item pai',
    Organizador varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT '???',
    ContReferencia int(11) NOT NULL COMMENT 'Conteudo para o qual realmente aponta essa chave',
    PRIMARY KEY (CodMontagem,Chave,CodCaso),
    KEY FK_mescasomontagem_mescaso (CodCaso),
    KEY IDX_ChavePai (ChavePai),
    CONSTRAINT FK_mescasomontagem_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de montagem do caso clínico';

CREATE TABLE mescasomontagemconfigs (
    CodConfig int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código da configuração',
    Nome varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Usado para fazer o label do campo',
    Descricao varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição da configuração',
    Grupo varchar(20) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Usar para fazer agrupamentos (vai virar fieldsets)',
    Prefixo varchar(3) COLLATE latin1_general_ci NOT NULL COMMENT 'Tipo. txt sel chk etc',
    PRIMARY KEY (CodConfig)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Possíveis configurações dos nodos da montagem';

insert into mescasomontagemconfigs (CodConfig, Nome, Descricao, Grupo, Prefixo) values('1','Tipo de escolha','Se o aluno poderá optar por mais de uma opção ou somente uma','escolha','sel');
insert into mescasomontagemconfigs (CodConfig, Nome, Descricao, Grupo, Prefixo) values('2','Reflexão','Sobre o que o aluno deve pensar ao ver as opções','reflexao','txt');
insert into mescasomontagemconfigs (CodConfig, Nome, Descricao, Grupo, Prefixo) values('3','Desvio condicional','Se o aluno chegou a determinado ponto o fluxo do caso pode ser desviado','desvio','sel');

CREATE TABLE mescasomontagemvalconfigs (
    CodCaso int(11) NOT NULL COMMENT 'Código do caso',
    CodMontagem int(11) NOT NULL COMMENT 'Código da montagem',
    Chave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do item na montagem',
    CodConfig int(11) NOT NULL COMMENT 'Código da configuração',
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