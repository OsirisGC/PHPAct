<?php include "../app/ProductController.php";
$token = strip_tags($_SESSION["token"]);
$productController = new ProductController();
$products = $productController->getAllProducts($token);
$arrayBrands = $productController->getAllBrands($token);?>
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
          <div><a href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary" style="width:100px; height:35px">Añadir</a></div>
          <?php foreach ($products as $product) { ?>
            <div class="card col-3">
              <img class="card-img-top" src="<?php echo $product->cover ?>" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title"><?php echo $product->name ?></h5>
                <p class="card-text"><?php echo $product->brand->name ?></p>
                <p class="card-text"><?php echo $product->description ?></p>
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary" style="background-color: blue">Editar</a>
                <a onclick='remove(<?php echo $product->id ?>)' href="#" class="btn btn-primary" style="background-color: red">Eliminar</a>
                <a href="details.php?slug=<?php echo $product->slug ?>" data-bs-target="#createProductModal" class="btn btn-primary" style="background-color: #ffa500">ver detalles</a>
              </div>
            </div><?php } ?>
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
          <form enctype="multipart/form-data" action="../app/ProductController.php" method="post" class="FORM">
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">@</span>
              <input name="name" type="text" class="form-control" placeholder="Name Product" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">@</span>
              <input name="slug" type="text" class="form-control" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">@</span>
              <input name="description" type="text" class="form-control" placeholder="Description" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">@</span>
              <input name="features" type="text" class="form-control" placeholder="Features" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">@</span>
              <select name="brand_id" class="form-select" required>
                <?php foreach ($arrayBrands as $brand) { ?>
                  <option value="<?php echo $brand->id; ?>" class="dropdown-item"><?php echo $brand->name; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="input-group mb-3">
              <label for="formFile" class="form-label">Default file input example</label>
              <input name="cover" type="file" class="form-control">
            </div>
            <input type="hidden" name="action" value="create">
            <button type="submit" class="btn btn-primary">Añadir</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php include "../layouts/scripts.template.php"; ?>
  <script type="text/javascript">
    function remove(id) {
      swal({
          title: "estas seguro?",
          text: "una vez borrado no se podra recuperar",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            var bodyFormData = new FormData();

              bodyFormData.append('id', id);
              bodyFormData.append('action', 'delete');

              axios.post('../app/ProductController.php', bodyFormData)
              .then(function(response) {
                console.log(response);
              })
              .catch(function(error) {
                console.log(error);
              });

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