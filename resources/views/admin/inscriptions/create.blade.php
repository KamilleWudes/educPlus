@extends('layouts/master')
@section('contenu')
    <form class="row g-3" method="POST" action="{{ route('createinscription') }}" enctype='multipart/form-data'>
        @csrf
        <div class="page-content">
            <!--breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Gestions inscriptions</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="validationCustom04"
                        name="annee_scolaire_id">
                        @foreach ($AnneeScolaires as $AnneeScolaire)
                            <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} -
                                {{ $AnneeScolaire->annee2 }}</option>
                        @endforeach
                    </select>
                    @error('annee_scolaire_id')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Selectionnez la classe</label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"><i class='bx bx-search'></i>
                            </button>
                            <select class="form-select @error('classe_id') is-invalid  @enderror single-select"
                                id="inputGroupSelect04" name="classe_id" aria-label="Example select with button addon">
                                <option value="">Selectionnez la classe</option>
                                @foreach ($classes as $classes)
                                    <option value="{{ $classes->classe_id }}"> {{ $classes->classe_nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('classe_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="card border-top border-0 border-4 border-white">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                                </div>
                                <h5 class="mb-0 text-white"id="label2">Nouvel Etudiant</h5>
                                <h5 class="mb-0 text-white"id="label"> Ancienne Etudiant</h5>
                            </div>

                            <input onclick="t(0)" type="radio" name="colors" id="red"><span
                                style="font-size:20px;">Nouveau</span>
                            <input onclick="t(1)" type="radio" name="colors" id="blue"><span
                                style="font-size:20px;">Ancien </span>
                            <hr> <br>
                            <div class="row g-3">
                                <div id="inteligen">
                                    <select class="form-select single-select" id="inputGroupSelect03" onchange="send()"
                                        name="ecole_id">
                                        <option value="">Selectionnez l''etudiant</option>
                                        @foreach ($etudiants as $etudiant)
                                            <option value="{{ $etudiant }}"> {{ $etudiant->nom }}
                                                {{ $etudiant->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">

                                    <label for="inputLastName1" class="form-label">Nom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('nom') is-invalid  @enderror border-start-0"
                                            id="inputLastName1" name="nom" value="{{ old('nom') }}" placeholder="Nom" />
                                    </div>
                                    @error('nom')
                                        {{--  <div id="validationServer03Feedback" class="invalid-feedback">Please provide a valid city.</div>  --}}
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputLastName2" class="form-label">Prenom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('prenom') is-invalid  @enderror border-start-0"
                                            id="inputLastName2" name="prenom" value="{{ old('prenom') }}" placeholder="Prenom" />
                                    </div>
                                    @error('prenom')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date de Naissance</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-calendar'></i></span><input
                                            class="result form-control form-control @error('dateNaissance') is-invalid  @enderror"
                                            name="dateNaissance" value="{{ old('dateNaissance') }}" type="text" id="date"
                                            placeholder="Date de Naissance...">
                                    </div>
                                    @error('dateNaissance')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom03" class="form-label">Lieu de Naissance</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-map-pin'></i></span>
                                        <input type="text"
                                            class="form-control @error('LieuNaissance') is-invalid  @enderror"
                                            name="LieuNaissance" value="{{ old('LieuNaissance') }}" id="validationCustom03"
                                            placeholder="Lieu de Naissance...">
                                    </div>
                                    @error('LieuNaissance')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Sexe</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <select class="form-select mb-0 @error('sexe') is-invalid  @enderror"
                                            name="sexe" id="sexe" aria-label="Default select example">
                                            <option value=""> Sexe </option>
                                            <option value="H">Masculin</option>
                                            <option value="F">Feminin</option>
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
                                            class="form-control  @error('telephone') is-invalid  @enderror border-start-0"
                                            id="inputPhoneNo" name="telephone"  value="{{ old('telephone') }}" placeholder="Phone No" />
                                    </div>
                                    @error('telephone')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label"> Address Email</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-message'></i></span>
                                        <input type="text"
                                            class="form-control  @error('email') is-invalid  @enderror border-start-0"
                                            id="inputEmailAddress" name="email" value="{{ old('email') ?? request('email') }}" placeholder="example@gmail.com" />
                                    </div>
                                    @error('email')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Address</label>
                                    <textarea class="form-control" name="adresse" value="{{ old('adresse') }}" id="inputAddress3" placeholder="Enter Address" rows="2"></textarea>
                                    @error('adresse')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Photo</label><br><br>
                                    <input type="file" class="form-control" aria-label="file example" id="image"
                                        name="image" accept=".jpg, .png, image/jpeg, image/png" multiple
                                        style="text-align: center;">
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="col-md-6">

                    <label class="form-label">Date d''inscription</label>
                    <div class="input-group"> <span class="input-group-text"><i class='bx bxs-calendar'></i></span><input
                            class="result form-control form-control @error('date_insription') is-invalid  @enderror"
                            name="date_insription" value="{{ old('date_insription') }}" type="date" id="date" placeholder="Date de Naissance...">
                    </div>
                    @error('date_insription')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror


                    <br>
                    <div class="card border-top border-0 border-4 border-white">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                                </div>
                                <h5 class="mb-0 text-white" id="new">Nouveau Tuteur</h5>
                                <h5 class="mb-0 text-white" id="old">Ancien Tuteur</h5>
                            </div>

                            <input onclick="t(2)" type="radio" name="colors" id="black"><span
                                style="font-size:20px;">Nouveau</span>
                            <input onclick="t(3)" type="radio" name="colors" id="white"><span
                                style="font-size:20px;">Ancien </span>
                            <hr> <br>
                            <div class="row g-3">
                                <div id="fermer">
                                    <select class="form-select single-select" id="inputGroupSelectTuteur" onchange="sendTuteur()"
                                        name="ecole_id">
                                        <option value="">Selectionnez le tuteur</option>
                                        @foreach ($Tuteurss as $tuteur1)
                                            <option value="{{ $tuteur1 }}"> {{ $tuteur1->noms }}
                                                {{ $tuteur1->prenoms }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputLastName" class="form-label">Nom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('noms') is-invalid  @enderror border-start-0"
                                            id="inputLastNom" name="noms" value="{{ old('noms') }}" placeholder="Nom" />
                                    </div>
                                    @error('noms')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputLastName" class="form-label">Prenom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('prenoms') is-invalid  @enderror border-start-0"
                                            id="inputsecondName" name="prenoms" value="{{ old('prenoms') }}" placeholder="Prenom" />
                                    </div>
                                    @error('prenoms')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPhoneNo" class="form-label">Téléphone 1</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-microphone'></i></span>
                                        <input type="text"
                                            class="form-control  @error('telephone1') is-invalid  @enderror border-start-0"
                                            id="inputFirstPhone" name="telephone1" value="{{ old('telephone1') }}" placeholder="Phone No" />
                                    </div>
                                    @error('telephone1')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputPhoneNo" class="form-label">Téléphone 2</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-microphone'></i></span>
                                        <input type="text"
                                            class="form-control  @error('telephone2') is-invalid  @enderror border-start-0"
                                            id="inputsecondPhone" name="telephone2" value="{{ old('telephone2') }}" placeholder="Phone No" />
                                    </div>
                                    @error('telephone2')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label"> Address Email</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-message'></i></span>
                                        <input type="text"
                                            class="form-control  @error('emails') is-invalid  @enderror border-start-0"
                                            id="inputEmail" name="emails" value="{{ old('emails') }}" placeholder="example@gmail.com" />
                                    </div>
                                    @error('emails')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress" class="form-label">Address</label>
                                    <textarea class="form-control @error('adresses') is-invalid  @enderror" name="adresses" id="inputAddress" value="{{ old('adresses') }}"
                                        placeholder="Enter Address" rows="2"></textarea>
                                    @error('adresses')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <br>
                                    <label for="inputAddress3" class="form-label">Sexe</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <select class="form-select mb-0 @error('sex') is-invalid  @enderror"
                                            name="sex" aria-label="Default select example" id="sexeTuteur">
                                            <option value=""> Sexe </option>
                                            <option value="H">Masculin</option>
                                            <option value="F">Feminin</option>
                                        </select>
                                    </div>
                                    @error('sex')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                    <input type="hidden" id="inputhidden" name="etudiant_id">


                                    <input type="hidden" id="na" name="na">

                                    <input type="hidden" id="inputTuteur" name="tuteur_id">

                                    <input type="hidden" id="nw" name="nw">
                                    {{--  <input type="text" name="code" id="code" value="{{ $code }}" required>  --}}



                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-5" id="flash"
                        data-flash="{!! session()->get('success') !!}"><i class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                    <a href="{{ route('inscription') }}"> <button type="button" class="btn btn-danger px-5"
                            onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                </div>
            </div>
        </div>
    </form>

 <script>

        t(2)
        //Remplissage des inputs
        function send() {

            var n = document.getElementById("inputGroupSelect03").value
            var r = JSON.parse(n)
            document.getElementById('inputhidden').value = r.id
            document.getElementById('inputLastName1').value = r.nom
            document.getElementById('inputLastName2').value = r.prenom
            document.getElementById('date').value = r.dateNaissance
            document.getElementById('validationCustom03').value = r.LieuNaissance
            document.getElementById('sexe').value = r.sexe
            document.getElementById('inputPhoneNo').value = r.telephone
            document.getElementById('inputEmailAddress').value = r.email
            document.getElementById('inputAddress3').value = r.adresse
            document.getElementById('image').value = r.image

        }

        function sendTuteur() {

            var n = document.getElementById("inputGroupSelectTuteur").value
            var r = JSON.parse(n)
            document.getElementById('inputTuteur').value = r.id
            document.getElementById('inputLastNom').value = r.noms
            document.getElementById('inputsecondName').value = r.prenoms
            document.getElementById('inputFirstPhone').value = r.telephone1
            document.getElementById('inputsecondPhone').value = r.telephone2
            document.getElementById('inputEmail').value = r.emails
            document.getElementById('inputAddress').value = r.adresses
            document.getElementById('sexeTuteur').value = r.sex

        }

        function t(r) {
            if (r == 0) {

                let o = document.getElementById("inteligen")
                o.setAttribute("hidden", "hidden")
                document.getElementById('na').value = 'nouveau'
                document.getElementById('inputLastName1').value = ''
                document.getElementById('inputLastName2').value = ''
                document.getElementById('date').value = ''
                document.getElementById('validationCustom03').value = ''
                document.getElementById('sexe').value = ''
                document.getElementById('inputPhoneNo').value = ''
                document.getElementById('inputEmailAddress').value = ''
                document.getElementById('inputAddress3').value = ''
                document.getElementById("inputLastName1").readOnly = false;
                document.getElementById("inputLastName2").readOnly = false;
                document.getElementById("date").readOnly = false;
                document.getElementById("validationCustom03").readOnly = false;
                document.getElementById("sexe").readOnly = false;
                document.getElementById("inputPhoneNo").readOnly = false;
                document.getElementById("inputEmailAddress").readOnly = false;
                document.getElementById("inputAddress3").readOnly = false;
                document.getElementById("image").readOnly = false;

                document.getElementById("label").hidden = true;
                document.getElementById("label2").hidden = false;
                document.getElementById("inputhidden").hidden = true;
                document.getElementById("inputhidden2").hidden = false;

                document.getElementById("inputhidden5").hidden = false;
                document.getElementById("inputhidden6").hidden = false;



            } else if (r == 1) {

                let o = document.getElementById("inteligen")
                o.removeAttribute("hidden")
                document.getElementById('na').value = 'ancien'

                document.getElementById("inputLastName1").readOnly = true;
                document.getElementById("inputLastName2").readOnly = true;
                document.getElementById("date").readOnly = true;
                document.getElementById("validationCustom03").readOnly = true;
                document.getElementById("sexe").readOnly = true;
                document.getElementById("inputPhoneNo").readOnly = true;
                document.getElementById("inputEmailAddress").readOnly = true;
                document.getElementById("inputAddress3").readOnly = true;
                document.getElementById("image").readOnly = true;
                document.getElementById("label").hidden = false;
                document.getElementById("label2").hidden = true;
                document.getElementById("inputhidden").hidden = false;
                document.getElementById("inputhidden2").hidden = true;


                document.getElementById("inputhidden5").hidden = true;

                document.getElementById("inputhidden6").hidden = true;



            } else if (r == 2){
                let o = document.getElementById("fermer")
                o.setAttribute("hidden", "hidden")
                document.getElementById('nw').value = 'new'
                document.getElementById('inputLastNom').value = ''
                document.getElementById('inputsecondName').value = ''

                document.getElementById('inputFirstPhone').value = ''
                document.getElementById('inputsecondPhone').value = ''

                document.getElementById('inputEmail').value = ''
                document.getElementById('inputAddress').value = ''
                document.getElementById('sexeTuteur').value = ''

                document.getElementById("inputLastNom").readOnly = false;
                document.getElementById("inputsecondName").readOnly = false;
                document.getElementById("inputFirstPhone").readOnly = false;
                document.getElementById("inputsecondPhone").readOnly = false;
                document.getElementById("inputEmail").readOnly = false;
                document.getElementById("inputAddress").readOnly = false;
                document.getElementById("sexeTuteur").readOnly = false;


                document.getElementById("old").hidden = true;
                document.getElementById("new").hidden = false;
                document.getElementById("inputTuteur").hidden = true;
                document.getElementById("inputTuteur2").hidden = false;


                {{--  document.getElementById("inputhidden").hidden = true;

                document.getElementById("inputhidden5").hidden = false;
                document.getElementById("inputhidden6").hidden = false;  --}}



            } else {

                let o = document.getElementById("fermer")
                o.removeAttribute("hidden")
                document.getElementById('nw').value = 'old'

                document.getElementById("inputLastNom").readOnly = true;
                document.getElementById("inputsecondName").readOnly = true;
                document.getElementById("inputFirstPhone").readOnly = true;
                document.getElementById("inputsecondPhone").readOnly = true;
                document.getElementById("inputEmail").readOnly = true;
                document.getElementById("inputAddress").readOnly = true;
                document.getElementById("sexeTuteur").readOnly = true;


                document.getElementById("old").hidden = false;
                document.getElementById("new").hidden = true;
                document.getElementById("inputTuteur").hidden = false;
                document.getElementById("inputTuteur2").hidden = true;


                {{--  document.getElementById("inputhidden").hidden = false;
                document.getElementById("inputhidden2").hidden = true;


                document.getElementById("inputhidden5").hidden = true;

                document.getElementById("inputhidden6").hidden = true;  --}}
            }

    }
    </script>

    <script> t(0) </script>

@endsection
