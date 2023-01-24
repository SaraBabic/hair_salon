const forgotPassword = document.getElementById('emailForgotPass');

forgotPassword.addEventListener('input', ()=>{
    if(forgotPassword.value.includes("@") && forgotPassword.value.includes(".")){
        forgotPassword.style.borderColor = "#0f0";
    }else{
        forgotPassword.style.borderColor = "#f00";
    }
})