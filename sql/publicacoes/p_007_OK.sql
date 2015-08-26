CREATE TABLE mesresolucaosituacao (                                                                                                                                               
	CodSituacao int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo do status da resolu��o',                                                                                         
	Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descri��o do status de resolu��o',                                                                       
	PRIMARY KEY (CodSituacao)                                                                                                                                                       
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Status de resolu��o do caso cl�nico';

insert into mesresolucaosituacao (CodSituacao, Descricao) values('1','N�o iniciado');
insert into mesresolucaosituacao (CodSituacao, Descricao) values('2','Iniciado');
insert into mesresolucaosituacao (CodSituacao, Descricao) values('3','Conclu�do');


CREATE TABLE mesresolucao (
	CodResolucao int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo da resolu��o',
	CodCaso int(11) NOT NULL COMMENT 'C�digo do caso',
	CodUsuario int(11) NOT NULL COMMENT 'C�digo do usu�rio que est� resolvendo',
	DataInicio datetime DEFAULT NULL COMMENT 'Data de in�cio',
	DataFim datetime DEFAULT NULL COMMENT 'Data de fim da resolu��o',
	CodSituacao int(11) DEFAULT NULL COMMENT 'C�digo da situa��o da resolu��o',
	PRIMARY KEY (CodResolucao,CodCaso,CodUsuario),
	UNIQUE KEY CodResolucao (CodResolucao),
	KEY FK_mesresolucao_mescaso (CodCaso),
	KEY FK_mesresolucao_mesusuario (CodUsuario),
	KEY FK_mesresolucao_mesresolucaosituacao (CodSituacao),
	CONSTRAINT FK_mesresolucao_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo),
	CONSTRAINT FK_mesresolucao_mesresolucaosituacao FOREIGN KEY (CodSituacao) REFERENCES mesresolucaosituacao (CodSituacao),
	CONSTRAINT FK_mesresolucao_mesusuario FOREIGN KEY (CodUsuario) REFERENCES mesusuario (Codigo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Resolu��o do caso por parte do aluno'

CREATE TABLE mesresolucaoacesso (
	CodResolucao int(11) NOT NULL COMMENT 'C�digo da resolu��o',
	CodAcesso int(11) NOT NULL COMMENT 'C�digo do acesso',
	PRIMARY KEY (CodResolucao,CodAcesso),
	KEY FK_mesresolucaoacesso_mesacessousuario (CodAcesso),
	CONSTRAINT FK_mesresolucaoacesso_mesacessousuario FOREIGN KEY (CodAcesso) REFERENCES mesacessousuario (NumAcesso),
	CONSTRAINT FK_mesresolucaoacesso_mesresolucao FOREIGN KEY (CodResolucao) REFERENCES mesresolucao (CodResolucao)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Registra os acesso diferentes a uma resolu��o de caso cl�nico';

CREATE TABLE mesresolucaoresposta (
	Identificador int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador sequencial',
	CodResolucao int(11) NOT NULL COMMENT 'N�mero da resolu��o',
	CodAcesso int(11) NOT NULL COMMENT 'C�digo do acesso da resposta',
	ChaveItem varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do conte�do na montagem',
	CodPergunta int(11) DEFAULT NULL COMMENT 'C�digo da pergunta caso for uma resposta de uma pergunta',
	NumTentativa int(11) NOT NULL COMMENT 'N�mero da tentativa',
	Resposta bigint(20) NOT NULL COMMENT 'Resposta do aluno',
	PRIMARY KEY (Identificador),
	KEY FK_mesresolucaoresposta_mesresolucao (CodResolucao),
	KEY FK_mesresolucaoresposta_mesacessousuario (CodAcesso),
	KEY FK_mesresolucaoresposta_mespergunta (CodPergunta),
	CONSTRAINT FK_mesresolucaoresposta_mespergunta FOREIGN KEY (CodPergunta) REFERENCES mespergunta (Codigo),
	CONSTRAINT FK_mesresolucaoresposta_mesacessousuario FOREIGN KEY (CodAcesso) REFERENCES mesacessousuario (NumAcesso),
	CONSTRAINT FK_mesresolucaoresposta_mesresolucao FOREIGN KEY (CodResolucao) REFERENCES mesresolucao (CodResolucao)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Respostas dos alunos';

CREATE TABLE mesresolucaomenu (
	CodItemMenu int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo sequencial do item de menu',
	Texto varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Texto que vai aparecer no title do bot�o',
	Imagem varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Caminho da imagem do bot�o',
	Acao varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Conte�do do onClick do item',
	Telas bigint(20) NOT NULL COMMENT 'Soma dos c�digos miraculosos das etapas que devem apresentar o menu conforme tabela mestipoitem',
	PRIMARY KEY (CodItemMenu)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Itens do menu das etapas de resolu��o';

insert into mesresolucaomenu (CodItemMenu, Texto, Imagem, Acao, Telas) values('1','Voltar','img/esquerda.png','javascript:fntAnterior();','32766');
insert into mesresolucaomenu (CodItemMenu, Texto, Imagem, Acao, Telas) values('2','Avan�ar','img/direita.png','javascript:fntProximo();','32511');
insert into mesresolucaomenu (CodItemMenu, Texto, Imagem, Acao, Telas) values('3','Verificar resposta','img/corrige.png','javascript:fntAvaliar();','24792');


ALTER TABLE mescasoconteudo
ADD CONSTRAINT FK_mescasoconteudo_mescaso foreign key (CodCaso) references mescaso (Codigo) 
ON DELETE NO ACTION 
ON UPDATE NO ACTION;

ALTER TABLE mesalternativa
ADD CONSTRAINT FK_mesalternativa_mespergunta FOREIGN KEY (CodPergunta) REFERENCES mespergunta (Codigo)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE mesalternativa
ADD COLUMN CodBinario INT NOT NULL DEFAULT 0 COMMENT 'C�digo para fazer as compara��es binarias';