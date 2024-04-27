const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click', function(){
    const userBox =document.querySelector('.profile-detail');
    userBox.classList.toggle('active');
})

const toggle = document.querySelector('#menu-bars');
toggle.addEventListener('click', function(){
    const navbar =document.querySelector('.navbar');
    navbar.classList.toggle('active');
})

let searchForm =document.querySelector('.search-form');
document.querySelector('#search-icon').onclick =() =>{
    searchForm.classList.toggle('active');
    userBox.classList.remove('active');
}

var swiper = new Swiper(".home-slider", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    loop:true,
    
});