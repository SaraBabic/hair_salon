const monFrom = document.getElementById('working_hours_form_mondayFrom');
const tueFrom = document.getElementById('working_hours_form_tuesdayFrom');
const wedFrom = document.getElementById('working_hours_form_wednesdayFrom');
const thuFrom = document.getElementById('working_hours_form_thursdayFrom');
const friFrom = document.getElementById('working_hours_form_fridayFrom');
const satFrom = document.getElementById('working_hours_form_saturdayFrom');
const sunFrom = document.getElementById('working_hours_form_sundayFrom');
const monTo = document.getElementById('working_hours_form_mondayTo');
const tueTo = document.getElementById('working_hours_form_tuesdayTo');
const wedTo = document.getElementById('working_hours_form_wednesdayTo');
const thuTo = document.getElementById('working_hours_form_thursdayTo');
const friTo = document.getElementById('working_hours_form_fridayTo');
const satTo = document.getElementById('working_hours_form_saturdayTo');
const sunTo = document.getElementById('working_hours_form_sundayTo');
const alertWH = document.getElementById('alertWH');

monTo.addEventListener('input',()=>check(monFrom, monTo));
tueTo.addEventListener('input',()=>check(tueFrom, tueTo));
wedTo.addEventListener('input',()=>check(wedFrom, wedTo));
thuTo.addEventListener('input',()=>check(thuFrom, thuTo));
friTo.addEventListener('input',()=>check(friFrom, friTo));
satTo.addEventListener('input',()=>check(satFrom, satTo));
sunTo.addEventListener('input',()=>check(sunFrom, sunTo));
monFrom.addEventListener('input',()=>check(monFrom, monTo));
tueFrom.addEventListener('input',()=>check(tueFrom, tueTo));
wedFrom.addEventListener('input',()=>check(wedFrom, wedTo));
thuFrom.addEventListener('input',()=>check(thuFrom, thuTo));
friFrom.addEventListener('input',()=>check(friFrom, friTo));
satFrom.addEventListener('input',()=>check(satFrom, satTo));
sunFrom.addEventListener('input',()=>check(sunFrom, sunTo));

function check(inputFrom, inputTo){
    if(inputTo.value === 'closed' && inputFrom.value === 'closed'){
        inputTo.style.borderColor = "#0f0";
        inputFrom.style.borderColor = "#0f0";
        alertWH.style.display = "none";
    }else {
        if (inputTo.value < inputFrom.value && inputFrom.value !== 'closed' && inputTo.value !== 'closed') {
            inputTo.style.borderColor = "#f00";
            inputFrom.style.borderColor = "#f00";
            alertWH.innerText = "Closing time must be after opening time!";
            alertWH.style.display = "block";
        } else {
            inputTo.style.borderColor = "#0f0";
            inputFrom.style.borderColor = "#0f0";
            alertWH.style.display = "none";
        }
    }
}