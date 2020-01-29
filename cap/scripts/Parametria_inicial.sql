-- PERFILES ========================================================================================

insert into cap.dbo.seg_perfil values
('SUPER','SUPER USUARIO.-','Activo'),
('PAI','Acceso al modulo de seguridad del sistema','Activo'),
('Analista programador','Analista programador de sistemas','Activo'),
('Responsable de sistemas','Responsable de sistemas','Activo'),
('Responsable GCTI','Responsable de gestión de TI','Activo'),
('RyT','Redes y tecnologia','Activo'),
('Responsable R. y T.','Responsable de Redes y Tecnologia','Activo')

insert into [dbo].[log_actividad]
select 'SCRIPT','seg_perfil','CREACION', id, GETDATE() from [dbo].seg_perfil order by id

-- USUARIOS ========================================================================================

insert into cap.dbo.seg_usuario values
('01601','Codino Maria Eugenia',4,'Activo'),
('01969','Leon Lucas',3,'Activo'),
('01560','Denezio Sebastian',3,'Activo'),
('01702','Alvarado Belen',3,'Activo'),
('01570','Diaz Susana',3,'Activo'),
('01879','Cohan Gustavo',3,'Activo'),
('07501','Farinola Santiago',3,'Activo'),
('07488','Salazar Malcom',3,'Activo'),
('07489','Marquez Emanuel',3,'Activo'),
('07486','Gonzalez Fabricio',3,'Activo'),
('01704','Ojeda Ulises',7,'Activo'),
('01983','Oyarzun Ezequiel',6,'Activo'),
('01653','Gomez Patricio',6,'Activo'),
('01952','Alvarez Pablo',6,'Activo'),
('02004','Diaz Pastrana Martin',6,'Activo'),
('01547','Corbett Carlos',5,'Activo'),
('01655','Coraccio Alejandro',1,'Activo'),
('01896','Strazanec Oscar',2,'Activo'),
('01982','Olmos Corsini Franco',2,'Activo')

insert into [dbo].[log_actividad]
select 'SCRIPT','seg_usuario','CREACION', id, GETDATE() from [dbo].seg_usuario order by id


-- PERMISOS =========================================================================================

