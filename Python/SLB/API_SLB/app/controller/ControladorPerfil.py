from cerberus import Validator
from app.service.ServicioPerfil import ServicioPerfil
from app.model.Resultado import Resultado
import app.static.Constantes as Constantes

# Controlador de perfiles
# Controla los eventos del perfil
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class ControladorPerfil():

    # Constructor de clase

    def __init__(self):
        self.servicioPerfil = ServicioPerfil()

    # Elimina un determinado perfil y los permisos que posee asociados
    # id: Identificador del perfil
    # Retorna un objeto de tipo Resultado

    def deletePerfil(self, id):
        if id is not None and id > 0:
            return self.servicioPerfil.deletePerfil(id)
        return Resultado(Constantes.CODES['ERR'], 'El identificador recibido es incorrecto para eliminar perfil', id)

    # Obtiene la informacion de un perfil
    # id: Identificador del perfil
    # Retorna un objeto Resultado

    def getPerfil(self, id):
        if id is not None and id > 0:
            return self.servicioPerfil.getPerfil(id)
        return Resultado(Constantes.CODES['ERR'], 'El identificador recibido es incorrecto para eliminar perfil', id)

    # Devuelve un listado de los perfiles de un determinado sistema ordenados por nombre
    # idSistema: Identificador del sistema a consultar
    # Retorna un objeto Resultado

    def getPerfilesPorSistema(self, idSistema):
        if idSistema is not None and idSistema > 0:
            return self.servicioPerfil.getPerfilesPorSistema(idSistema)
        return Resultado(Constantes.CODES['ERR'], 'El identificador recibido es incorrecto para obtener perfiles del sistema', id)

    # Agrega un nuevo perfil a un determinado sistema
    # idSistema: Identificador del sistema al que pertenece
    # nombre: Nombre del nuevo perfil
    # descripcion: Descripcion del perfil
    # permisos: Listado de identificadores de permisos
    # Retorna un objeto Resultado

    def insertPerfil(self, data):
        validador = Validator(Constantes.BD_SLB['PERFIL_INSERT'])
        if data is not None and validador.validate(data):
            idSistema = data['idSistema']
            nombre = data['nombre']
            descripcion = data['descripcion']
            permisos = data['permisos']
            return self.servicioPerfil.insertPerfil(idSistema, nombre, descripcion, permisos)
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para crear perfil', data)

    # Modifica los datos de un determinado perfil
    # Id: Identificador del perfil
    # Nombre: Nuevo nombre
    # Descripcion: Nueva descripcion
    # Estado: Nuevo estado
    # Permisos: Listado de permisos asociados al perfil
    # Retorna un objeto Resultado

    def updatePerfil(self, data):
        validador = Validator(Constantes.BD_SLB['PERFIL_UPDATE'])
        if data is not None and validador.validate(data):
            id = data['id']
            nombre = data['nombre']
            descripcion = data['descripcion']
            estado = data['estado']
            permisos = data['permisos']
            return self.servicioPerfil.updatePerfil(id, nombre, descripcion, estado, permisos)
        return Resultado(Constantes.CODES['ERR'], 'Los datos recibidos son incorrectos para actualizar perfil', data)
    
