@extends('layouts/master')
@section('contenu')
    <div class="col-12" <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('saisi-note') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Relevée de Notes</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <select class="form-select single-select @error('annee_scolaire_id') is-invalid  @enderror"
                            id="annee-scolaire" name="annee_scolaire_id">
                            <option value="">Annee Scolaires </option>

                            @foreach ($anneeScolaires as $AnneeScolaire)
                                <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} -
                                    {{ $AnneeScolaire->annee2 }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="btn-group">
                        <select class="form-select single-select @error('type_trimestre_id') is-invalid  @enderror"
                            id="type-trimestre" name="type_trimestre_id">
                            <option value="">Type trimestre </option>

                            @foreach ($typesTrimestreInfos as $typeTrimestre)
                                <option value="{{ $typeTrimestre->id }}">{{ $typeTrimestre->nom }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="btn-group">
                        <select class="form-select single-select @error('classe_id') is-invalid  @enderror" id="classe"
                            name="classe_id">
                            <option value="">Classe</option>
                            {{-- @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                            @endforeach --}}

                        </select>
                    </div>

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 id="typeTrimestreChoisie" class="mb-0 text-uppercase">Relevées de Notes</h6><br>
            <h6 id="classeChoisie" class="mb-0 text-uppercase"></h6>

            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>

                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Etudiant</th>
                                    <th style="text-align:center">Relevée de Notes</th>
                                </tr>
                            </thead>
                            <tbody id="etudNote">


                                <input type="hidden" name="trimestre" id="ee">


                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('releveNote')
    <script>
        // Désactivez tous les sélecteurs sauf l'année scolaire

        $('select').not('#annee-scolaire').prop('disabled', true);

        // Gestionnaire d'événements pour le changement d'année scolaire
        $('select#annee-scolaire').change(function() {
            // Réactivez le sélecteur de type trimestre et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre').prop('disabled', true);
            $('select#type-trimestre').prop('disabled', false);
        });

        // Gestionnaire d'événements pour le changement de type trimestre
        $('select#type-trimestre').change(function() {
            // Réactivez le sélecteur de type composition et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #classe').prop('disabled', true);
            $('select#classe').prop('disabled', false);
        });


        // Gestionnaire d'événements pour le changement de la classe
        $('select#classe').change(function() {
            // Réactivez le sélecteur de classe et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #classe').prop(
                'disabled', true);
            {{-- $('select#matiere').prop('disabled', false); --}}
        });
        $(document).ready(function() {
            console.log("hello note");

            $('#anneeScolaire,#type-trimestre,#classe').on("change", function() {
                var anneeScolaire = $('#annee-scolaire').val();
                var typeTrimestre = $('#type-trimestre').val();
                var classe = $('#classe').val();

                console.log('anneeScolaire', anneeScolaire);
                console.log('typeTrimestre', typeTrimestre);
                console.log('classe', classe);

                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetProfReleve') }}',
                    datatype: 'JSON',
                    data: {
                        annee_scolaire: anneeScolaire,
                        type_trimestre: typeTrimestre,
                        classe: classe,
                    },
                    success: (response) => {
                        typeTrimestreChoisie = response.typeTrimestreChoisie
                        classes = response.classes
                        inscri = response.Notes
                        console.log('avec filtre', inscri);

                        var NoteEtude = ''

                        for (let resp of inscri) {

                            NoteEtude +=

                                `<tr>

                              <td style="text-align:center">${ resp.matricule} </td>
                              <td style="text-align:center">${ resp.nom}  ${ resp.prenom} </td>
                                   <td style="text-align:center">
                ${resp.id ? `<a href="bulletin-pdf=${resp.id}?trimestre=${typeTrimestre}&anneeScolaire=${anneeScolaire}">
                        <button type="button" class="btn btn-light btn-sm radius-30 px-4" id="flash" data-flash="{!! session()->get('success') !!}">Voir Bulletin</button>
                    </a>` : 'ID non disponible'}
            </td>
                                        
                            </tr>`


                        }

                        var classe = '';

                        for (var i = 0; i < response.classes.length; i++) {
                            classe += '<option  value=""></option>';

                            classe += '<option  value="' + response.classes[i].id +
                                '">' +
                                response.classes[i].nom + '</option>';
                        }

                        if (response.classes.length > 0) {
                            $('#classe').html(classe);
                            $('#etudNote').html(NoteEtude);

                            $('#ee').val(typeTrimestre);


                            $('#typeTrimestreChoisie').html(
                                `<h6 class="mb-0 text-upercase">Relevées de Notes : ${response.typeTrimestreChoisie ? response.typeTrimestreChoisie : ''}</h6>`
                            );
                            $('#classeChoisie').html(
                                `<h6 class="mb-0 text-upercase">Classe : ${response.classeChoisie ? response.classeChoisie : ''}</h6>`
                            );

                        } else {
                            $('#classe').html('');
                            $('#etudNote').html('');
                            $('#typeTrimestreChoisie').html('');
                            $('#classeChoisie').html('');  


                        }

                    },

                })
            })
        });
    </script>
@endpush

@push("validate")
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
