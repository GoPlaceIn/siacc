alter table mesusuario
add column CodIdioma int not null default 1 comment 'Idioma do usuário';

alter table mesusuario
add constraint FK_mesusuario_sisidiomas
foreign key (CodIdioma) references sisidiomas(Codigo);

/* Tem que gerar o código 29 */
insert into mespermissao(Descricao)
('Configurar idiomas');

insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Configurações', 'javascript:void(0);', 29, 29, 4);

insert into mesitensmenu(CodMenu, Texto, link, CodPermissao, CodItemPai, Ordem)
values(1, 'Idiomas', 'vwidiomas.php', 29, 43, 1);

insert into mesgrupopermissao
values(1,29,1);

alter table mescaso
add ExigeLogin tinyint not null default 1 comment 'Indica se o usuário precisa estar logado para ver o caso';