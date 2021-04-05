
from app.service.ServicioPerfil import ServicioPerfil

servicio = ServicioPerfil()

print('--------------------------------------- DELETE PERFIL')
resultado = servicio.deletePerfil(22)
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- INSERT PERFIL')
resultado = servicio.insertPerfil(1, 'Administrador de sistemas operativos', 'Analista funcional', ['CAP001', 'CAP002'])
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- UPDATE PERFIL')
resultado = servicio.updatePerfil(5, 'ADMINISTRADOR', 'Analista funcional', 1, ['CAP001', 'CAP002', 'CAP003'])
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- GET PERFIL')
resultado = servicio.getPerfil(1)
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- GET PERFILES POR SISTEMA')
resultado = servicio.getPerfilesPorSistema(1)
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')
