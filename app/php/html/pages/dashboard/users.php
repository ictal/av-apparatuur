<section class='dashboard-content clearfix' ng-controller="userManager as um" ng-init="um.loadUsers()">
					<section><!-- Controller hier -->
						<section class='clearfix action_bar'>
						
							<button class='btn btn-blue' ng-click='um.editUser()'>Edit</button>
							<button class='btn btn-danger' ng-click='um.delete()'>Delete</button>
						</section>
					</section>
					<section class='notifications' >
							<h1>Alle Producten<a><img src='img/icon-show-1.png'></a></h1>
							<hr >
							
							<table ng-hide="pm.productAmount <= 0">
								<tr id='head' >
									<th width='35px'> <input type='checkbox' id='selected_products' name='selected_products' ng-click="um.selectAll($event)"></th>
									<th width='25px'>id</th>
									<th>naam</th>
									<th>studenten nummer</th>
									<th>email</th>
									<th>laats ingelogd</th>
								</tr>
								<tr ng-repeat="user in um.users">
								
									<td><input type='checkbox' id='{{user.id}}' ng-click="um.addToList( user.id )"name='selected_products'></td>
									<td>{{user.id}}</td>
									<td>{{user.first_name + " " + user.tsn_voegsel + ' ' + user.last_name }}</td>
									<td>{{user.student_number}}</td>
									<td>{{user.email}}</td>
									<td>{{user.last_login}}</td>
								</tr>
							</table>
							<p ng-show="pm.productAmount <= 0">Geen producten.</p>
					</section>
					
					<section class='notifications' ng-show="um.showEdit && um.selectedUsers.length > 0 && um.selectedUsers.length < 2">
						<h1> Form </h1>
						<hr>
						
						<section class='productForm' >
							<table>				
								<tr>
									<td>student_nummer </td>
									<td>
										<input type='text' ng-model="um.editAbleUser.student_number " placeholder="{{ um.getselectedUser('student_number' ) }} ">
									</td>
								</tr>
								<tr>
									<td>naam</td>
									<td>
										<input type='text' ng-model="um.editAbleUser.first_name" placeholder="{{ um.getselectedUser( 'first_name' ) }} ">
									</td>
								</tr>
								<tr>
									<td>tsn_voegsel</td>
									<td>
										<input type='text' ng-model="um.editAbleUser.tsn_voegsel" placeholder="{{ um.getselectedUser( 'tsn_voegsel' ) }} ">
									</td>
								</tr>
								<tr>
									<td>achternaam</td>
									<td>
										<input type='text' ng-model="um.editAbleUser.last_name" placeholder="{{ um.getselectedUser( 'last_name' ) }} ">
									</td>
								</tr>
								<tr>
									<td>email</td>
									<td>
										<input type='text' ng-model="um.editAbleUser.email" ng-placeholder="{{ um.getselectedUser( 'email' ) }} ">
									</td>		
								</tr>
								<tr>
									<td>permission</td>
									<td>
										<select name='permission' ng-model='um.editAbleUser.permission' >
											<option value='0'>0</option>
											<option value='1'>1</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>wachtwoord</td>
									<td><input type='text' ng-model="um.editAbleUser.password" placeholder="wachtwoord"></td>
								</tr>
								<tr>
									<td>
										<button class='btn btn-blue' ng-click='um.updateUser()' >Edit</button><button class='btn btn-danger' ng-click='um.closeEdit()' >sluiten</button>
									</td>
									
								</tr>
							</table>
							
						</section>
						
					</section>	
					
				</section>
				
			</section>
			<section id='popup' class="popup hidden">
				<section id='popup1' class="inner-popup  ">
					<h3>Waarshuwing</h3>
					<p><center>Weet u zeker dat u deze product(en) wilt verwijderen?</center></p>
					<center><button href="?"class='btn btn-blue'>Ja</button><button onclick='dismiss()'class='btn btn-danger'>Nee</button></center>
				</section>
			</section>
