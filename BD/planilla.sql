SELECT dnl.id, dnl.fecha, 
(SELECT GROUP_CONCAT(sede) 
	FROM m_sedes  s 
	WHERE FIND_IN_SET(s.id,dnl.sede_ids)) sede
FROM m_dias_no_laborables dnl

 ALTER TABLE m_horarios_plantillas
 ADD horario_amanecida INT DEFAULT 0 
	AFTER hora_fin;
	
-- Muestra Horario Plantillas
SELECT hp.id, hp.plantilla_descripcion, hp.hora_inicio, hp.hora_fin, hp.horario_amanecida,
(SELECT REPLACE(GROUP_CONCAT(d.dia_apocope), ",", " - ")
	FROM a_dias d 
	WHERE FIND_IN_SET(d.id, dia_ids)) dia_apocope,
(SELECT GROUP_CONCAT(d.id, "-", d.dia) 
	FROM a_dias d 
	WHERE FIND_IN_SET(d.id, dia_ids)) dias
FROM m_horarios_plantillas hp
WHERE hp.estado = 1;

SELECT hp.id, hp.dia_ids, hp.hora_inicio, hora_fin
	FROM m_horarios_plantillas hp
		WHERE hp.estado = 1
			AND hp.id = 1;

-- Muestra Horario Programados
SELECT hpro.horario_plantilla_id,
			(REPLACE(GROUP_CONCAT(d.dia, "-", hpro.hora_inicio, "-", hp.hora_fin, "-", hpro.tolerancia), ",", "|")) as horas_programadas, 
			hpro.estado
FROM p_horarios_programados hpro
INNER JOIN a_dias d ON d.id = hpro.dia_id
INNER JOIN m_horarios_plantillas hp ON hp.id = hpro.horario_plantilla_id
WHERE hpro.estado = 1
GROUP BY hpro.horario_plantilla_id, hpro.estado;