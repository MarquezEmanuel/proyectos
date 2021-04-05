from cerberus import Validator
from model.Resultado import Resultado
from repository.SQLServer import SQLServer
from repository.RepositorioLogAcceso import RepositorioLogAcceso
from static.Schemas import LOG_ACCESO_SCHEMA
import static.Constantes as Constantes

class ControladorLogAcceso():

    def __init__ (self):
        self.conexion = SQLServer()
        self.repositorioLog = RepositorioLogAcceso(self.conexion)

    def crear(self, data):
        validador = Validator(LOG_ACCESO_SCHEMA)
        if validador.validate(data):
            resultado = self.repositorioLog.crear(data['idUsuario'], data['idSistema'])
            if(resultado.valido() == False):
                print(self.conexion.logs)
            return resultado
        return Resultado(Constantes.CODE_ERROR, 'Los datos recibidos son incorrectos para crear log', data)