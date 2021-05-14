<?php

class BaseDeDatos
{

    private static function getConexion()
    {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=Universidad', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function login($nombre, $contrasena)
    {

        $pdo = self::getConexion();

        $statement = $pdo->prepare('SELECT id FROM Estudiante 
        WHERE nombre= :nombre AND contrasena= :contrasena');

        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':contrasena', $contrasena);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public static function getFacultades()
    {
        $pdo = self::getConexion();

        $statement = $pdo->prepare('SELECT * FROM Facultad');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMaterias($idFacultad)
    {
        $pdo = self::getConexion();

        $statement = $pdo->prepare('SELECT * FROM Materia WHERE facultad= :facultad');
        $statement->bindValue(':facultad', $idFacultad);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insertMatricula($idEstudiante, $idMateria)
    {
        $pdo = self::getConexion();
        $statement = $pdo->prepare('INSERT INTO Recibe(id_Est,id_Mat)
        VALUES(:estudiante,:materia)');
        $statement->bindValue(':estudiante', $idEstudiante);
        $statement->bindValue(':materia', $idMateria);
        $statement->execute();
    }

    public static function getMatriculas($idEstudiante)
    {
        $pdo = self::getConexion();

        $statement = $pdo->prepare("SELECT M.id,M.nombre AS 'materia',F.nombre AS 'facultad' FROM Recibe R
        INNER JOIN Materia M ON R.id_Mat=M.id
        INNER JOIN Facultad F ON M.facultad=F.id WHERE R.id_Est=:idEstudiante");
        $statement->bindValue(':idEstudiante', $idEstudiante);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMatriculasGlobal($nombre)
    {
        $pdo = self::getConexion();

        $statement = $pdo->prepare("SELECT E.nombre AS Estudiante, M.nombre AS Materia, F.nombre AS Facultad, 
        E.id AS idE, M.id AS idM
        FROM Recibe R  INNER JOIN Estudiante E ON R.id_Est=E.id
        INNER JOIN Materia M ON R.id_Mat=M.id
        INNER JOIN Facultad F ON M.facultad=F.id WHERE E.nombre LIKE :estudiante");
        $statement->bindValue(':estudiante', "%$nombre%");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteMatricula($idEstudiante, $idMateria)
    {
        $pdo = self::getConexion();

        $statement = $pdo->prepare('DELETE FROM Recibe WHERE id_Est=:estudiante AND id_Mat=:materia');
        $statement->bindValue(':estudiante', $idEstudiante);
        $statement->bindValue(':materia', $idMateria);
        $statement->execute();
    }

    public static function existNombre($nombre)
    {
        $pdo = self::getConexion();
        $statement = $pdo->prepare('SELECT * FROM Estudiante WHERE nombre= :nombre LIMIT 1');
        $statement->bindValue(':nombre', $nombre);
        $statement->execute();

        $existe = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existe) {
            return true;
        }
        return false;
    }

    public static function insertEstudiante($nombre, $contrasena)
    {
        $pdo = self::getConexion();
        $statement = $pdo->prepare("INSERT INTO Estudiante(nombre,contrasena) VALUES(:nombre,:contrasena)");
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':contrasena', $contrasena);
        $statement->execute();
    }
}
