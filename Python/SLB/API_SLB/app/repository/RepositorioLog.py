from app.repository.SQLServer import SQLServer

# Repositorio de log
# Tabla [SLB].[dbo].[log]
# Administra todas las operaciones con la tabla de logs
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class RepositorioLog():

    # Constructor de clase
    # Conexion: Recibe la conexion a la base de datos

    def __init__(self):
        self.tipos = {'INFO': 'INF', 'WARNING': 'WAR', 'ERROR': 'ERR'}
        self.conexion = SQLServer()

    # Guarda un mensaje de error
    # mensaje: texto de error

    def error(self, mensaje):
        if mensaje is not None and isinstance(mensaje, str):
            self.__insertar(self.tipos['ERROR'], mensaje.strip())

    # Guarda un mensaje informativo
    # mensaje: texto informativo
    def info(self, mensaje):
        if mensaje is not None and isinstance(mensaje, str):
            self.__insertar(self.tipos['INFO'], mensaje.strip())

    # Guarda un mensaje de alerta
    # mensaje: Texto de alerta

    def warning(self, mensaje):
        if mensaje is not None and isinstance(mensaje, str):
            self.__insertar(self.tipos['WARNING'], mensaje.strip())

    # Agrega un mensajes de un determinado tipo
    # Registros: listado de mensajes a insertar
    # Retorna true o false
    def __insertar(self, tipo, mensaje):
        try:
            query = 'INSERT INTO log_actividad (tipo, mensaje, fecha) VALUES (?, ?, GETDATE())'
            datos = [tipo, mensaje]
            insert = self.conexion.insert(query, datos)
            return True
        except Exception:
            return False
