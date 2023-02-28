function navActive() {
    const enlaces = document.querySelectorAll(".barra-servicios a");
    const URLactual = window.location.href;
    console.log(URLactual);

    // const containAnuncio = URLactual.includes("/anuncio/");
    enlaces.forEach((e) => {
        if (e.href == URLactual) {
            e.classList.add("active");
        }
    });
    // if (URLactual == "http://bienes-raices.test/entrada") {
    //     enlaces[2].classList.add("active");
    // }

    // if (containAnuncio) {
    //     enlaces[1].classList.add("active");
    // }
}

navActive();