from flask import Flask, jsonify, request
from flask_httpauth import HTTPBasicAuth
from flask_cors import CORS, cross_origin
from functools import wraps
import json, jwt, socket

# Importa los controladores
from app.controller.ControladorLog import ControladorLog
from app.controller.ControladorPerfil import ControladorPerfil
from app.controller.ControladorPermiso import ControladorPermiso
from app.controller.ControladorSistema import ControladorSistema
from app.controller.ControladorUsuario import ControladorUsuario

# Importa los modelos
from app.model.Resultado import Resultado

# Importa la configuraciones
from conf.config import  DATA_API, DATA_JWT

import app.static.Constantes as Constantes

# Configuracion del API

app = Flask(__name__)
auth = HTTPBasicAuth()
app.config['JSON_AS_ASCII'] = False
CORS(app, resources={r"/*": {"origins": "*"}})

# Ruta base para cada uno de los modulos

apiRoute = '/api'
logRoute = apiRoute + '/log/'
perfilRoute = apiRoute +'/perfil/'
permisoRoute = apiRoute +'/permiso/'
sistemaRoute = apiRoute +'/sistema/'
usuarioRoute = apiRoute +'/usuario/'

controladorLog = ControladorLog()

# Autentica los token que se reciben

def token_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        controlador = ControladorLog()
        token = None
        if 'x-access-token' in request.headers:
            token = request.headers['x-access-token']

        if(not token):
            mensaje = 'No se recibio un token para operar (x-access-token)'
            controlador.error(mensaje)
            resultado = Resultado(Constantes.CODES['ERR'], mensaje, None)
            return jsonify(resultado.toJSON()), 403
        try:
            current_user = jwt.decode(token, DATA_JWT['PUBLIC_KEY'], algorithms=DATA_JWT['ALGORITHM'])
            controlador.info('{} --> Usuario autorizado'.format(current_user['id']))
        except:
            controlador.error('Token invalido: {}'.format(token))
            resultado = Resultado(Constantes.CODES['ERR'], 'Token invalido', token)
            return jsonify(resultado.toJSON()), 403
        return f(current_user, *args, **kwargs)

    return decorated

# Autentica al usuario con acceso a los metodos del API

@auth.verify_password
def verify(username, password):
    if(not username or not password):
        return False
    return DATA_API.get(username) == password

# API Info ==============================================================
# =======================================================================

@app.route(apiRoute+'/info')
def info():
    return {'nombre': 'SLB',
            'descripcion':'Sistema de login a aplicaciones del BSC',
            'version': '1.0',
            'equipo': socket.gethostname()}

# Perfil endpoints ======================================================
# =======================================================================

