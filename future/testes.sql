

select grupo.nome 
    from grupo
    join grupo_usuario on grupo_usuario.grupo = grupo.codigo
    join usuario on usuario.email = grupo_usuario.usuario
where usuario.email = "MARINA@MARINA.COM";



select * from grupo_usuario;

select ativo from grupo_usuario where usuario like 'VINI@VINI.COM' and grupo = 6;

-- "select ativo from ".$_POST["tipo"]. "_usuario where usuario like '".$_POST["user"]."' and ".$_POST["valorgp"].""

-- 11) Mostrar qual faixa etária mais interagiu às postagens do grupo G nos últimos D dias

select count(*), case


select grupo.nome, grupo.codigo 
    from grupo 
        join grupo_usuario on grupo_usuario.grupo = grupo.codigo
        join usuario on usuario.email = grupo_usuario.usuario 
where usuario.email = 'VINI@VINI.COM' and grupo_usuario.ativo = 1 
orderby grupo.nome asc limit 5 offset 0





-- selo

update grupo_usuario
set selo = tmp10.selo
from usuario, grupo, 
(
    select case
        when (tmp7.porcentagem_comentario > 30 and tmp8.porcentagem_interacao > 75) and tmp8.nome = tmp7.user then 'ultra-fa' 
        when (tmp7.porcentagem_comentario > 20 and tmp8.porcentagem_interacao > 50) and tmp8.nome = tmp7.user  then 'super-fa'
        when (tmp7.porcentagem_comentario > 10 and tmp8.porcentagem_interacao > 25) and tmp8.nome = tmp7.user  then 'fa' end as selo, tmp8.nome
    from 
    (
        select tmp4.user, (cast(tmp4.qtde as real)/tmp5.qtde) * 100 as porcentagem_comentario from
            (select tmp2.user as user, count(*) as qtde
                from (
                    select coment.post as post,
                        coment.id as coment,
                        usuario.nome as user
                    from coment
                        join usuario on usuario.email = coment.usuario
                    where coment.post not null
                    union all
                    select case
                            when com2.post is null
                            and com2.coment = tmp.coment
                            and tmp.coment not null then tmp.post
                        end as post,
                        com2.id,
                        usuario.nome as user
                    from coment
                        join coment as com2 on com2.coment = coment.id
                        join usuario on usuario.email = coment.usuario,
                        (
                            select case
                                    coment.post
                                    when not null then coment.post
                                    else coment.post
                                end as post,
                                coment.id as coment
                            from coment
                            where coment.post not null
                        ) as tmp
                    group by 1,
                        2
                    having 1 not null
                ) as tmp2,
                (select post.id as id
                    from post
                        join usuario on usuario.email = post.usuario
                        join grupo_usuario on grupo_usuario.usuario = usuario.email
                        join grupo on grupo.id = grupo_usuario.grupo,
                        (select
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial) as tempo
                    where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final
                ) tmp3
                where tmp2.post in (tmp3.id) group by 1
            ) as tmp4, 
            (select count(*) as qtde 
                from (
                    select post.conteudo
                        from post
                            join grupo on grupo.id = post.grupo, 
                            (select
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial) as tempo
                            where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final 
                )
            ) as tmp5
            
    ) as tmp7,
    (
        select tmp.nome, (cast(tmp.qtde as real)/tmp2.post_total) * 100 as porcentagem_interacao
        -- COMEÇA AQUI
            from
                (select usuario.nome, count(*) as qtde
                    from interacao
                        join usuario on usuario.email = interacao.usuario
                        join grupo_usuario on grupo_usuario.usuario = usuario.email
                        join grupo on grupo.codigo = grupo_usuario.grupo
                    where grupo.nome like 'Grupo do Vini' and grupo.ativo = 1
                        and interacao.referencia in 
                        (
                            -- PEGA OS ID DAS INTERAÇÕES DOS POST EM UM GRUPO X NA ÚLTIMA SEMANA
                            select interacao.codigo
                                from interacao
                                    join usuario on usuario.email = interacao.usuario
                                    join grupo_usuario on grupo_usuario.usuario = usuario.email
                                    join grupo on grupo.codigo = grupo_usuario.grupo,
                                    (select
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                    ) as tempo
                            where grupo.nome like 'Grupo do Vini' and interacao.tipo like 'POST' and grupo.ativo = 1 and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final 
                        ) 
                    group by 1
                ) as tmp, 
        -- termina aqui
                (select count(*) as post_total 
                    from (
                        select post.conteudo
                            from post
                                join grupo on grupo.id = post.grupo,
                                (select
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial) as tempo
                            where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final 
                    )
            ) as tmp2
            -- TERMINA AQUI
    ) as tmp8
    group by 1, 2)as tmp10
