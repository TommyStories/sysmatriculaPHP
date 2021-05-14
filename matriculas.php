<?php require_once 'header.php' ?>
<?php require_once 'BaseDeDatos.php';
   
$search = $_POST['search'] ?? '';

    if ($_POST['idEstudiante']>0 && $_POST['idMateria']>0) {
        BaseDeDatos::deleteMatricula($_POST['idEstudiante'],$_POST['idMateria']);
    }
   $matriculas = BaseDeDatos::getMatriculasGlobal($search);

?>



<H1>Busque Matricula Por Estudiante</H1>

<form action="matriculas.php" method="POST">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search for products" name="search">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Materia</th>
            <th scope="col">Facultad</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($matriculas as $matricula) : ?>
            <tr>
                <th><?php echo $matricula['Estudiante'] ?></th>
                <td><?php echo $matricula['Materia'] ?></td>
                <td><?php echo $matricula['Facultad'] ?></td>
                <td>
                    <form action="matriculas.php" method="POST" style="padding: 0px;">
                        <input type="hidden" value="<?php echo $matricula['idE'] ?>" name="idEstudiante">
                        <input type="hidden" value="<?php echo $matricula['idM'] ?>" name="idMateria">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'footer.php' ?>