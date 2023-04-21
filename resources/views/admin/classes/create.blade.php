@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Forms</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Classe</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-light">Settings</button>
                    <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                            href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <br> <br>
                <h6 class="mb-0 text-uppercase">Formulaire d''enregistrement de la classe</h6>
                <hr />
                <div class="card">
                    <form class="row g-3" method="POST" action="{{ route('createclasse') }}">
                        @csrf
                        <div class="card-body">
                            <div class="border p-3 rounded">

                                {{--  <div class="mb-3">
                                    <label class="form-label">Selectionnez l''ecole</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button"><i
                                                class='bx bx-search'></i>
                                        </button>
                                        <select class="form-select @error('ecole_id') is-invalid  @enderror single-select"
                                            id="inputGroupSelect03" name="ecole_id"
                                            aria-label="Example select with button addon">
                                            <option value="">Selectionnez l''ecole</option>

                                                <option value="{{ EcolesId() }}">{{ Ecoles()}} </option>

                                        </select>
                                    </div>
                                    @error('ecole_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>  --}}
                                <input type="hidden" value="{{ EcolesId() }}" name="ecole_id"/>

                                <div class="mb-3">
                                    <label class="form-label">Selectionnez le niveau scolaire</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button"><i
                                            class='bx bx-search'></i>
                                    </button>
                                        <select
                                            class="single-select form-select  @error('niveau_scolaires_id') is-invalid  @enderror"
                                            name="niveau_scolaires_id">
                                            <option value="">Niveau scolaire</option>
                                            @foreach ($NiveauScolaires as $NiveauScolaire)
                                                <option value="{{ $NiveauScolaire->id }}">{{ $NiveauScolaire->nom }}
                                                </option>
                                            @endforeach
                                        </select>


                                    </div>
                                    @error('niveau_scolaires_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror

                                </div>
                                 <label class="form-label">Classe</label>
                                <input class="form-control @error('nom') is-invalid  @enderror mb-3" type="text"
                                    placeholder="Classe" name="nom" value="{{ old('nom') }}" aria-label="default input example"/>
                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary px-5" id="flash"
                                        data-flash="{!! session()->get('success') !!}"><i
                                            class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                                    <a href="{{ route('classe') }}"> <button type="button" class="btn btn-danger px-5"
                                            onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <br> <br><br> <br><br> <br><br> <br><br>
@endsection
