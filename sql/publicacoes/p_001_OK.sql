insert into mespermissao(Descricao)
values('Consultar acessos ao sistema');

insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Listar acessos', 'vwacessos.php', 22, 2, 4);

insert into mesgrupopermissao(CodGrupoUsuario, CodPermissao, Ativo)
values(1, 22, 1);

CREATE TABLE mesusuariologacoes
(
	Contador int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código automático de acesso',
	CodAcesso int(11) NOT NULL COMMENT 'Código de acesso do usuário',
	Acao varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Ação realizada pelo usuário',
	DataHora datetime NOT NULL COMMENT 'Data e Hora da ação',
	PRIMARY KEY (Contador),
	KEY FK_mesusuariologacoes (CodAcesso),
	CONSTRAINT FK_mesusuariologacoes FOREIGN KEY (CodAcesso) REFERENCES mesacessousuario (NumAcesso)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Log de Ações dos alunos';
