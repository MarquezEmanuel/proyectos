
/* Objetos literales (llave : valor) 

    console.table(persona);

*/

const persona = {
  nombre: 'Tony',
  apellido: 'Montana',
  age: 45,
  direccion: {
    ciudad: "New York",
    zip: 343565,
    lat: 14.334
  }
}

/* Esto asigna el mismo espacio de memoria */

const persona2 = persona;
persona2.nombre = 'Pedro';
console.log('Persona 1', persona);
console.log('Persona 2', persona2);

/* Crea una copia del objeto */

const persona3 = {...persona};
persona3.nombre = "Juan Roman"; 
console.log('Persona 1', persona);
console.log('Persona 3', persona3);
