<?php
include "../app/ProductController.php";
$productController = new ProductController();
$product = $productController->getProductDetail($_GET['slug']);?>
<!DOCTYPE html>
<html>
<head>
  <?php include "../layouts/head.template.php"; ?>
</head>
<body>
  <?php include "../layouts/nav.template.php"; ?>
  <div class="container-fluid">
  <div class="row">
      <?php include "../layouts/sidebar.template.php"; ?>
      <div class="col-10">
        <div class="row">
          <a href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary" style="background-color: green">Añadir</a>
          <div class="card col-7">
            <img src="<?php echo $product->cover; ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product->name; ?></h5>
              <h6 class="card-title">Description</h6>
              <p class="card-text"><?php echo $product->description; ?></p>
              <h6 class="card-title">Features</h6>
              <p class="card-text"><?php echo $product->features; ?></p>
              <h6 class="card-title">Categories</h6>
              <?php foreach ($product->categories as $category) : ?>
                <p class="card-text"><?php echo $category->name ?></p>
              <?php endforeach ?>
              <h5 class="card-title">Tags</h5>
              <?php foreach ($product->tags as $tag) : ?>
                <p class="card-text"><?php echo $tag->name ?></p>
              <?php endforeach ?>
              <a href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary" style="background-color: green">Editar</a>
              <a onclick='remove(<?php echo $product->id ?>)' href="#" class="btn btn-primary" style="background-color: red">Eliminar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <?php for ($i = 0; $i < 6; $i++) : ?>

              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            <?php endfor; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <?php include "../layouts/scripts.template.php"; ?>
    <script type="text/javascript">
      function remove(target) {
        swal({
            title: "estas seguro?",
            text: "una vez borrado no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Tu archivo se a borrado", {
                icon: "success",
              });
            } else {
              swal("Tu archivo no se a borrado");
            }
          });
      }
    </script>

</body>

</html>