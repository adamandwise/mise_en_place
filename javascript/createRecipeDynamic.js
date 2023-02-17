
function addInput() {
    var inputs = document.querySelectorAll('#instruction');
    var lastInput = inputs[inputs.length - 1];
    if (lastInput.value !== '') {

        var newSpan = document.createElement('span'); // create a new span element to hold the input number
        var inputCounter = inputs.length + 1;
        newSpan.textContent = inputCounter + '. ';


        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'instruction[]';
        newInput.id = 'instruction';
        newInput.className = 'w-100';
        newInput.addEventListener('input', addInput);

        var newDivRow = document.createElement('div'); // create a new div element with class 'row'
        newDivRow.className = 'row mt-2';

        var newDivCol2 = document.createElement('div'); // create a new div element with class 'col-2'
        newDivCol2.className = 'col-2';

        var newDivCol8 = document.createElement('div'); // create a new div element with class 'col-8'
        newDivCol8.className = 'col-8';
        newDivCol8.appendChild(newSpan);
        newDivCol8.appendChild(newInput); // add the new input element to the new col-8 div element

        newDivRow.appendChild(newDivCol2); // add the new col-2 div element to the new row div element
        newDivRow.appendChild(newDivCol8); // add the new col-8 div element to the new row div element

        document.querySelector('form').appendChild(newDivRow); // add the new row div element to the form
    }
}

function addIngredientInput() {
    var inputs = document.querySelectorAll('#unit');
    console.log('back again');
    console.log(inputs.length);
    var lastInput = inputs[inputs.length - 1];
    console.log(lastInput);
    if (lastInput.value !== '') {
        var newIngredientInput = document.createElement('input');
        newIngredientInput.type = 'text';
        newIngredientInput.name = 'ingredient[]';
        newIngredientInput.className = 'ms-2';


        var newAmountInput = document.createElement('input');
        newAmountInput.type = 'text';
        newAmountInput.name = 'amount[]';
        newAmountInput.className = 'ms-3';

        var newUnitInput = document.createElement('input');
        newUnitInput.type = 'text';
        newUnitInput.name = 'unit[]';
        newUnitInput.id = 'unit';
        newUnitInput.addEventListener('input', addIngredientInput);
        newUnitInput.className = 'ms-3';

        var newDivRow = document.createElement('div'); // create a new div element with class 'row'
        newDivRow.className = 'row';

        var newDivCol2 = document.createElement('div'); // create a new div element with class 'col-2'
        newDivCol2.className = 'col-2 mt-2';

        var newIngredientDiv = document.createElement('div'); // create a new div element with class 'col-8'
        newIngredientDiv.className = 'col-3 mt-2';
        newIngredientDiv.appendChild(newIngredientInput);

        var newAmountDiv = document.createElement('div'); // create a new div element with class 'col-8'
        newAmountDiv.className = 'col-3 mt-2';
        newAmountDiv.appendChild(newAmountInput);

        var newUnitDiv = document.createElement('div'); // create a new div element with class 'col-8'
        newUnitDiv.className = 'col-3 mt-2';
        newUnitDiv.appendChild(newUnitInput);// add the new input element to the new col-8 div element

        newDivRow.appendChild(newDivCol2); // add the new col-2 div element to the new row div element
        newDivRow.appendChild(newIngredientDiv);
        newDivRow.appendChild(newAmountDiv);
        newDivRow.appendChild(newUnitDiv);// add the new col-8 div element to the new row div element

    document.getElementById('ingredientRow').appendChild(newDivRow); // add the new row div element to the form


}}
