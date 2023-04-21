@extends('layouts/master')
@section('contenu')
    <form class="row g-3" method="POST" action="{{ route('createMatiere_coefficient') }}">
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
                        {{--  @foreach ($AnneeScolaires as $AnneeScolaire)
                        <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} -
                            {{ $AnneeScolaire->annee2 }}
                        </option>
                    @endforeach  typeCompositions --}}
                    </select>
                    @error('annee_scolaire_id')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!--end breadcrumb-->
            <input type="text" value=" {{ $data->id }}" />


            <div class="card">
                <div class="card-body">
                    <h4 class="mb-0">Saisie des notes</h4><br>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Type Trimestre</label>
                            <select class="single-select">
                                @foreach ($bulletins as $bulletin)
                                    <option value="{{$bulletin->type_trimestre->id }}">{{ $bulletin->type_trimestre->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type Composition</label>
                            <select class="single-select">
                                @foreach ($typeCompositions as $typeComposition)
                                    <option value="{{ $typeComposition->id }}">{{ $typeComposition->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr />
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Selectionnez la Classe</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button"><i class='bx bx-search'></i>
                                </button>
                                <select class="single-select form-select" id="sub_category_name" name="classe_id">
                                    <option value="">Selectionnez la classe</option>
                                    @foreach ($data->classe as $dat)
                                    <option value="{{$dat->id}}">{{ $dat->nom }} </option>
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
                                  <select class="form-select @error('classe_id') is-invalid  @enderror single-select"
                                     name="matiere_id" id="sub_category" aria-label="Example select with button addon">
                                    <option></option>
                                    {{--  @foreach ($data->matieres as $dat)
                                    <option value="{{$dat->id }}">{{ $dat->nom }} </option>
                                    @endforeach  --}}

                                </select>

                            </div>
                        </div>
                        @error('classe_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <br>
                </div>
            </div>
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Orders Summary</h5>
                        </div>
                        <div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
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
                                    <th>Coefficient</th>
                                    <th>Note coficié</th>
                                    <th style="text-align: center">Apreciation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bulletins as $bulletin)
                                    <tr>
                                        <td>#897656 </td>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div class="ms-2">
                                                    <h6 class="mb-1 font-14">
                                                        {{ $bulletin->inscription->etudiant->prenom }}
                                                        {{ $bulletin->inscription->etudiant->nom }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input id="todo-input" type="text"
                                                class="form-control @error('coefficient') is-invalid  @enderror"
                                                name="coefficient" value="{{ old('coefficient') }}">

                                        </td>
                                        <td>12 Jul 2020</td>
                                        <td>$64.00</td>
                                        <td>
                                            <div class="d-grid">
                                                <input id="todo-input" type="text"
                                                    class="form-control @error('coefficient') is-invalid  @enderror"
                                                    name="coefficient" value="{{ old('coefficient') }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="http://code.jquery.com/jquery-3.4.1.js"></script>

    <script>
                $(document).ready(function () {
                $('#sub_category_name').on('change', function () {
                let id = $(this).val();
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'GetSubCatAgainstMainCatEdit/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                response.forEach(element => {
                    $('#sub_category').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });
    </script>





@endsection
