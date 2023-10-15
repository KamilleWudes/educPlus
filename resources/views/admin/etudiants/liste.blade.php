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
                            <li class="breadcrumb-item active" aria-current="page">Etudiants</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="idetud"
                        name="annee_scolaire_id">
                        <option value="">Annee Scolaires </option>

                        @foreach ($anneeScolaires as $AnneeScolaire)
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
            <h6 class="mb-0 text-uppercase">Listes des Etudiants</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    {{--  <th style="text-align:center">Index</th>  --}}
                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Nom</th>
                                    <th style="text-align:center">Sexe</th>
                                    <th style="text-align:center">Classe</th>
                                    <th style="text-align:center">Tuteur etudiant</th>
                                    <th style="text-align:center">Adresse</th>
                                    <th style="text-align:center">Détail</th>
                                    {{-- <th style="text-align:center">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody id="etud">
                                @foreach ($etudiants as $etudiant)
                                    <tr>
                                        {{--  <td style="text-align:center">{{$loop->index+1}}</td>  --}}
                                        <td style="text-align:center">{{ $etudiant->matricule }}</td>
                                        <td style="text-align:center">{{ $etudiant->etudiant_prenom }}
                                            {{ $etudiant->etudiant_nom }}</td>
                                        <td style="text-align:center">{{ $etudiant->sexe }}
                                            
                                        </td>
                                        <td style="text-align:center">{{ $etudiant->classe_nom }}</td>
                                        <td style="text-align:center">{{ $etudiant->tuteur_prenoms }}
                                            {{ $etudiant->tuteur_nom }}</td>

                                        <td style="text-align:center">{{ $etudiant->etudiant_adresse }}</td>

                                        <td style="text-align:center"><a
                                                href="{{ url('detail-etudiant=' . $etudiant->id) }}"><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('etude')
    <script>
        $(document).ready(function() {
            console.log("hello word");
            $('#idetud').on("change", function() {
                var classe_id = $('#idetud').val();
                console.log(classe_id);
                $.ajax({
                    type: 'GET',
                    url: '{{ route('Getetude') }}',
                    datatype: 'JSON',
                    data: {
                        etudiant: classe_id
                    },
                    success: (response) => {
                        console.log("matiere", response.etudiants)
                        inscri = response.etudiants
                        console.log('avec filtre', inscri);
                        //inscri = inscri.filter(d => d.annee == classe_id)

                        var etud = ''

                        for (let resp of inscri) {

                            etud += `<tr>
                          <td style="text-align:center"> ${ resp.matricule} </td>
                          <td style="text-align:center">${ resp.etudiant_prenom} ${ resp.etudiant_nom}</td>
                          <td style="text-align:center">${ resp.etudiant_sexe} </td>
                            <td style="text-align:center">${ resp.classe_nom}</td>
                            <td style="text-align:center">${ resp.tuteur_prenoms} ${ resp.tuteur_nom}</td>
                            <td style="text-align:center">${ resp.etudiant_adresse}</td>

                                     <td style="text-align:center"><a
                                                href="{{ url('detail-etudiant=') }}${resp.id}"><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a>
                                        </td>
                                    

                        </tr>`

                        }

                        if (response.etudiants.length > 0) {

                            $('#etud').html(etud);
                            // console.log('tt',$('#ins').val())

                        } else {
                            $('#ins').html('');

                        }

                    },

                })
            })
        });
    </script>
@endpush
