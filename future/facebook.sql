-- drop table interacao;
-- drop table compart;
-- drop table citacao;
-- drop table assunto_coment;
-- drop table coment;
-- drop table assunto_post;
-- drop table post;
-- drop table amigo;
-- drop table pagina_usuario;
-- drop table grupo_usuario;
-- drop table usuario;
-- drop table assunto;
-- drop table grupo;
-- drop table pagina;
-- drop table cidade;
-- drop table estado;
-- drop table pais;

create table pais (
    codigo char(3) not null,
    nome varchar(60) not null,
    primary key(codigo)
);

create table estado (
    codigo char(2) not null,
    nome varchar(20) not null,
    pais char(3) not null,
    foreign key(pais) references pais(codigo),
    primary key(codigo)
);

create table cidade (
    cep char(8) not null,
    nome varchar(30) not null,
    estado char(2) not null,
    foreign key(estado) references estado(codigo),
    primary key (cep)
);

create table usuario (
    email varchar(50) not null,
    nome varchar(100) not null,
    data_hora timestamp not null default current_timestamp,
    cidade char(8) not null,
    genero char(1) not null check (genero like 'f' or genero like 'm' or genero like 'n'),
    data_nascimento date not null,
    foreign key(cidade) references cidade(cep),
    primary key(email)
);

create table amigo (
    usuario varchar(50) not null,
    amigo varchar(50) not null,
    data_hora timestamp not null default current_timestamp,
    foreign key(usuario) references usuario(email),
    foreign key(amigo) references usuario(email),
    primary key(usuario, amigo)
);

create table post (
    id integer not null,
    usuario varchar(50) not null,
    data_hora timestamp not null default current_timestamp,
    conteudo varchar(1000) not null,
    cidade integer not null,
    grupo integer default null,
    foreign key(usuario) references usuario(email),
    foreign key(cidade) references cidade(cep),
    foreign key(grupo) references grupo(id),
    primary key(id)
);

create table coment (
    id integer not null,
    usuario varchar(50) not null,
    data_hora timestamp not null default current_timestamp,
    conteudo varchar(1000) not null,
    post integer default null,
    coment integer default null,
    grupo integer default null,
    cidade integer not null,
    foreign key(usuario) references usuario(email),
    foreign key(post) references post(id),
    foreign key(coment) references coment(id),
    foreign key(grupo) references grupo(id),
    foreign key(cidade) references cidade(cep),
    primary key(id)
);

create table assunto (
    id integer not null,
    nome varchar(30) not null,
    primary key(id)
);

create table assunto_post (
    post integer not null,
    assunto integer not null,
    foreign key(post) references post(id),
    foreign key(assunto) references assunto(id),
    primary key(post, assunto)
);

create table assunto_coment (
    coment integer not null,
    assunto integer not null,
    foreign key(coment) references coment(id),
    foreign key(assunto) references assunto(id),
    primary key(coment, assunto)
);

create table citacao (
    post integer default null,
    coment integer default null,
    usuario varchar(50) not null,
    foreign key(post) references post(id),
    foreign key(coment) references coment(id),
    foreign key(usuario) references usuario(email),
    primary key(post, usuario)
);

create table interacao (
    tipo varchar(6) check (tipo like 'curti' or tipo like 'amei' or tipo like 'haha' or tipo like 'uau' or tipo like 'triste' or tipo like 'grr'),
    post integer default null,
    coment integer default null,
    usuario varchar(50) not null,
    data_hora timestamp not null default current_timestamp,
    cidade char(8) not null,
    foreign key(post) references post(id),
    foreign key(coment) references coment(id),
    foreign key(usuario) references usuario(email),
    foreign key(cidade) references cidade(cep),
    primary key(post, usuario)
);

create table compart (
    id integer not null,
    post integer not null,
    usuario varchar(50) not null,
    data_hora timestamp not null default current_timestamp,
    cidade char(8) not null,
    foreign key(post) references post(id),
    foreign key(usuario) references usuario(email),
    foreign key(cidade) references cidade(cep),
    primary key(id)
);

create table pagina (
    id integer not null,
    nome varchar(150) not null,
    primary key(id)
);

create table grupo (
    id integer not null,
    nome varchar(150) not null,
    primary key(id)
);

create table grupo_usuario (
    grupo integer not null,
    usuario varchar(50) not null,
    selo varchar(8) check (selo is null or selo like 'ultra-fã' or selo like 'super-fã' or selo like 'fã'),
    foreign key(grupo) references grupo(id),
    foreign key(usuario) references usuario(email),
    primary key(grupo, usuario)
);

create table pagina_usuario (
    pagina integer not null,
    usuario varchar(50) not null,
    foreign key(pagina) references pagina(codigo),
    foreign key(usuario) references usuario(email),
    primary key(pagina, usuario)
);

-- inserts de teste abaixo

insert into pais (codigo, nome) values
    ('BRA', 'Brasil'),
    ('EUA', 'Estados Unidos');

