import jwt
from conf.config import DATA_JWT
from app.model.Encriptador import Encriptador

enc = Encriptador()
print(enc.encriptarBase64('CAP'))
print(enc.encriptarBase64('PAPROD'))


token = jwt.encode({'user_id': 123}, DATA_JWT['PRIVATE_KEY'], algorithm='RS256')
print(token)

paiload = jwt.decode(token, DATA_JWT['PUBLIC_KEY'], algorithms=['RS256'])
print(paiload)