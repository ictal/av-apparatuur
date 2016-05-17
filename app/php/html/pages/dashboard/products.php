<?php

require_once dirname(__FILE__) . '/php/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = ASSET_PATH;
    $target_file = $target_dir . basename($_FILES["product_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["product_img"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["product_img"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
            #echo "The file ". basename( $_FILES["product_img"]["name"]). " has been uploaded.";
        } else {
            #echo "Sorry, there was an error uploading your file.";
        }
    }


    $db = new Database();

    $aantal = split(':', $_POST['product_aantal'])[1];
    $file_name = $_FILES['product_img']['name'];

    $sql = 'SELECT id FROM products WHERE name = ?';
    $result = $db->fetch($sql, array($_POST['product_name']));

    print_r($_POST);

    if ($result) {
        //pak het id.
        $id = $result['id'];

        for ($i = 0; $i < $aantal; $i++) {
            $serial = $_POST['product_serial_' . $i];
            $db->addToSerial($id, $serial);
        }

    } else {
        //maak nieuwe product.
        $db->addProduct($_POST['product_name'], $_POST['product_description'], $file_name);

        //pad het id van het nieuwe product.
        $id = $db->getProductId($_POST['product_name'])['id'];

        for ($i = 0; $i < $aantal; $i++) {

            $serial = $_POST['product_serial_' . $i];
            $db->addToSerial($id, $serial);
        }

    }

}


?>

<section class='dashboard-content clearfix' ng-controller="productManager as pm" ng-init="pm.loadProducts()">
    <section><!-- Controller hier -->
        <section id='popup' class="popup" ng-class="pm.alert ? 'show' : 'invisible' ">
            <section id='popup1' class="inner-popup  " ng-class="pm.alert ? 'scroll-up' : '' ">
                <h3>Waarshuwing</h3>
                <p>
                <center>Weet u zeker dat u deze product(en) wilt verwijderen?</center>
                </p>
                <center>
                    <button href="?" class='btn btn-blue' ng-click='pm.deleteProduct()'>Ja</button>
                    <button ng-click='pm.dismiss($event)' class='btn btn-danger'>Nee</button>
                </center>
            </section>
        </section>
        <section class='clearfix action_bar'>
            <button class='btn btn-blue' ng-click='pm.addProduct()'>Add</button>
            <button class='btn btn-danger' ng-click='pm.editProduct()'>Edit</button>
            <button class='btn btn-danger' ng-click='pm.popup()'>Delete</button>
        </section>
    </section>


    <section class='notifications'>
        <h1>Alle Producten<a><img src='img/icon-show-1.png'></a></h1>
        <hr>
        {{ pm.selectedProducts }}
        <table>
            <tr id='head'>
                <th width='35px'><input type='checkbox' id='selected_products' name='selected_products'
                                        ng-click='pm.selectAll($event)'></th>
                <th width='25px'>id</th>
                <th style="padding-left: 25px;">Product naam</th>
                <th style="padding-left: 25px;">Aantal</th>
                <th style="padding-left: 25px;">Description</th>
            </tr>
            <tr ng-repeat="product in pm.products">
                <td><input type='checkbox' id="{{product.id}}" ng-click="pm.addToList( product.id )"
                           name='selected_products'></td>
                <td>{{ product.id }}</td>
                <td style="padding-left: 25px;">{{ product.name}}</td>
                <td style="padding-left: 25px;">{{ product.aantal }}</td>
                <td style="padding-left: 25px;">{{ product.description}}</td>
            </tr>
        </table>
    </section>

    <section class='notifications' ng-show="pm.showAdd">
        <h1> Form </h1>
        <hr>

        <section class='productForm'>
            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?p=products'); ?> method="post"
                  enctype="multipart/form-data">
                <label style="margin-bottom: 9px; display: block;">
                    <span
                        style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> img </span>
                    <input type='file' name='product_img' required>
                </label>


                <label style="margin-bottom: 9px; display: block;">
                    <span
                        style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> naam</span>
                    <input type='text' name='product_name' placeholder=" naam " required>

                </label>

                <label style="margin-bottom: 9px; display: block;">
                    <span
                        style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> serial </span>

                    <input type='text' name='product_serial_{{ key }}' placeholder="serial_number"
                           ng-repeat='key in pm.NewArray( pm.aantal )' required>

                    <select name='product_aantal' ng-model='pm.aantal' ng-options="key as key for key in pm.aantallen">
                        <!-- <option ng-repeat='key in pm.aantallen' ng-value='key'> {{ key }}</option> -->

                    </select>
                </label>

                <label style="margin-bottom: 9px; display: block;">
                    <span
                        style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> description </span>
                    <textarea name='product_description' required></textarea>
                </label>
                <input class='btn btn-blue' type='submit' value='Edit'>
        </section>
        </form>
    </section>

    <section class='notifications'
             ng-show="pm.showEdit && pm.selectedProducts.length > 0 && pm.selectedProducts.length < 2">
        <h1> Form </h1>
        <hr>

        <section class='productForm'>

            <label style="margin-bottom: 9px; display: block;">
                <span
                    style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> img </span>
                <input type='file'>
            </label>


            <label style="margin-bottom: 9px; display: block;">
                <span
                    style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> naam</span>
                <input type='text' ng-model="pm.editAbleProduct.name"
                       placeholder="{{ pm.getselectedProduct( 'name' ) }} ">
            </label>

            <label style="margin-bottom: 9px; display: block;">
                <span
                    style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> serial </span>
                <input type='text' ng-model="pm.editAbleProduct.serial_number"
                       placeholder="{{ pm.getselectedProduct( 'serial_number' ) }} ">
            </label>

            <label style="margin-bottom: 9px; display: block;">
                <span
                    style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> description </span>
                <input type='text' ng-model="pm.editAbleProduct.description"
                       placeholder="{{ pm.getselectedProduct( 'description' ) }} ">
            </label>
            <button class='btn btn-blue' ng-click='pm.updateProduct()'>Edit</button>
        </section>


    </section>
</section>


</section>
			
