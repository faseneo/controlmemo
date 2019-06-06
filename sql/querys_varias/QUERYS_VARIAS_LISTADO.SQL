SELECT * 
FROM memo AS m, memo_estado as me , departamento as dep  ,memo_tiene_usuario as mtu 
WHERE m.memo_memo_estado_id = me.memo_estado_id 
AND dep.dpto_id = m.memo_depto_solicitante_id 
AND m.memo_memo_estado_id=1 
ORDER BY m.memo_fecha_recepcion DESC  LIMIT 10,10

SELECT * 
FROM memo AS m, memo_estado as me , departamento as dep  ,memo_tiene_usuario as mtu 
WHERE m.memo_memo_estado_id = me.memo_estado_id 
AND dep.dpto_id = m.memo_depto_solicitante_id 
AND m.memo_memo_estado_id=1 
AND mtu.memo_tiene_usu_memo_id = m.memo_id 
AND mtu.memo_tiene_usu_usuario_id=1 
ORDER BY m.memo_fecha_recepcion DESC  
LIMIT 10,10

SELECT count(`memo_id`) as cantidad 
FROM memo AS m, memo_tiene_usuario as mtu 
WHERE m.memo_memo_estado_id=1 
AND mtu.memo_tiene_usu_memo_id = m.memo_id 
AND mtu.memo_tiene_usu_usuario_id=1