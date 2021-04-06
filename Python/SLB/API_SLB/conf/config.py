
AMBIENTE = 'DESARROLLO'

DATA_BD = {
    'PRODUCCION': {
        'HOST': 'MTkyLjE2OC4yNTAuMTQ0',
        'NAME': '',
        'USER': '',
        'PASS': ''
    },
    'TEST': {
        'HOST': 'MTkyLjE2OC4yNTAuMTQ0',
        'NAME': '',
        'USER': '',
        'PASS': ''
    },
    'DESARROLLO': {
        'HOST': 'RU1BTlVFTFxTUUxFWFBSRVNT',
        'NAME': 'U0xC',
        'USER': 'c2E=',
        'PASS': 'Unl0ZGJhMDg2Kw=='
    }
}

# Datos de configuracion de Active Directory para los ambientes de Produccion, Desarrollo y Test
# HOST = Servidor
# HOST = Puerto
# DOMA = Dominio

DATA_LDAP = {
    'PRODUCCION': {
        'HOST': '172.26.100.10',
        'PORT': '389',
        'DOMA': 'santacruz'
    },
    'TEST': {
        'HOST': '192.168.172.1',
        'PORT': '389',
        'DOMA': 'STACRUZ'
    },
    'DESARROLLO': {
        'HOST': '192.168.250.150',
        'PORT': '389',
        'DOMA': 'desarrollo'
    }
}

# Datos de autenticacion basica con el API

DATA_API = {'BSC_DESARROLLO': 'bWJvcnRCMlMvNlpHTS91Z2tacnRvZz09Ojodk4/3agCtWbb5C+yY6AkE'}

# Datos de onfiguracion para JSON Web Token

DATA_JWT = {
    'EXPIRATION_TIME': 20,
    'ALGORITHM': 'RS256',
    'PUBLIC_KEY': """ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQC6PUnA1EDYS7oue1cNT6VC8+PRPHzKyeeAoc9LSciXUtf+oYKUkfFAJVcKmRPDTdVh4Ub5FwBABpXf+FALhMUSlb2sigpRTC/2XQF7E4Spc4hNO1yNV7C+DokNC+PY+oOghmzIAxMBAoVe3fXLtf4AE6GQ7MaS8iUtuRII20qY4ws+6mGFt+UCiDbqhbuYDh8yJ3Knj7D9Ggu4F71jmMAtFc5PI3unEWBid2wYFz8R6UcTLq1M0RUP9WDQsNZvIq/1NmjAqQcVFa+VaO/Wx6VjM0lDrhyOWZDd/ESo2cjyOwW8W0tvFk0/PK0RWmcn1/XQ3/Qc5058/2tMhXscPS5bDi+6p4ua5j5ascIpfQm9Ez0f94b0VO9U/GAbAcIWVxACVnNwyw8DlVXLCa9UNElFGjGOabn+sjkHAnl/Lqvf31qq7K1Bvy6HExJg9Qat1clcGZTApfY/n52TgYkmTKSA26qszVLkyHMGFXzz7nbGM7CQpjsAVhAIrIgCVcDIqQKmaD7XGHuwBVVeT41zLxVth3i7OyUf4NVFfWKkZjhyTA4Sqqx7dHOVrqa0vzlEPYi81x7IFJt1ou8aPaWp1BildJ9dc7wcIDwj91tf9hOw09hsnD0/JEBSf3VzRz/oyZFzNmBQjWjHOhtj7/WU+Gl46XoYwQ6pqOqbKrUVCcnjHw== desarrollo\administrador@VM250IIS05""",
    'PRIVATE_KEY': """-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----"""
}
