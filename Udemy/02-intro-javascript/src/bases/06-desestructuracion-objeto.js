
/* Desestructuracion o asignación desestructurante */

const persona = {
  apellido: 'Marquez',
  nombre: 'Emanuel',
  age: 54
}

console.log(persona.apellido);
console.log(persona.nombre);
console.log(persona.age);

/* Desestructuramos el objeto */

const { nombre, apellido, age } = persona;

console.log(apellido);
console.log(nombre);
console.log(age);

const retornaPersona = ({ nombre, age, rango = 'Capitan' }) => {
  console.log('Retorna Persona', nombre, age, rango);
}
retornaPersona(persona);

/* Segundo ejemplo */

const useContext = ({ apellido, nombre, age, rango = 'Capitan' }) => {
  return {
    apellidoUsuario: apellido,
    anios: age,
    latlng: {
      lat: 14.654,
      lng: 1.33
    }
  }
};

const { apellidoUsuario, anios, latlng: {lat} } = useContext(persona);

console.log('Desestructurado', apellidoUsuario, anios, lat);

