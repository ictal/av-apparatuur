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
            <form action='process.php' method="post" enctype="multipart/form-data">
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
				<input type='hidden' name='type' value='products'>
				<input type='hidden' name='toke' value='<?php echo $token ?>'>
                <input class='btn btn-blue' type='submit' value='Add'>
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