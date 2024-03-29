from cerberus import Validator
from app.model.Resultado import Resultado
from app.service.ServicioSistema import ServicioSistema
import app.static.Constantes as Constantes

class ControladorSistema():

    def __init__ (self):
        self.servicioSistema = ServicioSistema()

    # Devuelve la informacion del sistema junto con el listado de perfiles que posee
    # id: Identificador del sistema
    # Retorna un objeto Resultado

    def getSistema(self, id):
        if id is not None and id > 0:
            return self.servicioSistema.getSistema(id)
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para obtener sistema', id)

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
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para listar sistemas de uso frecuente', idUsuario)

    # Agrega un nuevo sistema
    # Retorna un objeto Resultado

    def insertSistema(self, data):
        validador = Validator(Constantes.BD_SLB['SISTEMA'])
        if validador.validate(data):
            nombreCorto = data['nombreCorto']
            nombreLargo = data['nombreLargo']
            descripcion = data['descripcion']
            produccion = data['URLProduccion']
            test = data['URLTest']
            imagen = data['imagen']
            estado = data['estado']
            codigo = data['codigo']
            return self.servicioSistema.insert(nombreCorto, nombreLargo, descripcion, produccion, test, imagen, estado, codigo) 
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para crear sistema', data)

    def updateSistema(self, data):
        validador = Validator(Constantes.BD_SLB['SISTEMA'])
        if data is not None and validador.validate(data):
            id = data['id']
            nombreCorto = data['nombreCorto']
            nombreLargo = data['nombreLargo']
            descripcion = data['descripcion']
            URLProduccion = data['URLProduccion']
            URLTest = data['URLTest']
            imagen = data['imagen']
            estado = data['estado']
            codigo = data['codigo']
            return self.servicioSistema.updateSistema(nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo, id) 
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para actualizar sistema', data)