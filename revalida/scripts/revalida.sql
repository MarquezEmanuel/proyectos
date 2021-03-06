USE [master]
GO
/****** Object:  Database [BD_Formulario]    Script Date: 17/3/2020 15:08:28 ******/
CREATE DATABASE [BD_Formulario]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'BD_Formulario', FILENAME = N'D:\Bases_SQL\BD_Formulario.mdf' , SIZE = 14336KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'BD_Formulario_log', FILENAME = N'E:\Log_SQL\BD_Formulario_log.ldf' , SIZE = 132544KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [BD_Formulario] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [BD_Formulario].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [BD_Formulario] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [BD_Formulario] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [BD_Formulario] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [BD_Formulario] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [BD_Formulario] SET ARITHABORT OFF 
GO
ALTER DATABASE [BD_Formulario] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [BD_Formulario] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [BD_Formulario] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [BD_Formulario] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [BD_Formulario] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [BD_Formulario] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [BD_Formulario] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [BD_Formulario] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [BD_Formulario] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [BD_Formulario] SET  DISABLE_BROKER 
GO
ALTER DATABASE [BD_Formulario] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [BD_Formulario] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [BD_Formulario] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [BD_Formulario] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [BD_Formulario] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [BD_Formulario] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [BD_Formulario] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [BD_Formulario] SET RECOVERY FULL 
GO
ALTER DATABASE [BD_Formulario] SET  MULTI_USER 
GO
ALTER DATABASE [BD_Formulario] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [BD_Formulario] SET DB_CHAINING OFF 
GO
ALTER DATABASE [BD_Formulario] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [BD_Formulario] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [BD_Formulario] SET DELAYED_DURABILITY = DISABLED 
GO
USE [BD_Formulario]
GO
/****** Object:  Table [dbo].[aplicativo]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[aplicativo](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[propietario] [int] NOT NULL,
	[nombreBase] [nvarchar](50) NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_aplicativo] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_aplicativo] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[aplicativo_formulario]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[aplicativo_formulario](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_formulario] [int] NULL,
	[id_aplicativo] [int] NULL,
 CONSTRAINT [PK_aplicativo_formulario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[formulario]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[formulario](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[motivoSolicitud] [nvarchar](50) NOT NULL,
	[fechaPedido] [smalldatetime] NOT NULL,
	[fechaEjecucion] [smalldatetime] NULL,
	[usuarioSolicitante] [int] NULL,
	[usuarioNuevo] [int] NULL,
	[plataforma] [nvarchar](50) NULL,
	[observacionInstancia] [nvarchar](50) NULL,
	[observacionProteccion] [nvarchar](50) NULL,
	[usuarioResponsableEjecucion] [int] NULL,
	[estado] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_formulario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[formulario_servicio]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[formulario_servicio](
	[id_servicio] [int] NULL,
	[id_formulario] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[gerencia]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[gerencia](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NULL,
	[delegado] [int] NULL,
	[subDelegado] [int] NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_gerencia] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[logsAccion]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[logsAccion](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [nvarchar](10) NULL,
	[acccion] [nvarchar](20) NULL,
	[mensaje] [nvarchar](100) NULL,
	[fecha] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_logsAccion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[logsAcierto]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[logsAcierto](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [nvarchar](100) NULL,
	[fecha] [datetime] NULL,
	[mensaje] [nvarchar](100) NULL,
 CONSTRAINT [PK_logsAcierto] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[logsConexionBD]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[logsConexionBD](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [nvarchar](10) NULL,
	[operacion] [nvarchar](50) NULL,
	[mensaje] [nvarchar](300) NULL,
	[fecha] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_logsConexionBD] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[logsError]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[logsError](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [nvarchar](100) NULL,
	[accion] [nvarchar](20) NULL,
	[mensaje] [nvarchar](100) NULL,
	[fecha] [smalldatetime] NULL,
 CONSTRAINT [PK_logsError] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[permiso]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[permiso](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NULL,
	[nivel] [int] NULL,
	[padre] [int] NULL,
	[link] [nvarchar](100) NULL,
 CONSTRAINT [PK_permiso] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rol]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rol](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_rol] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_rol] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rol_permiso]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rol_permiso](
	[id_rol] [int] NULL,
	[id_permiso] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[servicio]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[servicio](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_servicio] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_servicio] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[usuario]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[legajo] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[apellido] [nvarchar](50) NOT NULL,
	[cargo] [nvarchar](50) NOT NULL,
	[gerencia] [int] NOT NULL,
	[firma] [nvarchar](100) NULL,
	[estado] [int] NOT NULL,
	[id_rol] [int] NOT NULL,
	[foto] [nvarchar](50) NULL,
 CONSTRAINT [PK_usuario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[usuarioAcceso]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuarioAcceso](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[legajo] [nvarchar](100) NULL,
	[nombre] [nvarchar](100) NULL,
	[perfil] [nvarchar](70) NULL,
	[estado] [nvarchar](50) NULL,
	[aplicativo] [int] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_usuarioAcceso] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_usuarioAcceso] UNIQUE NONCLUSTERED 
(
	[legajo] ASC,
	[nombre] ASC,
	[perfil] ASC,
	[estado] ASC,
	[aplicativo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  View [dbo].[vw_aplicativo]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



  CREATE view [dbo].[vw_aplicativo] as
  SELECT 
		APL.id idAplicacion,
		APL.nombre nombreAplicacion,
		APL.nombreBase,
		GER.id idGerencia,
		GER.nombre nombreGerencia,
		DEL.legajo legajoDelegado,
		DEL.nombre +', '+DEL.apellido nombreDelegado,
		SUB.legajo legajoSubdelegado,
		SUB.nombre +', '+SUB.apellido nombreSubdelegado,
		APL.estado
  FROM [BD_Formulario].[dbo].[aplicativo] APL
  INNER JOIN [BD_Formulario].[dbo].[gerencia] GER ON GER.id = APL.propietario
  LEFT JOIN [BD_Formulario].[dbo].[usuario] DEL ON DEL.id = GER.delegado
  LEFT JOIN [BD_Formulario].[dbo].[usuario] SUB ON SUB.id = GER.subDelegado

GO
/****** Object:  View [dbo].[vw_aplicativoForm]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO





CREATE view [dbo].[vw_aplicativoForm] as
SELECT 
DOC.id,
DOC.motivoSolicitud,
DOC.fechaPedido,
DOC.plataforma,
DOC.observacionInstancia,
DOC.observacionProteccion,
DOC.estado,
A.nombre,
A.nombreBase,
A.propietario,
A.estado AS estadoAplicacion
FROM [BD_Formulario].[dbo].[formulario] DOC
INNER JOIN [BD_Formulario].[dbo].[aplicativo_formulario] AF ON DOC.id = AF.id_formulario
INNER JOIN [BD_Formulario].[dbo].[aplicativo] A ON AF.id_aplicativo = A.id




GO
/****** Object:  View [dbo].[vw_formulario]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO





CREATE view [dbo].[vw_formulario] as
SELECT 
DOC.id,
DOC.motivoSolicitud,
DOC.fechaPedido,
SOL.*,
NUE.*,
DOC.plataforma,
DOC.observacionInstancia,
DOC.observacionProteccion,
EJE.id id_eje,
EJE.legajo legajo_eje,
EJE.apellido apeliido_eje,
EJE.nombre nombre_eje,
EJE.cargo cargo_eje,
DOC.estado
FROM [BD_Formulario].[dbo].[formulario] DOC
INNER JOIN (
	SELECT USU.id idUsuarioSol, USU.legajo legajoUsuarioSol, USU.nombre nombreUsuarioSol, USU.apellido apellidoUsuarioSol, USU.cargo cargoUsuarioSol, 
		GER.id idGerenciaSol, GER.nombre nombreGerenciaSol, 
		DEL.id idDelegadoSol, DEL.legajo legajoDelegadoSol, DEL.nombre nombreDelegadoSol, DEL.apellido apellidoDelegadoSol, DEL.cargo cargoDelegadoSol,
		SUB.id idSubdelegadoSol, SUB.legajo legajoSubdelegadoSol, SUB.nombre nombreSubdelegadoSol, SUB.apellido apellidoSubdelegadoSol, SUB.cargo cargoSubdelegadoSol,USU.foto
	FROM [BD_Formulario].[dbo].usuario USU
	INNER JOIN [BD_Formulario].[dbo].gerencia GER ON GER.id = USU.gerencia
	LEFT JOIN [BD_Formulario].[dbo].usuario DEL ON DEL.id = GER.delegado
	LEFT JOIN [BD_Formulario].[dbo].usuario SUB ON SUB.id = GER.subDelegado
) SOL ON SOL.idUsuarioSol = DOC.usuarioSolicitante
LEFT JOIN (
	SELECT USU.id idUsuarioNue, USU.legajo legajoUsuarioNue, USU.nombre nombreUsuarioNue, USU.apellido apellidoUsuarioNue, USU.cargo cargoUsuarioNue, 
		GER.id idGerenciaNue, GER.nombre nombreGerenciaNue, 
		DEL.id idDelegadoNue, DEL.legajo legajoDelegadoNue, DEL.nombre nombreDelegadoNue, DEL.apellido apellidoDelegadoNue, DEL.cargo cargoDelegadoNue,
		SUB.id idSubdelegadoNue, SUB.legajo legajoSubdelegadoNue, SUB.nombre nombreSubdelegadoNue, SUB.apellido apellidoSubdelegadoNue, SUB.cargo cargoSubdelegadoNue
	FROM [BD_Formulario].[dbo].usuario USU
	INNER JOIN [BD_Formulario].[dbo].gerencia GER ON GER.id = USU.gerencia
	LEFT JOIN [BD_Formulario].[dbo].usuario DEL ON DEL.id = GER.delegado
	LEFT JOIN [BD_Formulario].[dbo].usuario SUB ON SUB.id = GER.subDelegado
) NUE ON NUE.idUsuarioNue = DOC.usuarioNuevo
LEFT JOIN  [BD_Formulario].[dbo].usuario EJE ON EJE.id = DOC.usuarioResponsableEjecucion




GO
/****** Object:  View [dbo].[vw_gerencia]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create view [dbo].[vw_gerencia] as
select 
ger.id id_gerencia,
ger.nombre nombre_gerencia,
del.id id_delegado,
del.nombre +', '+del.apellido nombre_delegado,
sub.id id_subdelegado,
sub.nombre +', '+sub.apellido nombre_subdelegado,
ger.estado estado_gerencia
from [BD_Formulario].dbo.gerencia ger
left join [BD_Formulario].dbo.usuario del on del.id = ger.delegado
left join [BD_Formulario].dbo.usuario sub on sub.id = ger.subDelegado



GO
/****** Object:  View [dbo].[vw_panel]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO






CREATE view [dbo].[vw_panel] as
SELECT EST.*, (CASE WHEN TOT.cantidad IS NULL THEN 0 ELSE TOT.cantidad END) cantidad FROM 
(SELECT 1 id, 'ESPERANDO APROBACION' estado,'warning' color UNION ALL 
SELECT 2 id,'APROBADO POR GERENCIA' estado,'success' color UNION ALL
SELECT 3 id,'RECHAZADO POR GERENCIA' estado,'danger' color UNION ALL
SELECT 4 id,'APROBADO POR PROPIETARIO DE DATOS' estado,'success' color UNION ALL 
SELECT 5 id,'RECHAZADO POR PROPIETARIO DE DATOS' estado,'danger' color UNION ALL
SELECT 6 id,'APROBADO POR PAI' estado,'success' color UNION ALL 
SELECT 7 id,'RECHAZADO POR PAI' estado,'danger' color) EST
LEFT JOIN (select UPPER(estado) estado, count(*) cantidad from [dbo].[formulario] group by UPPER(estado)) TOT ON TOT.estado = EST.estado







GO
/****** Object:  View [dbo].[vw_panelUsuario]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[vw_panelUsuario] as

SELECT EST.*, TOT.usuarioSolicitante,(CASE WHEN TOT.cantidad IS NULL THEN 0 ELSE TOT.cantidad END) cantidad FROM 
(SELECT 1 id, 'ESPERANDO APROBACION' estado,'warning' color UNION ALL 
SELECT 2 id,'APROBADO POR GERENCIA' estado,'success' color UNION ALL
SELECT 3 id,'RECHAZADO POR GERENCIA' estado,'danger' color UNION ALL
SELECT 4 id,'APROBADO POR PROPIETARIO DE DATOS' estado,'success' color UNION ALL 
SELECT 5 id,'RECHAZADO POR PROPIETARIO DE DATOS' estado,'danger' color UNION ALL
SELECT 6 id,'APROBADO POR PAI' estado,'success' color UNION ALL 
SELECT 7 id,'RECHAZADO POR PAI' estado,'danger' color) EST
LEFT JOIN (select UPPER(estado) estado, usuarioSolicitante, count(*) cantidad  from [dbo].[formulario] group by UPPER(estado), usuarioSolicitante) TOT ON TOT.estado = EST.estado




GO
/****** Object:  View [dbo].[vw_reporte]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vw_reporte] as 
SELECT 'ACCESOS' modulo, '<i class="fas fa-key fa-2x"></i>' icono, 'POR APLICACIÓN' reporte, nombre, cantidad 
FROM aplicativo APL
INNER JOIN (SELECT aplicativo, COUNT(*) cantidad 
			FROM [usuarioAcceso] 
			GROUP BY aplicativo) TOT ON TOT.aplicativo = APL.id
UNION ALL
SELECT 'ACCESOS' modulo, '<i class="fas fa-key fa-2x"></i>' icono, 'POR PERFIL' reporte, perfil nombre, COUNT(*) cantidad 
FROM [usuarioAcceso] 
GROUP BY perfil
UNION ALL
SELECT 'ACCESOS' modulo, '<i class="fas fa-key fa-2x"></i>' icono, 'POR USUARIO' reporte, legajo nombre, COUNT(*) cantidad 
FROM [usuarioAcceso] 
GROUP BY legajo
UNION ALL	  
SELECT 'APLICACIONES' modulo, '<i class="fas fa-laptop-code fa-2x"></i>' icono, 'POR GERENCIA' reporte, nombre, cantidad 
FROM gerencia GER
INNER JOIN (SELECT propietario, COUNT(*) cantidad 
	FROM aplicativo 
	GROUP BY propietario) TOT ON TOT.propietario = GER.id	  
UNION ALL
SELECT 'USUARIOS' modulo, '<i class="fas fa-user fa-2x"></i>' icono, 'POR CARGO' reporte, cargo, COUNT(cargo) cantidad 
FROM usuario
GROUP BY cargo
UNION ALL
SELECT 'FORMULARIOS' modulo, '<i class="fas fa-file-pdf fa-2x"></i>' icono, 'POR MOTIVO' reporte, motivoSolicitud, COUNT(motivoSolicitud) cantidad FROM formulario GROUP BY motivoSolicitud
UNION ALL
SELECT 'FORMULARIOS' modulo, '<i class="fas fa-file-pdf fa-2x"></i>' icono, 'POR FECHA DE PEDIDO' reporte, convert(varchar, fechaPedido, 101) nombre, COUNT(fechaPedido) cantidad from formulario GROUP BY fechaPedido
UNION ALL
SELECT 'FORMULARIOS' modulo, '<i class="fas fa-file-pdf fa-2x"></i>' icono, 'POR SOLICITANTE' reporte, USU.nombre+', '+USU.apellido nombre, TOT.cantidad FROM usuario USU
INNER JOIN (SELECT usuarioSolicitante, count(usuarioSolicitante) cantidad 
FROM formulario GROUP BY usuarioSolicitante) TOT ON TOT.usuarioSolicitante = USU.id

GO
/****** Object:  View [dbo].[vw_usuario]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


  CREATE view [dbo].[vw_usuario] as
  select 
  usu.id id_usuario,
  usu.legajo,
  usu.nombre +', '+usu.apellido nombre_usuario,
  usu.cargo,
  ger.nombre nombre_gerencia,
  rol.id id_rol,
  rol.nombre nombre_rol,
  usu.estado 
  from [BD_Formulario].[dbo].[usuario] usu
  inner join [BD_Formulario].[dbo].[rol] rol on rol.id = usu.id_rol
  inner join [BD_Formulario].[dbo].[gerencia] ger on ger.id = usu.gerencia


GO
/****** Object:  View [dbo].[vw_usuarioAcceso]    Script Date: 17/3/2020 15:08:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vw_usuarioAcceso]
as
select ACC.legajo,
	   ACC.nombre nombreUsuario,
	   ACC.perfil,
	   ACC.estado,
	   APP.id,
	   APP.nombre nombreAplicativo,
	   APP.propietario,
	   APP.nombreBase,
	   ACC.fechaActualizacion 
from [BD_Formulario].[dbo].[usuarioAcceso] ACC
INNER JOIN [BD_Formulario].[dbo].[aplicativo] APP on APP.id = ACC.aplicativo

GO
/****** Object:  Index [IX_rol_permiso]    Script Date: 17/3/2020 15:08:28 ******/
CREATE NONCLUSTERED INDEX [IX_rol_permiso] ON [dbo].[rol_permiso]
(
	[id_rol] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[aplicativo]  WITH CHECK ADD  CONSTRAINT [FK_aplicativo_gerencia1] FOREIGN KEY([propietario])
REFERENCES [dbo].[gerencia] ([id])
GO
ALTER TABLE [dbo].[aplicativo] CHECK CONSTRAINT [FK_aplicativo_gerencia1]
GO
ALTER TABLE [dbo].[aplicativo_formulario]  WITH CHECK ADD  CONSTRAINT [FK_aplicativo_formulario_aplicativo] FOREIGN KEY([id_aplicativo])
REFERENCES [dbo].[aplicativo] ([id])
GO
ALTER TABLE [dbo].[aplicativo_formulario] CHECK CONSTRAINT [FK_aplicativo_formulario_aplicativo]
GO
ALTER TABLE [dbo].[aplicativo_formulario]  WITH CHECK ADD  CONSTRAINT [FK_aplicativo_formulario_formulario] FOREIGN KEY([id_formulario])
REFERENCES [dbo].[formulario] ([id])
GO
ALTER TABLE [dbo].[aplicativo_formulario] CHECK CONSTRAINT [FK_aplicativo_formulario_formulario]
GO
ALTER TABLE [dbo].[formulario]  WITH CHECK ADD  CONSTRAINT [FK_formulario_usuario2] FOREIGN KEY([usuarioResponsableEjecucion])
REFERENCES [dbo].[usuario] ([id])
GO
ALTER TABLE [dbo].[formulario] CHECK CONSTRAINT [FK_formulario_usuario2]
GO
ALTER TABLE [dbo].[formulario]  WITH CHECK ADD  CONSTRAINT [FK_formulario_usuario3] FOREIGN KEY([usuarioSolicitante])
REFERENCES [dbo].[usuario] ([id])
GO
ALTER TABLE [dbo].[formulario] CHECK CONSTRAINT [FK_formulario_usuario3]
GO
ALTER TABLE [dbo].[formulario]  WITH CHECK ADD  CONSTRAINT [FK_formulario_usuarioAcceso] FOREIGN KEY([usuarioNuevo])
REFERENCES [dbo].[usuarioAcceso] ([id])
GO
ALTER TABLE [dbo].[formulario] CHECK CONSTRAINT [FK_formulario_usuarioAcceso]
GO
ALTER TABLE [dbo].[formulario_servicio]  WITH CHECK ADD  CONSTRAINT [FK_formulario_servicio_formulario] FOREIGN KEY([id_formulario])
REFERENCES [dbo].[formulario] ([id])
GO
ALTER TABLE [dbo].[formulario_servicio] CHECK CONSTRAINT [FK_formulario_servicio_formulario]
GO
ALTER TABLE [dbo].[formulario_servicio]  WITH CHECK ADD  CONSTRAINT [FK_formulario_servicio_servicio] FOREIGN KEY([id_servicio])
REFERENCES [dbo].[servicio] ([id])
GO
ALTER TABLE [dbo].[formulario_servicio] CHECK CONSTRAINT [FK_formulario_servicio_servicio]
GO
ALTER TABLE [dbo].[gerencia]  WITH CHECK ADD  CONSTRAINT [FK_gerencia_usuario] FOREIGN KEY([delegado])
REFERENCES [dbo].[usuario] ([id])
GO
ALTER TABLE [dbo].[gerencia] CHECK CONSTRAINT [FK_gerencia_usuario]
GO
ALTER TABLE [dbo].[gerencia]  WITH CHECK ADD  CONSTRAINT [FK_gerencia_usuario1] FOREIGN KEY([subDelegado])
REFERENCES [dbo].[usuario] ([id])
GO
ALTER TABLE [dbo].[gerencia] CHECK CONSTRAINT [FK_gerencia_usuario1]
GO
ALTER TABLE [dbo].[logsAccion]  WITH CHECK ADD  CONSTRAINT [FK_logsAccion_logsAccion] FOREIGN KEY([id])
REFERENCES [dbo].[logsAccion] ([id])
GO
ALTER TABLE [dbo].[logsAccion] CHECK CONSTRAINT [FK_logsAccion_logsAccion]
GO
ALTER TABLE [dbo].[rol_permiso]  WITH CHECK ADD  CONSTRAINT [FK_rol_permiso_permiso] FOREIGN KEY([id_permiso])
REFERENCES [dbo].[permiso] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[rol_permiso] CHECK CONSTRAINT [FK_rol_permiso_permiso]
GO
ALTER TABLE [dbo].[rol_permiso]  WITH CHECK ADD  CONSTRAINT [FK_rol_permiso_rol] FOREIGN KEY([id_rol])
REFERENCES [dbo].[rol] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[rol_permiso] CHECK CONSTRAINT [FK_rol_permiso_rol]
GO
ALTER TABLE [dbo].[usuario]  WITH CHECK ADD  CONSTRAINT [FK_usuario_usuario] FOREIGN KEY([gerencia])
REFERENCES [dbo].[gerencia] ([id])
GO
ALTER TABLE [dbo].[usuario] CHECK CONSTRAINT [FK_usuario_usuario]
GO
USE [master]
GO
ALTER DATABASE [BD_Formulario] SET  READ_WRITE 
GO
