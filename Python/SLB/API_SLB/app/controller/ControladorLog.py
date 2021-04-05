
from app.repository.RepositorioLog import RepositorioLog

class ControladorLog:

    def __init__(self):
        self.repoLog = RepositorioLog()

    def error(self, mensaje):
        return self.repoLog.error(mensaje)

    def info(self, mensaje):
        return self.repoLog.info(mensaje)

    def warning(self, mensaje):
        return self.repoLog.warning(mensaje)


    