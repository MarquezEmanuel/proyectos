
const personajes = ['Goku', 'Vegeta', 'Krilin']

const [, , p3] = personajes;
console.log(p3);


const retornaArreglo = () => {
  return ['ABC', 1234];
}
const [letras, numeros] = retornaArreglo();
console.log(letras, numeros);

const useState = (valor) => {
  return [valor, ()=> {console.log('Hola mundo')}];
}

const [nombre, setNombre] = useState('Goku');
console.log(nombre);
setNombre();