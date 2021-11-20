drop table citacao_usuario;
drop table assunto_interacao;
drop table interacao;
drop table pagina_usuario;
drop table grupo_usuario;
drop table pagina;
drop table grupo;
drop table assunto;
drop table amizade;
drop table usuario;
drop table cidade;
drop table uf;
drop table pais;

create table pais (
    codigo varchar(60) not null,
    nome varchar(60) not null,
    ativo bit default 1 not null,
    primary key (codigo)
);

insert into pais (codigo, nome) values ("BRASIL", "BRASIL"), ("COLOMBIA", "COLOMBIA"), ("ARGENTINA", "ARGENTINA");

create table uf (
    codigo varchar(60) not null,
    nome varchar(60) not null,
    pais char(60) not null,
    ativo bit default 1 not null,
    foreign key (pais) references pais(codigo),
    primary key (codigo)
);

insert into uf (codigo, nome, pais) values ("RIO_GRANDE_DO_SUL", "RIO GRANDE DO SUL", "BRASIL"), ("CORDOVA", "CÓRDOVA", "ARGENTINA");

create table cidade (
    codigo integer not null,
    nome varchar(60) not null,
    uf char(2) not null,
    ativo bit default 1 not null,
    foreign key (uf) references uf(codigo),
    primary key (codigo)
);

insert into cidade (codigo, nome, uf) values (1, "RIO GRANDE", "RIO_GRANDE_DO_SUL"), (2, "PELOTAS", "RIO_GRANDE_DO_SUL"), (3, "PORTO ALEGRE", "RIO_GRANDE_DO_SUL"), (4, "SAO JOSE DO NORTE", "RIO_GRANDE_DO_SUL");

create table usuario (
    email varchar(50) not null,
    nome varchar(100) not null,
    hora_cadastro timestamp default current_timestamp not null,
    ativo bit default 1 not null,
    data_nascimento date not null,
    genero char(1) not null,
    cidade integer not null,
    foreign key (cidade) references cidade(codigo),
    primary key (email)
);

insert into usuario (email, nome, data_nascimento, genero, cidade, hora_cadastro) values ("VINI@VINI.COM", "VINICUS", "2003-02-13", "M", 1, "2020-01-01 14:21"), ("MARINA@MARINA.COM", "MARINA", "2002-07-07", "F", 1, "2020-02-05 11:21");

create table amizade (
    usuario1 varchar(50) not null,
    usuario2 varchar(50) not null,
    data_hora timestamp default current_timestamp not null,
    ativo default 0 not null,
    foreign key (usuario1) references usuario(email),
    foreign key (usuario2) references usuario(email),
    primary key (usuario1, usuario2)
);

insert into amizade (usuario1, usuario2, data_hora) values ("VINI@VINI.COM", "MARINA@MARINA.COM", "2021-11-10 15:40");
-- update amizade set ativo = 1 where usuario1 = "VINI@VINI.COM" AND usuario2 = "MARINA@MARINA.COM";

create table assunto (
    codigo integer not null,
    nome varchar(100) not null,
    primary key(codigo)
);

create table grupo (
    codigo integer not null,
    nome varchar(50) not null,
    descricao varchar(200) not null,
    ativo bit default 1 not null,
    primary key(codigo)
);

create table pagina (
    codigo integer not null,
    nome varchar(50) not null,
    descricao varchar(200) not null,
    ativo bit default 1 not null,
    primary key(codigo)
);

create table grupo_usuario (
    grupo integer not null,
    usuario varchar(50) not null,
    selo varchar(8) default null,
    adm bit default 0 not null,
    ativo bit default 1 not null,
    foreign key (grupo) references grupo(codigo),
    foreign key (usuario) references usuario(email),
    primary key(grupo, usuario)
);

create table pagina_usuario (
    pagina integer not null,
    usuario varchar(50) not null,
    adm bit default 0 not null,
    ativo bit default 1 not null,
    foreign key (pagina) references pagina(codigo),
    foreign key (usuario) references usuario(email),
    primary key(pagina, usuario)
);

create table interacao (
    codigo integer not null,
    usuario varchar(50) not null,
    tipo integer not null,
    data_hora timestamp default current_timestamp not null,
    cidade integer not null,
    grupo integer default null,
    conteudo varchar(1000),
    assunto integer default null,
    referencia integer,
    ativo bit default 1 not null,
    foreign key (referencia) references interacao(codigo),
    foreign key (cidade) references cidade(codigo),
    foreign key(grupo) references grupo(codigo),
    foreign key (usuario) references usuario(email),
    primary key (codigo)
);

insert into interacao(codigo, usuario, tipo, cidade, conteudo) values (1, "VINI@VINI.COM", "POST", 1, "ALGUEM VIU O PELE?");
insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values (2, "MARINA@MARINA.COM", "COMENTARIO", 1, "NUNCA VI", 1);
insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values (3, "MARINA@MARINA.COM", "REACAO", 1, "GRR", 1);

create table assunto_interacao (
    assunto integer not null,
    interacao integer not null,
    ativo bit default 1 not null,
    foreign key (assunto) references assunto(codigo),
    foreign key (interacao) references interacao(codigo),
    primary key(assunto, interacao)
);

create table citacao_usuario (
    usuario_marcado varchar(50) not null,
    interacao integer not null,
    ativo bit default 1 not null,
    foreign key (interacao) references interacao(codigo),
    foreign key (usuario_marcado) references usuario(email),
    primary key(usuario_marcado, interacao)
);

-- mudei admin de pagina e grupo, length do nome de página e grupo e adicionei uma descrição de 200 carecteres