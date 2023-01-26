const firstPass = document.getElementById('change_password_form_password_first');
const secondPass = document.getElementById('change_password_form_password_second');
const err = document.getElementById('changePassErrors');

firstPass.addEventListener('input',()=>{
    if(firstPass.value.length < 8){
        firstPass.style.borderColor = "#f00";
    }else{
        firstPass.style.borderColor = "#0f0";
    }
});

secondPass.addEventListener('input',()=>{
    if(secondPass.value.length < 8){
        secondPass.style.borderColor = "#f00";
    }else{
        secondPass.style.borderColor = "#0f0";
    }
    if(firstPass.value !== secondPass.value){
        firstPass.style.borderColor = "#f00";
        secondPass.style.borderColor = "#f00";
        err.innerText="Passwords do not match";
        err.style.display = "block";
    }else {
        firstPass.style.borderColor = "#0f0";
        secondPass.style.borderColor = "#0f0";
        err.style.display = "none";
    }
});

