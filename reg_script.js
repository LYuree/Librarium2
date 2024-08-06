const form = document.getElementById("form1");


//========= INPUTS ===========
const username = document.getElementById("username");
const fName = document.getElementById("fname");
const lName = document.getElementById('lName');
const email = document.getElementById("email");
const password = document.getElementById("password");
const password2 = document.getElementById("password2");


// ================== PASSWORD VISIBILITY BUTTONS ==================

const toggle_v1 = document.getElementsByClassName("toggle_visibility")[0];
const toggle_v2 = document.getElementsByClassName("toggle_visibility")[1];


toggle_v1.addEventListener('click', function(){
    
    if (password.type === "password") {
        password.type = "text";
        toggle_v1.style.background ="url(https://static.waterstones.com/1.36.7/img/mobile-app/icons/eye.png)";
      } else {  
        password.type = "password";
        toggle_v1.style.background ="url(https://static.waterstones.com/1.36.7/img/mobile-app/icons/eye-grey.png)";
      }
});

toggle_v2.addEventListener('click', function(){
    
    if (password2.type === "password") {
        password2.type = "text";
        toggle_v2.style.background ="url(https://static.waterstones.com/1.36.7/img/mobile-app/icons/eye.png)";
      } else {
        password2.type = "password";
        toggle_v2.style.background ="url(https://static.waterstones.com/1.36.7/img/mobile-app/icons/eye-grey.png)";
      }
});
