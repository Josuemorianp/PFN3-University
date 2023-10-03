const body = document.querySelector("#body");
const btnDM = document.querySelector("#darkMode");

btnDM.addEventListener("click", ()=>{
    if(body.classList.contains("dark")){
        body.classList.remove("dark")
    }else{
        body.classList.add("dark")
    }
})
