USE [master]
GO
/****** Object:  Database [CAP]    Script Date: 10/1/2020 16:39:24 ******/
CREATE DATABASE [CAP]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'CAP', FILENAME = N'D:\Bases_SQL\CAP.mdf' , SIZE = 5120KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'CAP_log', FILENAME = N'E:\Log_SQL\CAP_log.ldf' , SIZE = 3392KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [CAP] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [CAP].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [CAP] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [CAP] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [CAP] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [CAP] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [CAP] SET ARITHABORT OFF 
GO
ALTER DATABASE [CAP] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [CAP] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [CAP] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [CAP] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [CAP] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [CAP] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [CAP] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [CAP] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [CAP] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [CAP] SET  DISABLE_BROKER 
GO
ALTER DATABASE [CAP] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [CAP] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [CAP] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [CAP] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [CAP] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [CAP] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [CAP] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [CAP] SET RECOVERY FULL 
GO
ALTER DATABASE [CAP] SET  MULTI_USER 
GO
ALTER DATABASE [CAP] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [CAP] SET DB_CHAINING OFF 
GO
ALTER DATABASE [CAP] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [CAP] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [CAP] SET DELAYED_DURABILITY = DISABLED 
GO
USE [CAP]
GO
/****** Object:  Table [dbo].[apl_aplicacion]    Script Date: 10/1/2020 16:39:24 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[apl_aplicacion](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[tipo] [nvarchar](20) NOT NULL,
	[seguridad] [nvarchar](50) NOT NULL,
	[proveedor] [bigint] NULL,
	[lenguaje] [bigint] NOT NULL,
	[base] [nvarchar](50) NULL,
	[gerencia] [bigint] NULL,
	[empleado] [nvarchar](10) NULL,
	[servidorProduccion] [nvarchar](15) NOT NULL,
	[servidorTest] [nvarchar](15) NULL,
	[servidorDesarrollo] [nvarchar](15) NOT NULL,
	[puertoProduccion] [bigint] NULL,
	[puertoTest] [bigint] NULL,
	[puertoDesarrollo] [bigint] NOT NULL,
	[confidencialidad] [int] NULL,
	[integridad] [int] NULL,
	[disponibilidad] [int] NULL,
	[criticidad] [int] NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_apl_aplicacion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[aux_auxiliar]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[aux_auxiliar](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[cantidad] [int] NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[empleado] [nvarchar](10) NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_aux_auxiliar] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_aux_auxiliar] UNIQUE NONCLUSTERED 
(
	[sigla] ASC,
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_base]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_base](
	[id] [nvarchar](50) NOT NULL,
	[nombre] [nchar](10) NOT NULL,
	[collation] [nchar](10) NOT NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[produccion] [nvarchar](15) NULL,
	[test] [nvarchar](15) NULL,
	[desarrollo] [nvarchar](15) NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_bas_base] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_columna]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_columna](
	[id] [bigint] NOT NULL,
	[tabla] [bigint] NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[nulos] [nvarchar](5) NOT NULL,
	[tipo] [nvarchar](50) NOT NULL,
	[maximo] [int] NULL,
	[descripcion] [nvarchar](200) NOT NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_bas_columna] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_procedimiento]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_procedimiento](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NULL,
	[nombre] [nvarchar](150) NULL,
	[rutina] [text] NULL,
	[fechaCreacion] [smalldatetime] NULL,
	[fechaEdicion] [smalldatetime] NULL,
	[descripcion] [nvarchar](50) NULL,
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_bas_procedimiento] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_tabla]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_tabla](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[fechaEdicion] [smalldatetime] NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_bas_tabla] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_vista]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_vista](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[tipoConsulta] [nvarchar](15) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_bas_vista] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[com_comunicacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[com_comunicacion](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[cantidad] [int] NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[empleado] [nvarchar](10) NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[proveedor] [bigint] NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_com_comunicacion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_com_comunicacion] UNIQUE NONCLUSTERED 
(
	[sigla] ASC,
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fir_firewall]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fir_firewall](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[marca] [nvarchar](50) NOT NULL,
	[modelo] [nvarchar](50) NOT NULL,
	[numeroSerie] [nvarchar](50) NOT NULL,
	[version] [nvarchar](50) NOT NULL,
	[ip] [nvarchar](15) NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_fir_firewall] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ger_departamento]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ger_departamento](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_ger_departamento] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_ger_departamento] UNIQUE NONCLUSTERED 
(
	[nombre] ASC,
	[gerencia] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ger_empleado]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ger_empleado](
	[id] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[departamento] [bigint] NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_ger_empleado] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ger_gerencia]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ger_gerencia](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[empleado] [nvarchar](10) NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_ger_gerencia] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_ger_gerencia] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[har_hardware]    Script Date: 10/1/2020 16:39:25 ******/
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
	[softwareBase] [nvarchar](50) NOT NULL,
	[ambiente] [nvarchar](20) NOT NULL,
	[funcion] [nvarchar](50) NOT NULL,
	[sitio] [nchar](10) NOT NULL,
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
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_har_hardware] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[her_herramienta]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[her_herramienta](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[version] [nvarchar](20) NOT NULL,
	[fabricante] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](100) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_her_herramienta] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_her_herramienta] UNIQUE NONCLUSTERED 
