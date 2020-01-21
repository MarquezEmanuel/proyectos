
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