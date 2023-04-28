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
                            Nouvel Utilisateur</li>
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

                <div class="card border-top border-0 border-4 border-white">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                            </div>
                            <h5 class="mb-0 text-white">Nouvel Utilisateur</h5>
                        </div>
                        <hr>
                        <form class="row g-3" method="POST"
                            action="{{ route('createSuperAdmin') }}"enctype='multipart/form-data'>
                            @csrf
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label">Nom</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('nom') is-invalid  @enderror border-start-0"
                                        id="inputLastName1" name="nom" value="{{ old('nom') }}" placeholder="Nom" />
                                </div>
                                @error('nom')
                                    {{--  <div id="validationServer03Feedback" class="invalid-feedback">Please provide a valid city.</div>  --}}
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName2" class="form-label">Prenom</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('nom') is-invalid  @enderror border-start-0"
                                        id="inputLastName2" name="prenom" value="{{ old('prenom') }}" placeholder="Prenom" />
                                </div>
                                @error('prenom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label"> Address Email</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-message'></i></span>
                                    <input type="text"
                                        class="form-control  @error('email') is-invalid  @enderror border-start-0"
                                        id="inputEmailAddress" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" />
                                </div>
                                @error('email')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputPhoneNo" class="form-label">Téléphone</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-microphone'></i></span>
                                    <input type="text"
                                        class="form-control  @error('telephone') is-invalid  @enderror border-start-0"
                                        id="inputPhoneNo" name="telephone" value="{{ old('telephone') }}" placeholder="Phone No" />
                                </div>
                                @error('telephone')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputChoosePassword" class="form-label">Mot de passe</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid  @enderror border-end-0" id="inputChoosePassword" name="password" value="{{ old('password') }}" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text"><i class='bx bx-hide'></i></a>
                                </div>
                                @error('password')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>


                            <input type="hidden" name="role" value="SuperAdmin" />

                            <div class="col-md-6">
                                <br>
                                <button type="submit" class="btn btn-primary px-5" id="flash"
                                    data-flash="{!! session()->get('success') !!}"><i
                                        class="bx bx-check-circle mr-1"></i>Enregistrer</button>
                            </div>

                            <div class="col-md-6"><br>
                                <a href="{{ route('SuperAdmin') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