insert into cap.dbo.seg_permiso values 
('Actividades',1,0,''),
('Aplicaciones',1,0,''),
('Auxiliares',1,0,''),
('Bases',1,0,''),
('Comunicaciones',1,0,''),
('Dependencias',1,0,''),
('Firewalls',1,0,''),
('Gerencias',1,0,''),
('Hardwares',1,0,''),
('Herramientas',1,0,''),
('Instalaciones',1,0,''),
('Inventarios',1,0,''),
('Lenguajes',1,0,''),
('Perfiles',1,0,''),
('Permisos',1,0,''),
('Personal',1,0,''),
('Plataformas',1,0,''),
('Procesamientos',1,0,''),
('Proveedores',1,0,''),
('Reportes',1,0,''),
('Servicios',1,0,''),
('Servidores',1,0,''),
('Sitios',1,0,''),
('Switchs',1,0,''),
('Usuarios',1,0,''),
('Utilidades',1,0,''),
('Ver log',2,1,'actividades/vistas/FBuscarActividad'),
('Buscar',2,2,'aplicaciones/vistas/FBuscarPPAplicacion'),
('Buscar',2,2,'aplicaciones/vistas/FBuscarSPAplicacion'),
('Buscar',2,2,'aplicaciones/vistas/FBuscarTPAplicacion'),
('Aplicaciones',2,2,'aplicaciones/vistas/FConsultarAplicacion'),
('Crear',2,2,'aplicaciones/vistas/FCrearAplicacion'),
('Buscar',2,3,'auxiliares/vistas/FBuscarElementoAuxiliar'),
('Auxiliares',2,3,'auxiliares/vistas/FConsultarElementoAuxiliar'),
('Crear',2,3,'auxiliares/vistas/FCrearElementoAuxiliar'),
('Buscar base',2,4,'bases/vistas/FBuscarBase'),
('Buscar columna',2,4,'bases/vistas/FBuscarCampo'),
('Buscar SP',2,4,'bases/vistas/FBuscarProcedimiento'),
('Buscar tabla',2,4,'bases/vistas/FBuscarTabla'),
('Buscar vista',2,4,'bases/vistas/FBuscarVista'),
('Bases de datos',2,4,'bases/vistas/FConsultarBase'),
('Buscar',2,5,'comunicaciones/vistas/FBuscarComunicacion'),
('Comunicaciones',2,5,'comunicaciones/vistas/FConsultarComunicacion'),
('Crear',2,5,'comunicaciones/vistas/FCrearComunicacion'),
('Buscar hijo',2,6,'dependencias/vistas/FBuscarActivoHijo'),
('Buscar padre',2,6,'dependencias/vistas/FBuscarActivoPadre'),
('Crear hijo',2,6,'dependencias/vistas/FCrearActivoHijo'),
('Crear padre',2,6,'dependencias/vistas/FCrearActivoPadre'),
('Buscar',2,7,'firewalls/vistas/FBuscarFirewall'),
('Firewall',2,7,'firewalls/vistas/FConsultarFirewall'),
('Crear',2,7,'firewalls/vistas/FCrearFirewall'),
('Buscar depto',2,8,'gerencias/vistas/FBuscarDepartamento'),
('Buscar empleado',2,8,'gerencias/vistas/FBuscarEmpleado'),
('Buscar gerencia',2,8,'gerencias/vistas/FBuscarGerencia'),
('Crear depto',2,8,'gerencias/vistas/FCrearDepartamento'),
('Crear empleado',2,8,'gerencias/vistas/FCrearEmpleado'),
('Crear gerencia',2,8,'gerencias/vistas/FCrearGerencia'),
('Gerencias',2,20,'gerencias/vistas/FReporteGerencia'),
('Buscar',2,9,'hardwares/vistas/FBuscarHardware'),
('Hardwares',2,9,'hardwares/vistas/FConsultarHardware'),
('Crear',2,9,'hardwares/vistas/FCrearHardware'),
('Buscar',2,10,'herramientas/vistas/FBuscarHerramienta'),
('Consultar',2,10,'herramientas/vistas/FConsultarHerramienta'),
('Crear',2,10,'herramientas/vistas/FCrearHerramienta'),
('Buscar',2,11,'instalaciones/vistas/FBuscarInstalacion'),
('Instalaciones',2,11,'instalaciones/vistas/FConsultarInstalacion'),
('Crear',2,11,'instalaciones/vistas/FCrearInstalacion'),
('Ver historico',2,12,'inventarios/vistas/FConsultarHistorico'),
('Buscar',2,13,'lenguajes/vistas/FBuscarLenguaje'),
('Ver',2,13,'lenguajes/vistas/FConsultarLenguaje'),
('Crear',2,13,'lenguajes/vistas/FCrearLenguaje'),
('Buscar',2,14,'perfiles/vistas/FBuscarPerfil'),
('Crear',2,14,'perfiles/vistas/FCrearPerfil'),
('Buscar',2,15,'permisos/vistas/FBuscarPermiso'),
('Crear',2,15,'permisos/vistas/FCrearPermiso'),
('Buscar',2,16,'personales/vistas/FBuscarPersonal'),
('Personales',2,16,'personales/vistas/FConsultarPersonal'),
('Crear',2,16,'personales/vistas/FCrearPersonal'),
('Buscar',2,17,'plataformas/vistas/FBuscarPlataformaSO'),
('Crear',2,17,'plataformas/vistas/FCrearPlataformaSO'),
('Buscar lugar',2,18,'procesamientos/vistas/FBuscarLugarProcesamiento'),
('Buscar modo',2,18,'procesamientos/vistas/FBuscarModoProcesamiento'),
('Crear lugar',2,18,'procesamientos/vistas/FCrearLugarProcesamiento'),
('Crear modo',2,18,'procesamientos/vistas/FCrearModoProcesamiento'),
('Buscar proveedor',2,19,'proveedores/vistas/FBuscarProveedor'),
('Buscar responsable',2,19,'proveedores/vistas/FBuscarResponsable'),
('Ver proveedor',2,19,'proveedores/vistas/FConsultarProveedor'),
('Ver responsable',2,19,'proveedores/vistas/FConsultarResponsable'),
('Crear proveedor',2,19,'proveedores/vistas/FCrearProveedor'),
('Crear responsable',2,19,'proveedores/vistas/FCrearResponsable'),
('Buscar',2,21,'servicios/vistas/FBuscarServicio'),
('Crear',2,21,'servicios/vistas/FCrearServicio'),
('Buscar',2,22,'servidores/vistas/FBuscarServidor'),
('Consultar job',2,22,'servidores/vistas/FConsultarJob'),
('Consultar',2,22,'servidores/vistas/FConsultarServidor'),
('Crear',2,22,'servidores/vistas/FCrearServidor'),
('Servidores',2,20,'servidores/vistas/FReporteServidor'),
('Buscar sitio',2,23,'sitios/vistas/FBuscarSitio'),
('Crear sitio',2,23,'sitios/vistas/FCrearSitio'),
('Sitios',2,20,'sitios/vistas/FReporteSitio'),
('Buscar',2,24,'switches/vistas/FBuscarSwitch'),
('Switchs',2,24,'switches/vistas/FConsultarSwitch'),
('Crear',2,24,'switches/vistas/FCrearSwitch'),
('Buscar',2,25,'usuarios/vistas/FBuscarUsuario'),
('Crear',2,25,'usuarios/vistas/FCrearUsuario'),
('Conversor fecha',2,26,'utilidades/vistas/FConvertirFechas'),
('Encriptador',2,26,'utilidades/vistas/FEncriptador')

