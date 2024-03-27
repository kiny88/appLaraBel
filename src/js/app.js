let paso = 1;
let pasoInicial = 1;
let pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
};

document.addEventListener('DOMContentLoaded',function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion();   // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente();  // Cambia la seccion cuando se presiona el paginador hacia delante
    paginaAnterior();   // Cambia la seccion cuando se presiona el paginador hacia atrás
    consultarAPI(); // Consulta la API en el backend de PHP
    idCliente();    // Agregar el id del cliente al objeto cita
    nombreCliente();    // Agregar el nombre del cliente al objeto cita
    seleccionarFecha(); // Agrega la fecha del servicio al objeto cita
    seleccionarHora(); // Agrega la hora del servicio al objeto cita
    mostrarResumen();   // Muestra el resumen de la cita
}

function mostrarSeccion(){
    // Ocultar la sección que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');

    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    
    // seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);

    seccion.classList.add('mostrar');

    // Quita la calse de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');

    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);

    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        });
    })
}

function botonesPaginador(){
    const paginaSiguiente = document.querySelector('#siguiente');
    const paginaAnterior = document.querySelector('#anterior');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click',function(){
        if(paso <= pasoInicial){
            return;
        }

        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click',function(){
        if(paso >= pasoFinal){
            return;
        }

        paso++;
        botonesPaginador();
    });
}

async function consultarAPI(){
    try{
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
    }catch(error){
        console.log(error);
    }

    try {
        const url = `${location.origin}/api/horas`;
        const resultado = await fetch(url);
        const horas = await resultado.json();

        mostrarHoras(horas);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        const {id,nombre,precio} = servicio;

        const nombreServicio = document.createElement('P');        
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `${precio}€`;
        
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;

    // Identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado
    if(servicios.some(agregado => agregado.id === id)){
        // Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    }else{
        // Agregarlo
        cita.servicios = [...servicios,servicio];
        divServicio.classList.add('seleccionado');
    }
}

function idCliente(){
    const id = document.querySelector('#id').value;

    cita.id = id;
}

function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;

    cita.nombre = nombre;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('change',function(e){
        const dia = new Date(e.target.value).getUTCDay();
        
        if([6,0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos','error','.formulario');
        }else{
            cita.fecha = e.target.value;
            deshabilitarHoras();
        }
    });
}

async function deshabilitarHoras(){
    try{
        const url = `${location.origin}/api/horasdisponibles?fecha=${cita.fecha}`;
        const resultado = await fetch(url);
        const horasNoDisponibles = await resultado.json();

        // Deshabilitar horas no disponibles
        const horas = document.querySelectorAll('#hora option');

        horas.forEach(hora => {
            const horaDisponible = horasNoDisponibles.find(horaNoDisponible => horaNoDisponible.hora === hora.value);

            if(horaDisponible){
                hora.disabled = true;
                hora.classList.remove('disponible');
                hora.classList.add('disabled');
                hora.textContent = `${hora.value} - No disponible`;
            }else{
                hora.disabled = false;
                hora.classList.remove('disabled');
                hora.textContent = hora.value;
                hora.classList.add('disponible');
            }
        })        
    }catch(error){
        console.log(error);
    }
}

function mostrarHoras(horas){
    const horarios = document.querySelector('#hora');

    horas.forEach(hora => {
        const {id, hora: horaCita} = hora;

        const opcion = document.createElement('OPTION');
        opcion.value = horaCita;
        opcion.textContent = horaCita;
        opcion.dataset.hora_id = id;    
        opcion.classList.add('disponible');    

        horarios.appendChild(opcion);
    })    
}

function seleccionarHora(){
    const horarios = document.querySelector('#hora');

    horarios.addEventListener('change',function(e){
        const hora = e.target.value;
        const id = e.target.selectedOptions[0].dataset.hora_id;

        cita.hora = hora;
        cita.hora_id = id;
    });
}

function mostrarAlerta(mensaje,tipo,elemento,desaparece = true){
    // Previene que se generen más de una alerta
    const alertaPrevia = document.querySelector('alerta');

    if(alertaPrevia){
        alertaPrevia.remove();
    }

    // Creación de la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        // Eliminar la alerta
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora','error','.contenido-resumen',false);
        return;
    }

    // Formatear el div de resumen
    const {nombre,fecha,hora,servicios} = cita;

    //  Cabecera para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const {id,precio,nombre} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> ${precio}€`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    //  Cabecera para cita en resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha a dd-mm-yyy
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year,mes,dia));

    const opciones = {weekday: 'long',year: 'numeric',month: 'long',day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES',opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Botón para crear un cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}

async function reservarCita(){
    const {fecha,hora,hora_id,id,servicios} = cita;
    const idServicios = servicios.map(servicio => servicio.id);
    const datos = new FormData();

    datos.append('fecha',fecha);
    datos.append('horaId',hora_id);
    datos.append('usuarioId',id);
    datos.append('servicios',idServicios);

    try{
        // Petición hacia la API
        const url = `${location.origin}/api/citas`;
        const respuesta = await fetch(url,{
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if(resultado.resultado){
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente',
                button: 'OK'
            }).then(() => {
                window.location.reload();
            });
        }
    }catch(error){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        });
    }
}