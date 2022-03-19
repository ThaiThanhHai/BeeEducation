let menu = document.querySelector('#menu-btn');
let header = document.querySelector('.header');

menu.onclick = () => {
    menu.classList.toggle('fa-times');
    header.classList.toggle('active');

}


let themeToggler = document.querySelector('#theme-toggler');

themeToggler.onclick = () => {
    themeToggler.classList.toggle('fa-sun');
    if(themeToggler.classList.contains('fa-sun')){
        document.body.classList.add('active')
    }else{
        document.body.classList.remove('active')
    }
}


CKEDITOR.replace( 'content',
{   
    filebrowserBrowseUrl: 'Admin/plugins/ckfinder/ckfinder.html',
    filebrowserUploadUrl: 'Admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 });