USE [CAP]
GO

/****** Object:  View [dbo].[vwlog_actividad]    Script Date: 25/01/2020 05:26:30 p.m. ******/
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


