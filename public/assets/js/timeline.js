// let start = 0;
// otomatis();

// function otomatis()
// {
//     const sliders = document.querySelectorAll(".image");
//     for (let i = 0; i < sliders.length; i++)
//     {
//         sliders[i].style.display = "none";
//     }

//     if (start >= sliders.lenght)
//     {
//         start = 0;
//     }

//     sliders[start].style.display = "block";
//     console.log("gambar  ke" +start);
//     start++;

//     setTimeout(otomatis, 2000);
// }

// let slider = document.querySelector('.sliders .slider');
// let items = document.querySelectorAll('.sliders .slider .image');
// let next = document.getElementById('next');
// let prev = document.getElementById('prev');
// let dots = document.querySelectorAll('.sliders .dots li');

// let lengthItems = items.length - 1;
// let active = 0;
// next.onclick = function(){
//     active = active + 1 <= lengthItems ? active + 1 : 0;
//     reloadSliders();
// }
// prev.onclick = function(){
//     active = active - 1 >= 0 ? active - 1 : lengthItems;
//     reloadSliders();
// }
// let refreshInterval = setInterval(()=> {next.click()}, 3000);
// function reloadSliders(){
//     slider.style.left = -items[active].offsetLeft + 'px';
//     //
//     let last_active_dot = document.querySelector('.sliders .dots li.active');
//     last_active_dot.classList.remove('active');
//     dots[active].classList.add('active');

//     clearInterval(refreshInterval);
//     refreshInterval = setInterval(()=> {next.click()}, 3000);

// }

// dots.forEach((li, key) => {
//     li.addEventListener('click', ()=>{
//          active = key;
//          reloadSlider();
//     })
// })
// window.onresize = function(event) {
//     reloadSliders();
// };

// $(function () {
//   window.sr = ScrollReveal();

//   if ($(window).width() < 768) {
//     if ($(".timeline-content").hasClass("js--fadeInLeft")) {
//       $(".timeline-content").removeClass("js--fadeInLeft").addClass("js--fadeInRight");
//     }

//     sr.reveal(".js--fadeInRight", {
//       origin: "right",
//       distance: "200px",
//       easing: "ease-in-out",
//       duration: 800,
//     });
//   } else {
//     sr.reveal(".js--fadeInLeft", {
//       origin: "left",
//       distance: "200px",
//       easing: "ease-in-out",
//       duration: 800,
//     });

//     sr.reveal(".js--fadeInRight", {
//       origin: "right",
//       distance: "200px",
//       easing: "ease-in-out",
//       duration: 800,
//     });
//   }

//   sr.reveal(".js--fadeInLeft", {
//     origin: "left",
//     distance: "200px",
//     easing: "ease-in-out",
//     duration: 800,
//   });

//   sr.reveal(".js--fadeInRight", {
//     origin: "right",
//     distance: "200px",
//     easing: "ease-in-out",
//     duration: 800,
//   });
// });
