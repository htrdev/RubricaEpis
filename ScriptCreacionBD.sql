CREATE DATABASE RubricaEpis
GO

USE RubricaEpis
GO

-- Tablas UPT

CREATE TABLE PERSONA(
	CodPer INT IDENTITY,
	ApepPer VARCHAR(100) NOT NULL,
	ApemPer VARCHAR(100) NOT NULL,
	NomPer VARCHAR(100) NOT NULL,
	Email VARCHAR(100) NOT NULL,
	Dni	VARCHAR(12) NOT NULL,
	CodEstamento INT NOT NULL,
	CONSTRAINT PERSONA_PK PRIMARY KEY (CodPer)
)
GO

CREATE TABLE SEMESTRE(
	idSem INT IDENTITY,
	Semestre VARCHAR(100) NOT NULL,
	Activo VARCHAR(10) NOT NULL,
	CONSTRAINT SEMESTRE_PK PRIMARY KEY(idSem)
)
GO

CREATE TABLE Curso(
	idcurso INT IDENTITY,
	CodCurso VARCHAR(10) NOT NULL,
	DesCurso VARCHAR(100) NOT NULL,
	CicloCurso VARCHAR(100) NOT NULL,
	CursoCreditos TINYINT NOT NULL,
	CONSTRAINT Curso_PK PRIMARY KEY(idcurso)
)
GO

CREATE TABLE Carga(
	idcarga INT IDENTITY,
	codper INT NOT NULL,
	idsem INT NOT NULL,
	idcurso INT NOT NULL,
	seccion VARCHAR(10) NOT NULL
		CONSTRAINT seccion_Default DEFAULT 'A',
	CONSTRAINT Carga_PK PRIMARY KEY(idcarga),
	CONSTRAINT Carga_codper_FK FOREIGN KEY(codper) REFERENCES PERSONA(CodPer),
	CONSTRAINT Carga_idsem_FK FOREIGN KEY(idsem) REFERENCES SEMESTRE(idsem),
	CONSTRAINT Carga_idcurso_FK FOREIGN KEY(idcurso) REFERENCES CURSO(idcurso)
)
GO

--TABLAS SISTEMA RUBRICAEPIS


CREATE TABLE ResultadoAprendizaje(
	idResultadoAprendizaje INT IDENTITY,
	definicionResultadoAPrendizaje TEXT NOT NULL,
	tituloResultadoAprendizaje VARCHAR(100) NOT NULL,
	codigoResultadoAprendizaje AS 'RA' + replace(str(idResultadoAprendizaje, 3), ' ', '0'),
	tipoResultadoAprendizaje VARCHAR(10) NOT NULL,
	CONSTRAINT ResultadoAprendizaje_PK PRIMARY KEY(idResultadoAprendizaje)
)
GO

CREATE TABLE ResultadoAprendizajeDocente(
	idResultadoAprendizaje INT,
	idDocente INT NOT NULL,
	CONSTRAINT ResultadoAprendizajeDocente_PK PRIMARY KEY(idResultadoAprendizaje),
	CONSTRAINT ResultadoAprendizajeDocente_idResultadoAprendizaje_FK FOREIGN KEY(idResultadoAprendizaje) REFERENCES ResultadoAprendizaje(idResultadoAprendizaje),
	CONSTRAINT ResultadoAprendizajeDocente_idDocente_FK FOREIGN KEY(idDocente) REFERENCES PERSONA(CodPer)
)
GO

CREATE TABLE CriterioEvaluacion(
	idCriterioEvaluacion INT IDENTITY,
	descripcionCriterioEvaluacion TEXT NOT NULL,
	idResultadoAprendizaje INT NOT NULL,
	CONSTRAINT CriterioEvaluacion_PK PRIMARY KEY(idCriterioEvaluacion),
	CONSTRAINT CriterioEvaluacion_idResultadoAprendizaje_FK FOREIGN KEY(idResultadoAprendizaje) REFERENCES ResultadoAprendizaje(idResultadoAprendizaje)
)
GO

