@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Detail</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Etudiant</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                {{-- <div class="btn-group">
                    <button type="button" class="btn btn-light">Settings</button>
                    <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                            href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div> --}}
            </div>
        </div>
    <form class="row g-3" method="POST" action="{{ url('update_inscription/' . $inscriptions->id) }}",
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
                                    <img src="/storage/images/{{$inscriptions->etudiant->image}}" alt="Admin"
                                        class="rounded-circle p-1 bg-primary" width="300">
                                    <div class="mt-3">
                                         <h6> Matricule: {{ $inscriptions->etudiant->matricule }}</h6>

                                        <h6>Nom: {{ $inscriptions->etudiant->nom }} {{ $inscriptions->etudiant->prenom }}</h6>
                                         @foreach ($classes as $classe)
                                           @if ($classe->id == $inscriptions->classe_id)

                                         <p class="font-size-sm">Classe: {{ $classe->nom }}</p> 
                                             @endif

                                              @endforeach
                                        {{-- <p class="font-size-sm">Email: {{ $inscriptions->etudiant->email }}</p> --}}
                                         {{-- <h5> Matricule: {{ $inscriptions->etudiant->matricule }}</h5> --}}

                                        {{-- <button class="btn btn-light">Follow</button>
                                        <button class="btn btn-light">Message</button> --}}
                                    </div>

                                </div>
                                 <hr class="my-4" />
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-mail me-2 icon-inline logo-email">
                                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                <line x1="8" y1="6" x2="16" y2="6"></line>
                                                <line x1="2" y1="10" x2="8" y2="10"></line>
                                                <line x1="2" y1="14" x2="8" y2="14"></line>
                                                <line x1="16" y1="10" x2="22" y2="10"></line>
                                                <line x1="16" y1="14" x2="22" y2="14"></line>
                                            </svg>Email
                                        </h6>
                                        <span class="text-white">{{ $inscriptions->etudiant->email }}</span>
                                    </li>
                                    
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone me-2 icon-inline">
                                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                                <path d="M12 2V22"></path>
                                                <circle cx="12" cy="18" r="2"></circle>
                                            </svg>Contact
                                        </h6>
                                        <span class="text-white">{{ $inscriptions->etudiant->telephone }}</span>
                                    </li>
                                    
                                    
                                    
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-calendar me-2 icon-inline">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            Date d'inscription
                                        </h6>
                                        <span class="text-white">{{ $inscriptions->date_insription }}</span>
                                    </li>
                                    
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-2 icon-inline">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                          </svg>
                                          Date de Naissance
                                        </h6>
                                        <span class="text-white">{{ $inscriptions->etudiant->dateNaissance }}</span>
                                      </li>
                                      
                                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-map-pin me-2 icon-inline">
                                                <path
                                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z">
                                                </path>
                                            </svg>Lieu de naissance
                                        </h6>
                                        <span class="text-white">{{ $inscriptions->etudiant->LieuNaissance }}</span>
                                    </li>
                                    
                                </ul>  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                            <div class="card">
                            
                                <div class="card-body">
                               <p class="font-size-sm" style="text-align:center">INFORMATIONS DE L'ETUDIANT</p> 
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nom et prenom</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="n" class="form-control" value="{{ $inscriptions->etudiant->nom }} {{ $inscriptions->etudiant->prenom }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sexe</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            @if ($inscriptions->etudiant->sexe == "H")
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
                                            <input type="text" id="t" class="form-control" value="{{ $inscriptions->etudiant->telephone }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="e" class="form-control" value="{{ $inscriptions->etudiant->email }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="a" class="form-control" value="{{ $inscriptions->etudiant->adresse }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                       
                                    </div>
                                </div>
                            </div>
                         

                         <div class="col-lg-12">
                            <div class="card">
                            
                                <div class="card-body">
                               <p class="font-size-sm" style="text-align:center">INFORMATIONS DU TUTEUR</p> 
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nom et prenom</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="x" class="form-control" value="{{ $inscriptions->tuteur->noms }} {{ $inscriptions->tuteur->prenoms }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sexe</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            @if ($inscriptions->tuteur->sex == "H")
                                            <input type="text" id="y" class="form-control" placeholder="Homme" />
                                            @else
                                            <input type="text" id="y" class="form-control" placeholder="Femme" />

                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Télephone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="z" class="form-control" value="{{ $inscriptions->tuteur->telephone1 }} / {{ $inscriptions->tuteur->telephone2 }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="b" class="form-control" value="{{ $inscriptions->tuteur->emails }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="c" class="form-control" value="{{ $inscriptions->tuteur->adresses }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9"><br>
                                            <a href="{{ route('Note-etudiant') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Retour à l'accueil</button> </a>
                                        </div>
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

@push('detail')
<script>
        document.getElementById("n").readOnly = true;
        document.getElementById("s").readOnly = true;
        document.getElementById("t").readOnly = true;
        document.getElementById("e").readOnly = true;
        document.getElementById("a").readOnly = true;

        document.getElementById("x").readOnly = true;
        document.getElementById("y").readOnly = true;
        document.getElementById("z").readOnly = true;
        document.getElementById("b").readOnly = true;
        document.getElementById("c").readOnly = true;

</script>
    
@endpush
