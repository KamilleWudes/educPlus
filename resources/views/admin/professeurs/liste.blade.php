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
                            <li class="breadcrumb-item active" aria-current="page">Liste Professeur</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="ms-auto">
                        <label for="validationCustom04" class="form-label">Année scolaire</label>
                        <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="idProf"
                            name="annee_scolaire_id">
                            <option value="">Annee Scolaires </option>
                            @foreach ($anneesScolairesEcole as $AnneeScolaire)
                                <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} -
                                    {{ $AnneeScolaire->annee2 }}</option>
                            @endforeach
                        </select>
                        @error('annee_scolaire_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Listes des Professeurs</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Nom</th>
                                    <th style="text-align:center">Sexe</th>
                                    <th style="text-align:center">Télephone</th>

                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>

                            <tbody id="proff">
                                @foreach ($professeurs as $professeur)
                                    <tr>
                                        <td style="text-align:center">{{ $professeur->matricule }}</td>

                                        <td style="text-align:center">{{ $professeur->prenom }} {{ $professeur->nom }}</td>
                                        <td style="text-align:center">
                                            @if ($professeur->sexe == 'H')
                                                H
                                            @else
                                                F
                                            @endif
                                        </td>
                                        {{--  <input type="hidden" class="serdelete_val_id" value={{ $professeur->id }}>  --}}
                                        <td style="text-align:center">{{ $professeur->telephone1 }}</td>

                                        <td style="text-align:center"><a
                                                href="{{ url('detail=' . $professeur->id) }}"><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a>
                                        </td>
                                        <td>
                                        <div class="d-flex order-actions d-flex justify-content-center">
                                            <a href="{{ url('professeur='.$professeur->id) }}" class=""><i class='bx bxs-edit'
                                                    style="text-align:center"></i></a>
                                            <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'
                                                    style="text-align:center"></i></a>
                                        </div>

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

@push('professeur')
    <script>
        $(document).ready(function() {
            console.log("hello judde");
            $('#idProf').on("change", function() {
                var classe_id = $('#idProf').val();
                console.log('val', classe_id);
                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetProf') }}',
                    datatype: 'JSON',
                    data: {
                        professeur: classe_id
                    },
                    success: (response) => {
                        console.log("matiere", response.professeurs)
                        inscri = response.professeurs
                        console.log('avec filtre', inscri);
                        //inscri = inscri.filter(d => d.annee == classe_id)

                        var professeur = ''

                        for (let resp of inscri) {

                            professeur += `<tr>
                              <td style="text-align:center">${ resp.matricule} </td>
                              <td style="text-align:center">${ resp.prenom} ${ resp.nom}</td>
                              <td style="text-align:center">${ resp.sexe} </td>
                              <td style="text-align:center">${ resp.telephone1}</td>
                                   <td style="text-align:center"><a
                                                href="{{ url('detail=') }}${resp.id}"><button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a>
                                        </td>
                                    <td style="text-align:center">
                                                <button type="button"
                                                    class="btn btn-light btn-sm radius-30 px-4" disabled="true">Action</button>
                                        </td>

                            </tr>`

                        }

                        if (response.professeurs.length > 0) {

                            $('#proff').html(professeur);
                            // console.log('tt',$('#ins').val())

                        } else {
                            $('#proff').html('');

                        }

                    },

                })
            })
        });
    </script>
@endpush
