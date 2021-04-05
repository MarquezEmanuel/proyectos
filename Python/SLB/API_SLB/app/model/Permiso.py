
class Permiso:

    def __init__(self, id, titulo, descripcion, link, subpermisos):
        self.id = id
        self.titulo = titulo
        self.descripcion = descripcion
        self.link = link
        self.subpermisos = subpermisos

    def toJSON():
        json = {'id': self.id,
                'titulo': self.titulo,
                'descripcion': self.descripcion,
                'link': self.link,
                'subpermisos': self.subpermisos}
        return json