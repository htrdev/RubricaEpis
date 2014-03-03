-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.1.41 - Source distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para rubricaepis
CREATE DATABASE IF NOT EXISTS `rubricaepis` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `rubricaepis`;


-- Volcando estructura para tabla rubricaepis.asignacioncriterioevaluacion
CREATE TABLE IF NOT EXISTS `asignacioncriterioevaluacion` (
  `idAsignacionCriterioEvaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `ModeloRubrica_idModeloRubrica` int(11) NOT NULL,
  `CriterioEvaluacion_idCriterioEvaluacion` int(11) NOT NULL,
  PRIMARY KEY (`idAsignacionCriterioEvaluacion`),
  KEY `fk_AsginacionCriterioEvaluacion_ModeloRubrica1_idx` (`ModeloRubrica_idModeloRubrica`),
  KEY `fk_AsginacionCriterioEvaluacion_CriterioEvaluacion1_idx` (`CriterioEvaluacion_idCriterioEvaluacion`),
  CONSTRAINT `fk_AsginacionCriterioEvaluacion_CriterioEvaluacion1` FOREIGN KEY (`CriterioEvaluacion_idCriterioEvaluacion`) REFERENCES `criterioevaluacion` (`idCriterioEvaluacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_AsginacionCriterioEvaluacion_ModeloRubrica1` FOREIGN KEY (`ModeloRubrica_idModeloRubrica`) REFERENCES `modelorubrica` (`idModeloRubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.asignacioncriterioevaluacion: ~88 rows (aproximadamente)
/*!40000 ALTER TABLE `asignacioncriterioevaluacion` DISABLE KEYS */;
INSERT INTO `asignacioncriterioevaluacion` (`idAsignacionCriterioEvaluacion`, `ModeloRubrica_idModeloRubrica`, `CriterioEvaluacion_idCriterioEvaluacion`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 1, 5),
	(6, 1, 6),
	(7, 1, 7),
	(8, 1, 8),
	(9, 1, 9),
	(10, 1, 10),
	(11, 2, 11),
	(12, 2, 12),
	(13, 2, 13),
	(14, 2, 14),
	(15, 1, 11),
	(20, 2, 1),
	(21, 2, 2),
	(22, 2, 1),
	(23, 2, 2),
	(24, 4, 1),
	(25, 4, 2),
	(26, 5, 1),
	(27, 5, 2),
	(30, 13, 1),
	(31, 13, 2),
	(34, 15, 1),
	(35, 15, 2),
	(36, 16, 1),
	(37, 16, 2),
	(38, 17, 1),
	(39, 17, 2),
	(40, 18, 1),
	(41, 18, 2),
	(42, 19, 1),
	(43, 19, 2),
	(44, 20, 1),
	(45, 20, 2),
	(46, 21, 1),
	(47, 21, 2),
	(48, 22, 1),
	(49, 22, 2),
	(50, 23, 1),
	(51, 23, 2),
	(52, 24, 1),
	(53, 24, 2),
	(54, 25, 1),
	(55, 25, 2),
	(56, 26, 1),
	(57, 26, 2),
	(58, 27, 1),
	(59, 27, 2),
	(60, 28, 1),
	(61, 28, 2),
	(62, 29, 1),
	(63, 29, 2),
	(64, 30, 1),
	(65, 30, 2),
	(66, 31, 1),
	(67, 31, 2),
	(68, 32, 1),
	(69, 32, 2),
	(70, 33, 1),
	(71, 33, 2),
	(72, 34, 1),
	(73, 34, 2),
	(74, 35, 1),
	(75, 35, 2),
	(76, 36, 1),
	(77, 36, 2),
	(78, 37, 1),
	(79, 37, 2),
	(80, 48, 1),
	(81, 49, 1),
	(82, 50, 1),
	(83, 54, 2),
	(84, 54, 3),
	(85, 54, 9),
	(86, 54, 10),
	(87, 54, 8),
	(88, 54, 7),
	(89, 55, 3),
	(90, 55, 2),
	(91, 55, 9),
	(92, 55, 10),
	(93, 55, 8),
	(94, 55, 7),
	(95, 5, 4),
	(96, 5, 5);
/*!40000 ALTER TABLE `asignacioncriterioevaluacion` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.asignacionpersonacalificada
CREATE TABLE IF NOT EXISTS `asignacionpersonacalificada` (
  `ResultadoRubrica_idResultadoRubrica` int(11) NOT NULL,
  `idPersonaCalificada` int(11) DEFAULT NULL,
  KEY `fk_AsignacionPersonaCalificada_ResultadoRubrica1_idx` (`ResultadoRubrica_idResultadoRubrica`),
  CONSTRAINT `fk_AsignacionPersonaCalificada_ResultadoRubrica1` FOREIGN KEY (`ResultadoRubrica_idResultadoRubrica`) REFERENCES `resultadorubrica` (`idResultadoRubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.asignacionpersonacalificada: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `asignacionpersonacalificada` DISABLE KEYS */;
INSERT INTO `asignacionpersonacalificada` (`ResultadoRubrica_idResultadoRubrica`, `idPersonaCalificada`) VALUES
	(4, 7),
	(4, 8),
	(6, 6),
	(6, 7),
	(3, 5),
	(14, 10);
/*!40000 ALTER TABLE `asignacionpersonacalificada` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.calificacioncriterioevaluacion
CREATE TABLE IF NOT EXISTS `calificacioncriterioevaluacion` (
  `Rubrica_idResultadoRubrica` int(11) NOT NULL,
  `calificacionResultadoRubrica` decimal(8,2) DEFAULT '0.00',
  `AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion` int(11) NOT NULL,
  KEY `fk_ResultadoRubrica_Rubrica1_idx` (`Rubrica_idResultadoRubrica`),
  KEY `fk_ResultadoCriterioEvaluacion_AsginacionCriterioEvaluacion_idx` (`AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion`),
  CONSTRAINT `fk_ResultadoCriterioEvaluacion_AsginacionCriterioEvaluacion1` FOREIGN KEY (`AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion`) REFERENCES `asignacioncriterioevaluacion` (`idAsignacionCriterioEvaluacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ResultadoRubrica_Rubrica1` FOREIGN KEY (`Rubrica_idResultadoRubrica`) REFERENCES `resultadorubrica` (`idResultadoRubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.calificacioncriterioevaluacion: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `calificacioncriterioevaluacion` DISABLE KEYS */;
INSERT INTO `calificacioncriterioevaluacion` (`Rubrica_idResultadoRubrica`, `calificacionResultadoRubrica`, `AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion`) VALUES
	(3, 50.00, 26),
	(3, 35.00, 27),
	(4, 10.00, 26),
	(6, 50.00, 26),
	(4, 20.00, 27),
	(6, 40.00, 27),
	(3, 33.00, 95),
	(3, 44.00, 96),
	(4, 40.00, 95),
	(4, 50.00, 96),
	(6, 70.00, 95),
	(6, 80.00, 96);
/*!40000 ALTER TABLE `calificacioncriterioevaluacion` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.criterioevaluacion
CREATE TABLE IF NOT EXISTS `criterioevaluacion` (
  `idCriterioEvaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionCriterioEvaluacion` text,
  `ResultadoAprendizaje_idResultadoAprendizaje` int(11) NOT NULL,
  PRIMARY KEY (`idCriterioEvaluacion`),
  KEY `fk_CriterioEvaluacion_ResultadoAprendizaje1_idx` (`ResultadoAprendizaje_idResultadoAprendizaje`),
  CONSTRAINT `fk_CriterioEvaluacion_ResultadoAprendizaje1` FOREIGN KEY (`ResultadoAprendizaje_idResultadoAprendizaje`) REFERENCES `resultadoaprendizaje` (`idResultadoAprendizaje`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.criterioevaluacion: ~24 rows (aproximadamente)
/*!40000 ALTER TABLE `criterioevaluacion` DISABLE KEYS */;
INSERT INTO `criterioevaluacion` (`idCriterioEvaluacion`, `descripcionCriterioEvaluacion`, `ResultadoAprendizaje_idResultadoAprendizaje`) VALUES
	(1, 'NOMESALE', 1),
	(2, 'Aplica modelos matematicos en la solucion de problemas', 1),
	(3, 'Aplica conocimientos y tecnicas matematicas para analizar, modelar y simular soluciones de TI', 1),
	(4, 'Determina las pruebas y experimentos a realizar tomando en cuenta los estandares de calidad de requerimientos', 2),
	(5, 'Identifica y relaciona las variables de los sistemas de software e informacion y los mide o estima con la presicion requerida', 2),
	(6, 'Determina los equipos y herramientas informaticas de acuerdo a las pruebas de realizacion', 2),
	(7, 'Recopila informacion relevante de pruebas y experimentos similares y complementarios', 2),
	(8, 'Procesa y Analiza resultados usnado metodos y criterios estadisticos', 2),
	(9, 'Identifica y define el problema a resolver, formula los requerimientos y los traduce en un procesos de un sistema informatico', 3),
	(10, 'Formula y analiza las especificaciones del proyecto de diseño considerando restricciones tanto tecnicas como economicas, sociales, y las legales, asi como las caracteristicas propias del negocio y de la organizacion', 3),
	(11, 'Representa y describe la solucion a traves de diagramas, y formula las especificaciones finales usando normas y estandares apropiados', 13),
	(12, 'Propone y evalua diversas arquitecturas y soluciones, selecciona la mas adecuada satisfaciendo los requerimientos y restricciones de seguridad', 12),
	(13, 'Participa como lider o mienro de un equipo de trabajo contribuyendo efectivamente en el logro de metras y resultados propuestos', 12),
	(14, 'Valora y considera las diferencias de opinion, respetando los acuerdos que conducen al logro de objetivos y resultados', 13),
	(15, 'Se preocupa y promueve el bienestar e integracion del equipo de trabajo', 16),
	(22, 'Criterio 1 Prueba Final\n', 18),
	(23, 'Criterio 2 Prueba Final', 18),
	(24, 'Criterio 1 Prueba Final con Default', 19),
	(25, 'Criterio 2 Prueba Final con Default', 19),
	(26, 'Criterio 1 Prueba Final con Default 2', 20),
	(27, 'Criterio 4 Prueba Final con Default 2', 20),
	(35, '4324324', 22),
	(36, 'XDD', 23),
	(37, '234234', 24);
/*!40000 ALTER TABLE `criterioevaluacion` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.modelorubrica
CREATE TABLE IF NOT EXISTS `modelorubrica` (
  `idModeloRubrica` int(11) NOT NULL AUTO_INCREMENT,
  `fechaCreacionRubrica` date NOT NULL,
  `fechaInicioRubrica` date DEFAULT NULL,
  `fechaFinalRubrica` date DEFAULT NULL,
  `calificacionRubrica` varchar(45) DEFAULT NULL,
  `Docente_Persona_idPersona` int(11) NOT NULL,
  `Curso_idCurso` int(11) NOT NULL,
  `Semestre_idSemestre` int(11) NOT NULL,
  `tipoModeloRubrica` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idModeloRubrica`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.modelorubrica: ~38 rows (aproximadamente)
/*!40000 ALTER TABLE `modelorubrica` DISABLE KEYS */;
INSERT INTO `modelorubrica` (`idModeloRubrica`, `fechaCreacionRubrica`, `fechaInicioRubrica`, `fechaFinalRubrica`, `calificacionRubrica`, `Docente_Persona_idPersona`, `Curso_idCurso`, `Semestre_idSemestre`, `tipoModeloRubrica`) VALUES
	(1, '2014-02-04', '2014-02-04', '2014-11-04', 'docente', 1, 1, 1, NULL),
	(2, '2014-05-04', '2014-05-04', '2014-11-04', 'alumno', 1, 1, 1, NULL),
	(4, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(5, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(13, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(15, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(16, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(17, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(18, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(19, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(20, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(21, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(22, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(23, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(24, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(25, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(26, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(27, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(28, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(29, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(30, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(31, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(32, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(33, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(34, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(35, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(36, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(37, '0000-00-00', '2014-05-05', '2014-06-06', 'docente', 1, 1, 1, NULL),
	(41, '0000-00-00', '2014-12-12', '2014-12-15', '1', 0, 1, 2, NULL),
	(42, '0000-00-00', '2014-12-12', '2014-12-15', '1', 0, 1, 2, NULL),
	(48, '0000-00-00', '2014-12-12', '2014-12-15', 'Alumnos', 1, 1, 2, NULL),
	(49, '0000-00-00', '2014-12-12', '2014-12-15', 'Alumnos', 1, 1, 2, NULL),
	(50, '0000-00-00', '2014-12-12', '2014-12-15', 'Alumnos', 1, 1, 2, NULL),
	(51, '0000-00-00', '0000-00-00', '0000-00-00', '', 0, 0, 0, NULL),
	(52, '0000-00-00', '0000-00-00', '0000-00-00', '', 0, 0, 0, NULL),
	(53, '0000-00-00', '0000-00-00', '0000-00-00', '', 0, 0, 0, NULL),
	(54, '0000-00-00', '0000-00-00', '0000-00-00', 'Alumnos', 0, 0, 0, NULL),
	(55, '0000-00-00', '0000-00-00', '0000-00-00', 'Alumnos', 1, 2, 1, NULL);
/*!40000 ALTER TABLE `modelorubrica` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.resultadoaprendizaje
CREATE TABLE IF NOT EXISTS `resultadoaprendizaje` (
  `idResultadoAprendizaje` int(11) NOT NULL AUTO_INCREMENT,
  `definicionResultadoAprendizaje` text,
  `tituloResultadoAprendizaje` text,
  `codigoResultadoAprendizaje` varchar(10) DEFAULT NULL,
  `tipoResultadoAprendizaje` varchar(50) DEFAULT 'Docente',
  PRIMARY KEY (`idResultadoAprendizaje`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.resultadoaprendizaje: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `resultadoaprendizaje` DISABLE KEYS */;
INSERT INTO `resultadoaprendizaje` (`idResultadoAprendizaje`, `definicionResultadoAprendizaje`, `tituloResultadoAprendizaje`, `codigoResultadoAprendizaje`, `tipoResultadoAprendizaje`) VALUES
	(1, 'abc', 'Titulo 1', '1e', 'Escuela'),
	(2, 'Diseñan y conducen expermentos, analizan e interpretan datos', 'Titulo 2', '2b', 'Escuela'),
	(3, 'Diseña sisteas informaticos, componentes y/o procesos para satisfacer requerimientos considerando resticciones realistas de seguridad y sostenibilidad', 'Diseño en Ingenieria', '3c', 'Escuela'),
	(4, 'Participa activa y efectivamente en grupos multidisciplinarios siendo capaces de liderarlos', 'Trabajo en Equipo', '4d', 'Escuela'),
	(5, 'Identifica, formula y resuelve problemas de ingenieria usando las tecnicas, metodos y herramientas apropiados', 'Solucion de Problemas de Ingenieria', '5e', 'Escuela'),
	(6, 'Entienden sus responsabilidades profesionales, etcas, sociales y legales, y cumplen los compromisos asumidos', 'Responsabilidad etica y profesional', '6f', 'Escuela'),
	(7, 'Se comunican clara y efectivamente en fora oral, escrita y grafica, interactuando con diferentes tipos de audiencias', 'Comunicacion', '7g', 'Escuela'),
	(8, 'Comprende el impacto que tienen las soluciones de ingenieria en la sociedad en un contexto local y global', 'Perpectiva y Global', '8h', 'Escuela'),
	(9, 'Reconocen la necesidad de mantener sus conocimientos y habilidades actualizadas de acuerdo a los avances de la ingenieria de software y sistemas de informacion y se compromete con un aprendizaje para toda la vida', 'Educacion Continua', '9i', 'Escuela'),
	(10, 'Conoce y analiza asuntos contemporaneos relevantes en contextos locales, nacionales y globales', 'Asuntos Contemporaneos', '10j', 'Escuela'),
	(12, 'Aplica Modelos matematicos', 'trabajo unidad I', '12d', 'Docente'),
	(13, 'Dominio del tema', 'exposicion unidad I', '13a', 'Docente'),
	(14, 'Utilza componentes del software para la implementacion', 'exposicion unidad II', '14c', 'Docente'),
	(15, 'Considera dentro del proyecto aspectos de calidad, eficiencia y riesgos', 'exposicion unidad III', '15v', 'Docente'),
	(16, 'Comprende el tema', 'trabajo unidad II', '16c', 'Docente'),
	(17, 'c', 'b', 'a', 'Docente'),
	(18, 'Definicion Prueba Final', 'RA Prueba Final', '11x', 'Docente'),
	(19, 'Defincion Prueba Final con Default', 'Prueba Final con Default', '12X', 'Docente'),
	(20, 'Definicion Prueba Final con Default 2', 'Titulo 20', '13X', 'Docente'),
	(22, '123', '123', '123', 'Docente'),
	(23, 'XDD', 'XD', 'XD', 'Docente'),
	(24, '534534534', '534543543', '4543543', 'Docente');
/*!40000 ALTER TABLE `resultadoaprendizaje` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.resultadoaprendizajedocente
CREATE TABLE IF NOT EXISTS `resultadoaprendizajedocente` (
  `ResultadoAprendizaje_idResultadoAprendizaje` int(11) NOT NULL,
  `Docente_Persona_idPersona` int(11) NOT NULL,
  PRIMARY KEY (`ResultadoAprendizaje_idResultadoAprendizaje`),
  CONSTRAINT `fk_ResultadoAprendizajeDocente_ResultadoAprendizaje1` FOREIGN KEY (`ResultadoAprendizaje_idResultadoAprendizaje`) REFERENCES `resultadoaprendizaje` (`idResultadoAprendizaje`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.resultadoaprendizajedocente: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `resultadoaprendizajedocente` DISABLE KEYS */;
INSERT INTO `resultadoaprendizajedocente` (`ResultadoAprendizaje_idResultadoAprendizaje`, `Docente_Persona_idPersona`) VALUES
	(12, 1),
	(13, 1),
	(14, 2),
	(15, 2),
	(16, 1);
/*!40000 ALTER TABLE `resultadoaprendizajedocente` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.resultadorubrica
CREATE TABLE IF NOT EXISTS `resultadorubrica` (
  `idResultadoRubrica` int(11) NOT NULL AUTO_INCREMENT,
  `fechaCompletadoRubrica` date DEFAULT NULL,
  `idDocenteCalificador` int(11) DEFAULT NULL,
  `ModeloRubrica_idModelRubrica` int(11) DEFAULT NULL,
  `estadoRubrica` varchar(15) DEFAULT NULL,
  `totalRubrica` decimal(8,2) DEFAULT '0.00',
  PRIMARY KEY (`idResultadoRubrica`),
  KEY `ModeloRubrica_idModelRubrica` (`ModeloRubrica_idModelRubrica`),
  CONSTRAINT `ModeloRubrica_idModelRubrica` FOREIGN KEY (`ModeloRubrica_idModelRubrica`) REFERENCES `modelorubrica` (`idModeloRubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.resultadorubrica: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `resultadorubrica` DISABLE KEYS */;
INSERT INTO `resultadorubrica` (`idResultadoRubrica`, `fechaCompletadoRubrica`, `idDocenteCalificador`, `ModeloRubrica_idModelRubrica`, `estadoRubrica`, `totalRubrica`) VALUES
	(1, '0000-00-00', 3, 17, 'Completado', 23.00),
	(2, '0000-00-00', 1, 32, 'Pendiente', 0.00),
	(3, '0000-00-00', 2, 5, 'Pendiente', 0.00),
	(4, '0000-00-00', 1, 5, 'Completado', 40.00),
	(5, '0000-00-00', 1, 33, 'Pendiente', 50.00),
	(6, '0000-00-00', 1, 5, 'Pendiente', 0.00),
	(7, '0000-00-00', 2, 34, 'Pendiente', 0.00),
	(8, '0000-00-00', 1, 35, 'Pendiente', 0.00),
	(9, '0000-00-00', 2, 35, 'Pendiente', 0.00),
	(10, '0000-00-00', 1, 36, 'Pendiente', 0.00),
	(11, '0000-00-00', 2, 36, 'Pendiente', 0.00),
	(12, '0000-00-00', 1, 37, 'Pendiente', 0.00),
	(13, '0000-00-00', 2, 37, 'Pendiente', 0.00),
	(14, '2014-03-01', 1, 33, 'Completado', 0.00);
/*!40000 ALTER TABLE `resultadorubrica` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL,
  `passwordUsuario` varchar(45) DEFAULT NULL,
  `tipoUsuario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.usuario: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`idUsuario`, `passwordUsuario`, `tipoUsuario`) VALUES
	(1, '1234', 'Docente'),
	(2, '1234', 'Docente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
