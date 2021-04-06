
# Codigos de las operaciones

CODES = {
    'ERR': 'ERROR',
    'WAR': 'WARNING',
    'SUC': 'SUCCESS',
    'INF': 'INFO'
}

# Codigos SQL Server

SQL = {
    'DUPLICATE': '23000'
}

# Esquemas para validar JSON con Cerberus

BD_SLB = {
    'PERFIL_INSERT': {
        'idSistema': {'required': True, 'type': 'integer', 'min': 1},
        'nombre': {'required': True, 'type': 'string', 'maxlength': 50},
        'descripcion': {'required': True, 'type': 'string', 'maxlength': 300},
        'permisos': {'required': True, 'type': 'list', 'minlength': 1}
    },
    'PERFIL_UPDATE': {
        'id': {'required': True, 'type': 'integer', 'min': 1},
        'nombre': {'required': True, 'type': 'string', 'maxlength': 50},
        'descripcion': {'required': True, 'type': 'string', 'maxlength': 300},
        'estado': {'required':True, 'type': 'integer'},
        'permisos': {'required': True, 'type': 'list', 'minlength': 1}
    },
    'SISTEMA': {
        'id': {'required': False, 'type': 'integer', 'min': 1},
        'nombreCorto': {'required': True, 'type': 'string', 'maxlength': 10},
        'nombreLargo': {'required': True, 'type': 'string', 'maxlength': 50},
        'descripcion': {'required': True, 'type': 'string', 'maxlength': 500},
        'URLProduccion': {'required': True, 'type': 'string', 'maxlength': 50},
        'URLTest': {'required': False, 'type': 'string', 'maxlength': 50},
        'imagen': {'required': True, 'type': 'string', 'maxlength': 50},
        'estado': {'required': True, 'type': 'integer'},
        'codigo': {'required': True, 'type': 'string', 'maxlength': 50}
    },
    'USUARIO': {
        'id': {'required': True, 'type': 'string', 'maxlength': 10},
        'apellido': {'required': True, 'type': 'string', 'maxlength': 30, 'regex': '^[a-zA-Z ]+$'},
        'nombre': {'required': True, 'type': 'string', 'maxlength': 30, 'regex': '^[a-zA-Z ]+$'},
        'imagen': {'required': True, 'type': 'string', 'maxlength': 50, 'regex': '^[a-zA-Z0-9.-]+$'},
        'marcaAdministrador': {'required': True, 'type': 'integer'},
        'idInvGate': {'required': True, 'type': 'integer', 'min': 1},
        'perfiles': {'required': True, 'type': 'list', 'minlength': 1}
    },
    'USUARIO_ACCESO': {
        'idUsuario': {'required': True, 'type': 'string', 'maxlength': 10},
        'idSistema': {'required': True, 'type': 'integer', 'min': 1}
    },
    'USUARIO_LOGIN': {
        'legajo': {'required': True, 'type': 'string', 'maxlength': 10},
        'clave': {'required': True, 'type': 'string', 'maxlength': 50}
    }

}
