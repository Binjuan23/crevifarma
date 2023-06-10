const wrapper = document.querySelector(".wrapper");
const loginLink = document.querySelector(".login-link");
const registerLink = document.querySelector(".register-link");
if(loginLink){
    loginLink.addEventListener("click",(()=>{
    wrapper.classList.add("active");
    wrapper.classList.remove("valogin");
    $("#login-form").validate().resetForm();
}));
}

if(registerLink){
    registerLink.addEventListener("click",(()=>{
    wrapper.classList.remove("active");
    wrapper.classList.remove("valre");
    $("#register-form").validate().resetForm();
}));
}


$(document).ready(function () {

    $(".burguer").click(function () {
        $(".navMovil").slideToggle("slow");

    });  



});
