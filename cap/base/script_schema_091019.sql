USE [master]
GO
/****** Object:  Database [CAP_BSC]    Script Date: 09/10/2019 10:50:09 p.m. ******/
CREATE DATABASE [CAP_BSC]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'CAP_BSC', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\CAP_BSC.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'CAP_BSC_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\CAP_BSC_log.ldf' , SIZE = 3072KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [CAP_BSC] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [CAP_BSC].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [CAP_BSC] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [CAP_BSC] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [CAP_BSC] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [CAP_BSC] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [CAP_BSC] SET ARITHABORT OFF 
GO
ALTER DATABASE [CAP_BSC] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [CAP_BSC] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [CAP_BSC] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [CAP_BSC] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [CAP_BSC] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [CAP_BSC] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [CAP_BSC] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [CAP_BSC] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [CAP_BSC] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [CAP_BSC] SET  DISABLE_BROKER 
GO
ALTER DATABASE [CAP_BSC] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [CAP_BSC] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [CAP_BSC] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [CAP_BSC] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [CAP_BSC] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [CAP_BSC] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [CAP_BSC] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [CAP_BSC] SET RECOVERY FULL 
GO
ALTER DATABASE [CAP_BSC] SET  MULTI_USER 
GO
ALTER DATABASE [CAP_BSC] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [CAP_BSC] SET DB_CHAINING OFF 
GO
ALTER DATABASE [CAP_BSC] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [CAP_BSC] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [CAP_BSC] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [CAP_BSC] SET QUERY_STORE = OFF
GO
USE [CAP_BSC]
GO
/****** Object:  Table [dbo].[srv_servidores]    Script Date: 09/10/2019 10:50:10 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[srv_servidores](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](30) NOT NULL,
	[ip] [nvarchar](13) NULL,
	[ambiente] [int] NOT NULL,
	[tipo] [int] NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_sis_servidor_bd] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bas_bases]    Script Date: 09/10/2019 10:50:11 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_bases](
	[id] [nvarchar](50) NOT NULL,
	[produccion] [bigint] NULL,
	[test] [bigint] NULL,
	[desarrollo] [bigint] NULL,
	[nombre] [nvarchar](50) NULL,
	[fechaCreacion] [smalldatetime] NULL,
	[collation] [nvarchar](50) NULL,
	[fechaProceso] [smalldatetime] NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [nvarchar](15) NULL,
 CONSTRAINT [PK_sis_basesDatos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteBaseDatos]    Script Date: 09/10/2019 10:50:11 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[reporteBaseDatos]
as
SELECT BAS.id idBase,
	   BAS.nombre nombreBase,
	   CAST(BAS.fechaCreacion AS DATE) fechaCreacionBase,
	   BAS.collation,
	   CAST(BAS.fechaProceso AS DATE) fechaProcesoBase,
	   BAS.rti,
	   BAS.estado codigoEstado,
	   (CASE 
			WHEN BAS.estado = 1 THEN 'DESCONOCIDO'
			WHEN BAS.estado = 2 THEN 'ONLINE'
			ELSE 'OFFLINE'
	   END) nombreEstado,
	   PROD.id idProduccion,
	   PROD.nombre servidorProduccion,
	   TEST.id idTest,
	   TEST.nombre servidorTest,
	   DESA.id idDesarrollo,
	   DESA.nombre servidorDesarrollo
FROM [dbo].[bas_bases] BAS
INNER JOIN [dbo].[srv_servidores] PROD ON PROD.id = BAS.produccion AND PROD.ambiente = 1
LEFT JOIN [dbo].[srv_servidores] TEST ON TEST.id = BAS.test AND TEST.ambiente = 2
LEFT JOIN [dbo].[srv_servidores] DESA ON DESA.id = BAS.desarrollo AND DESA.ambiente = 3
GO
/****** Object:  View [dbo].[reporteServidores]    Script Date: 09/10/2019 10:50:11 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[reporteServidores]
as
select id,
	   nombre,
	   ip,
	   ambiente codigoAmbiente,
	   (CASE WHEN ambiente = 1 THEN 'Producción'
			 WHEN ambiente = 2 THEN 'Test'
			 ELSE 'Desarrollo' END) nombreAmbiente,
	   tipo codigoTipo,
	   (CASE WHEN tipo = 1 THEN 'Aplicaciones'
			 WHEN tipo = 2 THEN 'Bases de datos'
			 ELSE 'Ambos' END) nombreTipo,
	   descripcion,
	   estado
from [CAP_BSC].[dbo].[srv_servidores]
GO
/****** Object:  Table [dbo].[ger_departamentos]    Script Date: 09/10/2019 10:50:11 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ger_departamentos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_departamentos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_ger_departamentos] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ger_personas]    Script Date: 09/10/2019 10:50:11 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ger_personas](
	[id] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[departamento] [bigint] NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_ger_personas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ger_gerencias]    Script Date: 09/10/2019 10:50:11 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ger_gerencias](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[jefe] [nvarchar](10) NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_gerencias] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_ger_gerencias] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reportePersonas]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reportePersonas]
as
SELECT PER.id idPersona,
	   PER.nombre nombrePersona,
	   DEP.id idDepto,
	   DEP.nombre nombreDepto,
	   DEP.estado estadoDepto,
	   GER.id idGerencia,
	   GER.nombre nombreGerencia,
	   GER.estado estadoGerencia,
	   PER.estado estadoPersona
FROM [dbo].[ger_personas] PER
INNER JOIN  [dbo].[ger_departamentos] DEP ON DEP.id = PER.departamento
INNER JOIN [dbo].[ger_gerencias] GER ON GER.id = DEP.gerencia
WHERE PER.departamento is not null
UNION ALL
SELECT PER.id,
	   PER.nombre,
	   NULL idDepto,
	   NULL nombreDepto,
	   NULL estadoDepto,
	   GER.id idGerencia,
	   GER.nombre nombreGerencia,
	   GER.estado estadoGerencia,
	   PER.estado estadoPersona
FROM [dbo].[ger_personas] PER
LEFT JOIN [dbo].[ger_gerencias] GER ON GER.jefe = PER.id
WHERE PER.departamento is null
GO
/****** Object:  View [dbo].[reporteGerencias]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


Create view [dbo].[reporteGerencias]
as
select ger.id idGerencia,
	   ger.nombre nombreGerencia,
	   ger.jefe legajoJefe,
	   per.nombre nombreJefe,
	   per.estado estadoJefe,
	   ger.estado estadoGerencia
from [dbo].[ger_gerencias] ger
left join [dbo].[ger_personas] per on per.id = ger.jefe
GO
/****** Object:  View [dbo].[reporteDepartamentos]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reporteDepartamentos]
as
SELECT DEP.id idDepto,
	   DEP.nombre nombreDepto,
	   GER.id idGerencia,
	   GER.nombre nombreGerencia,
	   GER.jefe jefeGerencia,
	   GER.estado estadoGerencia,
	   DEP.estado estadoDepto
FROM [dbo].[ger_departamentos] DEP
INNER JOIN [dbo].[ger_gerencias] GER ON GER.id = DEP.gerencia
GO
/****** Object:  Table [dbo].[bas_tablas]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_tablas](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[objeto] [nvarchar](15) NULL,
	[base] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](70) NOT NULL,
	[fechaCreacion] [smalldatetime] NULL,
	[fechaModificacion] [smalldatetime] NULL,
	[descripcion] [nvarchar](500) NULL,
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_sis_tablas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteTablas]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reporteTablas]
as
SELECT TAB.id idTabla,
	   TAB.objeto,
	   TAB.base idBase,
	   BAS.nombre nombreBase,
	   TAB.nombre nombreTabla,
	   TAB.fechaCreacion,
	   TAB.fechaModificacion,
	   TAB.descripcion,
	   TAB.fechaProceso 
FROM [dbo].[bas_tablas] TAB
INNER JOIN [dbo].[bas_bases] BAS ON BAS.id = TAB.base

GO
/****** Object:  Table [dbo].[suc_sucursales]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[suc_sucursales](
	[id] [bigint] NOT NULL,
	[sigla] [nvarchar](5) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_sucursales] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteSucursales]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create view [dbo].[reporteSucursales]
as
select  id,
		sigla,
		nombre,
		estado codigoEstado,
		(CASE WHEN estado = 1 THEN 'Activa' ELSE 'Inactiva' END) nombreEstado
from [dbo].[suc_sucursales]
GO
/****** Object:  Table [dbo].[pro_proveedores]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pro_proveedores](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NULL,
	[telefono] [nvarchar](30) NULL,
	[correo] [nvarchar](50) NULL,
	[provincia] [nvarchar](50) NULL,
	[localidad] [nvarchar](50) NULL,
	[direccion] [nvarchar](100) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_proveedores] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[pro_responsables]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pro_responsables](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[telefono] [nvarchar](20) NULL,
	[correo] [nvarchar](50) NULL,
	[proveedor] [bigint] NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_pro_responsable] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteResponsables]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create view [dbo].[reporteResponsables]
as
SELECT RES.id idResponsable,
	   RES.nombre,
	   RES.telefono,
	   RES.correo,
	   RES.estado codigoEstado,
	   (CASE WHEN RES.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nombreEstado,
	   PRO.id idProveedor,
	   PRO.nombre nombreProveedor,
	   PRO.estado codigoEstadoPro,
	   (CASE WHEN PRO.estado=1 THEN 'Activo' ELSE 'Inactivo' END) nombreEstadoPro
FROM [dbo].[pro_responsables] RES
INNER JOIN [dbo].[pro_proveedores] PRO ON PRO.id = RES.proveedor
GO
/****** Object:  Table [dbo].[seg_permisos]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_permisos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[titulo] [nvarchar](20) NOT NULL,
	[nivel] [int] NOT NULL,
	[padre] [int] NULL,
	[link] [nvarchar](50) NULL,
	[formulario] [nvarchar](50) NULL,
 CONSTRAINT [PK_seg_permisos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reportePermisos]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reportePermisos]
as
SELECT PER.id,
	   PER.titulo,
	   PER.nivel,
	   (CASE WHEN PER.nivel = 1 THEN 'Menú' ELSE 'Submenú' END) nombreNivel,
	   PER.padre,
	   NIV.titulo nombrePadre,
	   PER.link,
	   PER.formulario
FROM
[CAP_BSC].[dbo].[seg_permisos] PER
LEFT JOIN [CAP_BSC].[dbo].[seg_permisos] NIV ON PER.padre = NIV.id AND PER.nivel = 2
GO
/****** Object:  Table [dbo].[inv_inventarios]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_inventarios](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](15) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_inv_inventario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteInventarios]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[reporteInventarios]
as
select * from [CAP_BSC].[dbo].[inv_inventarios]
GO
/****** Object:  Table [dbo].[fir_firewall]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fir_firewall](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[inventario] [bigint] NULL,
	[firewall] [nvarchar](50) NULL,
	[marca] [nvarchar](50) NULL,
	[modelo] [nvarchar](50) NULL,
	[numeroSerie] [nvarchar](50) NULL,
	[version] [nvarchar](50) NULL,
	[ip] [nvarchar](15) NULL,
	[sucursal] [bigint] NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_fir_firewall] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteFirewalls]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[reporteFirewalls]
as
SELECT FIR.id idFirewall,
	   FIR.firewall nombre,
	   FIR.marca,
	   FIR.modelo,
	   FIR.numeroSerie,
	   FIR.version, 
	   FIR.ip,
	   FIR.estado codEstadoFirewall,
	   (CASE WHEN FIR.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoFirewall,
	   INV.id idInventario,
	   INV.sigla siglaInventario,
	   INV.estado estadoInventario,
	   SUC.id idSucursal,
	   SUC.nombre nombreSucursal,
	   SUC.estado estadoSucursal
FROM [fir_firewall] FIR
INNER JOIN [inv_inventarios] INV ON INV.id = FIR.inventario AND INV.estado = 1
INNER JOIN [suc_sucursales] SUC ON SUC.id = FIR.sucursal

GO
/****** Object:  Table [dbo].[dep_dependencias]    Script Date: 09/10/2019 10:50:12 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_dependencias](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[inventario] [bigint] NOT NULL,
	[categoria] [nvarchar](50) NOT NULL,
	[nivel] [int] NOT NULL,
	[padre] [bigint] NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_dep_dependencias] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_dep_dependencias] UNIQUE NONCLUSTERED 
(
	[inventario] ASC,
	[sigla] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteDependencias]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reporteDependencias]
as
select DEP.id idDependencia,
	   DEP.categoria,
	   DEP.nivel,
	   DEP.padre,
	   DEP.sigla,
	   DEP.nombre,
	   DEP.estado estadoDependencia,
	   INV.id idInventario,
	   INV.sigla nombreInventario,
	   INV.estado estadoInventario
from [dbo].[dep_dependencias] DEP
INNER JOIN [dbo].[inv_inventarios] INV ON INV.id = DEP.inventario

GO
/****** Object:  View [dbo].[reporteProveedores]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
/****** Script for SelectTopNRows command from SSMS  ******/
create view [dbo].[reporteProveedores]
as
SELECT PRO.id,
	   PRO.nombre,
	   PRO.telefono,
	   PRO.correo,
	   PRO.provincia,
	   PRO.localidad,
	   PRO.direccion,
	   PRO.estado codigoEstado,
	   (CASE WHEN PRO.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nombreEstado
FROM [pro_proveedores] PRO
GO
/****** Object:  Table [dbo].[har_hardware]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[har_hardware](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[inventario] [bigint] NULL,
	[tipo] [nvarchar](50) NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[dominio] [nvarchar](50) NULL,
	[softwareBase] [nvarchar](50) NULL,
	[ambiente] [nvarchar](50) NULL,
	[funcion] [nvarchar](50) NULL,
	[sucursal] [bigint] NULL,
	[marca] [nvarchar](50) NULL,
	[modelo] [nvarchar](50) NULL,
	[arquitectura] [nvarchar](50) NULL,
	[core] [nvarchar](50) NULL,
	[procesador] [nvarchar](50) NULL,
	[mhz] [nvarchar](50) NULL,
	[memoria] [nvarchar](50) NULL,
	[disco] [nvarchar](50) NULL,
	[raid] [nvarchar](50) NULL,
	[red] [int] NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_har_hardware] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[reporteHardwares]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

  
  --select * from [dbo].[har_hardware]
create view [dbo].[reporteHardwares]
as
SELECT HAR.id,
	   HAR.tipo,
	   HAR.sigla,
	   HAR.nombre,
	   HAR.dominio,
	   HAR.softwareBase,
	   HAR.ambiente,
	   HAR.funcion,
	   HAR.marca,
	   HAR.modelo,
	   HAR.arquitectura,
	   HAR.core,
	   HAR.procesador,
	   HAR.mhz,
	   HAR.memoria,
	   HAR.disco,
	   HAR.raid,
	   HAR.red,
	   HAR.rti,
	   HAR.estado codEstadoHardware,
	   (CASE WHEN HAR.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoHardware,
	   INV.sigla siglaInventario,
	   INV.estado codEstadoInventario,
	   SUC.id idSucursal,
	   SUC.nombre nombreSucursal,
	   SUC.estado codEstadoSucursal
FROM [dbo].[har_hardware] HAR
INNER JOIN [dbo].[inv_inventarios] INV ON INV.id = HAR.inventario
INNER JOIN [dbo].[suc_sucursales] SUC ON SUC.id = HAR.sucursal
GO
/****** Object:  View [dbo].[procedimientosAlmacenados]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE VIEW [dbo].[procedimientosAlmacenados]
as
SELECT BA.id idBase, BA.nombre nombreBase, SP.id idProcedimiento, SP.nombre nombreProcedimiento, SP.descripcion
FROM [dbo].[sis_bases] BA
INNER JOIN [dbo].[sis_procedimientos] SP ON BA.id = SP.base

GO
/****** Object:  View [dbo].[tablas]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[tablas]
AS
SELECT BA.id idBase, BA.nombre nombreBase, TA.id idTabla, TA.nombre nombreTabla, TA.descripcion
FROM [dbo].[sis_bases] BA
INNER JOIN  [dbo].[sis_tablas] TA ON TA.base = BA.id

  
GO
/****** Object:  Table [dbo].[bas_campos]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_campos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[tabla] [bigint] NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[nulos] [nvarchar](5) NOT NULL,
	[tipo] [nvarchar](50) NOT NULL,
	[maximo] [int] NULL,
 CONSTRAINT [PK_sis_campos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bas_procedimientos]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_procedimientos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NULL,
	[nombre] [nvarchar](200) NULL,
	[definicion] [nvarchar](max) NULL,
	[fechaCreacion] [smalldatetime] NULL,
	[fechaModificacion] [smalldatetime] NULL,
	[descripcion] [nvarchar](500) NULL,
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_sis_procedimientos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bas_vistas]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_vistas](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[consulta] [nvarchar](15) NULL,
	[descripcion] [nvarchar](500) NULL,
 CONSTRAINT [PK_sis_vistas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[com_switches]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[com_switches](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[inventario] [bigint] NULL,
	[sucursal] [bigint] NULL,
	[modelo] [nvarchar](50) NULL,
	[version] [nvarchar](50) NULL,
	[instalacion] [nvarchar](50) NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_com_switches] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[log_actividades]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[log_actividades](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[legajo] [nvarchar](10) NULL,
	[tabla] [nvarchar](50) NULL,
	[operacion] [nvarchar](50) NULL,
	[registro] [nvarchar](50) NULL,
	[fecha] [smalldatetime] NULL,
 CONSTRAINT [PK_log_actividad] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[pce_procesos]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pce_procesos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[inventario] [bigint] NULL,
	[codigo] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[valor] [int] NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_pro_procesos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[per_personales]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[per_personales](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[inventario] [bigint] NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[departamento] [bigint] NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_per_personales] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[seg_perfiles]    Script Date: 09/10/2019 10:50:13 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfiles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](300) NOT NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_seg_perfil] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_seg_perfiles] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[seg_perfiles_permisos]    Script Date: 09/10/2019 10:50:14 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfiles_permisos](
	[perfil] [int] NULL,
	[permiso] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[seg_usuarios]    Script Date: 09/10/2019 10:50:14 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_usuarios](
	[id] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[estado] [int] NOT NULL,
	[perfil] [int] NOT NULL,
 CONSTRAINT [PK_sis_usuarios] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ser_servicios]    Script Date: 09/10/2019 10:50:14 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ser_servicios](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[inventario] [bigint] NOT NULL,
	[departamento] [bigint] NOT NULL,
	[disponibilidad] [int] NOT NULL,
	[integridad] [int] NOT NULL,
	[confidencialidad] [int] NOT NULL,
	[autenticidad] [int] NOT NULL,
	[rti] [nvarchar](2) NOT NULL,
	[estado] [nchar](10) NOT NULL,
 CONSTRAINT [PK_ser_servicios_internos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sis_aplicativos]    Script Date: 09/10/2019 10:50:14 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sis_aplicativos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[origen] [nvarchar](3) NOT NULL,
	[base] [int] NOT NULL,
 CONSTRAINT [PK_sis_aplicativos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_inv_inventario]    Script Date: 09/10/2019 10:50:14 p.m. ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_inv_inventario] ON [dbo].[inv_inventarios]
(
	[sigla] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_srv_servidores]    Script Date: 09/10/2019 10:50:14 p.m. ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_srv_servidores] ON [dbo].[srv_servidores]
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_sucursales]    Script Date: 09/10/2019 10:50:14 p.m. ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_sucursales] ON [dbo].[suc_sucursales]
(
	[sigla] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[bas_campos]  WITH CHECK ADD  CONSTRAINT [FK_sis_campos_sis_tablas] FOREIGN KEY([tabla])
REFERENCES [dbo].[bas_tablas] ([id])
GO
ALTER TABLE [dbo].[bas_campos] CHECK CONSTRAINT [FK_sis_campos_sis_tablas]
GO
ALTER TABLE [dbo].[bas_procedimientos]  WITH CHECK ADD  CONSTRAINT [FK_sis_procedimientos_sis_bases] FOREIGN KEY([base])
REFERENCES [dbo].[bas_bases] ([id])
GO
ALTER TABLE [dbo].[bas_procedimientos] CHECK CONSTRAINT [FK_sis_procedimientos_sis_bases]
GO
ALTER TABLE [dbo].[bas_tablas]  WITH CHECK ADD  CONSTRAINT [FK_sis_tablas_sis_bases] FOREIGN KEY([base])
REFERENCES [dbo].[bas_bases] ([id])
GO
ALTER TABLE [dbo].[bas_tablas] CHECK CONSTRAINT [FK_sis_tablas_sis_bases]
GO
ALTER TABLE [dbo].[bas_vistas]  WITH CHECK ADD  CONSTRAINT [FK_sis_vistas_sis_bases] FOREIGN KEY([base])
REFERENCES [dbo].[bas_bases] ([id])
GO
ALTER TABLE [dbo].[bas_vistas] CHECK CONSTRAINT [FK_sis_vistas_sis_bases]
GO
ALTER TABLE [dbo].[seg_perfiles_permisos]  WITH CHECK ADD  CONSTRAINT [FK_seg_perfiles_permisos_seg_perfiles] FOREIGN KEY([perfil])
REFERENCES [dbo].[seg_perfiles] ([id])
GO
ALTER TABLE [dbo].[seg_perfiles_permisos] CHECK CONSTRAINT [FK_seg_perfiles_permisos_seg_perfiles]
GO
ALTER TABLE [dbo].[seg_perfiles_permisos]  WITH CHECK ADD  CONSTRAINT [FK_seg_perfiles_permisos_seg_permisos] FOREIGN KEY([permiso])
REFERENCES [dbo].[seg_permisos] ([id])
GO
ALTER TABLE [dbo].[seg_perfiles_permisos] CHECK CONSTRAINT [FK_seg_perfiles_permisos_seg_permisos]
GO
/****** Object:  StoredProcedure [dbo].[SP_TEST]    Script Date: 09/10/2019 10:50:14 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_TEST]
AS
BEGIN

	select * from [CAP_BSC].[dbo].[gerencias]
END
GO
USE [master]
GO
ALTER DATABASE [CAP_BSC] SET  READ_WRITE 
GO
