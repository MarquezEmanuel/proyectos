import { heroes } from './data/heroes'

/* Funcion que retorne un heroe por su ID */
const getHeroesById = (id) => heroes.find(heroe => heroe.id === id);
console.log('Heroe by id: ', getHeroesById(2));

/* Funcion que retorne todos los heroes de un owner */
const getHeroesByOwner = (owner) => heroes.filter(heroe => heroe.owner === owner);
console.log('Heroes by owner: ', getHeroesByOwner('DC'));
