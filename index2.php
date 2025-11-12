<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Alumnos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Registrar Alumno</h1>

    <form id="formAlumno">
        <input type="text" name="Matricula" placeholder="Matrícula" required pattern="\d{1,9}" title="Solo números, máximo 9 dígitos"><br>
        <input type="text" name="Nombre" placeholder="Nombre" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres"><br>
        <input type="text" name="Apaterno" placeholder="Apellido Paterno" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres"><br>
        <input type="text" name="Amaterno" placeholder="Apellido Materno" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres"><br>
        <input type="email" name="Email" placeholder="Correo electrónico" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" title="Debe ser un correo válido"><br>
        <input type="text" name="Celular" placeholder="Celular" required pattern="\d{10}" maxlength="10" title="Solo 10 dígitos numéricos"><br>
        <input type="text" name="CP" placeholder="Código Postal" required pattern="\d{5}" maxlength="5" title="Solo 5 dígitos numéricos"><br>
        <select name="Sexo" required>
            <option value="">Seleccionar Sexo</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
        </select><br>
        <button type="submit">Guardar</button>
    </form>

    <hr>

    <h2>Lista de alumnos</h2>
    <table border="1" id="tablaAlumnos">
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

    <!-- Modal para editar alumno -->
    <div id="modalEditar" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:8px; width:400px;">
            <h3>Editar Alumno</h3>
            <input type="hidden" id="editId">

            <input type="text" id="editMatricula" placeholder="Matrícula" maxlength="9" pattern="\d{1,9}" title="Solo números, máximo 9 dígitos"><br>
            <input type="text" id="editNombre" placeholder="Nombre" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres"><br>
            <input type="text" id="editApaterno" placeholder="Apellido Paterno" required maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres"><br>
            <input type="text" id="editAmaterno" placeholder="Apellido Materno" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,50}" title="Solo letras, máximo 50 caracteres"><br>
            <input type="email" id="editEmail" placeholder="Correo electrónico" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" title="Debe ser un correo válido"><br>
            <input type="text" id="editCelular" placeholder="Celular" maxlength="9" required pattern="\d{10}" maxlength="10" title="Solo 10 dígitos numéricos"><br>
            <input type="text" id="editCP" placeholder="Código Postal" maxlength="5" required pattern="\d{5}" maxlength="5" title="Solo 5 dígitos numéricos"><br>
            <select id="editSexo" required>
                <option value="">Seleccionar Sexo</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select><br><br>

            <button id="btnGuardarEdicion">Guardar Cambios</button>
            <button id="btnCerrarModal">Cancelar</button>
        </div>
    </div>


    <script>
        const mensajeDiv = document.createElement("div");
        mensajeDiv.id = "mensaje";
        mensajeDiv.style.display = "none";
        mensajeDiv.style.background = "#2ecc71";
        mensajeDiv.style.color = "white";
        mensajeDiv.style.padding = "8px";
        mensajeDiv.style.borderRadius = "5px";
        mensajeDiv.style.marginBottom = "10px";
        mensajeDiv.style.textAlign = "center";
        document.body.insertBefore(mensajeDiv, document.querySelector("hr"));

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

                const text = await res.text();
                console.log("Respuesta del servidor:", text);

                let respuesta;
                try {
                    respuesta = JSON.parse(text);
                } catch {
                    mostrarMensaje("❌ Error: el servidor no devolvió JSON válido.", true);
                    return;
                }

                if (respuesta.error) {
                    mostrarMensaje("❌ " + respuesta.error, true);
                } else {
                    mostrarMensaje("✅ " + respuesta.mensaje);
                    this.reset();
                    cargarAlumnos(); // actualiza tabla automáticamente
                }

            } catch (error) {
                console.error("Error en fetch:", error);
                mostrarMensaje("❌ Error al conectar con el servidor", true);
            }
        });

        async function cargarAlumnos() {
            try {
                const res = await fetch("php/api.php");
                const data = await res.json();

                const tbody = document.querySelector("#tablaAlumnos tbody");
                tbody.innerHTML = "";

                if (!Array.isArray(data)) {
                    console.error("Respuesta inesperada:", data);
                    return;
                }

                data.forEach(alumno => {
                    const fila = `
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
        </tr>`;
                    tbody.innerHTML += fila;
                });
            } catch (error) {
                console.error("Error al cargar alumnos:", error);
            }
        }

        function mostrarMensaje(texto, error = false) {
            const msg = document.getElementById("mensaje");
            msg.textContent = texto;
            msg.style.background = error ? "#e74c3c" : "#2ecc71";
            msg.style.display = "block";
            setTimeout(() => {
                msg.style.display = "none";
            }, 2500);
        }


        // Botones de eliminar y editar

        document.addEventListener("click", async function(e) {
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
                    alert("Alumno eliminado correctamente");
                    cargarAlumnos();
                }
            }

            if (e.target.classList.contains("btn-editar")) {
                const id = e.target.dataset.id;
                const fila = e.target.closest("tr");
                const celdas = fila.querySelectorAll("td");

                // Abrir la ventana modal
                document.getElementById("modalEditar").style.display = "block";

                // Rellenar campos con los datos del alumno seleccionado
                document.getElementById("editId").value = id;
                document.getElementById("editMatricula").value = celdas[1].textContent;
                document.getElementById("editNombre").value = celdas[2].textContent;
                document.getElementById("editApaterno").value = celdas[3].textContent;
                document.getElementById("editAmaterno").value = celdas[4].textContent;
                document.getElementById("editEmail").value = celdas[5].textContent;
                document.getElementById("editCelular").value = celdas[6].textContent;
                document.getElementById("editCP").value = celdas[7].textContent;
                document.getElementById("editSexo").value = celdas[8].textContent;
            }

        });

        // Cerrar modal
        document.getElementById("btnCerrarModal").addEventListener("click", () => {
            document.getElementById("modalEditar").style.display = "none";
        });

        // Guardar cambios
        document.getElementById("btnGuardarEdicion").addEventListener("click", async () => {
            const alumnoActualizado = {
                Id: document.getElementById("editId").value,
                Matricula: document.getElementById("editMatricula").value,
                Nombre: document.getElementById("editNombre").value,
                Apaterno: document.getElementById("editApaterno").value,
                Amaterno: document.getElementById("editAmaterno").value,
                Email: document.getElementById("editEmail").value,
                Celular: document.getElementById("editCelular").value,
                CP: document.getElementById("editCP").value,
                Sexo: document.getElementById("editSexo").value,
            };

            try {
                const res = await fetch("php/api.php", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(alumnoActualizado),
                });

                const data = await res.json();
                if (data.mensaje) {
                    alert("✅ " + data.mensaje);
                    document.getElementById("modalEditar").style.display = "none";
                    cargarAlumnos(); // 🔁 Recargar tabla
                } else {
                    alert("❌ " + (data.error || "Error al actualizar"));
                }
            } catch (error) {
                console.error("Error al actualizar:", error);
                alert("❌ Error al conectar con el servidor");
            }
        });


        cargarAlumnos();
    </script>

</body>

</html>