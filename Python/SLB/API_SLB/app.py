from flask import Flask, jsonify, request
from flask_httpauth import HTTPBasicAuth
from flask_cors import CORS, cross_origin
from functools import wraps
import json
import jwt
import socket

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
            controlador.info('Usuario autorizado: ' + str(current_user['id']))
        except:
            controlador.error('Token invalido: '+str(token))
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

# Aplication data

@app.route('/')
def test():
    return {'appName': 'SLB',
            'appDescription':
            'Sistema de login a aplicaciones del BSC',
            'equipo': socket.gethostname()}

# Log endpoints ======================================================
# =======================================================================

# @app.route(logRoute + 'add',  methods = ['POST'])
# def addLogAcceso():
#    data = json.loads(request.data)
#    controlador = ControladorLogAcceso()
#    resultado = controlador.crear(data)
#    return jsonify(resultado.toJSON())
#

# Perfil endpoints ======================================================
# =======================================================================

# @app.route(perfilRoute + 'listPorSistema/<int:id>')
# def listarPerfilesPorSistema(id):
#    controlador = ControladorPerfil()
#    resultado = controlador.listarPerfilesPorSistema(id)
#    return jsonify(resultado.toJSON())

# Permiso endpoints =====================================================
# =======================================================================

@app.route(permisoRoute + 'listPorSistema/<int:id>')
@token_required
def getPermisosPorSistema(current_user, id):
    if(current_user['marcaAdministrador']):
        controlador = ControladorPermiso()
        resultado = controlador.getPermisosPorSistema(id)
        return jsonify(resultado.toJSON())
    controladorLog.error(
        'Acceso no autorizado a getPermisosPorSistema para '+str(current_user['id']))
    resultado = Resultado(
        Constantes.CODES['ERR'], 'Debe ser administrador para acceder a crear sistema', None)
    return jsonify(resultado.toJSON())

# Sistema endpoints =====================================================
# =======================================================================


@app.route(sistemaRoute + '/add',  methods=['POST'])
@token_required
def addSistema(current_user):
    if(current_user['marcaAdministrador']):
        data = json.loads(request.data)
        controlador = ControladorSistema()
        resultado = controlador.crear(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a addSistema para '+str(current_user['id']))
    resultado = Resultado(
        Constantes.CODES['ERR'], 'Debe ser administrador para acceder a crear sistema', None)
    return jsonify(resultado.toJSON())


@app.route(sistemaRoute + 'getByID/<int:id>')
@token_required
def getSistema(current_user, id):
    if(current_user['marcaAdministrador']):
        controlador = ControladorSistema()
        resultado = controlador.get(id)
        return jsonify(resultado.toJSON())
    controladorLog.error(
        'Acceso no autorizado a getSistema para '+str(current_user['id']))
    resultado = Resultado(
        Constantes.CODES['ERR'], 'Debe ser administrador para acceder a obtener sistema', None)
    return jsonify(resultado.toJSON())


@app.route(sistemaRoute + '/list')
@token_required
def getSistemas(current_user):
    if(current_user['marcaAdministrador']):
        controlador = ControladorSistema()
        resultado = controlador.getSistemas()
        return jsonify(resultado.toJSON())
    controladorLog.error(
        'Acceso no autorizado a getSistemas para '+str(current_user['id']))
    resultado = Resultado(
        Constantes.CODES['ERR'], 'Debe ser administrador para acceder a listar sistemas', None)
    return jsonify(resultado.toJSON())


@app.route(sistemaRoute + '/listByUser/<string:idUsuario>')
@token_required
def getSistemasFrecuentesUsuario(current_user, idUsuario):
    controlador = ControladorSistema()
    resultado = controlador.getSistemasFrecuentesUsuario(idUsuario)
    return jsonify(resultado.toJSON())

# Usuario endpoints =====================================================
# =======================================================================

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
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para acceder a listar sistemas', None)
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
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para acceder a listar sistemas', None)
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
    resultado = Resultado(Constantes.CODES['ERR'], 'Debe ser administrador para acceder a listar sistemas', None)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'login', methods=['POST'])
@auth.login_required
def login():
    data = json.loads(request.data)
    controlador = ControladorUsuario()
    resultado = controlador.login(data)
    return jsonify(resultado.toJSON())

if __name__ == '__main__':
    app.run(debug = True, port = 4000)
