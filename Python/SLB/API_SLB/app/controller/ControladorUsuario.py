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

    # Retorna un listado de todos los usuarios

    def getUsuarios(self):
        return self.servicioUsuario.getUsuarios()

    # Agrega un nuevo acceso de un usuario a un sistema
    # legajo: Numero de legajo del usuario
    # idSistema: Identificador del sistema

    def insertUsuarioAcceso(self, data):
        validador = Validator(Constantes.BD_SLB['USUARIO_ACCESO'])
        if validador.validate(data):
            resultado = self.servicioUsuario.insertUsuarioAcceso(data['idUsuario'], data['idSistema'])
            return resultado
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para crear log', data)
            
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



