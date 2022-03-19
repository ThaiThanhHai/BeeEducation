/*==================Custom input file================ */
function customFile(){
    let realFileBtn = document.getElementById("account_image");
    let customBtn = document.getElementById("custom-button");
    let customTxt = document.getElementById("custom-text");

    customBtn.addEventListener("click", function(){
        realFileBtn.click();
    });

    realFileBtn.addEventListener("change", function(){
        if(realFileBtn.value){
            customTxt.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        }else{
            customTxt.innerHTML = "Không có tệp nào được chọn"
        }
    })
}

/* -----------------Menu toggle------------------------*/
let toggle = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let content = document.querySelector('.content');
let header = document.querySelector('.header');
let formContainer = document.querySelector('.form-container');
let boxContent1 = document.querySelector('.box-content');

toggle.onclick = function () {
    navigation.classList.toggle('active');
    content.classList.toggle('active');
    header.classList.toggle('active');
    formContainer.classList.toggle('active');
    boxContent1.classList.toggle('active');
}


/*--------Thêm class hovered vào danh sách đã chọn--------*/
let list = document.querySelectorAll('.navigation li');
function activeLink() {
    list.forEach((item) => 
    item.classList.remove('hovered'));
    this.classList.add('hovered')
}

list.forEach((item) => 
    item.addEventListener('mouseover', activeLink));


/*----------------pop up xác nhận xóa dữ liêu-----------------*/
var elems = document.getElementsByClassName('confirmDelete');
var confirmIt = function (e) {
    if (!confirm('Bạn có chắc chắn muốn xóa?')) e.preventDefault();
};
for (var i = 0, l = elems.length; i < l; i++) {
    elems[i].addEventListener('click', confirmIt, false);
}



/*--------------Đóng mở pop up thêm dữ liêu-------------- */

let closed = document.querySelector('.form-container form .close');
let form = document.querySelector('.form-container');
let added = document.querySelector('.box-content .add');
let boxContent = document.querySelector('.box-content');
let exited = document.querySelector('.form-container .form .form-button .exit');

added.onclick = function() {
    form.classList.add('popup');
    boxContent.classList.add('popup')
}


closed.onclick = function() {
    form.classList.remove('popup');
    boxContent.classList.remove('popup');
    e.preventDefault()
    
}


exited.onclick = function(){
    form.classList.remove('popup');
    boxContent.classList.remove('popup');
    e.preventDefault()
}









