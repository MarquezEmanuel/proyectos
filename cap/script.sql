USE [master]
GO
/****** Object:  Database [CAP_BSC]    Script Date: 15/11/2019 15:44:12 ******/
CREATE DATABASE [CAP_BSC]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'CAP_BSC', FILENAME = N'D:\Bases_SQL\CAP_BSC.mdf' , SIZE = 98304KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'CAP_BSC_log', FILENAME = N'E:\Log_SQL\CAP_BSC_log.ldf' , SIZE = 135936KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
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
USE [CAP_BSC]
GO
/****** Object:  Table [dbo].[bas_bases]    Script Date: 15/11/2019 15:44:12 ******/
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
	[rti] [nvarchar](5) NULL,
	[estado] [nvarchar](15) NULL,
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_sis_basesDatos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_campos]    Script Date: 15/11/2019 15:44:12 ******/
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
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_sis_campos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_procedimientos]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[bas_tablas]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_tablas](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NOT NULL,
	[objeto] [nvarchar](50) NULL,
	[nombre] [nvarchar](70) NOT NULL,
	[descripcion] [nvarchar](500) NULL,
	[fechaCreacion] [smalldatetime] NULL,
	[fechaModificacion] [smalldatetime] NULL,
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_sis_tablas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_vistas]    Script Date: 15/11/2019 15:44:12 ******/
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
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_sis_vistas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[com_switches]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[com_switches](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[modelo] [nvarchar](50) NULL,
	[version] [nvarchar](50) NULL,
	[instalacion] [nvarchar](50) NULL,
	[rti] [nvarchar](5) NULL,
	[sucursal] [bigint] NULL,
 CONSTRAINT [PK_com_switches] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[dep_activos_hijos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_activos_hijos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_dep_activosHijos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[dep_activos_inventarios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_activos_inventarios](
	[idActivoPadre] [bigint] NULL,
	[idInventario] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[dep_activos_padres]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_activos_padres](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[categoria] [nvarchar](50) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_dep_dependencias] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[dep_dependencias]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_dependencias](
	[idActivoPadre] [bigint] NULL,
	[idActivoHijo] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fir_firewall]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fir_firewall](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[firewall] [nvarchar](50) NULL,
	[marca] [nvarchar](50) NULL,
	[modelo] [nvarchar](50) NULL,
	[numeroSerie] [nvarchar](50) NULL,
	[version] [nvarchar](50) NULL,
	[ip] [nvarchar](15) NULL,
	[sucursal] [nvarchar](10) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_fir_firewall] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fir_firewalls_inventarios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fir_firewalls_inventarios](
	[idFirewall] [bigint] NULL,
	[idInventario] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ger_departamentos]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[ger_gerencias]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[ger_personas]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[har_hardware]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[har_hardware](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[tipo] [nvarchar](50) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[dominio] [nvarchar](20) NOT NULL,
	[softwareBase] [nvarchar](50) NULL,
	[ambiente] [nvarchar](20) NOT NULL,
	[funcion] [nvarchar](50) NOT NULL,
	[ubicacion] [nvarchar](10) NOT NULL,
	[marca] [nvarchar](30) NULL,
	[modelo] [nvarchar](30) NULL,
	[arquitectura] [nvarchar](30) NULL,
	[core] [nvarchar](30) NULL,
	[procesador] [nvarchar](30) NULL,
	[mhz] [int] NULL,
	[memoria] [int] NULL,
	[disco] [nvarchar](50) NULL,
	[raid] [nvarchar](50) NULL,
	[red] [int] NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_har_hardware] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_har_hardware] UNIQUE NONCLUSTERED 
(
	[sigla] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[har_hardwares_inventarios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[har_hardwares_inventarios](
	[idHardware] [bigint] NULL,
	[idInventario] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ins_instalaciones]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ins_instalaciones](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[responsable] [nvarchar](10) NOT NULL,
	[ubicacion] [nvarchar](10) NOT NULL,
	[plataforma] [nvarchar](50) NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[descripcion] [nvarchar](150) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_ins_instalaciones] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_ins_instalaciones] UNIQUE NONCLUSTERED 
