const serName = document.getElementById('service_create_form_serviceName');
const serprice = document.getElementById('service_create_form_servicePrice');
const serDur = document.getElementById('service_create_form_serviceDuration');
const alertServices = document.getElementById('alertServices');

serName.addEventListener('input', ()=>{
    if(serName.value.length < 3){
        serName.style.borderColor = "#f00";
    }else{
        serName.style.borderColor = "#0f0";
    }
});

serprice.addEventListener('input', ()=>{
   if(serprice.value.length <= 2 && serprice.value < 100){
       serprice.style.borderColor = "#f00";
       alertServices.innerText = "Price must be more than 100 dinars."
       alertServices.style.display = "block";
   }else if(serprice.value.toString().charAt(0) === '0'){
       serprice.style.borderColor = "#f00";
       alertServices.innerText = "Price can't start with 0."
       alertServices.style.display = "block";
   }else{
       serprice.style.borderColor = "#0f0";
       alertServices.style.display = "none";
   }
});

serDur.addEventListener('change', ()=>{
    if(serDur.value < 30 && serDur.value > 120){
        serDur.style.borderColor = "#f00";
    }else{
        serDur.style.borderColor = "#0f0";
    }
})