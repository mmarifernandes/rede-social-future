

    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL and interacao.ativo = 1

union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
        from interacao
        where interacao.usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL
        order by 1 desc) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in (select referencia
        from interacao
        where interacao.usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL
        order by 1 desc) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1 and grupo IS NULL
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in
    (select case when referencia is null then -1 else referencia end as referencia
        from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
        where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1 and interacao.grupo IS NULL) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.grupo IS NULL
    group by interacao.codigo
    having (
    (select interacao.codigo
        from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
        where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and interacao.grupo IS NULL and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 0) = interacao.codigo) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = 'MARINA@MARINA.COM'











select interacao.codigo, usuario.nome as usuario, citacao_usuario.usuario_marcado as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
from citacao_usuario join interacao on interacao.usuario = citacao_usuario.usuario_marcado join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
where interacao.ativo = 1 and citacao_usuario.ativo = 1 and citacao_usuario.usuario_marcado = 'MARINA@MARINA.COM'










    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL and interacao.ativo = 1

union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
        from interacao
        where interacao.usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL
        order by 1 desc) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in (select referencia
        from interacao
        where interacao.usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL
        order by 1 desc) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1 and interacao.grupo IS NULL
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in
    (select case when referencia is null then -1 else referencia end as referencia
        from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
        where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1 and interacao.grupo IS NULL) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.grupo IS NULL
    group by interacao.codigo
    having (
    (select interacao.codigo
        from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
        where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and interacao.grupo IS NULL and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 0) = interacao.codigo) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = 'MARINA@MARINA.COM'
union
    select interacao.codigo, usuario.nome as usuario, citacao_usuario.usuario_marcado as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from citacao_usuario join interacao on interacao.usuario = citacao_usuario.usuario_marcado join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and citacao_usuario.ativo = 1 and citacao_usuario.usuario_marcado = 'MARINA@MARINA.COM'

















UPDATE interacao
SET ativo = 0
FROM interacao AS c
WHERE c.codigo = 1 and c.codigo in (
        
select interacao.codigo
from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
where usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL and interacao.ativo = 1
    UNION 
select interacao.codigo
from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
where referencia in (select codigo
from interacao
where interacao.usuario = 'MARINA@MARINA.COM'
order by 1 desc)
) and c.codigo = 1













update interacao set ativo = 1 where
(select interacao.codigo
    where usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL and interacao.ativo = 1) = 1
union
    select interacao.codigo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
    from interacao
    where interacao.usuario = 'MARINA@MARINA.COM'
    order by 1 desc)
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in (select referencia
    from interacao
    where interacao.usuario = 'MARINA@MARINA.COM'
    order by 1 desc))
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in
    (select case when referencia is null then -1 else referencia end as referencia
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1)
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    group by interacao.codigo
    having (
    (select interacao.codigo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 0) = interacao.codigo)
union
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = 'MARINA@MARINA.COM'
)


-- INTERACOES GRUPO
union
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = 'MARINA@MARINA.COM'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.codigo in (select referencia
    from amizade join interacao on interacao.usuario = amizade.usuario1
    where usuario1 = 'MARINA@MARINA.COM')
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.codigo in (select referencia
    from amizade join interacao on interacao.usuario = amizade.usuario1
    where usuario1 = 'MARINA@MARINA.COM'and amizade.ativo = 1)




select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.usuario = 'MARINA@MARINA.COM' UNION SELECT interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    JOIN AMIZADE ON INTERACAO.USUARIO = AMIZADE.USUARIO1 WHERE USUARIO2 = 'MARINA@MARINA.COM' AND AMIZADE.ATIVO = 1 UNION SELECT interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.REFERENCIA IN (SELECT CODIGO FROM INTERACAO WHERE USUARIO = 'MARINA@MARINA.COM') UNION SELECT interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.CODIGO IN (SELECT REFERENCIA FROM INTERACAO WHERE USUARIO = 'MARINA@MARINA.COM') UNION SELECT interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.REFERENCIA IN (SELECT CODIGO FROM INTERACAO JOIN AMIZADE ON INTERACAO.USUARIO = AMIZADE.USUARIO1 WHERE USUARIO = USUARIO1 AND USUARIO2 = 'MARINA@MARINA.COM');



select USUARIO, CODIGO, CONTEUDO, REFERENCIA, TIPO from interacao where usuario = 'MARINA@MARINA.COM' UNION SELECT USUARIO, CODIGO, CONTEUDO, REFERENCIA, TIPO FROM INTERACAO JOIN AMIZADE ON INTERACAO.USUARIO = AMIZADE.USUARIO1 WHERE USUARIO2 = 'MARINA@MARINA.COM' AND AMIZADE.ATIVO = 1 UNION SELECT USUARIO, CODIGO, CONTEUDO, REFERENCIA,TIPO FROM INTERACAO WHERE REFERENCIA IN (SELECT CODIGO FROM INTERACAO WHERE USUARIO = 'MARINA@MARINA.COM') UNION SELECT USUARIO, CODIGO, CONTEUDO, REFERENCIA,TIPO FROM INTERACAO WHERE CODIGO IN (SELECT REFERENCIA FROM INTERACAO WHERE USUARIO = 'MARINA@MARINA.COM') UNION SELECT USUARIO, CODIGO, CONTEUDO, REFERENCIA,TIPO FROM INTERACAO WHERE CODIGO IN (SELECT REFERENCIA FROM INTERACAO JOIN AMIZADE ON INTERACAO.USUARIO = AMIZADE.USUARIO1 WHERE USUARIO2 = 'MARINA@MARINA.COM');




    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL and interacao.ativo = 1

union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
        from interacao
        order by 1 desc) and interacao.usuario != 'MARINA@MARINA.COM' and usuario2 = 'MARINA@MARINA.COM'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
    from interacao
    order by 1 desc) and usuario1 = 'MARINA@MARINA.COM'
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1
union
    -- INTERACOES GRUPO
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = 'MARINA@MARINA.COM'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.codigo in (select referencia
    from amizade join interacao on interacao.usuario = amizade.usuario1
    where usuario1 = 'MARINA@MARINA.COM')



        select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where usuario = 'MARINA@MARINA.COM' and interacao.grupo IS NULL and interacao.ativo = 1

union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in (select referencia
        from interacao
        order by 1 desc) and usuario2 = 'MARINA@MARINA.COM'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
        from interacao
        order by 1 desc) and usuario1 = 'MARINA@MARINA.COM'
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = 'MARINA@MARINA.COM' and amizade.ativo = 1
union
    -- INTERACOES GRUPO
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = 'MARINA@MARINA.COM'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.codigo in (select referencia
    from amizade join interacao on interacao.usuario = amizade.usuario1
    where usuario1 = 'MARINA@MARINA.COM')