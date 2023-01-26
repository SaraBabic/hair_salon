const forgotPassword = document.getElementById('emailForgotPass');
const alertFP = document.getElementById('alertFP');

forgotPassword.addEventListener('input', ()=>{
    if(forgotPassword.value.includes("@") && forgotPassword.value.includes(".")){
        forgotPassword.style.borderColor = "#0f0";
        alertFP.style.display = "none";
    }else{
        forgotPassword.style.borderColor = "#f00";
        alertFP.innerText = "Email has incorrect form."
        alertFP.style.display = "block";
    }
})