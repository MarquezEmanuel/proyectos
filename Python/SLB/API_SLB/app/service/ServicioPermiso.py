
from app.repository.RepositorioLog import RepositorioLog
from app.repository.RepositorioPermiso import RepositorioPermiso

class ServicioPermiso:

    def __init__(self):
        self.repoLog = RepositorioLog()
        self.repoPermiso = RepositorioPermiso()

    # Devuelve un listado de todos los permisos de un determinado sistema
    # idSistema: Identificador del sistema
    # Retorna un objeto Resultado

    def getPermisosPorSistema(self, idSistema):
        resultado = self.repoPermiso.getPermisosPorSistema(idSistema)
        if(resultado.error()):
            self.repoLog.error(resultado.mensaje)
            self.repoLog.error(resultado.datos)
        return resultado