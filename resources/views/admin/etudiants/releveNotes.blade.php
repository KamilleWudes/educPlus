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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
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
                        <select class="form-select single-select @error('annee_scolaire_id') is-invalid  @enderror"
                            id="type-trimestre" name="annee_scolaire_id">
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
                           

                        </select>
                    </div>

                </div>
            </div>
            <!--end breadcrumb-->
            <h6  id="typeTrimestreChoisie" class="mb-0 text-uppercase">Relevées de Notes</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Etudiant</th>
                                    <th style="text-align:center">Voir bulettin</th>
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

@push('releveNote')
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
            $('#anneeScolaire, #type-trimestre, #classe').on("change", function() {
                var anneeScolaire = $('#annee-scolaire').val();
                var typeTrimestre = $('#type-trimestre').val();
                var classe = $('#classe').val();

                console.log('anneeScolaire', anneeScolaire);
                console.log('typeTrimestre', typeTrimestre);
                console.log('classe', classe);

                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetReleve') }}',
                    datatype: 'JSON',
                    data: {
                        annee_scolaire: anneeScolaire,
                        type_trimestre: typeTrimestre,
                        classe: classe,
                    },
                    success: (response) => {
                        classes = response.classes
                        inscri = response.Notes
                        console.log('avec filtre', inscri);

                        var NoteEtude = ''

                        for (let resp of inscri) {

                            NoteEtude += `<tr>
                              <td style="text-align:center">${ resp.matricule} </td>
                              <td style="text-align:center">${ resp.prenom} ${ resp.nom}</td>
                                    <td style="text-align:center"><a
                                                href="Releve-pdf=${ resp.id}"><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4">Voir Bulletin</button></a>
                                        </td> 
                            </tr>`

                        }

                       // $('#etudNote').html(NoteEtude);

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

                            $('#typeTrimestreChoisie').html(
                                `<h6  class="mb-0 text-upercase">Relevées de Notes du  ${response.typeTrimestreChoisie}</h6>`
                            );

                        } else {
                            $('#classe').html('');
                            $('#etudNote').html('');
                            $('#typeTrimestreChoisie').html('');




                        }

                    },

                })
            })
        });
    </script>
@endpush
