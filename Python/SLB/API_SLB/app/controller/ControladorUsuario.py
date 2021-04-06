from cerberus import Validator
from app.service.ServicioUsuario import ServicioUsuario
from app.model.Encriptador import Encriptador
from app.model.Resultado import Resultado
import app.static.Constantes as Constantes

class ControladorUsuario():

    def __init__(self):
        self.servicioUsuario = ServicioUsuario()
    
    # Elimina un determinado usuario a partir de su legajo
    # legajo: Numero de legajo del usuario
    # Retorna un objeto Resultado

    def deleteUsuario(self, legajo):
        if legajo is not None:
            return self.servicioUsuario.deleteUsuario(legajo)
        return Resultado(Constantes.CODES['ERR'], 'El legajo recibido es incorrecto para eliminar usuario', legajo)

    # Obtiene los datos de un determinado usuario a partir de su numero de legajo
    # Legajo: Numero de legajo
    # Retorna un objeto Resultado

    def getUsuario(self, legajo):
        if legajo is not None:
            return self.servicioUsuario.getUsuario(legajo)
        return Resultado(Constantes.CODES['ERR'], 'El legajo recibido es incorrecto para obtener usuario', legajo)

    # Obtiene la informacion del usuario y el perfil asociado en un determinado sistema
    # legajo: Numero de legajo del usuario
    # codigoSistema: Codigo asignado al sistema
    # Retorna un objeto Resultado
    
    def getUsuarioSistema(self, legajo, codigoSistema):
        if legajo is not None and codigoSistema is not None:
            return self.servicioUsuario.getUsuarioSistema(legajo, codigoSistema)
        return Resultado(Constantes.CODES['ERR'], 'La información recibida es incorrecta para obtener usuario', legajo)

    # Retorna un listado de todos los usuarios

    def getUsuarios(self):
        return self.servicioUsuario.getUsuarios()

    # Agrega un nuevo usuario
    # Legajo: Numero de legajo del usuario
    # Apellido: Apellido de usuario
    # Nombre: Nombre de usuario
    # esAdministrador: True para usuarios PAI
    # idInvGate: Numero de identificador en InvGate
    # perfiles: Listado de perfiles asociados al usuario
    # Retorna un objeto Resultado
    
    def insertUsuario(self, data):
        validador = Validator(Constantes.BD_SLB['USUARIO'])
        if validador.validate(data):
            legajo = data['id']
            apellido = data['apellido']
            nombre = data['nombre']
            imagen = data['imagen']
            esAdministrador = data['marcaAdministrador']
            idInvGate = data['idInvGate']
            perfiles = data['perfiles']
            resultado = self.servicioUsuario.insertUsuario(legajo, apellido, nombre, imagen, esAdministrador, idInvGate, perfiles)
            return resultado
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para crear usuario', data)

    # Agrega un nuevo acceso de un usuario a un sistema
    # legajo: Numero de legajo del usuario
    # idSistema: Identificador del sistema

    def insertUsuarioAcceso(self, idUsuario, idSistema):
        if idUsuario is not None and idSistema is not None:
            resultado = self.servicioUsuario.insertUsuarioAcceso(idUsuario, idSistema)
            return resultado
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para registrar acceso', idSistema)
            
    # Verifica un usuario en Active Directory y en la base de datos para indicar su conexion

    def login(self, data):
        validador = Validator(Constantes.BD_SLB['USUARIO_LOGIN'])
        if validador.validate(data):
            encriptador = Encriptador()
            legajo = data['legajo']
            clave = encriptador.desencriptarBase64(data['clave'])
            resultado = self.servicioUsuario.login(legajo, clave)
            return resultado
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para realizar login', data)

    def updateUsuario(self, data):
        validador = Validator(Constantes.BD_SLB['USUARIO'])
        if validador.validate(data):
            legajo = data['id']
            apellido = data['apellido']
            nombre = data['nombre']
            imagen = data['imagen']
            esAdministrador = data['marcaAdministrador']
            idInvGate = data['idInvGate']
            perfiles = data['perfiles']
            return self.servicioUsuario.updateUsuario(legajo, apellido, nombre, imagen, esAdministrador, idInvGate, perfiles)
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para actualizar usuario', data)

