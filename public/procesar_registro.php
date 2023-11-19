<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener datos del formulario
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];
$password = $_POST['password'];

// Insertar nuevo usuario en la base de datos
$sql = "INSERT INTO Usuario (name, surname, email, birthdate, address, password)
VALUES ('$name', '$surname', '$email', '$birthdate', '$address', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente.";
    header("Location: login.php");
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>


?>

