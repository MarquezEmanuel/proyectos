import app.static.Constantes as Constantes

# Resultado de operacion
# Administra los datos correspondientes al resultado de una determinada operacion
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class Resultado():

    # Constructor de la clase
    # Codigo: codigo del resultado
    # Mensaje: mensaje de resultado
    # Datos: datos adicionales del resultado

    def __init__(self, codigo, mensaje, datos):
        self.codigo = codigo
        self.mensaje = mensaje 
        self.datos = datos

    # Indica si el resultado de la operacion es valido
    # Retorna true o false

    def esValido(self):
        return (self.codigo == Constantes.CODES['SUC'])

    def esError(self):
        return (self.codigo == Constantes.CODES['ERR'])

    # Devulve los datos en formato JSON
    def toJSON(self):
        return {'codigo': self.codigo, 'mensaje': self.mensaje, 'datos': self.datos}