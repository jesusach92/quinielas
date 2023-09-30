
// Objeto para almacenar las selecciones del usuario
const userSelections = {};

// Función para alternar el estado del resultado
function toggleResult(element, partidoId, resultado) {
    if (element.classList.contains('circle-green')) {
        element.classList.remove('circle-green');
        element.classList.add('circle-red');
        // Almacena la selección del usuario en el objeto
        if (!userSelections[partidoId]) {
            userSelections[partidoId] = [];
        }
        userSelections[partidoId].push(resultado);
    } else {
        element.classList.remove('circle-red');
        element.classList.add('circle-green');
        // Elimina la selección del usuario del objeto
        if (userSelections[partidoId]) {
            const index = userSelections[partidoId].indexOf(resultado);
            if (index !== -1) {
                userSelections[partidoId].splice(index, 1);
            }
        }
    }

    // Calcula el precio total
    calculateTotalPrice();
}

// Función para calcular el precio total
function calculateTotalPrice() {
const partidoIds = Object.keys(userSelections);
let totalPrice = 10;
partidoIds.forEach(partidoId => {
const selections = userSelections[partidoId];
if (selections.length === 3) 
    totalPrice = (totalPrice * 2) * 2.5;
if(selections.length === 2)
 totalPrice = totalPrice *2 ;
});
document.getElementById('precioTotal').value = totalPrice;
document.getElementById('totalPrice').textContent = `Costo total: $${totalPrice}.00`;
}
// Agrega una función para enviar el formulario con las selecciones del usuario
document.getElementById('apuestaForm').addEventListener('submit', function (event) {
    // Agrega las selecciones del usuario como un campo oculto en el formulario
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'selecciones';
    input.value = JSON.stringify(userSelections);
    this.appendChild(input);
});

  