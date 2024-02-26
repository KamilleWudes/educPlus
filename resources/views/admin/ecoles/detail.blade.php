@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Profile</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('getHome') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Détail ecole</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
             
            </div>
        </div>
        <!--end breadcrumb-->
        <form class="row g-3" method="POST" action="{{ url('update_ecole/' . $ecoles->id) }}",  enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="container"><br><br>
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="/storage/images/{{$ecoles->image}}" alt="Admin"
                                        class="p-1 bg-primary" width="350" height="350">
                                          {{-- <h6> Matricule: {{ $professeurs->matricule }}</h6>

                                        <h6>Nom: {{ $professeurs->nom }} {{ $professeurs->prenom }}</h6> --}}

                                        {{-- <button class="btn btn-light">Follow</button>
                                        <button class="btn btn-light">Message</button> --}}

                                </div>
                                {{-- <hr class="my-4" /> --}}
                                <ul class="list-group list-group-flush">
                                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-globe me-2 icon-inline">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                                <path
                                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                                </path>
                                            </svg>Email</h6>
                                        <span class="text-white">{{ $ecoles->email }}</span>
                                    </li> --}}
                                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-github me-2 icon-inline">
                                                <path
                                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                                </path>
                                            </svg>Contact</h6>
                                        <span class="text-white">{{ $ecoles->telephone1 }} / {{ $ecoles->telephone2 }}</span>
                                    </li> --}}
                                    
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                            <div class="card"><br>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Complexe scolaire</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="n" class="form-control" value="{{ $ecoles->nom }}" />
                                        </div>
                                    </div>
                                   
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Télephone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="t" class="form-control" value="{{ $ecoles->telephone1 }} / {{ $ecoles->telephone2 }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="e" class="form-control" value="{{ $ecoles->email }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="a" class="form-control" value="{{ $ecoles->adresse }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9"><br><br><br>
                                            <a href="{{ route('ecole') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Retour sur la liste des ecoles</button> </a>
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
        document.getElementById("t").readOnly = true;
        document.getElementById("e").readOnly = true;
        document.getElementById("a").readOnly = true;
</script>
    
@endpush
