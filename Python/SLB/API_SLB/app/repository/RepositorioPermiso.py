from app.repository.SQLServer import SQLServer
from app.model.Resultado import Resultado
from app.model.Permiso import Permiso
from app.model.Subpermiso import Subpermiso
import app.static.Constantes as Constantes


# Repositorio de permisos
# Administra todas las operaciones con la tabla de permisos
# Tabla [SLB].[dbo].[permiso]
#
# Autor: Aguero Emiliano 
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class RepositorioPermiso():

    # Constructor de clase
    # Conexion: Recibe la conexion a la base de datos

    def __init__(self):
        self.conexion = SQLServer()

    # Devuelve un listado de todos los permisos de un determinado perfil
    # idSistema: Identificador del sistema
    # Retorna un objeto Resultado

    def getPermisosPorPerfil(self, idPerfil):
        try:
            query =  'SELECT p.id, p.titulo, p.descripcion, p.link FROM permiso p '
            query += 'INNER JOIN perfil_permiso r ON r.idPermiso = p.id AND r.idPerfil = ? '
            query += 'WHERE p.nivel = ? ORDER BY p.titulo'
            datos = self.conexion.select(query, [idPerfil, 1])
            permisos = []
            if (datos is not None and len(datos) > 0):
                for row in datos:
                    resultado = self.getSubPermisos(row[0])
                    if resultado.esError():
                        return resultado
                    permiso = Permiso(row[0], row[1], row[2], row[3], resultado.datos)
                    permisos.append(permiso.toJSON())
                return Resultado(Constantes.CODES['SUC'], '', permisos)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron permisos para listar', permisos)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al obtener los permisos del perfil', repr(error))

    # Devuelve un listado de todos los permisos de un determinado sistema
    # idSistema: Identificador del sistema
    # Retorna un objeto Resultado

    def getPermisosPorSistema(self, idSistema):
        try:
            query = 'SELECT id, titulo, descripcion, link FROM permiso WHERE idSistema = ? AND nivel = ? ORDER BY titulo'
            datos = self.conexion.select(query, [idSistema, 1])
            permisos = []
            if (datos is not None and len(datos) > 0):
                for row in datos:
                    resultado = self.getSubPermisos(row[0])
                    if(resultado.esError()):
                        return resultado
                    permiso = Permiso(row[0], row[1], row[2], row[3], resultado.datos)
                    permisos.append(permiso.toJSON())
                return Resultado(Constantes.CODES['SUC'], '', permisos)   
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron permisos para listar', permisos)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al obtener los permisos del sistema', repr(error)) 

    # Devuelve un listado de todos subpermisos (nivel 2) de un determinado permiso (nivel 1)
    # idPadre: Identificador del permiso padre 
    # Retorna un objeto Resultado

    def getSubPermisos(self, idPadre):
        try:
            query = 'SELECT id, titulo, descripcion, link FROM permiso WHERE idPadre = ? AND nivel = ? ORDER BY titulo'
            datos = self.conexion.select(query, [idPadre, 2])
            subpermisos = []
            if(datos is not None and len(datos) > 0):
                for row in datos:
                    subpermiso = Subpermiso(row[0], row[1], row[2], row[3])
                    subpermisos.append(subpermiso.toJSON())
                return Resultado(Constantes.CODES['SUC'], '', subpermisos)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron subpermisos para listar', subpermisos)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al obtener los subpermisos', repr(error))

    