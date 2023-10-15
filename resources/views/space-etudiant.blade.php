@extends('layouts.auth')

@section('container')
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-lock-screen d-flex align-items-center justify-content-center">
            <div class="card shadow-none bg-transparent">
                <div class="card-body p-md-5 text-center">

                    {{-- <h2 class="text-white">10:53 AM</h2> --}}
                    {{--  @foreach ($userPrincipals as $userPrincipal)  --}}
                    {{-- <h3 class="text-white" id="t">Tuesday, January 14, 2021</h3> --}}
                    {{--  <h5 class="text-white">{{ $userPrincipal->created_at->diffForHumans()}}</h5>  --}}
                    <h5 class="text-white" id="t6">Espace Pour verifier les Notes et Bulettins des Etudiants</h5>
                    {{--  @endforeach  --}}
                    <div class="">
                        <img src="assets/images/icons/user.png" class="mt-5" width="120" alt="" />
                    </div>
                    <h6 class="mt-2 text-white">Tuteurs / Etudiants</h6>
                    <form method="POST" action="{{ route('NoteLogin') }}">
                        @csrf
                        <div class="mb-3 mt-3">
                            <input type="text" class="form-control @error('matricule') is-invalid @enderror"
                                name="matricule" placeholder="Matricule Etudiant" />
                            @error('matricule')
                                <span class="error" style="color:red">{{ $message }}</span>
                            @enderror <br>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-light" id="flash"
                                    data-flash="{!! session()->get('error') !!}"><i class="bx bxs-lock-open"></i>Se
                                    connecter</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
@endsection
