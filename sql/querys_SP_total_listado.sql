CREATE PROCEDURE total_listado_memos(IN seccion INT, IN estado INT, IN usuario INT)
BEGIN
DECLARE maximos VARCHAR(300);
DECLARE consulta VARCHAR (1000);
DECLARE filtro VARCHAR(100)DEFAULT ' WHERE 1 = 1 ';
DECLARE orden VARCHAR(100) DEFAULT ' ORDER BY m.memo_fecha_recepcion ASC, m.memo_fecha_memo DESC';
/*DECLARE pagina VARCHAR (50);*/
DECLARE agregajoinusuario VARCHAR (100) DEFAULT ' LEFT JOIN asigna_usuario as mtu ON mtu.asigna_usuario_memo_id = m.memo_id ';

/*SET pagina = CONCAT(' LIMIT ',inicio,',',fin);*/

	IF seccion = 1 THEN
		SET maximos = 'SELECT cambio_estados_memo_id, max(ce.cambio_estados_memo_estado_id) as estado_max_id FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id GROUP by ce.cambio_estados_memo_id';
	ELSEIF seccion=2 THEN
		SET maximos = 'SELECT cambio_estados_memo_id, max(ce.cambio_estados_memo_estado_id) as estado_max_id FROM cambio_estados as ce, memo_estado as me  WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id AND me.memo_estado_seccion_id = 2 GROUP by ce.cambio_estados_memo_id';
	ELSEIF seccion=3 THEN
		SET maximos = 'SELECT cambio_estados_memo_id, max(ce.cambio_estados_memo_estado_id) as estado_max_id FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id AND me.memo_estado_seccion_id = 3 GROUP by ce.cambio_estados_memo_id';
	END IF;

	SET @consulta = CONCAT('SELECT count(*) AS cantidad FROM (',maximos,') AS TABLA_MEM_MAX LEFT JOIN memo as m ON m.memo_id = cambio_estados_memo_id LEFT JOIN memo_estado as met ON met.memo_estado_id = estado_max_id INNER JOIN departamento as dep ON dep.dpto_id = m.memo_depto_solicitante_id ');

	IF usuario<>0 and seccion = 3 THEN
		SET @consulta = CONCAT(@consulta,agregajoinusuario);
	END IF;

	SET @consulta = CONCAT(@consulta,filtro);

	IF estado <> 0 THEN
		SET @consulta = concat(@consulta,' AND estado_max_id=',estado);
	END IF;

	IF usuario <> 0 and seccion = 3 THEN
		SET @consulta = concat(@consulta,' AND mtu.asigna_usuario_usuario_id=',usuario);
	END IF;

	SET @consulta = concat(@consulta,orden);
	/*SET @consulta = concat(@consulta,pagina);*/

	

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEA