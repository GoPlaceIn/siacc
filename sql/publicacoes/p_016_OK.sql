update mesitensmenu set Texto = 'Cadastros' where Codigo = 2;

insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Usuários', 'javascript:void(0);', 7, 2, 1);

update mesitensmenu set CodItemPai = 39 where Codigo IN(5, 4, 14);

insert into mespermissao(Descricao) values('Cadastrar instituições de ensino');

insert into mespermissao(Descricao) values('Consultar instituições de ensino');

/*
QUANDO PUBLICAR RODAR UM UPDATE NO ITEM 40 AO INVES DE INSERIR O ITEM ABAIXO
*/

/*
insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Instituições', 'javascript:void(0);', 28, 2, 1);
*/
UPDATE mesitensmenu set Texto = 'Instituições', CodPermissao = 28 where Codigo = 40


insert into mestemplates(Arquivo, Classe, Descricao, CodPermissao, jsLoad, linkNovoRegistro, linkSalva, linkVolta)
values('tpl/cad-instituicoes.html', 'Instituicao', 'Template do cadastro de instituições', 28, '', '', 'fntGravaInstituicao();', 'fntVoltar();');

insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Lista', 'listagem.php?t=13', 28, 40, 1);

insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Cadastro', 'cadastro.php?t=13', 27, 40, 2);

CREATE TABLE mespaises (
	Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código do país',
	Nome varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Nome do país',
	PRIMARY KEY (Codigo),
	KEY IDX_mespaises_nome (Nome)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Cadastro de países'

insert into mespaises(Nome) values('Brasil');

insert into mespaises(Nome) values('Argentina');

insert into mespaises(Nome) values('Uruguai');

insert into mespaises(Nome) values('Paraguai');

insert into mespaises(Nome) values('Chile');

insert into mespaises(Nome) values('Venezuela');

CREATE TABLE mesinstituicao (
	Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código da instituição',
	NomeCompleto varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Nome completo da instiuição',
	Sigla varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Sigla da instituição',
	NomeResponsavel varchar(300) COLLATE latin1_general_ci NOT NULL COMMENT 'Nome do responsavel pelo SIACC na instituição',
	EmailResponsavel varchar(300) COLLATE latin1_general_ci NOT NULL COMMENT 'Email do responsavel',
	FoneResponsavel varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Telefone do responsavel',
	Endereco varchar(500) COLLATE latin1_general_ci NOT NULL COMMENT 'Endereço da instituição',
	Complemento varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Complemento',
	Numero varchar(20) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Número da instituição',
	Bairro varchar(200) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Nome do bairro',
	Cidade varchar(400) COLLATE latin1_general_ci NOT NULL COMMENT 'Cidade da instituição',
	UF varchar(2) COLLATE latin1_general_ci NOT NULL COMMENT 'Estado da instituição',
	Pais int(11) NOT NULL COMMENT 'Código do país da instituição',
	FoneContato varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Telefone da instituição',
	Site varchar(500) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Site da instituição',
	Email varchar(300) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Email da instituição',
	ObrigaEmail tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Se os alunos devem ter obrigatóriamento email da instituição',
	DominioEmail varchar(300) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Domínio do email',
	Ativo tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Se a instituição está ativa ou não',
	DtCadastro datetime NOT NULL COMMENT 'Data/hora de cadastro',
	CodUsuario int(11) NOT NULL COMMENT 'Usuário que cadastrou',
	CEP varchar(15) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'CEP da instituição',
	PRIMARY KEY (Codigo),
	KEY FK_mesinstituicao_mesusuario (CodUsuario),
	KEY FK_mesinstituicao_mespaises (Pais),
	CONSTRAINT FK_mesinstituicao_mespaises FOREIGN KEY (Pais) REFERENCES mespaises (Codigo),
	CONSTRAINT FK_mesinstituicao_mesusuario FOREIGN KEY (CodUsuario) REFERENCES mesusuario (Codigo)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Cadastro de instituições de ensino'

alter table mesusuario
add column CodInstituicao int not null comment 'Código da instituição';

UPDATE mesusuario set CodInstituicao = 1;

CREATE INDEX IX_mesusuario_CodInstituicao ON mesusuario (CodInstituicao ASC);

alter table mesusuario
add constraint FK_mesusuario_mesinstituicao FOREIGN KEY (CodInstituicao)
REFERENCES mesinstituicao (Codigo)

update mesarea set Ativo = 0 where Codigo not like '4%'

CREATE TABLE sisparametros (                                                                                                                              
    Nome varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Nome do parametro do sistema',
    Valor varchar(1000) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Valor do parametro',
    PRIMARY KEY (Nome)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela de parametros do sistema'

insert into sisparametros values('URLWebServiceSIAP', 'http://200.18.67.61/siap/ws/siap_ws.php?wsdl');

insert into sisparametros values('URLSIAP', 'http://200.18.67.61/siap/');

update mesitensmenu set Texto = 'Exercícios' where Codigo in(20, 37);

update mesitensmenu set Texto = 'Classes de exercícios' where Codigo = 27;

alter table mescasoconteudo add column DtCadastro datetime comment 'Data de cadastro do conteúdo';

update mescasoconteudo set DtCadastro = '2012-08-01 10:00:00' where DtCadastro is null;

alter table mestemplates
add column QtdPadListagem int not null default 15 comment 'Quantidade default de registros por página';

update mestemplates set QtdPadListagem = 10 where Codigo = 10;

update mesitensmenu set link = 'javascript:fntHelp();' where codigo = 30