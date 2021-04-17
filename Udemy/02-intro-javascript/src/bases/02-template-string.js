

const nombre = 'Emanuel';
const apellido = 'Marquez';

const nombreCompleto = `${apellido} ${nombre}`;

console.log(nombreCompleto);

function getSaludo(nombre) {
  return `Hola ${nombre}`;
}

console.log(`Este es un mensaje: ${getSaludo(nombreCompleto)}`);