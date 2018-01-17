<?php
  session_start();
  include("./include/funciones.php");
  $connect = connect_db();

  $redirect = "";

  if(isset($_GET["redirect"])){$redirect = $_GET["redirect"];}
  else{$redirect = "index.php";}

  $title = "Minerales";
  include("./include/header.php");
  require './include/ElCaminas/Carrito.php';
  require './include/ElCaminas/Producto.php';
  require './include/ElCaminas/Productos.php';
  use ElCaminas\Carrito;


  $carrito = new Carrito();
  //Falta comprobar qué acción: add, delete, empty
  $action="view";
  if(isset($_GET["action"])){
    $action=$_GET["action"];
  }
  if($action=="add"){
  $carrito->addItem($_GET["id"], 1);
  }
  else if($action=="delete"){
  $carrito->deleteItem($_GET["id"]);
  }
  else if($action=="empty"){
  $carrito->empty();
  }

  ?>
  <script>
  function comp(){
      if (confirm('¿Seguro que desea eliminar este producto del carrito?')){
        return true;
        }else{
          return false;}
  }
  function comp2(){
      if (confirm('¿Esta acción eliminara todos los productos del carrito, desea continuar?')){
        return true;
        }else{
        return false;}
  }
  </script>
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>
  <script>
  paypal.Button.render({

            env: 'sandbox', // sandbox | production

            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
                production: '<insert production client id>'
            },

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: <?php echo $carrito->getTotal() ?>, currency: 'EUR' }
                            }
                        ]
                    }
                });
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
                    window.alert('Payment Complete!');
                    document.location.href = 'gracias.php';
                });
            }

        }, '#paypal-button-container');

  </script>
  <div class="row carro">
    <h2 class='subtitle' style='margin:0'>Carrito de la compra</h2>
    <?php  echo $carrito->toHtml();?>
    <?php  echo $carrito->deleteitem();?>
    <span><div id="paypal-button-container"></div></span>
    <span><a href='carro.php?action=empty&redirect=<?php echo $redirect ?>' onclick='return comp2()' class='btn btn-danger'>Empty</a></span></br>
    <span><a class='btn btn-success' href="<?php echo $redirect ?>">Seguir comprando</a></span>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Detalle del producto</h4>
        </div>
        <div class="modal-body">
          <iframe src='#' width="100%" height="600px" frameborder=0 style='padding:8px'></iframe>
        </div>
      </div>
    </div>
  </div>
<?php
$bottomScripts = array();
$bottomScripts[] = "modalIframeProducto.js";
include("./include/footer.php");
?>