CREATE TABLE ModeloRubrica(
	idModeloRubrica INT IDENTITY,
	fechaCreacionRubrica DATETIME
		CONSTRAINT fechaCreacionRubrica_Default DEFAULT GETDATE(),
	fechaInicioRubrica VARCHAR(25) NOT NULL,
	fechaFinalRubrica VARCHAR(25) NOT NULL,
	personaCalificada VARCHAR(50) NOT NULL,
	tipoModeloRubrica VARCHAR(50) NULL
		CONSTRAINT tipoModeloRubrica_Default DEFAULT 'Curso',
	idPersonaCreadorRubrica INT NOT NULL,
	idCurso INT NOT NULL,
	idSemestre INT NOT NULL,
	CONSTRAINT ModeloRubrica_PK PRIMARY KEY(idModeloRubrica),
	CONSTRAINT ModeloRubrica_idPersonaCreadorRubrica_FK FOREIGN KEY(idPersonaCreadorRubrica) REFERENCES PERSONA(CodPer),
	CONSTRAINT ModeloRubrica_idCurso_FK FOREIGN KEY(idCurso) REFERENCES Curso(idCurso),
	CONSTRAINT ModeloRubrica_idSemestre_FK FOREIGN KEY(idSemestre) REFERENCES SEMESTRE(idsem),
)
GO

CREATE TABLE ResultadoRubrica(
	idResultadoRubrica INT IDENTITY,
	fechaCompletadoRubrica VARCHAR(25) NULL
		CONSTRAINT fechaCompletadoRubrica_Default DEFAULT 'No Completado',
	estadoRubrica VARCHAR(20)
		CONSTRAINT estadoRubrica_Default DEFAULT 'Pendiente',
	totalRubrica DECIMAL(8,2) NOT NULL
		CONSTRAINT totalRubrica_Default DEFAULT 0,
	idModeloRubrica INT NOT NULL,
	idPersonaCalificadora INT NOT NULL,
	CONSTRAINT idResultadoRubrica PRIMARY KEY(idResultadoRubrica),
	CONSTRAINT ResultadoRubrica_idPersonaCalificadora_FK FOREIGN KEY(idPersonaCalificadora) REFERENCES PERSONA(CodPer),
	CONSTRAINT ResultadoRubrica_idModeloRubrica_FK FOREIGN KEY(idModeloRubrica) REFERENCES ModeloRubrica(idModeloRubrica)
)
GO

CREATE TABLE AsignacionPersonaCalificada(
	idResultadoRubrica INT NOT NULL,
	idPersonaCalificada INT NOT NULL,
	CONSTRAINT AsignacionPersonaCalificada_idResultadoRubrica_FK FOREIGN KEY(idResultadoRubrica) REFERENCES ResultadoRubrica(idResultadoRubrica),
	CONSTRAINT AsignacionPersonaCalificada_idPersonaCalificada_FK FOREIGN KEY(idPersonaCalificada) REFERENCES PERSONA(CodPer)
)
GO

CREATE TABLE AsignacionCriterioEvaluacion(
	idAsignacionCriterioEvaluacion INT IDENTITY,
	idModeloRubrica INT NOT NULL,
	idCriterioEvaluacion INT NOT NULL,
	CONSTRAINT AsignacionCriterioEvaluacion_PK PRIMARY KEY(idAsignacionCriterioEvaluacion),
	CONSTRAINT AsignacionCriterioEvaluacion_idModeloRubrica_FK FOREIGN KEY(idModeloRubrica) REFERENCES ModeloRubrica(idModeloRubrica),
	CONSTRAINT CriterioEvaluacion_idCriterioEvaluacion_FK FOREIGN KEY(idCriterioEvaluacion) REFERENCES CriterioEvaluacion(idCriterioEvaluacion)
)
GO

CREATE TABLE CalificacionCriterioEvaluacion(
	idResultadoRubrica INT NOT NULL,
	calificacionCriterioEvaluacion DECIMAL(8,2) NOT NULL,
	idAsignacionCriterioEvaluacion INT NOT NULL,
	CONSTRAINT CalificacionCriterioEvaluacion_idResultadoRubrica_FK FOREIGN KEY(idResultadoRubrica) REFERENCES ResultadoRubrica(idResultadoRubrica),
	CONSTRAINT CalificacionCriterioEvaluacion_idAsignacionCriterioEvaluacion_FK FOREIGN KEY(idAsignacionCriterioEvaluacion) REFERENCES AsignacionCriterioEvaluacion(idAsignacionCriterioEvaluacion)
)
GO