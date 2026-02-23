-- Active: 1771795287042@@127.0.0.1@3306
create table users(
    id int not null primary key auto_increment,
    nome text not null,
    telefone text,
    email text unique not null,
    senha text not null
)

create table produtos(
    id int not null primary key auto_increment,
    nome text not null,
    descricao text,
    imagem text,
    valorCentavos int not null
)