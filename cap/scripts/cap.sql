USE [CAP]
GO
/****** Object:  Table [dbo].[apl_aplicacion]    Script Date: 23/3/2020 13:16:01 ******/
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
	[tecnologia] [nvarchar](50) NULL,
	[proveedor] [bigint] NULL,
	[lenguaje] [bigint] NULL,
	[herramienta] [bigint] NULL,
	[base] [nvarchar](50) NULL,
	[modoProcesamiento] [bigint] NOT NULL,
	[lugarProcesamiento] [bigint] NOT NULL,
	[plataforma] [bigint] NULL,
	[gerencia] [bigint] NULL,
	[empleado] [nvarchar](10) NULL,
	[servidorProduccion] [nvarchar](15) NULL,
	[servidorTest] [nvarchar](15) NULL,
	[servidorDesarrollo] [nvarchar](15) NULL,
	[puertoProduccion] [bigint] NULL,
	[puertoTest] [bigint] NULL,
	[puertoDesarrollo] [bigint] NULL,
	[confidencialidad] [int] NULL,
	[integridad] [int] NULL,
	[disponibilidad] [int] NULL,
	[criticidad] [int] NULL,
	[rti] [nvarchar](5) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_apl_aplicacion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[aux_auxiliar]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[bas_base]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_base](
	[id] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[motor] [nvarchar](250) NULL,
	[collation] [nvarchar](50) NOT NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[produccion] [nvarchar](15) NULL,
	[test] [nvarchar](15) NULL,
	[desarrollo] [nvarchar](15) NULL,
	[fechaProceso] [smalldatetime] NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_bas_base] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_columna]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_columna](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
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
/****** Object:  Table [dbo].[bas_procedimiento]    Script Date: 23/3/2020 13:16:01 ******/
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
	[descripcion] [nvarchar](500) NULL,
	[fechaProceso] [smalldatetime] NULL,
 CONSTRAINT [PK_bas_procedimiento] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[bas_tabla]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bas_tabla](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[base] [nvarchar](50) NOT NULL,
	[objeto] [nvarchar](50) NOT NULL,
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
/****** Object:  Table [dbo].[bas_vista]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[com_comunicacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[dep_activo_hijo]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_activo_hijo](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_dep_activo_hijo] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_dep_activo_hijo] UNIQUE NONCLUSTERED 
(
	[sigla] ASC,
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[dep_activo_padre]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_activo_padre](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[categoria] [nvarchar](20) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_dep_activo_padre] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_dep_activo_padre] UNIQUE NONCLUSTERED 
(
	[sigla] ASC,
	[nombre] ASC,
	[categoria] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[dep_dependencia]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[dep_dependencia](
	[idPadre] [bigint] NULL,
	[idHijo] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fir_firewall]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[ger_departamento]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[ger_empleado]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[ger_gerencia]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[har_hardware]    Script Date: 23/3/2020 13:16:01 ******/
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
	[sitio] [nvarchar](10) NOT NULL,
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
/****** Object:  Table [dbo].[her_herramienta]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[ins_instalacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[inv_aplicacion]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_aplicacion](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[tipo] [nvarchar](20) NULL,
	[seguridad] [nvarchar](50) NULL,
	[tecnologia] [nvarchar](50) NULL,
	[proveedor] [bigint] NULL,
	[lenguaje] [bigint] NULL,
	[herramienta] [bigint] NULL,
	[base] [nvarchar](50) NULL,
	[modoProcesamiento] [bigint] NULL,
	[lugarProcesamiento] [bigint] NULL,
	[plataforma] [bigint] NULL,
	[gerencia] [bigint] NULL,
	[empleado] [nvarchar](10) NULL,
	[servidorProduccion] [nvarchar](15) NULL,
	[servidorTest] [nvarchar](15) NULL,
	[servidorDesarrollo] [nvarchar](15) NULL,
	[puertoProduccion] [bigint] NULL,
	[puertoTest] [bigint] NULL,
	[puertoDesarrollo] [bigint] NULL,
	[confidencialidad] [int] NULL,
	[integridad] [int] NULL,
	[disponibilidad] [int] NULL,
	[criticidad] [int] NULL,
	[rti] [nvarchar](5) NULL,
	[descripcion] [nvarchar](500) NULL,
	[estado] [nvarchar](20) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_auxiliar]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_auxiliar](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[cantidad] [int] NULL,
	[gerencia] [bigint] NULL,
	[empleado] [nvarchar](10) NULL,
	[sitio] [nvarchar](10) NULL,
	[descripcion] [nvarchar](500) NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [nvarchar](20) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_comunicacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[inv_firewall]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[inv_hardware]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_hardware](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[tipo] [nvarchar](50) NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[dominio] [nvarchar](20) NULL,
	[softwareBase] [nvarchar](50) NULL,
	[ambiente] [nvarchar](20) NULL,
	[funcion] [nvarchar](50) NULL,
	[sitio] [nvarchar](10) NULL,
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
	[rti] [nvarchar](5) NULL,
	[estado] [nvarchar](20) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_instalacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[inv_inventario]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[inv_personal]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[inv_personal](
	[inventario] [bigint] NOT NULL,
	[id] [bigint] NOT NULL,
	[sigla] [nvarchar](20) NULL,
	[nombre] [nvarchar](50) NULL,
	[departamento] [bigint] NULL,
	[rti] [nvarchar](5) NULL,
	[estado] [nvarchar](20) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[inv_switch]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[len_lenguaje]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[log_actividad]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[per_personal]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[per_personal](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sigla] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[departamento] [bigint] NOT NULL,
	[rti] [nvarchar](5) NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_per_personal] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pla_plataformaSO]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[pro_proveedor]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[pro_proveedor_servicio]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pro_proveedor_servicio](
	[idProveedor] [bigint] NULL,
	[idServicio] [bigint] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[pro_responsable]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[psa_lugar]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[psa_modo]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[seg_perfil]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[seg_perfil_permiso]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[seg_perfil_permiso](
	[idPerfil] [bigint] NOT NULL,
	[idPermiso] [bigint] NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[seg_permiso]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[seg_usuario]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[ser_job]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[ser_servidor]    Script Date: 23/3/2020 13:16:01 ******/
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
	[spjob] [int] NOT NULL,
	[spbd] [int] NOT NULL,
	[estado] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_ser_servidor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[sit_sitio]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[srv_servicio]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  Table [dbo].[swi_switch]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwapl_aplicacion]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vwapl_aplicacion]
