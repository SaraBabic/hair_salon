const star1 = document.getElementById('start1Label');
const star2 = document.getElementById('start2Label');
const star3 = document.getElementById('start3Label');
const star4 = document.getElementById('start4Label');
const star5 = document.getElementById('start5Label');
const starHTML = "<img src=\"/build/images/star_icon.png\" alt=\"star\" width=\"50px\">";
const noStarHTML = "<img src=\"/build/images/empty_star_icon.png\" alt=\"star\" width=\"50px\">";

star1.addEventListener('click', ()=>{
    star1.innerHTML = starHTML;
    star2.innerHTML = noStarHTML;
    star3.innerHTML = noStarHTML;
    star4.innerHTML = noStarHTML;
    star5.innerHTML = noStarHTML;
});
star2.addEventListener('click', ()=>{
    star1.innerHTML = starHTML;
    star2.innerHTML = starHTML;
    star3.innerHTML = noStarHTML;
    star4.innerHTML = noStarHTML;
    star5.innerHTML = noStarHTML;
});
star3.addEventListener('click', ()=>{
    star1.innerHTML = starHTML;
    star2.innerHTML = starHTML;
    star3.innerHTML = starHTML;
    star4.innerHTML = noStarHTML;
    star5.innerHTML = noStarHTML;
});
star4.addEventListener('click', ()=>{
    star1.innerHTML = starHTML;
    star2.innerHTML = starHTML;
    star3.innerHTML = starHTML;
    star4.innerHTML = starHTML;
    star5.innerHTML = noStarHTML;
});
star5.addEventListener('click', ()=>{
    star1.innerHTML = starHTML;
    star2.innerHTML = starHTML;
    star3.innerHTML = starHTML;
    star4.innerHTML = starHTML;
    star5.innerHTML = starHTML;
});
