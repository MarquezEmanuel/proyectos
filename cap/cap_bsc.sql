USE [master]
GO
/****** Object:  Database [CAP]    Script Date: 27/12/2019 16:45:42 ******/
CREATE DATABASE [CAP]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'CAP', FILENAME = N'D:\Bases_SQL\CAP.mdf' , SIZE = 5120KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'CAP_log', FILENAME = N'E:\Log_SQL\CAP_log.ldf' , SIZE = 3072KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
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
/****** Object:  Table [dbo].[bas_base]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[bas_columna]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[bas_procedimiento]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[bas_tabla]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[bas_vista]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[ger_departamento]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[ger_empleado]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[ger_gerencia]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[her_herramienta]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[len_lenguaje]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[log_actividad]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[pla_plataformaSO]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[pro_proveedor]    Script Date: 27/12/2019 16:45:42 ******/
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
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_pro_proveedor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pro_responsable]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[psa_lugar]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[psa_modo]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[seg_perfil]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[seg_perfil_permiso]    Script Date: 27/12/2019 16:45:42 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfil_permiso](
	[idPerfil] [bigint] NOT NULL,
	[idPermiso] [bigint] NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_permiso]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[seg_usuario]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[ser_job]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[ser_servidor]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[ser_vinculado]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  Table [dbo].[sit_sitio]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  View [dbo].[vwger_departamento]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  View [dbo].[vwger_empleado]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  View [dbo].[vwger_gerencia]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  View [dbo].[vwseg_perfil]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  View [dbo].[vwseg_permiso]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  View [dbo].[vwseg_usuario]    Script Date: 27/12/2019 16:45:42 ******/
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
/****** Object:  StoredProcedure [dbo].[CARGA_DATOS_SERVIDOR]    Script Date: 27/12/2019 16:45:42 ******/
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
