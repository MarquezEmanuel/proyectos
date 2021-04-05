from app.model.ActiveDirectory import ActiveDirectory
from app.model.Encriptador import Encriptador
from app.model.Resultado import Resultado
import conf.config as CONF
import app.static.Constantes as Constantes

# Repositorio de LDAP (Active Directory)
# Administra todas las operaciones con Active Directory
#
# Autor: Aguero Emiliano 
# Autor: Farinola Santiago
# Autor: Marquez Emanuel

class RepositorioLDAP():

    # Construtor de clase
    # Toma los datos de conexion del archivo de configuracion

    def __init__(self):
        encriptador = Encriptador()
        servidor = encriptador.desencriptarBase64(CONF.AD_HOST)
        puerto = encriptador.desencriptarBase64(CONF.AD_PORT)
        dominio = encriptador.desencriptarBase64(CONF.AD_DOMAIN)
        self.activeDirectory = ActiveDirectory(servidor, puerto, dominio)

    # Autentica un usuario con su clave
    # Legajo: Numero de legajo del usuario
    # Clave: Clave personal del usuario
    # Retorna un objeto Resultado
    
    def autenticar(self, legajo, clave):
        if(legajo and clave):
            autenticado = self.activeDirectory.autenticar(legajo, clave)
            if(autenticado):
                return Resultado(Constantes.CODES['SUC'], 'Usuario autenticado', [])
            mensaje = 'Usuario no autenticado por Active Directory ({})'.format(legajo)
            return Resultado(Constantes.CODES['ERR'], mensaje, self.activeDirectory.logs)
        mensaje = 'Datos de usuario no válidos para autenticar por Active Directory ({})'.format(legajo)
        return Resultado(Constantes.CODES['ERR'], mensaje, [])
