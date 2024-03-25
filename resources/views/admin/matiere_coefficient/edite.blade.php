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
                        <li class="breadcrumb-item active" aria-current="page">Matière et coefficient</li>
                    </ol>
                </nav>
            </div>
            <
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <br> <br>
                <h6 class="mb-0 text-uppercase">Formulaire d'edition du coefficient</h6>
                <hr />
                <div class="card">
                    <form class="row g-3" method="POST" action="{{ url('matiere_coefficient/' . $data->id) }}" id="ecoleForm">
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
                                <label class="form-label">Coefficient</label>
                                <input class="form-control @error('coefficient') is-invalid  @enderror mb-3" type="text"
                                    value="{{ $data->coefficient }}" placeholder="Coefficient" name="coefficient"
                                    aria-label="default input example">
                                @error('coefficient')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                                <input type="hidden" name="annee_scolaire_id" value="{{ $data->annee_scolaire_id }}">
            <input type="hidden" name="ecole_id" value="{{ EcolesId() }}">

                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary px-5" id="flash"
                                        data-flash="{!! session()->get('success') !!}"><i
                                            class="bx bx-check-circle mr-1"></i>Valider</button>
                                    <a href="{{ route('matiere_coefficient') }}"> <button type="button"
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
              
            });
        }
    </script>
@endpush
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
