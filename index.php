<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <title>Document</title>
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
                            <th>Código Postal</th>
                            <th>Sexo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCuerpo"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let alumnoSeleccionado = null;
        
        window.onload = function() {
            cargarAlumnos();
        };

        function cargarAlumnos() {
            fetch("php/api.php")
                .then(response => response.json())
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
                            `;

                        // Evento de clic en la fila
                        fila.addEventListener("click", () => {
                            // Quitar selección anterior
                            document.querySelectorAll("#tablaCuerpo tr").forEach(tr => tr.classList.remove("seleccionado"));

                            // Resaltar la fila seleccionada
                            fila.classList.add("seleccionado");

                            // Guardar el alumno seleccionado
                            alumnoSeleccionado = alumno;

                            console.log("Alumno seleccionado:", alumnoSeleccionado);
                        });

                        cuerpo.appendChild(fila);
                    });
                })
                .catch(error => console.error("❌ Error al cargar alumnos:", error));
        }
    </script>
    <style>
        tr.seleccionado {
            background-color: #d0ebff;
            /* azul claro */
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
    </style>

</body>

</html>