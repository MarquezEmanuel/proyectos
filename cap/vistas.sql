
  create view vwbas_base as
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
  sde.id sid,
  sde.nombre snombre,
  sde.tipo stipo,
  (CASE WHEN tab.tablas IS NULL THEN 0 ELSE tab.tablas END) btablas,
  (CASE WHEN vis.vistas IS NULL THEN 0 ELSE vis.vistas END) bvistas,
  (CASE WHEN pro.sps IS NULL THEN 0 ELSE pro.sps END) bprocedimientos,
  bas.fechaProceso bfechaProceso,
  bas.rti brti,
  bas.estado bestado
  from [CAP].[dbo].[bas_base] bas
  left join cap.dbo.ser_servidor spr on spr.id = bas.produccion
  left join cap.dbo.ser_servidor ste on spr.id = bas.test
  left join cap.dbo.ser_servidor sde on spr.id = bas.desarrollo
  left join (select base, count(id) tablas from [dbo].[bas_tabla] group by base) tab on tab.base = bas.id
  left join (select base, count(id) vistas from [dbo].[bas_vista] group by base) vis on vis.base = bas.id
  left join (select base, count(id) sps from [dbo].[bas_procedimiento] group by base) pro on pro.base = bas.id
  
  
  
 
  
  