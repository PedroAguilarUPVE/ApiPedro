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

    <script src="js/script.js"></script>


</body>

</html>