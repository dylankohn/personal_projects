const one = document.getElementById('1');
const two = document.getElementById('2');
const three = document.getElementById('3');
const four = document.getElementById('4');
const five = document.getElementById('5');
const six = document.getElementById('6');
const seven = document.getElementById('7');
const eight = document.getElementById('8');
const nine = document.getElementById('9');
const zero = document.getElementById('0');
const plus = document.getElementById('+');
const minus = document.getElementById('-');
const multiply = document.getElementById('*');
const divide = document.getElementById('/');
const equals = document.getElementById('=');
const clear = document.getElementById('C');
const display = document.getElementById('display-screen');
let currentInput = '';
let previousInput = '';
let operation = undefined;

one.addEventListener('click', () => {
    display.textContent += '1';
});

two.addEventListener('click', () => {
    display.textContent += '2';
});

three.addEventListener('click', () => {
    display.textContent += '3';
});

four.addEventListener('click', () => {   
    display.textContent += '4';
});

five.addEventListener('click', () => {
    display.textContent += '5';
});

six.addEventListener('click', () => {
    display.textContent += '6';
});

seven.addEventListener('click', () => {
    display.textContent += '7';
});

eight.addEventListener('click', () => {
    display.textContent += '8';
});

nine.addEventListener('click', () => {
    display.textContent += '9';
});

zero.addEventListener('click', () => {
    display.textContent += '0';
});

plus.addEventListener('click', () => {
    setOperation('+');
});

equals.addEventListener('click', () => {
    setOperation('=');
    calculate();
});

function setOperation(op) {
    if (currentInput === '') return;
    if (previousInput !== '') {
        calculate();
    }
    operation = op;
    previousInput = currentInput;
    currentInput = '';
}

function calculate() {
    let result;
    const prev = parseFloat(previousInput);
    const current = parseFloat(currentInput);

    if (isNaN(prev) || isNaN(current)) return;
    switch (operation) {
        case '+':
            result = prev + current;
            break;
        case '-':
            result = prev - current;
            break;
        case '*':
            result = prev * current;
            break;
        case '/':
            result = prev / current;
            break;
        default:
            return;
    }

    currentInput = result.toString();
    operation = undefined;
    previousInput = '';
    updateDisplay();
}

function clearDisplay() {
    currentInput = '';
    previousInput = '';
    operation = undefined;
    updateDisplay();
}

function updateDisplay() {
    display.value = currentInput;
}