insert into estado (codigo, nome, pais) values
    ('RS', 'Rio Grande do Sul', 'BRA'),
    ('CA', 'California', 'EUA');

insert into cidade (cep, nome, estado) values
    ('96200003', 'Rio Grande', 'RS'),
    ('31569081', 'Sacramento', 'CA');

insert into usuario (email, nome, data_hora, cidade, genero, data_nascimento) values
    ('profdb@mymail.com', 'Professor de BD', '2010-01-01 09:00:00', '96200003', 'm', '1974-05-24'), --1
    ('joaosbras@mymail.com', 'João Silva Brasil', '2010-01-01 13:00:00', '96200003', 'm', '1985-10-11'), --2
    ('papereira@mymail.com', 'Pedro Alencar Pereira', '2010-01-01 13:05:00', '96200003', 'm', '2000-01-14'), --3
    ('mcalbuq@mymail.com', 'Maria Cruz Albuquerque', '2010-01-01 13:10:00', '96200003', 'f', '1999-07-03'), --4
    ('jorosamed@mymail.com', 'Joana Rosa Medeiros', '2010-01-01 13:15:00', '96200003', 'f', '2001-06-09'), --5
    ('pxramos@mymail.com', 'Paulo Xavier Ramos', '2010-01-01 13:20:00', '96200003', 'n', '1999-04-12'); --6

insert into usuario (email, nome, cidade, genero, data_nascimento) values
    ('ifrsriogrande@mymail.com', 'IFRS campus Rio Grande', '96200003', 'n', '2013-01-10'),
    ('xuxa@xuxa.com', 'Xuxa Meneghel', '96200003', 'f', '1963-03-27'),
    ('pele@cbf.com.br', 'Edson Arantes do Nascimento', '96200003', 'm', '1940-10-23'),
    ('pmartinssilva90@mymail.com', 'Paulo Martins Silva', '96200003', 'm', '2007-08-17');

insert into amigo (usuario, amigo, data_hora) values
    ('profdb@mymail.com', 'joaosbras@mymail.com', '2010-05-17 10:00:00'),
    ('profdb@mymail.com', 'papereira@mymail.com', '2010-05-17 10:05:00'),
    ('profdb@mymail.com', 'mcalbuq@mymail.com', '2010-05-17 10:10:00'),
    ('profdb@mymail.com', 'jorosamed@mymail.com', '2010-05-17 10:15:00'),
    ('ifrsriogrande@mymail.com', 'profdb@mymail.com', '2010-05-17 10:15:00'),
    ('pele@cbf.com.br', 'xuxa@xuxa.com', '2010-05-17 10:15:00'),
    ('pele@cbf.com.br','pxramos@mymail.com', '2021-08-01 10:15:00'),
    ('pele@cbf.com.br', 'jorosamed@mymail.com', '2021-08-01 10:15:00'),
    ('pele@cbf.com.br', 'papereira@mymail.com', '2021-08-01 10:15:00'),
    ('pele@cbf.com.br', 'mcalbuq@mymail.com', '2021-08-01 10:15:00'),
    ('pele@cbf.com.br', 'joaosbras@mymail.com', '2021-08-01 10:15:00'),
    ('pxramos@mymail.com', 'xuxa@xuxa.com', '2021-08-01 10:15:00'),
    ('profdb@mymail.com', 'pxramos@mymail.com', '2010-05-17 10:20:00');

insert into grupo (nome) values 
    ('Banco de Dados-IFRS-2021'),
    ('SQLite');

insert into grupo_usuario (grupo, usuario) values
    (1, 'ifrsriogrande@mymail.com'),
    (1, 'joaosbras@mymail.com'),
    (1, 'profdb@mymail.com'),
    (2, 'profdb@mymail.com'),
    (2, 'joaosbras@mymail.com'),
    (2, 'pele@cbf.com.br'),
    (2, 'ifrsriogrande@mymail.com');

insert into post (conteudo, usuario, data_hora, cidade) values
    ('Hoje eu aprendi como inserir dados no SQLite no IFRS', 'joaosbras@mymail.com', '2021-07-02 15:00:00', '96200003'), --1
    ('Atendimento de BD no GMeet amanhã para quem tiver dúvidas de INSERT', 'profdb@mymail.com', '2021-06-02 15:35:00', '96200003'), --2
    ('abc', 'joaosbras@mymail.com', '2021-08-02 15:31:29', '96200003'), --3
    ('oi Brasil', 'pmartinssilva90@mymail.com', '2021-05-29 14:21:43', '96200003'), --4 
    ('oi Brasil 1', 'pmartinssilva90@mymail.com', '2020-05-29 14:21:43', '96200003'), --5
    ('hello America', 'pmartinssilva90@mymail.com', '2021-07-29 19:35:16', '31569081'), --6
    ('gg', 'joaosbras@mymail.com', '2021-07-29 19:35:16', '31569081'); --7

