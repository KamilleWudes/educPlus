@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Profile</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profile enseignant</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <form class="row g-3" method="POST" action="{{ url('update_professeur/' . $professeurs->id) }}",
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container"><br><br>
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="/storage/images/{{ $professeurs->image }}" alt="Admin"
                                            class="rounded-circle p-1 bg-primary" width="300">
                                        <div class="mt-3">
                                            <h6> Matricule: {{ $professeurs->matricule }}</h6>

                                            <h6>Nom: {{ $professeurs->nom }} {{ $professeurs->prenom }}</h6>

                                            {{-- <button class="btn btn-light">Follow</button>
                                        <button class="btn btn-light">Message</button> --}}
                                        </div>

                                    </div>
                                    <hr class="my-4" />
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Email</h6>
                                            <span class="text-white">{{ $professeurs->email }}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Contact</h6>
                                            <span class="text-white">{{ $professeurs->telephone1 }}</span>
                                        </li>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nom et prenom</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="n" class="form-control"
                                                value="{{ $professeurs->nom }} {{ $professeurs->prenom }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sexe</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            @if ($professeurs->sexe == 'H')
                                                <input type="text" id="s" class="form-control"
                                                    placeholder="Homme" />
                                            @else
                                                <input type="text" id="s" class="form-control"
                                                    placeholder="Femme" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Télephone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="t" class="form-control"
                                                value="{{ $professeurs->telephone1 }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="e" class="form-control"
                                                value="{{ $professeurs->email }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="a" class="form-control"
                                                value="{{ $professeurs->adresse }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9"><br><br><br>
                                            <a href="{{ route('professeur') }}"> <button type="button"
                                                    class="btn btn-danger px-5" onclick="error_noti()"><i
                                                        class="bx bx-x-circle mr-1"></i> Retour sur la liste des
                                                    enseignants</button> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="d-flex align-items-center mb-3">Project Status</h5>
                                        <p>Web Design</p>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 80%"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>Website Markup</p>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 72%"
                                                aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>One Page</p>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 89%"
                                                aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>Mobile Template</p>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 55%"
                                                aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>Backend API</p>
                                        <div class="progress" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 66%"
                                                aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  --}}

                        </div>

                    </div>
                </div>
            </div>
        </form><br><br>
    </div>
@endsection

@push('bloquer')
    <script>
        document.getElementById("n").readOnly = true;
        document.getElementById("s").readOnly = true;
        document.getElementById("t").readOnly = true;
        document.getElementById("e").readOnly = true;
        document.getElementById("a").readOnly = true;
    </script>
@endpush
