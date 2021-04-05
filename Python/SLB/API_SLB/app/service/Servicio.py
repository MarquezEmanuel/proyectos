from app.repository.RepositorioLog import RepositorioLog
from app.repository.SQLServer import SQLServer
class Servicio:

    def __init__(self):
        self._repoLog = RepositorioLog()

    def _iniciarTransaccion(self):
        conexion = SQLServer()
        self._repoLog.info('Inicia un nuevo lote de transacciones ({})'.format(conexion))
        conexion.autoCommit(False)

    def _finalizarTransaccion(self, confirmar):
        conexion = SQLServer()
        if confirmar:
            self._repoLog.info('Confirma el lote de transacciones ({})'.format(conexion))
            conexion.commit()
        else:
            self._repoLog.info('Cancela el lote de transacciones ({})'.format(conexion))
            conexion.rollback()
        conexion.autoCommit(True)

    # Recorre un arreglo de Resultado y retorna aquel que tenga error o warning
    # Guarda los logs
    # Retorna un objeto Resultado o None

    def _chequearValidos(self, resultados):
        for resultado in resultados:
            if(resultado.esValido() is not True):
                return resultado
        return None

    # Controla si en el arreglo hay al menos un error
    # Retorna el objeto Resultado erroneo

    def _chequearErrores(self, resultados):
        for resultado in resultados:
            if(resultado.esError() is True):
                return resultado
        return None

    def _guardarLogs(self, resultados):
        for resultado in resultados:
            if resultado.esError():
                self._repoLog.error(resultado.mensaje)
                self._repoLog.error(resultado.datos)
            elif resultado.esValido() is not True:
                self._repoLog.warning(resultado.mensaje)
                self._repoLog.warning(resultado.datos)
            
    def _guardarLog(self, resultado):
        if resultado is not None:
            if resultado.esError():
                self._repoLog.error(resultado.mensaje)
                self._repoLog.error(resultado.datos)
            elif resultado.esValido():
                self._repoLog.info(resultado.mensaje)
            else:
                self._repoLog.warning(resultado.mensaje)
                self._repoLog.warning(resultado.datos)