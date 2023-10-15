@extends('layouts/master')
@section('contenu')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Forms</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('getHome') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edition utilisateur</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
    
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
                            <h5 class="mb-0 text-white">Edition utilisateur</h5>
                        </div>
                        <hr>
                        <form class="row g-3" method="POST" action="{{ url('update_responsable/'. $users->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label">Nom</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid  @enderror border-start-0"
                                        id="inputLastName1" name="name" value="{{ $users->name }}"placeholder="Nom" />
                                </div>
                                @error('name')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName2" class="form-label">Prenom</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('prenom') is-invalid  @enderror border-start-0"
                                        id="inputLastName2" name="prenom" value="{{ $users->prenom }}" placeholder="Prenom" />
                                </div>
                                @error('prenom')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputAddress3" class="form-label">Sexe</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <select class="form-select mb-0 @error('sexe') is-invalid  @enderror" name="sexe"
                                        aria-label="Default select example">
                                        <option value="H"{{ $users->sexe == "1" ? 'selected' : '' }}>homme</option>
                                        <option value="F"{{ $users->sexe == "0" ? 'selected' : '' }}>Femme</option>
                                    </select>
                                </div>
                                @error('sexe')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputPhoneNo" class="form-label">Téléphone</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-microphone'></i></span>
                                    <input type="text"
                                        class="form-control  @error('telephone') is-invalid  @enderror border-start-0"
                                        id="inputPhoneNo" name="telephone" value="{{ $users->telephone }}" placeholder="Phone No" />
                                </div>
                                @error('telephone')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                           
                            <div class="col-12">
                                <label class="form-label">Ecole</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button"><i class='bx bx-search'></i>
                                    </button>
                                    <select class="form-select single-select @error('ecole_id') is-invalid  @enderror" id="inputGroupSelect03" aria-label="Example select with button addon" name="ecole_id">
                                        <option value="">Selectionnez l''ecole</option>

                                        @foreach ($ecoles as $ecole)
                                        @if($ecole->id == $users->ecole_id)
                                            <option value="{{ $ecole->id }}" selected>{{ $ecole->nom }}
                                                @else
                                                <option value="{{ $ecole->id }}">{{ $ecole->nom }} </option>

                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('ecole_id')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label"> Address Email</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-message'></i></span>
                                    <input type="text"
                                        class="form-control border-start-0  @error('email') is-invalid  @enderror"
                                        id="inputEmailAddress" name="email"  value="{{ $users->email }}" placeholder="example@gmail.com" />
                                </div>
                                @error('email')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputAddress3" class="form-label">Address</label>
                                <textarea class="form-control" name="adresse"  value="{{ $users->adresse }}" id="inputAddress3" placeholder="Enter Address" rows="2"></textarea>
                                @error('adresse')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputChoosePassword" class="form-label">Mot de passe</label><br><br>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid  @enderror border-end-0" id="inputChoosePassword" name="password"  value="{{ $users->password }}" placeholder="Enter Password" disabled="true"> <a href="javascript:;" class="input-group-text"><i class='bx bx-hide'></i></a>
                                </div>
                                @error('password')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-6">
                                <br>
                                <button type="submit" class="btn btn-primary px-5" id="flash"
                                    data-flash="{!! session()->get('success') !!}"><i
                                        class="bx bx-check-circle mr-1"></i>Valider la modification</button>
                            </div>

                            <div class="col-md-6"><br>
                                <a href="{{ route('utilisateur') }}">  <button type="button" class="btn btn-danger px-5" onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
