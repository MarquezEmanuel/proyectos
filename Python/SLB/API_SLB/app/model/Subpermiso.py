
class Subpermiso:

    def __init__(self, id, titulo, descripcion, link):
        self.id = id
        self.titulo = titulo
        self.descripcion = descripcion
        self.link = link

    def toJSON(self):
        json = {'id': self.id,
                'titulo': self.titulo,
                'descripcion': self.descripcion,
                'link': self.link}
        return json