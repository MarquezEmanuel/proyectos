from app.repository.SQLServer import SQLServer
from app.model.Resultado import Resultado
from app.model.Sistema import Sistema
import app.static.Constantes as Constantes

# Repositorio de permisos
# Administra todas las operaciones con la tabla de permisos
# Tabla [SLB].[dbo].[sistema]
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class RepositorioSistema():

    # Constructor de clase
    # Conexion: Recibe la conexion a la base de datos

    def __init__(self):
        self.conexion = SQLServer()

    # Elimina un determinado sistema
    # id: Identificador del sistema
    # Retorna un objeto de tipo Resultado

    def deleteSistema(self, id):
        try:
            query = 'DELETE FROM sistema WHERE id = ?'
            count = self.conexion.update(query, [id])
            if(count > 0):
                return Resultado(Constantes.CODES['SUC'], 'Se eliminó el sistema correctamente', None)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se realizó la eliminación del sistema', None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al eliminar sistema', repr(error))    

    # Obtiene los datos de un sistema a partir de su numero de id
    # id: Identificador del sistema
    # Retorna un objeto Resultado

    def getSistema(self, id):
        try:
            query = 'SELECT id, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo FROM sistema WHERE id = ?'
            row = self.conexion.get(query, [id])
            if(row is not None and len(row) > 0):
                sistema = Sistema(row[0],
                                  row[1],
                                  row[2],
                                  row[3],
                                  row[4],
                                  row[5],
                                  row[6],
                                  row[7],
                                  row[8])
                return Resultado(Constantes.CODES['SUC'], '', sistema.toJSON())
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron resultados para el sistema', None)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al consultar información de sistema', repr(error))

    # Devuelve un listado de todos los sistemas ordenados por su nombre corto
    # Retorna un objeto Resultado

    def getSistemas(self):
        try:
            query = 'SELECT id, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo FROM sistema ORDER BY nombreCorto'
            datos = self.conexion.select(query, [])
            sistemas = []
            if(datos is not None and len(datos) > 0):
                for row in datos:
                    sistema = Sistema(row[0],
                                  row[1],
                                  row[2],
                                  row[3],
                                  row[4],
                                  row[5],
                                  row[6],
                                  row[7],
                                  row[8])
                    sistemas.append(sistema.toJSON())
                return Resultado(Constantes.CODES['SUC'], '', sistemas)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron sistemas para listar', sistemas)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al consultar información de sistema', repr(error))

    # Devuelve un listado de los sistemas ordenados segun la frecuencia de acceso del usuario y con el perfil que posea
    # idUsuario: Numero de legajo del usuario

    def getSistemasFrecuentesUsuario(self, idUsuario):
        try:
            query = 'SELECT s.id, s.nombreCorto, s.nombreLargo, s.descripcion, s.URLProduccion, s.URLTest, s.imagen, s.estado, s.codigo, (case when a.contador is null then 0 else a.contador end) totalAccesos, p.nombre perfil '
            query += 'FROM sistema s '
            query += 'LEFT JOIN log_acceso a on a.idSistema = s.id and a.idUsuario = ? '
            query += 'LEFT JOIN usuario_perfil up on up.idUsuario = a.idUsuario '
            query += 'LEFT JOIN perfil p on up.idPerfil = p.id and p.idSistema = s.id '
            query += 'ORDER BY a.contador desc, nombreCorto'
            datos = self.conexion.select(query, [idUsuario])
            sistemas = []
            if(len(datos) > 0):
                for row in datos:
                    sistemas.append({'id': row[0],
                                     'nombreCorto': row[1],
                                     'nombreLargo': row[2],
                                     'descripcion': row[3],
                                     'URLProduccion': row[4],
                                     'URLTest': row[5],
                                     'imagen': row[6],
                                     'estado': row[7],
                                     'codigo': row[8],
                                     'totalAccesos': row[9],
                                     'nombrePerfil': row[10]})
                return Resultado(Constantes.CODES['SUC'], '', sistemas)
            else:
                return Resultado(Constantes.CODES['WAR'], 'No se encontraron sistemas para listar', sistemas)
        except Exception as error:
            return Resultado(Constantes.CODES['ERR'], 'Error al consultar información de sistema', repr(error))

    # Agrega un nuevo sistema
    # nombreCorto: Nombre corto de la aplicacion
    # nombreLargo: Nombre largo de la aplicacion
    # descripcion: Descripcion de la funcionalidad
    # URLProduccion: URL del sistema en el ambiente de produccion
    # URLTest: URL del sistema en el ambiente de test
    # estado: Estado del sistema
    # Retorna un objeto Resultado

    def insert(self, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo):
        try:
            query = 'INSERT INTO sistema (nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo) OUTPUT inserted.id VALUES (?, ?, ?, ?, ?, ?, ?)'
            datos = [nombreCorto.strip(), nombreLargo.strip(), descripcion.strip(), URLProduccion.strip(), URLTest, imagen, estado, codigo]
            identificador = self.conexion.insertWithId(query, datos)
            if(identificador > 0):
                mensaje = 'Se creó el sistema correctamente ({})'.format(nombreCorto)
                return Resultado(Constantes.CODES['SUC'], mensaje, identificador)
            else:
                mensaje = 'No se realizó la creación del sistema ({})'.format(nombreCorto)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            if(error.args[0] == Constantes.SQL['DUPLICATE']):
                mensaje = 'No se pueden crear sistemas duplicados ({})'.format(nombreCorto)
                return Resultado(Constantes.CODES['WAR'], mensaje, repr(error))
            else:
                mensaje = 'Error al crear sistema ({})'.format(nombreCorto)
                return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))

    # Actualiza la informacion del sistema
    # nombreCorto: Nombre corto de la aplicacion
    # nombreLargo: Nombre largo de la aplicacion
    # descripcion: Descripcion de la funcionalidad
    # URLProduccion: URL del sistema en el ambiente de produccion
    # URLTest: URL del sistema en el ambiente de test
    # estado: Estado del sistema
    # id: Identificador del sistema
    # Retorna un objeto Resultado

    def update(self, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado, codigo, id):
        try:
            query = 'UPDATE sistema SET nombreCorto=?, nombreLargo=?, descripcion=?, URLProduccion=?, URLTest=?, imagen=?, estado=?, codigo=? WHERE id = ?'
            datos = [nombreCorto.strip(), nombreLargo.strip(), descripcion.strip(),
                     URLProduccion.strip(), URLTest, imagen, estado, id]
            count = self.conexion.update(query, datos)
            if(count > 0):
                mensaje = 'Se modificó el sistema correctamente ({})'.format(nombreCorto)
                return Resultado(Constantes.CODES['SUC'], mensaje, None)
            else:
                mensaje = 'No se modificó la información del sistema'.format(nombreCorto)
                return Resultado(Constantes.CODES['WAR'], mensaje, None)
        except Exception as error:
            mensaje = 'Error al modificar la información del sistema ({})'.format(nombreCorto)
            return Resultado(Constantes.CODES['ERR'], mensaje, repr(error))