insert into post (conteudo, usuario, data_hora, cidade, grupo) values
    ('kaksas', 'profdb@mymail.com', '2021-06-02 11:20:00', '96200003', 2), --8
    ('boa noite', 'profdb@mymail.com', '2021-07-02 21:00:00', '96200003', 2); --9

insert into coment (conteudo, usuario, post, data_hora, cidade) values
    ('Alguém mais ficou com dúvida no comando INSERT?', 'jorosamed@mymail.com', 1, '2021-06-02 15:15:00', '96200003'), --1
    ('INSERT é difícil?', 'pele@cbf.com.br', 2, '2021-06-02 15:17:00', '96200003'); -- 2
    
insert into coment (conteudo, usuario, coment, data_hora, cidade) values
    ('Eu também', 'pxramos@mymail.com', 1, '2021-06-02 15:20:00', '96200003'), --3
    ('Sou o pele', 'pele@cbf.com.br', 1, '2021-07-02 15:20:00', '96200003'), --4
    ('Já agendaste horário de atendimento com o professor?', 'joaosbras@mymail.com', 2, '2021-06-02 15:30:00', '96200003'); --5
    
insert into assunto (nome) values
    ('BD'), --1
    ('SQLite'), --2
    ('INSERT'), --3
    ('atendimento'), --4
    ('aula'), --5
    ('escola'), --6
    ('SELECT'), --7
    ('DELETE'), --8
    ('UPDATE'), --9
    ('INTERSECT'); --10

insert into assunto_post (assunto, post) values
    (1, 1),
    (2, 1),
    (6, 1),
    (4, 1),
    (7, 1),
    (1, 7),
    (2, 7),
    (4, 7),
    (4, 3),
    (4, 2),
    (5, 2),
    (1, 2),
    (2, 2),
    (3, 2),
    (6, 2),
    (1, 4),
    (2, 4),
    (3, 4),
    (2, 5),
    (4, 5),
    (6, 5),
    (4, 6),
    (6, 6),
    (7, 2);

insert into assunto_coment (assunto, coment) values
    (1, 1),
    (2, 1),
    (3, 1),
    (6, 1),
    (4, 3),
    (6, 3),
    (4, 2),
    (6, 2),
    (1, 3),
    (1, 4);

insert into interacao (tipo, usuario, post, data_hora, cidade) values
    ('curti', 'papereira@mymail.com', 1, '2021-06-02 15:05:00', '96200003'),
    ('curti', 'mcalbuq@mymail.com', 1, '2021-06-02 15:10:00', '96200003'),
    ('curti', 'pxramos@mymail.com', 1, '2021-06-02 15:10:00', '96200003'),
    ('curti', 'xuxa@xuxa.com', 1, '2021-07-02 15:10:00', '96200003'),
    ('amei', 'profdb@mymail.com', 1, '2021-06-02 15:10:00', '96200003'),
    ('amei', 'jorosamed@mymail.com', 1, '2021-06-02 15:10:00', '96200003'),
    ('amei', 'pele@cbf.com.br', 1, '2021-06-02 15:10:00', '96200003'),
    ('amei', 'ifrsriogrande@mymail.com', 1, '2021-06-02 15:10:00', '96200003'),
    ('curti', 'papereira@mymail.com', 6, '2021-06-02 15:05:00', '96200003'),
    ('curti', 'joaosbras@mymail.com', 6, '2021-06-02 15:05:00', '96200003'),
    ('curti', 'joaosbras@mymail.com', 7, '2021-07-11 15:23:00', '96200003'),
    ('amei', 'pele@cbf.com.br', 7, '2021-07-14 11:13:00', '96200003'),
    ('amei', 'xuxa@xuxa.com', 7, '2021-07-15 19:21:00', '96200003'),
    ('curti', 'papereira@mymail.com', 7, '2021-07-12 15:59:00', '96200003'),
    ('curti', 'papereira@mymail.com', 8, '2021-07-15 21:29:00', '96200003'),
    ('amei', 'xuxa@xuxa.com', 8, '2021-07-15 22:00:00', '96200003');

insert into interacao (tipo, usuario, coment, data_hora, cidade) values
    ('triste', 'pxramos@mymail.com', 1, '2021-06-02 15:20:00', '96200003');

insert into compart (usuario, post, data_hora, cidade) values
    ('joaosbras@mymail.com', 2, '2021-06-02 15:40:00', '96200003'),
    ('joaosbras@mymail.com', 4, '2021-05-30 14:20:13', '96200003'),
    ('joaosbras@mymail.com', 4, '2020-05-30 14:20:13', '96200003');

insert into citacao (usuario, post) values
    ('ifrsriogrande@mymail.com', 1),
    ('jorosamed@mymail.com', 2),
    ('pxramos@mymail.com', 2);

-- precisamos
-- localidade, usuario, interações, assunto da interação, usuario citados em uma interação, amizades de um usuario, grupos, usuarios de um grupo


