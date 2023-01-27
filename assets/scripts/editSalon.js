const salonNameEdit = document.getElementById('salon_form_name');
const salonCityEdit = document.getElementById('salon_form_city');
const salonAddressEdit = document.getElementById('salon_form_address');
const salonDescriptionEdit = document.getElementById('salon_form_description');
const salonPhoneEdit = document.getElementById('salon_form_phoneNumber');
const salonImageEdit = document.getElementById('salon_form_salonImages');

salonPhoneEdit.addEventListener('input', ()=>{
    if(salonPhoneEdit.value.length < 6){
        salonPhoneEdit.style.borderColor = "#f00";
    } else {
        salonPhoneEdit.style.borderColor = "#0f0";
    }
});

salonCityEdit.addEventListener('input', ()=>{
    if(salonCityEdit.value.length < 2){
        salonCityEdit.style.borderColor = "#f00";
    } else {
        salonCityEdit.style.borderColor = "#0f0";
    }
});

salonNameEdit.addEventListener('input', ()=>{
    if(salonNameEdit.value.length < 2){
        salonNameEdit.style.borderColor = "#f00";
    } else {
        salonNameEdit.style.borderColor = "#0f0";
    }
});

salonAddressEdit.addEventListener('input', ()=>{
    if(salonAddressEdit.value.length < 2){
        salonAddressEdit.style.borderColor = "#f00";
    } else {
        salonAddressEdit.style.borderColor = "#0f0";
    }
});

salonDescriptionEdit.addEventListener('input', ()=>{
    if(salonDescriptionEdit.value.length < 20){
        salonDescriptionEdit.style.borderColor = "#f00";
    } else {
        salonDescriptionEdit.style.borderColor = "#0f0";
    }
});

salonImageEdit.addEventListener("change", () => {
    const file = salonImageEdit.files;
    let image= file[0];
    const displayImg = document.getElementById('displayImages');
    displayImg.innerHTML = ` <img src="${URL.createObjectURL(image)}" alt="img" width="80px">`;
});
