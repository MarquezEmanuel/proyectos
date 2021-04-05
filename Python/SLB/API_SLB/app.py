from flask import Flask, jsonify, request
from flask_httpauth import HTTPBasicAuth
from flask_cors import CORS, cross_origin
from functools import wraps
import json, jwt, socket

from config.config import USER_DATA, DATA_JWT
from model.Resultado import Resultado

# Importa los controladores 
from controller.ControladorLog import ControladorLog
#from controller.ControladorLogAcceso import ControladorLogAcceso
#from controller.ControladorPerfil import ControladorPerfil
from controller.ControladorPermiso import ControladorPermiso
from controller.ControladorSistema import ControladorSistema
from controller.ControladorUsuario import ControladorUsuario
import static.Constantes as Constantes

app = Flask(__name__)
auth = HTTPBasicAuth()
app.config['JSON_AS_ASCII'] = False
CORS(app, resources={r"/*": {"origins": "*"}})

def token_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        #token = request.args.get('token')
        controlador = ControladorLog()
        token = None
        if 'x-access-token' in request.headers:
            token = request.headers['x-access-token']

        if(not token):
            mensaje = 'No se recibio un token para operar (x-access-token)'
            controlador.error(mensaje)
            resultado = Resultado(Constantes.CODE_ERROR, mensaje, None)
            return jsonify(resultado.toJSON()), 403
        try:
            current_user = jwt.decode(token, DATA_JWT['SECRET_KEY'], algorithms=DATA_JWT['ALGORITHM'])
            controlador.info('Usuario autorizado: '+ str(current_user['id']))
        except:
            controlador.error('Token invalido: '+str(token))
            resultado = Resultado(Constantes.CODE_ERROR, 'Token invalido', token)
            return jsonify(resultado.toJSON()), 403
        return f(current_user, *args, **kwargs)
    
    return decorated

# Ruta base para cada uno de los modulos

logRoute = '/log/'
perfilRoute = '/perfil/'
permisoRoute = '/permiso/'
sistemaRoute = '/sistema/'
usuarioRoute = '/usuario/'

controladorLog = ControladorLog()

# Aplication data

@app.route('/')
def test():
    return {'appName': 'SLB', 
            'appDescription': 
            'Sistema de login a aplicaciones del BSC',
            'equipo': socket.gethostname()}

# Autentica al usuario con acceso a los metodos del API

@auth.verify_password
def verify(username, password):
    if(not username and password):
        return False
    return USER_DATA.get(username) == password

# Log endpoints ======================================================
# =======================================================================

#@app.route(logRoute + 'add',  methods = ['POST'])
#def addLogAcceso():
#    data = json.loads(request.data)
#    controlador = ControladorLogAcceso()
#    resultado = controlador.crear(data)
#    return jsonify(resultado.toJSON())
#

# Perfil endpoints ======================================================
# =======================================================================

#@app.route(perfilRoute + 'listPorSistema/<int:id>')
#def listarPerfilesPorSistema(id):
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
    controladorLog.error('Acceso no autorizado a getPermisosPorSistema para '+str(current_user['id']))
    resultado = Resultado(Constantes.CODE_ERROR, 'Debe ser administrador para acceder a crear sistema', None)
    return jsonify(resultado.toJSON())

# Sistema endpoints =====================================================
# =======================================================================

@app.route(sistemaRoute + '/add',  methods = ['POST'])
@token_required
def addSistema(current_user):
    if(current_user['marcaAdministrador']):
        data = json.loads(request.data)
        controlador = ControladorSistema()
        resultado = controlador.crear(data)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a addSistema para '+str(current_user['id']))
    resultado = Resultado(Constantes.CODE_ERROR, 'Debe ser administrador para acceder a crear sistema', None)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + 'getByID/<int:id>')
@token_required
def getSistema(current_user, id):
    if(current_user['marcaAdministrador']):
        controlador = ControladorSistema()
        resultado = controlador.get(id)
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getSistema para '+str(current_user['id']))
    resultado = Resultado(Constantes.CODE_ERROR, 'Debe ser administrador para acceder a obtener sistema', None)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + '/list')
@token_required
def getSistemas(current_user):
    if(current_user['marcaAdministrador']):
        controlador = ControladorSistema()
        resultado = controlador.getSistemas()
        return jsonify(resultado.toJSON())  
    controladorLog.error('Acceso no autorizado a getSistemas para '+str(current_user['id']))
    resultado = Resultado(Constantes.CODE_ERROR, 'Debe ser administrador para acceder a listar sistemas', None)
    return jsonify(resultado.toJSON())

@app.route(sistemaRoute + '/listByUser/<string:idUsuario>')
@token_required
def getSistemasFrecuentesUsuario(current_user, idUsuario):
    controlador = ControladorSistema()
    resultado = controlador.getSistemasFrecuentesUsuario(idUsuario)
    return jsonify(resultado.toJSON())

# Usuario endpoints =====================================================
# =======================================================================

#@app.route(usuarioRoute + 'getEstadoConexion/<string:legajo>')
##@auth.login_required
#def getEstadoConexion(legajo):
#    controlador = ControladorUsuario()
#    resultado = controlador.consultarEstadoConexion(legajo)
#    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'list')
@token_required
def getUsuarios(current_user):
    if(current_user['marcaAdministrador']):
        controlador = ControladorUsuario()
        resultado = controlador.getUsuarios()
        return jsonify(resultado.toJSON())
    controladorLog.error('Acceso no autorizado a getSistemas para '+str(current_user['id']))
    resultado = Resultado(Constantes.CODE_ERROR, 'Debe ser administrador para acceder a listar sistemas', None)
    return jsonify(resultado.toJSON())

@app.route(usuarioRoute + 'login', methods = ['POST'])
def login():
    data = json.loads(request.data)
    controlador = ControladorUsuario()
    resultado = controlador.login(data)
    return jsonify(resultado.toJSON())

if __name__ == '__main__' :
    app.run(debug = True, port = 4000) 
