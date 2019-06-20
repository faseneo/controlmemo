CREATE FUNCTION estado_max (memid int)

BEGIN
	DECLARE estado_max_id int;
	
	SELECT max(cambio_estados_id) INTO estado_max_id FROM cambio_estados WHERE cambio_estados_memo_id = memid;

	RETURN estado_max_id;
END


CREATE FUNCTION estado_max (memid int,dptoid int )
BEGIN
	DECLARE estado_max_id int;
	IF dptoid <> 0  THEN
		SELECT max(cambio_estados_id) INTO estado_max_id	
		FROM cambio_estados
		WHERE cambio_estados_memo_id = memid
		AND cambio_estados_memo_estado_id in(SELECT me.memo_estado_id 
																				FROM memo_estado as me
																				WHERE me.memo_estado_depto_id=dptoid);
	ELSE
		SELECT max(cambio_estados_id) INTO estado_max_id FROM cambio_estados WHERE cambio_estados_memo_id = memid;

	END IF;
	RETURN estado_max_id;
END