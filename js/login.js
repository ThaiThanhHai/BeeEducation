const signUpBtn = document.getElementById('SignUp');
const signInBtn = document.getElementById('SignIn');
const container = document.querySelector('.container');

signUpBtn.addEventListener('click', ()=>{
    container.classList.add("right-panel-active");
})

signInBtn.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
})


function validateform() {
let name = document.getElementById('account_name');
let password1 = document.getElementById('account_password1');
let password = document.getElementById('account_password');
if (password.value.length < 5) {
    alert("Mật khẩu phải có ít nhất 5 kí tự");
    return false;
}else if(password.value != password1.value){
    alert("Xác nhận mật khẩu không chính xác. Vui lòng kiểm tra lại!");
    return false;
}else if(name.value.trim() == ""){
    alert("Vui lòng nhập tên tài khoản!");
    return false;
}   
}


const realFileBtn = document.getElementById("real-file");
const customBtn = document.getElementById("custom-button");
const customTxt = document.getElementById("custom-text");

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