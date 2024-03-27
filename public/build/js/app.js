let paso=1,pasoInicial=1,pasoFinal=3;const cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),idCliente(),nombreCliente(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");const t="#paso-"+paso;document.querySelector(t).classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");1===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar"),mostrarResumen()):(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=pasoInicial||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=pasoFinal||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e=location.origin+"/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}try{const e=location.origin+"/api/horas",t=await fetch(e);mostrarHoras(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent=a+"€";const i=document.createElement("DIV");i.classList.add("servicio"),i.dataset.idServicio=t,i.onclick=function(){seleccionarServicio(e)},i.appendChild(n),i.appendChild(c),document.querySelector("#servicios").appendChild(i)})}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,a=document.querySelector(`[data-id-servicio="${t}"]`);o.some(e=>e.id===t)?(cita.servicios=o.filter(e=>e.id!==t),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado"))}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("change",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Fines de semana no permitidos","error",".formulario")):(cita.fecha=e.target.value,deshabilitarHoras())}))}async function deshabilitarHoras(){try{const e=`${location.origin}/api/horasdisponibles?fecha=${cita.fecha}`,t=await fetch(e),o=await t.json();document.querySelectorAll("#hora option").forEach(e=>{o.find(t=>t.hora===e.value)?(e.disabled=!0,e.classList.remove("disponible"),e.classList.add("disabled"),e.textContent=e.value+" - No disponible"):(e.disabled=!1,e.classList.remove("disabled"),e.textContent=e.value,e.classList.add("disponible"))})}catch(e){console.log(e)}}function mostrarHoras(e){const t=document.querySelector("#hora");e.forEach(e=>{const{id:o,hora:a}=e,n=document.createElement("OPTION");n.value=a,n.textContent=a,n.dataset.hora_id=o,n.classList.add("disponible"),t.appendChild(n)})}function seleccionarHora(){document.querySelector("#hora").addEventListener("change",(function(e){const t=e.target.value,o=e.target.selectedOptions[0].dataset.hora_id;cita.hora=t,cita.hora_id=o}))}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector("alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),a&&setTimeout(()=>{c.remove()},3e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos de Servicios, Fecha u Hora","error",".contenido-resumen",!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("H3");c.textContent="Resumen de Servicios",e.appendChild(c),n.forEach(t=>{const{id:o,precio:a,nombre:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const i=document.createElement("P");i.textContent=n;const r=document.createElement("P");r.innerHTML=`<span>Precio:</span> ${a}€`,c.appendChild(i),c.appendChild(r),e.appendChild(c)});const i=document.createElement("H3");i.textContent="Resumen de Cita",e.appendChild(i);const r=document.createElement("P");r.innerHTML="<span>Nombre:</span> "+t;const s=new Date(o),d=s.getMonth(),l=s.getDate(),u=s.getFullYear(),m=new Date(Date.UTC(u,d,l)).toLocaleDateString("es-ES",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),p=document.createElement("P");p.innerHTML="<span>Fecha:</span> "+m;const h=document.createElement("P");h.innerHTML=`<span>Hora:</span> ${a} Horas`;const v=document.createElement("BUTTON");v.classList.add("boton"),v.textContent="Reservar Cita",v.onclick=reservarCita,e.appendChild(r),e.appendChild(p),e.appendChild(h),e.appendChild(v)}async function reservarCita(){const{fecha:e,hora:t,hora_id:o,id:a,servicios:n}=cita,c=n.map(e=>e.id),i=new FormData;i.append("fecha",e),i.append("horaId",o),i.append("usuarioId",a),i.append("servicios",c);try{const e=location.origin+"/api/citas",t=await fetch(e,{method:"POST",body:i});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita Creada",text:"Tu cita fue creada correctamente",button:"OK"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un error al guardar la cita"})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));