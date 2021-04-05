
from app.model.Resultado import Resultado
from app.service.ServicioPermiso import ServicioPermiso
import app.static.Constantes as Constantes

class ControladorPermiso():

    def __init__ (self):
        self.servicioPermiso = ServicioPermiso()

    # Devuelve un listado de todos los permisos de un determinado sistema
    # idSistema: Identificador del sistema
    # Retorna un objeto Resultado
    
    def getPermisosPorSistema(self, idSistema):
        if idSistema is not None and idSistema > 0:
            resultado = self.servicioPermiso.getPermisosPorSistema(idSistema)
            return resultado
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para obtener permisos del sistema', idSistema)
