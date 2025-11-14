/* Variables de paginacion*/
let listaAlumnos = []; // ← Aquí se guarda todo
let paginaActual = 1;
const filasPorPagina = 10;
let totalPaginas = 1;


/* Cargar Alumnos */
async function cargarAlumnos() {
    try {
        const res = await fetch("php/api.php");
        listaAlumnos = await res.json();

        if (!Array.isArray(listaAlumnos)) {
            console.error("Respuesta inesperada:", listaAlumnos);
            return;
        }

        totalPaginas = Math.ceil(listaAlumnos.length / filasPorPagina);

        mostrarPagina();
    } catch (e) {
        console.error("Error al cargar alumnos:", e);
    }
}


/* Mostrar tabla de alumnos paginados*/
function mostrarPagina() {
    const tbody = document.querySelector("#tablaAlumnos tbody");
    tbody.innerHTML = "";

    const inicio = (paginaActual - 1) * filasPorPagina;
    const fin = inicio + filasPorPagina;

    const paginaDatos = listaAlumnos.slice(inicio, fin);

    paginaDatos.forEach(alumno => {
        tbody.innerHTML += `
                <tr>
                    <td>${alumno.Id}</td>
                    <td>${alumno.Matricula}</td>
                    <td>${alumno.Nombre}</td>
                    <td>${alumno.Apaterno}</td>
                    <td>${alumno.Amaterno ?? ""}</td>
                    <td>${alumno.Email}</td>
                    <td>${alumno.Celular}</td>
                    <td>${alumno.CP}</td>
                    <td>${alumno.Sexo}</td>
                    <td><button class="btn-editar" data-id="${alumno.Id}">Editar</button></td>
                    <td><button class="btn-eliminar" data-id="${alumno.Id}">Eliminar</button></td>
                </tr>
            `;
    });

    document.getElementById("paginaActual").textContent =
        `Página ${paginaActual} de ${totalPaginas}`;
}



/* Botones de paginacion */
document.getElementById("btnPrimero").onclick = () => {
    paginaActual = 1;
    mostrarPagina();
};

document.getElementById("btnAnterior").onclick = () => {
    if (paginaActual > 1) paginaActual--;
    mostrarPagina();
};

document.getElementById("btnSiguiente").onclick = () => {
    if (paginaActual < totalPaginas) paginaActual++;
    mostrarPagina();
};

document.getElementById("btnUltimo").onclick = () => {
    paginaActual = totalPaginas;
    mostrarPagina();
};



/* Insertar Alumnos */
document.getElementById("formAlumno").addEventListener("submit", async function (e) {
    e.preventDefault();

    const datos = Object.fromEntries(new FormData(this).entries());

    try {
        const res = await fetch("php/api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        });

        const respuesta = await res.json();

        mostrarMensaje("Alumno guardado correctamente");
        this.reset();
        cargarAlumnos(); // recargar paginación

    } catch (error) {
        mostrarMensaje("❌ Error al conectar", true);
    }
});



/* Editar y eliminar alumnos*/
document.addEventListener("click", async function (e) {

    /* Eliminar */
    if (e.target.classList.contains("btn-eliminar")) {
        const id = e.target.dataset.id;

        if (confirm("¿Seguro que deseas eliminar este alumno?")) {
            await fetch("php/api.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    Id: id
                })
            });

            mostrarMensaje("Alumno eliminado");
            cargarAlumnos();
        }
    }


    /* Editar */
    if (e.target.classList.contains("btn-editar")) {

        const fila = e.target.closest("tr");
        const c = fila.querySelectorAll("td");

        document.getElementById("modalEditar").style.display = "flex";

        document.getElementById("editId").value = e.target.dataset.id;
        document.getElementById("editMatricula").value = c[1].textContent;
        document.getElementById("editNombre").value = c[2].textContent;
        document.getElementById("editApaterno").value = c[3].textContent;
        document.getElementById("editAmaterno").value = c[4].textContent;
        document.getElementById("editEmail").value = c[5].textContent;
        document.getElementById("editCelular").value = c[6].textContent;
        document.getElementById("editCP").value = c[7].textContent;
        document.getElementById("editSexo").value = c[8].textContent;
    }
});



/* Guardar edicion */
document.getElementById("btnGuardarEdicion").onclick = async () => {

    const alumno = {
        Id: document.getElementById("editId").value,
        Matricula: document.getElementById("editMatricula").value,
        Nombre: document.getElementById("editNombre").value,
        Apaterno: document.getElementById("editApaterno").value,
        Amaterno: document.getElementById("editAmaterno").value,
        Email: document.getElementById("editEmail").value,
        Celular: document.getElementById("editCelular").value,
        CP: document.getElementById("editCP").value,
        Sexo: document.getElementById("editSexo").value
    };

    const res = await fetch("php/api.php", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(alumno)
    });

    mostrarMensaje("Alumno actualizado");
    document.getElementById("modalEditar").style.display = "none";
    cargarAlumnos();
};


document.getElementById("btnCerrarModal").onclick = () => {
    document.getElementById("modalEditar").style.display = "none";
};


/* Mensaje */
function mostrarMensaje(texto, error = false) {
    const msg = document.getElementById("mensaje");
    msg.textContent = texto;
    msg.style.background = error ? "#e74c3c" : "#2ecc71";
    msg.style.display = "block";
    setTimeout(() => msg.style.display = "none", 2500);
}

cargarAlumnos();
