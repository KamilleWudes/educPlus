@extends('layouts/master')
@section('contenu')
    <form class="row g-3" method="POST" action="{{ route('createprofesseur') }}" enctype='multipart/form-data'>
        @csrf
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
                                Nouvel Professeur</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="ms-auto">
                        <label for="validationCustom04" class="form-label">Année scolaire</label>
                        <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror"
                            id="validationCustom04" name="annee_scolaire_id">
                            <option value="{{ AnneScolairesId() }}">{{ AnneScolaires() }}
                            </option>
                        </select>
                        @error('annee_scolaire_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-md-6">

                    <div class="card border-top border-0 border-4 border-white">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                                </div>
                                <h5 class="mb-0 text-white"id="label2">Nouvel Professeur</h5>
                                <h5 class="mb-0 text-white"id="label"> Ancienne Professeur</h5>
                            </div>

                            <input onclick="t(0)" type="radio" name="colors" id="red"><span
                                style="font-size:20px;">Nouveau</span>
                            <input onclick="t(1)" type="radio" name="colors" id="blue"><span
                                style="font-size:20px;">Ancien </span>
                            <hr> <br>
                            <div class="row g-3">
                                <div id="inteligen">
                                    <select class="form-select single-select" id="inputGroupSelect03" onchange="sends()"
                                        name="ecole_id">
                                        <option value="">Selectionnez professeur</option>
                                        @foreach ($professeurs as $Professeur)
                                            <option value="{{ $Professeur }}"> {{ $Professeur->nom }}
                                                {{ $Professeur->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">

                                    <label for="inputLastName1" class="form-label">Nom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text" class="form-control @error('nom') is-invalid  @enderror"
                                            id="nom" name="nom" value="{{ old('nom') }}" placeholder="nom">
                                    </div>
                                    @error('nom')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputLastName2" class="form-label">Prenom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text" class="form-control @error('prenom') is-invalid  @enderror"
                                            id="inputEnterYourName" name="prenom" value="{{ old('prenom') }}"
                                            placeholder="prenom">
                                    </div>
                                    @error('prenom')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Sexe</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <select class="form-select mb-0 @error('sexe') is-invalid  @enderror" name="sexe"
                                            id="sexe" aria-label="Default select example">
                                            <option value=""> Sexe </option>
                                            <option value="H">homme</option>
                                            <option value="F">Femme</option>
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
                                        <input type="text"
                                            class="form-control border-start-0  @error('telephone1') is-invalid  @enderror"
                                            id="inputPhoneNo" name="telephone1" value="{{ old('telephone1') }}"
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
                                        <input type="text"
                                            class="form-control border-start-0 @error('email') is-invalid  @enderror"
                                            id="inputEmailAddress" name="email" value="{{ old('email') }}"
                                            placeholder="example@gmail.com" />
                                    </div>
                                    @error('email')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Address</label>
                                    <textarea class="form-control @error('adresse') is-invalid  @enderror" id="inputAddress3" name="adresse"
                                        value="{{ old('adresse') }}" placeholder="Enter Address" rows="2"></textarea>
                                    @error('adresse')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Photo</label><br><br>
                                    <input type="file" class="form-control" id="image" aria-label="file example"
                                        name="image" accept=".jpg, .png, .jfif, image/jpeg, image/png, image/jfif"
                                        multiple style="text-align:center;">
                                </div>
                                <div class="col-12">
                                    <label for="inputChoosePassword" class="form-label">Mot de passe</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid  @enderror border-end-0"
                                            id="inputChoosePassword" name="password" value="{{ old('password') }}"
                                            placeholder="Enter Password"> <a href="javascript:;"
                                            class="input-group-text"><i class='bx bx-hide'></i></a>
                                    </div>
                                    @error('password')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="hidden" id="roles" name="role" value="professeur">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <br> <br> <br> <br> <br>
                    <div class="card border-top border-0 border-4 border-white">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                                </div>
                                <h5 class="mb-0 text-white">Section Classes / Matières</h5>
                            </div>
                            <hr>
                            <div class="row g-3">

                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label"> Selectionnez la classe</label>
                                    <div class="input-group">
                                       
                                        <select
                                            class="multiple-select @error('classe_id') is-invalid  @enderror single-select"
                                            id="inputGroupSelect04" name="classe_id[]"
                                            aria-label="Example select with button addon" multiple="multiple">
                                            @foreach ($classes as $classe)
                                                <option value="{{ $classe->id }}"> {{ $classe->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('classe_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{--  <div class="col-12">
                                    <label class="form-label">Selectionnez la Matière</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button"><i
                                                class='bx bx-search'></i>
                                        </button>
                                        {{--  <select class="single-select  @error('matier_id') is-invalid  @enderror form-select"  name="matier_id">
                                            <option value="">Selectionnez la Matière</option>
                                            @foreach ($matieres as $matiere)
                                               <option value="{{ $matiere->id }}"> {{ $matiere->nom }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>  --}}
                                {{--  @error('matier_id')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror  --}}

                                <div class="col-12">
                                    <label class="form-label">Selectionnez la Matière</label>
                                    <div class="input-group">

                                        <select class="multiple-select  @error('matier_id') is-invalid  @enderror"
                                            data-placeholder="Choose anything" name="matier_id[]" multiple="multiple">
                                            @foreach ($matieres as $matiere)
                                                <option value="{{ $matiere->id }}"> {{ $matiere->nom }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @error('matier_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror


                                    <input type="hidden" id="na" name="na">
                                    <input type="hidden" id="inputhidden" name="professeur_id">
                                    <input type="hidden" value="{{ EcolesId() }}" name="ecole_id" />

                                </div>
                            </div> <br> <br><br>
                            <button type="submit" class="btn btn-primary px-5"><i
                                    class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                            <a href="{{ route('professeur') }}"> <button type="button" class="btn btn-danger px-5"
                                    onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                        </div>
                    </div>
                </div>
                <script>
                    t(0)
                    //Remplissage des inputs
                    function sends() {

                        var n = document.getElementById("inputGroupSelect03").value
                        var r = JSON.parse(n)
                        document.getElementById('inputhidden').value = r.id
                        document.getElementById('nom').value = r.nom
                        document.getElementById('inputEnterYourName').value = r.prenom
                        document.getElementById('sexe').value = r.sexe
                        document.getElementById('inputPhoneNo').value = r.telephone1
                        document.getElementById('inputEmailAddress').value = r.email
                        document.getElementById('inputAddress3').value = r.adresse
                        document.getElementById('image').value = r.image
                        document.getElementById('password').value = r.password
                        document.getElementById('roles').value = r.role


                    }

                    function t(r) {
                        if (r == 0) {

                            let o = document.getElementById("inteligen")
                            o.setAttribute("hidden", "hidden")
                            document.getElementById('na').value = 'nouveau'
                            document.getElementById('nom').value = ''
                            document.getElementById('inputEnterYourName').value = ''
                            document.getElementById('sexe').value = ''
                            document.getElementById('inputPhoneNo').value = ''
                            document.getElementById('inputEmailAddress').value = ''
                            document.getElementById('inputAddress3').value = ''
                            document.getElementById("nom").readOnly = false;
                            document.getElementById("inputEnterYourName").readOnly = false;

                            document.getElementById("sexe").readOnly = false;
                            document.getElementById("inputPhoneNo").readOnly = false;
                            document.getElementById("inputEmailAddress").readOnly = false;
                            document.getElementById("inputAddress3").readOnly = false;
                            document.getElementById("image").readOnly = false;
                            document.getElementById("password").readOnly = false;


                            document.getElementById("label").hidden = true;
                            document.getElementById("label2").hidden = false;
                            document.getElementById("inputhidden").hidden = true;
                            document.getElementById("inputhidden2").hidden = false;


                        } else {

                            let o = document.getElementById("inteligen")
                            o.removeAttribute("hidden")
                            document.getElementById('na').value = 'ancien'

                            document.getElementById("nom").readOnly = true;
                            document.getElementById("inputEnterYourName").readOnly = true;
                            document.getElementById("sexe").readOnly = true;
                            document.getElementById("inputPhoneNo").readOnly = true;
                            document.getElementById("inputEmailAddress").readOnly = true;
                            document.getElementById("inputAddress3").readOnly = true;
                            document.getElementById("image").readOnly = true;
                            document.getElementById("password").readOnly = true;

                            document.getElementById("label").hidden = false;
                            document.getElementById("label2").hidden = true;
                            document.getElementById("inputhidden").hidden = false;
                            document.getElementById("inputhidden2").hidden = true;

                        }
                    }
                   
                </script>
            @endsection

   @push("Unique-prof")
     <script>
        var successFlash = '{{ session('success') }}';
        var errorFlash = '{{ session('error') }}';

        if (successFlash) {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: successFlash,
                showClass: {
                    popup: 'animate__animated animate__jackInTheBox'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                },
                timer: 500000, // Temps en millisecondes (3 secondes dans cet exemple)
                timerProgressBar: true, // Affiche une barre de progression
                toast: false, // Style de popup de notification
                position: 'center' // Position de la notification
            });
        } else if (errorFlash) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: errorFlash,
                showClass: {
                    popup: 'animate__animated animate__shakeX'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                },
                //timer: 50000, // Temps en millisecondes (3 secondes dans cet exemple)
                //timerProgressBar: true, // Affiche une barre de progression
                //toast: false, // Style de popup de notification
                //position: 'top-end' // Position de la notification
            });
        }
    </script>
@endpush