as
select 
apl.id aid,
apl.sigla asigla,
apl.nombre anombre,
apl.tipo atipo,
apl.seguridad aseguridad,
apl.tecnologia atecnologia,
pro.id pid,
pro.nombre pnombre,
pro.estado pestado,
lje.id lid,
lje.nombre lnombre,
lje.version lversion,
lje.estado lestado,
her.id hid,
her.nombre hnombre,
her.version hversion,
her.estado hestado,
bas.id bid,
bas.nombre bnombre, 
pmo.id mid,
pmo.nombre mnombre,
pmo.estado mestado,
plu.id uid,
plu.nombre unombre,
plu.estado uestado,
ger.id gid,
ger.nombre gnombre,
ger.estado gestado,
emp.id eid,
emp.nombre enombre,
emp.estado eestado,
spr.id sid,
spr.nombre snombre,
ste.id tid,
ste.nombre tnombre,
sde.id did,
sde.nombre dnombre,
apl.puertoProduccion apuertoProduccion,
apl.puertoTest apuertoTest,
apl.puertoDesarrollo apuertoDesarrollo,
apl.confidencialidad,
apl.integridad,
apl.disponibilidad,
apl.criticidad,
apl.rti arti,
apl.descripcion adescripcion,
apl.estado aestado
from cap.[dbo].apl_aplicacion apl
left join cap.dbo.pro_proveedor pro on pro.id = apl.proveedor
left join cap.dbo.len_lenguaje lje on lje.id = apl.lenguaje
left join cap.dbo.her_herramienta her on her.id = apl.herramienta
left join cap.dbo.bas_base bas on bas.id = apl.base
inner join cap.dbo.psa_modo pmo on pmo.id = apl.modoProcesamiento
inner join cap.dbo.psa_lugar plu on plu.id = apl.lugarProcesamiento
left join cap.dbo.ger_gerencia ger on ger.id  = apl.gerencia
left join cap.dbo.ger_empleado emp on emp.id = apl.empleado
left join cap.dbo.ser_servidor spr on spr.id = apl.servidorProduccion
left join cap.dbo.ser_servidor ste on ste.id = apl.servidorTest
left join cap.dbo.ser_servidor sde on sde.id = apl.servidorDesarrollo

