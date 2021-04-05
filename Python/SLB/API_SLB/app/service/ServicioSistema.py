
from app.service.Servicio import Servicio
from app.repository.RepositorioPerfil import RepositorioPerfil
from app.repository.RepositorioSistema import RepositorioSistema


class ServicioSistema(Servicio):

    def __init__(self):
        super().__init__()
        self.repoSistema = RepositorioSistema()
        self.repoPerfil = RepositorioPerfil()

    # Devuelve la informacion del sistema junto con el listado de perfiles que posee
    # id: Identificador del sistema
    # Retorna un objeto Resultado

    def getSistema(self, id):
        resultados = []
        resultados.append(self.repoSistema.getSistema(id))
        resultados.append(self.repoPerfil.getPerfilesPorSistema(id))
        error = self._chequearErrores(resultados)
        if error is not None:
            return error
        resultado = resultados[0]
        if resultado.esValido():
            resultado.datos.update({'perfiles': resultados[1].datos})
        self._guardarLogs(resultados)
        return resultado

    # Devuelve un listado de todos los sistemas ordenados por su nombre corto
    # Retorna un objeto Resultado

    def getSistemas(self):
        resultado = self.repoSistema.getSistemas()
        error = self._chequearErrores([resultado])
        if error is not None:
            return error
        self._guardarLogs([resultado])
        return resultado

    # Devuelve un listado de los sistemas ordenados segun la frecuencia de acceso del usuario y con el perfil que posea
    # idUsuario: Numero de legajo del usuario
    # Retorna un objeto Resultado

    def getSistemasFrecuentesUsuario(self, idUsuario):
        resultado = self.repoSistema.getSistemasFrecuentesUsuario(idUsuario)
        if(resultado.error()):
            self.repoLog.error(resultado.mensaje)
            self.repoLog.error(resultado.datos)
        return resultado

    # Agrega un nuevo sistema
    # nombreCorto: Nombre corto de la aplicacion
    # nombreLargo: Nombre largo de la aplicacion
    # descripcion: Descripcion de la funcionalidad
    # URLProduccion: URL del sistema en el ambiente de produccion
    # URLTest: URL del sistema en el ambiente de test
    # estado: Estado del sistema
    # codigo: Codigo asignado al sistema para usar desde los backs
    # Retorna un objeto Resultado

    def insert(self, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo):
        resultado = self.repoSistema.insert(nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo)
        self._guardarLogs([resultado])
        return resultado

    # Actualiza la informacion del sistema
    # nombreCorto: Nombre corto de la aplicacion
    # nombreLargo: Nombre largo de la aplicacion
    # descripcion: Descripcion de la funcionalidad
    # URLProduccion: URL del sistema en el ambiente de produccion
    # URLTest: URL del sistema en el ambiente de test
    # estado: Estado del sistema
    # codigo: Codigo asignado al sistema para usar desde los back
    # id: Identificador del sistema
    # Retorna un objeto Resultado
    
    def update(self, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo, id):
        resultado = self.repoSistema.update(nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, id)
        self._guardarLogs([resultado])
        return resultado
