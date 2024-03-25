@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div> 
                                @if (UserFullRole() == 'Admin')
                                    <p class="mb-0 text-white">Nombre total d'étudiants</p>
                                    <h4 class="my-1 text-white">{{ getTotalEtudiants() }}</h4>
                                @endif
                                @if (fullRoleSuperAdmin() == 'SuperAdmin')
                                    <p class="mb-0 text-white">Total des écoles inscrites</p>
                                    <h4 class="my-1 text-white">{{ getTotalEcoles() }} </h4>
                                @endif
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i class="bx bxs-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                @if (UserFullRole() == 'Admin')
                                    <p class="mb-0 text-white">Nombre total de professeurs</p>
                                    <h4 class="my-1 text-white">{{ getTotalProfesseurs() }}</h4>
                                @endif
                                @if (fullRoleSuperAdmin() == 'SuperAdmin')
                                    <p class="mb-0 text-white">Total des Responsables</p>
                                    <h4 class="my-1 text-white">{{ getTotalResponsables() }}</h4>
                                @endif
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i class="bx bxs-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                @if (UserFullRole() == 'Admin')
                                    <p class="mb-0 text-white">Total de Classes</p>
                                    <h4 class="my-1 text-white">{{ getTotalClasses() }}</h4>
                                @endif
                                @if (fullRoleSuperAdmin() == 'SuperAdmin')
                                    <p class="mb-0 text-white">Total de Niveau scolaire</p>
                                    <h4 class="my-1 text-white">{{ getTotalNiveauScolaire() }}</h4>
                                @endif
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i
                                    class="bx bxs-binoculars"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                @if (UserFullRole() == 'Admin')
                                    <p class="mb-0 text-white">Total de Tuteurs</p>
                                    <h4 class="my-1 text-white">{{ getTotalTuteurs() }}</h4>
                                @endif
                                @if (fullRoleSuperAdmin() == 'SuperAdmin')
                                    <p class="mb-0 text-white">Total des Utilisateurs</p>
                                    <h4 class="my-1 text-white">{{ getTotalUtilisateurs() }}</h4>
                                @endif
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white"><i class="bx bxs-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
      
        @if (fullRoleSuperAdmin() == 'SuperAdmin')
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-12 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header border-bottom bg-transparent">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-0">Ecoles Récents</h5>
                                </div>
                                <button class="btn btn-secondary text-start" onclick="window.location.href='{{ route('ecole') }}'">Voir tous les Ecoles</button>
                            </div>
                            
                        </div>
                        @foreach ($ecoles as $ecole)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <img src="/storage/images/{{ $ecole->image }}" alt="user avatar"
                                            class="rounded-circle" width="55" height="55">
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $ecole->nom }}<small class="ms-4">
                                                    {{ $ecole->created_at }}</small></h6><br>
                                            <p class="mb-0 small-font">{{ $ecole->email }} </p>
                                            {{-- de {{ $dat->matiere }} en {{ $dat->classe }}.</p> --}}
                                        </div>
                                        <div class="ms-auto star">

                                        </div>

                                    </div>
                                </li>

                            </ul>
                        @endforeach
                    </div>
                </div>
            </div><!--End Row-->
        @endif


        <!--end row-->
       
        @if (fullRoleSuperAdmin() == 'SuperAdmin')
            <div class="row">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Responsables Récents</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('utilisateur') }}" class="btn btn-light btn-sm radius-30">Voir tous
                                        les
                                        Responsables</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Responsable</th>
                                            <th>Email</th>
                                            <th>Telephone</th>
                                            <th>Date d'inscription</th>
                                            <th>Ecole</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">

                                                        <div class="ms-0">
                                                            <h6 class="mb-1 font-14">{{ $user->prenom }}
                                                                {{ $user->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td> {{ $user->telephone }}</td>
                                                <td class="">{{ $user->created_at }}</td>
                                                <td>{{ optional($user->ecoles)->nom }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!--end row-->
        @endif

    </div>

@endsection
