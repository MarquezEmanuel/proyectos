

/* Funcion asignada a una constante */

const saludar = function (nombre) {
  return `Hola, ${nombre}`;
}

/* Funcion flecha. Cuando solo es un return, se puede simplicar */

const saludar2 = (nombre) => {
  return `Hola, ${nombre}`;
}

const saludar3 = (nombre) => `Hola, ${nombre}`;

console.log(saludar('Ema'));
console.log(saludar2('Emanuel'));
console.log(saludar3('Juan Roman'));

/* Colocamos los parentesis para resumir el return */

const getUser = () => ({
  'uid': 'ABC123',
  'username': '@usuario_123'
});


console.log(getUser());

const usuarioActivo = (nombre) => ({
  'uid': 'ABC123',
  'username': nombre
});

console.log(usuarioActivo('Emanuel'));
