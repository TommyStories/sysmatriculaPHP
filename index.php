<?php require_once 'header.php' ?>

<?php

require_once 'BaseDeDatos.php';
$id = BaseDeDatos::login($_POST['nombre'], $_POST['contrasena']) ?? null;

if ($id > 0) {
   echo '<h1> Hola ' . $_POST['nombre'] . '</h1>';
} else {
   header('Location: login.php');
}

if ($_POST['materia'] > 0) {
   BaseDeDatos::insertMatricula($id, $_POST['materia']);
}

if($_POST['idMatricula']>0){
   BaseDeDatos::deleteMatricula($id,$_POST['idMatricula']);
}

$facultades = BaseDeDatos::getFacultades() ?? null;
$materias = BaseDeDatos::getMaterias($_POST['facultad']) ?? null;
$matriculas = BaseDeDatos::getMatriculas($id);

?>

<h2>Inscribirse a Materia</h2>

<form action="index.php" method="POST">

   <label for="">Facultad</label>
   <select class="form-select" aria-label="Default select example" name="facultad">
      <option selected="true" disabled>Seleccione Facultad</option>
      <?php foreach ($facultades as $facultad) : ?>
         <option value="<?php echo $facultad['id'] ?>"><?php echo $facultad['nombre'] ?></option>
      <?php endforeach; ?>
   </select>
   <input type="hidden" value="<?php echo $_POST['nombre'] ?>" name="nombre">
   <input type="hidden" value="<?php echo $_POST['contrasena'] ?>" name="contrasena">
   <br>
   <input type="submit" value="Mostrar" class="btn btn-primary">
</form>

<?php if ($_POST['facultad'] > 0) : ?>

   <form action="index.php" method="POST">
      <label for="">Materia</label>
      <select class="form-select" aria-label="Default select example" name="materia">
         <option selected="true" disabled>Seleccione la Materia</option>
         <?php foreach ($materias as $materia) : ?>
            <option value="<?php echo $materia['id'] ?>"><?php echo $materia['nombre'] ?></option>
         <?php endforeach; ?>
      </select>
      <input type="hidden" value="<?php echo $_POST['nombre'] ?>" name="nombre">
      <input type="hidden" value="<?php echo $_POST['contrasena'] ?>" name="contrasena">
      <input type="submit" value="Añadir Materia" class="btn btn-primary">
   </form>
<?php endif; ?>

<br>
<br>

<?php if (empty($matriculas)) {
   echo '<h2> Aun no se dispone de matriculas';
} ?>

<?php if (!empty($matriculas)) : ?>
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
               <th><?php echo $matricula['id'] ?></th>
               <td><?php echo $matricula['materia'] ?></td>
               <td><?php echo $matricula['facultad'] ?></td>
               <td>
                  <form action="index.php" method="post" style="padding: 0px;">
                     <input type="hidden" value="<?php echo $_POST['nombre'] ?>" name="nombre">
                     <input type="hidden" value="<?php echo $_POST['contrasena'] ?>" name="contrasena">
                     <input type="hidden" value="<?php echo $matricula['id'] ?>" name="idMatricula">
                     <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
<?php endif; ?>

<?php require_once 'footer.php' ?>