(
	[nombre] ASC,
	[version] ASC,
	[fabricante] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ins_instalacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ins_instalacion](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[gerencia] [bigint] NULL,
	[empleado] [nvarchar](10) NULL,
	[sitio] [nvarchar](10) NULL,
	[plataforma] [bigint] NULL,
	[rti] [nvarchar](5) NULL,
	[descripcion] [nvarchar](300) NULL,
	[estado] [nvarchar](20) NULL,
 CONSTRAINT [PK_ins_instalacion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_ins_instalacion] UNIQUE NONCLUSTERED 
(
	[sigla] ASC,
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_comunicacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_comunicacion](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[cantidad] [int] NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[empleado] [nvarchar](10) NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[proveedor] [bigint] NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_firewall]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_firewall](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[marca] [nvarchar](50) NOT NULL,
	[modelo] [nvarchar](50) NOT NULL,
	[numeroSerie] [nvarchar](50) NOT NULL,
	[version] [nvarchar](50) NOT NULL,
	[ip] [nvarchar](15) NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[estado] [nvarchar](20) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_instalacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_instalacion](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[gerencia] [bigint] NOT NULL,
	[empleado] [nvarchar](10) NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[plataforma] [bigint] NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[descripcion] [nvarchar](300) NOT NULL,
	[estado] [nvarchar](20) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_inventario]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_inventario](
	[id] [bigint] NOT NULL,
	[descripcion] [nvarchar](3000) NOT NULL,
 CONSTRAINT [PK_inv_inventario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_switch]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_switch](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[modelo] [nvarchar](50) NOT NULL,
	[version] [nvarchar](50) NOT NULL,
	[instalacion] [bigint] NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[len_lenguaje]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[len_lenguaje](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[version] [nvarchar](20) NOT NULL,
	[descripcion] [nvarchar](100) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_len_lenguaje] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[log_actividad]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[log_actividad](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[legajo] [nvarchar](10) NOT NULL,
	[tabla] [nvarchar](50) NOT NULL,
	[operacion] [nvarchar](50) NOT NULL,
	[registro] [nvarchar](50) NOT NULL,
	[fecha] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_log_actividad] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pla_plataformaSO]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pla_plataformaSO](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_pla_plataformaSO] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_pla_plataformaSO] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pro_proveedor]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pro_proveedor](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[telefono] [nvarchar](20) NULL,
	[correo] [nvarchar](50) NULL,
	[provincia] [nvarchar](50) NOT NULL,
	[ciudad] [nvarchar](50) NOT NULL,
	[direccion] [nvarchar](50) NOT NULL,
	[tipo] [nvarchar](20) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_pro_proveedor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pro_proveedor_servicio]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pro_proveedor_servicio](
	[idProveedor] [bigint] NULL,
	[idServicio] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pro_responsable]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pro_responsable](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[telefono] [nvarchar](20) NULL,
	[correo] [nvarchar](50) NULL,
	[proveedor] [bigint] NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_pro_responsable] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[psa_lugar]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[psa_lugar](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_psa_lugar] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_psa_lugar] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[psa_modo]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[psa_modo](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_psa_modo] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_psa_modo] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_perfil]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfil](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](300) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_seg_perfil] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_seg_perfil] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_perfil_permiso]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfil_permiso](
	[idPerfil] [bigint] NOT NULL,
	[idPermiso] [bigint] NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_permiso]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_permiso](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[titulo] [nvarchar](20) NOT NULL,
	[nivel] [int] NOT NULL,
	[padre] [int] NOT NULL,
	[link] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_seg_permiso] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_seg_permiso] UNIQUE NONCLUSTERED 
