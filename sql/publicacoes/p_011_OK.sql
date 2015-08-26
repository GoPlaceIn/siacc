insert into mestipovalorreferencia(Descricao, Simbolo)
values('Menor que', '<'),('Maior que', '>')

alter table mestipoexamecomponente
add Ordem int not null default 1 comment 'Ordenação dos componentes do exame'

/*
PUBLICAR

js/fn-casos.js
js/funcoes.js
css/padrao.cs
tpl/casos-exames-detalhes.html
ajaxcasoscoisasextras.php
ajaxcomponentesexame.php
actgravavalorref.php
cls/exame.class.php
cls/tipoexame.class.php
cls/valref.class.php
inc/comuns.inc.php
*/