insert into [dbo].[log_actividad]
select 'SCRIPT','seg_usuario','CREACION', id, GETDATE() from [dbo].seg_permiso order by id

-- RELACION PERMISOS-PERFILES ======================================================================

insert into seg_perfil_permiso select 1, id from seg_permiso order by id

-- MODOS DE PROCESAMIENTO ===========================================================================

insert into cap.dbo.psa_modo values
('On-line', 'Activo'),
('Batch', 'Activo'),
('Tiempo real', 'Activo'),
('Paralelo', 'Activo'),
('Distribuido', 'Activo')

insert into [dbo].[log_actividad]
select 'SCRIPT','psa_modo','CREACION', id, GETDATE() from [dbo].[psa_modo] order by id

-- LUGARES DE PROCESAMIENTO ==========================================================================

insert into [dbo].[psa_lugar] values
('Entidad','Activo'),
('Tercero - Local','Activo'),
('Tercero - Exterior','Activo')

insert into [dbo].[log_actividad]
select 'SCRIPT','psa_lugar','CREACION', id, GETDATE() from [dbo].[psa_lugar] order by id

-- PLATAFORMAS DE SISTEMA OPERATIVO ===================================================================

insert into [dbo].[pla_plataformaSO] values
('Windows Server','Activa'),
('Unix','Activa'),
('Linux','Activa'),
('DOS','Activa'),
('BSD','Activa'),
('Solaris','Activa'),
('Mac','Activa'),
('Propietaria','Activa')

insert into [dbo].[log_actividad]
select 'SCRIPT','pla_plataformaSO','CREACION', id, GETDATE() from [dbo].[pla_plataformaSO] order by id

-- SITIOS ==============================================================================================