GO
/****** Object:  View [dbo].[vwaux_auxiliar]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwbas_base]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


  CREATE view [dbo].[vwbas_base] as
  select 
  bas.id bid, 
  bas.nombre bnombre,
  bas.motor bmotor,
  bas.collation bcollation,
  bas.fechaCreacion bfechaCreacion,
  spr.id pid,
  spr.nombre pnombre,
  spr.tipo ptipo,
  ste.id tid,
  ste.nombre tnombre,
  ste.tipo ttipo,
  sde.id did,
  sde.nombre dnombre,
  sde.tipo dtipo,
  (CASE WHEN tab.tablas IS NULL THEN 0 ELSE tab.tablas END) btablas,
  (CASE WHEN vis.vistas IS NULL THEN 0 ELSE vis.vistas END) bvistas,
  (CASE WHEN pro.sps IS NULL THEN 0 ELSE pro.sps END) bprocedimientos,
  bas.fechaProceso bfechaProceso,
  bas.rti brti,
  bas.estado bestado
  from [CAP].[dbo].[bas_base] bas
  left join cap.dbo.ser_servidor spr on spr.id = bas.produccion
  left join cap.dbo.ser_servidor ste on ste.id = bas.test
  left join cap.dbo.ser_servidor sde on sde.id = bas.desarrollo
  left join (select base, count(id) tablas from [dbo].[bas_tabla] group by base) tab on tab.base = bas.id
  left join (select base, count(id) vistas from [dbo].[bas_vista] group by base) vis on vis.base = bas.id
  left join (select base, count(id) sps from [dbo].[bas_procedimiento] group by base) pro on pro.base = bas.id


GO
/****** Object:  View [dbo].[vwbas_columna]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwbas_columna] as
select 
col.id cid,
bas.id bid,
bas.nombre bnombre,
tab.id tid,
tab.nombre tnombre,
col.nombre cnombre,
col.nulos cnulos,
col.tipo ctipo,
col.maximo cmaximo,
col.descripcion cdescripcion,
col.fechaProceso cfechaProceso 
from cap.[dbo].[bas_columna] col
inner join cap.dbo.bas_tabla tab on tab.id = col.tabla
inner join cap.dbo.bas_base bas on bas.id = tab.base
GO
/****** Object:  View [dbo].[vwbas_procedimiento]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create view [dbo].[vwbas_procedimiento] as
select 
pro.id pid,
bas.id bid,
bas.nombre bnombre,
pro.nombre pnombre,
pro.rutina prutina,
pro.fechaCreacion pfechaCreacion,
pro.fechaEdicion pfechaEdicion,
pro.descripcion pdescripcion,
pro.fechaProceso pfechaProceso
from [CAP].[dbo].[bas_procedimiento] pro
inner join cap.dbo.bas_base bas on bas.id = pro.base
GO
/****** Object:  View [dbo].[vwbas_tabla]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


  CREATE view [dbo].[vwbas_tabla] as
  select 
  tab.id tid,
  bas.id bid,
  bas.nombre bnombre,
  tab.nombre tnombre,
  tab.fechaCreacion tfechaCreacion,
  tab.fechaEdicion tfechaEdicion,
  tab.descripcion tdescripcion,
  col.campos,
  tab.fechaProceso tfechaProceso
  from cap.dbo.bas_tabla tab
  inner join cap.dbo.bas_base bas on bas.id = tab.base
  left join (select tabla, count(*) campos from cap.dbo.bas_columna group by tabla) col on col.tabla = tab.id 
  


GO
/****** Object:  View [dbo].[vwbas_vista]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwbas_vista] as
select 
vis.id vid,
bas.id bid,
bas.nombre bnombre,
vis.nombre vnombre,
vis.tipoConsulta vtipoConsulta,
vis.descripcion vdescripcion,
vis.fechaProceso vfechaProceso
from cap.dbo.bas_vista vis
inner join cap.dbo.bas_base bas on bas.id= vis.base
GO
/****** Object:  View [dbo].[vwcom_comunicacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwdep_activo_padre]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

  create view [dbo].[vwdep_activo_padre]
  as
  select 
  pad.id,
  pad.sigla,
  pad.nombre,
  pad.categoria,
  dep.hijos,
  pad.estado 
  from cap.[dbo].[dep_activo_padre] pad
  inner join (select idPadre, count(idHijo) hijos from cap.dbo.dep_dependencia group by idPadre) dep on dep.idPadre = pad.id


GO
/****** Object:  View [dbo].[vwfir_firewall]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwger_departamento]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwger_empleado]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwger_gerencia]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vwger_gerencia]
as

select  
ger.id gid,
ger.nombre gnombre,
emp.id eid,
emp.nombre enombre,
emp.estado eestado,
(case when apl.aplicaciones is not null then apl.aplicaciones else 0 end) aplicaciones,
(case when aux.auxiliares is not null then aux.auxiliares else 0 end) auxiliares,
(case when com.comunicaciones is not null then com.comunicaciones else 0 end) comunicaciones,
(case when dep.departamentos is not null then dep.departamentos else 0 end) departamentos,
(case when ins.instalaciones is not null then ins.instalaciones else 0 end) instalaciones,
ger.estado gestado
from dbo.ger_gerencia ger
left join ger_empleado emp on ger.empleado = emp.id
left join (select gerencia, count(*) aplicaciones 
			from cap.dbo.apl_aplicacion 
			where estado = 'Activa' and gerencia is not null 
			group by gerencia) apl on apl.gerencia = ger.id
left join (select gerencia, count(*) auxiliares 
			from cap.dbo.aux_auxiliar
			where estado = 'Activo' and gerencia is not null
			group by gerencia) aux on aux.gerencia = ger.id
left join (select gerencia, count(*) comunicaciones 
			from cap.dbo.com_comunicacion
			where estado = 'Activa' and gerencia is not null
			group by gerencia) com on com.gerencia = ger.id
left join (select gerencia, count(*) departamentos 
			from cap.dbo.ger_departamento
			where estado = 'Activo' and gerencia is not null
			group by gerencia) dep on dep.gerencia = ger.id
left join (select gerencia, count(*) instalaciones 
			from cap.dbo.ins_instalacion
			where estado = 'Activa' and gerencia is not null
			group by gerencia) ins on ins.gerencia = ger.id


GO
/****** Object:  View [dbo].[vwhar_hardware]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwins_instalacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwinv_aplicacion]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[vwinv_aplicacion] as
select 
apl.inventario,
apl.id aid,
apl.sigla asigla,
apl.nombre anombre,
apl.tipo atipo,
apl.seguridad aseguridad,
apl.tecnologia atecnologia,
pro.id pid,
pro.nombre pnombre,
lje.id lid,
lje.nombre lnombre,
lje.version lversion,
her.id hid,
her.nombre hnombre,
her.version hversion,
bas.id bid,
bas.nombre bnombre, 
pmo.id mid,
pmo.nombre mnombre,
plu.id uid,
plu.nombre unombre,
ger.id gid,
ger.nombre gnombre,
emp.id eid,
emp.nombre enombre,
spr.id sid,
spr.nombre snombre,
ste.id tid,
ste.nombre tnombre,
sde.id did,
sde.nombre dnombre,
apl.puertoProduccion apuertoProduccion,
apl.puertoTest apuertoTest,
apl.puertoDesarrollo apuertoDesarrollo,
apl.confidencialidad,
apl.integridad,
apl.disponibilidad,
apl.criticidad,
apl.rti arti,
apl.descripcion adescripcion,
apl.estado aestado
from cap.[dbo].inv_aplicacion apl
left join cap.dbo.pro_proveedor pro on pro.id = apl.proveedor
left join cap.dbo.len_lenguaje lje on lje.id = apl.lenguaje
left join cap.dbo.her_herramienta her on her.id = apl.herramienta
left join cap.dbo.bas_base bas on bas.id = apl.base
inner join cap.dbo.psa_modo pmo on pmo.id = apl.modoProcesamiento
inner join cap.dbo.psa_lugar plu on plu.id = apl.lugarProcesamiento
left join cap.dbo.ger_gerencia ger on ger.id  = apl.gerencia
left join cap.dbo.ger_empleado emp on emp.id = apl.empleado
left join cap.dbo.ser_servidor spr on spr.id = apl.servidorProduccion
left join cap.dbo.ser_servidor ste on ste.id = apl.servidorTest
left join cap.dbo.ser_servidor sde on sde.id = apl.servidorDesarrollo
GO
/****** Object:  View [dbo].[vwinv_auxiliar]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE view [dbo].[vwinv_auxiliar]
as
select 
aux.inventario,
aux.id aid,
aux.sigla asigla,
aux.nombre anombre,
aux.cantidad acantidad,
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
aux.descripcion adescripcion,
aux.rti arti,
aux.estado aestado
from [dbo].[inv_auxiliar] aux
inner join dbo.ger_gerencia ger on ger.id = aux.gerencia
left join dbo.ger_empleado jef on jef.id = ger.empleado
inner join dbo.ger_empleado emp on emp.id = aux.empleado
inner join dbo.sit_sitio sit on sit.id = aux.sitio


GO
/****** Object:  View [dbo].[vwinv_comunicacion]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwinv_firewall]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwinv_hardware]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE view [dbo].[vwinv_hardware] as
select 
har.inventario,
har.id hid,
har.tipo htipo,
har.sigla hsigla,
har.nombre hnombre,
har.dominio hdominio,
har.softwareBase hsoftwareBase,
har.ambiente hambiente,
har.funcion hfuncion,
sit.id sid,
sit.tipo stipo,
sit.nombre snombre,
sit.provincia sprovincia,
sit.ciudad sciudad,
sit.codigoPostal scodigoPostal,
sit.direccion sdireccion,
sit.origen sorigen,
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
from cap.[dbo].[inv_hardware] har
inner join cap.dbo.sit_sitio sit on sit.id = har.sitio
GO
/****** Object:  View [dbo].[vwinv_personal]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


  create view [dbo].[vwinv_personal] as
  select 
  per.inventario,
  per.id pid,
  per.sigla psigla,
  per.nombre pnombre,
  dep.id did,
  dep.nombre dnombre,
  ger.id gid,
  ger.nombre gnombre,
  per.rti prti,
  per.estado pestado
  from cap.dbo.inv_personal per
  inner join cap.dbo.ger_departamento dep on dep.id = per.departamento
  inner join cap.dbo.ger_gerencia ger on ger.id = dep.gerencia

GO
/****** Object:  View [dbo].[vwinv_switch]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwlog_actividad]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE view [dbo].[vwlog_actividad] as
select 
act.id aid,
act.legajo ulegajo,
(CASE WHEN usu.nombre IS NULL THEN '' ELSE usu.nombre END) unombre,
UPPER(SUBSTRING(act.tabla,0,4)) amodulo,
act.tabla atabla,
act.operacion aoperacion,
act.registro aregistro,
act.fecha afecha
from cap.[dbo].[log_actividad] act
left join cap.dbo.seg_usuario usu on usu.id = act.legajo

GO
/****** Object:  View [dbo].[vwper_personal]    Script Date: 23/3/2020 13:16:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

 create view [dbo].[vwper_personal] as
  select 
  per.id pid,
  per.sigla psigla,
  per.nombre pnombre,
  dep.id did,
  dep.nombre dnombre,
  per.rti prti,
  per.estado pestado
  from cap.dbo.per_personal per
  inner join cap.dbo.ger_departamento dep on dep.id = per.departamento
GO
/****** Object:  View [dbo].[vwpro_responsable]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwseg_perfil]    Script Date: 23/3/2020 13:16:01 ******/
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
	(CASE WHEN usu.usuarios IS NULL THEN 0 ELSE usu.usuarios END) usuarios,
	(CASE WHEN pmi.permisos IS NULL THEN 0 ELSE pmi.permisos END) permisos
  from [CAP].[dbo].[seg_perfil] per
  left join (select perfil, count(*) usuarios 
			 from [CAP].[dbo].[seg_usuario] 
			 group by perfil) usu on usu.perfil = per.id
  left join (select idPerfil, COUNT(*) permisos 
			from cap.[dbo].[seg_perfil_permiso] 
			group by idPerfil) pmi on pmi.idPerfil = per.id


