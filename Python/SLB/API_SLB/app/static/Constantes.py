
# Codigos de las operaciones

CODES = {
    'ERR' : 'ERROR',
    'WAR' : 'WARNING',
    'SUC' : 'SUCCESS',
    'INF' : 'INFO'
}

# Codigos SQL Server

SQL = {
    'DUPLICATE' : '23000'
}

# Esquemas para validar JSON con Cerberus

BD_SLB = {
    'LOG_ACCESO' : {
        'idUsuario': {'required': True, 'type': 'string', 'maxlength': 10},
        'idSistema': {'required': True, 'type': 'integer'}
    },
    'SISTEMA': {
        'id': {'required': False, 'type': 'integer'},
        'nombreCorto': {'required': True, 'type': 'string', 'maxlength': 10},
        'nombreLargo': {'required': True, 'type': 'string', 'maxlength': 50},
        'descripcion': {'required': True, 'type': 'string', 'maxlength': 500},
        'URLProduccion': {'required': True, 'type': 'string', 'maxlength': 50},
        'URLTest': {'required': False, 'type': 'string', 'maxlength': 50},
        'imagen': {'required': True, 'type': 'string', 'maxlength': 50},
        'estado': {'required': True, 'type': 'integer'}
    },
    'USUARIO_LOGIN' : {
        'legajo': {'required': True, 'type': 'string', 'maxlength': 10},
        'clave': {'required': True, 'type': 'string', 'maxlength': 50}
    }
}