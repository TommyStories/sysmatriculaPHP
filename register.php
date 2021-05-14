<?php require_once 'header.php' ?>

<?php require_once 'BaseDeDatos.php';


$errores = [];



$nombre = $_POST['nombre'] ?? null;
$existe = BaseDeDatos::existNombre($nombre);
$contrasena = $_POST['contrasena'] ?? null;

if (!$nombre) {
  $errores[] = 'Ingrese un Nombre';
}
if ($existe) {
  $errores[] = 'El nombre ingresado ya existe';
}
if (!$contrasena) {
  $errores[] = 'Ingrese una contraseña';
}

if (empty($errores)) {
  BaseDeDatos::insertEstudiante($nombre, $contrasena);
  echo '<h1>Se creo el usuario Exitosamente</h1>';
  exit;
}
?>

<h1>Registre su Cuenta</h1>

<?php foreach ($errores as $error) : ?>
  <h2 style="color: red;"><?php echo $error ?></h2>
<?php endforeach; ?>
<form action="register.php" method="POST">
  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombre" id="nombre">
  </div>
  <div class="mb-3">
    <label for="contrasena" class="form-label">Constraseña</label>
    <input type="password" class="form-control" name="contrasena" id="contrasena">
  </div>
  <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
</form>

<?php require_once 'footer.php' ?>