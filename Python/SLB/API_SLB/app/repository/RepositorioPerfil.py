from app.repository.SQLServer import SQLServer
from app.model.Resultado import Resultado
from app.model.Perfil import Perfil
import app.static.Constantes as Constantes

# Repositorio de perfiles
# Administra todas las operaciones con la tabla de perfiles
# Tabla [SLB].[dbo].[perfil]
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel


class RepositorioPerfil():

    # Constructor de clase
    # Conexion: Recibe la conexion a la base de datos
    def __init__(self):
        self.conexion = SQLServer()
        self.formatoFecha = 'dd/MM/yyyy hh:mm'

    # Elimina un determinado perfil
    # id: Identificador del perfil
    # Retorna un objeto de tipo Resultado

    def deletePerfil(self, id):
        try:
            query = 'DELETE FROM perfil WHERE id = ?'
            count = self.conexion.update(query, [id])
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se eliminó el perfil correctamente', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se eliminó el perfil', None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al eliminar perfil', repr(error))

    # Elimina la relacion de un perfil con los permisos
    # id: Identificador del perfil
    # Retorna un objeto de tipo Resultado

    def deletePerfilPermiso(self, id):
        try:
            query = 'DELETE FROM perfil_permiso WHERE idPerfil = ?'
            count = self.conexion.update(query, [id])
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se eliminaron los permisos del perfil correctamente', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se eliminaron los permisos del perfil', None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al eliminar los permisos asociados al perfil', repr(error))
    
    # Obtiene los datos de un determinado perfil a partir de su identificador
    # Los permisos se setean en none
    # Id: Identificador del perfil
    # Retorna un objeto Resultado

    def getPerfil(self, id):
        try:
            query = 'SELECT id, idSistema, nombre, descripcion, estado, FORMAT(fechaCreacion, ?), FORMAT(fechaEdicion, ?) FROM perfil WHERE id = ?'
            row = self.conexion.get(query, [self.formatoFecha, self.formatoFecha, id])
            if (row is not None and len(row) > 0):
                perfil = Perfil(row[0], row[1], row[2], row[3], row[4], row[5], row[6])
                return Resultado(Constantes.CODES['SUC'], '', perfil.toJSON())
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron resultados para el perfil', None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al obtener la informacion del perfil', repr(error))

    # Devuelve un listado de los perfiles de un determinado sistema ordenados por nombre
    # idSistema: Identificador del sistema a consultar
    # Retorna un objeto Resultado

    def getPerfilesPorSistema(self, idSistema):
        try:
            query = 'SELECT p.id, p.nombre, p.descripcion, p.estado, FORMAT(p.fechaCreacion, ?), FORMAT(p.fechaEdicion, ?) '
            query += 'FROM perfil p INNER JOIN sistema s ON s.id = p.idSistema AND s.id = ? ORDER BY p.nombre'
            datos = self.conexion.select(query, [self.formatoFecha, self.formatoFecha, idSistema])
            perfiles = []
            if(len(datos) > 0):
                for row in datos:
                    perfil = Perfil(row[0], idSistema, row[1], row[2], row[3], row[4], row[5])
                    perfiles.append(perfil.toJSON())
                return Resultado(Constantes.CODES['SUC'], '', perfiles)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron perfiles para el sistema', perfiles)
        except Exception as error:
            mensaje = 'Error al consultar perfiles del sistema ({})'.format(idSistema)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Devuelve un listado de los perfiles de un determinado usuario ordenados por nombre
    # idUsuario: Identificador del usuario a consultar
    # Retorna un objeto Resultado

    def getPerfilPorUsuario(self, idUsuario):
        try:
            query = 'SELECT p.id, p.idSistema, s.nombreCorto, p.nombre, p.descripcion, p.estado, FORMAT(p.fechaCreacion, ?), FORMAT(p.fechaEdicion, ?) '
            query += 'FROM perfil p INNER JOIN usuario_perfil up ON up.idPerfil = p.id '
            query += 'INNER JOIN sistema s ON p.idSistema = s.id WHERE up.idUsuario = ?'
            datos = self.conexion.select(query, [self.formatoFecha, self.formatoFecha, idUsuario])
            perfiles = []
            if(datos is not None and len(datos) > 0):
                for row in datos:
                    perfil = Perfil(row[0], row[1], row[3], row[4], row[5], row[6], row[7])
                    data = perfil.toJSON()
                    data.update({'nombreSistema':row[2]})
                    perfiles.append(data)
                return Resultado(Constantes.CODES['SUC'], '', perfiles)
            else:
                mensaje = 'No se encontraron perfiles para el usuario ({})'.format(idUsuario)
                return Resultado(Constantes.CODES['WAR'], mensaje, perfiles)
        except Exception as error:
            mensaje = 'Error al consultar perfiles del usuario ({})'.format(idUsuario)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Obtiene la informacion del perfil para un determinado usuario en un determinado sistema
    # idUsuario: Numero de legajo del usuario
    # codigoSistema: Codigo del sistema
    # Retorna un objeto de tipo Resultado

    def getPerfilPorUsuarioSistema(self, idUsuario, codigoSistema):
        try:
            query = 'SELECT p.id, p.idSistema, p.nombre, p.descripcion, p.estado, FORMAT(p.fechaCreacion, ?), FORMAT(p.fechaEdicion, ?) '
            query += 'FROM perfil p INNER JOIN usuario_perfil up ON up.idPerfil = p.id '
            query += 'INNER JOIN sistema s ON p.idSistema = s.id WHERE up.idUsuario = ? AND s.codigo = ?'
            row = self.conexion.get(query, [self.formatoFecha, self.formatoFecha, idUsuario, codigoSistema])
            perfiles = []
            if(row is not None and len(row) > 0):
                perfil = Perfil(row[0], row[1], row[2], row[3], row[4], row[5], row[6])
                return Resultado(Constantes.CODES['SUC'], '', perfil.toJSON())
            else:
                mensaje = 'No se encontraron perfiles para el usuario ({})'.format(idUsuario)
                return Resultado(Constantes.CODES['WAR'], mensaje, perfiles)
        except Exception as error:
            mensaje = 'Error al consultar perfiles del usuario ({})'.format(idUsuario)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Agrega un nuevo perfil a un determinado sistema
    # idSistema: Identificador del sistema al que pertenece
    # nombre: Nombre del nuevo perfil
    # descripcion: Descripcion del perfil
    # Retorna un objeto Resultado

    def insertPerfil(self, idSistema, nombre, descripcion):
        try:
            query = 'INSERT INTO perfil (idSistema, nombre, descripcion, fechaCreacion, fechaEdicion, estado) OUTPUT inserted.id VALUES (?, ?, ?, GETDATE(), NULL, 1)'
            datos = [idSistema, nombre.strip(), descripcion.strip()]
            id = self.conexion.insertWithId(query, datos)
            if(id > 0):
                mensaje = 'Se realizó la creación del perfil correctamente ({})'.format(nombre)
                return Resultado(Constantes.CODES['SUC'], mensaje, id)
            else:
                mensaje = 'No se realizó la creación del perfil ({})'.format(nombre)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                return Resultado(Constantes.CODES['WAR'], 'No se pueden crear perfiles duplicados', repr(error))
            else:
                return Resultado(Constantes.CODES['ERR'], 'Error al crear perfil', repr(error))

    # Asocia un perfil a multiples permisos
    # idPerfil: Identificador del perfil
    # permisos: Listado de identificadores de permisos

    def insertPerfilPermiso(self, idPerfil, permisos):
        try:
            query = 'INSERT INTO perfil_permiso (idPerfil, idPermiso) VALUES (?, ?)'
            datos = []
            for idPermiso in permisos:
                datos.append([idPerfil, idPermiso])
            count = self.conexion.inserts(query, datos)
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se asociaron los permisos correctamente', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se asociaron los permisos al perfil', None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                return Resultado(Constantes.CODES['WAR'], 'No se pueden asociar permisos duplicados al mismo perfil', None)
            else:
                return Resultado(Constantes.CODES['ERR'], 'Error al asociar permisos al perfil', repr(error))

    # Modifica los datos de un determinado perfil
    # Id: Identificador del perfil
    # Nombre: Nuevo nombre
    # Descripcion: Nueva descripcion
    # Estado: Nuevo estado
    # Retorna un objeto Resultado

    def updatePerfil(self, id, nombre, descripcion, estado):
        try:
            query = 'UPDATE perfil SET nombre=?, descripcion=?, estado=?, fechaEdicion=GETDATE() WHERE id = ?'
            datos = [nombre.strip(), descripcion.strip(), estado, id]
            count = self.conexion.update(query, datos)
            if(count > 0):
                mensaje = 'Se modificó el perfil correctamente ({})'.format(nombre)
                return Resultado(Constantes.CODES['SUC'],mensaje , None)
            else:
                mensaje = 'No se modificó la información del perfil ({})'.format(nombre)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            mensaje = 'Error al modificar la información del perfil ({})'.format(nombre)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))
