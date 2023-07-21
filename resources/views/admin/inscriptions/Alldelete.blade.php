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
                            <li class="breadcrumb-item active" aria-current="page">Inscriptions</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="idannee"
                        name="annee_scolaire_id">
                        <option value="">Annee Scolaires </option>

                        {{-- @foreach ($AnneeScolaires as $AnneeScolaire)
                            <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} -
                                {{ $AnneeScolaire->annee2 }}</option>
                        @endforeach --}}
                    </select>
                    @error('annee_scolaire_id')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Listes des Inscriptions</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    {{--  <th style="text-align:center">Numero</th>  --}}
                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Année Scolaire</th>
                                    <th style="text-align:center">Date d''inscription</th>
                                    <th style="text-align:center">Etudiant</th>
                                    <th style="text-align:center">classes</th>
                                    <th style="text-align:center">Tuteurs</th>
                                    <th style="text-align:center">Télephone Tuteur</th>
                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="ins">


                                @foreach ($inscriptions as $inscription)
                                    <tr>
                                        {{--  <td style="text-align:center">{{ $inscription->id }}</td>  --}}
                                      <td style="text-align:center">{{ $inscription->matricule }}</td>
                                        <td style="text-align:center">{{ $inscription->annee1}} - {{ $inscription->annee2}}</td>
                                        <td style="text-align:center">{{ $inscription->date_insription }}</td>
                                        <td style="text-align:center">{{ $inscription->etudiant_prenom }} {{ $inscription->etudiant_nom }}</td>
                                        <td style="text-align:center">{{ $inscription->classe_nom}}</td>
                                        <td style="text-align:center">{{ $inscription->tuteur_prenoms }} {{ $inscription->tuteur_nom }}</td>
                                        <td style="text-align:center">{{ $inscription->tuteur_telephone1 }} / {{ $inscription->tuteur_telephone2 }}</td>

                                            <td style="text-align:center"><a href="{{ url('inscription-detail=' . $inscription->id) }}"><button type="button"
                                                class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>

                                        <td>
                                            <div>
                                                <a href="{{ url('inscription-restore/'. $inscription->id) }}"><button type="button" id="flash"
                                                data-flash="{!! session()->get('success') !!}"
                                                class="btn btn-light btn-sm radius-30 px-4"> Restaurer</button></a>
                                                       
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

@push('ins')

  <script>

    $(document).ready(function(){
        console.log("hello word");
        $('#idannee').on("change",function(){
            var classe_id = $('#idannee').val();
            console.log(classe_id);
          $.ajax({
                type: 'GET',
                url: '{{ route('GetAnnee') }}',
                datatype: 'JSON',
                data:{annee:classe_id},
                success: (response)=>{
                    console.log("matiere",response.inscriptions)
                    inscri = response.inscriptions
                        console.log('avec filtre',inscri);
                        //inscri = inscri.filter(d => d.annee == classe_id)

                    var is = ''

                    for(let resp of inscri){

                        is += `<tr>
                          <td style="text-align:center">${ resp.matricule} </td>
                            <td style="text-align:center">${ resp.annee1} - ${ resp.annee2}</td>
                            <td style="text-align:center">${ resp.date_insription} </td>
                            <td style="text-align:center">${ resp.etudiant_prenom} ${ resp.etudiant_nom}</td>
                            <td style="text-align:center">${ resp.classe_nom}</td>
                            <td style="text-align:center">${ resp.tuteur_prenoms} ${ resp.tuteur_nom}</td>
                            <td style="text-align:center">${ resp.tuteur_telephone1} / ${ resp.tuteur_telephone2}</td>

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

                    if(response.inscriptions.length > 0){

                        $('#ins').html(is);
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

