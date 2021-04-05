
class Usuario:

    def __init__(self, id, apellido, nombre, imagen, marcaAdministrador, idInvGate, fechaCreacion, fechaEdicion):
        self.id = id
        self.apellido = apellido
        self.nombre = nombre
        self.imagen = imagen
        self.marcaAdministrador = marcaAdministrador
        self.idInvGate = idInvGate
        self.fechaCreacion = fechaCreacion
        self.fechaEdicion = fechaEdicion

    def toJSON(self):
        json = {
            'id': self.id,
            'apellido': self.apellido,
            'nombre': self.nombre,
            'imagen': self.imagen,
            'marcaAdministrador': self.marcaAdministrador,
            'idInvGate': self.idInvGate,
            'fechaCreacion': self.fechaCreacion,
            'fechaEdicion': self.fechaEdicion,
        }
        return json
