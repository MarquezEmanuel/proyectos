from app.repository.SQLServer import SQLServer
from app.model.Resultado import Resultado
import app.static.Constantes as Constantes

# Repositorio de log para accesos a las aplicaciones
# Administra todas las operaciones con la tabla de log_acceso
# Tabla [SLB].[dbo].[log_acceso]
#
# Autor: Aguero Emiliano 
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class RepositorioLogAcceso():

    # Constructor de clase
    # Conexion: Recibe la conexion a la base de datos

    def __init__(self):
        self.conexion = SQLServer()

    def get(self, idUsuario, idSistema):
        try:
            query = 'SELECT contador FROM log_acceso WHERE idUsuario = ? AND idSistema=?'
            row = self.conexion.get(query, [idUsuario, idSistema])
            if(len(row) > 0):
                return Resultado(Constantes.CODES['SUC'], '', row[0])
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron resultados para el usuario', None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERROR'], 'Error al consultar información de acceso del usuario', repr(error)) 

    # Agrega un nuevo acceso de un usuario a un sistema
    # idUsuario: Numero de legajo del usuario
    # idSistema: Identificador del sistema

    def insert(self, idUsuario, idSistema):
        try:
            query = 'INSERT INTO log_acceso (idUsuario, idSistema, contador) VALUES (?, ?, ?)'
            datos = [idUsuario, idSistema, 1]
            count =  self.conexion.insert(query, datos)
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se registró el acceso al sistema correctamente', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se realizó el registro de acceso al sistema', None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                return Resultado(Constantes.CODES['WAR'], 'No se pueden crear registros de acceso duplicados', repr(error))
            else:
                return Resultado(Constantes.CODES['ERROR'], 'Error al crear registro de acceso', repr(error))

    # Incrementa en uno el contador de accesos al sistema para el usuario
    # idUsuario: Numero de legajo del usuario
    # idSistema: Identificador del sistema

    def updateContador(self, idUsuario, idSistema):
        try:
            query = 'UPDATE log_acceso SET contador = contador + 1 WHERE idUsuario=? AND idSistema=?'
            datos = [idUsuario, idSistema]
            count = self.conexion.update(query, datos)
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se registró nuevo acceso', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se realizó el registro de acceso al sistema', None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                return Resultado(Constantes.CODES['ERROR'], 'Error al actualizar registro de acceso', repr(error))