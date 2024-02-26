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
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Notes Etudiants</li>
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
                        <select class="form-select single-select @error('annee_scolaire_id') is-invalid  @enderror"
                            id="type-trimestre" name="annee_scolaire_id">
                            <option value="">Type trimestre </option>

                            @foreach ($typesTrimestreInfos as $typeTrimestre)
                                <option value="{{ $typeTrimestre->id }}">{{ $typeTrimestre->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="btn-group">
                        <select class="form-select single-select @error('annee_scolaire_id') is-invalid  @enderror"
                            id="type-composition" name="annee_scolaire_id">
                            <option value="">Type Composition </option>

                            @foreach ($typeCompositions as $typeComposition)
                                <option value="{{ $typeComposition->id }}">{{ $typeComposition->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="btn-group">
                        <select class="form-select single-select @error('classe_id') is-invalid  @enderror" id="classe"
                            name="classe_id">
                            <option value="">Classe</option>


                        </select>
                    </div>

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 id="typeCompositionChoisie" class="mb-0 text-uppercase">Listes des Notes Etudiants </h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Matières</th>
                                    <th style="text-align:center">Notes</th>
                                    <th style="text-align:center">Coefficients</th>
                                    <th style="text-align:center">Note définitives</th>
                                    <th style="text-align:center">Appreciations</th>
                                </tr>
                            </thead>
                            <tbody id="etudNote">


                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('NoteEtudiant')
    <script>
        // Désactivez tous les sélecteurs sauf l'année scolaire

        $('select').not('#annee-scolaire').prop('disabled', true);

        // Gestionnaire d'événements pour le changement d'année scolaire
        $('select#annee-scolaire').change(function() {
            // Réactivez le sélecteur de type trimestre et désactivez les autres
            $('select').not('#annee-scolaire, #type_trimestre').prop('disabled', true);
            $('select#type-trimestre').prop('disabled', false);
        });

        // Gestionnaire d'événements pour le changement de type trimestre
        $('select#type-trimestre').change(function() {
            // Réactivez le sélecteur de type composition et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #type-composition').prop('disabled', true);
            $('select#type-composition').prop('disabled', false);
        });

        // Gestionnaire d'événements pour le changement de type composition
        $('select#type-composition').change(function() {
            // Réactivez le sélecteur de classe et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #type-composition, #classe').prop('disabled', true);
            $('select#classe').prop('disabled', false);
        });

        // Gestionnaire d'événements pour le changement de la classe
        $('select#classe').change(function() {
            // Réactivez le sélecteur de classe et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #type-composition, #classe, #matiere').prop(
                'disabled', true);
            {{-- $('select#matiere').prop('disabled', false); --}}
        });


        $(document).ready(function() {
            console.log("hello note");
            $('#anneeScolaire, #typeTrimestre, #type-composition, #classe').on("change", function() {
                var anneeScolaire = $('#annee-scolaire').val();
                var typeTrimestre = $('#type-trimestre').val();
                var typeComposition = $('#type-composition').val();
                var classe = $('#classe').val();


                console.log('anneeScolaire', anneeScolaire);
                console.log('typeTrimestre', typeTrimestre);
                console.log('typeComposition', typeComposition);
                console.log('classe', classe);


                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetNotesEtudiant') }}',
                    datatype: 'JSON',
                    data: {
                        annee_scolaire: anneeScolaire,
                        type_trimestre: typeTrimestre,
                        type_composition: typeComposition,
                        classe: classe,

                    },
                    success: (response) => {
                        console.log("classesEtudiant", response.classesEtudiant)
                        console.log("typeCompositionChoisie", response.typeCompositionChoisie)
                        inscri = response.matieresEtudiant
                        console.log('avec filtre', inscri);
                        //inscri = inscri.filter(d => d.annee == classe_id)

                        var NoteEtude = ''

                        for (let resp of inscri) {

                            NoteEtude += `<tr>

                              <td style="text-align:center">${ resp.nom_matiere} </td> 
                              <td style="text-align:center">${ resp.note} </td>
                              <td style="text-align:center">${ resp.coefficient} </td>
                              <td style="text-align:center">${ resp.note_coefficient} </td>
                              <td style="text-align:center">${ resp.appreciation} </td>


                            </tr>`

                        }

                        var classe = '';

                        for (var i = 0; i < response.classesEtudiant.length; i++) {
                            classe += '<option  value=""></option>';

                            classe += '<option  value="' + response.classesEtudiant[i].id +
                                '">' +
                                response.classesEtudiant[i].nom + '</option>';
                        }

                        if (response.classesEtudiant.length > 0) {
                            $('#classe').html(classe);
                            $('#etudNote').html(NoteEtude);

                            $('#typeCompositionChoisie').html(
                                `<h6 class="mb-0 text-uppercase">Listes des Notes Etudiants : ${response.typeCompositionChoisie ? response.typeCompositionChoisie : ''}</h6>`
                            );

                        } else {
                            $('#classe').html('');
                            $('#etudNote').html('');
                            $('#typeCompositionChoisie').html('');




                        }

                    },

                })
            })
        });
    </script>
@endpush
