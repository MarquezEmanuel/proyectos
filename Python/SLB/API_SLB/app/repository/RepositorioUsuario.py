from app.repository.SQLServer import SQLServer
from app.model.Resultado import Resultado
from app.model.Usuario import Usuario
import app.static.Constantes as Constantes

# Repositorio de usuarios
# Administra todas las operaciones con la tabla de usuarios
# Tabla [SLB].[dbo].[usuario]
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class RepositorioUsuario():

    # Constructor de la clase
    # Conexion: Recibe la conexion a la base de datos

    def __init__(self):
        self.conexion = SQLServer()
        self.formatoFecha = 'dd/MM/yyyy hh:mm'

    # Elimina un determinado usuario a partir de su legajo
    # legajo: Numero de legajo del usuario
    # Retorna un objeto Resultado

    def deleteUsuario(self, legajo):
        try:
            query = 'DELETE FROM usuario WHERE id = ?'
            count = self.conexion.update(query, [legajo])
            if(count > 0):
                mensaje = 'Se eliminó el usuario correctamente ({})'.format(legajo)
                return Resultado(Constantes.CODES['SUC'], mensaje, None)
            else:
                mensaje = 'No se realizó la eliminación del usuario ({})'.format(legajo)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            mensaje = 'Error al eliminar usuario ({})'.format(legajo)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Realiza la eliminacion de los perfiles asociados a un determinado usuario a partir del legajo
    # legajo: Numero de legajo del usuario
    # Retorna un objeto Resultado

    def deleteUsuarioPerfil(self, legajo):
        try:
            query = 'DELETE FROM usuario_perfil WHERE idUsuario = ?'
            count = self.conexion.update(query, [legajo])
            if(count > 0):
                mensaje = 'Se eliminaron los perfiles del usuario correctamente ({})'.format(
                    legajo)
                return Resultado(Constantes.CODES['SUC'], mensaje, None)
            else:
                mensaje = 'No se realizó la eliminación de los perfiles del usuario ({})'.format(
                    legajo)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            mensaje = 'Error al eliminar perfiles de usuario ({})'.format(legajo)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Obtiene los datos de un determinado usuario a partir de su numero de legajo
    # Legajo: Numero de legajo
    # Retorna un objeto Resultado

    def getUsuario(self, legajo):
        try:
            query = 'SELECT id, apellido, nombre, imagen, marcaAdministrador, idInvGate, FORMAT(fechaCreacion, ?), FORMAT(fechaEdicion, ?) '
            query += 'FROM usuario WHERE id = ?'
            row = self.conexion.get(query, [self.formatoFecha, self.formatoFecha, legajo])
            if (row is not None and len(row) > 0):
                usuario = Usuario(row[0],
                                  row[1],
                                  row[2],
                                  row[3],
                                  row[4],
                                  row[5],
                                  row[6],
                                  row[7])
                return Resultado(Constantes.CODES['SUC'], '', usuario.toJSON())
            else:
                mensaje = 'No se encontraron resultados para el usuario ({})'.format(legajo)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            mensaje = 'Error al obtener la información del usuario ({})'.format(legajo)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Devuelve un listado de todos los usuarios ordenados por id
    # Retorna un objeto Resultado

    def getUsuarios(self):
        try:
            query = 'SELECT id, apellido, nombre, imagen, marcaAdministrador, idInvGate, FORMAT(fechaCreacion, ?), FORMAT(fechaEdicion, ?) '
            query += 'FROM usuario ORDER BY id'
            datos = self.conexion.select(query, [self.formatoFecha, self.formatoFecha])
            usuarios = []
            if(len(datos) > 0):
                for row in datos:
                    usuario = Usuario(row[0],
                                      row[1],
                                      row[2],
                                      row[3],
                                      row[4],
                                      row[5],
                                      row[6],
                                      row[7])
                    usuarios.append(usuario.toJSON())
                return Resultado(Constantes.CODES['SUC'], '', usuarios)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron usuarios para listar', usuarios)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al consultar usuarios', repr(error))

    # Agrega un nuevo usuario
    # Legajo: Numero de legajo del usuario
    # Apellido: Apellido de usuario
    # Nombre: Nombre de usuario
    # Retorna un objeto Resultado

    def insertUsuario(self, legajo, apellido, nombre, esAdministrador, idInvGate):
        try:
            query = 'INSERT INTO usuario (id, apellido, nombre, imagen, marcaAdministrador, idInvGate, fechaCreacion, fechaEdicion) '
            query += 'VALUES (?, ?, ?, ?, ?, ?, GETDATE(), NULL)'
            count = self.conexion.insert(query, [legajo.strip(), apellido.strip(
            ), nombre.strip(), 'default', esAdministrador, idInvGate])
            if(count > 0):
                mensaje = 'Se creó el usuario correctamente ({}, {})'.format(apellido, nombre)
                return Resultado(Constantes.CODES['SUC'], mensaje, None)
            else:
                mensaje = 'No se realizó la creación del usuario ({})'.format(legajo)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                mensaje = 'No se pueden crear usuarios duplicados ({})'.format(legajo)
                return Resultado(Constantes.CODES['WAR'], mensaje, repr(error))
            else:
                return Resultado(Constantes.CODES['ERR'], 'Error al crear usuario', repr(error))

    # Relaciona un usuario a multiples perfiles
    # idUsuario: Legajo de usuario
    # perfiles: Listado de identificadores de perfiles

    def insertUsuarioPerfil(self, idUsuario, perfiles):
        try:
            query = 'INSERT INTO usuario_perfil (idUsuario, idPerfil) VALUES (?, ?)'
            datos = []
            for perfil in perfiles:
                datos.append([idUsuario, perfil])
            count = self.conexion.inserts(query, datos)
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se asociaron los perfiles correctamente', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se asociaron los perfiles al usuario', None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                return Resultado(Constantes.CODES['WAR'], 'No se pueden asociar perfiles duplicados al mismo usuario', None)
            else:
                return Resultado(Constantes.CODES['ERR'], 'Error al asociar perfiles al usuario', repr(error))

    # Modifica los datos de un determinado usuario
    # Legajo: Numero de legajo del usuario a modificar
    # Apellido: Apellido del usuario
    # Nombre: Nombre del usuario
    # Imagen: Imagen del usuario
    # marcaAdministrador: Indica si el usuario es administrador o no
    # idInvGate: Identificador del usuario en InvGate
    # Retorna un objeto Resultado

    def updateUsuario(self, legajo, apellido, nombre, imagen, marcaAdministrador, idInvGate):
        try:
            query = 'UPDATE usuario SET apellido = ?, nombre = ?, imagen = ?, marcaAdministrador = ?, idInvGate = ?, fechaEdicion = GETDATE() WHERE id = ?'
            count = self.conexion.update(query, [apellido, nombre, imagen, marcaAdministrador, idInvGate, legajo])
            if(count > 0):
                mensaje = 'Se modificó la información del usuario correctamente ({})'.format(legajo)
                return Resultado(Constantes.CODES['SUC'], mensaje, None)
            else:
                mensaje = 'No se modificó la información del usuario ({})'.format(legajo)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al modificar información del usuario', repr(error))
