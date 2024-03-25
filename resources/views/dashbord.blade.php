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
        
        @if (UserFullRole() == 'Admin')
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-12 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header border-bottom bg-transparent">
                           
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-0">Professeurs Récents</h5>
                                </div>
                                <button class="btn btn-secondary text-start" onclick="window.location.href='{{ route('disposer') }}'">Voir tous les professeurs</button>
                            </div>
                        </div>
                        @foreach ($data as $dat)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <img src="/storage/images/{{ $dat->image }}" alt="user avatar"
                                            class="rounded-circle" width="55" height="55">
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $dat->matricule }}<small class="ms-4">
                                                    {{ $dat->created_at }}</small></h6><br>
                                            <p class="mb-0 small-font">{{ $dat->nom }} {{ $dat->prenom }} :
                                                Professeur(e)
                                                de {{ $dat->matiere }} en {{ $dat->classe }}.</p>
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
        @if (UserFullRole() == 'Admin')
            <div class="row">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Étudiants Récents</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('etudiant') }}" class="btn btn-light btn-sm radius-30">Voir tous
                                        les
                                        Etudiants</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Matricules</th>
                                            <th>Nom Etudiants</th>
                                            <th>Nom Tuteurs</th>
                                            <th>Classes</th>
                                            <th>Date d'inscription</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inscriptions as $inscription)
                                            <tr>
                                                <td>{{ $inscription->matricule }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">

                                                        <div class="ms-0">
                                                            <h6 class="mb-1 font-14">{{ $inscription->etudiant_nom }}
                                                                {{ $inscription->etudiant_prenom }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $inscription->tuteur_nom }}
                                                    {{ $inscription->tuteur_prenoms }}</td>
                                                <td class="">{{ $inscription->classe_nom }}</td>
                                                <td>{{ $inscription->date_insription }}</td>

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
