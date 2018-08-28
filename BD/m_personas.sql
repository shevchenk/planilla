-- CAMPOS DE LA TABLA "M_PERSONAS"
ALTER TABLE m_personas 
	ADD regina VARCHAR(100)
	AFTER fecha_nacimiento;

ALTER TABLE m_personas 
	ADD regina_anio YEAR(4)
	AFTER regina;

ALTER TABLE m_personas 
	ADD dina VARCHAR(100)
	AFTER regina_anio;

ALTER TABLE m_personas 
	ADD dina_anio YEAR(4)
	AFTER dina;

-- NUEVAS TABLAS AGREGADAS
CREATE TABLE `m_personas_grados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `universidad` varchar(200) DEFAULT NULL,
  `grado_instruccion` varchar(200) DEFAULT NULL,
  `anio` year(4) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `m_personas_investigaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `investiga` varchar(255) DEFAULT NULL,
  `anio` year(4) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


CREATE TABLE `m_personas_publicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `publica` varchar(255) DEFAULT NULL,
  `anio` year(4) DEFAULT NULL,
  `revista` varchar(255) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

