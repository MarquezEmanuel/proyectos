

class Perfil:

    def __init__(self, id, idSistema, nombre, descripcion, estado, fechaCreacion, fechaEdicion):
        self.id = id
        self.idSistema = idSistema
        self.nombre = nombre
        self.descripcion = descripcion
        self.estado = estado
        self.fechaCreacion = fechaCreacion
        self.fechaEdicion = fechaEdicion

    def toJSON(self):
        json = {'id': self.id,
                'idSistema': self.idSistema,
                'nombre': self.nombre,
                'descripcion': self.descripcion,
                'estado': self.estado,
                'fechaCreacion': self.fechaCreacion,
                'fechaEdicion': self.fechaEdicion}
        return json
