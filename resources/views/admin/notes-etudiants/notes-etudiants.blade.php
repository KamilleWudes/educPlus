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
                            <li class="breadcrumb-item active" aria-current="page">Saisie de notes</li>
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
                        <select class="form-select single-select @error('classe_id') is-invalid  @enderror" id="professeur"
                            name="prof_id">
                            <option value="">Professeur</option>
                            @foreach ($professeurs as $professeur)
                                <option value="{{ $professeur->id }}">{{ $professeur->nom }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="btn-group">
                        <select class="form-select single-select @error('classe_id') is-invalid  @enderror" id="classe"
                            name="classe_id">
                            <option value="">Classe</option>

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
            <h6 class="mb-0 text-uppercase">Listes des Notes</h6>
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
                                    <th style="text-align:center">Détail</th>
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
            $('select#professeur').prop('disabled', false);
        });
         // Gestionnaire d'événements pour le changement de la classe
        $('select#professeur').change(function() {
            // Réactivez le sélecteur de classe et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #type-composition, #professeur').prop(
                'disabled', true);
            $('select#classe').prop('disabled', false);
        }); 

        // Gestionnaire d'événements pour le changement de la classe
        $('select#classe').change(function() {
            // Réactivez le sélecteur de classe et désactivez les autres
            $('select').not('#annee-scolaire, #type-trimestre, #type-composition,#professeur, #classe, #matiere').prop(
                'disabled', true);
            $('select#matiere').prop('disabled', false);
        }); 

        $(document).ready(function() {
            console.log("hello note");
            $('#anneeScolaire, #typeTrimestre, #typeComposition,#professeur, #classe, #matiere').on("change", function() {
                var anneeScolaire = $('#annee-scolaire').val();
                var typeTrimestre = $('#type-trimestre').val();
                var typeComposition = $('#type-composition').val(); 
                var professeur = $('#professeur').val();
                var classe = $('#classe').val();
                var matiere = $('#matiere').val();

                console.log('anneeScolaire', anneeScolaire);
                console.log('typeTrimestre', typeTrimestre);
                console.log('typeComposition', typeComposition);
                console.log('professeur', professeur);
                console.log('classe', classe);
                console.log('matiere', matiere);


                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetClassprof') }}',
                    datatype: 'JSON',
                    data: {
                        annee_scolaire: anneeScolaire,
                        type_trimestre: typeTrimestre,
                        type_composition: typeComposition,
                        professeur: professeur,
                        classe: classe,
                        matiere: matiere,
                    },
                    success: (response) => {
                        console.log("classes", response.classes)
                        console.log("matieres", response.matieres)

                        inscri = response.Notes
                        console.log('avec filtre', inscri);
                        //inscri = inscri.filter(d => d.annee == classe_id)

                        var NoteEtude = ''

                        for (let resp of inscri) {

                            NoteEtude += `<tr>
                              <td style="text-align:center">${ resp.matricule} </td>
                              <td style="text-align:center">${ resp.prenom_etudiant} ${ resp.nom_etudiant}</td>
                              <td style="text-align:center">${ resp.note} </td>
                                   <td style="text-align:center"><a
                                                href=""><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a>
                                        </td>
                            </tr>`

                        }

                        var classe = '';
                        var matiere = '';

                        // select classes
                        for (var i = 0; i < response.classes.length; i++) {
                            classe += '<option  value=""></option>';

                            classe += '<option  value="' + response.classes[i].id + '">' +
                                response.classes[i].nom + '</option>';
                        }
                           // select matieres
                        for (var i = 0; i < response.matieres.length; i++) {
                            matiere += '<option  value=""></option>';

                            matiere += '<option  value="' + response.matieres[i].id + '">' +
                                response.matieres[i].nom + '</option>';
                        }

                        if (response.classes.length > 0) {
                            $('#classe').html(classe);
                            $('#matiere').html(matiere);
                            $('#etudNote').html(NoteEtude);

                            //$('#etudNote').html(NoteEtude);
                            // console.log('tt',$('#ins').val())

                        } else {
                            $('#classe').html('');
                            $('#matiere').html('');
                            $('#etudNote').html('');


                        }

                    },

                })
            })
        });
    </script>
@endpush
