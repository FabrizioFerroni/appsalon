const DOM = document;

let paso = 1;
const pasoIni = 1;
const pasoFin = 3;

const cita = {
    id: null,
    nombre: "",
    fecha: "",
    hora: "",
    servicios: [],
};

DOM.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presione los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaAnterior();
    paginaSiguiente();
    consultarApi(); // Consultar api en el backend en php
    idCliente(); // Añade el id del cliente al objeto de cita
    nombreCliente(); // Añade el nombre del cliente al objeto de cita
    seleccionarFecha(); // Añade la fecha de la cita en el objeto
    seleccionarHora(); // Añade la hora de la cita en el objeto
    mostrarResumen(); // Muestra el resumen de la cita
}

function mostrarSeccion() {
    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = DOM.querySelector(".mostrar");
    if (seccionAnterior) {
        seccionAnterior.classList.remove("mostrar");
    }
    // Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = DOM.querySelector(pasoSelector);
    seccion.classList.add("mostrar");

    // Quita la clase actual al tab anterior
    const tabAnterior = DOM.querySelector(".actual");
    if (tabAnterior) {
        tabAnterior.classList.remove("actual");
    }
    // Resalta el tab actual
    const tab = DOM.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");
}

function tabs() {
    const botones = DOM.querySelectorAll(".tabs button");

    botones.forEach((boton) => {
        boton.addEventListener("click", (e) => {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const pagAnt = DOM.querySelector("#anterior");
    const pagSig = DOM.querySelector("#siguiente");

    if (paso === 1) {
        pagAnt.classList.add("ocultar");
        pagSig.classList.remove("ocultar");
    } else if (paso === 3) {
        pagAnt.classList.remove("ocultar");
        pagSig.classList.add("ocultar");
        mostrarResumen();
    } else {
        pagSig.classList.remove("ocultar");
        pagAnt.classList.remove("ocultar");
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const pagAnt = DOM.querySelector("#anterior");
    pagAnt.addEventListener("click", () => {
        if (paso <= pasoIni) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const pagSig = DOM.querySelector("#siguiente");
    pagSig.addEventListener("click", () => {
        if (paso >= pasoFin) return;
        paso++;
        botonesPaginador();
    });
}

async function consultarApi() {
    try {
        const URLdomain = window.location.origin;
        const url = `${URLdomain}/api/servicios`;
        // console.log(url);
        // const resultado = await fetch(url);
        // const servicios = await resultado.json();
        // mostrarServicios(servicios);
        await fetch(url)
            .then((resp) => resp.json())
            .then(function(data) {
                mostrarServicios(data);
            })
            .catch(function(error) {
                console.log(error);
            });
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach((servicio) => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = DOM.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;

        const precioServicio = DOM.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$${precio
      .toString()
      .replace(/\./g, ",")
      .toLocaleString("es-AR")}`;

        const servicioDiv = DOM.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id;

        servicioDiv.onclick = () => {
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        const servicioView = DOM.querySelector("#servicios");
        servicioView.appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    const divServicio = DOM.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado
    if (servicios.some((agregado) => agregado.id === id)) {
        // Eliminarlo
        cita.servicios = servicios.filter((agregado) => agregado.id !== id);
        divServicio.classList.remove("seleccionado");
    } else {
        // Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado");
    }
}

function idCliente() {
    cita.id = DOM.querySelector("#id").value;
}

function nombreCliente() {
    cita.nombre = DOM.querySelector("#nombre").value;
}

function seleccionarFecha() {
    const inputFecha = DOM.querySelector("#fecha");
    inputFecha.addEventListener("input", (e) => {
        const dia = new Date(e.target.value).getUTCDay();

        if ([0, 1].includes(dia)) {
            e.target.value = "";
            mostrarAlerta(
                "Domingo y Lunes no trabajamos",
                "error",
                "#paso-2 p",
                true
            );
        } else {
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora() {
    const inputHora = DOM.querySelector("#hora");
    inputHora.addEventListener("input", (e) => {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if (hora < 10 || hora > 18) {
            e.target.value = "";
            mostrarAlerta(
                "Abrimos de 10 de la mañana hasta las 6 de la tarde",
                "error",
                "#paso-2 p",
                true
            );
        } else {
            cita.hora = e.target.value;
        }
    });
}

function mostrarResumen() {
    const resumen = DOM.querySelector(".contenedor-resumen");
    // Limpiar contenido de resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes("") || cita.servicios.length === 0) {
        mostrarAlerta(
            "Faltan datos de servicios, fecha u hora",
            "error",
            ".contenedor-resumen",
            false
        );
        return;
    }

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;

    // Heading para servicios en resumen
    const headingServicios = DOM.createElement("H3");
    headingServicios.textContent = "Resumen de los servicios solicitados";
    resumen.appendChild(headingServicios);
    servicios.forEach((servicio) => {
        const { id, nombre, precio } = servicio;
        const contenedorServicio = DOM.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");

        const textoServicio = DOM.createElement("P");
        textoServicio.textContent = nombre;

        const precioServicio = DOM.createElement("P");
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    // Heading para servicios en resumen
    const headingCliente = DOM.createElement("H3");
    headingCliente.textContent = "Resumen del turno solicitado";
    resumen.appendChild(headingCliente);

    const nombreCliente = DOM.createElement("P");
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    const fechaFormateada = fechaUTC.toLocaleDateString("es-AR", opciones);

    const fechaCliente = DOM.createElement("P");
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCliente = DOM.createElement("P");
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} horas`;

    // Boton para crear un turno
    const botonReservar = DOM.createElement("BUTTON");
    botonReservar.classList.add("boton");
    botonReservar.textContent = "Reservar turno";
    botonReservar.onclick = reservarTurno;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    resumen.appendChild(botonReservar);
}

async function reservarTurno() {
    const { id, nombre, fecha, hora, servicios } = cita;

    const idServicios = servicios.map((servicio) => servicio.id);

    const data = new FormData();

    data.append("fecha", fecha);
    data.append("hora", hora);
    data.append("usuarioId", id);
    data.append("servicios", idServicios);

    const URLdomain = window.location.origin;
    const url = `${URLdomain}/api/turnos`;

    try {
        const respuesta = await fetch(url, {
            method: "POST",
            body: data,
        });

        const resultado = await respuesta.json();

        // Formatear la fecha en español
        const fechaObj = new Date(fecha);
        const mes = fechaObj.getMonth();
        const dia = fechaObj.getDate() + 2;
        const year = fechaObj.getFullYear();

        const fechaUTC = new Date(Date.UTC(year, mes, dia));
        const opciones = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        const fechaFormateada = fechaUTC.toLocaleDateString("es-AR", opciones);

        if (resultado.resultado) {
            swal
                .fire({
                    title: `Gracias ${nombre} 😁`,
                    text: `Has reservado con éxito tu turno para el dia ${fechaFormateada} a las ${hora} horas.`,
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#0da6f3",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "outnone",
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
        } else {
            swal
                .fire({
                    title: `Upps... hubo un error 😣`,
                    text: `Lamentamos que esto haya pasado, trata de volver a intentarlo.`,
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#0da6f3",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "outnone",
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
        }
    } catch (error) {
        swal
            .fire({
                title: `Upps... hubo un error 😢`,
                text: `No hemos podido procesar tu solicitud para guardar tu turno.`,
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#0da6f3",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "outnone",
                },
            })
            .then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
    }
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece) {
    // Previene que se genere mas una alerta
    const alertaPrevia = DOM.querySelector(".alerta");
    const alertaPrevia2 = DOM.querySelector(".alerta2");

    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    if (alertaPrevia2) {
        alertaPrevia2.remove();
    }
    // Scripting para generar alertas
    const alerta = DOM.createElement("DIV");
    const cerrar = DOM.createElement("SPAN");
    if (desaparece) {
        cerrar.textContent = "X";
        cerrar.classList.add("cerrar");
        cerrar.title = "Cerrar";
        alerta.textContent = mensaje;
        alerta.appendChild(cerrar);
        alerta.classList.add("alerta");
        alerta.classList.add(tipo);
        const referencia = DOM.querySelector(elemento);
        referencia.appendChild(alerta);

        // Cerrar alertas
        cerrar.addEventListener("click", () => {
            alerta.style.display = "none";
        });
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    } else {
        alerta.textContent = mensaje;
        alerta.classList.add("alerta2");
        alerta.classList.add(tipo);
        const referencia = DOM.querySelector(elemento);
        referencia.appendChild(alerta);
    }
}