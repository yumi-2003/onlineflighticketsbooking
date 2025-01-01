

    

   // Show password
   function showPwd(){
    const pwd = document.getElementById('pwd');
    if(pwd.type === 'password'){
        pwd.type = 'text';
    }else{
        pwd.type = 'password';
    }
    
}