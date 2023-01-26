const email = document.getElementById('inputEmail');
const pass = document.getElementById('inputPassword');

email.addEventListener('input',()=>{
    if(email.value.includes("@") && email.value.includes(".")){
        email.style.borderColor = "#fff";
    }else{
        email.style.borderColor = "#f00";
    }
});

pass.addEventListener('input',()=>{
    if(pass.value.length < 8){
        pass.style.borderColor = "#f00";
    }else{
        pass.style.borderColor = "#fff";
    }
});
