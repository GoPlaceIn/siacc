/*
## NÃO PUBLICADO ##
alter table mesusuario
add NomeInstit varchar(2000) null comment 'Nome da instituição de ensino',
add SiglaInstit varchar(20) null comment 'Sigla da instituição de ensino',
add UFInstit varchar(2) null comment 'Estado da instituição de ensino',
add CidadeInstit varchar(300) null comment 'Nome da cidade da instituição de ensino',
add OrigemCadastro smallint null not null default 1 comment 'Local de origem do cadastro (1 = Admin / 2 = Aluno)';
*/

/* DAQUI EM DIANTE PUBLICADO EM 12/10/12 */

create table mesestados
(
	Sigla varchar(2) not null primary key comment 'Sigla do estado',
	Descricao varchar(500) not null comment 'Nome do estado'
)

INSERT INTO mesestados(Descricao, Sigla) VALUES('Acre', 'AC');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Alagoas', 'AL');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Amapá', 'AP');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Amazonas', 'AM');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Bahia', 'BA');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Ceará', 'CE');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Distrito Federal', 'DF');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Espírito Santo', 'ES');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Goiás', 'GO');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Maranhão', 'MA');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Mato Grosso', 'MT');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Mato Grosso do Sul', 'MS');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Minas Gerais', 'MG');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Pará', 'PA');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Paraíba', 'PB');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Paraná', 'PR');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Pernambuco', 'PE');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Piauí', 'PI');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rio de Janeiro', 'RJ');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rio Grande do Norte', 'RN');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rio Grande do Sul', 'RS');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rondônia', 'RO');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Roraima', 'RR');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Santa Catarina', 'SC');
INSERT INTO mesestados(Descricao, Sigla) VALUES('São Paulo', 'SP');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Sergipe', 'SE');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Tocantins', 'TO');