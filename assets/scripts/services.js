const serName = document.getElementById('service_create_form_serviceName');
const serprice = document.getElementById('service_create_form_servicePrice');
const serDur = document.getElementById('service_create_form_serviceDuration');

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
   }else{
       serprice.style.borderColor = "#0f0";
   }
});

serDur.addEventListener('change', ()=>{
    if(serDur.value < 30 && serDur.value > 120){
        serDur.style.borderColor = "#f00";
    }else{
        serDur.style.borderColor = "#0f0";
    }
})