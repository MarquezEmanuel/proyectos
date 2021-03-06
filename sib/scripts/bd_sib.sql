USE [bd_sib]
GO
/****** Object:  Table [dbo].[10cuentasASJ]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[10cuentasASJ](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
 CONSTRAINT [PK_10cuentasASJ] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[10pmcred]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[10pmcred](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fecha] [smalldatetime] NULL,
	[moneda] [int] NULL,
	[tipo] [nvarchar](100) NULL,
	[causal] [int] NULL,
	[tipoCuenta] [nvarchar](100) NULL,
	[numeroCuenta] [int] NULL,
	[sucursal] [int] NULL,
	[digito] [int] NULL,
	[importe] [int] NULL,
	[documento] [bigint] NULL,
	[razon] [nvarchar](150) NULL,
	[usuario] [varchar](100) NULL,
	[legajo] [varchar](10) NULL,
	[oficina] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[3ACMOL]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3ACMOL](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numeroCliente] [bigint] NULL,
	[cuenta] [nvarchar](50) NULL,
	[nombreCliente] [nvarchar](50) NULL,
	[producto] [int] NULL,
	[estado] [int] NULL,
	[definicionEstado] [nvarchar](50) NULL,
	[saldo] [money] NULL,
	[fechaUltimoMovimiento] [smalldatetime] NULL,
	[sucursal] [int] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL,
 CONSTRAINT [PK_3ACMOL] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3altaCliente]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3altaCliente](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numeroCliente] [bigint] NULL,
	[nombreCliente] [nvarchar](100) NULL,
	[usuarioAlta] [int] NULL,
	[nombreUsuario] [nvarchar](30) NULL,
	[fechaAlta] [smalldatetime] NULL,
	[fechaNacimiento] [smalldatetime] NULL,
	[edad] [int] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL,
 CONSTRAINT [PK_3altaCliente] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3archivosConta]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3archivosConta](
	[sucursal] [int] NULL,
	[nombreArchivo] [nvarchar](100) NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3canjeInterno]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3canjeInterno](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fechaDeposito] [smalldatetime] NULL,
	[numeroCheque] [int] NULL,
	[concepto] [nvarchar](50) NULL,
	[sucursalCuentaDeposito] [int] NULL,
	[cuentaBeneficiario] [nvarchar](50) NULL,
	[sucursalGirada] [int] NULL,
	[cuentaLibra] [nvarchar](50) NULL,
	[importe] [money] NULL,
	[horaAcreditacion] [int] NULL,
	[comentario] [nvarchar](100) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3chequerasPendientesEntrega]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3chequerasPendientesEntrega](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fechaIngreso] [date] NULL,
	[sucursalOrigen] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[deposito] [nvarchar](100) NULL,
	[ubicacion] [nvarchar](100) NULL,
	[descripcion] [nvarchar](100) NULL,
	[numeroInicial] [bigint] NULL,
	[numeroFinal] [bigint] NULL,
	[diasAtraso] [int] NULL,
	[producto] [int] NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[comentario] [nvarchar](150) NULL,
	[legajo] [nvarchar](10) NULL,
	[idsav] [nchar](10) NULL,
 CONSTRAINT [PK_3chequerasPendientesEntrega] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3clientesPotenciales]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3clientesPotenciales](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [nvarchar](10) NULL,
	[fechaAlta] [smalldatetime] NULL,
	[nroCliente] [nvarchar](13) NULL,
	[sucursal] [int] NULL,
	[nombreCliente] [nvarchar](100) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[comentario] [nvarchar](50) NULL,
	[tratado] [int] NULL,
	[documento] [bigint] NULL,
 CONSTRAINT [PK_3clientesPotenciales] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3comentariosCuentacorrentistas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3comentariosCuentacorrentistas](
	[id] [nvarchar](50) NULL,
	[comentario] [nvarchar](100) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[legajo] [nchar](10) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3correoMensaje]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3correoMensaje](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[reporte] [nvarchar](50) NULL,
	[nombre] [nvarchar](50) NULL,
	[asunto] [nvarchar](50) NULL,
	[mensaje] [nvarchar](500) NULL,
 CONSTRAINT [PK_3correoMensaje] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3crucePPMAPySAV]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3crucePPMAPySAV](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pcuOfici] [int] NULL,
	[pcuNumeroCuenta] [int] NULL,
	[scoIdent] [bigint] NULL,
	[snoCliente] [nvarchar](50) NULL,
	[pcuProducto] [int] NULL,
	[fechaLiquidacion] [smalldatetime] NULL,
	[fechaVencimiento] [smalldatetime] NULL,
	[estadoPrestamo] [nvarchar](50) NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3cuentasConstanciaSaldo]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3cuentasConstanciaSaldo](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
 CONSTRAINT [PK_3cuentasConstanciaSaldo] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3cuentasPuente]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3cuentasPuente](
	[cuenta] [bigint] NULL,
	[suc01] [money] NULL,
	[suc10] [money] NULL,
	[suc20] [money] NULL,
	[suc25] [money] NULL,
	[suc30] [money] NULL,
	[suc41] [money] NULL,
	[suc50] [money] NULL,
	[suc55] [money] NULL,
	[suc60] [money] NULL,
	[suc80] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3fallas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3fallas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sucursalCuenta] [int] NULL,
	[numeroCuenta] [nvarchar](16) NULL,
	[sucursalOrigen] [int] NULL,
	[moneda] [nvarchar](3) NULL,
	[usuario] [nvarchar](10) NULL,
	[supervisor] [nvarchar](10) NULL,
	[numeroSecuencia] [int] NULL,
	[categoriaTransaccion] [int] NULL,
	[estadoTransaccion] [int] NULL,
	[tipoTransaccion] [int] NULL,
	[fechaTransaccion] [smalldatetime] NULL,
	[horaSistema] [bigint] NULL,
	[montoTransaccion] [money] NULL,
	[numeroComprobante] [nvarchar](18) NULL,
	[nombreTransaccion] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[comentario] [nvarchar](50) NULL,
	[tratado] [int] NULL,
 CONSTRAINT [PK_3fallas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3mayores15]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3mayores15](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[causal] [int] NULL,
	[transaccion] [int] NULL,
	[producto] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [int] NULL,
	[digito] [int] NULL,
	[fecha] [smalldatetime] NULL,
	[monto] [money] NULL,
	[usuario] [nvarchar](50) NULL,
	[nombre] [nvarchar](50) NULL,
	[sucursalPago] [int] NULL,
	[tarjetaSAV] [nvarchar](19) NULL,
	[sucursalOrigen] [int] NULL,
	[titular] [nvarchar](100) NULL,
	[nroTarDebHab] [int] NULL,
	[nroTarDebInh] [int] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3morasCajaSeguridad]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3morasCajaSeguridad](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[modulo] [int] NULL,
	[numeroCaja] [int] NULL,
	[codigoContrato] [bigint] NULL,
	[importeCuota] [money] NULL,
	[cantidadCuotas] [int] NULL,
	[cuentaDA] [bigint] NULL,
	[digitoDA] [int] NULL,
	[fechaAlta] [smalldatetime] NULL,
	[nombre] [nvarchar](200) NULL,
	[producto] [int] NULL,
	[sucursalCuentaDA] [int] NULL,
	[tipoCuentaDA] [nvarchar](10) NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[numeroDocumento] [nvarchar](20) NULL,
	[nombreCuenta] [nvarchar](300) NULL,
	[estado] [nvarchar](50) NULL,
	[saldo] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[comentario] [nvarchar](50) NULL,
	[tratado] [int] NULL,
 CONSTRAINT [PK_3morasCajaSeguridad] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3morasCPD]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3morasCPD](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[producto] [int] NULL,
	[numeroCuenta] [nvarchar](20) NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[deuda] [money] NULL,
	[interes] [money] NULL,
	[fechaVencimiento] [smalldatetime] NULL,
	[monto] [money] NULL,
	[cheque] [nvarchar](50) NULL,
	[diferencia] [int] NULL,
	[comentario] [nchar](10) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL,
 CONSTRAINT [PK_3morasCPD] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3movimientoSinDepositantes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3movimientoSinDepositantes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[concepto] [int] NULL,
	[tipo] [nvarchar](50) NULL,
	[codigoSucursal] [int] NULL,
	[numeroCuenta] [nvarchar](10) NULL,
	[digitoVerificador] [int] NULL,
	[codigoMoneda] [int] NULL,
	[codigoUsuario] [nvarchar](15) NULL,
	[nombreUsuario] [nvarchar](100) NULL,
	[fechaValor] [date] NULL,
	[montoOrigen] [money] NULL,
	[montoPesos] [money] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_3movimientoSinDepositantes] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3pagaresCancelados]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3pagaresCancelados](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[producto] [int] NULL,
	[numeroPagare] [nvarchar](15) NULL,
	[fechaLiquidacion] [date] NULL,
	[fechaVencimiento] [date] NULL,
	[descripcion] [nvarchar](50) NULL,
	[codigoSucursalDeposito] [int] NULL,
	[nombreSucursalDeposito] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_3pagaresCancelados] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3prestamosConCuentaAsociada]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3prestamosConCuentaAsociada](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[transaccion] [int] NOT NULL,
	[causal] [int] NOT NULL,
	[nombreTransaccion] [nvarchar](50) NULL,
	[tipoCuenta] [int] NULL,
	[productoCuenta] [int] NULL,
	[sucursalCuenta] [int] NULL,
	[cuenta] [int] NULL,
	[digitoCuenta] [int] NULL,
	[nombreCuenta] [nvarchar](50) NULL,
	[productoPrestamo] [int] NULL,
	[sucursalPrestamo] [int] NULL,
	[prestamo] [int] NULL,
	[cliente] [nvarchar](50) NULL,
	[sucursalOperacion] [int] NULL,
	[usuarioTransaccion] [nvarchar](10) NULL,
	[nombreUsuario] [nvarchar](50) NULL,
	[dcoDelCre] [int] NULL,
	[clientePrestamo] [nvarchar](13) NULL,
	[clienteCuenta] [nvarchar](13) NULL,
	[fechaTransaccion] [smalldatetime] NULL,
	[monto] [money] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3reversas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3reversas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sucursalCuenta] [int] NULL,
	[numeroCuenta] [nvarchar](20) NULL,
	[numeroSucursalOrigen] [int] NULL,
	[numeroComprobante] [nvarchar](50) NULL,
	[moneda] [nvarchar](5) NULL,
	[usuario] [nvarchar](50) NULL,
	[supervisor] [nvarchar](50) NULL,
	[concepto] [int] NULL,
	[numeroSecuencia] [int] NULL,
	[categoriaTransaccion] [int] NULL,
	[estadoTransaccion] [int] NULL,
	[tipoTransaccion] [int] NULL,
	[fechaTransaccion] [smalldatetime] NULL,
	[horaSistema] [nvarchar](20) NULL,
	[montoTransaccion] [money] NULL,
	[nombreTransaccion] [nvarchar](50) NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3saldosSucursales]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3saldosSucursales](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numeroSucursal] [int] NULL,
	[cuenta] [nvarchar](20) NULL,
	[saldoSFB] [nvarchar](50) NULL,
	[saldoSCB] [nvarchar](50) NULL,
	[diferencias] [nvarchar](50) NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaControl] [nvarchar](10) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3telefonosTarjetas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3telefonosTarjetas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[numeroDocumento] [nvarchar](20) NULL,
	[descripcion] [nvarchar](20) NULL,
	[fechaGra] [smalldatetime] NULL,
	[fechaIngreso] [smalldatetime] NULL,
	[numeroInicial] [nvarchar](20) NULL,
	[numeroCliente] [nvarchar](20) NULL,
	[nombreCliente] [nvarchar](200) NULL,
	[correoCliente] [nvarchar](50) NULL,
	[telefonoSFB] [nvarchar](20) NULL,
	[telefonoEngage] [nvarchar](50) NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [nvarchar](1) NULL,
 CONSTRAINT [PK_3telefonosTarjetas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3tramitesFirmaGrafometrica]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3tramitesFirmaGrafometrica](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombreTramite] [nvarchar](4000) NULL,
	[codigoLegajoDigital] [nvarchar](20) NULL,
	[numeroDocumento] [nvarchar](50) NULL,
	[fechaAlta] [datetime] NULL,
	[instanciaLegajoDigital] [int] NULL,
	[instanciaWorkflow] [nvarchar](20) NULL,
 CONSTRAINT [PK_tramitesFirmaGrafometrica] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3transaccionIncorrecta]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3transaccionIncorrecta](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[causal] [int] NULL,
	[transaccion] [int] NULL,
	[nombreTransaccion] [nvarchar](150) NULL,
	[concepto] [int] NULL,
	[producto] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[depositante] [nvarchar](100) NULL,
	[ordenante] [nvarchar](100) NULL,
	[documentoDepositante] [nvarchar](25) NULL,
	[documentoOrdenante] [nvarchar](25) NULL,
	[sucursalOperacion] [int] NULL,
	[usuario] [nvarchar](50) NULL,
	[nombreUsuario] [nvarchar](100) NULL,
	[fecha] [smalldatetime] NULL,
	[numeroOperacion] [nvarchar](10) NULL,
	[monto] [money] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL,
 CONSTRAINT [PK_3transaccionIncorrecta] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[3turnero]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[3turnero](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sucursal] [nvarchar](50) NULL,
	[numeroSucursal] [int] NULL,
	[grupo] [nvarchar](50) NULL,
	[puestosDisponibles] [int] NULL,
	[puestosOcupados] [int] NULL,
	[clientesAtendidos] [int] NULL,
	[clientesNoAtendidos] [int] NULL,
	[tiempoMedioEspera] [int] NULL,
	[tiempoMedioAtencion] [int] NULL,
	[tiempoAtencionCliente] [int] NULL,
	[maximoTiempoEspera] [int] NULL,
	[maximoTiempoAtencion] [int] NULL,
	[comentario] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
	[tratado] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4cobranzasTC]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4cobranzasTC](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[marca] [nvarchar](50) NULL,
	[cuentaTarjeta] [bigint] NULL,
	[nombre] [nvarchar](100) NULL,
	[cuentaBanco] [bigint] NULL,
	[sucursalCuentaBanco] [int] NULL,
	[tipoCuenta] [nvarchar](50) NULL,
	[tipoDebito] [nvarchar](50) NULL,
	[saldoPesos] [money] NULL,
	[minimoPesos] [money] NULL,
	[saldoDolares] [money] NULL,
	[fechaVencimiento] [nvarchar](50) NULL,
	[cobranzasSo] [money] NULL,
	[cobranzasTanqueSFB] [money] NULL,
	[fechaPagoTanqueSFB] [nvarchar](50) NULL,
	[saldoCuentaSFB] [money] NULL,
	[bloqueo] [money] NULL,
	[cliente] [nvarchar](100) NULL,
	[cobranzasReafa] [money] NULL,
	[fechaPagoReafa] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4cobranzasTC] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4cobroNoAplicado]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4cobroNoAplicado](
	[id] [nvarchar](50) NOT NULL,
	[producto] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [int] NULL,
	[digito] [int] NULL,
	[moneda] [int] NULL,
	[sucursalCredito] [int] NULL,
	[cuentaCredito] [int] NULL,
	[saldoTerceros] [money] NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](100) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4cobroNoAplicado] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4cuentasCorrientes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4cuentasCorrientes](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[producto] [int] NULL,
	[moneda] [int] NULL,
	[saldo] [money] NULL,
	[acuerdo] [money] NULL,
	[exceso] [money] NULL,
	[rechazo] [money] NULL,
	[nroDiasSobregiro] [int] NULL,
	[nroDiasSaldoDeudor] [int] NULL,
	[primerVencimiento] [date] NULL,
	[promedioMes] [money] NULL,
	[promedio180] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4cuentasCorrientes] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4lineasNoPropias]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4lineasNoPropias](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sucursal] [int] NULL,
	[producto] [int] NULL,
	[operacion] [int] NULL,
	[nombre] [nvarchar](100) NULL,
	[diasMora] [int] NULL,
	[documento] [bigint] NULL,
	[fechaAlta] [nchar](10) NULL,
	[fechaVencimientoFinal] [nchar](10) NULL,
	[fechaVencimientoPago] [nchar](10) NULL,
	[capital] [money] NULL,
	[numeroCliente] [bigint] NULL,
	[fechaUltimoPago] [nchar](10) NULL,
	[fechaPrimerImpago] [nchar](10) NULL,
	[capitalOrigen] [money] NULL,
	[fechaPrimerVencimiento] [nchar](10) NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4moraPrestamos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4moraPrestamos](
	[id] [nvarchar](20) NOT NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[producto] [int] NULL,
	[moneda] [int] NULL,
	[atributo] [int] NULL,
	[cuota] [int] NULL,
	[vencimiento] [smalldatetime] NULL,
	[importeCuota] [money] NULL,
	[interesNormal] [money] NULL,
	[capital] [money] NULL,
	[punitorios] [money] NULL,
	[gastos] [money] NULL,
	[compensatorios] [money] NULL,
	[diasMora] [int] NULL,
	[legajo] [bigint] NULL,
	[carpeta] [int] NULL,
	[tipoCredito] [int] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4moraPrestamos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4moraTarjetas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4moraTarjetas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[marca] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[cuentaTarjeta] [nvarchar](15) NULL,
	[total] [money] NULL,
	[minimo] [money] NULL,
	[mora] [money] NULL,
	[diasAtraso] [int] NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[documento] [nvarchar](15) NULL,
	[tipoCuenta] [nvarchar](5) NULL,
	[sucursalCuenta] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[saldo] [money] NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[producto] [int] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4moraTarjetas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4plazoFijoWeb]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4plazoFijoWeb](
	[id] [nvarchar](20) NOT NULL,
	[fechaAlta] [bigint] NULL,
	[fechaDeposito] [bigint] NULL,
	[fechaPago] [bigint] NULL,
	[fechaVencimiento] [bigint] NULL,
	[montoDepositado] [money] NULL,
	[montoPago] [money] NULL,
	[conceptoDebito] [int] NULL,
	[sucursalDebito] [int] NULL,
	[cuentaDebito] [bigint] NULL,
	[digitoDebito] [int] NULL,
	[conceptoCredito] [int] NULL,
	[sucursalCredito] [int] NULL,
	[cuentaCredito] [bigint] NULL,
	[digitoCredito] [int] NULL,
	[moneda] [int] NULL,
	[sucursalCertificado] [int] NULL,
	[productoCertificado] [int] NULL,
	[sucursalInversora] [int] NULL,
	[cuentaInversora] [bigint] NULL,
	[digitoInversora] [int] NULL,
	[numeroCertificado] [bigint] NULL,
	[codigoUsuario] [nvarchar](10) NULL,
	[senalRenovacion] [nvarchar](2) NULL,
	[codigoAtributoBCRA] [int] NULL,
	[plazoDeposito] [int] NULL,
	[estadoCertificado] [int] NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[documento] [nvarchar](15) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[cbu] [nvarchar](50) NULL,
 CONSTRAINT [PK_4plazoFijoWeb] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4pmdeb]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4pmdeb](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[causal] [int] NULL,
	[tipocta] [nchar](10) NULL,
	[sucursal] [int] NULL,
	[cuenta] [int] NULL,
	[digito] [int] NULL,
	[monto] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4recuperacionCrediticia]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4recuperacionCrediticia](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numeroCuit] [nvarchar](15) NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[cartera] [int] NULL,
	[sucursal] [int] NULL,
	[deudaTotalConsolidada] [money] NULL,
	[deudaTotalVencida] [money] NULL,
	[deudaTotalMME] [money] NULL,
	[segmento] [nvarchar](50) NULL,
	[diasAtrasoPrestamo] [int] NULL,
	[sdoTotPendientePrestamo] [money] NULL,
	[mtoTotalMoraPrestamo] [money] NULL,
	[mmePrestamo] [money] NULL,
	[diasAtrasoTC] [int] NULL,
	[sdoTotalPendienteTC] [money] NULL,
	[mtoTotalMoraTC] [money] NULL,
	[mmeTC] [money] NULL,
	[diasAtrasoGYM] [int] NULL,
	[sdoTotalPendienteGYM] [money] NULL,
	[mtoTotalMoraGYM] [money] NULL,
	[mmeGYM] [money] NULL,
	[capitalGYM] [money] NULL,
	[saldoContableGYM] [money] NULL,
	[diasAtrasoCC] [int] NULL,
	[sdoTotPendienteCC] [money] NULL,
	[mtoTotalMoraCC] [money] NULL,
	[mmeCC] [money] NULL,
	[fallecido] [nvarchar](2) NULL,
	[quiebra] [nvarchar](2) NULL,
	[agencia] [nvarchar](100) NULL,
	[etapa] [nvarchar](50) NULL,
	[situacionBCRA] [int] NULL,
	[proyeccion] [nvarchar](50) NULL,
	[datosEmpleador] [nvarchar](150) NULL,
	[conyuge] [nvarchar](100) NULL,
	[tipoGestion] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4recuperacionCrediticia] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[4saldosClientesMora]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[4saldosClientesMora](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[numeroCuit] [nvarchar](15) NOT NULL,
	[numeroDocumento] [nvarchar](12) NULL,
	[nombre] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[cartera] [int] NULL,
	[diasAtraso] [int] NULL,
	[productoMayorAtraso] [int] NULL,
	[montoTotal] [money] NULL,
	[deudaVencidaTotal] [money] NULL,
	[montoExigible] [money] NULL,
	[mme] [money] NULL,
	[fallecido] [nvarchar](50) NULL,
	[confidencial] [nvarchar](50) NULL,
	[agencia] [nvarchar](50) NULL,
	[etapa] [nvarchar](50) NULL,
	[fechaAltaEtapa] [smalldatetime] NULL,
	[situacionBCRA] [int] NULL,
	[conyuge] [nvarchar](100) NULL,
	[organismo] [nvarchar](50) NULL,
	[empresaHaberes] [nvarchar](100) NULL,
	[tipoGestion] [nvarchar](50) NULL,
	[cantidadCuentas] [int] NULL,
	[saldoCuentas] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_4saldosClientesMora] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5chequesCobradosMorosos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5chequesCobradosMorosos](
	[id] [nvarchar](50) NOT NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[nombreCuenta] [nvarchar](200) NULL,
	[cuilCuenta] [nvarchar](15) NULL,
	[productoCuenta] [int] NULL,
	[depositante] [nvarchar](150) NULL,
	[ordenante] [nvarchar](150) NULL,
	[documentoCobrador] [nvarchar](15) NULL,
	[monto] [money] NULL,
	[fecha] [smalldatetime] NULL,
	[codigoUsuario] [nvarchar](50) NULL,
	[nombreUsuario] [nvarchar](150) NULL,
	[sucursalPago] [int] NULL,
	[cuilDeudor] [nvarchar](15) NULL,
	[diasAtraso] [int] NULL,
	[deuda] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_5chequesCobradosMorosos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5chequesPagadosCaja]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5chequesPagadosCaja](
	[id] [nvarchar](20) NOT NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[causal] [int] NULL,
	[depositante] [nvarchar](150) NULL,
	[ordenante] [nvarchar](150) NULL,
	[monto] [money] NULL,
	[cheque] [nvarchar](10) NULL,
	[sucursalPago] [int] NULL,
	[codigoUsuario] [nvarchar](10) NULL,
	[nombreUsuario] [nvarchar](150) NULL,
	[fecha] [nvarchar](15) NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[cuil] [nvarchar](13) NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_5chequesPagados] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5cuentasSinRestriccion]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5cuentasSinRestriccion](
	[id] [nvarchar](50) NOT NULL,
	[producto] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[restriccionCredito] [int] NULL,
	[clientesRelacionados] [int] NULL,
	[saldoDisponible] [money] NULL,
	[concepto] [int] NULL,
	[fechaFallecimiento] [smalldatetime] NULL,
	[fechaNovedad] [smalldatetime] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_5cuentasSinRestriccion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5movimientosLiquidadosVisa]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5movimientosLiquidadosVisa](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoAdministrador] [nvarchar](4) NULL,
	[codigoBanco] [nvarchar](4) NULL,
	[codigoSucursal] [nvarchar](4) NULL,
	[codigoTransaccion] [nvarchar](5) NULL,
	[nroTarjeta1] [nvarchar](5) NULL,
	[nroTarjeta2] [nvarchar](5) NULL,
 CONSTRAINT [PK_5movimientosLiquidadosVisa] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5movimientosSucursales]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5movimientosSucursales](
	[id] [nchar](10) NULL,
	[sucursalCuenta] [int] NULL,
	[numeroCuenta] [nvarchar](20) NULL,
	[sucursalOrigen] [int] NULL,
	[numeroComprobante] [nvarchar](50) NULL,
	[moneda] [nvarchar](10) NULL,
	[usuario] [nvarchar](15) NULL,
	[supervisor] [nvarchar](15) NULL,
	[concepto] [int] NULL,
	[numeroSecuencia] [int] NULL,
	[categoriaTransaccion] [int] NULL,
	[estadoTransaccion] [int] NULL,
	[tipoTransaccion] [int] NULL,
	[fechaTransaccion] [nvarchar](15) NULL,
	[horaSistema] [nvarchar](15) NULL,
	[montoTransaccion] [money] NULL,
	[equipo] [nvarchar](20) NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5salariosMinimos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5salariosMinimos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[cantidad] [int] NULL,
	[monto] [money] NULL,
 CONSTRAINT [PK_5salariosMinimos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[5tarjetasMalVinculadas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[5tarjetasMalVinculadas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[numeroTarjeta] [nvarchar](20) NULL,
	[tipoCuenta] [int] NULL,
	[numeroCuenta] [nvarchar](20) NULL,
	[numeroDocumento] [nvarchar](13) NULL,
	[estado] [nvarchar](50) NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[tipoTarjeta] [nvarchar](2) NULL,
	[fechaEmisionPlastico] [smalldatetime] NULL,
	[tipoCliente] [nvarchar](2) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_5tarjetasMalVinculadas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6adhesionComercio]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6adhesionComercio](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[tipo] [nvarchar](5) NULL,
	[transaccionCausal] [nvarchar](10) NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[numeroCuenta] [bigint] NULL,
	[digito] [int] NULL,
	[producto] [int] NULL,
	[fechaValor] [date] NULL,
	[monto] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6adhesionComercio] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6adhesionDepositaria]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6adhesionDepositaria](
	[id] [nvarchar](50) NOT NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[numeroCuenta] [bigint] NULL,
	[digito] [int] NULL,
	[fechaTransaccion] [date] NULL,
	[monto] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6adhesionDepositaria] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6bloqueosVigentes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6bloqueosVigentes](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[documento] [nvarchar](11) NULL,
	[tipo] [nvarchar](50) NULL,
	[fechaInicio] [date] NULL,
	[fechaFin] [date] NULL,
	[numero] [nvarchar](15) NULL,
	[monto] [money] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6bloqueosVigentes] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6calificacionesEspeciales]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6calificacionesEspeciales](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](100) NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[producto] [int] NULL,
	[moneda] [int] NULL,
	[fechaAutorizacion] [date] NULL,
	[fechaVencimiento] [date] NULL,
	[montoCalificacion] [money] NULL,
	[montoCredito] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6calificacionesEspeciales] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6chequesRechazados]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6chequesRechazados](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[numeroCuenta] [bigint] NULL,
	[digito] [int] NULL,
	[numeroCheque] [nvarchar](20) NULL,
	[fechaRechazo] [date] NULL,
	[importeCheque] [money] NULL,
	[importeMulta] [money] NULL,
	[importeDebitadoMulta] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6chequesRechazados] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6clientesBE]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6clientesBE](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[tipoCuenta] [nvarchar](20) NULL,
	[documento] [nvarchar](13) NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[estadoCuenta] [nvarchar](30) NULL,
	[fechaApertura] [date] NULL,
	[producto] [int] NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[correo] [nvarchar](100) NULL,
	[telefono] [nvarchar](20) NULL,
	[actividadAFIP] [nvarchar](10) NULL,
	[CBU] [nvarchar](50) NULL,
	[mesDeudaPrevisional] [nvarchar](10) NULL,
	[mesSituacionBCRA] [nvarchar](10) NULL,
	[situacionBCRA] [nvarchar](10) NULL,
	[ultimaFechaPayCheck] [smalldatetime] NULL,
	[siteEmpresa] [nvarchar](5) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6clientesBE] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6embargosVigentes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6embargosVigentes](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[numeroDocumento] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[fechaAlta] [date] NULL,
	[fechaHasta] [date] NULL,
	[monto] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6embargosVigentes] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6haberes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6haberes](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoEmpresa] [nvarchar](13) NULL,
	[documentoEmpresa] [nvarchar](13) NULL,
	[nombreEmpresa] [nvarchar](150) NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[sucursal] [int] NULL,
	[numeroCuenta] [bigint] NULL,
	[digito] [int] NULL,
	[fechaAcreditacion] [date] NULL,
	[monto] [money] NULL,
	[codigoCausal] [int] NULL,
	[codigoTransaccion] [int] NULL,
	[nombreTransaccion] [nvarchar](100) NULL,
	[origen] [nvarchar](50) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6haberesSFB] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6plazosFijos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6plazosFijos](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[fechaOperacion] [date] NULL,
	[plazoDias] [int] NULL,
	[numeroCertificado] [nvarchar](20) NULL,
	[concepto] [int] NULL,
	[moneda] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[fechaVencimiento] [date] NULL,
	[montoDepositado] [money] NULL,
	[montoInteres] [money] NULL,
	[montoPago] [money] NULL,
	[atm] [nvarchar](5) NULL,
	[renovacionAutomatica] [nvarchar](5) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6plazosFijos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6sublimites]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6sublimites](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[codigoLimite] [int] NULL,
	[nombreLimite] [nvarchar](50) NULL,
	[limite] [money] NULL,
	[valorUtilizado] [money] NULL,
	[valorUtilizadoTotal] [money] NULL,
	[fechaAutorizacion] [date] NULL,
	[fechaVencimiento] [date] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6limites] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6valcesin]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6valcesin](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipoMovimiento] [nvarchar](50) NULL,
	[tipoCuenta] [nvarchar](5) NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[documento] [nvarchar](11) NULL,
	[numeroCheque] [nvarchar](11) NULL,
	[fechaPresentacionCamara] [date] NULL,
	[importe] [money] NULL,
	[nombreBanco] [nvarchar](100) NULL,
	[codigoPostal] [bigint] NULL,
	[documentoFirmante] [nvarchar](11) NULL,
	[nombreFirmante] [nvarchar](150) NULL,
	[oficina] [int] NULL,
	[numeroPrestamo] [nvarchar](11) NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6valcesin] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[6valcetot]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[6valcetot](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[documento] [nvarchar](11) NULL,
	[nombre] [nvarchar](150) NULL,
	[total] [money] NULL,
	[limite] [money] NULL,
	[disponible] [money] NULL,
	[situacion] [nvarchar](10) NULL,
	[fechaCendeu] [nvarchar](10) NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_6valcetot] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7ajusteSinReintegro]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7ajusteSinReintegro](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[marca] [nvarchar](50) NULL,
	[cuenta] [nvarchar](20) NULL,
	[concepto] [bigint] NULL,
	[fecha] [smalldatetime] NULL,
	[importe] [money] NULL,
 CONSTRAINT [PK_7ajusteSinReintegro] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7prestamosTC]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7prestamosTC](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[IDCLIENTE] [int] NULL,
	[CUIT] [bigint] NULL,
	[DNI] [bigint] NULL,
	[NOMBRE] [nvarchar](150) NULL,
	[PRODUCTO] [int] NULL,
	[NROPRESTAMO] [int] NULL,
	[VENCIMIENTO] [date] NULL,
	[CAPITALREAL] [money] NULL,
	[SALDOREAL] [money] NULL,
	[SOLICITADO] [money] NULL,
	[FALLECIDO] [date] NULL,
	[MCUENTA] [bigint] NULL,
	[MESTADO] [int] NULL,
	[MMTU] [int] NULL,
	[MSALANT] [money] NULL,
	[MSALACT] [money] NULL,
	[MCODIGO] [bigint] NULL,
	[MFECHA] [date] NULL,
	[MIMPORTE] [money] NULL,
	[MDEUDA] [money] NULL,
	[VCUENTA] [bigint] NULL,
	[VESTADO] [int] NULL,
	[VMTU] [int] NULL,
	[VSALANT] [money] NULL,
	[VSALACT] [money] NULL,
	[VCODIGO] [bigint] NULL,
	[VFECHA] [date] NULL,
	[VIMPORTE] [money] NULL,
	[VDEUDA] [money] NULL,
	[FECHALIQUIDACION] [nchar](10) NULL,
 CONSTRAINT [PK_7prestamosTC] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7regimenConsolidadoMaster]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7regimenConsolidadoMaster](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[mes] [int] NULL,
	[documento] [nvarchar](11) NULL,
	[nombre] [nvarchar](100) NULL,
	[consumos] [money] NULL,
	[ajustes] [money] NULL,
	[consolidado] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_7regimenConsolidadoMaster] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7regimenConsolidadoVisa]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7regimenConsolidadoVisa](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[mes] [int] NULL,
	[documento] [nvarchar](11) NULL,
	[nombre] [nvarchar](100) NULL,
	[consumos] [money] NULL,
	[ajustes] [money] NULL,
	[consolidado] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_7regimenConsolidadoVisa] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7regimenCTTC]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7regimenCTTC](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[mes] [int] NULL,
	[cuenta] [nvarchar](30) NULL,
	[marca] [nvarchar](50) NULL,
	[entidad] [nvarchar](50) NULL,
	[tarjeta] [nvarchar](30) NULL,
	[nombre] [nvarchar](100) NULL,
	[docTipo] [nvarchar](50) NULL,
	[docNro] [nvarchar](20) NULL,
	[relacion] [nvarchar](20) NULL,
	[pesos] [int] NULL,
	[dolar] [int] NULL,
	[dolarPeso] [int] NULL,
	[ajuste] [int] NULL,
	[titularNombre] [nvarchar](100) NULL,
	[titularDocTipo] [nvarchar](50) NULL,
	[titularDocNro] [nvarchar](20) NULL,
	[fechaActualizacion] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_7regimenCTTC] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7regimenITC]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7regimenITC](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[mes] [int] NOT NULL,
	[cuenta] [nvarchar](30) NOT NULL,
	[marca] [nvarchar](50) NOT NULL,
	[entidad] [nvarchar](50) NOT NULL,
	[docTipo] [nvarchar](50) NOT NULL,
	[docNro] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[fechaNacimiento] [nvarchar](50) NOT NULL,
	[tarjeta] [nvarchar](30) NOT NULL,
	[relacion] [int] NOT NULL,
	[fechaActualizacion] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_7regimenITC] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[7reintegroSinAjuste]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[7reintegroSinAjuste](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[causal] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[codigoCliente] [nvarchar](13) NULL,
	[cuentaTarjeta] [nvarchar](20) NULL,
	[fecha] [nvarchar](20) NULL,
	[monto] [money] NULL,
 CONSTRAINT [PK_7reintegroSinAjuste] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[8empleadosBanco]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[8empleadosBanco](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[cuit] [nvarchar](12) NULL,
	[nombre] [nvarchar](100) NULL,
	[legajo] [varchar](10) NULL,
 CONSTRAINT [PK_8empleadosBanco] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[9conciliacionContable]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[9conciliacionContable](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sucursalDestino] [nvarchar](5) NULL,
	[fechaImputacion] [date] NULL,
	[tipoAsiento] [int] NULL,
	[numeroAsiento] [nvarchar](10) NULL,
	[sucursalOrigen] [nvarchar](5) NULL,
	[fechaProceso] [date] NULL,
	[descripcion] [nvarchar](50) NULL,
	[debe] [money] NULL,
	[haber] [money] NULL,
	[origen] [nvarchar](50) NULL,
	[transaccion] [int] NULL,
	[causal] [int] NULL,
	[montoSFB] [money] NULL,
	[fechaActualizacion] [smalldatetime] NULL,
 CONSTRAINT [PK_9conciliacionContable] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[AltasXML]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AltasXML](
	[apellido] [nvarchar](255) NULL,
	[primer_nombre] [nvarchar](255) NULL,
	[segundo_nombre] [nvarchar](255) NULL,
	[documento] [float] NULL,
	[fecha_alta] [nvarchar](255) NULL,
	[producto_activos] [nvarchar](255) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[cartera]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cartera](
	[id_cartera] [int] IDENTITY(1,1) NOT NULL,
	[fecEscCart] [date] NULL,
	[fecInscCart] [date] NULL,
	[datCart] [nvarchar](150) NULL,
	[rutaImgPaga] [nvarchar](150) NULL,
	[prodGtiaCart] [int] NULL,
	[nroGtiaCart] [int] NULL,
	[fecVtoGtiaCart] [date] NULL,
	[montoCart] [numeric](12, 2) NULL,
 CONSTRAINT [PK_cartera] PRIMARY KEY CLUSTERED 
(
	[id_cartera] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[chats]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[chats](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tema] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](100) NULL,
	[fecha] [smalldatetime] NOT NULL,
	[legajo] [nchar](10) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[chatsMensaje]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[chatsMensaje](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[idChat] [int] NOT NULL,
	[mensaje] [nvarchar](250) NOT NULL,
	[nombre] [nvarchar](50) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[chatsParticipante]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[chatsParticipante](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[legajo] [nchar](10) NOT NULL,
	[idChat] [int] NOT NULL,
	[nombre] [nvarchar](50) NOT NULL,
	[estado] [nvarchar](50) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[cuentasComitentes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cuentasComitentes](
	[idCuentaComitente] [int] IDENTITY(1,1) NOT NULL,
	[fechaAccion] [nvarchar](50) NOT NULL,
	[estadoDepositante] [nvarchar](50) NOT NULL,
	[cuentaDepositante] [bigint] NOT NULL,
	[cuentaComitente] [bigint] NOT NULL,
	[cantidadCliente] [bigint] NOT NULL,
	[tipoAccion] [nvarchar](50) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[cuentasComitentesAltas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cuentasComitentesAltas](
	[idCuentasComitentesAltas] [int] IDENTITY(1,1) NOT NULL,
	[idCuentaComitente] [int] NOT NULL,
	[vinculado] [nvarchar](50) NOT NULL,
	[tipoCliente] [nvarchar](50) NULL,
	[cuil] [bigint] NOT NULL,
	[tipoPersona] [nvarchar](50) NOT NULL,
	[apellido] [nvarchar](50) NULL,
	[nombre] [nvarchar](50) NULL,
	[tipoDocumento] [nvarchar](50) NULL,
	[numeroDocumento] [bigint] NULL,
	[genero] [nvarchar](50) NULL,
	[nacionalidad] [nvarchar](50) NULL,
	[paisNacimiento] [nvarchar](50) NULL,
	[lugarNacimiento] [nvarchar](50) NULL,
	[fechaNacimiento] [nvarchar](50) NULL,
	[declaraSerPEP] [nvarchar](50) NULL,
	[denominacion] [nvarchar](50) NULL,
	[fechaConstitucion] [nvarchar](50) NULL,
	[riesgo] [nvarchar](50) NULL,
	[pais] [nvarchar](50) NULL,
	[provincia] [nvarchar](50) NULL,
	[localidad] [nvarchar](50) NULL,
	[calle] [nvarchar](50) NULL,
	[numero] [int] NULL,
	[piso] [int] NULL,
	[departamento] [nvarchar](50) NULL,
	[otroPais] [nvarchar](50) NULL,
	[provinciaEstado] [nvarchar](50) NULL,
	[localidadCiudad] [nvarchar](50) NULL,
	[domicilioDireccion] [nvarchar](50) NULL,
	[codigoPostal] [nvarchar](50) NULL,
	[codigoArea] [int] NULL,
	[telefono] [bigint] NULL,
	[correoElectronico] [nvarchar](50) NULL,
	[naturalezaDelVinculo] [nvarchar](100) NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[cuentasComitentesBajas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cuentasComitentesBajas](
	[idCuentasComitentesBajas] [int] IDENTITY(1,1) NOT NULL,
	[idCuentaComitente] [int] NOT NULL,
	[vinculado] [nvarchar](50) NOT NULL,
	[tipoCliente] [nvarchar](50) NULL,
	[cuil] [bigint] NULL,
	[tipoPersona] [nvarchar](50) NULL,
	[apellido] [nvarchar](50) NULL,
	[nombre] [nvarchar](50) NULL,
	[tipoDocumento] [nvarchar](50) NULL,
	[numeroDocumento] [bigint] NULL,
	[denominacion] [nvarchar](50) NULL,
	[fechaConstitucion] [nvarchar](50) NULL,
	[riesgo] [nvarchar](50) NULL,
	[naturalezaDelVinculo] [nvarchar](100) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[cuentasSinRestriccion]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cuentasSinRestriccion](
	[id] [nvarchar](50) NOT NULL,
	[producto] [int] NULL,
	[sucursal] [int] NULL,
	[cuenta] [bigint] NULL,
	[digito] [int] NULL,
	[numeroCliente] [nvarchar](13) NULL,
	[nombreCliente] [nvarchar](150) NULL,
	[nombreCuenta] [nvarchar](150) NULL,
	[restriccionCredito] [int] NULL,
	[clientesRelacionados] [nchar](10) NULL,
	[saldoDisponible] [money] NULL,
	[concepto] [int] NULL,
	[fechaFallecimiento] [smalldatetime] NULL,
	[fechaNovedad] [smalldatetime] NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[estado]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[estado](
	[id_estado] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NULL,
	[descripcion] [nvarchar](100) NULL,
 CONSTRAINT [PK_estado] PRIMARY KEY CLUSTERED 
(
	[id_estado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fianza]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fianza](
	[id_fianza] [int] IDENTITY(1,1) NOT NULL,
	[datAcue] [nvarchar](150) NULL,
	[datFiad] [nvarchar](150) NULL,
	[fecInscFia] [date] NULL,
	[fecEscFia] [date] NULL,
	[montoFia] [numeric](12, 2) NULL,
	[prodGtiaFia] [int] NULL,
	[nroGtiaFia] [int] NULL,
	[fecVtoGtiaFia] [date] NULL,
 CONSTRAINT [PK_fianza] PRIMARY KEY CLUSTERED 
(
	[id_fianza] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[garantia]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[garantia](
	[id_garantia] [int] IDENTITY(1,1) NOT NULL,
	[id_cartera] [int] NULL,
	[id_fianza] [int] NULL,
	[id_hipoteca] [int] NULL,
	[id_leasing] [int] NULL,
	[id_prenda] [int] NULL,
	[descProd] [nvarchar](150) NULL,
	[estado] [nvarchar](150) NULL,
	[entGtia] [nvarchar](150) NULL,
	[fecAltaOpe] [date] NULL,
	[fecVtoOpe] [date] NULL,
	[gesCan] [nvarchar](150) NULL,
	[moneda] [int] NULL,
	[nomCli] [nvarchar](150) NULL,
	[nroCli] [int] NULL,
	[prodCred] [int] NULL,
	[observacion] [nvarchar](150) NULL,
	[oriGtia] [nvarchar](2) NULL,
	[opeRela] [int] NULL,
	[sav] [int] NULL,
	[sucursal] [int] NULL,
	[valNomi] [numeric](12, 2) NULL,
 CONSTRAINT [PK_garantia] PRIMARY KEY CLUSTERED 
(
	[id_garantia] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[hipoteca]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[hipoteca](
	[id_hipoteca] [int] IDENTITY(1,1) NOT NULL,
	[cotizaHip] [numeric](12, 2) NULL,
	[datGtiaHip] [nvarchar](150) NULL,
	[deudorHip] [nvarchar](150) NULL,
	[escDomHip] [int] NULL,
	[fecInscHip] [date] NULL,
	[fecVtoGtiaHip] [date] NULL,
	[nomSegHip] [nvarchar](50) NULL,
	[nroGtiaHip] [int] NULL,
	[nroInscHip] [int] NULL,
	[prodGtiaHip] [int] NULL,
	[vtoSegHip] [nvarchar](50) NULL,
	[montoHip] [numeric](12, 2) NULL,
 CONSTRAINT [PK_hipoteca] PRIMARY KEY CLUSTERED 
(
	[id_hipoteca] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[imagenesCartera]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[imagenesCartera](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ruta] [nvarchar](300) NULL,
	[idCartera] [int] NULL,
	[tipo] [nchar](10) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[imagenesFianza]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[imagenesFianza](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ruta] [nvarchar](300) NULL,
	[idFianza] [int] NULL,
	[tipo] [nchar](10) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[imagenesHipoteca]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[imagenesHipoteca](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ruta] [nvarchar](300) NULL,
	[idHipoteca] [int] NULL,
	[tipo] [nchar](10) NULL,
 CONSTRAINT [PK_imagenesHipoteca] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[imagenesLeasing]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[imagenesLeasing](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ruta] [nvarchar](300) NULL,
	[idLeasing] [int] NULL,
	[tipo] [nchar](10) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[imagenesPrenda]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[imagenesPrenda](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ruta] [nvarchar](300) NULL,
	[idPrenda] [int] NULL,
	[tipo] [nchar](10) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[leasing]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[leasing](
	[id_leasing] [int] IDENTITY(1,1) NOT NULL,
	[nroInscLea] [int] NULL,
	[nomSegLea] [nvarchar](150) NULL,
	[vtoSegLea] [nvarchar](150) NULL,
	[cotizaLea] [numeric](12, 2) NULL,
	[fecEscLea] [date] NULL,
	[datGtiaLea] [nvarchar](150) NULL,
	[prodGtiaLea] [int] NULL,
	[nroGtiaLea] [int] NULL,
	[fecVtoGtiaLea] [date] NULL,
	[montoLea] [numeric](12, 2) NULL,
 CONSTRAINT [PK_leasing] PRIMARY KEY CLUSTERED 
(
	[id_leasing] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[logs]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[logs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipo] [nvarchar](50) NOT NULL,
	[legajo] [nvarchar](10) NOT NULL,
	[usuario] [nvarchar](50) NOT NULL,
	[rol] [nvarchar](50) NOT NULL,
	[operacion] [nvarchar](50) NOT NULL,
	[detalle] [nvarchar](500) NOT NULL,
	[fecha] [smalldatetime] NOT NULL,
 CONSTRAINT [PK_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[permiso]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[permiso](
	[id_permiso] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NULL,
 CONSTRAINT [PK_permiso] PRIMARY KEY CLUSTERED 
(
	[id_permiso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[prenda]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[prenda](
	[id_prenda] [int] IDENTITY(1,1) NOT NULL,
	[nomSegPre] [nvarchar](150) NULL,
	[vtoSegPre] [nvarchar](50) NULL,
	[cotizaPre] [numeric](12, 2) NULL,
	[deudorPre] [nvarchar](150) NULL,
	[datGtiaPre] [nvarchar](150) NULL,
	[fecEscPre] [date] NULL,
	[fecVtoGtiaPre] [date] NULL,
	[nroGtiaPre] [int] NULL,
	[nroInscPre] [int] NULL,
	[prodGtiaPre] [int] NULL,
	[montoPre] [numeric](12, 2) NULL,
 CONSTRAINT [PK_prenda] PRIMARY KEY CLUSTERED 
(
	[id_prenda] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rol]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rol](
	[id_rol] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](50) NULL,
	[link] [nvarchar](50) NULL,
 CONSTRAINT [PK_rol] PRIMARY KEY CLUSTERED 
(
	[id_rol] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rol_permiso]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rol_permiso](
	[id_rol] [int] NULL,
	[id_permiso] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rte_operacion]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rte_operacion](
	[idOperacion] [int] IDENTITY(1,1) NOT NULL,
	[cuenta] [nvarchar](12) NULL,
	[fecha] [date] NULL,
	[tipo] [nvarchar](50) NULL,
	[moneda] [nvarchar](50) NULL,
	[montoMo] [nvarchar](50) NULL,
	[montoPesos] [nvarchar](50) NULL,
	[numeroPersonas] [int] NULL,
	[provincia] [nvarchar](100) NULL,
	[localidad] [nvarchar](100) NULL,
	[calle] [nvarchar](100) NULL,
	[numero] [nvarchar](100) NULL,
 CONSTRAINT [PK_rte_operacion_1] PRIMARY KEY CLUSTERED 
(
	[idOperacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rte_sujeto]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rte_sujeto](
	[idSujeto] [int] IDENTITY(1,1) NOT NULL,
	[idOperacion] [int] NOT NULL,
	[relacionFondo] [nvarchar](50) NULL,
	[relacionProducto] [nvarchar](50) NULL,
	[cuit] [nvarchar](20) NULL,
	[tipoPersona] [nvarchar](20) NULL,
	[apellidos] [nvarchar](100) NULL,
	[nombres] [nvarchar](100) NULL,
	[tipoDocumento] [nvarchar](50) NULL,
	[numeroDocumento] [nvarchar](15) NULL,
 CONSTRAINT [PK_rte_sujeto] PRIMARY KEY CLUSTERED 
(
	[idSujeto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rte_transaccion]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rte_transaccion](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[concepto] [int] NULL,
	[cuenta] [nvarchar](20) NULL,
	[referencia] [nvarchar](20) NULL,
	[fecha] [smalldatetime] NULL,
	[tipo] [nvarchar](20) NULL,
	[moneda] [nvarchar](30) NULL,
	[montoOrigen] [int] NULL,
	[montoPesos] [int] NULL,
	[numeroPersonas] [int] NULL,
	[provincia] [nvarchar](100) NULL,
	[localidad] [nvarchar](100) NULL,
	[calle] [nvarchar](100) NULL,
	[numero] [nvarchar](20) NULL,
 CONSTRAINT [PK_rte_transaccion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[rte_vinculado]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[rte_vinculado](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[referencia] [nvarchar](20) NULL,
	[relacionFondo] [nvarchar](50) NULL,
	[relacionProducto] [nvarchar](10) NULL,
	[cuil] [nvarchar](20) NULL,
	[tipoPersona] [nvarchar](20) NULL,
	[apellido] [nvarchar](100) NULL,
	[nombre] [nvarchar](100) NULL,
	[tipoDocumento] [nvarchar](50) NULL,
	[numeroDocumento] [nvarchar](15) NULL,
 CONSTRAINT [PK_rte_vinculado] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[SMVM]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SMVM](
	[saldo] [money] NOT NULL,
	[fechaActualizacion] [smalldatetime] NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[transaccion]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[transaccion](
	[idTransaccion] [int] IDENTITY(1,1) NOT NULL,
	[fecha] [nvarchar](50) NOT NULL,
	[provincia] [nvarchar](50) NOT NULL,
	[localidad] [nvarchar](50) NOT NULL,
	[calle] [nvarchar](50) NOT NULL,
	[numero] [int] NOT NULL,
	[operacion] [nvarchar](50) NOT NULL,
	[transaccion] [nvarchar](50) NOT NULL,
	[moneda] [nvarchar](50) NOT NULL,
	[monto] [bigint] NOT NULL,
	[equivalente] [bigint] NOT NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[turnero]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[turnero](
	[fechaInicio] [datetime] NULL,
	[fechaFin] [datetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[upTimeDiario]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[upTimeDiario](
	[cajero] [nvarchar](100) NULL,
	[neutral] [nvarchar](100) NULL,
	[fueraMedicion] [nvarchar](100) NULL,
	[UPT] [nvarchar](100) NULL,
	[dispens] [nvarchar](100) NULL,
	[HWCASS] [nvarchar](100) NULL,
	[dinero] [nvarchar](100) NULL,
	[insumos] [nvarchar](100) NULL,
	[comunic] [nvarchar](100) NULL,
	[otrosHW] [nvarchar](100) NULL,
	[deposito] [nvarchar](100) NULL,
	[superv] [nvarchar](100) NULL,
	[openST] [nvarchar](100) NULL,
	[presHOP1] [nvarchar](100) NULL,
	[presHOP2] [nvarchar](100) NULL,
	[presHOP3] [nvarchar](100) NULL,
	[presHOP4] [nvarchar](100) NULL,
	[tiempoOperativo] [nvarchar](100) NULL,
	[fechaActualizacion] [smalldatetime] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[upTimeDiario_tmp]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[upTimeDiario_tmp](
	[cajero] [nvarchar](100) NULL,
	[neutral] [nvarchar](100) NULL,
	[fueraMedicion] [nvarchar](100) NULL,
	[UPT] [nvarchar](100) NULL,
	[dispens] [nvarchar](100) NULL,
	[HWCASS] [nvarchar](100) NULL,
	[dinero] [nvarchar](100) NULL,
	[insumos] [nvarchar](100) NULL,
	[comunic] [nvarchar](100) NULL,
	[otrosHW] [nvarchar](100) NULL,
	[deposito] [nvarchar](100) NULL,
	[superv] [nvarchar](100) NULL,
	[openST] [nvarchar](100) NULL,
	[presHOP1] [nvarchar](100) NULL,
	[presHOP2] [nvarchar](100) NULL,
	[presHOP3] [nvarchar](100) NULL,
	[presHOP4] [nvarchar](100) NULL,
	[tiempoOperativo] [nvarchar](100) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[usuario]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario](
	[legajo] [nchar](5) NOT NULL,
	[nombre] [nvarchar](100) NULL,
	[id_rol] [int] NULL,
 CONSTRAINT [PK_usuario] PRIMARY KEY CLUSTERED 
(
	[legajo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[vinculado]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[vinculado](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[operador] [nvarchar](50) NOT NULL,
	[identificacion] [nvarchar](50) NOT NULL,
	[cuit] [bigint] NOT NULL,
	[tipo] [nvarchar](50) NOT NULL,
	[apellidoDenominacion] [nvarchar](50) NOT NULL,
	[nombre] [nvarchar](50) NULL,
	[tipoDocumento] [nvarchar](50) NULL,
	[numeroDocumento] [bigint] NULL,
	[idTransaccion] [int] NOT NULL
) ON [PRIMARY]

GO
/****** Object:  View [dbo].[recuperacionCrediticia]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE VIEW [dbo].[recuperacionCrediticia]
as

SELECT DISTINCT REC.*, 
	   CNA.saldoTerceros, 
	   MTA.marca, 
	   MTA.cuentaTarjeta, 
	   COB.cobranzasTanqueSFB, 
	   MPR.productoPrestamo,
	   MPR.carpeta,
	   MPR.formaPago,
	   CMO.saldoCuentas,
	   CMO.organismo
FROM [dbo].[4recuperacionCrediticia] REC
LEFT JOIN (SELECT SUM(saldoTerceros) saldoTerceros, 
				  numeroCliente 
		   FROM [dbo].[4cobroNoAplicado] GROUP BY numeroCliente) CNA ON CNA.numeroCliente = RIGHT('000000000000' + REC.numeroCliente, 13)
LEFT JOIN (SELECT documento, cuentaTarjeta, marca, mora, ROW_NUMBER() over (partition by documento order by mora desc) orden 
			FROM [dbo].[4moraTarjetas]) MTA ON MTA.documento = REC.numeroCuit AND MTA.orden = 1
LEFT JOIN (SELECT numeroCliente, 
	   producto productoPrestamo,
	   diasMora, 
	   carpeta,
	   (CASE WHEN carpeta = 0 THEN 'Debito en cuenta' 
			 WHEN carpeta IS NULL THEN 'Debito en cuenta' 
			 ELSE 'Descuento por recibo' 
	   END) formaPago,
	   ROW_NUMBER() over (partition by numeroCliente order by diasMora desc) orden
FROM [dbo].[4moraPrestamos]) MPR ON MPR.numeroCliente = RIGHT('000000000000' + REC.numeroCliente, 13) AND MPR.orden = 1
LEFT JOIN [dbo].[4cobranzasTC] COB ON COB.cuentaTarjeta = MTA.cuentaTarjeta
LEFT JOIN [dbo].[4saldosClientesMora] CMO ON CMO.numeroCliente = REC.numeroCliente


GO
/****** Object:  View [dbo].[moraComercial]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[moraComercial]
AS

	SELECT RIGHT('000000000000' + MO.numeroCliente, 13) numeroCliente, 
		   MO.numeroCuit,
		   MO.nombreCliente, 
		   MO.sucursal, 
		   SC.diasAtraso,
		   MO.deudaTotalConsolidada montoTotal,
		   MO.deudaTotalVencida montoExigible,
		   MO.deudaTotalMME MME,
		   CC.producto, 
		   (CASE WHEN MO.cartera = 1 THEN 'COMERCIAL' 
		        WHEN MO.cartera = 2 THEN 'COMERCIAL' 
				ELSE 'CONSUMO'
		   END) cartera,
		   MO.proyeccion
	FROM [dbo].[recuperacionCrediticia] MO  
	LEFT JOIN [dbo].[4cuentasCorrientes] CC on RIGHT('000000000000' + MO.numeroCliente, 13) = CC.numeroCliente
	LEFT JOIN [dbo].[4saldosClientesMora] SC ON  MO.numeroCliente = SC.numeroCliente
	WHERE MO.proyeccion <> '1 - 1' AND 
		  (MO.cartera in (1, 2) OR (MO.cartera = 3 AND CC.producto <> 153)) AND 
		  MO.deudaTotalMME <> 0.00 AND 
		  MO.fallecido <> 'SI' AND 
		  MO.tipoGestion <> 'LEGALES' AND 
		  MO.numeroCliente <> 1000000


GO
/****** Object:  View [dbo].[adhesionComercioHistorica]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE VIEW [dbo].[adhesionComercioHistorica]
as

SELECT DISTINCT ADH.codigoCliente,
	   ADH.nombreCuenta,
	   ADH.sucursal,
	   ADH.numeroCuenta, 
	   ADH.digito, 
	   ADH.producto,
	   ADH.fechaValor,
	   MAE.totalMaestro,
	   MAS.totalMaster,
	   VIS.totalVisa
FROM [dbo].[6adhesionComercio] ADH
LEFT JOIN (SELECT RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
				  SUM(monto) totalMaestro,
				  fechaValor fecha
		   FROM [dbo].[6adhesionComercio]
		   WHERE transaccionCausal IN (220150, 221150)
		   GROUP BY RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR), fechaValor) MAE 
ON MAE.cuenta = RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) AND 
   MAE.fecha = ADH.fechaValor
LEFT JOIN (SELECT RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
				   SUM(monto) totalMaster,
				   fechaValor fecha
			FROM [dbo].[6adhesionComercio]
			WHERE transaccionCausal = 220151
			GROUP BY RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR), fechaValor ) MAS 
ON MAS.cuenta = RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) AND 
   MAS.fecha = ADH.fechaValor 
LEFT JOIN (SELECT RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
	   SUM(monto) totalVisa,
	   fechaValor fecha
FROM [dbo].[6adhesionComercio]
WHERE transaccionCausal = 220152
GROUP BY RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR), fechaValor ) VIS ON VIS.cuenta =  RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) AND VIS.fecha = ADH.fechaValor
WHERE ADH.tipo = 'CA'
union all
SELECT DISTINCT ADH.codigoCliente,
	   ADH.nombreCuenta,
	   ADH.sucursal,
	   ADH.numeroCuenta, 
	   ADH.digito, 
	   ADH.producto,
	   ADH.fechaValor,
	   MAE.totalMaestro,
	   MAS.totalMaster,
	   VIS.totalVisa
FROM [dbo].[6adhesionComercio] ADH
LEFT JOIN (SELECT RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
				   SUM(monto) totalMaestro,
				   fechaValor fecha
			FROM [dbo].[6adhesionComercio]
			WHERE transaccionCausal IN (100150, 120150, 121150)
			GROUP BY RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR), fechaValor) MAE 
ON MAE.cuenta = RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) AND 
   MAE.fecha = ADH.fechaValor
LEFT JOIN (SELECT RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
				   SUM(monto) totalMaster,
				   fechaValor fecha
			FROM [dbo].[6adhesionComercio]
			WHERE transaccionCausal IN (100151, 120151, 121151)
			GROUP BY RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR), fechaValor) MAS 
ON MAS.cuenta = RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) AND 
   MAS.fecha = ADH.fechaValor 
LEFT JOIN (SELECT RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
				   SUM(monto) totalVisa,
				   fechaValor fecha
			FROM [dbo].[6adhesionComercio]
			WHERE transaccionCausal IN (100152, 120152)
			GROUP BY RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR), fechaValor) VIS 
ON VIS.cuenta =  RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) AND 
   VIS.fecha = ADH.fechaValor
WHERE ADH.tipo = 'CC'


GO
/****** Object:  View [dbo].[adhesionComercioMesActual]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[adhesionComercioMesActual]
as
select distinct ADH.codigoCliente,
	   ADH.nombreCuenta,
	   ADH.sucursal,
	   ADH.numeroCuenta,
	   ADH.digito,
	   ADH.producto,
	   TOT.totalMaestro,
	   TOT.totalMaster,
	   TOT.totalVisa
from [dbo].[adhesionComercioHistorica] ADH
inner join (select RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR) cuenta,
			   SUM(totalMaestro) totalMaestro,
			   SUM(totalMaster) totalMaster,
			   SUM(totalVisa) totalVisa
		from [dbo].[adhesionComercioHistorica] 
		where CAST(fechaValor AS DATE) >= CAST(DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AS DATE)
		group by RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR)) TOT 
ON TOT.cuenta = RIGHT('0' + CAST(sucursal as NVARCHAR) , 2) + RIGHT('000000' + CAST(numeroCuenta as NVARCHAR) , 6)+CAST(digito as NVARCHAR)


GO
/****** Object:  View [dbo].[adhesionDepositariaMesActual]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE VIEW [dbo].[adhesionDepositariaMesActual]
as
SELECT DISTINCT ADH.codigoCliente, 
	   ADH.nombreCuenta, 
	   ACU.nroMovimientos,
	   ACU.sumaMensual
FROM [dbo].[6adhesionDepositaria] ADH
INNER JOIN (SELECT codigoCliente, 
					COUNT(codigoCliente) nroMovimientos,
					SUM(monto) sumaMensual
			FROM [dbo].[6adhesionDepositaria] 
			WHERE CAST(fechaTransaccion AS DATE) >= CAST(DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AS DATE)
			GROUP BY codigoCliente) ACU ON ACU.codigoCliente = ADH.codigoCliente

GO
/****** Object:  View [dbo].[chequesRechazados]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[chequesRechazados]
as
SELECT DISTINCT CHE.codigoCliente, 
	   CHE.nombreCliente,
	   REC.nroRechazos,
	   IMP.nroImpagos
FROM [dbo].[6chequesRechazados] CHE
INNER JOIN (SELECT codigoCliente, COUNT(*) nroRechazos 
			FROM [dbo].[6chequesRechazados] 
			GROUP BY codigoCliente) REC ON REC.codigoCliente = CHE.codigoCliente
LEFT JOIN (SELECT codigoCliente, COUNT(*) nroImpagos 
			FROM [dbo].[6chequesRechazados] 
			WHERE importeDebitadoMulta < importeMulta
			GROUP BY codigoCliente) IMP ON IMP.codigoCliente = CHE.codigoCliente



GO
/****** Object:  View [dbo].[embargosVigentes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[embargosVigentes]
as
SELECT codigoCliente, 
	   nombreCliente,
	   COUNT(*) nroEmbargos, 
	   SUM(monto) montoTotal
FROM [bd_sib].[dbo].[6embargosVigentes] 
GROUP BY codigoCliente, nombreCliente
GO
/****** Object:  View [dbo].[limites]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[limites]
as
SELECT codigoCliente, 
	   SUM(limite) limite, 
	   SUM(valorUtilizado) valorUtilizado, 
	   SUM(valorUtilizadoTotal) valorUtilizadoTotal 
FROM [dbo].[6sublimites] 
GROUP BY codigoCliente
GO
/****** Object:  View [dbo].[pagoHaberesEmpresas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO





CREATE view [dbo].[pagoHaberesEmpresas]
AS

SELECT DISTINCT HAB.codigoEmpresa,
	   HAB.documentoEmpresa,
	   HAB.nombreEmpresa,
	   HAB.origen,
	   TOT.ultimoPago,
	   TOT.montoTotal
FROM [dbo].[6haberes] HAB
INNER JOIN (SELECT codigoEmpresa, 
				   SUM(monto) montoTotal,
				   MAX(fechaAcreditacion) ultimoPago
			FROM  [dbo].[6haberes] 
			WHERE origen = 'HABERES DE SFB'
			GROUP BY codigoEmpresa) TOT ON TOT.codigoEmpresa = HAB.codigoEmpresa
WHERE  HAB.origen = 'HABERES DE SFB'
UNION ALL
SELECT DISTINCT HAB.codigoEmpresa,
	   HAB.documentoEmpresa,
	   HAB.nombreEmpresa,
	   HAB.origen,
	   TOT.ultimoPago,
	   TOT.montoTotal
FROM [dbo].[6haberes] HAB
INNER JOIN (SELECT documentoEmpresa, 
				   SUM(monto) montoTotal,
				   MAX(fechaAcreditacion) ultimoPago
			FROM  [dbo].[6haberes] 
			WHERE origen = 'INTERBANKING'
			GROUP BY documentoEmpresa) TOT ON TOT.documentoEmpresa = HAB.documentoEmpresa
WHERE  HAB.origen = 'INTERBANKING'


GO
/****** Object:  View [dbo].[integradorBancaEmpresa]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE view [dbo].[integradorBancaEmpresa]
as
SELECT DISTINCT CLI.id,
	   CLI.tipoCuenta,
	   CLI.documento, 
	   CLI.codigoCliente,
	   CLI.sucursal,
	   CLI.cuenta,
	   CLI.digito,
	   CLI.producto,
	   CLI.nombreCuenta,
	   CLI.estadoCuenta,
	   CLI.fechaApertura,
	   CLI.correo,
	   CLI.telefono,
	   CLI.actividadAFIP,
	   CLI.cbu,
	   CLI.mesDeudaPrevisional,
	   CLI.mesSituacionBCRA,
	   CLI.situacionBCRA,
	   CLI.ultimaFechaPayCheck,
	   CLI.siteEmpresa,
	   ADE.nroMovimientos adhMovimientos, 
	   ADE.sumaMensual adhSumaMensual,
	   REC.nroRechazos chequesRechazados,
	   REC.nroImpagos chequesImpagos,
	   MCO.diasAtraso,
	   MCO.montoTotal,
	   MCO.montoExigible,
	   MCO.MME,
	   LIM.limite,
	   LIM.valorUtilizado,
	   LIM.valorUtilizadoTotal,
	   EMB.nroEmbargos embargos,
	   EMB.montoTotal embMontoTotal,
	   BLO.cantidad numeroBloqueos,
	   ADC.totalMaestro adcTotalMaestro,
	   ADC.totalMaster adcTotalMaster,
	   ADC.totalVisa adcTotalVisa,
	   MHA.montoTotal totalHaberesSFB,
	   ING.montoTotal totalInterbanking,
	   VAL.disponible
FROM [dbo].[6clientesBE] CLI
LEFT JOIN [dbo].[adhesionDepositariaMesActual] ADE ON ADE.codigoCliente = CLI.codigoCliente
LEFT JOIN [dbo].[chequesRechazados] REC ON REC.codigoCliente = CLI.codigoCliente
LEFT JOIN [dbo].[moraComercial] MCO ON MCO.numeroCliente = CLI.codigoCliente
LEFT JOIN [dbo].[limites] LIM ON LIM.codigoCliente = CLI.codigoCliente AND LIM.limite <> 0.00
LEFT JOIN [dbo].[embargosVigentes] EMB ON EMB.codigoCliente = CLI.codigoCliente
LEFT JOIN (SELECT codigoCliente, count(*) cantidad 
           FROM [6bloqueosVigentes] 
		   GROUP BY codigoCliente) BLO ON BLO.codigoCliente = CLI.codigoCliente
LEFT JOIN [dbo].[adhesionComercioMesActual] ADC ON ADC.sucursal = CLI.sucursal AND ADC.numeroCuenta = CLI.cuenta AND ADC.digito = CLI.digito
LEFT JOIN (SELECT codigoEmpresa, montoTotal FROM [dbo].[pagoHaberesEmpresas] where origen = 'HABERES DE SFB') MHA ON MHA.codigoEmpresa = CLI.codigoCliente
LEFT JOIN (SELECT documentoEmpresa, montoTotal FROM [dbo].[pagoHaberesEmpresas] where origen = 'INTERBANKING') ING ON ING.documentoEmpresa = CLI.documento 
LEFT JOIN [dbo].[6valcetot] VAL ON VAL.documento = CLI.documento

GO
/****** Object:  View [dbo].[adhesionDepositariaHistorica]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[adhesionDepositariaHistorica]
as
SELECT DISTINCT ADH.codigoCliente, 
	   ADH.nombreCuenta, 
	   ACU.nroMovimientos,
	   ACU.sumatoria,
	   ACU.fechaTransaccion
FROM [dbo].[6adhesionDepositaria] ADH
INNER JOIN (SELECT codigoCliente, 
				   COUNT(codigoCliente) nroMovimientos,
				   SUM(monto) sumatoria,
				   fechaTransaccion
			FROM [dbo].[6adhesionDepositaria] 
			GROUP BY codigoCliente, fechaTransaccion) ACU ON ACU.codigoCliente = ADH.codigoCliente
GO
/****** Object:  View [dbo].[autorizacionChequesEnCamara]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[autorizacionChequesEnCamara]
as
select 
	TITULAR,
	SUCURSAL,
	CUENTA,
	DIGITO,
	CHEQUE,
	IMPORTE,
	SALDO,
	BLOQUEO,
	ACUERDO,
	SUM(IMPORTE) OVER( PARTITION BY IDCUENTA ORDER BY CHEQUE ASC) as IMPORTEACU,
	SALDO - SUM(IMPORTE)OVER( PARTITION BY IDCUENTA ORDER BY CHEQUE ASC) SALDOCAL
from openquery(M4000SF, 'SELECT DISTINCT CONCAT(MCH.VCO_OFICI, CONCAT(MCH.VCUNUMCUE, MCH.VCUDIGVER)) IDCUENTA,
								MOL.CNO_CUENT TITULAR,
								MCH.VCO_OFICI SUCURSAL, 
								MCH.VCUNUMCUE CUENTA, 
								MCH.VCUDIGVER DIGITO, 
								MCH.VNU_CHEQU CHEQUE,
								MCH.VIM_CHEQU IMPORTE,
								MOL.CSATOTHOY SALDO,
								MOL.CSA_PROTE BLOQUEO,
								MAC.CMO_ACUER ACUERDO
						FROM SFB_AVMCH MCH
						LEFT JOIN SFB_ACMOL MOL ON MOL.CCU_OFICI = VCO_OFICI AND 
													MOL.CCUNUMCUE = MCH.VCUNUMCUE AND
													MOL.CCUDIGVER = MCH.VCUDIGVER 
						LEFT JOIN SFB_ACMAC MAC ON MAC.CCU_OFICI = VCO_OFICI AND 
													MAC.CCUNUMCUE = MCH.VCUNUMCUE AND
													MAC.CCUDIGVER = MCH.VCUDIGVER AND
													MAC.CCOESTACU = 2 AND MAC.CCOTIPACU <> 99
						WHERE MCH.VSE_PROCE = ''N'' AND VCOTIPCAN = 51')
GO
/****** Object:  View [dbo].[cobrosNoAplicados]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[cobrosNoAplicados]
AS

select * from openquery(M4000SF,'SELECT MAP.GLB_DTIME ID,
										MAP.PCU_PRODU PRODUCTO, 
										MAP.ACU_OFICI SUCURSAL, 
										MAP.ACUNUMCUE CUENTA, 
										MAP.ACUDIGVER DIGITO, 
										MAP.PCOESTCUE ESTADO, 
										MAP.PCU_MONED MONEDA, 
										MAP.PCU_OFICI SUCCREDITO, 
										MAP.PCUNUMCUE CTACREDITO, 
										MAP.PSA_TERCE SALDOSTERCEROS, 
										MAP.SCO_IDENT NROCLIENTE,
										MCL.SNO_CLIEN NOMBRECLIENTE
								 FROM SFB_PPMAP MAP 
								 INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = MAP.SCO_IDENT
								 WHERE MAP.PCOESTCUE = 1 AND MAP.PSA_TERCE <> 0.00 AND MAP.PCU_PRODU IN (443, 457, 458, 957)')


GO
/****** Object:  View [dbo].[codigoPostalInconsistente]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[codigoPostalInconsistente]
AS

select * from openquery(M4000SF, 'SELECT MDI.GLB_DTIME ID,
										 MDI.SCO_IDENT NROCLIENTE,
										 MCL.SNO_CLIEN NOMCLIENTE,
										 MDI.SCO_POSTA CODPOSTAL,
										 MDI.CODPOSCPA CODCPA,
										 MDI.SNOUSUADI CODUSUCRE,
										 MDI.SNOUSUMOD CODUSUMOD
									 FROM SFB_BSMDI MDI
									 INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = MDI.SCO_IDENT
									 WHERE LENGTH(MDI.SCO_POSTA) < 4 AND LENGTH(MDI.CODPOSCPA) < 8')


GO
/****** Object:  View [dbo].[conciliacionContable]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[conciliacionContable]
as
SELECT CON.id,
	   CON.sucursalDestino,
	   CON.fechaImputacion,
	   CON.tipoAsiento,
	   CON.numeroAsiento,
	   CON.sucursalOrigen,
	   CON.fechaProceso,
	   CON.descripcion,
	   (CASE WHEN DEB.debe IS NULL THEN 0 ELSE DEB.debe END) debe,
	   (CASE WHEN CON.haber IS NULL THEN 0 ELSE CON.haber END) haber,
	   ABS((CASE WHEN DEB.debe IS NULL THEN 0 ELSE DEB.debe END) - (CASE WHEN CON.haber IS NULL THEN 0 ELSE CON.haber END)) diferencia,
	   CON.origen,
	   CON.transaccion,
	   CON.causal,
	   CON.fechaActualizacion
FROM [bd_sib].[dbo].[9conciliacionContable] CON
LEFT JOIN (SELECT id, debe
			FROM [dbo].[9conciliacionContable] 
			WHERE debe is not null
			UNION ALL
			SELECT id, montoSFB
			FROM [dbo].[9conciliacionContable] 
			WHERE montoSFB is not null) DEB ON DEB.id = CON.id
GO
/****** Object:  View [dbo].[correosElectronicos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE VIEW [dbo].[correosElectronicos] 
AS  
select * from openquery([192.168.250.134],'SELECT MDI.SCO_IDENT codigoCliente,
										MCL.SNO_CLIEN nombreCliente,
										MDI.SCO_EMAIL correo,
										AH.HCU_OFICI sucursal, 
										AH.HCUNUMCUE cuenta, 
										AH.HCUDIGVER digito,
										''CA'' tipo
								 FROM DWH.DBO.SFB_BSMDI MDI
								 LEFT JOIN DWH.DBO.SFB_BSMCL MCL ON MCL.SCO_IDENT = MDI.SCO_IDENT
								 LEFT JOIN DWH.DBO.SFB_AHMOL AH  ON AH.SCO_IDENT = MDI.SCO_IDENT
								 WHERE MDI.SCO_IDENT <> ''0000001000000'' AND MDI.SNU_DIREC = 1 AND MDI.SCO_EMAIL NOT IN ('' '',
																				   ''  '',
																				   '','',
																				   ''a@a.com'',
																				   ''A@A.COM'',
																				   ''A@HOTMAIL.COM'',
																				   ''a@hotmail.com'',
																				   ''NO POSEE'',
																				   ''no posee'',
																				   ''no tiene@gmail.com'',
																				   ''NO@BSC.COM'',
																				   ''NO@DECLARA.COM'',
																				   ''no@declara.com'',
																				   ''nodeclara@hotmail.com'',
																				   ''nodeclara@nodeclara.com'',
																				   '' noposeecorreo@yahoo.com'')  
								 UNION
								 SELECT MDI.SCO_IDENT codigoCliente,
										MCL.SNO_CLIEN nombreCliente,
										MDI.SCO_EMAIL correo,
										AC.CCU_OFICI sucursal, 
										AC.CCUNUMCUE cuenta, 
										AC.CCUDIGVER digito, 
										''CC'' tipo
								 FROM DWH.DBO.SFB_BSMDI MDI
								 LEFT JOIN DWH.DBO.SFB_BSMCL MCL ON MCL.SCO_IDENT = MDI.SCO_IDENT
								 LEFT JOIN DWH.DBO.SFB_ACMOL AC  ON AC.SCO_IDENT = MDI.SCO_IDENT
								 WHERE MDI.SCO_IDENT <> ''0000001000000'' AND MDI.SNU_DIREC = 1 AND MDI.SCO_EMAIL NOT IN ('' '',
																				   ''  '',
																				   '','',
																				   ''a@a.com'',
																				   ''A@A.COM'',
																				   ''A@HOTMAIL.COM'',
																				   ''a@hotmail.com'',
																				   ''NO POSEE'',
																				   ''no posee'',
																				   ''no tiene@gmail.com'',
																				   ''NO@BSC.COM'',
																				   ''NO@DECLARA.COM'',
																				   ''no@declara.com'',
																				   ''nodeclara@hotmail.com'',
																				   ''nodeclara@nodeclara.com'',
																				   '' noposeecorreo@yahoo.com'')')

GO
/****** Object:  View [dbo].[correosElectronicosInvalidos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO






CREATE VIEW [dbo].[correosElectronicosInvalidos]
AS
select * from openquery(M4000SF,'SELECT MDI.GLB_DTIME ID,
										MDI.SCO_IDENT NROCLIENTE,
										MCL.SNO_CLIEN NOMCLIENTE,
										MDI.SCO_EMAIL CORREO, 
										MDI.SNOUSUADI CODUSUCRE,
										MDI.SNOUSUMOD CODUSUMOD,
										MCL.SCOOFIORI SUCURSAL,
										TO_CHAR ( TO_DATE ( LPAD(MCL.SFEUSUADI, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHAALTA
								 FROM SFB_BSMDI MDI 
								 INNER JOIN SFB_BSMCL MCL ON MDI.SCO_IDENT = MCL.SCO_IDENT
								 WHERE 
								 MDI.SCO_IDENT <> ''0000001000000'' AND MDI.SNU_DIREC = 1 AND
								 (MDI.GLB_DTIME IN (SELECT MDI.GLB_DTIME
														FROM SFB_BSMDI MDI 
														WHERE LOWER(MDI.SCO_EMAIL) LIKE ''%posee%'' OR 
															  LOWER(MDI.SCO_EMAIL) LIKE ''%declara%'' OR 
															  LOWER(MDI.SCO_EMAIL) LIKE ''%informa%'' OR
									   (MDI.SCO_EMAIL<> '' '' AND (LENGTH(MDI.SCO_EMAIL) < 8 OR MDI.SCO_EMAIL NOT LIKE ''%@%'' ))) OR 
								 MDI.GLB_DTIME IN (SELECT MDI.GLB_DTIME
												   FROM SFB_BSMDI MDI 
												   WHERE LOWER(SUBSTR(MDI.SCO_EMAIL, LENGTH(REGEXP_SUBSTR( MDI.SCO_EMAIL, ''[^@]*'', 1, 1)) + 2 , LENGTH(MDI.SCO_EMAIL))) 
														IN (''hotmial.com'', ''mail.com'', 
														    ''hotmail.co'',''hotmai.com'',
															''hotmal.com'', ''homail.com'',
															''hotamil.com'', ''hotamil.com'',
															''gmai.com'',''gmial.com'',
															''gimail.com'',''hormail.com'',
															''gmeil.com'', ''outlok.com'',
															''oulook.com'',''hitmail.com'',
															''hotamail.com'',''gmail.co'',
															''htmail.com'',''gmil.com'', 
															''hotmail.com.com'', ''gamil.com'',
															''no.com'', ''yahoo.con.ar'',
															''yahho.com.ar'')))')



GO
/****** Object:  View [dbo].[cuentaCorrentistasInhabilitados]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[cuentaCorrentistasInhabilitados]
AS  
	select * from openquery(M4000SF,' SELECT CONCAT(CONCAT(LPAD(MOL.CCUNUMCUE, 6, ''0''), MEC.GLB_DTIME), MOL.CCUDIGVER)  id, 
											MOL.CCU_OFICI sucursal,
											MOL.CCUDIGVER digito,
											MOL.CCU_PRODU producto,
											MOL.CCUNUMCUE numeroCuenta,
											ADO.SCO_IDENT numeroCliente,
											MOL.CNO_CUENT nombreCuenta,
											MCL.SNO_CLIEN nombreCliente,
											MEC.SCOTIPDOC tipoDocumento,
											MEC.SNU_DOCUM cuit,
											LPAD(RCC.SCOTIRECC, 2,''0'') tipoRelacion,
											MTG.ANO_CORTA nombreRelacion,
											TO_CHAR ( TO_DATE ( LPAD(MEC.AFE_ALTA, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') fechaAlta,
											TO_CHAR ( TO_DATE ( LPAD(MEC.AFE_HASTA, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') fechaHasta
									FROM SFB_BSMEC MEC 
									INNER JOIN SFB_BSADO ADO ON ADO.SNU_DOCUM = MEC.SNU_DOCUM
									INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = ADO.SCO_IDENT
									INNER JOIN SFB_BSRCC RCC ON RCC.SCO_IDENT = ADO.SCO_IDENT AND RCC.ACO_CONCE = 1
									INNER JOIN SFB_ACMOL MOL ON MOL.CCU_OFICI = RCC.ACU_OFICI AND MOL.CCUNUMCUE = RCC.ACUNUMCUE AND MOL.CCOESTCUE NOT IN (6,7,9)  
									INNER JOIN SFB_BSMTG MTG ON MTG.ACO_TABLA = ''RELCLICTA'' AND MTG.ACO_CODIG = LPAD(RCC.SCOTIRECC, 2,''0'')
									WHERE MEC.AFE_HASTA <> 0 AND MEC.AFE_HASTA <> 999999 AND MEC.SCO_MOTIV = 2
									ORDER BY MOL.CCU_OFICI, ADO.SCO_IDENT')

GO
/****** Object:  View [dbo].[documentosInvalidos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[documentosInvalidos]
AS

select * from openquery(M4000SF,'SELECT ADO.GLB_DTIME ID,
										ADO.SCO_IDENT NROCLIENTE,
										MCL.SNO_CLIEN NOMCLIENTE,
										MTG.ANO_CORTA TIPODOCUMENTO,
										ADO.SNU_DOCUM NRODOCUMENTO
								 FROM SFB_BSADO ADO
								 INNER JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = ADO.SCOTIPDOC AND 
															 MTG.ACO_TABLA = ''TIPIDENT'' AND 
															 MTG.ACO_CODIG <> '' '' AND
															 MTG.ACO_CODIG IN (''31'', ''34'', ''35'')
								 LEFT JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = ADO.SCO_IDENT
								 WHERE (MTG.ACO_CODIG IN (''34'', ''35'') AND LENGTH(ADO.SNU_DOCUM) <= 10) OR 
									   (MTG.ACO_CODIG=''31'' AND LENGTH(ADO.SNU_DOCUM) > 8) ')


GO
/****** Object:  View [dbo].[domiciliosInconsistentes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[domiciliosInconsistentes]
AS

select * from openquery(M4000SF,'SELECT MDI.GLB_DTIME ID,
										MDI.SCO_IDENT NROCLIENTE,
										MCL.SNO_CLIEN NOMCLIENTE,
										MTG.ANO_CORTA PROVINCIA,
										MDI.SNO_CIUDA CIUDAD,
										MDI.SNO_CALLE CALLE
								 FROM SFB_BSMDI MDI
								 INNER JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = MDI.SCO_PROVI AND MTG.ACO_TABLA =''PROVINCIAS'' AND MTG.ACO_CODIG <> '' ''
								 LEFT JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = MDI.SCO_IDENT
								 WHERE (TRANSLATE(MDI.SNO_CALLE, ''T 0123456789'', ''T'') IS NULL OR LENGTH(MDI.SNO_CALLE) <= 3) OR LENGTH(MDI.SNO_CIUDA) <= 3')



GO
/****** Object:  View [dbo].[personasFisicasDuplicadas]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[personasFisicasDuplicadas]
AS

select * from openquery(M4000SF, 'SELECT MFI.GLB_DTIME ID, 
										 MFI.SCO_IDENT NROCLIENTE,
										 MCL.SNO_CLIEN NOMCLIENTE,
										 MFI.SNOUSUADI CODUSUCRE,
										 MFI.SNOUSUMOD CODUSUMOD
								  FROM SFB_BSMFI MFI
								  INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = MFI.SCO_IDENT
								  INNER JOIN (SELECT SCO_IDENT, COUNT(GLB_DTIME) CANTIDAD
											  FROM SFB_BSMFI
											  GROUP BY SCO_IDENT) DUP ON DUP.SCO_IDENT = MFI.SCO_IDENT AND CANTIDAD > 1')


GO
/****** Object:  View [dbo].[plazoVencidoSAV]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO




CREATE VIEW [dbo].[plazoVencidoSAV]
AS
select * from openquery([192.168.250.251], 'SELECT VND.CodValorND ID,
											 VND.SucursalDep SUCURSAL,
										     UPPER (VND.Titular) TITULAR, 
										     (CASE Tipo 
												WHEN 3 THEN ''Tarjeta de crédito master''
												WHEN 4 THEN ''Tarjeta de crédito visa'' 
												ELSE ''Visa débito''
										     END) TIPO, 
										    VND.NroInicial NROINICIAL, 
										    VND.NroFinal NROFINAL,
										    CONVERT(NVARCHAR, VND.FechaIngreso, 103) FECHAINGRESO,
										    CONVERT(NVARCHAR, VND.FechaGra, 103) FECHADESTRUCCION,
										    DATEDIFF(day, VND.FechaIngreso, GETDATE()) AS PLAZODIAS
									FROM [Tesoreria].[dbo].[DEPOSITOSVND] VND
									INNER JOIN [Tesoreria].[dbo].[TIPOSNODINERARIOS] TND ON VND.Tipo = TND.Codigo
									WHERE (TND.Destruccion = ''SI'') AND DATEDIFF(day, VND.FechaIngreso, GETDATE()) > TND.CantDias AND Tipo IN (3, 4, 38)')



GO
/****** Object:  View [dbo].[regimenCTTCTranasacciones]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[regimenCTTCTranasacciones] as
select 
	mes,
	docNro usuarioDocNro,
	cuenta,
	marca,
	entidad,
	SUBSTRING(tarjeta, LEN(tarjeta)-3, 4) tarjeta,
	pesos,
	dolarPeso,
	relacion,
	titularDocTipo,
	titularDocNro,
	REPLACE(LEFT([titularNombre], ISNULL(NULLIF(CHARINDEX(' ', [titularNombre]) - 1, -1), LEN([titularNombre]))), ',','') titularApellido,
SUBSTRING([titularNombre], CHARINDEX(' ', [titularNombre]) + 1, LEN([titularNombre])) titularNombre
from [bd_sib].[dbo].[7regimenCTTC]


GO
/****** Object:  View [dbo].[regimenCTTCUsuarios]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE view [dbo].[regimenCTTCUsuarios] as
SELECT mes,
	cuentaTipo,
	docTipo,
	docNro,
	apellido,
	nombre 
FROM (	SELECT mes,
			'Personal' cuentaTipo,
			docTipo,
			docNro,
			REPLACE(LEFT([nombre], ISNULL(NULLIF(CHARINDEX(' ', [nombre]) - 1, -1), LEN([nombre]))), ',','') apellido,
			SUBSTRING([nombre], CHARINDEX(' ', [nombre]) + 1, LEN([nombre])) nombre,
			ROW_NUMBER() over (partition by mes, docNro order by docNro desc) orden 
		FROM [bd_sib].[dbo].[7regimenCTTC]
		WHERE relacion in ('Titular', 'Adicional')) A WHERE A.orden = 1


GO
/****** Object:  View [dbo].[rteSinDepositantes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[rteSinDepositantes]
as
SELECT DISTINCT TRA.referencia,
	   TRA.concepto,
	   TRA.cuenta,
	   CAST(TRA.fecha AS DATE) fecha,
	   TRA.tipo,
	   TRA.moneda,
	   TRA.montoOrigen,
	   TRA.montoPesos,
	   (CASE WHEN OPE.cuil IS NOT NULL THEN 'Operador'
			 WHEN OPT.cuil IS NOT NULL THEN 'Operador/Titular' 
			 ELSE 'Titular'
		END) relacion,
	   (CASE WHEN OPE.cuil IS NOT NULL THEN OPE.cuil
			 WHEN OPT.cuil IS NOT NULL THEN OPT.cuil 
			 ELSE TIT.cuil
		END) cuil,
		(CASE WHEN OPE.nombre IS NOT NULL THEN OPE.nombre
			  WHEN OPT.nombre IS NOT NULL THEN OPT.nombre 
			  ELSE TIT.nombre
		END) nombre,
		MOV.codigoUsuario,
		MOV.nombreUsuario
FROM [bd_sib].[dbo].[rte_transaccion] TRA
LEFT JOIN (SELECT referencia, cuil, apellido +' '+(CASE WHEN nombre IS NOT NULL THEN nombre ELSE '' END) nombre
			FROM [bd_sib].[dbo].[rte_vinculado]
			WHERE relacionFondo = 'Titular') TIT ON TIT.referencia = TRA.referencia
LEFT JOIN (SELECT referencia, cuil, apellido +' '+(CASE WHEN nombre IS NOT NULL THEN nombre ELSE '' END) nombre
			FROM [bd_sib].[dbo].[rte_vinculado]
			WHERE relacionFondo = 'Operador/Titular') OPT ON OPT.referencia = TRA.referencia
LEFT JOIN (SELECT referencia, cuil, apellido +' '+(CASE WHEN nombre IS NOT NULL THEN nombre ELSE '' END) nombre
			FROM [bd_sib].[dbo].[rte_vinculado]
			WHERE relacionFondo = 'Operador') OPE ON OPE.referencia = TRA.referencia
INNER JOIN (SELECT *, RIGHT('0' + CAST(codigoSucursal AS NVARCHAR), 2)+'-'+RIGHT('00000' + CAST(numeroCuenta AS NVARCHAR), 6)+'/'+CAST(digitoVerificador AS NVARCHAR) cuenta
			FROM [bd_sib].[dbo].[3movimientoSinDepositantes]) MOV 
			ON MOV.concepto = TRA.concepto 
			AND MOV.cuenta = TRA.cuenta 
			AND MOV.fechaValor = CAST(TRA.fecha AS DATE) 
			AND MOV.montoPesos = TRA.montoPesos
			AND (CASE WHEN MOV.tipo = 'Deposito' THEN 'Depósito' ELSE 'Extración' END)  = TRA.tipo 
GO
/****** Object:  View [dbo].[solicitudesWF]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



CREATE VIEW [dbo].[solicitudesWF]
AS  
	select * from openquery([192.168.250.134],'SELECT ''VN''+CONVERT(NVARCHAR, V.id) ID,
											  ''VALORES NEGOCIADOS'' PROCESO,
											  V.altaFecha FECHAALTA,
											  V.sucursalId SUCURSAL,
											  V.altaUsuario COLLATE DATABASE_DEFAULT USUARIO,
											  V.nroCliente CLIENTE,
											  V.producto COLLATE DATABASE_DEFAULT PRODUCTO,
											  V.estadoFecha FECHAESTADO,
											  E.descripcion COLLATE DATABASE_DEFAULT DESCRIPCION
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLVALORESNEGOCIADOS] V
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLVALORESNEGOCIADOSESTADO] E ON E.id = V.estadoId AND E.id = 9
									   UNION ALL
									   SELECT ''PA''+CONVERT(NVARCHAR, P.id) id,
											   ''PAQUETES'' proceso,
											   P.fechaAlta fechaAlta,
											   P.sucursalId sucursal,
											   P.altaUsuario COLLATE DATABASE_DEFAULT usuario,
											   P.cuit cliente,
											   '''' COLLATE DATABASE_DEFAULT producto,
											   P.fechaMod fechaEstado,
											   E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDPAQUETES] P
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDPAQUETESESTADO] E ON E.id = P.estadoId AND E.id IN (4,5)
									   UNION ALL
									   SELECT ''TA''+CONVERT(NVARCHAR, T.id) id,
											  ''TARJETAS'' proceso,
											  T.altaFecha fechaAlta,
											  T.sucursalId sucursal,
											  T.altaUsuario COLLATE DATABASE_DEFAULT usuario,
											  T.clienteIdentificadorNro cliente,
											  T.producto COLLATE DATABASE_DEFAULT producto,
											  T.estadoFecha fechaEstado,
											  E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[pcSolicitudTC] T 
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[pcSolicitudTCEstado] E ON E.id = T.estadoId AND E.id IN (4, 12,13)
									   UNION ALL
									   SELECT ''AC''+CONVERT(NVARCHAR, C.id) id,
											  ''ALTA DE CAJA DE AHORRO'' proceso,
											  C.altaFecha fechaAlta,
											  C.sucursalId sucursal,
											  C.altaUsuario COLLATE DATABASE_DEFAULT usuario,
											  C.nroCliente cliente,
											  convert(NVARCHAR, C.idProducto) producto,
											  C.estadoFecha fechaEstado,
											  E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDCAJADEAHORRO] C
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDCAJADEAHORROESTADO] E on E.id = C.estadoId AND E.id IN (20, 21, 49)
									   UNION ALL
									   SELECT ''AM''+CONVERT(NVARCHAR, B.id) id,
												''ALTA MASIVA'' proceso,
												B.altaFecha fechaAlta,
												B.sucursalId sucursal,
												B.altaUsuario COLLATE DATABASE_DEFAULT usuario, 
												B.nroCliente cliente,
												'''' COLLATE DATABASE_DEFAULT producto,
												B.estadoFecha fechaEstado,
												E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDBANCARISACIONANSES] B
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDBANCARISACIONANSESESTADO] E ON E.id = B.estadoId AND E.id IN (5, 8)
									    UNION ALL
									   SELECT ''ABM''+CONVERT(NVARCHAR, A.id) id,
												''ABM CLIENTE'' proceso,
												A.altaFecha fechaAlta,
												A.sucursalId sucursal,
												A.altaUsuario COLLATE DATABASE_DEFAULT usuario, 
												A.nroCliente cliente,
												'''' COLLATE DATABASE_DEFAULT producto,
												A.estadoFecha fechaEstado,
												E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDALTAYMODCLIENTE] A
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDALTAYMODCLIENTEESTADO] E ON E.id = A.estadoId AND E.id IN (4, 5)
									   UNION ALL
									   SELECT ''CC''+CONVERT(NVARCHAR, C.id) id,
												''CUENTA CORRIENTE'' proceso,
												C.altaFecha fechaAlta,
												C.sucursalId sucursal,
												C.altaUsuario COLLATE DATABASE_DEFAULT usuario, 
												C.nroCliente cliente,
												'''' COLLATE DATABASE_DEFAULT producto,
												C.estadoFecha fechaEstado,
												E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDCUENTACORRIENTE] C
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDCUENTACORRIENTEESTADO] E ON E.id = C.estadoId AND E.id IN (6, 7)
									   UNION ALL
									   SELECT ''S''+CONVERT(NVARCHAR, S.id) id,
												''SEGUROS'' proceso,
												S.altaFecha fechaAlta,
												S.sucursalId sucursal,
												S.altaUsuario COLLATE DATABASE_DEFAULT usuario, 
												S.clienteIdentificadorNro cliente,
												'''' COLLATE DATABASE_DEFAULT producto,
												S.estadoFecha fechaEstado,
												E.descripcion COLLATE DATABASE_DEFAULT descripcion
									   FROM [DATOS_CLIENTE_UNICO].[dbo].[pcSolicitudSeguro] S
									   INNER JOIN [DATOS_CLIENTE_UNICO].[dbo].[pcSolicitudSeguroEstado] E ON E.id = S.estadoId AND E.id IN (3,4)
									   ')




GO
/****** Object:  View [dbo].[telefonosParticularesInvalidos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE VIEW [dbo].[telefonosParticularesInvalidos]
AS

select * from openquery([192.168.250.134],'SELECT MDI.SCO_IDENT NROCLIENTE,
										  MCL.SNO_CLIEN NOMCLIENTE,
										  MDI.SNUTELPAR TELEFONO,
										  MDI.SNOUSUADI CODUSUCRE
								 FROM [DWH].[DBO].[SFB_BSMDI] MDI
								 LEFT JOIN [DWH].[DBO].[SFB_BSMCL] MCL ON MCL.SCO_IDENT = MDI.SCO_IDENT
								 WHERE (SUBSTRING(MDI.SNUTELPAR,1,4) = ''0297'' AND LEN(MDI.SNUTELPAR) NOT IN (10, 11, 13)) OR 
									   (SUBSTRING(MDI.SNUTELPAR, 1, 3) = ''297'' AND LEN(MDI.SNUTELPAR) NOT IN (9, 10, 12)) OR
									   (LEN(MDI.SNUTELPAR) NOT IN (10, 11, 12, 13) AND MDI.SNUTELPAR <> '' '') ')



GO
/****** Object:  View [dbo].[telefonosParticularesValidos]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[telefonosParticularesValidos]
AS
select * from openquery([192.168.250.134],'SELECT MDI.SCO_IDENT NROCLIENTE,
										  MCL.SNO_CLIEN NOMCLIENTE,
										  (CASE 
											WHEN SUBSTRING(MDI.SNUTELPAR, 1, 4) = ''0297'' THEN SUBSTRING(MDI.SNUTELPAR,1,4)
											WHEN SUBSTRING(MDI.SNUTELPAR, 1, 3) = ''297''  THEN SUBSTRING(MDI.SNUTELPAR, 1, 3)
											ELSE SUBSTRING(MDI.SNUTELPAR, 1, 5)
										  END) CODIGO,
										  (CASE 
											WHEN SUBSTRING(MDI.SNUTELPAR, 1, 4) = ''0297'' THEN SUBSTRING(MDI.SNUTELPAR, 5, LEN(MDI.SNUTELPAR))
											WHEN SUBSTRING(MDI.SNUTELPAR, 1, 3) = ''297''  THEN SUBSTRING(MDI.SNUTELPAR, 4, LEN(MDI.SNUTELPAR))
											ELSE SUBSTRING(MDI.SNUTELPAR, 6, LEN(MDI.SNUTELPAR))
										  END) TELEFONO,
										  MDI.SNOUSUADI CODUSUCRE
								 FROM [DWH].[DBO].[SFB_BSMDI] MDI
								 LEFT JOIN [DWH].[DBO].[SFB_BSMCL] MCL ON MCL.SCO_IDENT = MDI.SCO_IDENT
								 WHERE (SUBSTRING(MDI.SNUTELPAR, 1, 4) = ''0297'' AND LEN(MDI.SNUTELPAR) IN (10, 11, 13)) OR 
									   (SUBSTRING(MDI.SNUTELPAR, 1, 3) = ''297'' AND LEN(MDI.SNUTELPAR) IN (9, 10, 12)) OR
									   (LEN(MDI.SNUTELPAR) IN (10, 11, 12, 13) AND MDI.SNUTELPAR <> '' '') AND MDI.SNU_DIREC = 1')
GO
/****** Object:  View [dbo].[zz_plano_movimientos_depositantes]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[zz_plano_movimientos_depositantes]
as
select '('+cast(concepto as nvarchar)+', '+
+''''+tipo+''', '+
+''+cast(codigoSucursal as nvarchar)+', '+
+''+cast(numeroCuenta as nvarchar)+', '+
+''+cast(digitoVerificador as nvarchar)+', '+
+''+cast(codigoMoneda as nvarchar)+', '+
+''''+codigoUsuario+''', '+
+''''+nombreUsuario+''', '+
+''''+CAST(CAST(fechaValor AS DATE) AS NVARCHAR) +'T00:00:00'','
+''+cast(montoOrigen as nvarchar)+', '+
+''+cast(montoPesos as nvarchar)+', '+
+''+(CASE WHEN comentario IS NOT NULL THEN ''''+comentario+'''' ELSE 'NULL' END)+'), ' registro
from [bd_sib].[dbo].[3movimientoSinDepositantes]
GO
/****** Object:  View [dbo].[zz_plano_regimenCTTC]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[zz_plano_regimenCTTC] as
SELECT
      '('+CAST([mes] AS nvarchar)+','
      +''''+[cuenta]+''','
      +''''+[marca]+''','
      +''''+[entidad]+''','
      +''''+[tarjeta]+''','
      +''''+RTRIM([nombre])+''','
      +''''+[docTipo]+''','
      +''''+[docNro]+''','
      +''''+[relacion]+''','
      +CAST([pesos] AS NVARCHAR)+','
      +CAST([dolar] AS NVARCHAR)+','
      +CAST([dolarPeso] AS NVARCHAR)+','
      +CAST([ajuste] AS NVARCHAR)+','
      +''''+[titularNombre]+''','
      +''''+[titularDocTipo]+''','
      +''''+[titularDocNro]+''','
	  + 'GETDATE() ),' registro
  FROM [bd_sib].[dbo].[7regimenCTTC]
GO
/****** Object:  View [dbo].[zz_plano_rte_transaccion]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
  CREATE VIEW [dbo].[zz_plano_rte_transaccion]
  AS
  select 
  '('+cast(concepto as nvarchar)+', '+
  +''''+cuenta+''', '+
  +''''+referencia+''', '+
  +''''+CAST(CAST(fecha AS DATE) AS NVARCHAR) +'T00:00:00'','
  +''''+tipo+''', '+
  +''''+moneda+''', '+
  +''+cast(montoOrigen as nvarchar)+', '+
  +''+cast(montoPesos as nvarchar)+', '+
  +'NULL,'+ 
  +''''+provincia+''', '+
  +''''+localidad+''', '
  +''''+calle+''', '+
  +''+cast(numero as nvarchar)+'), ' registro
  from [bd_sib].[dbo].[rte_transaccion]
GO
/****** Object:  View [dbo].[zz_plano_rte_vinculado]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
 create view [dbo].[zz_plano_rte_vinculado]
 as
  SELECT '('''+referencia+''', '+
	+''''+relacionFondo+''', '+
	+''+(CASE WHEN relacionProducto IS NOT NULL THEN ''''+relacionProducto+'''' ELSE 'NULL' END)+', '+
	+''''+cuil+''', '+
	+''''+tipoPersona+''', '+
	+''''+apellido+''', '+
	+''+(CASE WHEN nombre IS NOT NULL THEN ''''+nombre+'''' ELSE 'NULL' END)+', '+
	+''+(CASE WHEN tipoDocumento IS NOT NULL THEN ''''+tipoDocumento+'''' ELSE 'NULL' END)+', '+
	+''+(CASE WHEN numeroDocumento IS NOT NULL THEN ''''+numeroDocumento+'''' ELSE 'NULL' END)+'), ' registro
  FROM [bd_sib].[dbo].[rte_vinculado]
  WHERE referencia IN (SELECT referencia from [bd_sib].[dbo].[rte_transaccion])
GO
/****** Object:  View [dbo].[zzz_regimenConsolidadoVisa]    Script Date: 20/3/2020 11:16:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[zzz_regimenConsolidadoVisa]
AS
SELECT        '(' + CAST(mes AS nvarchar) + ', ' + + '''' + documento + ''', ' + + '''' + nombre + ''', ' + + '' + CAST(consumos AS nvarchar) + ', ' + + '' + CAST(ajustes AS nvarchar) + ', ' + + '' + CAST(consolidado AS nvarchar) 
                         + ', ' + + '''' + CAST(CAST(fechaActualizacion AS DATE) AS NVARCHAR) + 'T00:00:00''),' AS Expr1
FROM            dbo.[7regimenConsolidadoVisa]

GO
ALTER TABLE [dbo].[garantia]  WITH CHECK ADD  CONSTRAINT [FK_garantia_cartera] FOREIGN KEY([id_cartera])
REFERENCES [dbo].[cartera] ([id_cartera])
GO
ALTER TABLE [dbo].[garantia] CHECK CONSTRAINT [FK_garantia_cartera]
GO
ALTER TABLE [dbo].[garantia]  WITH CHECK ADD  CONSTRAINT [FK_garantia_fianza] FOREIGN KEY([id_fianza])
REFERENCES [dbo].[fianza] ([id_fianza])
GO
ALTER TABLE [dbo].[garantia] CHECK CONSTRAINT [FK_garantia_fianza]
GO
ALTER TABLE [dbo].[garantia]  WITH CHECK ADD  CONSTRAINT [FK_garantia_hipoteca] FOREIGN KEY([id_hipoteca])
REFERENCES [dbo].[hipoteca] ([id_hipoteca])
GO
ALTER TABLE [dbo].[garantia] CHECK CONSTRAINT [FK_garantia_hipoteca]
GO
ALTER TABLE [dbo].[garantia]  WITH CHECK ADD  CONSTRAINT [FK_garantia_leasing] FOREIGN KEY([id_leasing])
REFERENCES [dbo].[leasing] ([id_leasing])
GO
ALTER TABLE [dbo].[garantia] CHECK CONSTRAINT [FK_garantia_leasing]
GO
ALTER TABLE [dbo].[garantia]  WITH CHECK ADD  CONSTRAINT [FK_garantia_prenda] FOREIGN KEY([id_prenda])
REFERENCES [dbo].[prenda] ([id_prenda])
GO
ALTER TABLE [dbo].[garantia] CHECK CONSTRAINT [FK_garantia_prenda]
GO
ALTER TABLE [dbo].[imagenesCartera]  WITH CHECK ADD  CONSTRAINT [FK_imagenesCartera_cartera] FOREIGN KEY([idCartera])
REFERENCES [dbo].[cartera] ([id_cartera])
GO
ALTER TABLE [dbo].[imagenesCartera] CHECK CONSTRAINT [FK_imagenesCartera_cartera]
GO
ALTER TABLE [dbo].[imagenesFianza]  WITH CHECK ADD  CONSTRAINT [FK_imagenesFianza_fianza] FOREIGN KEY([idFianza])
REFERENCES [dbo].[fianza] ([id_fianza])
GO
ALTER TABLE [dbo].[imagenesFianza] CHECK CONSTRAINT [FK_imagenesFianza_fianza]
GO
ALTER TABLE [dbo].[imagenesHipoteca]  WITH CHECK ADD  CONSTRAINT [FK_imagenesHipoteca_hipoteca] FOREIGN KEY([idHipoteca])
REFERENCES [dbo].[hipoteca] ([id_hipoteca])
GO
ALTER TABLE [dbo].[imagenesHipoteca] CHECK CONSTRAINT [FK_imagenesHipoteca_hipoteca]
GO
ALTER TABLE [dbo].[imagenesHipoteca]  WITH CHECK ADD  CONSTRAINT [FK_imagenesHipoteca_imagenesHipoteca] FOREIGN KEY([id])
REFERENCES [dbo].[imagenesHipoteca] ([id])
GO
ALTER TABLE [dbo].[imagenesHipoteca] CHECK CONSTRAINT [FK_imagenesHipoteca_imagenesHipoteca]
GO
ALTER TABLE [dbo].[imagenesLeasing]  WITH CHECK ADD  CONSTRAINT [FK_imagenesLeasing_leasing] FOREIGN KEY([idLeasing])
REFERENCES [dbo].[leasing] ([id_leasing])
GO
ALTER TABLE [dbo].[imagenesLeasing] CHECK CONSTRAINT [FK_imagenesLeasing_leasing]
GO
ALTER TABLE [dbo].[imagenesPrenda]  WITH CHECK ADD  CONSTRAINT [FK_imagenesPrenda_prenda] FOREIGN KEY([idPrenda])
REFERENCES [dbo].[prenda] ([id_prenda])
GO
ALTER TABLE [dbo].[imagenesPrenda] CHECK CONSTRAINT [FK_imagenesPrenda_prenda]
GO
ALTER TABLE [dbo].[rol_permiso]  WITH CHECK ADD  CONSTRAINT [FK_rol_permiso_permiso] FOREIGN KEY([id_permiso])
REFERENCES [dbo].[permiso] ([id_permiso])
GO
ALTER TABLE [dbo].[rol_permiso] CHECK CONSTRAINT [FK_rol_permiso_permiso]
GO
ALTER TABLE [dbo].[rol_permiso]  WITH CHECK ADD  CONSTRAINT [FK_rol_permiso_rol] FOREIGN KEY([id_rol])
REFERENCES [dbo].[rol] ([id_rol])
GO
ALTER TABLE [dbo].[rol_permiso] CHECK CONSTRAINT [FK_rol_permiso_rol]
GO
ALTER TABLE [dbo].[rte_sujeto]  WITH CHECK ADD  CONSTRAINT [FK_rte_sujeto_rte_sujeto] FOREIGN KEY([idSujeto])
REFERENCES [dbo].[rte_sujeto] ([idSujeto])
GO
ALTER TABLE [dbo].[rte_sujeto] CHECK CONSTRAINT [FK_rte_sujeto_rte_sujeto]
GO
ALTER TABLE [dbo].[usuario]  WITH CHECK ADD  CONSTRAINT [FK_usuario_rol] FOREIGN KEY([id_rol])
REFERENCES [dbo].[rol] ([id_rol])
GO
ALTER TABLE [dbo].[usuario] CHECK CONSTRAINT [FK_usuario_rol]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Descripcion del producto' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'descProd'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Estado de garantia y operacion' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'estado'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Entrega garantia o documentacion' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'entGtia'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Fecha de alta op' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'fecAltaOpe'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Fecha de vencimiento op' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'fecVtoOpe'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Gestion de cancelacion' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'gesCan'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'moneda' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'moneda'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Nombre o denominacion del cliente' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'nomCli'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Producto de credito o acuerdo' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'prodCred'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Garantia original' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'oriGtia'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Operacion relacionada' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'opeRela'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Numero de valor no dinerario' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'sav'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Valor nominal o de origen' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'garantia', @level2type=N'COLUMN',@level2name=N'valNomi'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "7regimenConsolidadoVisa"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 136
               Right = 247
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'zzz_regimenConsolidadoVisa'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'zzz_regimenConsolidadoVisa'
GO
