CREATE PROCEDURE listado_memo_por_estadomax_depto(IN deptosol INT,IN deptodes INT, IN estado INT, IN inicio INT, IN fin INT, IN usuario INT, IN anio INT)
BEGIN
DECLARE maximos VARCHAR(300);
DECLARE consulta VARCHAR (1000);
DECLARE filtro VARCHAR(100)DEFAULT ' WHERE 1 = 1 ';
DECLARE orden VARCHAR(100) DEFAULT ' ORDER BY cambio_estados_dias DESC, memo_fecha_recepcion ASC, memo_fecha_memo DESC';
DECLARE pagina VARCHAR (50);


SET pagina = CONCAT(' LIMIT ',inicio,',',fin);
SET maximos = 'SELECT estado_max(mm.memo_id) as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_recepcion,
					 mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id
			   FROM memo as mm WHERE 1=1 ';

	IF deptosol <> 1 THEN
		SET filtro = CONCAT(filtro,' AND memo_depto_solicitante_id = ',deptosol);
	END IF;

	IF deptoDES <> 1 THEN
		SET filtro = CONCAT(filtro,' AND memo_depto_destinatario_id = ',deptodes);
	END IF;

	SET @consulta = CONCAT('SELECT estado_max_id,memo_id, memo_num_memo, memo_anio, memo_fecha_recepcion, 
							memo_fecha_memo, memo_materia, memo_fecha_ingreso, memo_depto_solicitante_id, memo_depto_destinatario_id,
							dep.depto_nombre, met.memo_estado_tipo, met.memo_estado_color_bg, met.memo_estado_color_font, 
							cei.cambio_estados_memo_estado_id,cei.cambio_estados_observacion, cei.cambio_estados_fecha,
							DATEDIFF(CURDATE() ,cei.cambio_estados_fecha) as cambio_estados_dias, cei.cambio_estados_usuario_id
			FROM (',maximos,') AS TABLA_MEM_MAX
			LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
			LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
			INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id ');

	SET @consulta = CONCAT(@consulta,filtro);

	IF estado <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id=',estado);
	END IF;

	IF anio <> 0 THEN
		SET @consulta = concat(@consulta,' AND memo_anio=',anio);
	END IF;

	SET @consulta = concat(@consulta,orden);
	SET @consulta = concat(@consulta,pagina);

	/*select @consulta;*/

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEALLOCATE PREPARE smpt;
END