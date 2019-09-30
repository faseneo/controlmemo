CREATE FUNCTION estado_max_det (medetid INT, usuid INT)
BEGIN
	DECLARE estado_max_det_id INT;

	IF usuid > 1  THEN
		SELECT max(cambio_estados_detmemo_id) INTO estado_max_det_id	
		FROM cambio_estados_detmemo
		WHERE cambio_estados_detmemo_detmemo_id = medetid AND cambio_estados_detmemo_usu_id = usuid;
	ELSE
		SELECT max(cambio_estados_detmemo_id) INTO estado_max_det_id	
		FROM cambio_estados_detmemo
		WHERE cambio_estados_detmemo_detmemo_id = medetid;
	END IF;

	RETURN estado_max_det_id;
END