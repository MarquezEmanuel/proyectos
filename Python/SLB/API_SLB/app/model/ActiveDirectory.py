import ldap 

# Active Directory
# Administra los datos correspondientes a una conexion LDAP
#
# Autor: Aguero Emiliano
# Autor: Farinola Santiago
# Autor: Marquez Emanuel
class ActiveDirectory():

    # Constructor de clase
    # Servidor: IP o Nombre del servidor AD
    # Puerto: Numero de puerto
    # Dominio: Nombre del dominio
    def __init__(self, servidor, puerto, dominio):
        self.servidor = servidor
        self.puerto = puerto
        self.dominio = dominio
        self.logs = []

    # Autentica un usuario
    # Legajo: Numero de legajo del usuario
    # Password: Clave del usuario
    # Retorna true o false
    def autenticar(self, legajo, password):
        try:
            datos = 'ldap://'+self.servidor+':'+str(self.puerto)
            usuario = self.dominio+'\\'+legajo
            conexion = ldap.initialize(datos)
            conexion.set_option(ldap.OPT_REFERRALS, 0)
            conexion.simple_bind_s(usuario, password)
        except ldap.SERVER_DOWN:
            self.logs.append('Conexión al servidor no establecida')
            return False
        except ldap.INVALID_CREDENTIALS:
            self.logs.append('Credenciales invalidas')
            return False
        return True