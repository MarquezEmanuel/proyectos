USE [master]
GO
/****** Object:  Database [SLB]    Script Date: 01/04/2021 09:49:30 p.m. ******/
CREATE DATABASE [SLB]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'SLB', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\SLB.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'SLB_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\SLB_log.ldf' , SIZE = 5120KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [SLB] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [SLB].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [SLB] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [SLB] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [SLB] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [SLB] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [SLB] SET ARITHABORT OFF 
GO
ALTER DATABASE [SLB] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [SLB] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [SLB] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [SLB] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [SLB] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [SLB] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [SLB] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [SLB] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [SLB] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [SLB] SET  DISABLE_BROKER 
GO
ALTER DATABASE [SLB] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [SLB] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [SLB] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [SLB] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [SLB] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [SLB] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [SLB] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [SLB] SET RECOVERY FULL 
GO
ALTER DATABASE [SLB] SET  MULTI_USER 
GO
ALTER DATABASE [SLB] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [SLB] SET DB_CHAINING OFF 
GO
ALTER DATABASE [SLB] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [SLB] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [SLB] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [SLB] SET QUERY_STORE = OFF
GO
USE [SLB]
GO
/****** Object:  Table [dbo].[log_acceso]    Script Date: 01/04/2021 09:49:31 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[log_acceso](
	[idUsuario] [nvarchar](10) NOT NULL,
	[idSistema] [int] NOT NULL,
	[contador] [int] NOT NULL,
 CONSTRAINT [IX_log_acceso] UNIQUE NONCLUSTERED 
(
	[idUsuario] ASC,
	[idSistema] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[log_actividad]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[log_actividad](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipo] [nvarchar](3) NOT NULL,
	[mensaje] [nvarchar](max) NOT NULL,
	[fecha] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_log] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[perfil]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[perfil](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[idSistema] [int] NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](150) NOT NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[fechaEdicion] [smalldatetime] NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_perfil] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_perfil] UNIQUE NONCLUSTERED 
(
	[idSistema] ASC,
	[nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[perfil_permiso]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[perfil_permiso](
	[idPerfil] [int] NOT NULL,
	[idPermiso] [nvarchar](6) NOT NULL,
 CONSTRAINT [IX_perfil_permiso] UNIQUE NONCLUSTERED 
(
	[idPerfil] ASC,
	[idPermiso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[permiso]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[permiso](
	[id] [nvarchar](6) NOT NULL,
	[idSistema] [int] NOT NULL,
	[titulo] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](100) NOT NULL,
	[nivel] [int] NOT NULL,
	[idPadre] [nvarchar](6) NOT NULL,
	[link] [nvarchar](150) NOT NULL,
 CONSTRAINT [PK_permiso] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sistema]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sistema](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombreCorto] [nvarchar](10) NOT NULL,
	[nombreLargo] [nvarchar](50) NOT NULL,
	[descripcion] [nvarchar](500) NOT NULL,
	[URLProduccion] [nvarchar](50) NOT NULL,
	[URLTest] [nvarchar](50) NULL,
	[imagen] [nvarchar](500) NOT NULL,
	[estado] [int] NOT NULL,
 CONSTRAINT [PK_sistema] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [IX_sistema] UNIQUE NONCLUSTERED 
(
	[nombreCorto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[usuario]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario](
	[id] [nvarchar](10) NOT NULL,
	[apellido] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[imagen] [nvarchar](50) NOT NULL,
	[marcaAdministrador] [bit] NOT NULL,
	[fechaConexion] [smalldatetime] NULL,
	[fechaCreacion] [smalldatetime] NOT NULL,
	[fechaEdicion] [smalldatetime] NULL,
 CONSTRAINT [PK_usuario] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[usuario_perfil]    Script Date: 01/04/2021 09:49:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario_perfil](
	[idUsuario] [nvarchar](10) NOT NULL,
	[idPerfil] [int] NOT NULL,
 CONSTRAINT [IX_usuario_perfil] UNIQUE NONCLUSTERED 
(
	[idUsuario] ASC,
	[idPerfil] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[log_acceso]  WITH CHECK ADD  CONSTRAINT [FK_log_acceso_sistema] FOREIGN KEY([idSistema])
REFERENCES [dbo].[sistema] ([id])
GO
ALTER TABLE [dbo].[log_acceso] CHECK CONSTRAINT [FK_log_acceso_sistema]
GO
ALTER TABLE [dbo].[log_acceso]  WITH CHECK ADD  CONSTRAINT [FK_log_acceso_usuario] FOREIGN KEY([idUsuario])
REFERENCES [dbo].[usuario] ([id])
GO
ALTER TABLE [dbo].[log_acceso] CHECK CONSTRAINT [FK_log_acceso_usuario]
GO
ALTER TABLE [dbo].[perfil]  WITH CHECK ADD  CONSTRAINT [FK_perfil_sistema] FOREIGN KEY([idSistema])
REFERENCES [dbo].[sistema] ([id])
GO
ALTER TABLE [dbo].[perfil] CHECK CONSTRAINT [FK_perfil_sistema]
GO
ALTER TABLE [dbo].[perfil_permiso]  WITH CHECK ADD  CONSTRAINT [FK_perfil_permiso_perfil] FOREIGN KEY([idPerfil])
REFERENCES [dbo].[perfil] ([id])
GO
ALTER TABLE [dbo].[perfil_permiso] CHECK CONSTRAINT [FK_perfil_permiso_perfil]
GO
ALTER TABLE [dbo].[perfil_permiso]  WITH CHECK ADD  CONSTRAINT [FK_perfil_permiso_permiso] FOREIGN KEY([idPermiso])
REFERENCES [dbo].[permiso] ([id])
GO
ALTER TABLE [dbo].[perfil_permiso] CHECK CONSTRAINT [FK_perfil_permiso_permiso]
GO
ALTER TABLE [dbo].[permiso]  WITH CHECK ADD  CONSTRAINT [FK_permiso_sistema] FOREIGN KEY([idSistema])
REFERENCES [dbo].[sistema] ([id])
GO
ALTER TABLE [dbo].[permiso] CHECK CONSTRAINT [FK_permiso_sistema]
GO
ALTER TABLE [dbo].[usuario_perfil]  WITH CHECK ADD  CONSTRAINT [FK_sistema_usuario_perfil] FOREIGN KEY([idPerfil])
REFERENCES [dbo].[perfil] ([id])
GO
ALTER TABLE [dbo].[usuario_perfil] CHECK CONSTRAINT [FK_sistema_usuario_perfil]
GO
ALTER TABLE [dbo].[usuario_perfil]  WITH CHECK ADD  CONSTRAINT [FK_sistema_usuario_usuario] FOREIGN KEY([idUsuario])
REFERENCES [dbo].[usuario] ([id])
GO
ALTER TABLE [dbo].[usuario_perfil] CHECK CONSTRAINT [FK_sistema_usuario_usuario]
GO
USE [master]
GO
ALTER DATABASE [SLB] SET  READ_WRITE 
GO
