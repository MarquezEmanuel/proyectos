
/* 

  Push modifica el objeto por lo que no se recomienda usarlo.
*/

const arreglo = [];

arreglo.push(1);
arreglo.push(2);
arreglo.push(3);
arreglo.push(4);

let arreglo2 = [...arreglo, 5];

const arreglo3 = arreglo.map(function(x){
  return x * 2;
});

console.log(arreglo);
console.log(arreglo2);
console.log(arreglo3);