(
	[titulo] ASC,
	[nivel] ASC,
	[padre] ASC,
	[link] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_usuario]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_usuario](
	[id] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](150) NOT NULL,
	[perfil] [bigint] NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_seg_usuario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ser_job]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ser_job](
	[id] [nvarchar](100) NOT NULL,
	[servidor] [nvarchar](15) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[categoria] [nvarchar](50) NOT NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[fechaEdicion] [smalldatetime] NOT NULL,
	[version] [int] NOT NULL,
	[pasos] [int] NOT NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_ser_job] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ser_servidor]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ser_servidor](
	[id] [nvarchar](15) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[ambiente] [nvarchar](20) NOT NULL,
	[tipo] [nvarchar](20) NOT NULL,
	[descripcion] [nvarchar](500) NULL,
	[sp] [int] NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_ser_servidor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ser_vinculado]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ser_vinculado](
	[id] [nvarchar](10) NOT NULL,
	[servidor] [nvarchar](15) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[producto] [nvarchar](50) NOT NULL,
	[proveedor] [nvarchar](50) NOT NULL,
	[origen] [nvarchar](50) NOT NULL,
	[fechaEdicion] [smalldatetime] NOT NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_ser_vinculado] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[sit_sitio]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sit_sitio](
	[id] [nvarchar](10) NOT NULL,
	[tipo] [nvarchar](10) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[provincia] [nvarchar](50) NOT NULL,
	[ciudad] [nvarchar](50) NOT NULL,
	[codigoPostal] [bigint] NOT NULL,
	[direccion] [nvarchar](50) NOT NULL,
	[origen] [nvarchar](15) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_sit_sitio] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[srv_servicio]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[srv_servicio](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_srv_servicio] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[swi_switch]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[swi_switch](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[modelo] [nvarchar](50) NOT NULL,
	[version] [nvarchar](50) NOT NULL,
	[instalacion] [bigint] NOT NULL,
	[sitio] [nvarchar](10) NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_swi_switch] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_swi_switch] UNIQUE NONCLUSTERED 
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  View [dbo].[vwaux_auxiliar]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[vwaux_auxiliar]
as
select 
aux.id aid,
aux.sigla asigla,
aux.nombre anombre,
aux.cantidad acantidad,
ger.id gid,
ger.nombre gnombre,
ger.estado gestado,
emp.id eid,
emp.nombre enombre,
emp.estado eestado,
sit.id sid,
sit.nombre snombre,
sit.estado sestado,
aux.descripcion adescripcion,
aux.rti arti,
aux.estado aestado
from [dbo].[aux_auxiliar] aux
inner join dbo.ger_gerencia ger on ger.id = aux.gerencia
inner join dbo.ger_empleado emp on emp.id = aux.empleado
inner join dbo.sit_sitio sit on sit.id = aux.sitio

