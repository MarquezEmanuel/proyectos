

class Sistema:

    def __init__(self, id, nombreCorto, nombreLargo, descripcion, URLProduccion, URLTest, imagen, estado):
        self.id = id
        self.nombreCorto = nombreCorto
        self.nombreLargo = nombreLargo
        self.descripcion = descripcion
        self.URLProduccion = URLProduccion
        self.URLTest = URLTest
        self.imagen = imagen
        self.estado = estado   

    


    def toJSON(self):
        json = {
            'id': self.id,
            'nombreCorto': self.nombreCorto,
            'nombreLargo': self.nombreLargo,
            'descripcion': self.descripcion,
            'URLProduccion': self.URLProduccion,
            'URLTest': self.URLTest,
            'imagen': self.imagen,
            'estado': self.estado
        }
        return json
