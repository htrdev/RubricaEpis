-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.1.41 - Source distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             8.3.0.4694
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.asignacioncriterioevaluacion: ~14 rows (aproximadamente)
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
	(14, 2, 14);
/*!40000 ALTER TABLE `asignacioncriterioevaluacion` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.asignacionpersonacalificada
CREATE TABLE IF NOT EXISTS `asignacionpersonacalificada` (
  `ResultadoRubrica_idResultadoRubrica` int(11) NOT NULL,
  `Persona_idPersona` int(11) DEFAULT NULL,
  KEY `fk_AsignacionPersonaCalificada_ResultadoRubrica1_idx` (`ResultadoRubrica_idResultadoRubrica`),
  CONSTRAINT `fk_AsignacionPersonaCalificada_ResultadoRubrica1` FOREIGN KEY (`ResultadoRubrica_idResultadoRubrica`) REFERENCES `resultadorubrica` (`idResultadoRubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.asignacionpersonacalificada: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `asignacionpersonacalificada` DISABLE KEYS */;
/*!40000 ALTER TABLE `asignacionpersonacalificada` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.calificacioncriterioevaluacion
CREATE TABLE IF NOT EXISTS `calificacioncriterioevaluacion` (
  `Rubrica_idResultadoRubrica` int(11) NOT NULL,
  `calificacionResultadoRubrica` decimal(8,2) DEFAULT NULL,
  `AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion` int(11) NOT NULL,
  KEY `fk_ResultadoRubrica_Rubrica1_idx` (`Rubrica_idResultadoRubrica`),
  KEY `fk_ResultadoCriterioEvaluacion_AsginacionCriterioEvaluacion_idx` (`AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion`),
  CONSTRAINT `fk_ResultadoCriterioEvaluacion_AsginacionCriterioEvaluacion1` FOREIGN KEY (`AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion`) REFERENCES `asignacioncriterioevaluacion` (`idAsignacionCriterioEvaluacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ResultadoRubrica_Rubrica1` FOREIGN KEY (`Rubrica_idResultadoRubrica`) REFERENCES `resultadorubrica` (`idResultadoRubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.calificacioncriterioevaluacion: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `calificacioncriterioevaluacion` DISABLE KEYS */;
INSERT INTO `calificacioncriterioevaluacion` (`Rubrica_idResultadoRubrica`, `calificacionResultadoRubrica`, `AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion`) VALUES
	(1, 20.00, 1),
	(1, 35.00, 2),
	(1, 45.00, 3),
	(2, 35.00, 11),
	(2, 25.00, 12);
/*!40000 ALTER TABLE `calificacioncriterioevaluacion` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.criterioevaluacion
CREATE TABLE IF NOT EXISTS `criterioevaluacion` (
  `idCriterioEvaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionCriterioEvaluacion` text,
  `ResultadoAprendizaje_idResultadoAprendizaje` int(11) NOT NULL,
  PRIMARY KEY (`idCriterioEvaluacion`),
  KEY `fk_CriterioEvaluacion_ResultadoAprendizaje1_idx` (`ResultadoAprendizaje_idResultadoAprendizaje`),
  CONSTRAINT `fk_CriterioEvaluacion_ResultadoAprendizaje1` FOREIGN KEY (`ResultadoAprendizaje_idResultadoAprendizaje`) REFERENCES `resultadoaprendizaje` (`idResultadoAprendizaje`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.criterioevaluacion: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `criterioevaluacion` DISABLE KEYS */;
INSERT INTO `criterioevaluacion` (`idCriterioEvaluacion`, `descripcionCriterioEvaluacion`, `ResultadoAprendizaje_idResultadoAprendizaje`) VALUES
	(1, 'Entiende e interpreta fenomenos naturales aplicando las leyes fundamentales que los gobiernan', 1),
	(2, 'Aplica modelos matematicos en la solucion de problemas', 1),
	(3, 'Aplica conocimientos y tecnicas matematicas para analizar, modelar y simular soluciones de TI', 1),
	(4, 'Determina las pruebas y experimentos a realizar tomando en cuenta los estandares de calidad de requerimientos', 2),
	(5, 'Identifica y relaciona las variables de los sistemas de software e informacion y los mide o estima con la presicion requerida', 2),
	(6, 'Determina los equipos y herramientas informaticas de acuerdo a las pruebas de realizacion', 2),
	(7, 'Recopila informacion relevante de pruebas y experimentos similares y complementarios', 2),
	(8, 'Procesa y Analiza resultados usnado metodos y criterios estadisticos', 2),
	(9, 'Identifica y define el problema a resolver, formula los requerimientos y los traduce en un procesos de un sistema informatico', 3),
	(10, 'formula y analiza las especificaciones del proyecto de diseño considerando restricciones tanto tecnicas como economicas, sociales, y las legales, asi como las caracteristicas propias del negocio y de la organizacion', 3),
	(11, 'representa y describe la solucion a traves de diagramas, y formula las especificaciones finales usando normas y estandares apropiados', 3),
	(12, 'propone y evalua diversas arquitecturas y soluciones, selecciona la mas adecuada satisfaciendo los requerimientos y restricciones de seguridad', 3),
	(13, 'participa como lider o mienro de un equipo de trabajo contribuyendo efectivamente en el logro de metras y resultados propuestos', 4),
	(14, 'valora y considera las diferencias de opinion, respetando los acuerdos que conducen al logro de objetivos y resultados', 4),
	(15, 'se preocupa y promueve el bienestar e integracion del equipo de trabajo', 4);
