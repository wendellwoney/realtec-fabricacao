# Realtec Desafio

## Tarefa

O cadastro de fórmulas/composição, é um controle muito importante dentro das fábricas de qualquer
tipo de produto. Esse cadastro permite à empresa controlar os custos dos insumos (ingredientes/peças)
necessários para fabricação, bem como seus estoques necessários para o fornecimento contínuo de seus
produtos. O cliente deseja uma ferramenta para controle de produtos e seus insumos, que permita cadastrar
fórmulas/composições para cada produto do seu mix.

## Arquitetura do projeto

* Linguagem utilizada - PHP 7.x
* Bibliotecas - Doctrine, jquery, jschart, bootstrap.
* Framework - Zend 3
* Estrutura: MVC, ORM
* Banco de Dados: Mysql

## Instalação da aplicação

#### Ambiente de desenvolvimento

A maneira mais fácil de executar a aplicação **realtec-fabricação** é instalar o ambiente de desenvolvimento
XAMPP. O XAMPP é completamente gratuito, fácil de instalar a distribuição Apache, contendo MySQL, PHP e Perl.
O pacote de código aberto do XAMPP foi criado para ser extremamente fácil de instalar e de usar.

Link para versão com php 7:

```bash
https://www.apachefriends.org/download.html
```
Após a instalação e início do controlador XAMPP geralmente será iniciado o cli-server na porta 80. Você poderá 
visitar a tela de boas vindas do XAMPP em  http://localhost

**Nota:** O xampp é utilizado *apenas para desenvolvimento e teste da aplicação*.

#### Subindo o banco de dados

Após o início do controlador XAMPP você terá acesso a aplicação **phpmyadmin** que é uma aplicação web para gerenciamento
do banco de dados mysql. Com ela poderemos subir o sql com a estrutura da base de dados que é utilizada na aplicação 
**realtec-fabricação**.

**Nota:** o acesso será http://localhost/phpmyadmin.

###### Criando a base de dados

Já na aplicação **phpmyadmin** basta seguir o seguinte processo:

1- Clicar em base de dados

2- Em Criar base de dados no input Nome da base de dados adicionar o nome: realtec

3- Após a criação a base de dados será listada no menu no lado esquerdo da aplicação basta clicar sobre o nome realtec.

4- Ao abrir a base de dados clicar no menu superior em importar

5- Na tela seguinte onde com o título File to import escolha o sql que escontra-se dentro da pasta da aplicação em :

```bash
    /realtec-fabricacao/doc/realtec.sql
```

#### Adicionando a aplicação no XAMPP
Basta copiar toda a pasta **realtec-fabricacao** para o diretório de instalação do xampp seguindo o caminho:

```bash
    /DIR_INSTALACAO/xampp/htdocs
```

## Sobre os Modulos da aplicação

#### Modulo INICIAL

Este modulo trás um amparato geral dos dados do sistema com alguns dados de acesso rápido.

![tela_inicio](https://user-images.githubusercontent.com/29403648/63791422-de037780-c8d1-11e9-8685-0f468de95ac6.gif)

#### Modulo INSUMOS

Este modulo controla toda a materia prima e o seu respectivo estoque

![tela_insumos](https://user-images.githubusercontent.com/29403648/63791906-d55f7100-c8d2-11e9-9d65-5e71a7d6ab8c.gif)

#### Modulo ENTRADA DE INSUMOS

Este modulo controla a compra de insumos para o sistema ele reflete diretamente com o estoque dos insumos.

###### Cadastro de entrada insumos

![insumo_1](https://user-images.githubusercontent.com/29403648/63792675-6b47cb80-c8d4-11e9-9139-59027e576474.gif)

###### Visualização do estoque

![insumo_2](https://user-images.githubusercontent.com/29403648/63792793-ae09a380-c8d4-11e9-91df-2fe6c49eeafc.gif)

#### Modulo PRODUTO

Modulo de controde das formulas utilizadas para composição de um produto 

![produto](https://user-images.githubusercontent.com/29403648/63793991-4c970400-c8d7-11e9-9107-5696e0e549af.gif)

#### Modulo FABRICAÇÃO

Modulo de controle para estoque de produtos fabricados. Com ele você seleciona uma quantidade de um determinado produto que deseja fabricar
o sistema calcula automaticamente se é possivel ou não fabricar o produto de acordo com o estoque de insumos necessários.

![fabricacao](https://user-images.githubusercontent.com/29403648/63794446-6b49ca80-c8d8-11e9-8822-64abc915f881.gif)






