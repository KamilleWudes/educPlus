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
                        <li class="breadcrumb-item active" aria-current="page">Profile professeur</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        <!--end breadcrumb-->
        <form class="row g-3" method="POST" action="{{ url('update_professeur/' . $professeurs->id) }}",  enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="container"><br><br>
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="/storage/images/{{$professeurs->image}}" alt="Admin"
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
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-mail me-2 icon-inline logo-email">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="6" x2="16" y2="6"></line>
                                            <line x1="2" y1="10" x2="8" y2="10"></line>
                                            <line x1="2" y1="14" x2="8" y2="14"></line>
                                            <line x1="16" y1="10" x2="22" y2="10"></line>
                                            <line x1="16" y1="14" x2="22" y2="14"></line>
                                        </svg>Email</h6>
                                        <span class="text-white">{{ $professeurs->email }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone me-2 icon-inline">
                                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                            <path d="M12 2V22"></path>
                                            <circle cx="12" cy="18" r="2"></circle>
                                        </svg>Contact</h6>
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
                                            <input type="text" id="n" class="form-control" value="{{ $professeurs->nom }} {{ $professeurs->prenom }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sexe</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            @if ($professeurs->sexe == "H")
                                            <input type="text" id="s" class="form-control" placeholder="Homme" />
                                            @else
                                            <input type="text" id="s" class="form-control" placeholder="Femme" />

                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Télephone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="t" class="form-control" value="{{ $professeurs->telephone1 }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="e" class="form-control" value="{{ $professeurs->email }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="a" class="form-control" value="{{ $professeurs->adresse }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9"><br><br><br>
                                            <a href="{{ route('saisi-note') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Retour à l'accueil</button> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
