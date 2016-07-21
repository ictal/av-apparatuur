<?php $page = new Page(); ?>
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
	<form action='process.php' method="post" enctype="multipart/form-data">
		<section class='notifications' ng-show="pm.showAdd">
			<h1> Product <span ng-click='pm.hideAdd()'class=' btn-x pull-right'>x</span></h1>
			<hr>
			<?php echo $page->SPOST('product_name'); ?>
				<section class='productForm'>
					
						<table>
						
							<tr>
								<td>Product foto:</td>
								<td><input type='file' name='product_img' required ></td>
							</tr>
							
							<tr>
								<td>Product naam:</td>
								<td><input type='text' name='product_name' value='<?php echo $page->SPOST('product_name'); ?>' placeholder="product naam " required></td>
							</tr>
							
							<tr>
								<td>Product Beschrijving:</td>
								<td>
									<textarea name='product_description' required><?php echo $page->SPOST('product_description'); ?> </textarea>
									<input type='hidden' name='type' value='products'>
									<input type='hidden' name='token' value='<?php echo 123 ?>'>	
								</td>
							</tr>
							
						</table>
							<input type='submit' class='btn btn-blue' value='Opslaan'>
							<input type='button' class='btn btn-danger'  ng-click='pm.hideAdd()' value='Annuleren'>
			   </section>
		   
		</section>
		</form>
		<section class='notifications' ng-show="pm.showEdit && pm.selectedProducts.length > 0 && pm.selectedProducts.length < 2">
			<h1> Apparaat : {{ pm.getselectedProduct('name')}} <span ng-click='pm.closeEdit()' class='btn-x pull-right'>x</span></h1>
			<hr>
				<table style='width: 60%'>
					<thead>
						<td>Huidige foto<br><br><img src='assets/{{ pm.editAbleProduct.img }}' width='150px'></td>
						
					</thead>
					<tbody>
						<tr>
							<td> Upload een nieuwe foto</td>
							<td><input name='new_img' type='file'></td>
						</tr>
						<tr>
							<td>Naam</td>
							<td><input type='text' ng-model='pm.editAbleProduct.name'></td>
						</tr>
						<tr>
							<td width='50%'>Aantal totaal</td>
							<td>{{ pm.getselectedProduct('aantal')}}</td>
						</tr>
						<tr>
							<td width='50%'>beschrijving</td>
							<td><textarea ng-model="pm.editAbleProduct.description" ></textarea></td>
						</tr>
					</tbody>
				</table>
				<button class='btn btn-blue' ng-click='pm.saveEditProduct()'>Opslaan</button>
				<button class='btn btn-danger' ng-click='pm.closeEdit()'>Afsluiten</button>
		</section>
		
		<section class='notifications' ng-show="pm.showEdit && pm.selectedProducts.length > 0 && pm.selectedProducts.length < 2">
			<h1> Serials </h1>
			<hr>
			<!-- {{ pm.editAbleProduct.serials }} -->
				<table style='width: 60%'>
					<tr ng-repeat='(key, value) in pm.editAbleProduct.serials' >
						<td ng-hide="pm.editAbleProduct.serials[key]['removed']"><input type='checkbox' id="{{ value['id'] }}" name='serial' ng-click="pm.addSerialToList( value['id'] )"></td>
						<td ng-hide="pm.editAbleProduct.serials[key]['removed']">serial {{ key + 1 }} </td>
						<td ng-hide="pm.editAbleProduct.serials[key]['removed']">
							<input type='text' ng-model="pm.editAbleProduct.serials[key]['serial']" name="product_serial_{{ value['id'] }}" value="{{ value['serial'] }}" placeholder="serial_number" >
						</td>
					</tr>
				</table>
				<button class='btn btn-blue' ng-click='pm.addSerial()'>Toevoegen</button>
				<button class='btn btn-danger' ng-click='pm.removeSerials()'>Verwijderen</button>

		</section>
	

</section>


</section>