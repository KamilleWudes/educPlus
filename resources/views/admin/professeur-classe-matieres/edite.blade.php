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
                        <li class="breadcrumb-item active" aria-current="page">Professeur - classe - matière</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
             
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <br> <br>
                <h6 class="mb-0 text-uppercase">Formulaire d'edition du professeur</h6>
                <hr />
                <div class="card">
                    <form class="row g-3" method="POST" action="{{ url('edition-professeur/' . $data->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="border p-3 rounded">
                                <div class="mb-3">
                                    <label class="form-label">Selectionnez la classe</label>
                                    <div class="input-group">
                                        <select class="single-select form-select  @error('classe_id') is-invalid  @enderror"
                                            name="classe_id">
                                            <option value="">Classe</option>
                                            @foreach ($classes as $classe)
                                                @if ($classe->id == $data->classe_id)
                                                    <option value="{{ $classe->id }}" selected>{{ $classe->nom }}
                                                    </option>
                                                @else
                                                    <option value="{{ $classe->id }}">{{ $classe->nom }} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-secondary" type="button"><i
                                                class='bx bx-search'></i>
                                        </button>

                                    </div>
                                    @error('classe_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Selectionnez la Matier</label>
                                    <div class="input-group">
                                        <select class="single-select form-select  @error('matier_id') is-invalid  @enderror"
                                            name="matier_id">
                                            <option value="">Matier</option>
                                            @foreach ($matieres as $matiere)
                                                @if ($matiere->id == $data->matier_id)
                                                    <option value="{{ $matiere->id }}" selected>{{ $matiere->nom }}
                                                    </option>
                                                @else
                                                    <option value="{{ $matiere->id }}">{{ $matiere->nom }} </option>
                                                @endif
                                            @endforeach


                                        </select>
                                        <button class="btn btn-outline-secondary" type="button"><i
                                                class='bx bx-search'></i>
                                        </button>

                                    </div>
                                    @error('matier_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Selectionnez le Professeur</label>
                                    <div class="input-group">
                                        <select
                                            class="single-select form-select  @error('professeur_id') is-invalid  @enderror"
                                            name="professeur_id">
                                            <option value="">Professeur</option>
                                            @foreach ($professeurs as $professeur)
                                                @if ($professeur->id == $data->professeur_id)
                                                    <option value="{{ $professeur->id }}" selected>{{ $professeur->nom }} {{ $professeur->prenom }} 
                                                    </option>
                                                @else
                                                    <option value="{{ $professeur->id }}">{{ $professeur->nom }} {{ $professeur->prenom }} </option>
                                                @endif
                                            @endforeach


                                        </select>
                                        <button class="btn btn-outline-secondary" type="button"><i
                                                class='bx bx-search'></i>
                                        </button>

                                    </div>
                                    @error('professeur_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror

                                </div>
                                <input type="hidden" name="ecole_id" value="{{ $data->ecole_id }}">

                                <input type="hidden" name="annee_scolaire_id" value="{{ $data->annee_scolaire_id }}">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary px-5" id="flash"
                                        data-flash="{!! session()->get('success') !!}"><i
                                            class="bx bx-check-circle mr-1"></i>Valider</button>
                                    <a href="{{ route('disposer') }}"> <button type="button"
                                            class="btn btn-danger px-5" onclick="error_noti()"><i
                                                class="bx bx-x-circle mr-1"></i> Annuler</button> </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <br> <br><br> <br><br>
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
