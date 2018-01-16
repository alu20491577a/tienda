<?php
  session_start();
  $title = "Minerales";

  include("./include/funciones.php");
  require './include/ElCaminas/Carrito.php';
  use ElCaminas\Carrito;

  $carrito = new Carrito();

  $carrito->empty();

  include("./include/header-popup.php");
?>
  <div class="row">
    <div class="jumbotron">
        <h1>Gracias</h1>
        <p> Gracias por realizar su compra con nosotros</p>
        <p><a class="btn btn-primary btn-lg" href="/tiendav/" role="button">Continuar</a></p>
    </div>
  </div>
<?php
include("./include/footer-popup.php");
?>
