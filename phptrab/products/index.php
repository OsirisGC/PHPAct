<?php
include_once "../app/config.php";
include "../app/ProductController.php";
$token = strip_tags($_SESSION["global_token"]);
$productController = new ProductController();
$products = $productController->getAllProducts($token);
$arrayBrands = $productController->getAllBrands($token);
?>
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
            <a onclick="addProduct()" href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary" style="background-color: green">Añadir producto</a>
            <?php foreach ($products as $product) { ?>
              <div class="card col-3">
                <img class="card-img-top" src="<?php echo $product->cover ?>" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $product->name ?></h5>
                  <p class="card-text"><?php echo $product->brand->name ?></p>
                  <p class="card-text"><?php echo $product->description ?></p>
                  <button data-product='<?php echo json_encode($product); ?>' onclick="editProduct(this)" href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary">Editar</button>
                  <a onclick="remove(<?php echo $product->id ?>)" href="#" class="btn btn-primary" style="background-color: red">Eliminar</a>
                  <a href="<?= BASE_PATH."product/".$product->slug ?>" data-bs-target="#createProductModal" class="btn btn-primary" style="background-color: #ffa500">ver detalles</a>
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
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form enctype="multipart/form-data" action="<?= BASE_PATH?>prod" method="post" class="FORM">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input id="name" name="name" type="text" class="form-control" placeholder="Name Product" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input id="slug" name="slug" type="text" class="form-control" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input id="description" name="description" type="text" class="form-control" placeholder="Description" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input id="features" name="features" type="text" class="form-control" placeholder="Features" aria-label="Username" aria-describedby="basic-addon1">
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
              <button type="submit" class="btn btn-primary">Save changes</button>
              <input id="inputOculto" type="hidden" name="action" value="create">
              <input id="id" type="hidden" name="id">
              <input type="hidden" name="global_token" value="<?= $_SESSION['global_token']?>">
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
              swal("Tu archivo se a borrado", {
                  icon: "success",
              });
              var bodyFormData = new FormData();
              bodyFormData.append('id', id);
              bodyFormData.append('action', 'delete');
              bodyFormData.append("global_token", '<?= $_SESSION['global_token']?>');
              axios.post('<?= BASE_PATH?>prod', bodyFormData)
                .then(function(response) {
                  console.log(response);
                })
                .catch(function(error) {
                  console.log('error')
                })
            } else {
              swal("Your imaginary file is safe!");
            }
          });
      }

      function addProduct() {
        const elem = document.getElementById('inputOculto').value = 'create';
        document.getElementById("name").value = "";
        document.getElementById("slug").value = "";
        document.getElementById("description").value = "";
        document.getElementById("features").value = "";
        document.getElementById("brand_id").value = "";
      }

      function editProduct(target) {
        const elem = document.getElementById('inputOculto').value = 'edit';
        let product = JSON.parse(target.getAttribute('data-product'));
        document.getElementById("name").value = product.name;
        document.getElementById("slug").value = product.slug;
        document.getElementById("description").value = product.description;
        document.getElementById("features").value = product.features;
        document.getElementById("brand_id").value = product.brand_id;
        document.getElementById("id").value = product.id;
      }
    </script>

  </body>

</html>