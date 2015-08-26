CREATE TABLE mesresolucaosituacao (                                                                                                                                               
	CodSituacao int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código do status da resolução',                                                                                         
	Descricao varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Descrição do status de resolução',                                                                       
	PRIMARY KEY (CodSituacao)                                                                                                                                                       
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Status de resolução do caso clínico';

insert into mesresolucaosituacao (CodSituacao, Descricao) values('1','Não iniciado');
insert into mesresolucaosituacao (CodSituacao, Descricao) values('2','Iniciado');
insert into mesresolucaosituacao (CodSituacao, Descricao) values('3','Concluído');


CREATE TABLE mesresolucao (
	CodResolucao int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código da resolução',
	CodCaso int(11) NOT NULL COMMENT 'Código do caso',
	CodUsuario int(11) NOT NULL COMMENT 'Código do usuário que está resolvendo',
	DataInicio datetime DEFAULT NULL COMMENT 'Data de início',
	DataFim datetime DEFAULT NULL COMMENT 'Data de fim da resolução',
	CodSituacao int(11) DEFAULT NULL COMMENT 'Código da situação da resolução',
	PRIMARY KEY (CodResolucao,CodCaso,CodUsuario),
	UNIQUE KEY CodResolucao (CodResolucao),
	KEY FK_mesresolucao_mescaso (CodCaso),
	KEY FK_mesresolucao_mesusuario (CodUsuario),
	KEY FK_mesresolucao_mesresolucaosituacao (CodSituacao),
	CONSTRAINT FK_mesresolucao_mescaso FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo),
	CONSTRAINT FK_mesresolucao_mesresolucaosituacao FOREIGN KEY (CodSituacao) REFERENCES mesresolucaosituacao (CodSituacao),
	CONSTRAINT FK_mesresolucao_mesusuario FOREIGN KEY (CodUsuario) REFERENCES mesusuario (Codigo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Resolução do caso por parte do aluno'

CREATE TABLE mesresolucaoacesso (
	CodResolucao int(11) NOT NULL COMMENT 'Código da resolução',
	CodAcesso int(11) NOT NULL COMMENT 'Código do acesso',
	PRIMARY KEY (CodResolucao,CodAcesso),
	KEY FK_mesresolucaoacesso_mesacessousuario (CodAcesso),
	CONSTRAINT FK_mesresolucaoacesso_mesacessousuario FOREIGN KEY (CodAcesso) REFERENCES mesacessousuario (NumAcesso),
	CONSTRAINT FK_mesresolucaoacesso_mesresolucao FOREIGN KEY (CodResolucao) REFERENCES mesresolucao (CodResolucao)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Registra os acesso diferentes a uma resolução de caso clínico';

CREATE TABLE mesresolucaoresposta (
	Identificador int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador sequencial',
	CodResolucao int(11) NOT NULL COMMENT 'Número da resolução',
	CodAcesso int(11) NOT NULL COMMENT 'Código do acesso da resposta',
	ChaveItem varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do conteúdo na montagem',
	CodPergunta int(11) DEFAULT NULL COMMENT 'Código da pergunta caso for uma resposta de uma pergunta',
	NumTentativa int(11) NOT NULL COMMENT 'Número da tentativa',
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
	CodItemMenu int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código sequencial do item de menu',
	Texto varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Texto que vai aparecer no title do botão',
	Imagem varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Caminho da imagem do botão',
	Acao varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Conteúdo do onClick do item',
	Telas bigint(20) NOT NULL COMMENT 'Soma dos códigos miraculosos das etapas que devem apresentar o menu conforme tabela mestipoitem',
	PRIMARY KEY (CodItemMenu)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Itens do menu das etapas de resolução';

insert into mesresolucaomenu (CodItemMenu, Texto, Imagem, Acao, Telas) values('1','Voltar','img/esquerda.png','javascript:fntAnterior();','32766');
insert into mesresolucaomenu (CodItemMenu, Texto, Imagem, Acao, Telas) values('2','Avançar','img/direita.png','javascript:fntProximo();','32511');
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
ADD COLUMN CodBinario INT NOT NULL DEFAULT 0 COMMENT 'Código para fazer as comparações binarias';