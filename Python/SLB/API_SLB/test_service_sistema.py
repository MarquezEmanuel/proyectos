
from app.service.ServicioSistema import ServicioSistema

servicio = ServicioSistema()

print('---------------------------------------INSERT')
resultado = servicio.insert('PaProd','Pases a producción','Pases a producción','VM000APL02:9000','VM172APL02:9000','default.png',1)
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('---------------------------------------UPDATE')
resultado = servicio.update('PaProd','Pases a producción','Pases a producción','VM000APL02:9000','VM172APL02:9000','paprod.png', 0, 3)
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- GET SISTEMA')
resultado = servicio.getSistema(1)
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('---------------------------------------GET SISTEMAS')
resultado = servicio.getSistemas()
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')


