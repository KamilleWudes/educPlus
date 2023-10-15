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
                        <li class="breadcrumb-item active" aria-current="page">Profile Responsable</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
       
            </div>
        </div>
        <!--end breadcrumb-->
        <form class="row g-3" method="POST" action="{{ url('detail_responsable/' . $responsables->id) }}",  enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="container"><br><br>
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-11">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nom et prenom</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="n" class="form-control" value="{{ $responsables->name }} {{ $responsables->prenom }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sexe</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            @if ($responsables->sexe == "H")
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
                                            <input type="text" id="t" class="form-control" value="{{ $responsables->telephone }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="e" class="form-control" value="{{ $responsables->email }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="a" class="form-control" value="{{ $responsables->adresse }}" />
                                        </div>
                                    </div>
                                     <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Ecole d'appartenance</h6>
                                        </div>
                                        <div class="col-sm-9">
                                                         @foreach ($ecoles as $ecole)
                                           @if ($ecole->id == $responsables->ecole_id)

                                            <input type="text" id="y" class="form-control" value="{{ $ecole->nom }}" />
                                              @endif

                                              @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9"><br><br><br>
                                            <a href="{{ route('utilisateur') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Retour sur la liste des responsables</button> </a>
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
        document.getElementById("y").readOnly = true;

</script>
    
@endpush
