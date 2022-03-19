
// ==========Reponsive menu-bar starts==========
$(document).ready(function() {

    $('#menu').click(function() {
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    })

    $('#login').click(function(){
        $('.login-form').addClass('popup');
    })

    $('.login-form form .fa-times').click(function(){
        $('.login-form').removeClass('popup');
    })

    $(window).on('load scroll', function(){

        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        $('.login-form').removeClass('popup');

        $('section').each(function(){
            
            let top = $(window).scrollTop();
            let height = $(this).height();
            let id = $(this).attr('id');
            let offset = $(this).offset().top - 200;

            if(top > offset && top < offset + height){
                $('.navbar ul li a').removeClass('active');
                $('.navbar').find(`[href="#${id}"]`).addClass('active');
            }

        })
    })
});
//==========Reponsive menu-bar ends==========

$(document).ready(function(){

    $('.course-container').owlCarousel({
        autoplay:true,
        loop:true,
        autoplayTimeout:6000,
        responsive:{
            0:{
                items:1
            },
            700:{
                items:2
            },
            1100:{
                items:3
            }

        }
    })
});


//==========OwlCarousel slider starts==========
$(document).ready(function(){

    $('.review-container').owlCarousel({
        autoplay:true,
        loop:true,
        autoplayTimeout:6000,
        responsive:{
            0:{
                items:1
            },
            700:{
                items:2
            },
            1100:{
                items:3
            }

        }
    })
});


$(document).ready(function(){

    $('.blog-container').owlCarousel({
        autoplay:true,
        loop:true,
        autoplayTimeout:6000,
        responsive:{
            0:{
                items:1
            },
            700:{
                items:2
            },
            1100:{
                items:3
            }

        }
    })
});

//==========Owlcarousel slider ends==========

// ==========Accordion starts==========
let accordion = document.getElementsByClassName('Panel');
for(i = 0; i< accordion.length; i++){
    accordion[i].addEventListener('click', function(){
        this.classList.toggle('accordion');
    })
}
// ==========Accordion ends==========


// ==========Video gallery starts==========
// let listVideo = document.querySelectorAll('.video-list .vid .video-links');
// let mainVideo = document.querySelector('.main-video .video .main');
// let title = document.querySelector('.main-video .video .title');

// listVideo.forEach(links =>{
//     links.addEventListener('click', (e) => {
//         e.preventDefault();
//         listVideo.forEach(vid => vid.classList.remove('active'));
//         links.classList.add('active');
//         if(links.classList.contains('active')){
//             var src = links.getAttribute('href');
//             mainVideo.src = src;
//             mainVideo.play();
//             var text = links.children[0].innerHTML;
//             title.innerHTML = text;
//         }
//     })
// })
document.querySelectorAll(".video-list .vid .video-links").forEach(links => {
    links.addEventListener('click', (e) =>  {
       e.preventDefault();
       var icon = links.children[0];
       var text = links.children[1];
       var textName = text.children[0].innerHTML;

       document.querySelectorAll('.video-list .vid').forEach(vid => vid.classList.remove('active'));
       links.parentNode.classList.add('active');
       
       if(links.parentNode.classList.contains('active')){
           var src = links.getAttribute('href');
           document.querySelector('.main-video .video .main').src=src;
           document.querySelector('.main-video .title').innerHTML = textName;
       }
    })
 });

let comment = document.querySelector('.comments .form-comment form .cmt-btn');
comment.addEventListener('click', function(){
    let mainSrc = document.querySelector('.main-video .video .main').src;
    document.querySelector('.comments .form-comment form .lesson_id').value = mainSrc;
    console.log(document.querySelector('.comments .form-comment form .lesson_id').value)
})



// ==========Video gallery ends==========



