@extends('layouts/master')
@section('contenu')
    <form class="row g-3" method="POST" action="{{ route('createMatiere_coefficient') }}">
        @csrf
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Applications</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Enregistrement de Matière et coefficient</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <label for="validationCustom04" class="form-label">Année scolaire</label>
                    <select class="form-select @error('annee_scolaire_id') is-invalid  @enderror" id="validationCustom04"
                        name="annee_scolaire_id">
                        @foreach ($AnneeScolaires as $AnneeScolaire)
                            <option value="{{ $AnneeScolaire->id }}">{{ $AnneeScolaire->annee1 }} -
                                {{ $AnneeScolaire->annee2 }}
                            </option>
                        @endforeach
                    </select>
                    @error('annee_scolaire_id')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!--end breadcrumb-->



            <div class="card">
                <div class="card-body">
                    <h4 class="mb-0">Formulaire matiere et coefficient</h4>
                    <hr />
                    <div class="mb-3">
                        <label class="form-label">Selectionnez la classe</label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"><i class='bx bx-search'></i>
                            </button>
                            <select class="form-select @error('classe_id') is-invalid  @enderror single-select"
                            id="classe" name="classe_id" aria-label="Example select with button addon">
                                <option value="">Selectionnez la classe</option>
                                @foreach ($classes as $classes)
                                    <option value="{{ $classes->id }}"> {{ $classes->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('classe_id')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <br>


                    <div class="row gy-3">
                        <div class="col-md-4">
                            <label for="inputLastName1" class="form-label">Ajouter Matière</label>
                            {{--  <input type="text" class="form-control @error('nom') is-invalid  @enderror" name="nom" value="{{ old('nom') }}">  --}}
                            <select class="single-select  @error('matier_id') is-invalid  @enderror form-select" id="matiere"  name="matier_id">
                                <option value="">Selectionnez la Matière</option>
                                @foreach ($matieres as $matiere)
                                   <option value="{{ $matiere->id }}"> {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matier_id')
                            <span class="error"style="color:red">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="inputLastName1" class="form-label">Ajouter Coefficient</label>
                            <input id="todo-input" type="text" class="form-control @error('coefficient') is-invalid  @enderror" name="coefficient" value="{{ old('coefficient') }}">
                            @error('coefficient')
                            <span class="error"style="color:red">{{ $message }}</span>
                        @enderror

                        </div>

                        <div class="col-md-3">
                            <label for="inputLastName1" class="form-label" style="text-align: center">Actions</label><br>
                            <button type="submit" class="btn btn-primary px-4" id="flash"
                                data-flash="{!! session()->get('success') !!}"><i
                                    class="bx bx-check-circle mr-1"></i>Enregistrer</button>

                            <a href="{{ route('anneescolaire-classe-matieres') }}"> <button type="button" class="btn btn-danger px-"
                                    onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>
                        </div> <br>

                    </div><br>
                </div>
            </div><br><br><br><br><br><br><br><br><br><br>
        </div>
    </form>
@endsection
