const password = document.getElementById("password");
const toggle_v1 = document.getElementsByClassName("toggle_visibility")[0];


toggle_v1.addEventListener('click', function(){
    
    if (password.type === "password") {
        password.type = "text";
        toggle_v1.style.background ="url(images/eye-green.png)";
      } else {  
        password.type = "password";
        toggle_v1.style.background ="url(images/eye-grey.png)";
      }
});