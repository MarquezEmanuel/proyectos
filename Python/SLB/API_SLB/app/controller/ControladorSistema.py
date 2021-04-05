from cerberus import Validator
from model.Resultado import Resultado
from service.ServicioSistema import ServicioSistema

import static.Constantes as Constantes

class ControladorSistema():

    def __init__ (self):
        self.servicioSistema = ServicioSistema()

    # Devuelve la informacion del sistema junto con el listado de perfiles que posee
    # id: Identificador del sistema
    # Retorna un objeto Resultado

    def get(self, id):
        if id is not None and id > 0:
            resultado = self.servicioSistema.get(id)
            return resultado
        return Resultado(Constantes.CODE_ERROR, 'Los datos recibidos son incorrectos para obtener sistema', id)

    # Devuelve un listado de todos los sistemas ordenados por su nombre corto
    # Retorna un objeto Resultado
    
    def getSistemas(self):
        resultado = self.servicioSistema.getSistemas()
        return resultado

    # Devuelve un listado de los sistemas ordenados segun la frecuencia de acceso del usuario y con el perfil que posea
    # idUsuario: Numero de legajo del usuario
    # Retorna un objeto Resultado
    
    def getSistemasFrecuentesUsuario(self, idUsuario):
        if idUsuario is not None:
            resultado = self.servicioSistema.getSistemasFrecuentesUsuario(idUsuario)
            return resultado
        return Resultado(Constantes.CODE_ERROR, 'Los datos recibidos son incorrectos para listar sistemas de uso frecuente', idUsuario)

    # Agrega un nuevo sistema
    # Retorna un objeto Resultado

    def insert(self, data):
        validador = Validator(SISTEMA_SCHEMA)
        if validador.validate(data):
            nombreCorto = data['nombreCorto']
            nombreLargo = data['nombreLargo']
            descripcion = data['descripcion']
            produccion = data['URLProduccion']
            test = data['URLTest']
            imagen = data['imagen']
            estado = data['estado']
            resultado = self.servicioSistema.insert(nombreCorto, nombreLargo, descripcion, produccion, test, imagen, estado)
            return resultado
        return Resultado(Constantes.CODE_ERROR, 'Los datos recibidos son incorrectos para crear sistema', data)
