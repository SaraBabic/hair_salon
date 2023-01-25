const firstNH = document.getElementById('hairdresser_create_form_firstName');
const lastNH = document.getElementById('hairdresser_create_form_lastName');
const emailRegH = document.getElementById('hairdresser_create_form_email');
const pass1H = document.getElementById('hairdresser_create_form_password_first');
const pass2H = document.getElementById('hairdresser_create_form_password_second');

pass1H.addEventListener('input',()=>{
    if(pass1H.value.length < 8){
        pass1H.style.borderColor = "#f00";
    }else{
        pass1H.style.borderColor = "#0f0";
    }
});

pass2H.addEventListener('input',()=>{
    if(pass2H.value.length < 8){
        pass2H.style.borderColor = "#f00";
    }else{
        pass2H.style.borderColor = "#0f0";
    }
    if(pass1H.value !== pass2H.value){
        pass1H.style.borderColor = "#f00";
        pass2H.style.borderColor = "#f00";
    }else {
        pass1H.style.borderColor = "#0f0";
        pass2H.style.borderColor = "#0f0";
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
    }else{
        emailRegH.style.borderColor = "#f00";
    }
})