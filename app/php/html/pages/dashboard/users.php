<section class='dashboard-content clearfix' ng-controller="userManager as um" ng-init="um.loadUsers()">
					<section><!-- Controller hier -->
						<section class='clearfix action_bar'>
							<button class='btn btn-blue' >Add</button>
							<button class='btn btn-danger' ng-click='um.editUser()'>Edit</button>
							<button class='btn btn-danger' >Delete</button>
						</section>
					</section>
					<section class='notifications' >
							<h1>Alle Producten<a><img src='img/icon-show-1.png'></a></h1>
							<hr >
							{{ um.selectedUsers }}
							<table ng-hide="pm.productAmount <= 0">
								<tr id='head' >
									<th width='35px'> <input type='checkbox' id='selected_products' name='selected_products' onclick="selectAll('selected_products')"></th>
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
						
						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> student_nummer </span>
							<input type='text' ng-model="um.editAbleUser.student_number " placeholder="{{ um.getselectedUser('student_number' ) }} ">
						</label>
						
						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> naam</span>
							<input type='text' ng-model="um.editAbleUser.first_name" placeholder="{{ um.getselectedUser( 'first_name' ) }} ">
						</label>

						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> tsn_voegsel </span>
							<input type='text' ng-model="um.editAbleUser.tsn_voegsel" placeholder="{{ um.getselectedUser( 'tsn_voegsel' ) }} ">
						</label>
						
						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> achternaam </span>
							<input type='text' ng-model="um.editAbleUser.last_name" placeholder="{{ um.getselectedUser( 'last_name' ) }} ">
						</label>
						
						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> email</span>
							<input type='text' ng-model="um.editAbleUser.email" placeholder="{{ um.getselectedUser( 'email' ) }} ">
						</label>
						
						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> permission </span>
							<select name='permission' ng-model='um.editAbleUser.permission' >
								<option value='0'>0</option>
								<option value='1'>1</option>
							</select>
						</label>
						
						<label style="margin-bottom: 9px; display: block;">
							<span style="border-top-width: 0px; height: 22px; width: 61px; padding-bottom: 0px; border-bottom-width: 12px; padding-right: 0px; border-right-width: 0px; margin-right: 28px; font-family: arial, sans-serif;"> wachtwoord </span>
							<input type='text' ng-model="um.editAbleUser.password" placeholder="password">
						</label>
						
						<button class='btn btn-blue' ng-click='um.updateUser()' >Edit</button>
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
