from cerberus import Validator
from app.model.Encriptador import Encriptador
from app.model.Resultado import Resultado
from app.static.Schemas import LOGIN_SCHEMA

import app.static.Constantes as Constantes
from app.service.ServicioUsuario import ServicioUsuario

class ControladorUsuario():

    def __init__(self):
        self.servicioUsuario = ServicioUsuario()
    
    #def consultarEstadoConexion(self, legajo):
    #    resultado = self.repositorioUsuario.consultarEstadoConexion(legajo)
    #    if(resultado.valido() == False):s
    #        print(self.conexion.logs)
    #    return resultado

    #def consultarUsuario(self, legajo):
    #    resultado = self.repositorioUsuario.consultarUsuario(legajo)
    #    if(resultado.valido() == False):
    #        print(self.c#onexion.logs)
    #    return resultado

    # Retorna un listado de todos los usuarios

    def getUsuarios(self):
        resultado = self.servicioUsuario.getUsuarios()
        return resultado

    # Verifica un usuario en Active Directory y en la base de datos para indicar su conexion

    def login(self, data):
        validador = Validator(LOGIN_SCHEMA)
        if validador.validate(data):
            encriptador = Encriptador()
            legajo = data['legajo']
            clave = encriptador.desencriptarBase64(data['clave'])
            resultado = self.servicioUsuario.login(legajo, clave)
            return resultado
        return Resultado(Constantes.CODE_ERROR, 'Los datos recibidos son incorrectos para realizar login', data)



