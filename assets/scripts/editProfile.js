const fName = document.getElementById('user_profile_form_firstName');
const lName = document.getElementById('user_profile_form_lastName');
const phoneNum = document.getElementById('user_profile_form_phoneNumber');

fName.addEventListener('input', ()=>{
   if(fName.value.length < 2){
       fName.style.borderColor = "#f00";
   } else {
       fName.style.borderColor = "#0f0";
   }
});

lName.addEventListener('input', ()=>{
    if(lName.value.length < 2){
        lName.style.borderColor = "#f00";
    } else {
        lName.style.borderColor = "#0f0";
    }
});

phoneNum.addEventListener('input', ()=>{
    if(phoneNum.value.length < 6){
        phoneNum.style.borderColor = "#f00";
    } else {
        phoneNum.style.borderColor = "#0f0";
    }
});