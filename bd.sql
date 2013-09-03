
CREATE DATABASE `consultorio` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci */;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


INSERT INTO `usuarios`(`id`,`usuario`,`password`) VALUES(1,'g3rcar',md5('test'));