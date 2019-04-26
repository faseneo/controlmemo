CREATE PROCEDURE total_listado_memos_estado_depto(IN deptosol INT,IN deptodes INT,  IN estado INT, IN usuario INT, IN anio INT)
BEGIN
DECLARE maximos VARCHAR(300);
DECLARE consulta VARCHAR (1000);
DECLARE filtro VARCHAR(100)DEFAULT ' WHERE 1 = 1 ';

SET maximos = 'SELECT estado_max(mm.memo_id) as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_recepcion,
					 mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id
			   FROM memo as mm WHERE 1=1 ';

	IF deptosol <> 1 THEN
		SET filtro = CONCAT(filtro,' AND memo_depto_solicitante_id = ',deptosol);
	END IF;

	IF deptoDES <> 1 THEN
		SET filtro = CONCAT(filtro,' AND memo_depto_destinatario_id = ',deptodes);
	END IF;


	SET @consulta = CONCAT('SELECT count(*) AS cantidad FROM (',maximos,') AS TABLA_MEM_MAX 
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

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEALLOCATE PREPARE smpt;
END