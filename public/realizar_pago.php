<?php
require_once '../vendor/autoload.php'; // Asegúrate de cargar la biblioteca de Stripe

// Configura tus claves de API de Stripe
\Stripe\Stripe::setApiKey('sk_test_51ODnBhB8npZc25UNGdpXDjuVKfhHPEy0ko7I0aBWSRTeopHE09xtAe05WO9fh1QeEUmkuVIisnbvzBnQzjgcSNH200wYL5UgHh');

// Recupera el token de pago generado por Stripe.js
$token = $_POST['stripeToken'];

// Crea una carga (charge) con la cantidad y la moneda
try {
    $charge = \Stripe\Charge::create([
        'amount' => 10000, // La cantidad en céntimos
        'currency' => 'eur',
        'description' => 'Compra en ComputerBeef',
        'source' => $token,
    ]);

    // Recupera información adicional del pago y el cliente
    $paymentInfo = $charge->payment_method_details;
    $clientInfo = $charge->customer;

    // Agrega el resumen del pedido y productos a la base de datos
    $orderId = agregarResumenPedido($paymentInfo);
    agregarProductosPedido($orderId);

    // Redirige al usuario a la página de resumen de pedido
    header("Location: resumen_pedido.php");
    exit();
} catch (\Stripe\Exception\CardException $e) {
    // Si hay un error con la tarjeta
    echo "Error en el pago: " . $e->getError()->message;
} catch (\Stripe\Exception\RateLimitException $e) {
    // Si hay problemas con la tasa de solicitud a la API de Stripe
    echo "Error en el pago: Problema de tasa de solicitud";
} catch (\Stripe\Exception\InvalidRequestException $e) {
    // Si hay una solicitud inválida a la API de Stripe
    echo "Error en el pago: Solicitud inválida";
} catch (\Stripe\Exception\AuthenticationException $e) {
    // Si hay un error de autenticación con las claves de API de Stripe
    echo "Error en el pago: Autenticación fallida";
} catch (\Stripe\Exception\ApiConnectionException $e) {
    // Si hay un problema de conexión con la API de Stripe
    echo "Error en el pago: Problema de conexión";
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Si hay un error general con la API de Stripe
    echo "Error en el pago: Error general";
} catch (Exception $e) {
    // Captura de otros tipos de errores
    echo "Error en el pago: " . $e->getMessage();
}

// Función para agregar un resumen del pedido a la base de datos en la tabla "pedido"
function agregarResumenPedido($paymentInfo)
{
    // Lógica para agregar un resumen del pedido a la base de datos
    // Puedes usar la información del carrito y el cliente para llenar la tabla "pedido"
    // Aquí deberías incluir la fecha, la dirección, el nombre del titular de la tarjeta, etc.
    // Puedes usar variables como $_POST['cardHolder'], $_POST['address'], etc.

    // Ejemplo de inserción (debes ajustar esto según tu base de datos y estructura de tabla)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $fecha = date('Y-m-d');
    $direccion = $_POST['address'];
    $cardHolder = $paymentInfo->name;
    $cardNumber = '************' . substr($paymentInfo->card->last4, -4);

    $sql = "INSERT INTO pedido (fecha, direccion, cardHolder, cardNumber, usuario_id) VALUES ('$fecha', '$direccion', '$cardHolder', '$cardNumber', 1)";
    $conn->query($sql);

    // Obtiene el ID del último pedido insertado
    $orderId = $conn->insert_id;

    $conn->close();

    return $orderId;
}

// Función para agregar productos al pedido en la tabla "orderitem"
function agregarProductosPedido($orderId)
{
    // Lógica para agregar productos al pedido en la tabla "orderitem"
    // Puedes obtener la información del carrito y agregarla a la tabla "orderitem"

    // Ejemplo de inserción (debes ajustar esto según tu base de datos y estructura de tabla)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    // Recupera productos del carrito (debes ajustar esto según tu lógica de carrito)
    $cartItems = $_SESSION['cart'];

    foreach ($cartItems as $product_id => $quantity) {
        // Obtiene información del producto desde la base de datos
        $sqlProduct = "SELECT * FROM Producto WHERE id = $product_id";
        $resultProduct = $conn->query($sqlProduct);

        if ($resultProduct->num_rows > 0) {
            $rowProduct = $resultProduct->fetch_assoc();
            // Inserta el producto en la tabla "orderitem"
            $sqlOrderItem = "INSERT INTO orderitem (order_id, product_id, cantidad, precio) VALUES ('$orderId', '$product_id', '$quantity', '" . $rowProduct['precio'] . "')";
            $conn->query($sqlOrderItem);
        }
    }

    $conn->close();
}
?>