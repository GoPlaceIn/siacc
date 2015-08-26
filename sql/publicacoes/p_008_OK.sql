ALTER TABLE mescasomontagemconfigs
MODIFY Grupo BIGINT NOT NULL DEFAULT 0 COMMENT 'Usar para fazer agrupamentos (o que mostra em que tipo)';

CREATE TABLE mescasomontagemsaltos (
	CodCaso int(11) NOT NULL COMMENT 'Código do caso',
	CodMontagem int(11) NOT NULL COMMENT 'Código da montagem do caso',
	ChaveAtual varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave na qual o aluno está atualmente',
	ChaveDestino varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave para qual o aluno deve ser direcionado',
	ChaveCond varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Chave para testar condição',
	CodPergunta INT(11) NULL COMMENT 'Código da pergunta se existir',
	RespostaCond bigint(20) DEFAULT NULL COMMENT 'Respostas que satisfazem a condição (and binário)',
	PRIMARY KEY (CodCaso,CodMontagem,ChaveAtual,ChaveDestino),
	KEY FK_mescasomontagemsaltos (CodMontagem,ChaveAtual,CodCaso),
	KEY FK_mescasomontagemsaltos_mespergunta (CodPergunta),
	CONSTRAINT FK_mescasomontagemsaltos_mespergunta FOREIGN KEY (CodPergunta) REFERENCES mespergunta (Codigo),
	CONSTRAINT FK_mescasomontagemsaltos FOREIGN KEY (CodMontagem, ChaveAtual, CodCaso) REFERENCES mescasomontagem (CodMontagem, Chave, CodCaso)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de saltos'

DROP TABLE IF EXISTS `mesalternativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesalternativa` (
  `CodPergunta` int(11) NOT NULL COMMENT 'Código da pergunta',
  `Sequencia` int(11) NOT NULL COMMENT 'Sequencia da pergunta',
  `Texto` varchar(1000) COLLATE latin1_general_ci NOT NULL COMMENT 'Texto da alternativa',
  `Imagem` varchar(1000) COLLATE latin1_general_ci NOT NULL COMMENT 'Caminho da imagem da alternativa',
  `Correto` int(11) NOT NULL COMMENT 'Indica se a alternativa é correta ou não',
  `Explicacao` varchar(5000) COLLATE latin1_general_ci NOT NULL COMMENT 'Explicação do porque está certo ou errado',
  `ExibirExplicacao` int(11) DEFAULT NULL COMMENT 'Indica qual o comportamento necessário para exibir a explicação ou não',
  `TipoConsequencia` int(11) DEFAULT '1' COMMENT 'Se deve ir para uma questão específica, seguir adiante ou mostrar ajuda.',
  `ValorConsequencia` int(11) DEFAULT '0' COMMENT 'Codigo da ProximaPergunta, PerguntaApoio ou 0',
  `CodUnico` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código sequencial das alternativas',
  `CodBinario` int(11) NOT NULL DEFAULT '0' COMMENT 'Código para fazer as comparações binarias',
  PRIMARY KEY (`CodUnico`),
  CONSTRAINT `FK_mesalternativa_mespergunta` FOREIGN KEY (`CodPergunta`) REFERENCES `mespergunta` (`Codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesalternativa`
--

LOCK TABLES `mesalternativa` WRITE;
/*!40000 ALTER TABLE `mesalternativa` DISABLE KEYS */;
INSERT INTO `mesalternativa` VALUES (9,1,'Rim direito','files/perg/9/imgs/66FF9121ACD638253C7BE5FDCA97386D.jpg',0,'Este rim é sadio',1,1,0,1,1),(9,2,'Rim direito','files/perg/9/imgs/527B6C914520E2C6AA25D0622FC3E602.jpg',1,'Parabéns. Você acertou.',1,1,0,2,2),(10,1,'Rim direito','files/perg/10/imgs/6F7A105EA493B15FE72DEA89DF76AC0A.jpg',0,'Este rim não apresenta sinais de cálculo renal',1,1,0,3,1),(10,2,'Rim direito','files/perg/10/imgs/B15AF16B506F185342FD80A5D9E34283.jpg',1,'É possível observar a sombra do cálculo projetada na imagem',1,2,6,4,2),(11,1,'Alterando e colocando um texto mair ele vai ficar assim. Isso ai do lado é só uma prévia do texto.','',0,'<p>adfaf. alterando aqui</p>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,5,1),(12,1,'Normocítica e normocrômica','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,6,1),(12,2,'Microcítica e hipocrômica','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,7,2),(12,3,'Microcítica e normocrômica','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,8,4),(12,4,'Macrocítica e normocrômica','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,9,8),(12,5,'Normocítica e hipocrômica','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,10,16),(12,6,'Macrocítica e hipocrômica','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,11,32),(13,1,'Aumentado','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,12,1),(13,2,'Reduzido','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,13,2),(14,1,'Aumentado','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,14,1),(14,2,'Reduzido','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,15,2),(15,1,'Aumentada','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,16,1),(15,2,'Reduzida','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,17,2),(16,1,'Nefrite intersticial','',0,'<p>Doen&ccedil;as tubulointersticiais variam de apresenta&ccedil;&atilde;o de insufici&ecirc;ncia renal aguda a disfun&ccedil;&atilde;o renal cr&ocirc;nica que se manifestam como insufici&ecirc;ncia renal leve assintom&aacute;tica.</p>\r\n<p>As causas mais comuns de nefrite tubulointersticial s&atilde;o:</p>\r\n<ul>\r\n<li>Necrose tubular isqu&ecirc;mica</li>\r\n<li>Nefrite intersticial al&eacute;rgica</li>\r\n<li>Nefrite intersticial secund&aacute;ria a complexo auto-imune: colagenos, como doen&ccedil;a de Sj&ouml;gren ou Lupus Critomatoso Sist&ecirc;mico</li>\r\n</ul>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,18,1),(16,2,'Nefroesclerose hipertensiva','',1,'<p>Nefroesclerose hipertensiva &eacute; um dist&uacute;rbio que &eacute; geralmente associada com hipertens&atilde;o cr&ocirc;nica. Pacientes com nefroesclerose normalmente apresentam uma longa hist&oacute;ria de hipertens&atilde;o lentamente progressiva, eleva&ccedil;&otilde;es de ur&eacute;ia e creatinina plasm&aacute;tica e protein&uacute;ria leve. Negros com essas caracteristicas cl&iacute;nicas s&atilde;o particularmente propensos a ter nefroesclerose subjacente.</p>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,19,2),(16,3,'Glomerulonefrite crônica','',0,'<p>Existem doen&ccedil;as prim&aacute;rias renais ou secund&aacute;rias &agrave; doen&ccedil;as sist&ecirc;micas (devido a auto-imunidade com deposi&ccedil;&atilde;o de imuno-complexos, anormalidades gen&eacute;ticas e infec&ccedil;&otilde;es como a hepatite C ou HIV) que podem produzir doen&ccedil;a glomerular.</p>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,20,4),(16,4,'Doença Vascular Renal','',0,'<p>Doen&ccedil;as micro e macrovasculares.</p>\r\n<p>- Microvascular: Incorreta - Doen&ccedil;as que causam a oclus&atilde;o transit&oacute;ria ou permanente da microvasculatura renal uniformemente pode resultar na interrup&ccedil;&atilde;o da perfus&atilde;o glomerular e, portanto, da taxa de filtra&ccedil;&atilde;o glomerular, constituindo uma s&eacute;ria amea&ccedil;a &agrave; homeostase sist&ecirc;mica. Incluem-se neste grupo: s&iacute;ndrome hemol&iacute;tico ur&ecirc;mica, p&uacute;rpura trombocitop&ecirc;nica, envolvimento renal anemia falciforme, nefrite por radia&ccedil;&atilde;o, doen&ccedil;a ateroemb&oacute;lica.</p>\r\n<p>- Macrovascular: Incorreta - Oclus&otilde;es da art&eacute;ria renal (traum&aacute;ticas e n&atilde;o traum&aacute;ticas), oclus&atilde;o de veia renal, aneurisma de art&eacute;ria renal, trombose de veia renal (que ocorre com maior frequ&ecirc;ncia na sindrome nefr&oacute;tica associada a estado de hipercoagulabilidade).</p>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,21,8),(16,5,'Diabetes','',0,'<p>Glomeruloesclerose diab&eacute;tica &eacute; considerada uma das complica&ccedil;&otilde;es microvasculares do diabetes, ocorrendo em 10-20% dos diab&eacute;ticos tipo 2 e 30-40% dos diab&eacute;ticos tipo 1 ap&oacute;s 7-10 anos de doen&ccedil;a e costuma evoluir desde a microalbumin&uacute;ria at&eacute; protein&uacute;ria nefr&oacute;tica que evolui para doen&ccedil;a renal cr&ocirc;nica terminal.</p>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,22,16),(16,6,'Uropatia Obstrutiva','',0,'<p>Uropatia obstrutiva ocorre quando um defeito estrutural ou funcional do trato urin&aacute;rio interrompe ou atenua o fluxo de urina. Uropatia obstrutiva pode prejudicar a fun&ccedil;&atilde;o renal e levar &agrave; nefropatia obstrutiva. Obstru&ccedil;&atilde;o urin&aacute;ria pode ocorrer em qualquer local da pelve renal at&eacute; a uretra.</p>\r\n<!--txtJustTxt-->',NULL,NULL,NULL,23,32),(17,1,'Correto','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,24,1),(17,2,'Errado','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,25,2),(18,1,'Correto','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,26,1),(18,2,'Errado','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,27,2),(19,1,'Correto','',1,'<!--txtJustTxt-->',NULL,NULL,NULL,28,1),(19,2,'Errado','',0,'<!--txtJustTxt-->',NULL,NULL,NULL,29,2),(20,1,'Alternativa A','',1,'<p>&ccedil;ladsf&ccedil;lajfd</p>',NULL,NULL,NULL,30,1);
/*!40000 ALTER TABLE `mesalternativa` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS mesresolucaovisconteudo;

CREATE TABLE mesresolucaovisconteudo (
	CodVisita int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código sequencial da visita ao nodo',
	CodResolucao int(11) NOT NULL COMMENT 'Código da resolução',
	CodAcesso int(11) NOT NULL COMMENT 'Código do acesso',
	CodCaso int(11) NOT NULL COMMENT 'Código do caso clínico',
	CodMontagem int(11) NOT NULL COMMENT 'Código da montagem',
	CodChave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave do nodo',
	DataHora datetime NOT NULL COMMENT 'Data hora que o nodo foi visto',
	SoControle smallint(6) NOT NULL DEFAULT '0' COMMENT 'Coluna para saber se um conteúdo de um agrupador foi exibido',
	PRIMARY KEY (CodVisita),
	KEY FK_mesresolucaovisconteudo_mescasomontagem (CodMontagem,CodChave,CodCaso),
	KEY FK_mesresolucaovisconteudo_mesresolucaoacesso (CodResolucao,CodAcesso),
	KEY IDX_mesresolucaovisconteudo_DataHora (DataHora),
	CONSTRAINT FK_mesresolucaovisconteudo_mescasomontagem FOREIGN KEY (CodMontagem, CodChave, CodCaso) REFERENCES mescasomontagem (CodMontagem, Chave, CodCaso),
	CONSTRAINT FK_mesresolucaovisconteudo_mesresolucaoacesso FOREIGN KEY (CodResolucao, CodAcesso) REFERENCES mesresolucaoacesso (CodResolucao, CodAcesso)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Registro das visalizações de conteudo do caso';

ALTER TABLE mesalternativa
ADD Origem VARCHAR(100) NULL COMMENT 'Upload ou do banco de imagens';

INSERT INTO mestipomidia(Descricao, Ativo) VALUES('Documento', 1);

UPDATE mestipomidiaextensao
SET CodTipoMidia = 5
WHERE Extensao IN('doc','docx','pdf');

INSERT INTO mestipomidiaextensao(CodTipoMidia, Extensao, TamMaxUpload, Descricao)
VALUES(5, 'ppt', 3000, 'Apresentação do Power Point');

insert into mestipoitem values('doc','Documento',32768);

UPDATE mescasomontagemconfigs
SET Nome = 'So exames selecionados', Descricao = 'Mostrar somente os resultados dos exames selecionados nas opções de exames associados', Grupo = 32
WHERE CodConfig = 3;

UPDATE mescasomontagemconfigs SET Grupo = 65528 WHERE CodConfig = 2;
UPDATE mescasomontagemconfigs SET Grupo = 40480 WHERE CodConfig = 4;
UPDATE mescasomontagemconfigs SET Grupo = 65534 WHERE CodConfig = 5;

INSERT INTO mescasomontagemconfigs(Nome, Descricao, Grupo, Prefixo)
VALUES('Não é o fim do caso','Configuração aplicavel aos desfechos. Estes por padrão são fim de caso',256,'chk');

ALTER TABLE mescasoexames
MODIFY NumBateria INT NULL COMMENT 'Bateria de exames: 1, 2, 3... (não usado)';