const firstN = document.getElementById('registration_form_firstName');
const lastN = document.getElementById('registration_form_lastName');
const phoneNumb = document.getElementById('registration_form_phoneNumber');
const emailReg = document.getElementById('registration_form_email');
const pass1 = document.getElementById('registration_form_password_first');
const pass2 = document.getElementById('registration_form_password_second');

pass1.addEventListener('input',()=>{
    if(pass1.value.length < 8){
        pass1.style.borderColor = "#f00";
    }else{
        pass1.style.borderColor = "#0f0";
    }
});

pass2.addEventListener('input',()=>{
    if(pass2.value.length < 8){
        pass2.style.borderColor = "#f00";
    }else{
        pass2.style.borderColor = "#0f0";
    }
    if(pass1.value !== pass2.value){
        pass1.style.borderColor = "#f00";
        pass2.style.borderColor = "#f00";
    }else {
        pass1.style.borderColor = "#0f0";
        pass2.style.borderColor = "#0f0";
    }
});

phoneNumb.addEventListener('input', ()=>{
    if(phoneNumb.value.length < 6){
        phoneNumb.style.borderColor = "#f00";
    } else {
        phoneNumb.style.borderColor = "#0f0";
    }
});

lastN.addEventListener('input', ()=>{
    if(lastN.value.length < 2){
        lastN.style.borderColor = "#f00";
    } else {
        lastN.style.borderColor = "#0f0";
    }
});

firstN.addEventListener('input', ()=>{
    if(firstN.value.length < 2){
        firstN.style.borderColor = "#f00";
    } else {
        firstN.style.borderColor = "#0f0";
    }
});

emailReg.addEventListener('input', ()=>{
    if(emailReg.value.includes("@") && emailReg.value.includes(".")){
        emailReg.style.borderColor = "#0f0";
    }else{
        emailReg.style.borderColor = "#f00";
    }
})