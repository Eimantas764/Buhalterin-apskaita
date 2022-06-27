
    try{
        let burger = document.querySelector(".burger");
        let menu = document.querySelector(".items");
        let i = 0;
        burger.addEventListener("click", (e)=>{
            menu.classList.toggle("show-menu");
            setTimeout(() => menu.classList.toggle("extra-transition"), 1000);
        })
    }
    catch(err){ }

