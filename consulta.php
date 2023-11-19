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
?>


<?php 

// Realiza la consulta SQL
$sql = "SELECT * FROM Producto ORDER BY precio DESC";
$result = $conn->query($sql);

// Consulta 1: Obtener los pedidos de un usuario específico con detalles del producto
$sql1 = "SELECT Pedido.id AS 'ID Pedido', Usuario.name AS 'Nombre Usuario', Producto.nombreProducto AS 'Producto'
FROM Pedido
JOIN Usuario ON Pedido.usuario_id = Usuario.id
JOIN OrderItem ON Pedido.id = OrderItem.order_id
JOIN Producto ON OrderItem.product_id = Producto.id
WHERE Usuario.id = 1";
$result1 = $conn->query($sql1);

// Consulta 2: Calcular el total gastado por un usuario específico
$sql2 = "SELECT Usuario.name AS 'Nombre Usuario', SUM(Producto.precio * OrderItem.cantidad) AS 'Total Gastado'
FROM Usuario
JOIN Pedido ON Usuario.id = Pedido.usuario_id
JOIN OrderItem ON Pedido.id = OrderItem.order_id
JOIN Producto ON OrderItem.product_id = Producto.id
WHERE Usuario.id = 1
GROUP BY Usuario.id";
$result2 = $conn->query($sql2);

// Consulta 3: Insertar un nuevo usuario
$sql3 = "INSERT INTO Usuario (name, surname, email, birthdate, address, password)
VALUES ('Nuevo', 'Usuario', 'nuevo.usuario@example.com', '1995-05-10', '123 New St', 'newpassword')";
$conn->query($sql3);


?>

<?php
// Muestra los resultados
if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nombreProducto"]. "</td><td>" . $row["precio"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados encontrados";
}


// Mostrar los resultados de la Consulta 1
if ($result1->num_rows > 0) {
    echo "<h2>Pedidos del Usuario:</h2>";
    echo "<table border='1'><tr><th>ID Pedido</th><th>Nombre Usuario</th><th>Producto</th></tr>";
    while($row = $result1->fetch_assoc()) {
        echo "<tr><td>".$row["ID Pedido"]."</td><td>".$row["Nombre Usuario"]."</td><td>".$row["Producto"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron pedidos para el usuario.";
}


// Mostrar los resultados de la Consulta 2
if ($result2->num_rows > 0) {
    echo "<h2>Total Gastado por el Usuario:</h2>";
    echo "<table border='1'><tr><th>Nombre Usuario</th><th>Total Gastado</th></tr>";
    while($row = $result2->fetch_assoc()) {
        echo "<tr><td>".$row["Nombre Usuario"]."</td><td>".$row["Total Gastado"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron datos de gastos para el usuario.";
}



// Cierra la conexión
$conn->close();

?>