where usuario.email = grupo_usuario.usuario and grupo.id = grupo_usuario.grupo and tmp10.nome = usuario.nome and grupo.nome like '%IFRS-Campus Rio Grande%'; 


select usuario, tipo, hora_post, grupo, referencia, ativo from interacao;

insert into interacao (usuario, tipo, cidade, hora_post, grupo, conteudo) values ('VINI@VINI.COM', 'POST', 1, "2021-11-29 15:40", 2, 'POST 1');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, conteudo) values ('VINI@VINI.COM', 'POST', 1, "2021-11-30 15:40", 2, 'POST 2');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, conteudo) values ('VINI@VINI.COM', 'POST', 1, "2021-12-01 15:40", 2, 'POST 3');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, conteudo) values ('VINI@VINI.COM', 'POST', 1, "2021-12-02 15:40", 2, 'POST 4');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia) values ('VINI@VINI.COM', 'CURTIR', 1, "2021-12-02 15:42", 2, 1);
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia) values ('JOAO@JOAO.COM', 'CURTIR', 1, "2021-12-02 15:42", 2, 1);
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia) values ('MARINA@MARINA.COM', 'CURTIR', 1, "2021-12-02 15:43", 2, 2);
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia) values ('MARINA@MARINA.COM', 'CURTIR', 1, "2021-12-02 15:43", 2, 3);
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('MARINA@MARINA.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 2, 2, 'LEGAL');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('MARINA@MARINA.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 2, 1, 'NOSSA');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('MARINA@MARINA.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 2, 3, 'MANEIRO');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('VINI@VINI.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 3, 3, 'CONCORDO');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('MARINA@MARINA.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 3, 11, 'DISCORDO');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('VINI@VINI.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 3, 4, 'CONCORDO MEIO TERMO');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('MARINA@MARINA.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 3, 13, 'CONCORDO MEIO TERMO');
insert into interacao (usuario, tipo, cidade, hora_post, grupo, referencia, conteudo) values ('JOAO@JOAO.COM', 'COMENTARIO', 1, "2021-12-02 15:44", 3, 13, 'CONCORDO MEIO TERMO');

insert into usuario
    (email, nome, data_nascimento, genero, cidade, hora_cadastro)
values
    ("VINI@VINI.COM", "VINICIUS AAAA", "2003-02-13", "M", 1, "2020-01-01 14:21"),
    ("MARINA@MARINA.COM", "MARINA BBBB", "2002-07-07", "F", 1, "2020-02-05 11:21");
insert into usuario
    (email, nome, data_nascimento, genero, cidade, hora_cadastro)
values ("JOAO@JOAO.COM", "JOAO CCCC", "2002-07-07", "M", 1, "2020-02-05 11:21");

insert into grupo (nome, descricao) values ('GRUPO DO JOAOAO', 'GRUPO DELE');
insert into grupo (nome, descricao) values ('GRUPO DO VINI', 'MEU GRUPO');

insert into grupo_usuario (usuario, grupo, adm) values ('VINI@VINI.COM', 2);
insert into grupo_usuario (usuario, grupo) values ('JOAO@JOAO.COM', 2);
insert into grupo_usuario (usuario, grupo) values ('MARINA@MARINA.COM', 2);

-- Funcionalidades
update grupo_usuario
set selo = tmp10.selo
from usuario, grupo,

-- seleciona o tipo de selo que o usuário deve receber de acordo com a porcentagem de interação e comentário
(
    select case
        when (tmp7.porcentagem_comentario > 10 and tmp8.porcentagem_interacao > 25) and tmp8.nome = tmp7.user  then 'fa' 
        when (tmp7.porcentagem_comentario > 20 and tmp8.porcentagem_interacao > 50) and tmp8.nome = tmp7.user  then 'super-fa'
        when (tmp7.porcentagem_comentario > 30 and tmp8.porcentagem_interacao > 75) and tmp8.nome = tmp7.user then 'ultra-fa' 
        when (tmp7.porcentagem_comentario <= 10 or tmp8.porcentagem_interacao <= 25) and tmp8.nome = tmp7.user  then 'não é fa' 
        end as selo, tmp8.nome
    from 

    -- TMP7 = seleciona o nome do usuário, a qtde/total * 100 = porcentagem de comentários feitos por um usuário nos posts de um grupo
    (
        select tmp4.user, (cast(tmp4.qtde as real)/tmp5.qtde) * 100 as porcentagem_comentario 
            from
                (
                    select tmp2.user as user, count(*) as qtde
                        from (

                            -- seleciona o post, comentário e o usuario
                            select coment.post as post,
                                coment.id as coment,
                                usuario.nome as user
                            from coment
                                join usuario on usuario.email = coment.usuario
                            where coment.post not null

                            union all

                            -- seleciona post, o id do comentário e o usuario
                            select case
                                    when com2.post is null
                                    and com2.coment = tmp.coment
                                    and tmp.coment not null then tmp.post
                                end as post,
                                com2.id,
                                usuario.nome as user
                            from coment
                                join coment as com2 on com2.coment = coment.id
                                join usuario on usuario.email = coment.usuario,
                                (
                                    select case
                                            coment.post
                                            when not null then coment.post
                                            else coment.post
                                        end as post,
                                        coment.id as coment
                                    from coment
                                    where coment.post not null
                                ) as tmp
                            group by 1,
                                2
                            having 1 not null
                        ) as tmp2,
                        (
                            -- seleciona o id do post de um grupo específico que foi feito nos últimos 7 diass
                            select post.id as id
                            from post
                                join usuario on usuario.email = post.usuario
                                join grupo_usuario on grupo_usuario.usuario = usuario.email
                                join grupo on grupo.id = grupo_usuario.grupo,
                                -- seleciona o dia de hoje a o dia de 7 dias atrás
                                (select
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                ) as tempo
                            where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final
                        ) as tmp3
                        where tmp2.post in (tmp3.id) group by 1
                ) as tmp4,

                (
                    -- seleciona a quantidade de posts em  um grupo feitos nos últimos sete dias
                    select count(*) as qtde 
                    from (
                        select post.conteudo
                            from post
                                join grupo on grupo.id = post.grupo, 
                                (select
                                    case 
                                        when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                        when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                        when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                        when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                        when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                        when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                        when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                    case 
                                        when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                        when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                        when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                        when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                        when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                        when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                        when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial) as tempo
                                where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final 
                    )
                ) as tmp5
    ) as tmp7,

    -- TMP8 = seleciona o nome do usuario, a qtde/total de posts * 100 = porcentagem de interação do usuário nas postagens do grupo
    (
        select tmp.nome, (cast(tmp.qtde as real)/tmp2.post_total) * 100 as porcentagem_interacao
            from
                (
                    -- seleciona o nome do usuário e a quantidade de interações dele em um grupo nas as postagens que tenham sido feitas entre hoje e uma semana atrás
                    select usuario.nome, count(*) as qtde
                        from interacao
                            join usuario on usuario.email = interacao.usuario
                            join grupo_usuario on grupo_usuario.usuario = usuario.email
                            join grupo on grupo.id = grupo_usuario.grupo
                    where grupo.nome like 'IFRS-Campus Rio Grande'
                    and interacao.post in 
                        (
                            -- seleciona o id do post de um grupo específico que tenha sido postado entre o dia de hoje e uma semana atrás
                            select post.id
                            from post
                                join usuario on usuario.email = post.usuario
                                join grupo_usuario on grupo_usuario.usuario = usuario.email
                                join grupo on grupo.id = grupo_usuario.grupo,
                                -- seleciona o dia de hoje e o dia de uma semana atrás
                                (select
                                    case 
                                        when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                        when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                        when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                        when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                        when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                        when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                        when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                    case 
                                        when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                        when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                        when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                        when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                        when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                        when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                        when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                ) as tempo
                                where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final 
                        ) group by 1
                ) as tmp,

                (
                    -- pega o número total de posts
                    select count(*) as post_total 
                    from (
                        select post.conteudo
                            from post
                                join grupo on grupo.id = post.grupo,
                                (select
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                case 
                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial) as tempo
                            where grupo.nome like 'IFRS-Campus Rio Grande' and strftime('%Y%m%d', post.data_hora) between tempo.data_inicial and tempo.data_final 
                    )
                ) as tmp2
    ) as tmp8

    group by 1, 2

) as tmp10
where usuario.email = grupo_usuario.usuario and grupo.id = grupo_usuario.grupo and tmp10.nome = usuario.nome and grupo.nome like 'IFRS-Campus Rio Grande'; 


-- CONTEUDO FINAL

select tmp10.selo, tmp10.nome 
    from grupo,
    (
        select case
                when (tmp7.porcentagem_comentario >= 30 and tmp8.porcentagem_interacao >= 75) and tmp8.nome = tmp7.user then 'ultra-fa' 
                when (tmp7.porcentagem_comentario >= 20 and tmp8.porcentagem_interacao >= 50) and tmp8.nome = tmp7.user  then 'super-fa'
                when (tmp7.porcentagem_comentario >= 10 and tmp8.porcentagem_interacao >= 25) and tmp8.nome = tmp7.user  then 'fa' 
                else 'vazio' 
                end as selo, tmp8.nome
        from
        (
            select tmp4.user, (cast(tmp4.qtde as real)/tmp5.qtde) * 100 as porcentagem_comentario 
                from
                    (
                        select tmp2.user as user, count(*) as qtde
                            from (

                                -- seleciona o post, comentário e o usuario
                                select distinct interacao.referencia as post,
                                    usuario.nome as user
                                    -- interacao.codigo as coment,
                                from interacao
                                    join usuario on usuario.email = interacao.usuario
                                where interacao.referencia not null and interacao.tipo like 'COMENTARIO'

                                UNION

                                -- seleciona post, o id do comentário e o usuario comentário de comentário
                                select distinct interacao.referencia as post, tmp11.user
                                from interacao,
                                (select case
                                        when com2.referencia is null
                                        and com2.referencia = tmp.coment
                                        and tmp.coment not null then tmp.post
                                        else com2.referencia
                                    end as post,
                                    com2.codigo,
                                    usuario.nome as user
                                from interacao
                                    join interacao as com2 on com2.referencia = interacao.codigo
                                    join usuario on usuario.email = com2.usuario,
                                    (
                                        select interacao.referencia as post,
                                            interacao.codigo as coment
                                        from interacao
                                        where interacao.referencia not null and interacao.tipo like 'COMENTARIO'
                                    ) as tmp
                                where interacao.tipo like 'COMENTARIO'
                                group by 1,
                                    2
                                having 1 not null) as tmp11
                                where interacao.codigo in (tmp11.post)
                            ) as tmp2,
                            (
                                -- seleciona o id do post de um grupo específico que foi feito nos últimos 7 diass
                                select interacao.codigo as id
                                from interacao
                                    join usuario on usuario.email = interacao.usuario
                                    join grupo_usuario on grupo_usuario.usuario = usuario.email
                                    join grupo on grupo.codigo = grupo_usuario.grupo,
                                    -- seleciona o dia de hoje a o dia de 7 dias atrás
                                    (select
                                            case 
                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                            case 
                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                    ) as tempo
                                where interacao.tipo like 'POST' and grupo.nome like 'Grupo do Vini' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final
                            ) as tmp3
                        where tmp2.post in (tmp3.id) group by 1
                    ) as tmp4,

                    (
                        -- seleciona a quantidade de posts em  um grupo feitos nos últimos sete dias
                        select count(*) as qtde 
                        from (
                            select interacao.codigo
                                from interacao
                                    join grupo on grupo.codigo = interacao.grupo, 
                                    (select
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                    ) as tempo
                                where grupo.nome like 'Grupo do Vini' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final and interacao.tipo like 'POST'
                        )
                    ) as tmp5
        ) as tmp7,
        (
            select tmp.nome, (cast(tmp.qtde as real)/tmp2.post_total) * 100 as porcentagem_interacao
                from
                    (
                        -- seleciona o nome do usuário e a quantidade de interações dele em um grupo nas as postagens que tenham sido feitas entre hoje e uma semana atrás
                        select usuario.nome, count(*) as qtde
                            from interacao
                                join usuario on usuario.email = interacao.usuario
                                join grupo_usuario on grupo_usuario.usuario = usuario.email
                                join grupo on grupo.codigo = grupo_usuario.grupo
                        where grupo.nome like 'Grupo do Vini' and interacao.tipo like 'CURTIR'
                        and interacao.referencia in 
                            (
                                -- seleciona o id do post de um grupo específico que tenha sido postado entre o dia de hoje e uma semana atrás
                                select interacao.codigo
                                from interacao
                                    join usuario on usuario.email = interacao.usuario
                                    join grupo_usuario on grupo_usuario.usuario = usuario.email
                                    join grupo on grupo.codigo = grupo_usuario.grupo,
                                    -- seleciona o dia de hoje e o dia de uma semana atrás
                                    (select
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                    ) as tempo
                                    where grupo.nome like 'Grupo do Vini' and interacao.tipo like 'POST' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final 
                            ) group by 1
                    ) as tmp,

                    (
                        -- pega o número total de posts
                        select count(*) as post_total 
                        from (
                            select distinct interacao.codigo
                                from interacao
                                    join grupo on grupo.codigo = interacao.grupo,
                                    (select
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                        case 
                                            when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                            when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                            when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                            when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                            when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                            when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                            when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                    ) as tempo
                                where interacao.tipo like 'POST' and grupo.nome like 'Grupo do Vini' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final 
                        )
                    ) as tmp2
        ) as tmp8
        order by 1
    ) as tmp10
where grupo.nome like 'Grupo do Vini' and tmp10.nome like 'VINICIUS AAAA'
group by 2;