/*!40000 ALTER TABLE `criterioevaluacion` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.modelorubrica
CREATE TABLE IF NOT EXISTS `modelorubrica` (
  `idModeloRubrica` int(11) NOT NULL AUTO_INCREMENT,
  `fechaCreacionRubrica` date DEFAULT NULL,
  `fechaInicioRubrica` date DEFAULT NULL,
  `fechaFinalRubrica` date DEFAULT NULL,
  `calificacionRubrica` varchar(45) DEFAULT NULL,
  `Docente_Persona_idPersona` int(11) NOT NULL,
  `Curso_idCurso` int(11) NOT NULL,
  `Semestre_idSemestre` int(11) NOT NULL,
  PRIMARY KEY (`idModeloRubrica`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.modelorubrica: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `modelorubrica` DISABLE KEYS */;
INSERT INTO `modelorubrica` (`idModeloRubrica`, `fechaCreacionRubrica`, `fechaInicioRubrica`, `fechaFinalRubrica`, `calificacionRubrica`, `Docente_Persona_idPersona`, `Curso_idCurso`, `Semestre_idSemestre`) VALUES
	(1, '2014-02-04', '2014-02-04', '2014-11-04', 'docente', 1, 1, 1),
	(2, '2014-05-04', '2014-05-04', '2014-11-04', 'alumno', 1, 1, 1);
/*!40000 ALTER TABLE `modelorubrica` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.resultadoaprendizaje
CREATE TABLE IF NOT EXISTS `resultadoaprendizaje` (
  `idResultadoAprendizaje` int(11) NOT NULL AUTO_INCREMENT,
  `definicionResultadoAprendizaje` text,
  `tituloResultadoAprendizaje` text,
  PRIMARY KEY (`idResultadoAprendizaje`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.resultadoaprendizaje: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `resultadoaprendizaje` DISABLE KEYS */;
INSERT INTO `resultadoaprendizaje` (`idResultadoAprendizaje`, `definicionResultadoAprendizaje`, `tituloResultadoAprendizaje`) VALUES
	(1, 'Aplicacion de Ciencias', NULL),
	(2, 'Experimentacion y Pruebas', NULL),
	(3, 'Diseño en Ingenieria', NULL),
	(4, 'Trabajo en Equipo', NULL),
	(5, 'Solucion de Problemas de Ingenieria', NULL),
	(6, 'Responsabilidad etica y profesional', NULL),
	(7, 'Comunicacion', NULL),
	(8, 'Perpectiva y Global', NULL),
	(9, 'Educacion Continua', NULL),
	(10, 'Asuntos Contemporaneos', NULL),
	(11, 'Prueba definicion', 'Prueba titulo'),
	(12, 'examen unidad', 'examen'),
	(13, 'exposicion unidad I', NULL),
	(14, 'exposicion unidad II', NULL),
	(15, 'exposicion unidad III', NULL),
	(16, 'trabajo unidad I', NULL);
/*!40000 ALTER TABLE `resultadoaprendizaje` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.resultadoaprendizajedocente
CREATE TABLE IF NOT EXISTS `resultadoaprendizajedocente` (
  `ResultadoAprendizaje_idResultadoAprendizaje` int(11) NOT NULL,
  `Docente_Persona_idPersona` int(11) NOT NULL,
  PRIMARY KEY (`ResultadoAprendizaje_idResultadoAprendizaje`),
  CONSTRAINT `fk_ResultadoAprendizajeDocente_ResultadoAprendizaje1` FOREIGN KEY (`ResultadoAprendizaje_idResultadoAprendizaje`) REFERENCES `resultadoaprendizaje` (`idResultadoAprendizaje`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.resultadoaprendizajedocente: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `resultadoaprendizajedocente` DISABLE KEYS */;
INSERT INTO `resultadoaprendizajedocente` (`ResultadoAprendizaje_idResultadoAprendizaje`, `Docente_Persona_idPersona`) VALUES
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1);
/*!40000 ALTER TABLE `resultadoaprendizajedocente` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.resultadorubrica
CREATE TABLE IF NOT EXISTS `resultadorubrica` (
  `idResultadoRubrica` int(11) NOT NULL,
  `fechaCompletadoRubrica` date DEFAULT NULL,
  `estadoRubrica` tinyint(1) DEFAULT NULL,
  `totalRubrica` decimal(8,2) DEFAULT NULL,
  `Persona_idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idResultadoRubrica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.resultadorubrica: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `resultadorubrica` DISABLE KEYS */;
INSERT INTO `resultadorubrica` (`idResultadoRubrica`, `fechaCompletadoRubrica`, `estadoRubrica`, `totalRubrica`, `Persona_idPersona`) VALUES
	(1, '2014-02-04', 1, 90.00, 1),
	(2, '2014-02-05', 1, 90.00, 2);
/*!40000 ALTER TABLE `resultadorubrica` ENABLE KEYS */;


-- Volcando estructura para tabla rubricaepis.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `passwordUsuario` varchar(45) DEFAULT NULL,
  `tipoUsuario` varchar(45) DEFAULT NULL,
  `Persona_idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`Persona_idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla rubricaepis.usuario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
