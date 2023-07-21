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
                            <li class="breadcrumb-item active" aria-current="page">Tuteurs</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select" id="idtut" name="annee_scolaire_id">
                        <option value="">Annee Scolaires </option>

                        @foreach ($anneeScolaires as $AnneeScolaire)
                            <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} - {{ $AnneeScolaire->annee2 }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Listes des Tuteurs</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th style="text-align:center">Numero</th> --}}
                                    <th style="text-align:center">Nom Tuteur</th>
                                    <th style="text-align:center">Sexe</th>
                                    <th style="text-align:center">Adresse</th>
                                    <th style="text-align:center">Nom etudiant</th>
                                    <th style="text-align:center">Détail</th>
                                    {{-- <th style="text-align:center">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody id="tut">

                                @foreach ($tuteurs as $tuteur)
                                    <tr>
                                        {{-- <td style="text-align:center">{{ $tuteur->tuteurs_id }}</td> --}}
                                        <td style="text-align:center">{{ $tuteur->prenoms }} {{ $tuteur->noms }}</td>
                                        <td style="text-align:center">
                                            @if ($tuteur->sex == 'F')
                                                F
                                            @else
                                                M
                                            @endif
                                        </td>
                                        <td style="text-align:center">{{ $tuteur->adresses }}</td>

                                        <td style="text-align:center">{{ $tuteur->etudiant_prenom }} {{ $tuteur->etudiant_nom }}</td>


                                        <td style="text-align:center"><a href="{{ url('detail-tuteur=' . $tuteur->id) }}"><button type="button"
                                            class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>

                                        {{-- <td>

                                            <div class="d-flex order-actions">
                                                <a href="{{ url('etudiant=' . $tuteur->id) }}" class=""><i
                                                    class='bx bxs-edit' style="text-align:center"></i></a>

                                            <a href="{{ route('delete_etudiant', $tuteur->id) }}" id="btn-hapus" data-id="{{ $tuteur->id }}" nom-id="{{ $tuteur->noms }}" prenom-id="{{ $tuteur->prenoms }}" class="ms-4"><i class='bx bxs-trash'
                                                    style="text-align:center"></i></a>

                                            </div>

                                        </td> --}}

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


@push('tuteur')

    <script>

        $(document).ready(function(){
            console.log("hello word");
            $('#idtut').on("change",function(){
                var classe_id = $('#idtut').val();
                console.log(classe_id);
              $.ajax({
                    type: 'GET',
                    url: '{{ route('GetTuteur') }}',
                    datatype: 'JSON',
                    data:{tuteur:classe_id},
                    success: (response)=>{
                        console.log("matiere",response.tuteurs)
                        inscri = response.tuteurs
                            console.log('avec filtre',inscri);
                            //inscri = inscri.filter(d => d.annee == classe_id)

                        var tuteur = ''

                        for(let resp of inscri){

                            tuteur += `<tr>
                              <td style="text-align:center">${ resp.id} </td>
                              <td style="text-align:center">${ resp.tuteur_prenoms} ${ resp.tuteur_nom}</td>
                              <td style="text-align:center">${ resp.etudiant_sexe} </td>
                              <td style="text-align:center">${ resp.tuteur_adresse}</td>
                              <td style="text-align:center">${ resp.etudiant_prenom} ${ resp.etudiant_nom}</td>

                                    <td style="text-align:center">
                                        <button type="button"
                                        class="btn btn-light btn-sm radius-30 px-4">View Details</button>
                                    </td>

                                <td>
                                    <div class="d-flex order-actions" style="margin:2%">
                                        <a href="" class=""><i
                                            class='bx bxs-edit' style="text-align:center" disabled></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'
                                                style="text-align:center"></i></a>
                                    </div>
                                </td>
                            </tr>`

                        }

                        if(response.tuteurs.length > 0){

                            $('#tut').html(tuteur);
                           // console.log('tt',$('#ins').val())

                        }else{
                            $('#ins').html('');

                        }

                    },

                })
            })
        });



    </script>

  @endpush
