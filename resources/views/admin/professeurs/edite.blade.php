@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Forms</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edition Professeur</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-7 mx-auto">
                {{--  <h6 class="mb-0 text-uppercase">Formulaire d'enregistrement d'un etudiant</h6>
                <hr />  https://youtu.be/u1xdTEP-hjM--}}
                <div class="card border-top border-0 border-4 border-white">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                            </div>
                            <h5 class="mb-0 text-white">Edition Professeur</h5>
                        </div>
                        <hr>
                        <form class="row g-3" method="POST" action="{{ url('update_professeur/'. $professeurs->id) }}", enctype="multipart/form-data" id="ecoleForm">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label">Nom</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text" class="form-control @error('nom') is-invalid  @enderror" value="{{ $professeurs->nom }}"
                                     name="nom" placeholder="nom">
                                </div>
                                @error('nom')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName2" class="form-label">Prenom</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text" class="form-control @error('prenom') is-invalid  @enderror" value="{{ $professeurs->prenom }}"
                                    id="inputEnterYourName" name="prenom" placeholder="prenom">
                                </div>
                                @error('prenom')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputAddress3" class="form-label">Sexe</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <select class="form-select mb-0 @error('sexe') is-invalid  @enderror" name="sexe" aria-label="Default select example">
                                        <option value="H"{{ $professeurs->sexe == "1" ? 'selected' : '' }}>homme</option>
                                        <option value="F"{{ $professeurs->sexe == "0" ? 'selected' : '' }}>Femme</option>
                                    </select>
                                </div>
                                @error('sexe')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputPhoneNo" class="form-label">Téléphone</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-microphone'></i></span>
                                    <input type="text" class="form-control border-start-0  @error('telephone1') is-invalid  @enderror" id="inputPhoneNo" name="telephone1" value="{{ $professeurs->telephone1 }}"
                                        placeholder="Phone No" />
                                </div>
                                @error('telephone1')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>


                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label"> Address Email</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-message'></i></span>
                                    <input type="text" class="form-control border-start-0 @error('email') is-invalid  @enderror" id="inputEmailAddress" name="email" value="{{ $professeurs->email }}"
                                        placeholder="Email Address" />
                                </div>
                                @error('email')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputAddress3" class="form-label">Address</label>
                                <input class="form-control @error('adresse') is-invalid  @enderror" id="inputAddress3" name="adresse" placeholder="Enter Address" value="{{ $professeurs->adresse }}">
                                @error('adresse')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputAddress3" class="form-label">Photo</label><br><br>
                                <input type="file" class="form-control" aria-label="file example" name="image"
                                    style="text-align:center;">
                            </div>

                            <div class="col-md-6">
                                <br>
                                <button type="submit" class="btn btn-primary px-5" id="flash"
                                data-flash="{!! session()->get('success') !!}"><i
                                    class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                           </div>
                           <div class="col-md-6"><br>
                            <a href="{{ route('professeur') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                    </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <br><br><br>

@endsection
@push('validate')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Désactive le bouton Enregistrer lorsqu'il est cliqué
        document.getElementById("ecoleForm").addEventListener("submit", function() {
            document.getElementById("flash").setAttribute("disabled", "disabled");
        });
    });

    window.onload = function() {
        // Réactive le bouton Enregistrer une fois que la page a fini de se charger
        document.getElementById("flash").removeAttribute("disabled");
    };

</script>
@endpush

