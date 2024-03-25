@extends('layouts.auth')

@section('container')
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card my-5 my-lg-0 shadow-none border">
                        <form class="row g-3" method="POST" action="{{ route('verificationEcole') }}">
                            @csrf
                            <div class="card-body">
                                <div class="p-4">
                                    <div class="text-center">
                                        <img src="assets/images/icons/forgot-2.png" width="100" alt="" />
                                    </div>
                                    <h4 class="mt-5 font-weight-bold">Sélection d'école</h4>
                                    <p class="mb-3">Merci de choisir votre établissement scolaire.</p>
                                    <div class="my-4">
                                        <input type="hidden" name="email" />
                                        <label class="form-label">Ecole</label>
                                        <select class="form-select single-select @error('ecole_id') is-invalid  @enderror"
                                            id="inputGroupSelect03" aria-label="Example select with button addon"
                                            name="ecole_id">

                                            <option value="">Selectionnez l'ecole</option>

                                            @foreach ($ecoles as $ecole)
                                                <option value="{{ $ecole->id }}">{{ $ecole->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('ecole_id')
                                            <span class="error" style="color:red">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-white">Se connecter</button>
                        </form>
                        </form>
                        {{-- <a href="{{ route('home') }}" class="btn btn-light"><i class='bx bx-arrow-back me-1'></i>Back to Login</a> --}}
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                            target="_blank" class="btn btn-light">
                            <i class='bx bx-arrow-back me-1'></i>Back to Login</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
