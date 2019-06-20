SELECT estado_max_id,memo_id, memo_num_memo, memo_anio, memo_fecha_recepcion, 
							memo_fecha_memo, memo_materia, memo_fecha_ingreso, memo_depto_solicitante_id, memo_depto_destinatario_id,
							dep.depto_nombre, dep2.depto_nombre as depto_nombre_dest, met.memo_estado_tipo, met.memo_estado_color_bg, met.memo_estado_color_font, 
							cei.cambio_estados_memo_estado_id,cei.cambio_estados_observacion, cei.cambio_estados_fecha,
							DATEDIFF(CURDATE() ,cei.cambio_estados_fecha) as cambio_estados_dias, cei.cambio_estados_usuario_id
			FROM (SELECT estado_max(mm.memo_id,9) as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_recepcion,
					 mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id
			   FROM memo as mm WHERE 1=1 ) AS TABLA_MEM_MAX
			LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
			LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
			INNER JOIN departamento as dep2 ON dep2.depto_id = memo_depto_destinatario_id
			INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id  WHERE 1 = 1  ORDER BY cambio_estados_dias DESC, memo_fecha_recepcion ASC, memo_fecha_memo DESC LIMIT 0,10


SELECT estado_max_id,memo_id, memo_num_memo, memo_anio, memo_fecha_recepcion, 
							memo_fecha_memo, memo_materia, memo_fecha_ingreso, memo_depto_solicitante_id, memo_depto_destinatario_id,
							dep.depto_nombre, dep2.depto_nombre as depto_nombre_dest, met.memo_estado_tipo, met.memo_estado_color_bg, met.memo_estado_color_font, 
							cei.cambio_estados_memo_estado_id,cei.cambio_estados_observacion, cei.cambio_estados_fecha,
							DATEDIFF(CURDATE() ,cei.cambio_estados_fecha) as cambio_estados_dias, cei.cambio_estados_usuario_id
			FROM (SELECT estado_max(mm.memo_id,87) as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_recepcion,
					 mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id
			   FROM memo as mm 
				 INNER JOIN memo_derivado as mdev ON mdev.memo_derivado_memo_id = memo_id
				 WHERE 1=1 AND mdev.memo_derivado_dpto_id=87) AS TABLA_MEM_MAX
			LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
			LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
			INNER JOIN departamento as dep2 ON dep2.depto_id = memo_depto_destinatario_id
			INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id  
WHERE 1 = 1  
ORDER BY cambio_estados_dias DESC, memo_fecha_recepcion ASC, memo_fecha_memo DESC 
LIMIT 0,10


//cambia dpto_tiene_usu_principal = 1 por query, no esta implementado en el mantenedor
UPDATE dpto_tiene_usu SET dpto_tiene_usu_principal = 1
WHERE dpto_tiene_usu_depto_id = 82 AND dpto_tiene_usu_usuario_id = 6