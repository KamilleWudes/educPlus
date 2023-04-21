{{--  <form method="POST" action="{{ route('createAnneeScolaire') }}">
    @csrf
    <div class="col">
        <div class="modal fade" id="exampleDarkModal" tabindex="-1" aria-hidden="true";>
            <div class="modal-dialog modal-lg modal-dialog-centered"style="width:800px";>
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-white">Formulaire d''enregistrement d''une ecole</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-white">
                        <h5 class="mb-0 text-white">Nouvelle Ecole</h5>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Nom de l''ecole
                                </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-start-0" id="inputEmailAddress"
                                placeholder="Nom ecole" />
                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Nom de l''ecole
                                </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-start-0" id="inputEmailAddress"
                                placeholder="Email Address" />
                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Télephone 1
                                </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-start-0" id="inputPhoneNo"
                                placeholder="Phone No" />
                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Télephone 2
                                </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-start-0" id="inputPhoneNo"
                                placeholder="Phone No" />
                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Adresse
                                </label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="inputAddress3" placeholder="Enter Address" rows="2"></textarea>

                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary pd-5 px-5">Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>  --}}
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
                        <li class="breadcrumb-item active" aria-current="page">
                            Nouvel Ecole</li>
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
            <div class="col-xl-7 mx-auto">
                <br>
                <div class="card border-top border-0 border-4 border-white">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                            </div>
                            <h5 class="mb-0 text-white">Nouvel Ecole</h5>
                        </div>
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('createecole') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label">Nom</label> <br> <br>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('nom') is-invalid  @enderror border-start-0 "
                                        id="inputLastName1" name="nom" value="{{ old('nom') }}" placeholder="Nom" />

                                </div>
                                @error('nom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputAddress3" class="form-label">Address</label>
                                <textarea class="form-control @error('adresse') is-invalid  @enderror" name="adresse" value="{{ old('adresse') }}" id="inputAddress3"
                                    placeholder="Enter Address" rows="2"></textarea>
                                @error('adresse')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputPhoneNo" class="form-label">Téléphone 1</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-microphone'></i></span>
                                    <input type="text"
                                        class="form-control @error('telephone1') is-invalid  @enderror border-start-0"
                                        name="telephone1" id="inputPhoneNo" value="{{ old('telephone1') }}" placeholder="Téléphone 1 " />

                                </div>
                                @error('telephone1')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputPhoneNo" class="form-label">Téléphone 2</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-microphone'></i></span>
                                    <input type="text" class="form-control border-start-0" id="inputPhoneNo"
                                        name="telephone2" value="{{ old('telephone2') }}" placeholder="Téléphone 2" />
                                </div>
                                @error('telephone2')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label"> Address Email</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-message'></i></span>
                                    <input type="text"
                                        class="form-control @error('email') is-invalid  @enderror border-start-0"
                                        id="inputEmailAddress" name="email" value="{{ old('email') }}" placeholder="Email Address" />

                                </div>
                                @error('email')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <br>
                                <button type="submit" class="btn btn-primary px-5" id="flash"
                                    data-flash="{!! session()->get('success') !!}"><i
                                        class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                            </div>

                            <div class="col-md-6"><br>
                                    <a href="{{ route('ecole') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
