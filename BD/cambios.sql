INSERT INTO `personas` VALUES ('1', 'Admin', 'System', 'Software', '12312312', 'M', null, '$2y$10$GbcNEAXRTarkHEU/diSbA.vNd5eipLoV5f2RMpr5piMcJZb3NxIhK', 'z3IvnfgyTK0sOyr99QrwQhUU5avNPJpOfN2R47TdiuGQTWQiU1JYsMhFoTBM', null, null, null, null, '1', '2017-05-26 15:53:15', null, '1', null);INSERT INTO `personas` VALUES ('1', 'Admin', 'System', 'Software', '46487881', 'M', null, '$10$ucUoHOKUooZu9X08fItn8.PUSZqox76CKY5qlK6gkLo0UqStWA7d6', 'z3IvnfgyTK0sOyr99QrwQhUU5avNPJpOfN2R47TdiuGQTWQiU1JYsMhFoTBM', null, null, null, null, '1', '2017-05-26 15:53:15', null, '1', null);

INSERT INTO `menus` VALUES ('1', 'Mantenimiento', 'fa fa-cogs', '1', '2017-05-26 18:56:58', null, '1', null);

INSERT INTO `opciones` VALUES ('1', '1', 'Mantenimiento - Cargos', 'expertmanage.cargo.cargo', 'fa fa-sitemap', '1', '2017-05-26 19:00:25', null, '1', null);
INSERT INTO `opciones` VALUES ('2', '1', 'Mantenimiento - Cargos', 'basicmanage.cargo.cargo', 'fa fa-sitemap', '1', '2017-05-26 19:01:08', null, '1', null);
INSERT INTO `opciones` VALUES ('3', '1', 'Mantenimiento - Productos', 'expertmanage.producto.producto', 'fa fa-sitemap', '1', '2017-05-26 19:02:18', null, '1', null);
INSERT INTO `opciones` VALUES ('4', '1', 'Mantenimiento - Productos', 'basicmanage.producto.producto', 'fa fa-sitemap', '1', '2017-05-26 19:02:49', null, '1', null);
INSERT INTO `opciones` VALUES ('5', '1', 'Mantenimiento - Empresas', 'expertmanage.empresa.empresa', 'fa fa-sitemap', '1', '2017-05-26 19:03:08', null, '1', null);
INSERT INTO `opciones` VALUES ('6', '1', 'Mantenimiento - Empresas', 'basicmanage.empresa.empresa', 'fa fa-sitemap', '1', '2017-05-26 19:03:08', null, '1', null);

INSERT INTO `privilegios` VALUES ('1', 'Admin', '1', '2017-05-26 19:04:59', null, '1', null);

INSERT INTO `privilegios_opciones` VALUES ('1', '1', '1', '1', '2017-05-26 19:05:13', null, '1', null);
INSERT INTO `privilegios_opciones` VALUES ('2', '1', '2', '1', '2017-05-26 19:05:13', null, '1', null);
INSERT INTO `privilegios_opciones` VALUES ('3', '1', '3', '1', '2017-05-26 19:05:13', null, '1', null);
INSERT INTO `privilegios_opciones` VALUES ('4', '1', '4', '1', '2017-05-26 19:05:13', null, '1', null);
INSERT INTO `privilegios_opciones` VALUES ('5', '1', '5', '1', '2017-05-26 19:05:13', null, '1', null);
INSERT INTO `privilegios_opciones` VALUES ('6', '1', '6', '1', '2017-05-26 19:05:13', null, '1', null);

INSERT INTO `personas_privilegios_sucursales` VALUES ('1', '1', '1', null, null, null, '1', '2017-05-26 19:06:06', null, '1', null);

//*******************23/04/2018*****************//
ALTER TABLE `p_personas_contratos_historicos`
CHANGE COLUMN `ultimo_resgistro` `ultimo_registro`  int(11) NOT NULL DEFAULT 1 AFTER `asignacion_familiar`;

ALTER TABLE `m_eventos_tipos`
ADD COLUMN `aplica_cambio`  int(11) NOT NULL DEFAULT 0 COMMENT '0: Todo' AFTER `aplica_dscto`;

/**************** 26/08*****//

CREATE TABLE `m_cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso` varchar(250) NOT NULL,
  `curso_apocope` varchar(50) DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

