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
        <!--end row-->


        {{-- <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="mb-0">Performance</h5>
                            <div class="dropdown options ms-auto">
                                <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                </div>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="hstack flex-wrap align-items-center justify-content-between gap-3 gap-sm-4 mb-3 border p-3 radius-10">
                            <div class="">
                                <h5 class="mb-0">974 <span class="text-white font-13">56% <i
                                            class='bx bx-up-arrow-alt'></i></span></h5>
                                <p class="mb-0">Page Views</p>
                            </div>
                            <div class="vr"></div>
                            <div class="">
                                <h5 class="mb-0">1,218 <span class="text-white font-13">34% <i
                                            class='bx bx-down-arrow-alt'></i></span></h5>
                                <p class="mb-0">Total Sales</p>
                            </div>
                            <div class="vr"></div>
                            <div class="">
                                <h5 class="mb-0">42.8% <span class="text-white font-13">22% <i
                                            class='bx bx-up-arrow-alt'></i></span></h5>
                                <p class="mb-0">Conversion Rate</p>
                            </div>
                        </div>

                        <div class="chart-js-container1">
                            <canvas id="chart1"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 d-flex">
                <div class="card radius-10 overflow-hidden w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="mb-0">Top Categories</h5>
                            <div class="dropdown options ms-auto">
                                <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                </div>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="chart-js-container2 mt-4">
                            <div class="piechart-legend">
                                <h2 class="mb-1">8,452</h2>
                                <h6 class="mb-0">Total Sessions</h6>
                            </div>
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center border-top bg-transparent">
                            Clothing
                            <span class="badge bg-white rounded-pill text-dark">558</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Electronics
                            <span class="badge bg-white bg-opacity-50 rounded-pill">204</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Furniture
                            <span class="badge bg-white bg-opacity-25 rounded-pill">108</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!--end row-->

        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">Weekly Visits</h5>
                    </div>
                    <div class="dropdown options ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-js-container3">
                    <canvas id="chart3"></canvas>
                </div>
            </div>
        </div>

        <div class="card radius-10 w-100">
            <div class="card-body">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 g-3">
                    <div class="col">
                        <div class="p-3 text-center border radius-10">
                            <span class="donut"
                                data-peity='{ "fill": ["#fff", "rgb(255 255 255 / 12%)"], "innerRadius": 50, "radius": 32 }'>4/5</span>

                            <h6 class="mb-0 mt-3">Total Orders : 4K</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 text-center border radius-10">
                            <span class="donut"
                                data-peity='{ "fill": ["#fff", "rgb(255 255 255 / 12%)"], "innerRadius": 50, "radius": 32 }'>2/5</span>

                            <h6 class="mb-0 mt-3">Pending : 1.2K</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 text-center border radius-10">
                            <span class="donut"
                                data-peity='{ "fill": ["#fff", "rgb(255 255 255 / 12%)"], "innerRadius": 50, "radius": 32 }'>3/5</span>

                            <h6 class="mb-0 mt-3">Delivered : 2.4</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 text-center border radius-10">
                            <span class="donut"
                                data-peity='{ "fill": ["#fff", "rgb(255 255 255 / 12%)"], "innerRadius": 50, "radius": 32 }'>2/5</span>

                            <h6 class="mb-0 mt-3">Received : 492</h6>
                        </div>
                    </div>
                </div>
                <!--end row-->

            </div>
        </div> --}}
        @if (UserFullRole() == 'Admin')
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-12 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header border-bottom bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-0">Professeurs Récents</h5>
                                </div>
                                <div class="dropdown options ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('disposer') }}">Voir tous les
                                                professeurs</a></li>

                                    </ul>
                                </div>

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
                                                            <h6 class="mb-1 font-14">{{ $inscription->etudiant_prenom }}
                                                                {{ $inscription->etudiant_nom }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $inscription->tuteur_prenoms }}
                                                    {{ $inscription->tuteur_nom }}</td>
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
