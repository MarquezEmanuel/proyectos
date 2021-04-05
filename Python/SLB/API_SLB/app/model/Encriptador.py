import base64

# Encriptador
# Administra las operaciones para encriptar o desencriptar cadenas de texto
#
# Autor: Aguero Emiliano
# Autor: Estrada Francisco
# Autor: Marquez Emanuel
# Autor: Trujillo Nicolas
# Autor: Urra Matias

class Encriptador():

    # Encripta una cadena de texto a Base64
    # Retorna la cadena decodificada
    
    def encriptarBase64(self, texto):
        codificada = texto.encode()
        encriptada = base64.b64encode(codificada)
        return encriptada.decode()

    # Desencripta una cadena de texto en Base64
    # Retorna la cadena decodificada
    def desencriptarBase64(self, texto):
        try:
            desencriptada = base64.b64decode(texto)
            return desencriptada.decode()
        except Exception:
            return None
        