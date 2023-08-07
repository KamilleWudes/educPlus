@extends('layouts/master')
@section('contenu')
    <form class="row g-3" method="POST" action="{{ route('create-saisi-note') }}">
        @csrf
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Form</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Bulettin</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="validationCustom04"
                        name="annee_scolaire_id">
                        <option value="{{ AnneScolairesId()}}">{{ AnneScolaires()}}
                        </option>
                    </select>
                    @error('annee_scolaire_id')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!--end breadcrumb-->
            <input type="text" value=" {{ ProfId() }}" name="professeur_id" />


            <div class="card">
                <div class="card-body">
                    <h4 class="mb-0">Saisie des notes</h4><br>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Type Trimestre</label>
                            <select class="single-select @error('type_trimestre_id') is-invalid  @enderror" name="type_trimestre_id">
                                <option value="">Selectionnez Type Trimestre</option>
                                @foreach ($typesTrimestreInfos->pluck('nom', 'id') as $id => $nom)
                                 <option value="{{ $id }}">{{ $nom }}</option>
                               @endforeach
                            </select>
                            @error('type_trimestre_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Type Composition</label>
                            <select class="single-select @error('type_compo_id') is-invalid @enderror" name="type_compo_id">
                                <option value="">Selectionnez Type Composition</option>
                                @foreach ($typeCompositions as $typeComposition)
                                    <option value="{{ $typeComposition->id }}">{{ $typeComposition->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_compo_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <hr />
                    <div class="row gy-3">
                        <div class="col-md-6">
                            {{--  <label class="form-label">Selectionnez la Classe {{ disposer() }}</label>  --}}
                            <label class="form-label">Selectionnez la Classe</label>

                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button"><i class='bx bx-search'></i>
                                </button>
                                <select class="single-select form-select @error('classe_id') is-invalid  @enderror" id="classe-select" name="classe_id">
                                    <option value="">Selectionnez la classe</option>
                                    @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                @endforeach

                                </select>


                            </div>
                            @error('classe_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                        </div>
                        <br>
                        <div class="col-md-6">
                            <label class="form-label">Selectionnez la Matière</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button"><i class='bx bx-search'></i>
                                </button>
                                  <select class="form-select single-select @error('matier_id') is-invalid  @enderror" name="matier_id" id="matiere">
                                    </select>
                            </div>
                            @error('matier_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                        </div>
                        {{--  @error('classe_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror  --}}
                    </div>
                    <br>
                </div>
            </div>
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Listes des etudiants</h5>
                        </div>
                        <div class="font-22 ms-auto">
                            {{--  <i class='bx bx-dots-horizontal-rounded'>  --}}
                           <p id="coef"></p>
                        {{--  </i>  --}}
                        </div>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order id</th>
                                    <th>Nom et prenom</th>
                                    <th style="text-align: center">Notes</th>
                                    {{--  <th>Coefficient</th>  --}}
                                    <th>Note coficié</th>
                                    {{--  <th style="text-align: center">Apreciation</th>  --}}
                                </tr>
                            </thead>
                            <tbody id="etu">


                            </tbody>
                                    <input type="text" name="note" id="notes">

                        </table>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                     <button type="submit" onclick="insertNotes()" class="btn btn-primary px-5" ><i
                class="bx bx-check-circle mr-1"></i>Enregistrer</button>

        <a href=""> <button type="button" class="btn btn-danger px-5"
                onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>
                </div><br>
            </div>
        </div>
    </form>

@endsection

@push('select_matiere')
    <script>
        var etuu = []
        var note_etudiants = [];


        var allCoef = []
        var calc = 0

        function insertNotes(){

            for(let resp of etuu){
                var note_etudiant = {};
                note_etudiant.etu = resp.id

                note_etudiant.note = document.getElementById('note'+resp.id).value

                note_etudiants.push(note_etudiant);
            }
            //console.log(note_etudiants)
            //alert(JSON.stringify(note_etudiants))
                    document.getElementById('notes').value = JSON.stringify(note_etudiants);
                    // Soumettez le formulaire
                document.querySelector('form').submit();

        }

        $(document).ready(function(){

            $('#matiere').on("change",function(){
                $('#note').val('')
                $('#re').text('')
                var coeff = allCoef.filter(d => d.matier_id == $('#matiere').val())
                calc = coeff[0].coefficient
                $('#coef').html(`<h5 class="mb-0">coefficient : ${coeff[0].coefficient}</h5>`);

               /* $.ajax({ AzraelMic
                    type: 'GET',
                    url: 'http://192.168.17.210:8000/api/get-all-region',
                    datatype: 'JSON',
                    success: (response)=>{
                        console.log(response.regions)
                              for( var i = 0; i < response.regions.length; i++){
                            matiere += '<option  value="'+response.regions[i].id+'">'+response.regions[i].intitule+'</option>';
                        }
                        $('#matiere').html(matiere);
                 }

                 })  */
            })
        });

        function add(){
            console.log('br')
            $('#re').text($('#note').val() *  calc)
        }
      /*  $(document).ready(function(){

            $('#note').on("onKeydown",function(){
                console.log('yygfryhj')

            })
        });*/



        // declaring each grid element as a Object having three properties


        var etudiants = [];
        $(document).ready(function(){
            console.log("hello word");
            $('#classe-select').on("change",function(){
                var classe_id = $('#classe-select').val();
                console.log(classe_id);
                $.ajax({
                    type: 'GET',
                    url: '{{ route('GetClasseMatiere') }}',
                    datatype: 'JSON',
                    data:{classe_id:classe_id},
                    success: (response)=>{
                        allCoef = response.coefficient;
                        console.log("yy",response.matieres[0].coefficient)
                        console.log("matiere",response.matieres)
                        etudiants = response.etudiantsInscrits

                        console.log('sans filtre',etudiants);
                        etudiants = etudiants.filter(d => d.classe_id == classe_id)
                        etuu = etudiants
                        console.log('avec filtre',etudiants);
                        console.log('avec filtre',etudiants);
                        var et = ''

                        for(let resp of etudiants){

                        et += `<tr><td>   ${ resp.matricule }

                            <td>
                                <div class="d-flex align-items-center">
                                    <t

                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14">
                                            ${ resp.nom }

                                            ${ resp.prenom }
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input id="note${ resp.id }" onkeyup='add()' type="text" min="0"
                                    class="form-control @error('note') is-invalid  @enderror"
                                    name="note">
                                    <input type="text" value="${ resp.id }" name="inscription_id" />

                            </td>


                            <td id="re"></td>
                            <td>

                        </td></tr>`;



                    }


                        var matiere = '';
                        var etudiant ='';

                        for( var i = 0; i < response.matieres.length; i++){
                            matiere += '<option  value="'+response.matieres[i].id+'">'+response.matieres[i].nom+'</option>';
                        }


                        if(response.matieres.length > 0){

                            $('#matiere').html(matiere);
                            $('#etu').html(et);
                            console.log('tt',$('#matiere').val())
                            var coeff = allCoef.filter(d => d.matier_id == $('#matiere').val())
                            calc = coeff[0].coefficient
                            $('#coef').html(`<h5 class="mb-0">coefficient : ${coeff[0].coefficient}</h5>`);

                        }else{

                        }
                    },

                })
            })
        });


    </script>


@endpush
