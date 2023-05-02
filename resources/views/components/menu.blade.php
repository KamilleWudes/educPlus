<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Dashtreme</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
					<ul>
						<li> <a href="index.html"><i class="bx bx-right-arrow-alt"></i>Default</a>
						</li>
						<li> <a href="dashboard-eCommerce.html"><i class="bx bx-right-arrow-alt"></i>eCommerce</a>
						</li>
						<li> <a href="dashboard-sales.html"><i class="bx bx-right-arrow-alt"></i>Sales</a>
						</li>
						<li> <a href="dashboard-analytics.html"><i class="bx bx-right-arrow-alt"></i>Analytics</a>
						</li>
						<li> <a href="dashboard-alternate.html"><i class="bx bx-right-arrow-alt"></i>Alternate</a>
						</li>
						<li> <a href="dashboard-digital-marketing.html"><i class="bx bx-right-arrow-alt"></i>Digital Marketing</a>
						</li>
						<li> <a href="dashboard-human-resources.html"><i class="bx bx-right-arrow-alt"></i>Human Resources</a>
						</li>
					</ul>
				</li>
                @if(UserFullRole()=="Admin")
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-user-plus"></i>
						</div>
						<div class="menu-title">Gestions des Etudiants</div>
					</a>
					<ul>
						<li> <a href="{{ route('addEtudiant') }}"><i class="bx bx-right-arrow-alt"></i>Nouvel Etudiant</a>
						</li>
						<li> <a href="{{ route('etudiant') }}"><i class="bx bx-right-arrow-alt"></i>Liste Etudiant</a>
						</li>
                        <li> <a href="{{ route('etudiant-delete-list') }}"><i class="bx bx-right-arrow-alt"></i>Corbeille Etudiant</a>
						</li>
					</ul>
				</li>
                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-user-plus"></i>
						</div>
						<div class="menu-title">Gestions des Professeurs</div>
					</a>
					<ul>
						<li> <a href="{{ route('addprofesseur') }}"><i class="bx bx-right-arrow-alt"></i>Nouveau Professeur</a>
						</li>
						<li> <a href="{{ route('professeur') }}"><i class="bx bx-right-arrow-alt"></i>Liste Professeur</a>
						</li>
                        <li> <a href="{{ route('disposer') }}"><i class="bx bx-right-arrow-alt"></i>Liste Matière - classe -<bR> - Professeur<br></a>
						</li>
					</ul>
				</li>
                {{--  <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-user-plus"></i>
						</div>
						<div class="menu-title">Gestions des classes -<br>-Professeurs-Matières</div>
					</a>
					<ul>
						<li> <a href="{{ route('adddisposer') }}"><i class="bx bx-right-arrow-alt"></i>Nouvel liaison</a>
						</li>
						<li> <a href="{{ route('disposer') }}"><i class="bx bx-right-arrow-alt"></i>Liste liaison</a>
						</li>
					</ul>
				</li>  --}}
				<li class="menu-label">Inscrptions</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-desktop'></i>
						</div>
						<div class="menu-title">Gestions des Inscriptions</div>
					</a>
					<ul>
						<li> <a href="{{ route('addinscription') }}"><i class="bx bx-right-arrow-alt"></i>Nouvel Inscrption</a>
						</li>
						<li> <a href="{{ route('inscription') }}"><i class="bx bx-right-arrow-alt"></i>Liste des Inscrptions</a>
						</li>
					</ul>
				</li>
                @endif

                @if(UserFullRoleProf()=="professeur")
				<li class="menu-label">Elaborations des Bulettins</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-news'></i>
						</div>
						<div class="menu-title"> Gestions des Bulettins</div>
					</a>
					<ul>
                        {{--  <li> <a href="{{ route('addoperation') }}"><i class="bx bx-right-arrow-alt"></i>Operation</a>
						</li>
						<li> <a href="{{ route('bulletin') }}"><i class="bx bx-right-arrow-alt"></i>Liste des Operation</a>
						</li>  --}}
                        <li> <a href="{{ route('add-saisi-note') }}"><i class="bx bx-right-arrow-alt"></i>Saisie de note</a>
						</li>
						<li> <a href="{{ route('saisi-note') }}"><i class="bx bx-right-arrow-alt"></i>Liste des notes</a>
						</li>
					</ul>

				</li>
                @endif
                @if(UserFullRole()=="Admin" || fullRoleSuperAdmin()=="SuperAdmin")
                <li class="menu-label">Parametres</li>
                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-cog bx-spin"></i>
						</div>
						<div class="menu-title">Gestions des Parametres</div>
					</a>
					<ul>
                        @if(UserFullRole()=="Admin")
						<li> <a href="{{ route('anneeScolaire') }}"><i class="bx bx-right-arrow-alt"></i>Années scolaires</a>
						</li>
                        @elseif(fullRoleSuperAdmin()=="SuperAdmin")
						<li> <a href="{{ route('ecole') }}"><i class="bx bx-right-arrow-alt"></i>Ecoles</a>
						</li>
                        <li> <a href="{{ route('NiveauScolaires') }}"><i class="bx bx-right-arrow-alt"></i>Niveaux Scolaires</a>
						</li>
                        @endif
                        @if(UserFullRole()=="Admin")
						<li> <a href="{{ route('classe') }}"><i class="bx bx-right-arrow-alt"></i>Classes</a>
						</li>
                        <li> <a href="{{ route('matier') }}"><i class="bx bx-right-arrow-alt"></i>Matieres</a>
						</li>
                        <li> <a href="{{ route('anneescolaire-classe-matieres') }}"><i class="bx bx-right-arrow-alt"></i>Matieres et coefficients</a>
						</li>
                        <li> <a href="{{ route('tuteur') }}"><i class="bx bx-right-arrow-alt"></i>Tuteurs</a>
						</li>
						<li> <a href="{{ route('trimestre') }}"><i class="bx bx-right-arrow-alt"></i>Types Trimestres</a>
						</li>
                        <li> <a href="{{ route('TypeComposition') }}"><i class="bx bx-right-arrow-alt"></i>Types Compositions</a>
						</li>
                        @endif
                        @if(fullRoleSuperAdmin()=="SuperAdmin")
                        <li> <a href="{{ route('utilisateur') }}"><i class="bx bx-right-arrow-alt"></i>Responsables</a>
						</li>
                        <li> <a href="{{ route('SuperAdmin') }}"><i class="bx bx-right-arrow-alt"></i>Utilisateurs</a>
						</li>
                        @endif
					</ul>
				</li>
                @endif

				<li class="menu-label">Charts & Maps</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-line-chart"></i>
						</div>
						<div class="menu-title">Charts</div>
					</a>
					<ul>
						<li> <a href="charts-apex-chart.html"><i class="bx bx-right-arrow-alt"></i>Apex</a>
						</li>
						<li> <a href="charts-chartjs.html"><i class="bx bx-right-arrow-alt"></i>Chartjs</a>
						</li>
						<li> <a href="charts-highcharts.html"><i class="bx bx-right-arrow-alt"></i>Highcharts</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-map-alt"></i>
						</div>
						<div class="menu-title">Maps</div>
					</a>
					<ul>
						<li> <a href="map-google-maps.html"><i class="bx bx-right-arrow-alt"></i>Google Maps</a>
						</li>
						<li> <a href="map-vector-maps.html"><i class="bx bx-right-arrow-alt"></i>Vector Maps</a>
						</li>
					</ul>
				</li>
				<li class="menu-label">Others</li>
                <li>
					<a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" target="_blank">
						<div class="parent-icon"><i class="bx bx-log-out"></i>
						</div>
						<div class="menu-title">Déconnexion</div>
					</a>
                       <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
