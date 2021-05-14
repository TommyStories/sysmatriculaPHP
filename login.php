<?php require_once 'header.php' ?>

<form action="index.php" method="POST">
    
    <h1>Inicie Sesion</h1>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="nombre">
    </div>
    <div class="mb-3">
        <label for="contrasena" class="form-label">Constraseña</label>
        <input type="password" class="form-control" name="contrasena" id="contrasena">
    </div>
    <p>
        <a href="register.php" class="btn btn-warning">¿No tienes Cuenta? Registrate</a>
    </p>
    <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
    
</form>

<?php require_once 'footer.php' ?>