CREATE TABLE IF NOT EXISTS `mescasoexamesmidia` (
  `CodCaso` int(11) NOT NULL COMMENT 'Código do caso',
  `NumBateria` int(11) NOT NULL,
  `CodExame` int(11) DEFAULT NULL COMMENT 'Código do exame',
  `CodMidia` int(11) NOT NULL COMMENT 'Código da mídia',
  PRIMARY KEY (`CodCaso`,`CodMidia`,`NumBateria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Relação entre exames e mídias';

/*
revisar antes de publicar

ALTER TABLE `mescasoexamesmidia`
  ADD FOREIGN KEY (`CodCaso`, `CodMidia`) REFERENCES `mesmidia` (`CodCaso`, `CodMidia`),
  ADD FOREIGN KEY (`CodExame`, `CodCaso`) REFERENCES `mescasoexames` (`CodCaso`, `CodExame`);
*/

ALTER TABLE mescaso ADD CodAutor INT NOT NULL COMMENT 'Código do autor';

ALTER TABLE mescaso ADD INDEX ( CodAutor );

UPDATE mescaso SET CodAutor = 1;

ALTER TABLE mescaso ADD CONSTRAINT FK_mescaso_mesusuario
FOREIGN KEY (CodAutor) REFERENCES mesusuario (Codigo) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE mescaso ADD Publico TINYINT NOT NULL DEFAULT '0' COMMENT 'Indica se o público será';

CREATE TABLE mescasocolaborador (
	CodCaso INT NOT NULL COMMENT 'Código do Caso',
	CodUsuario INT NOT NULL COMMENT 'Código do Usuário Colaborador do Caso',
	PRIMARY KEY ( CodCaso , CodUsuario )
) ENGINE = INNODB COMMENT = 'Irá apontar as pessoas que colaboram com o caso, com permissão de edição';

ALTER TABLE mescasocolaborador 
ADD CONSTRAINT FK_mescasocolaborador_mescaso FOREIGN KEY ( CodCaso ) REFERENCES mescaso (Codigo);

ALTER TABLE mescasocolaborador 
ADD CONSTRAINT FK_mescasocolaborador_mesusuario FOREIGN KEY ( CodUsuario ) REFERENCES mesusuario (Codigo);

/*
RODAR O CREATE DA vwconteudoscaso
RODAR O CREATE DA vwperguntasalternativas
*/