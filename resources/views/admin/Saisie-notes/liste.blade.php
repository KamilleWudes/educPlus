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
                            <li class="breadcrumb-item active" aria-current="page">Liste des notes</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <select class="form-select single-select @error('annee_scolaire_id') is-invalid  @enderror"
                            id="annee-scolaire" name="annee_scolaire_id">
                            <option value="">Année Scolaire </option>

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

                            @foreach ($typesTrimestres as $typeTrimestre)
                                <option value="{{ $typeTrimestre->id }}">{{ $typeTrimestre->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="btn-group">
                        <select class="form-select single-select @error('type_compo_id') is-invalid  @enderror"
                            id="type-composition" name="type_compo_id">
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
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="btn-group">
                        <select class="form-select single-select single-select @error('matier_id') is-invalid  @enderror"
                            name="matier_id" id="matiere">
                            <option value="">Matier</option>

                        </select>
                    </div>

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 id="matiereChoisie" class="mb-0 text-uppercase">Listes des Notes</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Etudiant</th>
                                    <th style="text-align:center">Note</th>
                                    <th style="text-align:center">Note définitive</th>
                                    <th style="text-align:center">Appreciations</th>
                                    <th style="text-align:center">Edition Note</th>



                                </tr>
                            </thead>
                            <tbody id="etudNote">
                                <p id="coef"></p>



                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('saisieNote')
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
            $('select#matiere').prop('disabled', false);
        });

        $(document).ready(function() {
            console.log("hello note");
            $('#anneeScolaire, #typeTrimestre, #typeComposition, #classe, #matiere').on("change", function() {
                var anneeScolaire = $('#annee-scolaire').val();
                var typeTrimestre = $('#type-trimestre').val();
                var typeComposition = $('#type-composition').val();
                var classe = $('#classe').val();
                var matiere = $('#matiere').val();

                console.log('anneeScolaire', anneeScolaire);
                console.log('typeTrimestre', typeTrimestre);
                console.log('typeComposition', typeComposition);
                console.log('classe', classe);
                console.log('matiere', matiere);


                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetNotesEtude') }}',
                    datatype: 'JSON',
                    data: {
                        annee_scolaire: anneeScolaire,
                        type_trimestre: typeTrimestre,
                        type_composition: typeComposition,
                        classe: classe,
                        matiere: matiere,
                    },
                    success: (response) => {
                        console.log("matieres", response.matieres)
                        console.log("coefficientMatiere", response.coefficientMatiere)
                        console.log("matiereChoisie", response.matiereChoisie)
                        inscri = response.Notes
                        console.log('avec filtre', inscri);
                        //inscri = inscri.filter(d => d.annee == classe_id)

                        var NoteEtude = ''

                        for (let resp of inscri) {

                            NoteEtude += `<tr>

                              <td style="text-align:center">${ resp.matricule} </td> 
                              <td style="text-align:center">${ resp.nom_etudiant}  ${ resp.prenom_etudiant} </td>
                              <td style="text-align:center">${ resp.note} </td>
                              <td style="text-align:center">${ resp.note_coefficient} </td>
                              <td style="text-align:center">${ resp.appreciation} </td>
                              <td style="text-align:center"><a
                                                href="{{ url('edit_note=') }}${resp.id}"><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4">Edition Note</button></a>
                                        </td>


                            </tr>`

                        }

                        var matiere = '';

                        for (var i = 0; i < response.matieres.length; i++) {
                            matiere += '<option  value=""></option>';

                            matiere += '<option  value="' + response.matieres[i].id + '">' +
                                response.matieres[i].nom + '</option>';
                        }

                        if (response.matieres.length > 0) {
                            $('#matiere').html(matiere);
                            $('#etudNote').html(NoteEtude);
                            $('#coef').html(
                                `<h5 class="mb-0">coefficient : ${response.coefficientMatiere}</h5>`
                            );
                            $('#matiereChoisie').html(
                                `<h6 class="mb-0">Listes des Notes : ${response.matiereChoisie ? response.matiereChoisie : ''}</h6>`
                            );

                        } else {
                            $('#matiere').html('');
                            $('#etudNote').html('');
                            $('#coef').html('');
                            $('#matiereChoisie').html('');




                        }

                    },

                })
            })
        });
    </script>
@endpush
