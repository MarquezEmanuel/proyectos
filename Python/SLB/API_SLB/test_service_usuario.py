
from app.service.ServicioUsuario import ServicioUsuario

servicio = ServicioUsuario()

print('--------------------------------------- DELETE USUARIO')
resultado = servicio.deleteUsuario('07000')
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:', resultado.datos)
print('---------------------------------------')

print('--------------------------------------- INSERT USUARIO')
resultado = servicio.insertUsuario('07001', 'Riquelme', 'Juan Roman', 0, 10, [1])
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- UPDATE USUARIO')
resultado = servicio.updateUsuario('07001', 'Riquelme', 'Juan Roman', 'roman.jpg', 1, 10, [1])
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- GET USUARIO')
resultado = servicio.getUsuario('0741')
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- GET USUARIOS')
resultado = servicio.getUsuarios()
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')

print('--------------------------------------- LOGIN')
resultado = servicio.login('07489', 'av')
print('Codigo:', resultado.codigo)
print('Mensaje:', resultado.mensaje)
print('Datos:',resultado.datos)
print('---------------------------------------')
