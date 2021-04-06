
from app.service.Servicio import Servicio
from app.repository.RepositorioLog import RepositorioLog
from app.repository.RepositorioPermiso import RepositorioPermiso

class ServicioPermiso(Servicio):

    def __init__(self):
        super().__init__()
        self.repoPermiso = RepositorioPermiso()

    # Devuelve un listado de todos los permisos de un determinado sistema
    # idSistema: Identificador del sistema
    # Retorna un objeto Resultado

    def getPermisosPorSistema(self, idSistema):
        resultado = self.repoPermiso.getPermisosPorSistema(idSistema)
        self._guardarLog(resultado)
        return resultado