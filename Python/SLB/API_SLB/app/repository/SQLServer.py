import pyodbc
from conf.config import DATA_BD, AMBIENTE
from app.model.Encriptador import Encriptador

class MetaSQLServer(type):

    __instance = None

    def __call__(cls, *args, **kwargs):
        if not cls.__instance:
            cls.__instance =  super(MetaSQLServer, cls).__call__(*args, **kwargs)
        return cls.__instance


class SQLServer(metaclass=MetaSQLServer):

    conexion = None

    def __init__(self):
        if self.conexion is None:
            encriptador = Encriptador()
            host = encriptador.desencriptarBase64(DATA_BD[AMBIENTE]['HOST'])
            user = encriptador.desencriptarBase64(DATA_BD[AMBIENTE]['USER'])
            pasw = encriptador.desencriptarBase64(DATA_BD[AMBIENTE]['PASS'])
            name = encriptador.desencriptarBase64(DATA_BD[AMBIENTE]['NAME'])
            db_datos = 'Driver={SQL Server};Server='+host+';UID='+user+';PWD='+pasw+';Database='+name+';'
            self.conexion = pyodbc.connect(db_datos)
            self.autoCommit(True)

    def get(self, query, params):
        if(self.conexion and query is not None and params is not None):
            cursor = self.conexion.cursor()
            cursor.execute(query, params)
            return cursor.fetchone()
        return None

    def insert(self, query, params):
        if(self.conexion and query is not None and params is not None):
            cursor = self.conexion.cursor()
            cursor.execute(query, params)
            return 1
        return 0

    def inserts(self, query, params):
        if(self.conexion and query is not None and params is not None):
            cursor = self.conexion.cursor()
            salida = cursor.executemany(query, params)
            return len(params)
        return 0

    def insertWithId(self, query, params):
        if(self.conexion and query is not None and params is not None):
            cursor = self.conexion.cursor()
            cursor.execute(query, params)
            salida = cursor.fetchone()
            identificador = salida[0] if salida is not None and salida[0] is not None else 0
            return identificador
        return 0

    def select(self, query, params):
        if(self.conexion and query is not None and params is not None):
            cursor = self.conexion.cursor()
            cursor.execute(query, params)
            return cursor.fetchall()
        return None

    def update(self, query, params):
        if(self.conexion and query is not None and params is not None):
            cursor = self.conexion.cursor()
            cursor.execute(query, params)
            return cursor.rowcount
        return 0

    def autoCommit(self, estado):
        self.conexion.autocommit = estado

    def rollback(self):
        self.conexion.rollback()

    def commit(self):
        self.conexion.commit()
    
   