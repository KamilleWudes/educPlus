@extends('layouts/master')
@section('contenu')
    <form class="row g-3" method="POST" action="{{ url('update_inscription/' . $inscriptions->id) }}",
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                Edition inscription</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="validationCustom04"
                        name="annee_scolaire_id">
                        @foreach ($AnneeScolaires as $AnneeScolaire)
                            @if ($AnneeScolaire->id == $inscriptions->annee_scolaire_id)
                                <option value="{{ $AnneeScolaire->id }}" selected>{{ $AnneeScolaire->annee1 }} - {{ $AnneeScolaire->annee2 }} </option>
                            @else
                                <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} - {{ $AnneeScolaire->annee2 }} </option>
                            @endif
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
                                @foreach ($classes as $classe)
                                @if ($classe->id == $inscriptions->classe_id)
                                    <option value="{{ $classe->id }}" selected>{{ $classe->nom }} </option>
                                @else
                                    <option value="{{ $classe->id }}">{{ $classe->nom }} </option>
                                @endif
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
                                <h5 class="mb-0 text-white">Edition Etudiant </h5>
                                {{--  <h5 class="mb-0 text-white"id="label"> Ancienne Etudiant</h5>  --}}
                            </div>
                            {{--  <h5 class="mb-0 text-white"id="label"> Edition Etudiant</h5>  --}}


                            {{--  <input onclick="t(0)" type="radio" name="colors" id="red"><span
                                style="font-size:20px;">Nouveau</span>
                            <input onclick="t(1)" type="radio" name="colors" id="blue"><span
                                style="font-size:20px;">Ancien </span>  --}}
                            <hr> <br>
                            <div class="row g-3">

                                {{--  <select class="form-select @error('ecole_id') is-invalid  @enderror single-select"
                                    id="inputGroupSelect03" onchange="send()" name="ecole_id"
                                    aria-label="Example select with button addon">
                                    <option value="">Selectionnez l''etudiant</option>
                                    @foreach ($etudiants as $etudiant)
                                        <option value="{{ $etudiant }}"> {{ $etudiant->nom }} {{ $etudiant->prenom }}
                                        </option>
                                    @endforeach
                                </select>  --}}

                                <div class="col-md-6">


                                    <label for="inputLastName1" class="form-label">Nom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('nom') is-invalid  @enderror border-start-0"
                                            id="inputLastName1" name="nom" value="{{ $inscriptions->etudiant->nom }}" placeholder="Nom" />
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
                                            class="form-control @error('prenom') is-invalid  @enderror border-start-0" value="{{ $inscriptions->etudiant->prenom }}"
                                            id="inputLastName2" name="prenom" placeholder="Prenom" />
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
                                            name="dateNaissance" type="text" id="date" value="{{ $inscriptions->etudiant->dateNaissance }}"
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
                                            class="form-control @error('LieuNaissance') is-invalid  @enderror" value="{{ $inscriptions->etudiant->LieuNaissance }}"
                                            name="LieuNaissance" id="validationCustom03" placeholder="Lieu de Naissance...">
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
                                            name="sexe" id="sexe" aria-label="Default select example"
                                            id="sexe">

                                            <option value="H"{{$inscriptions->etudiant->sexe == "1" ? 'selected' : '' }}>homme</option>
                                        <option value="F"{{ $inscriptions->etudiant->sexe == "0" ? 'selected' : '' }}>Femme</option>
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
                                            class="form-control  @error('telephone') is-invalid  @enderror border-start-0" value="{{ $inscriptions->etudiant->telephone }}"
                                            id="inputPhoneNo" name="telephone" placeholder="Phone No" />
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
                                            class="form-control  @error('email') is-invalid  @enderror border-start-0" value="{{ $inscriptions->etudiant->email }}"
                                            id="inputEmailAddress" name="email" placeholder="example@gmail.com" />
                                    </div>
                                    @error('email')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Address</label>
                                    <textarea class="form-control" name="adresse" id="inputAddress3"  value="{{ $inscriptions->etudiant->adresse }}" placeholder="Enter Address" rows="2"></textarea>
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
                            {{--  <input type="text"
                                class="form-control @error('etudiant_id') is-invalid  @enderror border-start-0"
                                id="inputLastName22" name="etudiant_id" />  --}}

                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    {{--  <label class="form-label"> Date d''inscription</label>
                    <input type="text" class="form-control @error('date_insription') is-invalid @enderror datepicker"
                        name="date_insription" />
                    @error('date_insription')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror  --}}
                    <label class="form-label">Date d''inscription</label>
                    <div class="input-group"> <span class="input-group-text"><i class='bx bxs-calendar'></i></span><input
                            class="result form-control form-control @error('date_insription') is-invalid  @enderror"
                            name="date_insription" type="date" id="date" placeholder="Date de Naissance..." value="{{ $inscriptions->date_insription }}">
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
                                <h5 class="mb-0 text-white">Edition Tuteur</h5>
                            </div>
                            <hr>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="inputLastName1" class="form-label">Nom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('noms') is-invalid  @enderror border-start-0"
                                            id="inputLastName1" name="noms" value="{{ $inscriptions->tuteur->noms }}" placeholder="Nom" />
                                    </div>
                                    @error('noms')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputLastName2" class="form-label">Prenom</label>
                                    <div class="input-group"> <span class="input-group-text"><i
                                                class='bx bxs-user'></i></span>
                                        <input type="text"
                                            class="form-control @error('prenoms') is-invalid  @enderror border-start-0"
                                            id="inputLastName2" name="prenoms" value="{{ $inscriptions->tuteur->prenoms}}" placeholder="Prenom" />
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
                                            id="inputPhoneNo" name="telephone1" value="{{ $inscriptions->tuteur->telephone1 }}" placeholder="Phone No" />
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
                                            id="inputPhoneNo" name="telephone2" value="{{ $inscriptions->tuteur->telephone2 }}" placeholder="Phone No" />
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
                                            class="form-control  @error('emails') is-invalid  @enderror border-start-0" value="{{ $inscriptions->tuteur->emails }}"
                                            id="inputEmailAddress" name="emails" placeholder="example@gmail.com" />
                                    </div>
                                    @error('emails')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inputAddress3" class="form-label">Address</label>
                                    <textarea class="form-control @error('adresses') is-invalid  @enderror" name="adresses" value="{{$inscriptions->tuteur->adresses  }}" id="inputAddress3"
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
                                            name="sex" aria-label="Default select example">
                                            <option value="H"{{ $inscriptions->tuteur->sexe == "1" ? 'selected' : '' }}>homme</option>
                                            <option value="F"{{ $inscriptions->tuteur->sexe == "0" ? 'selected' : '' }}>Femme</option>
                                        </select>
                                    </div>
                                    @error('sex')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <input type="hidden" id="inputhidden2" name="etudiant_id" value="{{ $inscriptions->etudiant_id }}"> 
                                <input type="hidden" name="tuteur_id" value="{{ $inscriptions->tuteur_id }}">

                            </div>
                        </div>
                    </div> <br>
                    <button type="submit" class="btn btn-primary px-5" id="flash"
                        data-flash="{!! session()->get('success') !!}"><i class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                    <a href="{{ route('inscription') }}"> <button type="button" class="btn btn-danger px-5"
                            onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                </div>
            </div>
        </div>
    </form>


@endsection
@push('validate')
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