from app.repository.SQLServer import SQLServer
from app.service.Servicio import Servicio

from app.repository.RepositorioPerfil import RepositorioPerfil
from app.repository.RepositorioPermiso import RepositorioPermiso
from app.repository.RepositorioSistema import RepositorioSistema

class ServicioPerfil(Servicio):

    def __init__(self):
        super().__init__()
        self.repoPerfil = RepositorioPerfil()
        self.repoPermiso = RepositorioPermiso()
        self.repoSistema = RepositorioSistema()

    # Elimina un determinado perfil y los permisos que posee asociados
    # id: Identificador del perfil
    # Retorna un objeto de tipo Resultado

    def deletePerfil(self, id):
        self._iniciarTransaccion()
        resultado01 = self.repoPerfil.deletePerfilPermiso(id)
        if resultado01.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado01)
            return resultado01
        resultado02 = self.repoPerfil.deletePerfil(id)
        self._finalizarTransaccion(resultado02.esValido())
        self._guardarLog(resultado02)
        return resultado02

    # Obtiene los datos de un determinado perfil a partir de su identificador
    # Obtiene los datos del sistema al que pertenece el perfil
    # Obtiene los datos de los permisos que posee el perfil
    # Id: Identificador del perfil
    # Retorna un objeto Resultado

    def getPerfil(self, id):
        resultado01 = self.repoPerfil.getPerfil(id)
        if(resultado01.esValido()):
            idSistema = resultado01.datos['idSistema']
            resultado02 = self.repoSistema.getSistema(idSistema)
            resultado03 = self.repoPermiso.getPermisosPorPerfil(id)
            if resultado02.esError():
                return resultado02
            if resultado03.esError():
                return resultado03
            resultado01.datos.update({'sistema': resultado02.datos})
            resultado01.datos.update({'permisos': resultado03.datos})
        return resultado01

    # Devuelve un listado de los perfiles de un determinado sistema ordenados por nombre
    # idSistema: Identificador del sistema a consultar
    # Retorna un objeto Resultado

    def getPerfilesPorSistema(self, idSistema):
        resultado = self.repoPerfil.getPerfilesPorSistema(idSistema)
        self._guardarLog(resultado)
        return resultado

    # Agrega un nuevo perfil a un determinado sistema
    # idSistema: Identificador del sistema al que pertenece
    # nombre: Nombre del nuevo perfil
    # descripcion: Descripcion del perfil
    # permisos: Listado de permisos asociados al perfil
    # Retorna un objeto Resultado

    def insertPerfil(self, idSistema, nombre, descripcion, permisos):
        self._iniciarTransaccion()
        resultado01 = self.repoPerfil.insertPerfil(idSistema, nombre, descripcion)
        if resultado01.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado01)
            return resultado01
        idPerfil = resultado01.datos
        resultado02 = self.repoPerfil.insertPerfilPermiso(idPerfil, permisos)
        if resultado02.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado02)
            return resultado02
        self._finalizarTransaccion(True)
        return resultado01

    # Modifica los datos de un determinado perfil
    # Id: Identificador del perfil
    # Nombre: Nuevo nombre
    # Descripcion: Nueva descripcion
    # Estado: Nuevo estado
    # Permisos: Listado de permisos asociados al perfil
    # Retorna un objeto Resultado

    def updatePerfil(self, id, nombre, descripcion, estado, permisos):
        self._iniciarTransaccion()
        resultados = []
        resultados.append(self.repoPerfil.deletePerfilPermiso(id))
        resultados.append(self.repoPerfil.insertPerfilPermiso(id, permisos))
        for resultado in resultados:
            if resultado.esValido() is False:
                self._finalizarTransaccion(False)
                self._guardarLog(resultado)
                return resultado
        resultado = self.repoPerfil.updatePerfil(id, nombre, descripcion, estado)
        self._finalizarTransaccion(resultado.esValido())
        return resultado
