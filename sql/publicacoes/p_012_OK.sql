/*
Arquivos a plicar
=================

img/pe_1.png
img/pe_2.png
img/pe_3.png
img/pe_4.png
img/pe_5.png
img/resp_certas.png
img/saiba_mais_texto.png

tpl/casos-basicos.html
tpl/casos-inicio.html
tpl/casos-anamnese.html
tpl/tela-topo.html
tpl/padraolistagem.html
tpl/cad-padrao.html
tpl/usuariosgrupo.html
tpl/frm-acessos.html
tpl/gerenciagrupos.html
tpl/frm-resolucao-off.html

css/padrao.css
css/ie8menos.css
css/ie7menos.css
css/aluno/estilo.css

js/fn-casos.js
js/siacc.montagem.js
js/siacc.resolucao.js

cls/etnia.class.php
cls/imgpaciente.class.php
cls/caso.class.php
cls/resolucao.class.php
cls/exame.class.php

ajaxcasoparte.php
actgravacaso.php
ajaxverificaacertos.php

*/

ALTER TABLE mescaso
ADD Etnia INT NULL COMMENT 'Etnia do paciente',
ADD NomePaciente VARCHAR(50) NULL COMMENT 'Iniciais do nome do paciente',
ADD ImgPaciente INT NULL COMMENT 'Imagem a ser usada (homem, mulher, criança, etc)';

ALTER TABLE mestipoexamecomponente
ADD Ordem INT NOT NULL DEFAULT 1 COMMENT 'Ordem de exibição dos componentes do exame'

INSERT INTO mescasomontagemconfigs(Nome, Descricao, Grupo, Prefixo)
VALUES('Resposta imediata','Permite ao aluno consultar a resposta imediatamente',24792,'chk');