(
	[sigla] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ins_instalaciones_inventarios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ins_instalaciones_inventarios](
	[idInstalacion] [bigint] NULL,
	[idInventario] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_inventarios]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[log_actividades]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[pce_procesos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pce_procesos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigo] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[valor] [int] NULL,
	[rti] [nvarchar](5) NULL,
 CONSTRAINT [PK_pro_procesos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pro_proveedores]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[pro_responsables]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[seg_perfiles]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[seg_perfiles_permisos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfiles_permisos](
	[perfil] [int] NULL,
	[permiso] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_permisos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_permisos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[titulo] [nvarchar](20) NOT NULL,
	[nivel] [int] NOT NULL,
	[padre] [int] NULL,
	[link] [nvarchar](100) NULL,
	[formulario] [nvarchar](50) NULL,
 CONSTRAINT [PK_seg_permisos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_usuarios]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[ser_servicios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ser_servicios](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[tipo] [nvarchar](50) NULL,
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
/****** Object:  Table [dbo].[sis_aplicativos]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  Table [dbo].[sit_sitios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sit_sitios](
	[id] [nvarchar](10) NOT NULL,
	[tipo] [nvarchar](10) NULL,
	[nombre] [nvarchar](50) NULL,
	[provincia] [nvarchar](50) NULL,
	[localidad] [nvarchar](50) NULL,
	[codigoPostal] [bigint] NULL,
	[direccion] [nvarchar](60) NULL,
	[origen] [nvarchar](15) NULL,
	[estado] [int] NULL,
 CONSTRAINT [PK_sit_sitios] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[srv_servidores]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[srv_servidores](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](30) NOT NULL,
	[ip] [nvarchar](15) NULL,
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
/****** Object:  Table [dbo].[srv_servidores_inventarios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[srv_servidores_inventarios](
	[idServidor] [bigint] NULL,
	[idInventario] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[suc_sucursales]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  View [dbo].[reporteBaseDatos]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  View [dbo].[reporteCampos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

  create view [dbo].[reporteCampos]
  as
  SELECT  CAM.id idCampo,
		  TAB.id idTabla,
		  TAB.nombre nombreTabla,
		  BAS.nombre nombreBase,
		  CAM.nombre nombreCampo,
		  CAM.nulos,
		  CAM.tipo,
		  CAM.maximo,
		  CAM.fechaProceso
  FROM [CAP_BSC].[dbo].[bas_campos] CAM
  INNER JOIN [CAP_BSC].[dbo].[bas_tablas] TAB ON TAB.id = CAM.tabla
  INNER JOIN [CAP_BSC].[dbo].[bas_bases] BAS ON BAS.id = TAB.base
GO
/****** Object:  View [dbo].[reporteDepartamentos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[reporteDepartamentos]
as
SELECT DEP.id idDepto,
	   DEP.nombre nombreDepto,
	   GER.id idGerencia,
	   GER.nombre nombreGerencia,
	   GER.jefe jefeGerencia,
	   GER.estado codEstadoGerencia,
	   DEP.estado codEstadoDepto,
	   (CASE WHEN DEP.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoDepto
FROM [dbo].[ger_departamentos] DEP
INNER JOIN [dbo].[ger_gerencias] GER ON GER.id = DEP.gerencia

GO
/****** Object:  View [dbo].[reporteDependencias]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  View [dbo].[reporteFirewalls]    Script Date: 15/11/2019 15:44:12 ******/
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
	   SIT.id idSitio,
	   SIT.tipo,
	   SIT.nombre nombreSitio,
	   SIT.provincia,
	   SIT.localidad,
	   SIT.codigoPostal,
	   SIT.direccion,
	   SIT.origen,
	   SIT.estado codEstadoSitio,
	   (CASE WHEN SIT.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoSitio,
	   INV.id idInventario,
	   INV.sigla,
	   INV.fechaCreacion,
	   INV.estado codEstadoInventario,
	   (CASE WHEN INV.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoInventario
FROM [fir_firewall] FIR 
INNER JOIN [sit_sitios] SIT ON SIT.id = FIR.sucursal
INNER JOIN [fir_firewalls_inventarios] REL ON REL.idFirewall = FIR.id
INNER JOIN [inv_inventarios] INV ON INV.id = REL.idInventario


GO
/****** Object:  View [dbo].[reporteGerencias]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[reporteGerencias]
as
select ger.id idGerencia,
	   ger.nombre nombreGerencia,
	   ger.jefe legajoJefe,
	   per.nombre nombreJefe,
	   per.estado estadoJefe,
	   ger.estado codEstadoGerencia,
	   (case when ger.estado = 1 then 'Activa' else 'Inactiva' end) nomEstadoGerencia
from [dbo].[ger_gerencias] ger
left join [dbo].[ger_personas] per on per.id = ger.jefe

GO
/****** Object:  View [dbo].[reporteHardwares]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[reporteHardwares]
as
SELECT HAR.id idHardware,
	   HAR.tipo tipoHardware,
	   HAR.sigla siglaHardware,
	   HAR.nombre nombreHardware,
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
	   SIT.id idSitio,
	   SIT.tipo tipoSitio,
	   SIT.nombre nombreSitio,
	   SIT.provincia,
	   SIT.localidad,
	   SIT.codigoPostal,
	   SIT.direccion,
	   SIT.origen,
	   SIT.estado codEstadoSitio,
	   (CASE WHEN SIT.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoSitio,
	   INV.sigla siglaInventario,
	   INV.fechaCreacion,
	   INV.estado codEstadoInventario,
	   (CASE WHEN INV.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoInventario
FROM [dbo].[har_hardware] HAR
INNER JOIN [dbo].[har_hardwares_inventarios] REL ON REL.idHardware = HAR.id
INNER JOIN [dbo].[inv_inventarios] INV ON INV.id = REL.idInventario
INNER JOIN [dbo].[sit_sitios] SIT ON SIT.id = HAR.ubicacion 

GO
/****** Object:  View [dbo].[reporteInstalaciones]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[reporteInstalaciones]
as
SELECT 
INS.id idInstalacion,
INS.sigla siglaInstalacion,
INS.nombre nombreInstalacion,
INS.gerencia idGerencia,
GER.nombre nombreGerencia,
INS.responsable idResponsable,
RES.nombre nombreResponsable,
INS.ubicacion idUbicacion,
SIT.tipo tipoSitio,
SIT.nombre nombreSitio,
INS.plataforma,
INS.rti,
INS.descripcion,
INS.estado codEstadoInstalacion,
(CASE WHEN INS.estado = 1 THEN 'Activa' ELSE 'Inactiva' END) nomEstadoInstalacion,
INV.id,
INV.sigla,
INV.fechaCreacion,
INV.estado codEstadoInventario,
(CASE WHEN INV.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoInventario
FROM ins_instalaciones INS
INNER JOIN ger_gerencias GER ON GER.id = INS.gerencia
INNER JOIN ger_personas RES ON RES.id = INS.responsable
INNER JOIN sit_sitios SIT ON SIT.id = INS.ubicacion
INNER JOIN ins_instalaciones_inventarios REL ON REL.idInstalacion = INS.id
INNER JOIN inv_inventarios INV ON INV.id = REL.idInventario

GO
/****** Object:  View [dbo].[reporteInventarios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[reporteInventarios]
as
select * from [CAP_BSC].[dbo].[inv_inventarios]

GO
/****** Object:  View [dbo].[reportePersonas]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[reportePersonas]
as
SELECT PER.id idPersona,
	   PER.nombre nombrePersona,
	   DEP.id idDepto,
	   DEP.nombre nombreDepto,
	   DEP.estado estadoDepto,
	   GER.id idGerencia,
	   GER.nombre nombreGerencia,
	   GER.estado estadoGerencia,
	   PER.estado codEstadoPersona,
	   (CASE WHEN PER.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoPersona
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
	   PER.estado codEstadoPersona,
	   (CASE WHEN PER.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoPersona
FROM [dbo].[ger_personas] PER
LEFT JOIN [dbo].[ger_gerencias] GER ON GER.jefe = PER.id
WHERE PER.departamento is null

GO
/****** Object:  View [dbo].[reporteProcedimientos]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


  create view [dbo].[reporteProcedimientos]
  as
  SELECT PRO.id idSP,
		 PRO.base idBase,
		 BAS.nombre nombreBase,
		 PRO.nombre nombreSP,
		 PRO.definicion,
		 PRO.fechaCreacion,
		 PRO.fechaModificacion,
		 PRO.descripcion,
		 PRO.fechaProceso
  FROM [CAP_BSC].[dbo].[bas_procedimientos] PRO
  INNER JOIN [CAP_BSC].[dbo].[bas_bases] BAS ON BAS.id = PRO.base
GO
/****** Object:  View [dbo].[reporteProveedores]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  View [dbo].[reporteResponsables]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  View [dbo].[reporteServicios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[reporteServicios]
as
SELECT SER.id idServicio,
	   SER.sigla siglaServicio,
	   SER.nombre,
	   SER.inventario idInventario,
	   INV.sigla siglaInventario,
	   INV.estado codEstadoInventario,
	   SER.departamento idDepto,
	   DEP.nombre nombreDepto,
	   SER.disponibilidad,
	   SER.integridad,
	   SER.confidencialidad,
	   SER.autenticidad,
	   SER.rti,
	   SER.estado codEstadoServicio,
	   (CASE WHEN SER.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoServicio
FROM [dbo].[ser_servicios] SER
INNER JOIN [dbo].[inv_inventarios] INV ON INV.id = SER.inventario AND INV.estado = 1
INNER JOIN [dbo].[ger_departamentos] DEP ON DEP.id = SER.inventario

GO
/****** Object:  View [dbo].[reporteServidores]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[reporteServidores]
as
select SER.id idServidor,
	   SER.nombre nombreServidor,
	   SER.ip,
	   ambiente codigoAmbiente,
	   (CASE WHEN SER.ambiente = 1 THEN 'Producción'
			 WHEN SER.ambiente = 2 THEN 'Test'
			 ELSE 'Desarrollo' END) nombreAmbiente,
	   SER.tipo codigoTipo,
	   (CASE WHEN SER.tipo = 1 THEN 'Aplicaciones'
			 WHEN SER.tipo = 2 THEN 'Bases de datos'
			 ELSE 'Ambos' END) nombreTipo,
	   SER.descripcion,
	   SER.estado codEstadoServidor,
	   (CASE WHEN SER.estado=1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoServidor,
	   INV.id idInventario,
	   INV.sigla,
	   INV.fechaCreacion,
	   INV.estado codEstadoInventario,
	   (CASE WHEN INV.estado=1 THEN 'Activo' ELSE 'Inactivo' END) nomEstadoInventario
from [CAP_BSC].[dbo].[srv_servidores] SER
INNER JOIN [CAP_BSC].[dbo].[srv_servidores_inventarios] REL ON REL.idServidor = SER.id
INNER JOIN [CAP_BSC].[dbo].[inv_inventarios] INV ON INV.id = REL.idInventario


GO
/****** Object:  View [dbo].[reporteSitios]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


create View [dbo].[reporteSitios]
as
select SIT.id,
		SIT.tipo,
		SIT.nombre,
		SIT.provincia,
		SIT.localidad,
		SIT.codigoPostal,
		SIT.direccion,
		SIT.origen,
		SIT.estado codigoEstado,
		(CASE WHEN SIT.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) nombreEstado 
from [dbo].[sit_sitios] SIT
GO
/****** Object:  View [dbo].[reporteSucursales]    Script Date: 15/11/2019 15:44:12 ******/
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
/****** Object:  View [dbo].[reporteTablas]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reporteTablas]
as
  SELECT TAB.id idTabla,
		 BAS.id idBase,
		 BAS.nombre nombreBase,
		 TAB.objeto objeto,
		 TAB.nombre nombreTabla,
		 TAB.descripcion,
		 TAB.fechaCreacion,
		 TAB.fechaModificacion,
		 TAB.fechaProceso
	FROM [CAP_BSC].[dbo].[bas_tablas] TAB
	INNER JOIN [CAP_BSC].[dbo].[bas_bases] BAS ON TAB.base = BAS.id
GO
/****** Object:  View [dbo].[reporteVistas]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[reporteVistas]
as
SELECT VIS.id idVista,
	   BAS.id idBase,
	   BAS.nombre nombreBase,
	   VIS.nombre nombreVista,
	   VIS.consulta,
	   VIS.descripcion,
	   VIS.fechaProceso
FROM [bas_vistas] VIS
INNER JOIN [bas_bases] BAS ON VIS.base = BAS.id


GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [IX_inv_inventario]    Script Date: 15/11/2019 15:44:12 ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_inv_inventario] ON [dbo].[inv_inventarios]
(
	[sigla] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [IX_srv_servidores]    Script Date: 15/11/2019 15:44:12 ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_srv_servidores] ON [dbo].[srv_servidores]
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [IX_sucursales]    Script Date: 15/11/2019 15:44:12 ******/
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
ALTER TABLE [dbo].[dep_activos_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_dep_activos_inventarios_dep_activosPadres] FOREIGN KEY([idActivoPadre])
REFERENCES [dbo].[dep_activos_padres] ([id])
GO
ALTER TABLE [dbo].[dep_activos_inventarios] CHECK CONSTRAINT [FK_dep_activos_inventarios_dep_activosPadres]
GO
ALTER TABLE [dbo].[dep_activos_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_dep_activos_inventarios_inv_inventarios] FOREIGN KEY([idInventario])
REFERENCES [dbo].[inv_inventarios] ([id])
GO
ALTER TABLE [dbo].[dep_activos_inventarios] CHECK CONSTRAINT [FK_dep_activos_inventarios_inv_inventarios]
GO
ALTER TABLE [dbo].[dep_dependencias]  WITH CHECK ADD  CONSTRAINT [FK_dep_dependencias_dep_activosHijos] FOREIGN KEY([idActivoHijo])
REFERENCES [dbo].[dep_activos_hijos] ([id])
GO
ALTER TABLE [dbo].[dep_dependencias] CHECK CONSTRAINT [FK_dep_dependencias_dep_activosHijos]
GO
ALTER TABLE [dbo].[dep_dependencias]  WITH CHECK ADD  CONSTRAINT [FK_dep_dependencias_dep_activosPadres] FOREIGN KEY([idActivoPadre])
REFERENCES [dbo].[dep_activos_padres] ([id])
GO
ALTER TABLE [dbo].[dep_dependencias] CHECK CONSTRAINT [FK_dep_dependencias_dep_activosPadres]
GO
ALTER TABLE [dbo].[fir_firewalls_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_fir_firewalls_inventarios_fir_firewall] FOREIGN KEY([idFirewall])
REFERENCES [dbo].[fir_firewall] ([id])
GO
ALTER TABLE [dbo].[fir_firewalls_inventarios] CHECK CONSTRAINT [FK_fir_firewalls_inventarios_fir_firewall]
GO
ALTER TABLE [dbo].[fir_firewalls_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_fir_firewalls_inventarios_inv_inventarios] FOREIGN KEY([idInventario])
REFERENCES [dbo].[inv_inventarios] ([id])
GO
ALTER TABLE [dbo].[fir_firewalls_inventarios] CHECK CONSTRAINT [FK_fir_firewalls_inventarios_inv_inventarios]
GO
ALTER TABLE [dbo].[har_hardwares_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_har_hardwares_inventarios_har_hardware] FOREIGN KEY([idHardware])
REFERENCES [dbo].[har_hardware] ([id])
GO
ALTER TABLE [dbo].[har_hardwares_inventarios] CHECK CONSTRAINT [FK_har_hardwares_inventarios_har_hardware]
GO
ALTER TABLE [dbo].[har_hardwares_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_har_hardwares_inventarios_inv_inventarios] FOREIGN KEY([idInventario])
REFERENCES [dbo].[inv_inventarios] ([id])
GO
ALTER TABLE [dbo].[har_hardwares_inventarios] CHECK CONSTRAINT [FK_har_hardwares_inventarios_inv_inventarios]
GO
ALTER TABLE [dbo].[ins_instalaciones_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_ins_instalaciones_inventarios_ins_instalaciones] FOREIGN KEY([idInstalacion])
REFERENCES [dbo].[ins_instalaciones] ([id])
GO
ALTER TABLE [dbo].[ins_instalaciones_inventarios] CHECK CONSTRAINT [FK_ins_instalaciones_inventarios_ins_instalaciones]
GO
ALTER TABLE [dbo].[ins_instalaciones_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_ins_instalaciones_inventarios_inv_inventarios] FOREIGN KEY([idInventario])
REFERENCES [dbo].[inv_inventarios] ([id])
GO
ALTER TABLE [dbo].[ins_instalaciones_inventarios] CHECK CONSTRAINT [FK_ins_instalaciones_inventarios_inv_inventarios]
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
ALTER TABLE [dbo].[srv_servidores_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_srv_servidores_inventarios_inv_inventarios] FOREIGN KEY([idInventario])
REFERENCES [dbo].[inv_inventarios] ([id])
GO
ALTER TABLE [dbo].[srv_servidores_inventarios] CHECK CONSTRAINT [FK_srv_servidores_inventarios_inv_inventarios]
GO
ALTER TABLE [dbo].[srv_servidores_inventarios]  WITH CHECK ADD  CONSTRAINT [FK_srv_servidores_inventarios_srv_servidores] FOREIGN KEY([idServidor])
REFERENCES [dbo].[srv_servidores] ([id])
GO
ALTER TABLE [dbo].[srv_servidores_inventarios] CHECK CONSTRAINT [FK_srv_servidores_inventarios_srv_servidores]
GO
/****** Object:  StoredProcedure [dbo].[CARGA_CAMPOS_DESABASES3]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create PROCEDURE [dbo].[CARGA_CAMPOS_DESABASES3]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'DESABASES3');

	IF(@IDSERVIDOR > 0) 
		BEGIN

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQL NVARCHAR(MAX);

			CREATE TABLE #CAMPOS(IDBASE NVARCHAR(50),
								 IDTABLA BIGINT,
								 TABLA NVARCHAR(200),
								 NOMBRE NVARCHAR(200),
								 NULOS NVARCHAR(5),
								 TIPO NVARCHAR(20),
								 MAXIMO BIGINT)

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			WHILE @CONTADOR > 1
				BEGIN

					SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
					SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				
					SET @SQL = 'SELECT '+@IDBASE+',* FROM OPENQUERY([192.168.250.133], '' SELECT TABLE_NAME tabla,
									   COLUMN_NAME nombre,
									   IS_NULLABLE nulos,
									   UPPER(DATA_TYPE) tipo,
									   CHARACTER_MAXIMUM_LENGTH maximo
								FROM '+@NOMBRE+'.INFORMATION_SCHEMA.columns 
								WHERE TABLE_NAME <> ''''sysdiagrams'''' '')';
					INSERT INTO #CAMPOS (IDBASE, TABLA, NOMBRE, NULOS, TIPO, MAXIMO)
					EXEC(@SQL);

					DELETE FROM #BASES2 WHERE nombre = @NOMBRE
					SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
				END

			-- ACTUALIZA EL ID DE CADA TABLA

			UPDATE #CAMPOS SET IDTABLA = TAB.idTabla
			FROM #CAMPOS CAM INNER JOIN (SELECT BAS.id idBase, TAB.id idTabla, TAB.nombre nombreTabla
									FROM [dbo].[bas_tablas] TAB 
									INNER JOIN [dbo].[bas_bases] BAS ON TAB.base = BAS.id AND BAS.desarrollo = @IDSERVIDOR) TAB ON 
						TAB.idBase = CAM.IDBASE AND TAB.nombreTabla = CAM.TABLA
 
			-- ELIMINA LAS VISTAS (CONSIDERADAS TABLAS)

			DELETE FROM #CAMPOS WHERE IDTABLA IS NULL

			-- AGREGA O ACTUALIZA LOS CAMPOS DE CADA BASE DEL SERVIDOR

			MERGE [dbo].[bas_campos] T USING #CAMPOS TMP 
			ON (T.tabla = TMP.IDTABLA AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (tabla, nombre, nulos, tipo, maximo, fechaProceso)
				VALUES (TMP.IDTABLA, TMP.NOMBRE, TMP.NULOS, TMP.TIPO, TMP.MAXIMO, GETDATE());

			DROP TABLE #BASES2
			DROP TABLE #CAMPOS

		END

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_CAMPOS_DESABASES4]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_CAMPOS_DESABASES4]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'DESABASES4');

	IF(@IDSERVIDOR > 0) 
		BEGIN

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQL NVARCHAR(MAX);

			CREATE TABLE #CAMPOS(IDBASE NVARCHAR(50),
								 IDTABLA BIGINT,
								 TABLA NVARCHAR(200),
								 NOMBRE NVARCHAR(200),
								 NULOS NVARCHAR(5),
								 TIPO NVARCHAR(20),
								 MAXIMO BIGINT)

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			WHILE @CONTADOR > 1
				BEGIN

					SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
					SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				
					SET @SQL = 'SELECT '+@IDBASE+',* FROM OPENQUERY([192.168.250.251], '' SELECT TABLE_NAME tabla,
									   COLUMN_NAME nombre,
									   IS_NULLABLE nulos,
									   UPPER(DATA_TYPE) tipo,
									   CHARACTER_MAXIMUM_LENGTH maximo
								FROM '+@NOMBRE+'.INFORMATION_SCHEMA.columns 
								WHERE TABLE_NAME <> ''''sysdiagrams'''' '')';
					INSERT INTO #CAMPOS (IDBASE, TABLA, NOMBRE, NULOS, TIPO, MAXIMO)
					EXEC(@SQL);

					DELETE FROM #BASES2 WHERE nombre = @NOMBRE
					SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
				END

			-- ACTUALIZA EL ID DE CADA TABLA

			UPDATE #CAMPOS SET IDTABLA = TAB.idTabla
			FROM #CAMPOS CAM INNER JOIN (SELECT BAS.id idBase, TAB.id idTabla, TAB.nombre nombreTabla
									FROM [dbo].[bas_tablas] TAB 
									INNER JOIN [dbo].[bas_bases] BAS ON TAB.base = BAS.id AND BAS.desarrollo = @IDSERVIDOR) TAB ON 
						TAB.idBase = CAM.IDBASE AND TAB.nombreTabla = CAM.TABLA
 
			-- ELIMINA LAS VISTAS (CONSIDERADAS TABLAS)

			DELETE FROM #CAMPOS WHERE IDTABLA IS NULL

			-- AGREGA O ACTUALIZA LOS CAMPOS DE CADA BASE DEL SERVIDOR

			MERGE [dbo].[bas_campos] T USING #CAMPOS TMP 
			ON (T.tabla = TMP.IDTABLA AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (tabla, nombre, nulos, tipo, maximo, fechaProceso)
				VALUES (TMP.IDTABLA, TMP.NOMBRE, TMP.NULOS, TMP.TIPO, TMP.MAXIMO, GETDATE());

			DROP TABLE #BASES2
			DROP TABLE #CAMPOS

		END


END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_CAMPOS_DESABASES5]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_CAMPOS_DESABASES5]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'DESABASES5');

	IF(@IDSERVIDOR > 0) 
		BEGIN

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQL NVARCHAR(MAX);

			CREATE TABLE #CAMPOS(IDBASE NVARCHAR(50),
								 IDTABLA BIGINT,
								 TABLA NVARCHAR(200),
								 NOMBRE NVARCHAR(200),
								 NULOS NVARCHAR(5),
								 TIPO NVARCHAR(20),
								 MAXIMO BIGINT)

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			WHILE @CONTADOR > 1
				BEGIN

					SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
					SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				
					SET @SQL = 'SELECT '+@IDBASE+',* FROM OPENQUERY([192.168.250.134], '' SELECT TABLE_NAME tabla,
									   COLUMN_NAME nombre,
									   IS_NULLABLE nulos,
									   UPPER(DATA_TYPE) tipo,
									   CHARACTER_MAXIMUM_LENGTH maximo
								FROM '+@NOMBRE+'.INFORMATION_SCHEMA.columns 
								WHERE TABLE_NAME <> ''''sysdiagrams'''' '')';

					IF(@NOMBRE <> 'MensajeriaEntidad')
					BEGIN
						INSERT INTO #CAMPOS (IDBASE, TABLA, NOMBRE, NULOS, TIPO, MAXIMO)
						EXEC(@SQL);
					END

					DELETE FROM #BASES2 WHERE nombre = @NOMBRE
					SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
				END

			-- ACTUALIZA EL ID DE CADA TABLA

			UPDATE #CAMPOS SET IDTABLA = TAB.idTabla
			FROM #CAMPOS CAM INNER JOIN (SELECT BAS.id idBase, TAB.id idTabla, TAB.nombre nombreTabla
									FROM [dbo].[bas_tablas] TAB 
									INNER JOIN [dbo].[bas_bases] BAS ON TAB.base = BAS.id AND BAS.desarrollo = @IDSERVIDOR) TAB ON 
						TAB.idBase = CAM.IDBASE AND TAB.nombreTabla = CAM.TABLA
 
			-- ELIMINA LAS VISTAS (CONSIDERADAS TABLAS)

			DELETE FROM #CAMPOS WHERE IDTABLA IS NULL

			-- AGREGA O ACTUALIZA LOS CAMPOS DE CADA BASE DEL SERVIDOR

			MERGE [dbo].[bas_campos] T USING #CAMPOS TMP 
			ON (T.tabla = TMP.IDTABLA AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (tabla, nombre, nulos, tipo, maximo, fechaProceso)
				VALUES (TMP.IDTABLA, TMP.NOMBRE, TMP.NULOS, TMP.TIPO, TMP.MAXIMO, GETDATE());

			DROP TABLE #BASES2
			DROP TABLE #CAMPOS

		END

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_CAMPOS_VM250DB00]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_CAMPOS_VM250DB00]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'VM250DB00');

	IF(@IDSERVIDOR > 0) 
		BEGIN

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQL NVARCHAR(MAX);

			CREATE TABLE #CAMPOS(IDBASE NVARCHAR(50),
								 IDTABLA BIGINT,
								 TABLA NVARCHAR(200),
								 NOMBRE NVARCHAR(200),
								 NULOS NVARCHAR(5),
								 TIPO NVARCHAR(20),
								 MAXIMO BIGINT)

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			WHILE @CONTADOR > 1
				BEGIN

					SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
					SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				
					SET @SQL = 'SELECT '+@IDBASE+',* FROM OPENQUERY([192.168.250.141], '' SELECT TABLE_NAME tabla,
									   COLUMN_NAME nombre,
									   IS_NULLABLE nulos,
									   UPPER(DATA_TYPE) tipo,
									   CHARACTER_MAXIMUM_LENGTH maximo
								FROM '+@NOMBRE+'.INFORMATION_SCHEMA.columns 
								WHERE TABLE_NAME <> ''''sysdiagrams'''' '')';
					INSERT INTO #CAMPOS (IDBASE, TABLA, NOMBRE, NULOS, TIPO, MAXIMO)
					EXEC(@SQL);

					DELETE FROM #BASES2 WHERE nombre = @NOMBRE
					SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
				END

			-- ACTUALIZA EL ID DE CADA TABLA

			UPDATE #CAMPOS SET IDTABLA = TAB.idTabla
			FROM #CAMPOS CAM INNER JOIN (SELECT BAS.id idBase, TAB.id idTabla, TAB.nombre nombreTabla
									FROM [dbo].[bas_tablas] TAB 
									INNER JOIN [dbo].[bas_bases] BAS ON TAB.base = BAS.id AND BAS.desarrollo = @IDSERVIDOR) TAB ON 
						TAB.idBase = CAM.IDBASE AND TAB.nombreTabla = CAM.TABLA
 
			-- ELIMINA LAS VISTAS (CONSIDERADAS TABLAS)

			DELETE FROM #CAMPOS WHERE IDTABLA IS NULL

			-- AGREGA O ACTUALIZA LOS CAMPOS DE CADA BASE DEL SERVIDOR

			MERGE [dbo].[bas_campos] T USING #CAMPOS TMP 
			ON (T.tabla = TMP.IDTABLA AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (tabla, nombre, nulos, tipo, maximo, fechaProceso)
				VALUES (TMP.IDTABLA, TMP.NOMBRE, TMP.NULOS, TMP.TIPO, TMP.MAXIMO, GETDATE());

			DROP TABLE #BASES2
			DROP TABLE #CAMPOS

		END

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_CAMPOS_VM250DB01]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_CAMPOS_VM250DB01]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'VM250DB01');

	IF(@IDSERVIDOR > 0) 
		BEGIN

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQL NVARCHAR(MAX);

			CREATE TABLE #CAMPOS(IDBASE NVARCHAR(50),
								 IDTABLA BIGINT,
								 TABLA NVARCHAR(200),
								 NOMBRE NVARCHAR(200),
								 NULOS NVARCHAR(5),
								 TIPO NVARCHAR(20),
								 MAXIMO BIGINT)

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			WHILE @CONTADOR > 1
				BEGIN

					SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
					SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				
					SET @SQL = 'SELECT '+@IDBASE+',* FROM OPENQUERY([192.168.250.142], '' SELECT TABLE_NAME tabla,
									   COLUMN_NAME nombre,
									   IS_NULLABLE nulos,
									   UPPER(DATA_TYPE) tipo,
									   CHARACTER_MAXIMUM_LENGTH maximo
								FROM '+@NOMBRE+'.INFORMATION_SCHEMA.columns 
								WHERE TABLE_NAME <> ''''sysdiagrams'''' '')';

					IF(@NOMBRE <> 'MensajeriaEntidad')
					BEGIN
						INSERT INTO #CAMPOS (IDBASE, TABLA, NOMBRE, NULOS, TIPO, MAXIMO)
						EXEC(@SQL);
					END

					DELETE FROM #BASES2 WHERE nombre = @NOMBRE
					SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
				END

			-- ACTUALIZA EL ID DE CADA TABLA

			UPDATE #CAMPOS SET IDTABLA = TAB.idTabla
			FROM #CAMPOS CAM INNER JOIN (SELECT BAS.id idBase, TAB.id idTabla, TAB.nombre nombreTabla
									FROM [dbo].[bas_tablas] TAB 
									INNER JOIN [dbo].[bas_bases] BAS ON TAB.base = BAS.id AND BAS.desarrollo = @IDSERVIDOR) TAB ON 
						TAB.idBase = CAM.IDBASE AND TAB.nombreTabla = CAM.TABLA
 
			-- ELIMINA LAS VISTAS (CONSIDERADAS TABLAS)

			DELETE FROM #CAMPOS WHERE IDTABLA IS NULL

			-- AGREGA O ACTUALIZA LOS CAMPOS DE CADA BASE DEL SERVIDOR

			MERGE [dbo].[bas_campos] T USING #CAMPOS TMP 
			ON (T.tabla = TMP.IDTABLA AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (tabla, nombre, nulos, tipo, maximo, fechaProceso)
				VALUES (TMP.IDTABLA, TMP.NOMBRE, TMP.NULOS, TMP.TIPO, TMP.MAXIMO, GETDATE());

			DROP TABLE #BASES2
			DROP TABLE #CAMPOS

		END

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_CAMPOS_VM250DB02]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_CAMPOS_VM250DB02]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'VM250DB02');

	IF(@IDSERVIDOR > 0) 
		BEGIN

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQL NVARCHAR(MAX);

			CREATE TABLE #CAMPOS(IDBASE NVARCHAR(50),
								 IDTABLA BIGINT,
								 TABLA NVARCHAR(200),
								 NOMBRE NVARCHAR(200),
								 NULOS NVARCHAR(5),
								 TIPO NVARCHAR(20),
								 MAXIMO BIGINT)

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			WHILE @CONTADOR > 1
				BEGIN

					SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
					SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				
					SET @SQL = 'SELECT '+@IDBASE+',* FROM OPENQUERY([192.168.250.154], '' SELECT TABLE_NAME tabla,
									   COLUMN_NAME nombre,
									   IS_NULLABLE nulos,
									   UPPER(DATA_TYPE) tipo,
									   CHARACTER_MAXIMUM_LENGTH maximo
								FROM '+@NOMBRE+'.INFORMATION_SCHEMA.columns 
								WHERE TABLE_NAME <> ''''sysdiagrams'''' '')';

					IF(@NOMBRE <> 'ProBatch')
					BEGIN
						INSERT INTO #CAMPOS (IDBASE, TABLA, NOMBRE, NULOS, TIPO, MAXIMO)
						EXEC(@SQL);
					END

					DELETE FROM #BASES2 WHERE nombre = @NOMBRE
					SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
				END

			-- ACTUALIZA EL ID DE CADA TABLA

			UPDATE #CAMPOS SET IDTABLA = TAB.idTabla
			FROM #CAMPOS CAM INNER JOIN (SELECT BAS.id idBase, TAB.id idTabla, TAB.nombre nombreTabla
									FROM [dbo].[bas_tablas] TAB 
									INNER JOIN [dbo].[bas_bases] BAS ON TAB.base = BAS.id AND BAS.desarrollo = @IDSERVIDOR) TAB ON 
						TAB.idBase = CAM.IDBASE AND TAB.nombreTabla = CAM.TABLA
 
			-- ELIMINA LAS VISTAS (CONSIDERADAS TABLAS)

			DELETE FROM #CAMPOS WHERE IDTABLA IS NULL

			-- AGREGA O ACTUALIZA LOS CAMPOS DE CADA BASE DEL SERVIDOR

			MERGE [dbo].[bas_campos] T USING #CAMPOS TMP 
			ON (T.tabla = TMP.IDTABLA AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (tabla, nombre, nulos, tipo, maximo, fechaProceso)
				VALUES (TMP.IDTABLA, TMP.NOMBRE, TMP.NULOS, TMP.TIPO, TMP.MAXIMO, GETDATE());

			DROP TABLE #BASES2
			DROP TABLE #CAMPOS

		END

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_DESABASES3]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_DESABASES3]
AS
BEGIN

	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'DESABASES3');

	IF(@IDSERVIDOR > 0) 
	BEGIN

		-- DECLARA LAS VARIABLES NECESARIAS

		DECLARE @CONTADOR INT;
		DECLARE @IDBASE NVARCHAR(50);
		DECLARE @NOMBRE NVARCHAR(100);
		DECLARE @SQLTB NVARCHAR(MAX);
		DECLARE @SQLSP NVARCHAR(MAX);
		DECLARE @SQLVW NVARCHAR(MAX);
		
		select idBase, @IDSERVIDOR desarrollo, nombre, fechaCreacion, collation
		into #BASES
		from openquery([192.168.250.133], 'SELECT ''250133''+RIGHT(''0000'' + CAST(database_id AS NVARCHAR), 5) idBase, 
													   name nombre, 
													   create_date fechaCreacion, 
													   collation_name collation 
											   FROM sys.databases 
											   WHERE name not in (''master'', ''tempdb'', ''model'', ''msdb'')')
		
		MERGE [bas_bases] T USING #BASES TMP 
		ON (T.id = TMP.idBase)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (id, produccion, test, desarrollo, nombre, fechaCreacion, collation, rti, estado, fechaProceso)
			VALUES (TMP.idBase, NULL, NULL, TMP.desarrollo, TMP.nombre, TMP.fechaCreacion, TMP.collation, NULL, NULL, GETDATE());	

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS TABLAS DE LAS BASES

		CREATE TABLE #TABLAS (BASE NVARCHAR(100),
							  ID NVARCHAR(20),
							  NOMBRE NVARCHAR(500),
							  CREACION SMALLDATETIME,
							  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNO DE LOS PROCEDIMIENTOS ALMACENADOS DE LAS BASES

		CREATE TABLE #PROCEDIMIENTOS (BASE NVARCHAR(100),
									  NOMBRE NVARCHAR(100),
									  RUTINA NVARCHAR(MAX),
									  CREACION SMALLDATETIME,
									  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS VISTAS DE LAS BASES

		CREATE TABLE #VISTAS (BASE NVARCHAR(100), 
							  NOMBRE NVARCHAR(300))

		-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

		SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

		SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

		-- RECORRE EL WHILE PARA CADA UNA D LAS BASES DE DATOS CORRESPONDIENTES AL SERVIDOR

		WHILE @CONTADOR > 1
		BEGIN

			SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
			SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
			SET @SQLTB = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.133], ''SELECT object_id, 
																	  name, 
																	  create_date, 
																	  modify_date 
															   FROM '+@NOMBRE+'.sys.tables '') ';
			SET @SQLSP = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.133], ''SELECT ROUTINE_NAME, 
								 ROUTINE_DEFINITION, 
								 CREATED, 
								 LAST_ALTERED 
						  FROM '+@NOMBRE+'.information_schema.routines'') ';
	

			SET @SQLVW = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.133], ''SELECT TABLE_NAME FROM '+@NOMBRE+'.information_schema.views'')';

			INSERT INTO #TABLAS
			EXEC(@SQLTB);

			INSERT INTO #PROCEDIMIENTOS
			EXEC(@SQLSP);

			INSERT INTO #VISTAS
			EXEC(@SQLVW);

			DELETE FROM #BASES2 WHERE nombre = @NOMBRE
			SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
		END

		MERGE [bas_tablas] T USING #TABLAS TMP 
		ON (T.base = TMP.BASE AND T.objeto = TMP.ID)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, objeto, nombre, descripcion, fechaCreacion, fechaModificacion, fechaProceso)
			VALUES (TMP.BASE, TMP.ID, TMP.nombre, '', TMP.CREACION, TMP.MODIFICACION, GETDATE());	

		
		--SELECT * FROM #PROCEDIMIENTOS

		MERGE [bas_procedimientos] T USING #PROCEDIMIENTOS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, definicion, fechaCreacion, fechaModificacion, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, TMP.RUTINA, TMP.CREACION, TMP.MODIFICACION, '', GETDATE());	

		--SELECT * FROM #VISTAS

		MERGE [dbo].[bas_vistas] T USING #VISTAS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, consulta, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, 'DESCONOCIDA', '', GETDATE());

		-- ELIMINA TODAS LAS TABLAS TEMPORALES CREADAS 

		DROP TABLE #BASES
		DROP TABLE #BASES2
		DROP TABLE #TABLAS
		DROP TABLE #PROCEDIMIENTOS
		DROP TABLE #VISTAS

	END;

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_DESABASES4]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_DESABASES4]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'DESABASES4');

	IF(@IDSERVIDOR > 0) 
	BEGIN

		-- DECLARA LAS VARIABLES NECESARIAS

		DECLARE @CONTADOR INT;
		DECLARE @IDBASE NVARCHAR(50);
		DECLARE @NOMBRE NVARCHAR(100);
		DECLARE @SQLTB NVARCHAR(MAX);
		DECLARE @SQLSP NVARCHAR(MAX);
		DECLARE @SQLVW NVARCHAR(MAX);

		select idBase, @IDSERVIDOR desarrollo, nombre, fechaCreacion, collation
		into #BASES
		from openquery([192.168.250.251], 'SELECT ''250251''+RIGHT(''0000'' + CAST(database_id AS NVARCHAR), 5) COLLATE Modern_Spanish_CI_AS idBase, 
													   name nombre, 
													   create_date fechaCreacion, 
													   collation_name collation 
											   FROM sys.databases 
											   WHERE name not in (''master'', ''tempdb'', ''model'', ''msdb'')')
		
		MERGE [bas_bases] T USING #BASES TMP 
		ON (T.id = TMP.idBase)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (id, produccion, test, desarrollo, nombre, fechaCreacion, collation, rti, estado, fechaProceso)
			VALUES (TMP.idBase, NULL, NULL, TMP.desarrollo, TMP.nombre, TMP.fechaCreacion, TMP.collation, NULL, NULL, GETDATE());

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS TABLAS DE LAS BASES

		CREATE TABLE #TABLAS (BASE NVARCHAR(100),
							  ID NVARCHAR(20),
							  NOMBRE NVARCHAR(500),
							  CREACION SMALLDATETIME,
							  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNO DE LOS PROCEDIMIENTOS ALMACENADOS DE LAS BASES

		CREATE TABLE #PROCEDIMIENTOS (BASE NVARCHAR(100),
									  NOMBRE NVARCHAR(100),
									  RUTINA NVARCHAR(MAX),
									  CREACION SMALLDATETIME,
									  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS VISTAS DE LAS BASES

		CREATE TABLE #VISTAS (BASE NVARCHAR(100), 
							  NOMBRE NVARCHAR(300))

		-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

		SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

		SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

		-- RECORRE EL WHILE PARA CADA UNA D LAS BASES DE DATOS CORRESPONDIENTES AL SERVIDOR

		WHILE @CONTADOR > 1
		BEGIN

			SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
			SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
			SET @SQLTB = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.251], ''SELECT object_id, 
																	  name, 
																	  create_date, 
																	  modify_date 
															   FROM '+@NOMBRE+'.sys.tables '') ';
			SET @SQLSP = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.251], ''SELECT ROUTINE_NAME, 
								 ROUTINE_DEFINITION, 
								 CREATED, 
								 LAST_ALTERED 
						  FROM '+@NOMBRE+'.information_schema.routines'') ';
	

			SET @SQLVW = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.251], ''SELECT TABLE_NAME FROM '+@NOMBRE+'.information_schema.views'')';

			INSERT INTO #TABLAS
			EXEC(@SQLTB);

			INSERT INTO #PROCEDIMIENTOS
			EXEC(@SQLSP);

			INSERT INTO #VISTAS
			EXEC(@SQLVW);

			DELETE FROM #BASES2 WHERE nombre = @NOMBRE
			SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
		END

		MERGE [bas_tablas] T USING #TABLAS TMP 
		ON (T.base = TMP.BASE AND T.objeto = TMP.ID)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, objeto, nombre, descripcion, fechaCreacion, fechaModificacion, fechaProceso)
			VALUES (TMP.BASE, TMP.ID, TMP.nombre, '', TMP.CREACION, TMP.MODIFICACION, GETDATE());	

		MERGE [bas_procedimientos] T USING #PROCEDIMIENTOS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, definicion, fechaCreacion, fechaModificacion, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, TMP.RUTINA, TMP.CREACION, TMP.MODIFICACION, '', GETDATE());	

		MERGE [dbo].[bas_vistas] T USING #VISTAS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, consulta, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, 'DESCONOCIDA', '', GETDATE());

		-- ELIMINA TODAS LAS TABLAS TEMPORALES CREADAS 

		DROP TABLE #BASES
		DROP TABLE #BASES2
		DROP TABLE #TABLAS
		DROP TABLE #PROCEDIMIENTOS
		DROP TABLE #VISTAS

	END;


END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_DESABASES5]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_DESABASES5]
AS
BEGIN
		DECLARE @IDSERVIDOR BIGINT;

		SET @IDSERVIDOR = 0;
		SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'DESABASES5');

		IF(@IDSERVIDOR > 0) 
		BEGIN

			-- DECLARA LAS VARIABLES NECESARIAS

			DECLARE @CONTADOR INT;
			DECLARE @IDBASE NVARCHAR(50);
			DECLARE @NOMBRE NVARCHAR(100);
			DECLARE @SQLTB NVARCHAR(MAX);
			DECLARE @SQLSP NVARCHAR(MAX);
			DECLARE @SQLVW NVARCHAR(MAX);
		
			select idBase, @IDSERVIDOR desarrollo, nombre, fechaCreacion, collation
			into #BASES
			from openquery([192.168.250.134], 'SELECT ''250134''+RIGHT(''0000'' + CAST(database_id AS NVARCHAR), 5) idBase, 
														   name nombre, 
														   create_date fechaCreacion, 
														   collation_name collation 
												   FROM sys.databases 
												   WHERE name not in (''master'', ''tempdb'', ''model'', ''msdb'')')
		
			MERGE [bas_bases] T USING #BASES TMP 
			ON (T.id = TMP.idBase)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (id, produccion, test, desarrollo, nombre, fechaCreacion, collation, rti, estado, fechaProceso)
				VALUES (TMP.idBase, NULL, NULL, TMP.desarrollo, TMP.nombre, TMP.fechaCreacion, TMP.collation, NULL, NULL, GETDATE());	

			-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS TABLAS DE LAS BASES

			CREATE TABLE #TABLAS (BASE NVARCHAR(100),
								  ID NVARCHAR(20),
								  NOMBRE NVARCHAR(500),
								  CREACION SMALLDATETIME,
								  MODIFICACION SMALLDATETIME)

			-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNO DE LOS PROCEDIMIENTOS ALMACENADOS DE LAS BASES

			CREATE TABLE #PROCEDIMIENTOS (BASE NVARCHAR(100),
										  NOMBRE NVARCHAR(100),
										  RUTINA NVARCHAR(MAX),
										  CREACION SMALLDATETIME,
										  MODIFICACION SMALLDATETIME)

			-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS VISTAS DE LAS BASES

			CREATE TABLE #VISTAS (BASE NVARCHAR(100), 
								  NOMBRE NVARCHAR(300))

			-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

			SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

			SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

			-- RECORRE EL WHILE PARA CADA UNA D LAS BASES DE DATOS CORRESPONDIENTES AL SERVIDOR

			WHILE @CONTADOR > 1
			BEGIN

				SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
				SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
				SET @SQLTB = 'SELECT '+@IDBASE+', * 
							  FROM OPENQUERY ([192.168.250.134], ''SELECT object_id, 
																		  name, 
																		  create_date, 
																		  modify_date 
																   FROM '+@NOMBRE+'.sys.tables '') ';
				SET @SQLSP = 'SELECT '+@IDBASE+', * 
							  FROM OPENQUERY ([192.168.250.134], ''SELECT ROUTINE_NAME, 
									 ROUTINE_DEFINITION, 
									 CREATED, 
									 LAST_ALTERED 
							  FROM '+@NOMBRE+'.information_schema.routines'') ';
	

				SET @SQLVW = 'SELECT '+@IDBASE+', * 
							  FROM OPENQUERY ([192.168.250.134], ''SELECT TABLE_NAME FROM '+@NOMBRE+'.information_schema.views'')';

				INSERT INTO #TABLAS
				EXEC(@SQLTB);

				IF(@NOMBRE <> 'MensajeriaEntidad')
				BEGIN
					INSERT INTO #PROCEDIMIENTOS
					EXEC(@SQLSP);

					INSERT INTO #VISTAS
					EXEC(@SQLVW);
				END

				DELETE FROM #BASES2 WHERE nombre = @NOMBRE
				SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
			END

			MERGE [bas_tablas] T USING #TABLAS TMP 
			ON (T.base = TMP.BASE AND T.objeto = TMP.ID)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaModificacion = TMP.MODIFICACION,
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (base, objeto, nombre, descripcion, fechaCreacion, fechaModificacion, fechaProceso)
				VALUES (TMP.BASE, TMP.ID, TMP.nombre, '', TMP.CREACION, TMP.MODIFICACION, GETDATE());	
	
			--SELECT * FROM #PROCEDIMIENTOS

			MERGE [bas_procedimientos] T USING #PROCEDIMIENTOS TMP 
			ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaModificacion = TMP.MODIFICACION,
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (base, nombre, definicion, fechaCreacion, fechaModificacion, descripcion, fechaProceso)
				VALUES (TMP.BASE, TMP.NOMBRE, TMP.RUTINA, TMP.CREACION, TMP.MODIFICACION, '', GETDATE());	

			--SELECT * FROM #VISTAS

			MERGE [dbo].[bas_vistas] T USING #VISTAS TMP 
			ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
			WHEN MATCHED 
				THEN UPDATE SET 
					T.fechaProceso = getdate()
			WHEN NOT MATCHED BY TARGET 
				THEN INSERT (base, nombre, consulta, descripcion, fechaProceso)
				VALUES (TMP.BASE, TMP.NOMBRE, 'DESCONOCIDA', '', GETDATE());

			-- ELIMINA TODAS LAS TABLAS TEMPORALES CREADAS 

			DROP TABLE #BASES
			DROP TABLE #BASES2
			DROP TABLE #TABLAS
			DROP TABLE #PROCEDIMIENTOS
			DROP TABLE #VISTAS

		END;
END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_VM250DB00]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_VM250DB00]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'VM250DB00');

	IF(@IDSERVIDOR > 0) 
	BEGIN

		-- DECLARA LAS VARIABLES NECESARIAS

		DECLARE @CONTADOR INT;
		DECLARE @IDBASE NVARCHAR(50);
		DECLARE @NOMBRE NVARCHAR(100);
		DECLARE @SQLTB NVARCHAR(MAX);
		DECLARE @SQLSP NVARCHAR(MAX);
		DECLARE @SQLVW NVARCHAR(MAX);

		select idBase, @IDSERVIDOR desarrollo, nombre, fechaCreacion, collation
		into #BASES
		from openquery([192.168.250.141], 'SELECT ''250141''+RIGHT(''0000'' + CAST(database_id AS NVARCHAR), 5) idBase, 
													   name nombre, 
													   create_date fechaCreacion, 
													   collation_name collation 
											   FROM sys.databases 
											   WHERE name not in (''master'', ''tempdb'', ''model'', ''msdb'')')
		
		MERGE [bas_bases] T USING #BASES TMP 
		ON (T.id = TMP.idBase)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (id, produccion, test, desarrollo, nombre, fechaCreacion, collation, rti, estado, fechaProceso)
			VALUES (TMP.idBase, NULL, NULL, TMP.desarrollo, TMP.nombre, TMP.fechaCreacion, TMP.collation, NULL, NULL, GETDATE());

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS TABLAS DE LAS BASES

		CREATE TABLE #TABLAS (BASE NVARCHAR(100),
							  ID NVARCHAR(20),
							  NOMBRE NVARCHAR(500),
							  CREACION SMALLDATETIME,
							  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNO DE LOS PROCEDIMIENTOS ALMACENADOS DE LAS BASES

		CREATE TABLE #PROCEDIMIENTOS (BASE NVARCHAR(100),
									  NOMBRE NVARCHAR(100),
									  RUTINA NVARCHAR(MAX),
									  CREACION SMALLDATETIME,
									  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS VISTAS DE LAS BASES

		CREATE TABLE #VISTAS (BASE NVARCHAR(100), 
							  NOMBRE NVARCHAR(300))

		-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

		SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

		SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

		-- RECORRE EL WHILE PARA CADA UNA D LAS BASES DE DATOS CORRESPONDIENTES AL SERVIDOR

		WHILE @CONTADOR > 1
		BEGIN

			SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
			SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
			SET @SQLTB = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.141], ''SELECT object_id, 
																	  name, 
																	  create_date, 
																	  modify_date 
															   FROM '+@NOMBRE+'.sys.tables '') ';
			SET @SQLSP = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.141], ''SELECT ROUTINE_NAME, 
								 ROUTINE_DEFINITION, 
								 CREATED, 
								 LAST_ALTERED 
						  FROM '+@NOMBRE+'.information_schema.routines'') ';
	

			SET @SQLVW = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.141], ''SELECT TABLE_NAME FROM '+@NOMBRE+'.information_schema.views'')';

			INSERT INTO #TABLAS
			EXEC(@SQLTB);

			INSERT INTO #PROCEDIMIENTOS
			EXEC(@SQLSP);

			INSERT INTO #VISTAS
			EXEC(@SQLVW);

			DELETE FROM #BASES2 WHERE nombre = @NOMBRE
			SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
		END

		MERGE [bas_tablas] T USING #TABLAS TMP 
		ON (T.base = TMP.BASE AND T.objeto = TMP.ID)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, objeto, nombre, descripcion, fechaCreacion, fechaModificacion, fechaProceso)
			VALUES (TMP.BASE, TMP.ID, TMP.nombre, '', TMP.CREACION, TMP.MODIFICACION, GETDATE());	

		MERGE [bas_procedimientos] T USING #PROCEDIMIENTOS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, definicion, fechaCreacion, fechaModificacion, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, TMP.RUTINA, TMP.CREACION, TMP.MODIFICACION, '', GETDATE());	

		MERGE [dbo].[bas_vistas] T USING #VISTAS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, consulta, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, 'DESCONOCIDA', '', GETDATE());

		-- ELIMINA TODAS LAS TABLAS TEMPORALES CREADAS 

		DROP TABLE #BASES
		DROP TABLE #BASES2
		DROP TABLE #TABLAS
		DROP TABLE #PROCEDIMIENTOS
		DROP TABLE #VISTAS

	END;


END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_VM250DB01]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_VM250DB01]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'VM250DB01');

	IF(@IDSERVIDOR > 0) 
	BEGIN

		-- DECLARA LAS VARIABLES NECESARIAS

		DECLARE @CONTADOR INT;
		DECLARE @IDBASE NVARCHAR(50);
		DECLARE @NOMBRE NVARCHAR(100);
		DECLARE @SQLTB NVARCHAR(MAX);
		DECLARE @SQLSP NVARCHAR(MAX);
		DECLARE @SQLVW NVARCHAR(MAX);

		select idBase, @IDSERVIDOR desarrollo, nombre, fechaCreacion, collation
		into #BASES
		from openquery([192.168.250.142], 'SELECT ''250142''+RIGHT(''0000'' + CAST(database_id AS NVARCHAR), 5) idBase, 
													   name nombre, 
													   create_date fechaCreacion, 
													   collation_name collation 
											   FROM sys.databases 
											   WHERE name not in (''master'', ''tempdb'', ''model'', ''msdb'')')
		
		MERGE [bas_bases] T USING #BASES TMP 
		ON (T.id = TMP.idBase)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (id, produccion, test, desarrollo, nombre, fechaCreacion, collation, rti, estado, fechaProceso)
			VALUES (TMP.idBase, NULL, NULL, TMP.desarrollo, TMP.nombre, TMP.fechaCreacion, TMP.collation, NULL, NULL, GETDATE());

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS TABLAS DE LAS BASES

		CREATE TABLE #TABLAS (BASE NVARCHAR(100),
							  ID NVARCHAR(20),
							  NOMBRE NVARCHAR(500),
							  CREACION SMALLDATETIME,
							  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNO DE LOS PROCEDIMIENTOS ALMACENADOS DE LAS BASES

		CREATE TABLE #PROCEDIMIENTOS (BASE NVARCHAR(100),
									  NOMBRE NVARCHAR(100),
									  RUTINA NVARCHAR(MAX),
									  CREACION SMALLDATETIME,
									  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS VISTAS DE LAS BASES

		CREATE TABLE #VISTAS (BASE NVARCHAR(100), 
							  NOMBRE NVARCHAR(300))

		-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

		SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

		SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

		-- RECORRE EL WHILE PARA CADA UNA D LAS BASES DE DATOS CORRESPONDIENTES AL SERVIDOR

		WHILE @CONTADOR > 1
		BEGIN

			SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
			SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
			SET @SQLTB = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.142], ''SELECT object_id, 
																	  name, 
																	  create_date, 
																	  modify_date 
															   FROM '+@NOMBRE+'.sys.tables '') ';
			SET @SQLSP = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.142], ''SELECT ROUTINE_NAME, 
								 ROUTINE_DEFINITION, 
								 CREATED, 
								 LAST_ALTERED 
						  FROM '+@NOMBRE+'.information_schema.routines'') ';
	

			SET @SQLVW = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.142], ''SELECT TABLE_NAME FROM '+@NOMBRE+'.information_schema.views'')';

			INSERT INTO #TABLAS
			EXEC(@SQLTB);

			INSERT INTO #PROCEDIMIENTOS
			EXEC(@SQLSP);

			INSERT INTO #VISTAS
			EXEC(@SQLVW);

			DELETE FROM #BASES2 WHERE nombre = @NOMBRE
			SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
		END

		MERGE [bas_tablas] T USING #TABLAS TMP 
		ON (T.base = TMP.BASE AND T.objeto = TMP.ID)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, objeto, nombre, descripcion, fechaCreacion, fechaModificacion, fechaProceso)
			VALUES (TMP.BASE, TMP.ID, TMP.nombre, '', TMP.CREACION, TMP.MODIFICACION, GETDATE());	

		MERGE [bas_procedimientos] T USING #PROCEDIMIENTOS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, definicion, fechaCreacion, fechaModificacion, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, TMP.RUTINA, TMP.CREACION, TMP.MODIFICACION, '', GETDATE());	

		MERGE [dbo].[bas_vistas] T USING #VISTAS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, consulta, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, 'DESCONOCIDA', '', GETDATE());

		-- ELIMINA TODAS LAS TABLAS TEMPORALES CREADAS 

		DROP TABLE #BASES
		DROP TABLE #BASES2
		DROP TABLE #TABLAS
		DROP TABLE #PROCEDIMIENTOS
		DROP TABLE #VISTAS

	END;

END

GO
/****** Object:  StoredProcedure [dbo].[CARGA_VM250DB02]    Script Date: 15/11/2019 15:44:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_VM250DB02]
AS
BEGIN
	
	DECLARE @IDSERVIDOR BIGINT;

	SET @IDSERVIDOR = 0;
	SET @IDSERVIDOR = (SELECT id FROM [dbo].[srv_servidores] WHERE nombre = 'VM250DB02');

	IF(@IDSERVIDOR > 0) 
	BEGIN

		-- DECLARA LAS VARIABLES NECESARIAS

		DECLARE @CONTADOR INT;
		DECLARE @IDBASE NVARCHAR(50);
		DECLARE @NOMBRE NVARCHAR(100);
		DECLARE @SQLTB NVARCHAR(MAX);
		DECLARE @SQLSP NVARCHAR(MAX);
		DECLARE @SQLVW NVARCHAR(MAX);
		
		select idBase, @IDSERVIDOR desarrollo, nombre, fechaCreacion, collation
		into #BASES
		from openquery([192.168.250.154], 'SELECT ''250154''+RIGHT(''0000'' + CAST(database_id AS NVARCHAR), 5) idBase, 
													   name nombre, 
													   create_date fechaCreacion, 
													   collation_name collation 
											   FROM sys.databases 
											   WHERE name not in (''master'', ''tempdb'', ''model'', ''msdb'')')
		
		MERGE [bas_bases] T USING #BASES TMP 
		ON (T.id = TMP.idBase)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (id, produccion, test, desarrollo, nombre, fechaCreacion, collation, rti, estado, fechaProceso)
			VALUES (TMP.idBase, NULL, NULL, TMP.desarrollo, TMP.nombre, TMP.fechaCreacion, TMP.collation, NULL, NULL, GETDATE());	

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS TABLAS DE LAS BASES

		CREATE TABLE #TABLAS (BASE NVARCHAR(100),
							  ID NVARCHAR(20),
							  NOMBRE NVARCHAR(500),
							  CREACION SMALLDATETIME,
							  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNO DE LOS PROCEDIMIENTOS ALMACENADOS DE LAS BASES

		CREATE TABLE #PROCEDIMIENTOS (BASE NVARCHAR(100),
									  NOMBRE NVARCHAR(100),
									  RUTINA NVARCHAR(MAX),
									  CREACION SMALLDATETIME,
									  MODIFICACION SMALLDATETIME)

		-- CREA LA TABLA TEMPORAL QUE CONTIENE CADA UNA DE LAS VISTAS DE LAS BASES

		CREATE TABLE #VISTAS (BASE NVARCHAR(100), 
							  NOMBRE NVARCHAR(300))

		-- DEFINE EL CONTADOR COMO LA CANTIDAD DE BASES EN ELSERVIDOR

		SET @CONTADOR = (SELECT COUNT(*) FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR);

		SELECT id, nombre into #BASES2 FROM [dbo].[bas_bases] WHERE desarrollo = @IDSERVIDOR ORDER BY nombre ASC

		-- RECORRE EL WHILE PARA CADA UNA D LAS BASES DE DATOS CORRESPONDIENTES AL SERVIDOR

		WHILE @CONTADOR > 1
		BEGIN

			SET @NOMBRE = (SELECT TOP(1) nombre FROM #BASES2);
			SET @IDBASE = (SELECT TOP(1) id FROM #BASES2);
			SET @SQLTB = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.154], ''SELECT object_id, 
																	  name, 
																	  create_date, 
																	  modify_date 
															   FROM '+@NOMBRE+'.sys.tables '') ';
			SET @SQLSP = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.154], ''SELECT ROUTINE_NAME, 
								 ROUTINE_DEFINITION, 
								 CREATED, 
								 LAST_ALTERED 
						  FROM '+@NOMBRE+'.information_schema.routines'') ';
	

			SET @SQLVW = 'SELECT '+@IDBASE+', * 
						  FROM OPENQUERY ([192.168.250.154], ''SELECT TABLE_NAME FROM '+@NOMBRE+'.information_schema.views'')';

			INSERT INTO #TABLAS
			EXEC(@SQLTB);

			IF(@NOMBRE <> 'ProBatch')
			BEGIN
				INSERT INTO #PROCEDIMIENTOS
				EXEC(@SQLSP);

				INSERT INTO #VISTAS
				EXEC(@SQLVW);
			END

			DELETE FROM #BASES2 WHERE nombre = @NOMBRE
			SET @CONTADOR = (SELECT COUNT(*) FROM #BASES2);	
		END

		MERGE [bas_tablas] T USING #TABLAS TMP 
		ON (T.base = TMP.BASE AND T.objeto = TMP.ID)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, objeto, nombre, descripcion, fechaCreacion, fechaModificacion, fechaProceso)
			VALUES (TMP.BASE, TMP.ID, TMP.nombre, '', TMP.CREACION, TMP.MODIFICACION, GETDATE());	

		
		--SELECT * FROM #PROCEDIMIENTOS

		MERGE [bas_procedimientos] T USING #PROCEDIMIENTOS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaModificacion = TMP.MODIFICACION,
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, definicion, fechaCreacion, fechaModificacion, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, TMP.RUTINA, TMP.CREACION, TMP.MODIFICACION, '', GETDATE());	

		--SELECT * FROM #VISTAS

		MERGE [dbo].[bas_vistas] T USING #VISTAS TMP 
		ON (T.base = TMP.BASE AND T.nombre = TMP.NOMBRE)
		WHEN MATCHED 
			THEN UPDATE SET 
				T.fechaProceso = getdate()
		WHEN NOT MATCHED BY TARGET 
			THEN INSERT (base, nombre, consulta, descripcion, fechaProceso)
			VALUES (TMP.BASE, TMP.NOMBRE, 'DESCONOCIDA', '', GETDATE());

		-- ELIMINA TODAS LAS TABLAS TEMPORALES CREADAS 

		DROP TABLE #BASES
		DROP TABLE #BASES2
		DROP TABLE #TABLAS
		DROP TABLE #PROCEDIMIENTOS
		DROP TABLE #VISTAS

	END;

END

GO
USE [master]
GO
ALTER DATABASE [CAP_BSC] SET  READ_WRITE 
GO
