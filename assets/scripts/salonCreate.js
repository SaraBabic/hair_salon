const firstNS = document.getElementById('salon_create_form_firstName');
const lastNS = document.getElementById('salon_create_form_lastName');
const phoneNumbS = document.getElementById('salon_create_form_phoneNumber');
const emailRegS = document.getElementById('salon_create_form_email');
const pass1S = document.getElementById('salon_create_form_password_first');
const pass2S = document.getElementById('salon_create_form_password_second');
const salonName = document.getElementById('salon_create_form_salonName');
const salonCity = document.getElementById('salon_create_form_salonCity');
const salonAddress = document.getElementById('salon_create_form_salonAddress');
const salonDescription = document.getElementById('salon_create_form_salonDescription');
const salonPhone = document.getElementById('salon_create_form_salonPhoneNumber');
const salonImage = document.getElementById('salon_create_form_salonImages');
const alertCreate = document.getElementById('alertCreate');

pass1S.addEventListener('input',()=>{
    if(pass1S.value.length < 8){
        pass1S.style.borderColor = "#f00";
        alertCreate.innerText = "Password must have at least 8 characters.";
        alertCreate.style.display = "block";
    }else{
        pass1S.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }
});

pass2S.addEventListener('input',()=>{
    if(pass2S.value.length < 8){
        pass2S.style.borderColor = "#f00";
        alertCreate.innerText = "Password must have at least 8 characters.";
        alertCreate.style.display = "block";
    }else{
        pass2S.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }
    if(pass1S.value !== pass2S.value){
        pass1S.style.borderColor = "#f00";
        pass2S.style.borderColor = "#f00";
        alertCreate.innerText = "Passwords do not match.";
        alertCreate.style.display = "block";
    }else {
        pass1S.style.borderColor = "#0f0";
        pass2S.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }
});

phoneNumbS.addEventListener('input', ()=>{
    if(phoneNumbS.value.length < 6){
        phoneNumbS.style.borderColor = "#f00";
        alertCreate.innerText = "Phone number must have at least 6 numbers.";
        alertCreate.style.display = "block";
    } else {
        phoneNumbS.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }
});

lastNS.addEventListener('input', ()=>{
    if(lastNS.value.length < 2){
        lastNS.style.borderColor = "#f00";
    } else {
        lastNS.style.borderColor = "#0f0";
    }
});

firstNS.addEventListener('input', ()=>{
    if(firstNS.value.length < 2){
        firstNS.style.borderColor = "#f00";
    } else {
        firstNS.style.borderColor = "#0f0";
    }
});

emailRegS.addEventListener('input', ()=>{
    if(emailRegS.value.includes("@") && emailRegS.value.includes(".")){
        emailRegS.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }else{
        emailRegS.style.borderColor = "#f00";
        alertCreate.innerText = "Email has incorrect format.";
        alertCreate.style.display = "block";
    }
});

salonPhone.addEventListener('input', ()=>{
    if(salonPhone.value.length < 6){
        salonPhone.style.borderColor = "#f00";
        alertCreate.innerText = "Phone number must have at least 6 numbers.";
        alertCreate.style.display = "block";
    } else {
        salonPhone.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }
});

salonCity.addEventListener('input', ()=>{
    if(salonCity.value.length < 2){
        salonCity.style.borderColor = "#f00";
    } else {
        salonCity.style.borderColor = "#0f0";
    }
});

salonName.addEventListener('input', ()=>{
    if(salonName.value.length < 2){
        salonName.style.borderColor = "#f00";
    } else {
        salonName.style.borderColor = "#0f0";
    }
});

salonAddress.addEventListener('input', ()=>{
    if(salonAddress.value.length < 2){
        salonAddress.style.borderColor = "#f00";
    } else {
        salonAddress.style.borderColor = "#0f0";
    }
});

salonDescription.addEventListener('input', ()=>{
    if(salonDescription.value.length < 20){
        salonDescription.style.borderColor = "#f00";
        alertCreate.innerText = "Description must be longer.";
        alertCreate.style.display = "block";
    } else {
        salonDescription.style.borderColor = "#0f0";
        alertCreate.style.display = "none";
    }
});

salonImage.addEventListener("change", () => {
    const file = salonImage.files;
    let image= file[0];
    const displayImg = document.getElementById('displayImages');
    displayImg.innerHTML = ` <img src="${URL.createObjectURL(image)}" alt="img" width="80px">`;
});
