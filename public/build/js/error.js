const listaCerrar=document.querySelectorAll(".cerrar");Array.from(listaCerrar).forEach(r=>{r.addEventListener("click",()=>{r.parentNode.style.display="none"})});