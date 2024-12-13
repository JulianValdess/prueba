<?php
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/database.php');
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : ''; 
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == ''){

    echo 'Error al procesar la peticion';
    exit;
}else {

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp) {

      $sql = $con->prepare("SELECT count(id) From productos Where id=? and activo=1");
$sql->execute([$id]);
if($sql->fetchColumn() > 0){

  $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento From productos Where id=? and activo=1 LIMIT 1");
  $sql->execute([$id]);
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  $nombre =$row['nombre'];
  $descripcion =$row['descripcion'];
  $precio =$row['precio'];
  $descuento =$row['descuento'];
  $precio_desc = $precio - (($precio * $descuento) / 100);
  $dir_images = '../assets/imagenes/' . $id . '/';

  $rutaImg = $dir_images . 'ControlXB.jpg';

  if(!file_exists($rutaImg)){
    $rutaImg = '../assets/imagenes/nofoto.png';
  }

  $images = array();
  $dir = dir($dir_images);
  while(($archivo = $dir->read()) != false){
    if($archivo != 'ControlXB.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
      $imagenes[] = $dir_images . $archivo;
    }
  }
  $dir->close();

}


    }else{
        echo 'Error al procesar la peticion';
        exit;
    }
}




//$sql = $con->prepare("SELECT id, nombre, precio FROM productos Where activo=1");
//$sql->execute();
//$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JE Videogames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/estilosinicio.css">
</head>
<body>
<!--Agregacion de barra de navegacion-->
<header data-bs-theme="dark">
  <div class="collapse text-bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-4 offset-md-1 py-4">
          <h4>Contact</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand">        
        <strong>JE VIDEOGAMES</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="#" class="nav-link active">Catalogo</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Contacto</a>
            </li>            
        </ul>
        <!--Boton de acceso al carrito-->
        <a href="checkout.php" class="btn btn-primary">
          Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
      </div>
    </div>
  </div>
</header>
<main>
    <!--Agregacion de los elementos de venta-->
    <div class="container">
           <div class="row">
            <div class="col-md-6 order-md-1">

            <div id="carouselImages" class="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo $rutaImg; ?>" class="d-block w-100" alt="Imagen principal">
    </div>

    <?php foreach ($imagenes as $img) { ?>
      <div class="carousel-item">
        <img src="<?php echo $img; ?>" class="d-block w-100" alt="Imagen secundaria">
      </div>
    <?php } ?>
  </div>
  <button class="carousel-control-prev" type="button">
    <span class="carousel-control-prev-icon" aria-hidden="true">&lt;</span>
  </button>
  <button class="carousel-control-next" type="button">
    <span class="carousel-control-next-icon" aria-hidden="true">&gt;</span>
  </button>
</div>
<style>
.carousel {
  position: relative;
  overflow: hidden;
}

.carousel-inner {
  position: relative;
  width: 100%;
  height: auto;
}

.carousel-item {
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  transition: opacity 0.5s ease-in-out;
}

.carousel-item.active {
  display: block;
  position: relative;
  opacity: 1;
}

.carousel-control-prev, .carousel-control-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  font-size: 20px;
  cursor: pointer;
}

.carousel-control-prev {
  left: 10px;
}

.carousel-control-next {
  right: 10px;
}
</style>

              

            </div>
            <div class="col-md-6 order-md-2">
              <h2><?php echo $nombre; ?></h2>
              <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
              <p class="lead">
                <?php echo $descripcion; ?>
              </p>
              <div class="d-grid gap-3 col-10 mx-auto">
                <button class="btn btn-primary" type="button">Comprar ahora</button>
                <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo 
                $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>

              </div>

            </div>
           </div>
    </div>
 


</main>
    



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  let currentIndex = 0;
  const items = $('#carouselImages .carousel-item');
  const totalItems = items.length;

  function showItem(index) {
    items.removeClass('active').css('opacity', '0');
    $(items[index]).addClass('active').css('opacity', '1');
  }

  $('.carousel-control-next').click(function () {
    currentIndex = (currentIndex + 1) % totalItems;
    showItem(currentIndex);
  });

  $('.carousel-control-prev').click(function () {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    showItem(currentIndex);
  });

  // Inicializa el primer elemento
  showItem(currentIndex);
});
</script>

<script>
  function addProducto(id, token){
    let url = '/proyectophp/clases/carrito.php'; // Ajusta según sea necesario
    let formData = new FormData()
    formData.append('id', id)
    formData.append('token', token)

    fetch(url, {
    method: 'POST', 
    body: formData,
    mode: 'cors'
})
.then(response => response.text()) // Cambiar a `text` para debug
.then(data => {
    console.log(data); // Mostrar la respuesta completa
    let json = JSON.parse(data); // Intentar convertir a JSON
    if (json.ok) {
        let elemento = document.getElementById("num_cart");
        elemento.innerHTML = json.numero;
    }
})
.catch(error => console.error('Error:', error));

  }
  </script>
</body>
</html>