GO
/****** Object:  View [dbo].[vwseg_permiso]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwseg_usuario]    Script Date: 23/3/2020 13:16:01 ******/
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
/****** Object:  View [dbo].[vwser_servidor]    Script Date: 23/3/2020 13:16:02 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create view [dbo].[vwser_servidor] as
select 
ser.id,
ser.nombre,
ser.ambiente,
ser.tipo,
ser.descripcion,
(CASE when bas.bases is not null then bas.bases else 0 end) bases,
(CASE when job.jobs is not null then job.jobs else 0 end) jobs,
(CASE when apl.aplicaciones is not null then apl.aplicaciones else 0 end) aplicaciones,
ser.spjob,
ser.spbd,
ser.estado 
from cap.dbo.ser_servidor ser
left join (select produccion servidor, count(*) bases 
		   from cap.dbo.bas_base where produccion is not null 
		   group by produccion
		   UNION
		   select test servidor, count(*) bases 
		   from cap.dbo.bas_base where test is not null 
		   group by test
		   UNION
		   select desarrollo servidor, count(*) bases 
		   from cap.dbo.bas_base where desarrollo is not null 
		   group by desarrollo) bas on bas.servidor = ser.id
left join (select servidor, count(*) jobs
		   from cap.[dbo].[ser_job]
		   group by servidor) job on job.servidor = ser.id
left join (select servidorProduccion servidor, count(*) aplicaciones
			from cap.[dbo].[apl_aplicacion] 
			where servidorProduccion is not null
			group by servidorProduccion
			UNION
			select servidorTest servidor, count(*) aplicaciones
			from cap.[dbo].[apl_aplicacion] 
			where servidorTest is not null
			group by servidorTest
			UNION
			select servidorDesarrollo servidor, count(*) aplicaciones
			from cap.[dbo].[apl_aplicacion] 
			where servidorDesarrollo is not null
			group by servidorDesarrollo) apl on apl.servidor = ser.id
		   

GO
/****** Object:  View [dbo].[vwsit_sitio]    Script Date: 23/3/2020 13:16:02 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create view [dbo].[vwsit_sitio] as
SELECT 
sit.id sid,
sit.tipo stipo,
sit.nombre snombre,
sit.provincia sprovincia,
sit.ciudad sciudad,
sit.codigoPostal scodigoPostal,
sit.direccion sdireccion,
sit.origen sorigen,
(case when com.comunicaciones is not null then com.comunicaciones else 0 end) comunicaciones,
(case when fir.firewalls is not null then fir.firewalls else 0 end) firewalls,
(case when har.hardwares is not null then har.hardwares else 0 end) hardwares,
(case when ins.instalaciones is not null then ins.instalaciones else 0 end) instalaciones,
(case when swi.switchs is not null then swi.switchs else 0 end) switchs,
sit.estado sestado
FROM sit_sitio sit
left join (select sitio, count(*) comunicaciones
			from com_comunicacion 
			where estado = 'Activa' AND sitio is not null
			group by sitio) com on com.sitio = sit.id
left join (select sitio, count(*) firewalls
			from fir_firewall 
			where estado = 'Activo' AND sitio is not null
			group by sitio) fir on fir.sitio = sit.id
left join (select sitio, count(*) hardwares
			from har_hardware 
			where estado = 'Activo' AND sitio is not null
			group by sitio) har on har.sitio = sit.id
left join (select sitio, count(*) instalaciones
			from inv_instalacion 
			where estado = 'Activa' AND sitio is not null
			group by sitio) ins on ins.sitio = sit.id
left join (select sitio, count(*) switchs
			from swi_switch 
			where estado = 'Activo' AND sitio is not null
			group by sitio) swi on swi.sitio = sit.id










GO
/****** Object:  View [dbo].[vwswi_switch]    Script Date: 23/3/2020 13:16:02 ******/
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
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_her_herramienta] FOREIGN KEY([herramienta])
REFERENCES [dbo].[her_herramienta] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_her_herramienta]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_len_lenguaje] FOREIGN KEY([lenguaje])
REFERENCES [dbo].[len_lenguaje] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_len_lenguaje]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_pla_plataformaSO] FOREIGN KEY([plataforma])
REFERENCES [dbo].[pla_plataformaSO] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_pla_plataformaSO]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_pro_proveedor] FOREIGN KEY([proveedor])
REFERENCES [dbo].[pro_proveedor] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_pro_proveedor]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_psa_lugar] FOREIGN KEY([lugarProcesamiento])
REFERENCES [dbo].[psa_lugar] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_psa_lugar]
GO
ALTER TABLE [dbo].[apl_aplicacion]  WITH CHECK ADD  CONSTRAINT [FK_apl_aplicacion_psa_modo] FOREIGN KEY([modoProcesamiento])
REFERENCES [dbo].[psa_modo] ([id])
GO
ALTER TABLE [dbo].[apl_aplicacion] CHECK CONSTRAINT [FK_apl_aplicacion_psa_modo]
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
ALTER TABLE [dbo].[aux_auxiliar]  WITH CHECK ADD  CONSTRAINT [FK_aux_auxiliar_ger_empleado] FOREIGN KEY([empleado])
REFERENCES [dbo].[ger_empleado] ([id])
GO
ALTER TABLE [dbo].[aux_auxiliar] CHECK CONSTRAINT [FK_aux_auxiliar_ger_empleado]
GO
ALTER TABLE [dbo].[aux_auxiliar]  WITH CHECK ADD  CONSTRAINT [FK_aux_auxiliar_ger_gerencia] FOREIGN KEY([gerencia])
REFERENCES [dbo].[ger_gerencia] ([id])
GO
ALTER TABLE [dbo].[aux_auxiliar] CHECK CONSTRAINT [FK_aux_auxiliar_ger_gerencia]
GO
ALTER TABLE [dbo].[aux_auxiliar]  WITH CHECK ADD  CONSTRAINT [FK_aux_auxiliar_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[aux_auxiliar] CHECK CONSTRAINT [FK_aux_auxiliar_sit_sitio]
GO
ALTER TABLE [dbo].[bas_base]  WITH CHECK ADD  CONSTRAINT [FK_bas_base_ser_servidor] FOREIGN KEY([produccion])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[bas_base] CHECK CONSTRAINT [FK_bas_base_ser_servidor]
GO
ALTER TABLE [dbo].[bas_base]  WITH CHECK ADD  CONSTRAINT [FK_bas_base_ser_servidor1] FOREIGN KEY([test])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[bas_base] CHECK CONSTRAINT [FK_bas_base_ser_servidor1]
GO
ALTER TABLE [dbo].[bas_base]  WITH CHECK ADD  CONSTRAINT [FK_bas_base_ser_servidor2] FOREIGN KEY([desarrollo])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[bas_base] CHECK CONSTRAINT [FK_bas_base_ser_servidor2]
GO
ALTER TABLE [dbo].[bas_columna]  WITH CHECK ADD  CONSTRAINT [FK_bas_columna_bas_tabla] FOREIGN KEY([tabla])
REFERENCES [dbo].[bas_tabla] ([id])
GO
ALTER TABLE [dbo].[bas_columna] CHECK CONSTRAINT [FK_bas_columna_bas_tabla]
GO
ALTER TABLE [dbo].[bas_procedimiento]  WITH CHECK ADD  CONSTRAINT [FK_bas_procedimiento_bas_base] FOREIGN KEY([base])
REFERENCES [dbo].[bas_base] ([id])
GO
ALTER TABLE [dbo].[bas_procedimiento] CHECK CONSTRAINT [FK_bas_procedimiento_bas_base]
GO
ALTER TABLE [dbo].[bas_tabla]  WITH CHECK ADD  CONSTRAINT [FK_bas_tabla_bas_base] FOREIGN KEY([base])
REFERENCES [dbo].[bas_base] ([id])
GO
ALTER TABLE [dbo].[bas_tabla] CHECK CONSTRAINT [FK_bas_tabla_bas_base]
GO
ALTER TABLE [dbo].[bas_vista]  WITH CHECK ADD  CONSTRAINT [FK_bas_vista_bas_base] FOREIGN KEY([base])
REFERENCES [dbo].[bas_base] ([id])
GO
ALTER TABLE [dbo].[bas_vista] CHECK CONSTRAINT [FK_bas_vista_bas_base]
GO
ALTER TABLE [dbo].[com_comunicacion]  WITH CHECK ADD  CONSTRAINT [FK_com_comunicacion_ger_empleado] FOREIGN KEY([empleado])
REFERENCES [dbo].[ger_empleado] ([id])
GO
ALTER TABLE [dbo].[com_comunicacion] CHECK CONSTRAINT [FK_com_comunicacion_ger_empleado]
GO
ALTER TABLE [dbo].[com_comunicacion]  WITH CHECK ADD  CONSTRAINT [FK_com_comunicacion_ger_gerencia] FOREIGN KEY([gerencia])
REFERENCES [dbo].[ger_gerencia] ([id])
GO
ALTER TABLE [dbo].[com_comunicacion] CHECK CONSTRAINT [FK_com_comunicacion_ger_gerencia]
GO
ALTER TABLE [dbo].[com_comunicacion]  WITH CHECK ADD  CONSTRAINT [FK_com_comunicacion_pro_proveedor] FOREIGN KEY([proveedor])
REFERENCES [dbo].[pro_proveedor] ([id])
GO
ALTER TABLE [dbo].[com_comunicacion] CHECK CONSTRAINT [FK_com_comunicacion_pro_proveedor]
GO
ALTER TABLE [dbo].[com_comunicacion]  WITH CHECK ADD  CONSTRAINT [FK_com_comunicacion_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[com_comunicacion] CHECK CONSTRAINT [FK_com_comunicacion_sit_sitio]
GO
ALTER TABLE [dbo].[dep_dependencia]  WITH CHECK ADD  CONSTRAINT [FK_dep_dependencias_dep_activo_hijo] FOREIGN KEY([idHijo])
REFERENCES [dbo].[dep_activo_hijo] ([id])
GO
ALTER TABLE [dbo].[dep_dependencia] CHECK CONSTRAINT [FK_dep_dependencias_dep_activo_hijo]
GO
ALTER TABLE [dbo].[dep_dependencia]  WITH CHECK ADD  CONSTRAINT [FK_dep_dependencias_dep_activo_padre] FOREIGN KEY([idPadre])
REFERENCES [dbo].[dep_activo_padre] ([id])
GO
ALTER TABLE [dbo].[dep_dependencia] CHECK CONSTRAINT [FK_dep_dependencias_dep_activo_padre]
GO
ALTER TABLE [dbo].[fir_firewall]  WITH CHECK ADD  CONSTRAINT [FK_fir_firewall_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[fir_firewall] CHECK CONSTRAINT [FK_fir_firewall_sit_sitio]
GO
ALTER TABLE [dbo].[ger_departamento]  WITH CHECK ADD  CONSTRAINT [FK_ger_departamento_ger_gerencia] FOREIGN KEY([gerencia])
REFERENCES [dbo].[ger_gerencia] ([id])
GO
ALTER TABLE [dbo].[ger_departamento] CHECK CONSTRAINT [FK_ger_departamento_ger_gerencia]
GO
ALTER TABLE [dbo].[ger_empleado]  WITH CHECK ADD  CONSTRAINT [FK_ger_empleado_ger_departamento] FOREIGN KEY([departamento])
REFERENCES [dbo].[ger_departamento] ([id])
GO
ALTER TABLE [dbo].[ger_empleado] CHECK CONSTRAINT [FK_ger_empleado_ger_departamento]
GO
ALTER TABLE [dbo].[ger_gerencia]  WITH CHECK ADD  CONSTRAINT [FK_ger_gerencia_ger_empleado] FOREIGN KEY([empleado])
REFERENCES [dbo].[ger_empleado] ([id])
GO
ALTER TABLE [dbo].[ger_gerencia] CHECK CONSTRAINT [FK_ger_gerencia_ger_empleado]
GO
ALTER TABLE [dbo].[har_hardware]  WITH CHECK ADD  CONSTRAINT [FK_har_hardware_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[har_hardware] CHECK CONSTRAINT [FK_har_hardware_sit_sitio]
GO
ALTER TABLE [dbo].[ins_instalacion]  WITH CHECK ADD  CONSTRAINT [FK_ins_instalacion_ger_empleado] FOREIGN KEY([empleado])
REFERENCES [dbo].[ger_empleado] ([id])
GO
ALTER TABLE [dbo].[ins_instalacion] CHECK CONSTRAINT [FK_ins_instalacion_ger_empleado]
GO
ALTER TABLE [dbo].[ins_instalacion]  WITH CHECK ADD  CONSTRAINT [FK_ins_instalacion_ger_gerencia] FOREIGN KEY([gerencia])
REFERENCES [dbo].[ger_gerencia] ([id])
GO
ALTER TABLE [dbo].[ins_instalacion] CHECK CONSTRAINT [FK_ins_instalacion_ger_gerencia]
GO
ALTER TABLE [dbo].[ins_instalacion]  WITH CHECK ADD  CONSTRAINT [FK_ins_instalacion_pla_plataformaSO] FOREIGN KEY([plataforma])
REFERENCES [dbo].[pla_plataformaSO] ([id])
GO
ALTER TABLE [dbo].[ins_instalacion] CHECK CONSTRAINT [FK_ins_instalacion_pla_plataformaSO]
GO
ALTER TABLE [dbo].[ins_instalacion]  WITH CHECK ADD  CONSTRAINT [FK_ins_instalacion_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[ins_instalacion] CHECK CONSTRAINT [FK_ins_instalacion_sit_sitio]
GO
ALTER TABLE [dbo].[inv_auxiliar]  WITH CHECK ADD  CONSTRAINT [FK_inv_auxiliar_ger_empleado] FOREIGN KEY([empleado])
REFERENCES [dbo].[ger_empleado] ([id])
GO
ALTER TABLE [dbo].[inv_auxiliar] CHECK CONSTRAINT [FK_inv_auxiliar_ger_empleado]
GO
ALTER TABLE [dbo].[inv_auxiliar]  WITH CHECK ADD  CONSTRAINT [FK_inv_auxiliar_ger_gerencia] FOREIGN KEY([gerencia])
REFERENCES [dbo].[ger_gerencia] ([id])
GO
ALTER TABLE [dbo].[inv_auxiliar] CHECK CONSTRAINT [FK_inv_auxiliar_ger_gerencia]
GO
ALTER TABLE [dbo].[inv_auxiliar]  WITH CHECK ADD  CONSTRAINT [FK_inv_auxiliar_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[inv_auxiliar] CHECK CONSTRAINT [FK_inv_auxiliar_sit_sitio]
GO
ALTER TABLE [dbo].[per_personal]  WITH CHECK ADD  CONSTRAINT [FK_per_personal_ger_departamento] FOREIGN KEY([departamento])
REFERENCES [dbo].[ger_departamento] ([id])
GO
ALTER TABLE [dbo].[per_personal] CHECK CONSTRAINT [FK_per_personal_ger_departamento]
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
ALTER TABLE [dbo].[pro_responsable]  WITH CHECK ADD  CONSTRAINT [FK_pro_responsable_pro_proveedor] FOREIGN KEY([proveedor])
REFERENCES [dbo].[pro_proveedor] ([id])
GO
ALTER TABLE [dbo].[pro_responsable] CHECK CONSTRAINT [FK_pro_responsable_pro_proveedor]
GO
ALTER TABLE [dbo].[seg_perfil_permiso]  WITH NOCHECK ADD  CONSTRAINT [FK_seg_perfil_permiso_seg_perfil] FOREIGN KEY([idPerfil])
REFERENCES [dbo].[seg_perfil] ([id])
NOT FOR REPLICATION 
GO
ALTER TABLE [dbo].[seg_perfil_permiso] CHECK CONSTRAINT [FK_seg_perfil_permiso_seg_perfil]
GO
ALTER TABLE [dbo].[seg_perfil_permiso]  WITH NOCHECK ADD  CONSTRAINT [FK_seg_perfil_permiso_seg_permiso] FOREIGN KEY([idPermiso])
REFERENCES [dbo].[seg_permiso] ([id])
NOT FOR REPLICATION 
GO
ALTER TABLE [dbo].[seg_perfil_permiso] CHECK CONSTRAINT [FK_seg_perfil_permiso_seg_permiso]
GO
ALTER TABLE [dbo].[ser_job]  WITH CHECK ADD  CONSTRAINT [FK_ser_job_ser_servidor] FOREIGN KEY([servidor])
REFERENCES [dbo].[ser_servidor] ([id])
GO
ALTER TABLE [dbo].[ser_job] CHECK CONSTRAINT [FK_ser_job_ser_servidor]
GO
ALTER TABLE [dbo].[swi_switch]  WITH CHECK ADD  CONSTRAINT [FK_swi_switch_ins_instalacion] FOREIGN KEY([instalacion])
REFERENCES [dbo].[ins_instalacion] ([id])
GO
ALTER TABLE [dbo].[swi_switch] CHECK CONSTRAINT [FK_swi_switch_ins_instalacion]
GO
ALTER TABLE [dbo].[swi_switch]  WITH CHECK ADD  CONSTRAINT [FK_swi_switch_sit_sitio] FOREIGN KEY([sitio])
REFERENCES [dbo].[sit_sitio] ([id])
GO
ALTER TABLE [dbo].[swi_switch] CHECK CONSTRAINT [FK_swi_switch_sit_sitio]
GO
