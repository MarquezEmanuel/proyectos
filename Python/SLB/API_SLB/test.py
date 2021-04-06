import jwt
from cerberus import Validator
from conf.config import DATA_JWT
from app.model.Encriptador import Encriptador
import app.static.Constantes as Constantes

enc = Encriptador()
print(enc.encriptarBase64('CAP'))
print(enc.encriptarBase64('PAPROD'))


token = jwt.encode({'user_id': 123}, DATA_JWT['PRIVATE_KEY'], algorithm='RS256')
print(token)

paiload = jwt.decode(token, DATA_JWT['PUBLIC_KEY'], algorithms=['RS256'])
print(paiload)



user = {
    "id":"7000",
    "apellido": "Riquelme",
    "nombre":"Juan Roman",
    "imagen":"default.png",
    "marcaAdministrador":1,
    "idInvGate":10,
    "perfiles": [1,2]
}
try:
    validador = Validator(Constantes.BD_SLB['USUARIO'])
    if validador.validate(user):
        print('Usuario re valido')
    else:
        print('usurio invalido')
        print(validador.errors)
except Exception as error:
    print(error)