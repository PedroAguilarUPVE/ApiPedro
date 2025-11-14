<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Alumnos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">


</head>

<body>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Gestión de Alumnos</h2>

        <div id="formularioPrincipal">
            <h4>Registro de Alumno</h4>
            <form id="formAlumno">
                <input type="text" id="Matricula" name="Matricula" placeholder="Matrícula" maxlength="9" pattern="\d{1,9}" title="Solo números, máximo 9 dígitos" required>
                <input type="text" id="Nombre" name="Nombre" placeholder="Nombre" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres">
                <input type="text" id="Apaterno" name="Apaterno" placeholder="Apellido Paterno" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres">
                <input type="text" id="Amaterno" name="Amaterno" placeholder="Apellido Materno" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres">
                <input type="email" id="Email" name="Email" placeholder="Correo electrónico" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" title="Debe ser un correo válido">
                <input type="text" id="Celular" name="Celular" placeholder="Celular" maxlength="10" required pattern="\d{10}" title="Solo 10 dígitos numéricos">
                <input type="text" id="CP" name="CP" placeholder="Código Postal" maxlength="5" required pattern="\d{5}" title="Solo 5 dígitos numéricos">
                <select id="Sexo" name="Sexo" required>
                    <option value="">Seleccionar sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <button id="btnRegistrar" type="submit" class="w-100">Registrar</button>
            </form>
        </div>

        <div id="mensaje"></div>

        <h4 class="mt-4 mb-3">Lista de alumnos</h4>
        <table class="table table-bordered table-striped" id="tablaAlumnos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>CP</th>
                    <th>Sexo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="pagination">
            <button id="btnPrimero">⏮ Inicio</button>
            <button id="btnAnterior">◀ Anterior</button>
            <span id="paginaActual"></span>
            <button id="btnSiguiente">Siguiente ▶</button>
            <button id="btnUltimo">Fin ⏭</button>
        </div>
    </div>

    <!-- Modal para editar alumno -->
    <div id="modalEditar" class="modal" style="display: none;">
        <div class="modal-content">
            <h3 class="text-center mb-3">Editar Alumno</h3>
            <input type="hidden" id="editId">

            <input type="text" id="editMatricula" placeholder="Matrícula" maxlength="9" pattern="\d{1,9}" title="Solo números, máximo 9 dígitos" required>
            <input type="text" id="editNombre" placeholder="Nombre" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres">
            <input type="text" id="editApaterno" placeholder="Apellido Paterno" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres">
            <input type="text" id="editAmaterno" placeholder="Apellido Materno" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres">
            <input type="email" id="editEmail" placeholder="Correo electrónico" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" title="Debe ser un correo válido">
            <input type="text" id="editCelular" placeholder="Celular" maxlength="10" required pattern="\d{10}" title="Solo 10 dígitos numéricos">
            <input type="text" id="editCP" placeholder="Código Postal" maxlength="5" required pattern="\d{5}" title="Solo 5 dígitos numéricos">

            <select id="editSexo" required>
                <option value="">Seleccionar sexo</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>

            <div class="text-center mt-3">
                <button id="btnGuardarEdicion">Guardar cambios</button>
                <button id="btnCerrarModal">Cancelar</button>
            </div>
        </div>
    </div>


    <script>
        /* ============================================
       VARIABLES GLOBALES PARA PAGINACIÓN
    ============================================ */
        let listaAlumnos = []; // ← Aquí se guarda todo
        let paginaActual = 1;
        const filasPorPagina = 10;
        let totalPaginas = 1;


        /* ============================================
           FUNCIÓN PRINCIPAL: CARGAR + PAGINAR
        ============================================ */
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


        /* ============================================
           MOSTRAR UNA PÁGINA DE DATOS
        ============================================ */
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



        /* ============================================
           BOTONES DE PAGINACIÓN
        ============================================ */
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



        /* ============================================
           INSERTAR ALUMNO
        ============================================ */
        document.getElementById("formAlumno").addEventListener("submit", async function(e) {
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



        /* ============================================
           EDITAR + ELIMINAR (Delegación de eventos)
        ============================================ */
        document.addEventListener("click", async function(e) {

            /* ---- ELIMINAR ---- */
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


            /* ---- EDITAR ---- */
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



        /* ============================================
           GUARDAR EDICIÓN DEL MODAL
        ============================================ */
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


        /* ============================================
           MENSAJE EMERGENTE
        ============================================ */
        function mostrarMensaje(texto, error = false) {
            const msg = document.getElementById("mensaje");
            msg.textContent = texto;
            msg.style.background = error ? "#e74c3c" : "#2ecc71";
            msg.style.display = "block";
            setTimeout(() => msg.style.display = "none", 2500);
        }



        /* ============================================
           INICIO
        ============================================ */
        cargarAlumnos();
    </script>

</body>

</html>