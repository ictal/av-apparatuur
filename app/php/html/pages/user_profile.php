<?php 

require_once( dirname(__FILE__) .'/../page.php');
require_once( dirname(__FILE__) .'/../../net/session.php');
require_once( dirname(__FILE__) .'/../../net/database.php');
require_once( dirname(__FILE__) .'/../../user/user.php');


$session = new Session();
$page = new Page();

if(!$session->_isset( 'logged_in')){
	$page->redirect( 'index.php');
}else{
	$user = new User( $session->get('userId') );
}


?>
<!doctype html>
<html ng-app='av_apparatuur'>
	<head>
		<meta charset="uft-8">
		<title>AV - Apparatuur</title>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="css/main_style.css">
		<link rel="stylesheet" href="css/datepicker.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.1/angular.min.js' type='text/javascript'></script>
		
		<script src="js/bootstrap-datepicker.js"></script>
		<script>
		$(document).ready(function () {
			
			$('#datepicker_from').datepicker();
			$('#datepicker_to').datepicker();
		
		});
		</script>
		<script src='js/app.js' type='text/javascript'></script>
</head>
<body>

	<section class='page-head'>
		
		<nav>
			<ul>
				<li><a href='#'>Home</a></li>
				
				<li class='pull-right' ><a href='?logout=true'>Logout</a></li>
				<li class='pull-right'><a href='#'>Profiel</a></li>
				<li class='pull-right'><a href='#'>Permission <?php echo $user->getPermission(); ?></a></li>
			</ul>
		</nav>
		
	</section>
	
	<section class='page-body' >
		<section ng-controller='userProductActivityControler as upac' ng-init='upac.loadActivity()'>
			 <!--<p class='heading'>Mijn Geschiedenis: geleende producten</p>
			<section class='user_stats' >
				<table class="table table-striped">
					<thead>
						<tr><th>Naam</th>
							<th>Aantal</th>
							<th>Sirinummer</th>
							<th>Datum geleend</th>
							<th>Datum retour</th>
						</tr>
					</thead>
					<tbody ng-show='upac.history.length > 0'>
						<tr ng-repeat='product in upac.history'>
							<td> {{ product.name }} </td>
							<td> {{ product.amount }} </td>
							<td> {{ product.serial }} </td>
							<td> {{ rent_date }} </td>
							<td> {{ retour_date }} </td>
						</tr>
					</tbody>
				</table>
			</section>
			
			<p class='heading'>Mijn Activiteit: Recent aanvragen</p>
			<section class='user_stats'>
				<table class="table table-striped">
					<thead>
						<tr><th>Naam</th>
							<th>Aantal</th>
							<th>Sirinummer</th>
							<th>Datum geleend</th>
							<th>Datum retour</th>
						</tr>
					</thead>
					<tbody ng-show='upac.activity.length > 0'>
						<tr ng-repeat='item in upac.activity'>
							<td>{{ item.name }}</td>
							<td>{{ item.amount }}</td>
							<td>{{ item.serial_number }}</td>
							<td>{{ item.date_rented }}</td>
							<td>{{ item.date_retour }}</td>
						</tr>
						
					</tbody>
				</table>
				
			</section>
			
		</section> -->
		<section id='t' class='formulier clearfix' ng-controller='productRentingControler as prc' ng-init='prc.init()'>
		
			<h1 class='page_heading' >Aanvraagformulier AV Apparatuur</h1>
			<p class='sub_heading'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, accusamus dolor illum maiores velit repellendus doloremque inventore culpa obcaecati et distinctio voluptate dicta nemo laborum molestias ullam quis dolorem non.</p>
			<hr>
			
			<section ng-show='prc.showDate'>
			
				<h3 class='page_heading' >Ik wil een product huren</h3>
				
				<button class='pull-right' ng-click='prc.getProducts()' >zoek naar producten</button>
				<label for='rent_date'>
					<span>Van</span> 
					<input id='datepicker_from' name='rent_date' placeholder='yyyy-mm-dd' data-date-format="yyyy-mm-dd" >
				</label>
				
				<label for='date_retour'>
					<span>Tot</span> 
					<input id='datepicker_to' name='date_retour' placeholder='yyyy-mm-dd' data-date-format="yyyy-mm-dd" ng-model='prc.date'  >
				</label>
				
			</section>
			<!-- 
			<section class='waiting_gif' ng-show='prc.showGif'>
				<center><p>Een ogenblick geduld Producten worden geladen</p><br><img src='img/wait.gif' width='50px'> </center>
			</section>
			-->
			
			<section class='product_list' ng-show='prc.showProducts' >
				<h3  class='page_heading' >Selecteer het geen wat u wilt lenen</h3>
				<span class='sub_heading'>Leen periode van {{ prc.rent_date + ' t/m ' + prc.retour_date }}
				<button class='pull-right' ng-click='prc.sendRequest()' >verzenden</button>
				
				<section class='product_container'>
					
					<section class='product thumbnail' ng-repeat=' item in prc.products' ng-click='prc.selectProduct( item )' >
					
						<img class='icon-check'src='img/check.gif' width='75px' ng-show='prc.inBasket( item )'>
						<img src='img/jvc.png'>
						
						<section class="description ng-class:{ 'description-scroll-up': prc.selectedProduct == item.id };  ">
						<button class='icon-x' ng-click='prc.deSelectProduct( item, $event )' ng-show='prc.inBasket( item )'>x</button>
							<h1 class='page_heading'>{{ item.name }}</h1>
							<p>{{ item.description }}</p>
							
							<select ng-model='item.amount' ng-click='prc.stopPropagation( $event )'>
								<option value="">--- Aantal ---</option> <!-- not selected / blank option -->
								<option value='{{key}}' ng-repeat='key in prc.makeArray( item.name )' >{{key}}</option>
								
							</select>
							<button ng-click='prc.addToBasket( item , $event )'>Selecteer</button>
						</section>
						
					</section>
				
				</section>
			</section>
			
			<section class='popup'  ng-show='prc.popup.show' >
				
				<section class='popup_body'>
					<button class='exit-x' ng-click='prc.popup.close()'>x</button>
					<h1> {{ prc.popup.heading }} </h1>
					<p> {{ prc.popup.message }}</p>
					<button class='btn btn-default' ng-show='prc.popup.Type > 0'>verzenden</button>
				</section>
				
			
			</section>
			
			
		</section>
		
	</section>
	
</body>
</html>