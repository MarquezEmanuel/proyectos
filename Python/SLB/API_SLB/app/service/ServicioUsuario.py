from app.service.Servicio import Servicio
from app.repository.RepositorioLDAP import RepositorioLDAP
from app.repository.RepositorioPerfil import RepositorioPerfil
from app.repository.RepositorioUsuario import RepositorioUsuario
from conf.config import DATA_JWT
from datetime import datetime, timedelta
import jwt

class ServicioUsuario(Servicio):

    def __init__(self):
        super().__init__()
        self.repoUsuario = RepositorioUsuario()
        self.repoPerfil = RepositorioPerfil()

    # Elimina un determinado usuario a partir de su legajo
    # legajo: Numero de legajo del usuario
    # Retorna un objeto Resultado

    def deleteUsuario(self, legajo):
        self._iniciarTransaccion()
        resultado01 = self.repoUsuario.deleteUsuarioPerfil(legajo)
        if resultado01.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado01)
            return resultado01
        resultado02 = self.repoUsuario.deleteUsuario(legajo)
        self._finalizarTransaccion(resultado02.esValido())
        self._guardarLog(resultado02)
        return resultado02

    # Obtiene los datos de un determinado usuario a partir de su numero de legajo
    # Legajo: Numero de legajo
    # Retorna un objeto Resultado

    def getUsuario(self, legajo):
        resultado01 = self.repoUsuario.getUsuario(legajo)
        if resultado01.esValido() is False:
            self._guardarLog(resultado01)
            return resultado01
        resultado02 = self.repoPerfil.getPerfilPorUsuario(legajo)
        if resultado02.esValido() is False:
            self._guardarLog(resultado02)
            return resultado02
        resultado01.datos.update({'perfiles': resultado02.datos})
        return resultado01

    # Devuelve un listado de todos los usuarios ordenados por id
    # Retorna un objeto Resultado

    def getUsuarios(self):
        resultado = self.repoUsuario.getUsuarios()
        if resultado.esValido() is False:
            self._guardarLog(resultado)
        return resultado

    # Agrega un nuevo usuario
    # Legajo: Numero de legajo del usuario
    # Apellido: Apellido de usuario
    # Nombre: Nombre de usuario
    # esAdministrador: True para usuarios PAI
    # idInvGate: Numero de identificador en InvGate
    # perfiles: Listado de perfiles asociados al usuario
    # Retorna un objeto Resultado

    def insertUsuario(self, legajo, apellido, nombre, esAdministrador, idInvGate, perfiles):
        self._iniciarTransaccion()
        resultado01 = self.repoUsuario.insertUsuario(legajo, apellido, nombre, esAdministrador, idInvGate)
        if resultado01.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado01)
            return resultado01
        resultado02 = self.repoUsuario.insertUsuarioPerfil(legajo, perfiles)
        if resultado02.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado02)
            return resultado02
        self._finalizarTransaccion(True)
        return resultado01

    def insertUsuarioAcceso(self, legajo, idSistema):
        resultado = self.insertUsuarioAcceso(legajo, idSistema)
        self._guardarLog(resultado)
        return resultado

    # Realiza el login del usuario
    # Retorna un objeto Resultado

    def login(self, legajo, clave):
        #repoLDAP = RepositorioLDAP()
        #resultado01 = repoLDAP.autenticar(legajo, clave)
        resultado02 = self.repoUsuario.getUsuario(legajo)
        if resultado02.esValido() is False:
            return resultado02
        user = resultado02.datos
        token = self._generarToken(user['id'], user['apellido'], user['nombre'], user['marcaAdministrador'])
        resultado02.datos.update({'token': token})
        return resultado02

    # Modifica los datos de un determinado usuario
    # Legajo: Numero de legajo del usuario a modificar
    # Apellido: Apellido del usuario
    # Nombre: Nombre del usuario
    # Imagen: Imagen del usuario
    # marcaAdministrador: Indica si el usuario es administrador o no
    # idInvGate: Identificador del usuario en InvGate
    # perfiles: Listado de perfiles asociados al usuario
    # Retorna un objeto Resultado

    def updateUsuario(self, legajo, apellido, nombre, imagen, esAdministrador, idInvGate, perfiles):
        self._iniciarTransaccion()
        resultado01 = self.repoUsuario.deleteUsuarioPerfil(legajo)
        if resultado01.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado01)
            return resultado01
        resultado02 = self.repoUsuario.insertUsuarioPerfil(legajo, perfiles)
        if resultado02.esValido() is False:
            self._finalizarTransaccion(False)
            self._guardarLog(resultado02)
            return resultado02
        resultado03 = self.repoUsuario.updateUsuario(legajo, apellido, nombre, imagen, esAdministrador, idInvGate)
        self._finalizarTransaccion(resultado03.esValido())
        self._guardarLog(resultado03)
        return resultado03

    # Genera un token a partir de los datos del usuario
    # legajo: Numero de legajo
    # apellido: Apellido del usuario
    # nombre: Nombre del usuario
    # esAministrador: True para usuarios de PAI
    # Retorna un token

    def _generarToken(self, legajo, apellido, nombre, esAdministrador):
        data = {
            'id': legajo,
            'nombre': nombre,
            'apellido': apellido,
            'marcaAdministrador': esAdministrador,
            'iat': datetime.utcnow(),
            'exp': datetime.utcnow() + timedelta(minutes=DATA_JWT['EXPIRATION_TIME'])
        }
        token = jwt.encode(data, DATA_JWT['PRIVATE_KEY'], algorithm=DATA_JWT['ALGORITHM'])
        return token


