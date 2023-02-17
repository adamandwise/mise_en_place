
function addInput() {
    var inputs = document.querySelectorAll('input[type="text"]');
    var lastInput = inputs[inputs.length - 1];
    if (lastInput.value !== '') {

        var newSpan = document.createElement('span'); // create a new span element to hold the input number
        var inputCounter = inputs.length - 2;
        newSpan.textContent = inputCounter + '. ';


        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'input' + (inputs.length + 1);
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