insert into [dbo].[sit_sitio] values
('CPP1','CPD','Centro de Procesamiento Principal 1','San Juan','San Juan',5402,'Av. J. Ignacio de la Roza 85','Tercerizado', 'Activo'),
('CPP2','CPD','Centro de Procesamiento Principal 2','Santa Cruz','Río Gallegos',9400,'Av. Presidente Néstor C. Kirchner Nº812','Propio', 'Activo'),
('CPA1','CPD','Centro de Procesamiento Alternativo 1','Entre Ríos','Parana',3100,'Monte Casero Nº128','Tercerizado', 'Activo'),
('CPA2','CPD','Centro de Procesamiento Alternativo 2','Santa Cruz','Río Gallegos',9400,'Perito Moreno 157','Propio', 'Activo'),
('URP1','SAR','Sitio de Resguardo Principal 1','San Juan','San Juan',5402,'Av. J. Ignacio de la Roza 85','Tercerizado', 'Activo'),
('URP2','SAR','Sitio de Resguardo Principal 2','Santa Cruz','Río Gallegos',9400,'Av. Presidente Néstor C. Kirchner Nº812','Propio', 'Activo'),
('URS1','SAR','Sitio de Resguardo Secundario 1','San Juan','Caucete',5442,'Sarmiento esquina Laprida','Tercerizado', 'Activo'),
('URS2','SAR','Sitio de Resguardo Secundario 2','Santa Cruz','Río Gallegos',9400,'Perito Moreno 157','Propio', 'Activo'),
('01','SUC','Rio Gallegos','Santa Cruz','Rio Gallegos',9400,'Av.Pte Nestor Kirchner N° 812','Propio', 'Activo'),
('05','SUC','Buenos Aires','Buenos Aires','Buenos Aires',1001,'Suipacha 1065','Propio', 'Activo'),
('10','SUC','Caleta Olivia','Santa Cruz','Caleta Olivia',9011,'Avda. Independencia N° 1070','Propio', 'Activo'),
('15','SUC','Rio Turbio','Santa Cruz','Rio Turbio',9407,'Gobernador Lista N° 222','Propio', 'Activo'),
('20','SUC','Piedra Buena','Santa Cruz','Piedra Buena',9303,'Av.Gregorio Ibañez N° 168','Propio', 'Activo'),
('25','SUC','El Calafate','Santa Cruz','El Calafate',9405,'Avda. Del Libertador N° 1285','Propio', 'Activo'),
('30','SUC','Gobernador Gregores','Santa Cruz','Gobernador Gregores',9311,'Avda. San Martin N° 402','Propio', 'Activo'),
('40','SUC','Perito Moreno','Santa Cruz','Perito Moreno',9040,'Avda San Martin 1493','Propio', 'Activo'),
('41','SUC','Los Antiguos','Santa Cruz','Los Antiguos',9041,'Avda. 11 De Julio N° 531','Propio', 'Activo'),
('45','SUC','Las Heras','Santa Cruz','Las Heras',9017,'Antiguos Pobladores N°418','Propio', 'Activo'),
('50','SUC','Pico Truncado','Santa Cruz','Pico Truncado',9015,'Hipolito Irigoyen Y 9 De Julio','Propio', 'Activo'),
('55','SUC','Puerto Deseado','Santa Cruz','Puerto Deseado',9050,'San Martin N° 1056','Propio', 'Activo'),
('60','SUC','San Julian','Santa Cruz','San Julian',9310,'Av.San Martin N° 595','Propio', 'Activo'),
('70','SUC','Santa Cruz','Santa Cruz','Santa Cruz',9300,'Av.Piedra Buena N° 298','Propio', 'Activo'),
('75','SUC','Agencia Numero 1','Santa Cruz','Rio Gallegos',9400,'Perito Moreno 157','Propio', 'Activo'),
('80','SUC','Comodoro Rivadavia','Chubut','Comodoro Rivadavia',9000,'Avda. San Martin N° 175','Propio', 'Activo'),
('85','SUC','28 De Noviembre','Santa Cruz','28 De Noviembre',9407,'Antartida Argentina N° 427','Propio', 'Activo'),
('95','SUC','Casa Central','Santa Cruz','Casa Central',9400,'Av  Pte Nestor Kirchner N° 812','Propio', 'Activo')

insert into [dbo].[log_actividad]
select 'SCRIPT','sit_sitio','CREACION', id, GETDATE() from [dbo].[sit_sitio] order by id