GO
/****** Object:  View [dbo].[vwcom_comunicacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create view [dbo].[vwcom_comunicacion]
as
select 
com.id cid,
com.sigla csigla,
com.nombre cnombre,
com.cantidad ccantidad,
ger.id gid,
ger.nombre gnombre,
ger.estado gestado,
emp.id eid,
emp.nombre enombre,
emp.estado eestado,
sit.id sid,
sit.nombre snombre,
sit.estado sestado,
pro.id pid,
pro.nombre pnombre,
pro.estado pestado,
com.descripcion cdescripcion,
com.rti crti,
com.estado cestado
from [dbo].[com_comunicacion] com
inner join dbo.ger_gerencia ger on ger.id = com.gerencia
inner join dbo.ger_empleado emp on emp.id = com.empleado
inner join dbo.sit_sitio sit on sit.id = com.sitio
inner join dbo.pro_proveedor pro on pro.id = com.proveedor
GO
/****** Object:  View [dbo].[vwfir_firewall]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwfir_firewall]
as
select 
fir.id fid,
fir.nombre fnombre,
fir.marca fmarca,
fir.modelo fmodelo,
fir.numeroSerie fnumeroSerie,
fir.version fversion,
fir.ip fip,
sit.id sid,
sit.nombre snombre,
sit.estado sestado,
fir.estado festado
from cap.[dbo].[fir_firewall] fir
inner join  cap.[dbo].sit_sitio sit on sit.id = fir.sitio
GO
/****** Object:  View [dbo].[vwger_departamento]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwger_departamento]
as
select 
dep.id did,
dep.nombre dnombre,
ger.id gid,
ger.nombre gnombre,
ger.empleado gempleado,
ger.estado gestado,
dep.estado destado
from dbo.ger_departamento dep
inner join dbo.ger_gerencia ger ON ger.id = dep.gerencia
GO
/****** Object:  View [dbo].[vwger_empleado]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vwger_empleado]
as
select 
emp.id eid,
emp.nombre enombre,
dep.id did,
dep.nombre dnombre,
dep.estado destado,
emp.estado eestado,
(CASE WHEN ger.id IS NULL THEN 'No' ELSE 'Si' END) gerente 
from [dbo].[ger_empleado] emp
left join dbo.ger_departamento dep on dep.id = emp.departamento
left join dbo.ger_gerencia ger on ger.empleado = emp.id

GO
/****** Object:  View [dbo].[vwger_gerencia]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwger_gerencia]
as
select  
ger.id gid,
ger.nombre gnombre,
emp.id eid,
emp.nombre enombre,
emp.estado eestado,
ger.estado gestado
from dbo.ger_gerencia ger
left join ger_empleado emp on ger.empleado = emp.id
GO
/****** Object:  View [dbo].[vwhar_hardware]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


create view [dbo].[vwhar_hardware]
as
select 
har.id hid,
har.tipo htipo,
har.sigla hsigla,
har.nombre hnombre,
har.dominio hdominio,
har.softwareBase hsoftwareBase,
har.ambiente hambiente,
har.funcion hfuncion,
sit.id sid,
sit.nombre snombre,
sit.estado sestado,
har.marca hmarca,
har.modelo hmodelo,
har.arquitectura harquitectura,
har.core hcore,
har.procesador hprocesador,
har.mhz hmhz,
har.memoria hmemoria,
har.disco hdisco,
har.raid hraid,
har.red hred,
har.rti hrti,
har.estado hestado
from cap.[dbo].[har_hardware] har
inner join cap.dbo.sit_sitio sit on sit.id = har.sitio
GO
/****** Object:  View [dbo].[vwins_instalacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vwins_instalacion]
as
SELECT 
ins.id iid,
ins.sigla isigla,
ins.nombre inombre,
ger.id gid,
ger.nombre gnombre,
ger.estado gestado,
emp.id eid,
emp.nombre enombre,
emp.estado eestado,
sit.id sid,
sit.nombre snombre,
sit.estado sestado,
pla.id pid,
pla.nombre pnombre,
pla.estado pestado,
ins.rti irti,
ins.descripcion idescripcion, 
ins.estado iestado
FROM cap.[dbo].[ins_instalacion] ins
inner join cap.dbo.ger_gerencia ger on ger.id = ins.gerencia
inner join cap.dbo.ger_empleado emp on emp.id = ins.empleado
inner join cap.dbo.sit_sitio sit on sit.id = ins.sitio
inner join cap.dbo.pla_plataformaSO pla on pla.id = ins.plataforma
GO
/****** Object:  View [dbo].[vwinv_comunicacion]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO




CREATE view [dbo].[vwinv_comunicacion]
as
select 
com.inventario,
com.id cid,
com.sigla csigla,
com.nombre cnombre,
com.cantidad ccantidad,
ger.id gid,
ger.nombre gnombre,
jef.id jid,
jef.nombre jnombre,
emp.id eid,
emp.nombre enombre,
sit.id sid,
sit.tipo stipo,
sit.nombre snombre,
sit.provincia sprovincia,
sit.ciudad sciudad,
sit.codigoPostal scodigoPostal,
sit.direccion sdireccion,
sit.origen sorigen,
pro.id pid,
pro.nombre pnombre,
pro.telefono ptelefono,
pro.correo pcorreo,
pro.provincia pprovincia,
pro.ciudad pciudad,
pro.direccion pdireccion,
pro.tipo ptipo,
com.descripcion cdescripcion,
com.rti crti,
com.estado cestado
from [dbo].[inv_comunicacion] com
inner join dbo.ger_gerencia ger on ger.id = com.gerencia
left join dbo.ger_empleado jef on jef.id = ger.empleado
inner join dbo.ger_empleado emp on emp.id = com.empleado
inner join dbo.sit_sitio sit on sit.id = com.sitio
inner join dbo.pro_proveedor pro on pro.id = com.proveedor



GO
/****** Object:  View [dbo].[vwinv_firewall]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwinv_firewall]
as
select 
fir.inventario,
fir.id fid,
fir.nombre fnombre,
fir.marca fmarca,
fir.modelo fmodelo,
fir.numeroSerie fnumeroSerie,
fir.version fversion,
fir.ip fip,
sit.id sid,
sit.nombre snombre,
sit.provincia sprovincia,
sit.ciudad sciudad,
sit.codigoPostal scodigoPostal,
sit.direccion sdireccion,
sit.origen sorigen,
sit.estado sestado,
fir.estado festado
from cap.[dbo].[inv_firewall] fir
inner join  cap.[dbo].sit_sitio sit on sit.id = fir.sitio
GO
/****** Object:  View [dbo].[vwinv_switch]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwinv_switch]
as
select 
swi.inventario,
swi.id sid,
swi.nombre snombre,
swi.modelo smodelo,
swi.version sversion,
ins.id iid,
ins.sigla isigla,
ins.nombre inombre,
sit.id uid,
sit.tipo utipo,
sit.nombre unombre,
sit.provincia uprovincia,
sit.ciudad uciudad,
sit.codigoPostal ucodigoPostal,
sit.direccion udireccion,
sit.origen uorigen,
swi.rti srti,
swi.estado sestado
from [dbo].[inv_switch] swi
inner join dbo.ins_instalacion ins on ins.id = swi.instalacion
inner join dbo.sit_sitio sit on sit.id = swi.sitio
GO
/****** Object:  View [dbo].[vwpro_responsable]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwpro_responsable]
as
SELECT 
res.id rid,
res.nombre rnombre,
res.telefono rtelefono,
res.correo rcorreo,
pro.id pid,
pro.nombre pnombre,
pro.estado pestado,
res.estado restado 
FROM [dbo].[pro_responsable] res
INNER JOIN dbo.pro_proveedor pro on pro.id = res.proveedor
GO
/****** Object:  View [dbo].[vwseg_perfil]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[vwseg_perfil]
as
  select per.id,
	per.nombre,
	per.descripcion,
	per.estado,
	(CASE WHEN usu.usuarios IS NULL THEN 0 ELSE usu.usuarios END) usuarios 
  from [CAP].[dbo].[seg_perfil] per
  left join (select perfil, count(*) usuarios 
			 from [CAP].[dbo].[seg_usuario] 
			 group by perfil) usu on usu.perfil = per.id


GO
/****** Object:  View [dbo].[vwseg_permiso]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE view [dbo].[vwseg_permiso]
as
 select id, 
		titulo, 'Menu' nivel, 
		'' padre, 
		link, 
		(CASE WHEN rol.roles IS NOT NULL THEN rol.roles ELSE 0 END) perfiles,
		(CASE WHEN hij.hijos IS NOT NULL THEN hij.hijos ELSE 0 END) hijos
  from [CAP].[dbo].[seg_permiso] 
  left join (SELECT idPermiso, COUNT(*) roles FROM [dbo].[seg_perfil_permiso] GROUP BY idPermiso) rol on rol.idPermiso = id
  left join (SELECT padre, COUNT(*) hijos FROM [CAP].[dbo].[seg_permiso] GROUP BY padre) hij ON hij.padre = id
  where nivel = 1
  UNION ALL
  select SUB.id, 
	     SUB.titulo, 
		 'Sub-menu' nivel, 
		 MEN.titulo padre, 
		 SUB.link, 
		 (CASE WHEN rol.roles IS NOT NULL THEN rol.roles ELSE 0 END) perfiles,
		 0 hijos
  from [CAP].[dbo].[seg_permiso] SUB
  LEFT JOIN [CAP].[dbo].[seg_permiso] MEN on MEN.id = SUB.padre
  left join (SELECT idPermiso, COUNT(*) roles FROM [dbo].[seg_perfil_permiso] GROUP BY idPermiso) rol on rol.idPermiso = SUB.id
  where SUB.nivel = 2



GO
/****** Object:  View [dbo].[vwseg_usuario]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwseg_usuario]
as
select usu.id usuId,
	usu.nombre usuNombre,
	usu.estado usuEstado,
	per.id perId,
	per.nombre perNombre,
	per.descripcion perDescripcion,
	per.estado perEstado
from [CAP].[dbo].[seg_usuario] usu
inner join [CAP].[dbo].[seg_perfil] per on per.id = usu.perfil 
GO
/****** Object:  View [dbo].[vwswi_switch]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwswi_switch]
as
select 
swi.id sid,
swi.nombre snombre,
swi.modelo smodelo,
swi.version sversion,
ins.id iid,
ins.nombre inombre,
ins.estado iestado,
sit.id uid,
sit.nombre unombre,
sit.estado uestado,
swi.rti srti,
swi.estado sestado
from [dbo].[swi_switch] swi
inner join dbo.ins_instalacion ins on ins.id = swi.instalacion
inner join dbo.sit_sitio sit on sit.id = swi.sitio
GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [IX_fir_firewall]    Script Date: 10/1/2020 16:39:25 ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_fir_firewall] ON [dbo].[fir_firewall]
(
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [IX_srv_servicio]    Script Date: 10/1/2020 16:39:25 ******/
CREATE NONCLUSTERED INDEX [IX_srv_servicio] ON [dbo].[srv_servicio]
(
	[sigla] ASC,
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_bas_base] FOREIGN KEY([base])
REFERENCES [dbo].[bas_base] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_bas_base]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_ger_empleado] FOREIGN KEY([empleado])
REFERENCES [dbo].[ger_empleado] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_ger_empleado]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_ger_gerencia] FOREIGN KEY([gerencia])
REFERENCES [dbo].[ger_gerencia] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_ger_gerencia]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_len_lenguaje] FOREIGN KEY([lenguaje])
REFERENCES [dbo].[len_lenguaje] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_len_lenguaje]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_pro_proveedor] FOREIGN KEY([proveedor])
REFERENCES [dbo].[pro_proveedor] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_pro_proveedor]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_ser_servidor] FOREIGN KEY([servidorProduccion])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_ser_servidor]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_ser_servidor1] FOREIGN KEY([servidorTest])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_ser_servidor1]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_ser_servidor2] FOREIGN KEY([servidorDesarrollo])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_ser_servidor2]
GO
ALTER TABLE [dbo].[pro_proveedor_servicio]  WITH CHECK ADD  CONSTRAINT [FK_pro_proveedor_servicio_pro_proveedor] FOREIGN KEY([idProveedor])
REFERENCES [dbo].[pro_proveedor] ([id])
GO
ALTER TABLE [dbo].[pro_proveedor_servicio] CHECK CONSTRAINT [FK_pro_proveedor_servicio_pro_proveedor]
GO
ALTER TABLE [dbo].[pro_proveedor_servicio]  WITH CHECK ADD  CONSTRAINT [FK_pro_proveedor_servicio_srv_servicio] FOREIGN KEY([idServicio])
REFERENCES [dbo].[srv_servicio] ([id])
GO
ALTER TABLE [dbo].[pro_proveedor_servicio] CHECK CONSTRAINT [FK_pro_proveedor_servicio_srv_servicio]
GO
ALTER TABLE [dbo].[seg_perfil_permiso]  WITH CHECK ADD  CONSTRAINT [FK_seg_perfil_permiso_seg_perfil] FOREIGN KEY([idPerfil])
REFERENCES [dbo].[seg_perfil] ([id])
GO
ALTER TABLE [dbo].[seg_perfil_permiso] CHECK CONSTRAINT [FK_seg_perfil_permiso_seg_perfil]
GO
ALTER TABLE [dbo].[seg_perfil_permiso]  WITH CHECK ADD  CONSTRAINT [FK_seg_perfil_permiso_seg_permiso] FOREIGN KEY([idPermiso])
REFERENCES [dbo].[seg_permiso] ([id])
GO
ALTER TABLE [dbo].[seg_perfil_permiso] CHECK CONSTRAINT [FK_seg_perfil_permiso_seg_permiso]
GO
/****** Object:  StoredProcedure [dbo].[CARGA_DATOS_SERVIDOR]    Script Date: 10/1/2020 16:39:25 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[CARGA_DATOS_SERVIDOR]
AS
BEGIN
	
	DECLARE @SQLJOB NVARCHAR(MAX);
	DECLARE @SQLVIN NVARCHAR(MAX);
	DECLARE @CONTADOR INT;
	DECLARE @IP NVARCHAR(20);
	DECLARE @REF NVARCHAR(10);

	CREATE TABLE #JOBS (ID NVARCHAR(100),
						SERVIDOR NVARCHAR(15),
						NOMBRE NVARCHAR(100),
						DESCRIPCION NVARCHAR(500),
						CATEGORIA NVARCHAR(50),
						CREACION SMALLDATETIME,
						EDICION SMALLDATETIME,
						NVERSION INT,
						PASOS INT)

	CREATE TABLE #VINCULADOS (ID NVARCHAR(50),
						SERVIDOR NVARCHAR(15),
						NOMBRE NVARCHAR(50),
						PRODUCTO NVARCHAR(50),
						PROVEEDOR NVARCHAR(50),
						ORIGEN NVARCHAR(50),
						EDICION SMALLDATETIME)

	select id, SUBSTRING(REPLACE(id, '.',''), 7, 6) ref 
	into #SERVIDORES
	from [CAP].[dbo].[ser_servidor]  where sp = 1 order by SUBSTRING(REPLACE(id, '.',''), 7, 6)

	SET @CONTADOR = (SELECT COUNT(*) FROM #SERVIDORES);

	WHILE @CONTADOR >= 1
	BEGIN
		SET @IP = (SELECT TOP(1) id FROM #SERVIDORES ORDER BY ref);
		SET @REF = (SELECT TOP(1) ref FROM #SERVIDORES ORDER BY ref);

		SET @SQLJOB = 'select * from openquery(['+@IP+'], '' select '''''+@REF+'''''+CAST(job.job_id AS NVARCHAR(MAX)) id,
				 '''''+@IP+''''' servidor,
				 job.name nombre,
				 job.description descripcion,
				 cat.name categoria,
				 job.date_created fechaCreacion,
				 job.date_modified fechaEdicion,
				 job.version_number version,
				 ste.pasos
		  from msdb.dbo.sysjobs job
		  inner join msdb.dbo.syscategories cat on job.category_id = cat.category_id
		  left join (select job_id, count(*) pasos from msdb.dbo.sysjobsteps steps group by job_id) ste ON ste.job_id = job.job_id 
		  where job.enabled = 1 and job.description NOT LIKE ''''%Source:%'''' AND job.name NOT IN (''''syspolicy_purge_history'''') '') ';

		  SET @SQLVIN = 'select * from openquery(['+@IP+'], '' select '''''+@REF+'''''+RIGHT(''''000'''' + CAST(server_id AS NVARCHAR), 3) id,
				   '''''+@IP+''''' servidor,
				   name nombre,
				   product producto,
				   provider proveedor,
				   data_source origen,
				   modify_date edicion
			from sys.Servers '')';

		INSERT INTO #JOBS (ID, SERVIDOR, NOMBRE, DESCRIPCION, CATEGORIA, CREACION, EDICION, NVERSION, PASOS)
		EXEC(@SQLJOB);

		INSERT INTO #VINCULADOS (ID, SERVIDOR, NOMBRE, PRODUCTO, PROVEEDOR, ORIGEN, EDICION)
		EXEC(@SQLVIN);

		DELETE FROM #SERVIDORES WHERE id = @IP
		SET @CONTADOR = (SELECT COUNT(*) FROM #SERVIDORES);	
	END

	MERGE [CAP].[dbo].[ser_job] T USING #JOBS TMP 
	ON (T.id = TMP.id AND T.servidor = TMP.SERVIDOR)
	WHEN MATCHED 
		THEN UPDATE SET 
			T.fechaEdicion = TMP.EDICION,
			T.pasos = TMP.PASOS,
			T.fechaProceso = getdate()
	WHEN NOT MATCHED BY TARGET 
		THEN INSERT ([id],[servidor],[nombre],[descripcion],[categoria],[fechaCreacion],[fechaEdicion],[version],[pasos],[fechaProceso])
		VALUES (TMP.ID, TMP.SERVIDOR, TMP.NOMBRE, TMP.DESCRIPCION, TMP.CATEGORIA, TMP.CREACION, TMP.EDICION, TMP.NVERSION, TMP.PASOS, GETDATE());

	MERGE [CAP].[dbo].[ser_vinculado] T USING #VINCULADOS TMP 
	ON (T.id = TMP.id AND t.servidor = TMP.SERVIDOR)
	WHEN MATCHED 
		THEN UPDATE SET 
			T.fechaEdicion = TMP.EDICION,
			T.fechaProceso = getdate()
	WHEN NOT MATCHED BY TARGET 
		THEN INSERT ([id],[servidor],[nombre],[producto],[proveedor],[origen],[fechaEdicion],[fechaProceso])
		VALUES (TMP.ID, TMP.SERVIDOR, TMP.NOMBRE, TMP.PRODUCTO, TMP.PROVEEDOR, TMP.ORIGEN, TMP.EDICION, GETDATE());

	DROP TABLE #JOBS
	DROP TABLE #VINCULADOS
	DROP TABLE #SERVIDORES

END

GO
USE [master]
GO
ALTER DATABASE [CAP] SET  READ_WRITE 
GO
