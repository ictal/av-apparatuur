<?php
include(dirname(__FILE__) .'/../user/user.php');
	$session = new Session();
	echo $session->get('userId');
echo 'test';
echo "\n";
?>
<!DOCTYPE html>
<html  ng-app='av_apparatuur'>
<head>
	
	<meta charset='urf-8'>
	<title>Denis Service</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	
	<link rel="stylesheet" href="css/main_style.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300' rel='stylesheet' type='text/css'>
	<script src='js/fx.js' type='text/javascript'></script>
	<!--  Temp not needed  -->
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.1/angular.min.js' type='text/javascript'></script>
	<script src='js/app.js' type='text/javascript'></script>
	
</head>
<body >

	<!-- user Bar -->
	<section class='A clearfix'>
	
	<!-- user_items_info -->
	<section class='item_table'>
		<!-- must make nav -->
		<table class="table table-striped">
			<thead>
				<tr><th>Naam</th>
					<th>Aantal</th>
					<th>Sirinummer</th>
					<th>Datum geleend</th>
					<th>Datum retour</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Canon V15</td>
					<td>1</td>
					<td>026326156</td>
					<td>24-01-2016</td>
					<td>02-02-2016</td>
				</tr>
				<tr>
					<td>Canon V15</td>
					<td>1</td>
					<td>026326156</td>
					<td>24-01-2016</td>
					<td>02-02-2016</td>
				</tr>
				<tr>
					<td>Canon V15</td>
					<td>1</td>
					<td>026326156</td>
					<td>24-01-2016</td>
					<td>02-02-2016</td>
				</tr>
			</tbody>
		</table>
	</section>
	
	

	<!-- user_info 
	 <section class='B clearfix'>
		<h5>Welkom Ashna Wiar</h5>
			<section class='C clearfix'>
				<section class='D'>
					<img src='http://vishaljewelleryworld.com/wp-content/themes/diyasilver/images/blank.jpg'>
				</section>
				<section class='E'>
				<ul>
					<li>Berichten</li>
					<li>Settings</li>
					<li>log out</li>
				</ul>
				</section>
			</section>
			<section class="F">
				<ul>
					<li>ID :&nbsp &nbsp #5981</li>
					<li>OV :&nbsp #00121571</li>
				</ul>
			</section>
			
	</section> -->
	</section>
	

	<section class='G clearfix' ng-controller="storeController as store" >
		<h1>Aanvraagformulier AV Apparatuur</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, accusamus dolor illum maiores velit repellendus doloremque inventore culpa obcaecati et distinctio voluptate dicta nemo laborum molestias ullam quis dolorem non.</p>
		<hr>
		<section class='Gheader clearfix' ng-hide='store.has_loaded_items' ng-init='store.load(store)'>
		<h3>Een ogenblik geduld. de data wordt geladen.</h3><br>
		{{store.products.lenght}}
			<img width="50px" style="margin-top: 100px; margin-left: 50px; padding-bottom: 10px; padding-top: 10px;" src="https://govizzle.com/images/loading-animation.gif">
		</section>
		
		<section ng-show='store.has_loaded_items' class='Gheader clearfix'>
			<h3>Selecteer het geen wat u wilt lenen</h3>
			<button ng-click='store.submit(store)'>verzenden</button>
		</section>
		<section  class="popup ng-class:{ 'animate1': store.finished() }; ">
			<section class="inner-popup  ng-class:{ 'animate': store.finished() }; ">
				<h3>Uw verzoek is verzonden.</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, eos.</p>
				<button ng-click='store.reset()'>verder</button>
			</section>
		</section>
		
		<section class='item_options clearfix' ng-show='store.has_loaded_items' ng-click='store.selected( $event, "none" )' > 
				
			<section class='item'  ng-repeat='item in store.products' ng-click='store.select( $event, item )' >
			
				<img id='checkmark' ng-show='store.inBasket( item )' src='img/check.gif' >
				
				<img ng-src='{{item.img}}' >
				
				<section id='dec' class="dec ng-class:{ 'display': store.selected(item) };">
					<h1>{{item.name}}</h1>
					{{item.description}}
					<form name='amount'>
						
						<select ng-model='item.amount'>
							<option value="">--- Please select ---</option> <!-- not selected / blank option -->
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
						</select>
						<input type='submit' ng-click='item.amount && store.addToBasket( item, $event ); 'value='&#10003'>
					</form>
					
				</section>
				
			</section>
		
		</section>
	</section>
	<!-- reservation -->
	<section class=''>
	
	</section>

 </script>
</body>
</html>
