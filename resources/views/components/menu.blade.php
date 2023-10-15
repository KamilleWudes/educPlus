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
        @if (UserFullRole() == 'Admin')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
                <ul>
                    <li> <a href="{{ route('dashboard') }}"><i class="bx bx-right-arrow-alt"></i>Dashboard</a>
                    </li>

                </ul>
            </li> 
        @endif
        @if (fullRoleSuperAdmin() == 'SuperAdmin')
           <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
                <ul>
                  <li> <a href="{{ route('getHome') }}"><i class="bx bx-right-arrow-alt"></i>Home</a></li>


                </ul>
            </li> 
        @endif
        @if (UserFullRole() == 'Admin')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-user-plus"></i>
                    </div>
                    <div class="menu-title">Gestions des Etudiants</div>
                </a>
                <ul>
                    {{-- <li> <a href="{{ route('addEtudiant') }}"><i class="bx bx-right-arrow-alt"></i>Nouvel Etudiant</a>
						</li> --}}
                    <li> <a href="{{ route('etudiant') }}"><i class="bx bx-right-arrow-alt"></i>Liste Etudiant</a>
                    </li>
                    {{-- <li> <a href="{{ route('etudiant-delete-list') }}"><i class="bx bx-right-arrow-alt"></i>Corbeille Etudiant</a>
						</li> --}}
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-user-plus"></i>
                    </div>
                    <div class="menu-title">Gestions des Professeurs</div>
                </a>
                <ul>
                    <li> <a href="{{ route('addprofesseur') }}"><i class="bx bx-right-arrow-alt"></i>Nouveau
                            Professeur</a>
                    </li>
                    <li> <a href="{{ route('professeur') }}"><i class="bx bx-right-arrow-alt"></i>Liste Professeur</a>
                    </li>
                    <li> <a href="{{ route('disposer') }}"><i class="bx bx-right-arrow-alt"></i>Liste Matière - classe
                            -<bR> - Professeur<br></a>
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
            <li class="menu-label">Inscriptions</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-desktop'></i>
                    </div>
                    <div class="menu-title">Gestions des Inscriptions</div>
                </a>
                <ul>
                    <li> <a href="{{ route('addinscription') }}"><i class="bx bx-right-arrow-alt"></i>Nouvel
                            Inscription</a>
                    </li>
                    <li> <a href="{{ route('inscription') }}"><i class="bx bx-right-arrow-alt"></i>Liste des
                            Inscriptions</a>
                    </li>
                    <li> <a href="{{ route('inscription-delete-list') }}"><i class="bx bx-right-arrow-alt"></i>Corbeille
                            Inscription</a>
                    </li>
                </ul>
            </li>
        @endif

        @if (UserFullRoleProf() == 'professeur')
            <li class="menu-label">Elaborations des Bulettins</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-news'></i>
                    </div>
                    <div class="menu-title"> Gestions des Bulettins</div>
                </a>
                <ul>
                    <li> <a href="{{ route('add-saisi-note') }}"><i class="bx bx-right-arrow-alt"></i>Saisie de note</a>
                    </li>
                    <li> <a href="{{ route('saisi-note') }}"><i class="bx bx-right-arrow-alt"></i>Liste des notes</a>
                    </li>
                    <li> <a href="{{ route('Releves') }}"><i class="bx bx-right-arrow-alt"></i>Relevée de Notes</a>
                    </li>
                     <li> <a href="{{ url('reset-password-professeur=' . ProfId()) }}"><i class="bx bx-right-arrow-alt"></i>Réinitialiser le mot de passe</a>
                        </li>
                </ul>

            </li>
        @endif
        @if (UserFullRole() == 'Admin' || fullRoleSuperAdmin() == 'SuperAdmin')
            <li class="menu-label">Parametres</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-cog bx-spin"></i>
                    </div>
                    <div class="menu-title">Gestions des Parametres</div>
                </a>
                <ul>
                    @if (UserFullRole() == 'Admin')
                        <li> <a href="{{ route('anneeScolaire') }}"><i class="bx bx-right-arrow-alt"></i>Années
                                scolaires</a>
                        </li>
                    @elseif(fullRoleSuperAdmin() == 'SuperAdmin')
                        <li> <a href="{{ route('ecole') }}"><i class="bx bx-right-arrow-alt"></i>Ecoles</a>
                        </li>
                        <li> <a href="{{ route('NiveauScolaires') }}"><i class="bx bx-right-arrow-alt"></i>Niveaux
                                Scolaires</a>
                        </li>
                    @endif
                    @if (UserFullRole() == 'Admin')
                        <li> <a href="{{ route('classe') }}"><i class="bx bx-right-arrow-alt"></i>Classes</a>
                        </li>
                        <li> <a href="{{ route('matier') }}"><i class="bx bx-right-arrow-alt"></i>Matières</a>
                        </li>
                        <li> <a href="{{ route('anneescolaire-classe-matieres') }}"><i
                                    class="bx bx-right-arrow-alt"></i>Matières et coefficients</a>
                        </li>
                        <li> <a href="{{ route('tuteur') }}"><i class="bx bx-right-arrow-alt"></i>Tuteurs</a>
                        </li>
                        <li> <a href="{{ route('trimestre') }}"><i class="bx bx-right-arrow-alt"></i>Types
                                Trimestres</a>
                        </li>
                        <li> <a href="{{ route('TypeComposition') }}"><i class="bx bx-right-arrow-alt"></i>Types
                                Compositions</a>
                        </li>
                        <li> <a href="{{ route('notes-etudiants') }}"><i class="bx bx-right-arrow-alt"></i>Notes
                                Etudiants</a>
                        </li>
                        <li> <a href="{{ route('Releve') }}"><i class="bx bx-right-arrow-alt"></i>Relevée de Notes</a>
                        </li>
                        <li> <a href="{{ url('reset-password=' . Userid()) }}"><i class="bx bx-right-arrow-alt"></i>Réinitialiser le mot de passe</a>
                        </li>
                    @endif
                    @if (fullRoleSuperAdmin() == 'SuperAdmin')
                        <li> <a href="{{ route('utilisateur') }}"><i class="bx bx-right-arrow-alt"></i>Responsables</a>
                        </li>
                        <li> <a href="{{ route('SuperAdmin') }}"><i class="bx bx-right-arrow-alt"></i>Utilisateurs</a>
                        </li>
                        <li> <a href="{{ url('reset-password-utilisateur=' . superAdminId()) }}"><i class="bx bx-right-arrow-alt"></i>Réinitialiser le mot de passe</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (RoleEtudiant() == 'etudiant')
            <li class="menu-label">Relevées de Notes</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-news'></i>
                    </div>
                    <div class="menu-title"> Notes & Bulettins</div>
                </a>
                <ul>
                    <li> <a href="{{ route('Note-etudiant') }}"><i class="bx bx-right-arrow-alt"></i>Notes
                            Etudiants</a>
                    </li>
                    <li> <a href="{{ route('bulettin-etudiant') }}"><i class="bx bx-right-arrow-alt"></i>Bulettins
                            Etudiants </a>
                    </li>

                </ul>

            </li>
        @endif


        <li class="menu-label">AUTRES</li>
        <li>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                target="_blank">
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
