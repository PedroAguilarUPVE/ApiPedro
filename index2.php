<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Gestión de Alumnos</h1>

        <!-- Formulario de registro -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Registrar Alumno</div>
            <div class="card-body">
                <form action="php/api.php" method="POST" id="formAlumno">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Matrícula</label>
                            <input type="text" name="Matricula" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="Nombre" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Apellido Paterno</label>
                            <input type="text" name="Apaterno" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="Amaterno" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="Email" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Celular</label>
                            <input type="text" name="Celular" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Código Postal</label>
                            <input type="text" name="CP" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sexo</label>
                            <select name="Sexo" class="form-select" required>
                                <option value="">Seleccionar</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Registrar Alumno</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de alumnos -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">Lista de Alumnos</div>
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle" id="tablaAlumnos">
                    <thead class="table-dark">
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCuerpo"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar">
                        <input type="hidden" id="editId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" id="editNombre" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" id="editApaterno" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" id="editAmaterno" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" id="editEmail" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Celular</label>
                                <input type="text" id="editCelular" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CP</label>
                                <input type="text" id="editCP" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sexo</label>
                                <select id="editSexo" class="form-select">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ELIMINAR -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Eliminar Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Seguro que deseas eliminar a <strong id="nombreEliminar"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let alumnoSeleccionado = null;

        window.onload = function() {
            cargarAlumnos();
        };

        function cargarAlumnos() {
            fetch("php/api.php")
                .then(res => res.json())
                .then(datos => {
                    const cuerpo = document.getElementById("tablaCuerpo");
                    cuerpo.innerHTML = "";

                    datos.forEach(alumno => {
                        const fila = document.createElement("tr");
                        fila.innerHTML = `
              <td>${alumno.Id}</td>
              <td>${alumno.Matricula}</td>
              <td>${alumno.Nombre}</td>
              <td>${alumno.Apaterno}</td>
              <td>${alumno.Amaterno ?? ""}</td>
              <td>${alumno.Email}</td>
              <td>${alumno.Celular}</td>
              <td>${alumno.CP}</td>
              <td>${alumno.Sexo}</td>
              <td>
                <button class="btn btn-sm btn-warning me-2" onclick='abrirEditar(${JSON.stringify(alumno)})'> Editar </button>
                <button class="btn btn-sm btn-danger" onclick='abrirEliminar(${alumno.Id}, "${alumno.Nombre}")'> Eliminar </button>
              </td>
            `;
                        cuerpo.appendChild(fila);
                    });
                })
                .catch(err => console.error("Error:", err));
        }

        // --- MODAL EDITAR ---
        function abrirEditar(alumno) {
            document.getElementById("editId").value = alumno.Id;
            document.getElementById("editNombre").value = alumno.Nombre;
            document.getElementById("editApaterno").value = alumno.Apaterno;
            document.getElementById("editAmaterno").value = alumno.Amaterno ?? "";
            document.getElementById("editEmail").value = alumno.Email;
            document.getElementById("editCelular").value = alumno.Celular;
            document.getElementById("editCP").value = alumno.CP;
            document.getElementById("editSexo").value = alumno.Sexo;

            const modal = new bootstrap.Modal(document.getElementById("modalEditar"));
            modal.show();
        }

        document.getElementById("formEditar").addEventListener("submit", function(e) {
            e.preventDefault();
            const datos = {
                accion: "editar",
                Id: document.getElementById("editId").value,
                Nombre: document.getElementById("editNombre").value,
                Apaterno: document.getElementById("editApaterno").value,
                Amaterno: document.getElementById("editAmaterno").value,
                Email: document.getElementById("editEmail").value,
                Celular: document.getElementById("editCelular").value,
                CP: document.getElementById("editCP").value,
                Sexo: document.getElementById("editSexo").value
            };

            fetch("php/api.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(datos)
                }).then(res => res.json())
                .then(r => {
                    alert(r.mensaje || "Alumno actualizado");
                    cargarAlumnos();
                    bootstrap.Modal.getInstance(document.getElementById("modalEditar")).hide();
                });
        });

        // --- MODAL ELIMINAR ---
        let idEliminar = null;

        function abrirEliminar(id, nombre) {
            idEliminar = id;
            document.getElementById("nombreEliminar").textContent = nombre;
            const modal = new bootstrap.Modal(document.getElementById("modalEliminar"));
            modal.show();
        }

        document.getElementById("btnConfirmarEliminar").addEventListener("click", function() {
            fetch("php/api.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        accion: "eliminar",
                        Id: idEliminar
                    })
                }).then(res => res.json())
                .then(r => {
                    alert(r.mensaje || "Alumno eliminado");
                    cargarAlumnos();
                    bootstrap.Modal.getInstance(document.getElementById("modalEliminar")).hide();
                });
        });
    </script>

    <style>
        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
    </style>

</body>

</html>