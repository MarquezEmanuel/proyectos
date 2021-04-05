from repository.SQLServer import SQLServer
from repository.repositorioPerfil import RepositorioPerfil
from repository.repositorioPermiso import RepositorioPermiso
from repository.repositorioLog import RepositorioLog

# Controlador de perfiles
# Controla los eventos del perfil
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel
class ControladorPerfil():

    # Constructor de clase
    def __init__(self):
        self.conexion = SQLServer()
        self.repositorioPerfil = RepositorioPerfil(self.conexion)
        self.repositorioPermiso = RepositorioPermiso(self.conexion)
        self.repositorioLog = RepositorioLog(self.conexion)

    # Agrega un nuevo perfil a un determinado sistema
    # idSistema: Identificador del sistema al que pertenece
    # nombre: Nombre del nuevo perfil
    # descripcion: Descripcion del perfil
    # permisos: Listado de identificadores de permisos
    # Retorna un objeto Resultado
    def crear(self, idSistema, nombre, descripcion, permisos):
        self.conexion.autoCommit(False)
        resultado01 = self.repositorioPerfil.crear(idSistema, nombre, descripcion)
        if(resultado01.valido()):
            idPerfil = resultado01.datos
            resultado02 = self.repositorioPerfil.asociarPerfilPermiso(idPerfil, permisos)
            if(resultado02.valido()):
                self.conexion.commit()
                self.conexion.autoCommit(True)
                return resultado01
            resultado01 = resultado02
        self.conexion.rollback()
        self.conexion.autoCommit(True)
        self.repositorioLog.errorMultiple(self.conexion.logs)
        return resultado01

    # Devuelve un listado de los perfiles de un determinado sistema ordenados por nombre
    # idSistema: Identificador del sistema a consultar
    # Retorna un objeto Resultado
    def listarPerfilesPorSistema(self, idSistema):
        resultado = self.repositorioPerfil.listarPerfilesPorSistema(idSistema)
        if(resultado.valido() == False):
            self.repositorioLog.errorMultiple(self.conexion.logs)
        return resultado

    # Obtiene la informacion de un perfil
    # id: Identificador del perfil
    # Retorna un objeto Resultado
    def obtener(self, id):
        resultado01 = self.repositorioPerfil.obtener(id)
        if(resultado01.valido()):
            resultado02 = self.repositorioPermiso.listarPermisosPorPerfil(id)
            if(resultado02.valido()):
                perfil = resultado01.datos
                perfil['permisos'] = resultado02.datos
                return resultado01
            resultado01 = resultado02
        self.repositorioLog.errorMultiple(self.conexion.logs)
        return resultado01
