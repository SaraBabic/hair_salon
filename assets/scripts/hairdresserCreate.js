const firstNH = document.getElementById('hairdresser_create_form_firstName');
const lastNH = document.getElementById('hairdresser_create_form_lastName');
const emailRegH = document.getElementById('hairdresser_create_form_email');
const pass1H = document.getElementById('hairdresser_create_form_password_first');
const pass2H = document.getElementById('hairdresser_create_form_password_second');
const alertHairdresser = document.getElementById('alertHairdresser');

pass1H.addEventListener('input',()=>{
    if(pass1H.value.length < 8){
        pass1H.style.borderColor = "#f00";
        alertHairdresser.innerText = "Password must have at least 8 characters.";
        alertHairdresser.style.display = "block";
    }else{
        pass1H.style.borderColor = "#0f0";
        alertHairdresser.style.display = "none";
    }
});

pass2H.addEventListener('input',()=>{
    if(pass2H.value.length < 8){
        pass2H.style.borderColor = "#f00";
        alertHairdresser.innerText = "Password must have at least 8 characters.";
        alertHairdresser.style.display = "block";
    }else{
        pass2H.style.borderColor = "#0f0";
        alertHairdresser.style.display = "none";
    }
    if(pass1H.value !== pass2H.value){
        pass1H.style.borderColor = "#f00";
        pass2H.style.borderColor = "#f00";
        alertHairdresser.innerText = "Passwords do not match.";
        alertHairdresser.style.display = "block";
    }else {
        pass1H.style.borderColor = "#0f0";
        pass2H.style.borderColor = "#0f0";
        alertHairdresser.style.display = "none";
    }
});

firstNH.addEventListener('input', ()=>{
    if(firstNH.value.length < 2){
        firstNH.style.borderColor = "#f00";
    } else {
        firstNH.style.borderColor = "#0f0";
    }
});

lastNH.addEventListener('input', ()=>{
    if(lastNH.value.length < 2){
        lastNH.style.borderColor = "#f00";
    } else {
        lastNH.style.borderColor = "#0f0";
    }
});

emailRegH.addEventListener('input', ()=>{
    if(emailRegH.value.includes("@") && emailRegH.value.includes(".")){
        emailRegH.style.borderColor = "#0f0";
        alertHairdresser.style.display = "none";
    }else{
        emailRegH.style.borderColor = "#f00";
        alertHairdresser.innerText = "Email is not in correct format.";
        alertHairdresser.style.display = "block";
    }
})