@app.route(perfilRoute + '/add',  methods=['POST'])
@auth.login_required
@token_required
def insertPerfil(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> insertPerfil()'.format(current_user['id']))
        data = json.loads(request.data)
        controlador = ControladorPerfil()
        resultado = controlador.insertPerfil(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a insertPerfil() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para crear perfil', None)
    return jsonify(resultado.toJSON())

@app.route(perfilRoute + 'delete/<int:id>', methods=['DELETE'])
@auth.login_required
@token_required
def deletePerfil(current_user, id):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> deletePerfil()'.format(current_user['id']))
        controlador = ControladorPerfil()
        resultado = controlador.deletePerfil(id)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a deletePerfil() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para eliminar perfil', None)
    return jsonify(resultado.toJSON())

@app.route(perfilRoute + 'get/<int:id>')
@auth.login_required
@token_required
def getPerfil(current_user, id):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getPerfil()'.format(current_user['id']))
        controlador = ControladorPerfil()
        resultado = controlador.getPerfil(id)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getPerfil() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para obtener datos de perfil', None)
    return jsonify(resultado.toJSON())

@app.route(perfilRoute + 'listBySistema/<int:idSistema>')
@auth.login_required
@token_required
def getPerfilesPorSistema(current_user, idSistema):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getPerfilesPorSistema()'.format(current_user['id']))
        controlador = ControladorPerfil()
        resultado = controlador.getPerfilesPorSistema(idSistema)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getPerfilesPorSistema() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para listar datos de perfiles', None)
    return jsonify(resultado.toJSON())

@app.route(perfilRoute + '/update',  methods=['PUT'])
@auth.login_required
@token_required
def updatePerfil(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> updatePerfil()'.format(current_user['id']))
        data = json.loads(request.data)
        controlador = ControladorPerfil()
        resultado = controlador.updatePerfil(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a updatePerfil() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para actualizar perfil', None)
    return jsonify(resultado.toJSON())

# Permiso endpoints =====================================================
# =======================================================================

@app.route(permisoRoute + 'listBySistema/<int:id>')
@auth.login_required
@token_required
def getPermisosPorSistema(current_user, id):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getPermisosPorSistema()'.format(current_user['id']))
        controlador = ControladorPermiso()
        resultado = controlador.getPermisosPorSistema(id)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getPermisosPorSistema() para '.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para acceder a listar permisos por sistema', None)
    return jsonify(resultado.toJSON())

# Sistema endpoints =====================================================
# =======================================================================

@app.route(sistemaRoute + '/add',  methods=['POST'])
@auth.login_required
@token_required
def insertSistema(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> insertSistema()'.format(current_user['id']))
        data = json.loads(request.data)
        controlador = ControladorSistema()
        resultado = controlador.insertSistema(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a insertSistema() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para crear sistema', None)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + 'get/<int:id>')
@auth.login_required
@token_required
def getSistema(current_user, id):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getSistema()'.format(current_user['id']))
        controlador = ControladorSistema()
        resultado = controlador.getSistema(id)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getSistema() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para obtener datos de sistema', None)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + '/list')
@auth.login_required
@token_required
def getSistemas(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getSistemas()'.format(current_user['id']))
        controlador = ControladorSistema()
        resultado = controlador.getSistemas()
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getSistemas() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para listar sistemas', None)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + '/listByUser/<string:idUsuario>')
@auth.login_required
@token_required
def getSistemasFrecuentesUsuario(current_user, idUsuario):
    controladorLog.info('{} --> getSistemasFrecuentesUsuario()'.format(current_user['id']))
    controlador = ControladorSistema()
    resultado = controlador.getSistemasFrecuentesUsuario(idUsuario)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + 'update', methods=['PUT'])
@auth.login_required
@token_required
def updateSistema(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> updateSistema()'.format(current_user['id']))
        data = json.loads(request.data)
        controlador = ControladorSistema()
        resultado = controlador.updateSistema(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a updateSistema() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para actualizar datos de sistema', None)
    return jsonify(resultado.toJSON())

# Usuario endpoints =====================================================
# =======================================================================

@app.route(usuarioRoute + 'access/<int:idSistema>', methods=['POST'])
@auth.login_required
@token_required
def insertUsuarioAcceso(current_user, idSistema):
    controladorLog.info('{} --> insertUsuarioAcceso()'.format(current_user['id']))
    controlador = ControladorUsuario()
    resultado = controlador.insertUsuarioAcceso(current_user['id'], idSistema)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'add', methods=['POST'])
@auth.login_required
@token_required
def insertUsuario(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> insertUsuario()'.format(current_user['id']))
        data = json.loads(request.data)
        controlador = ControladorUsuario()
        resultado = controlador.insertUsuario(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a insertUsuario() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para crear usuario', None)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'delete/<string:legajo>', methods=['DELETE'])
@auth.login_required
@token_required
def deleteUsuario(current_user, legajo):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> deleteUsuario()'.format(current_user['id']))
        controlador = ControladorUsuario()
        resultado = controlador.deleteUsuario(legajo)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a deleteUsuario() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para eliminar usuario', None)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'get/<string:legajo>')
@auth.login_required
@token_required
def getUsuario(current_user, legajo):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getUsuario()'.format(current_user['id']))
        controlador = ControladorUsuario()
        resultado = controlador.getUsuario(legajo)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getUsuario() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para obtener información de usuario', None)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'getUsuarioSistema/<string:codigoSistema>')
@auth.login_required
@token_required
def getUsuarioSistema(current_user, codigoSistema):
    controladorLog.info('{} --> getUsuarioSistema()'.format(current_user['id']))
    controlador = ControladorUsuario()
    resultado = controlador.getUsuarioSistema(current_user['id'], codigoSistema)
    return jsonify(resultado.toJSON())
    
@app.route(usuarioRoute + 'list')
@auth.login_required
@token_required
def getUsuarios(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> getUsuarios()'.format(current_user['id']))
        controlador = ControladorUsuario()
        resultado = controlador.getUsuarios()
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getUsuarios() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para listar usuarios', None)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'login', methods=['POST'])
@auth.login_required
def login():
    data = json.loads(request.data)
    controlador = ControladorUsuario()
    resultado = controlador.login(data)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'update', methods=['PUT'])
@auth.login_required
@token_required
def updateUsuario(current_user):
    if(current_user['marcaAdministrador']):
        controladorLog.info('{} --> updateUsuario()'.format(current_user['id']))
        data = json.loads(request.data)
        controlador = ControladorUsuario()
        resultado = controlador.updateUsuario(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a update() para {}'.format(current_user['id']))
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para actualizar datos de usuario', None)
    return jsonify(resultado.toJSON())

if __name__ == '__main__':
    app.run(debug = True, port = 4000)
