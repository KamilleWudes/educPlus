@extends('layouts.auth')

@section('container')
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center">
                            {{-- <h3 class="">EducPlus</h3> --}}
                            {{-- <img src="assets/images/logo-img.png" width="180" alt="" /> --}}
                            <br><br>
                            {{--  <h5 class="mb-0 text-white"id="label2">Nouvel Etudiant</h5>
                            <h5 class="mb-0 text-white"id="label"> Ancienne Etudiant</h5>  --}}
                            <input onclick="t(0)" type="radio" name="colors" id="red"><span
                                style="font-size:20px;">Admin</span>
                            <input onclick="t(1)" type="radio" name="colors" id="blue"><span
                                style="font-size:20px;">Professeur </span>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">Authentification</h3><br>

                                    </div>

                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('verification') }}">
                                            @csrf
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="inputEmailAddress" name="email" value="{{ old('email') }}"
                                                    placeholder="Email Address">
                                            </div>

                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Enter
                                                    Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password"
                                                        class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                        name="password" id="inputChoosePassword"
                                                        placeholder="Enter Password"> <a href="javascript:;"
                                                        class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            {{-- <div class="col-12" id="ecoles">
                                                <label class="form-label">Selectionnez l'ecole</label>

                                                <select
                                                    class="form-select single-select @error('ecole_id') is-invalid  @enderror"
                                                    id="inputGroupSelect03" aria-label="Example select with button addon"
                                                    name="ecole_id">

                                                    <option value="">Selectionnez l'ecole</option>

                                                    @foreach ($ecoles as $ecole)
                                                        <option value="{{ $ecole->id }}">{{ $ecole->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}


                                            <div class="col-md-6 text-end"> <a
                                                    href="authentication-forgot-password.html"></a>
                                            </div>
                                            <input type="hidden" id="na" name="na">

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-light" id="flash"
                                                        data-flash="{!! session()->get('error') !!}"><i
                                                            class="bx bxs-lock-open"></i>Se connecter</button>



                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  </div>  --}}


                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->


    <script>
        t(0)

        function t(r) {
            if (r == 0) {


                document.getElementById('na').value = 'admin'
                document.getElementById("ecoles").hidden = true;


            } else {

                document.getElementById('na').value = 'professeur'
                document.getElementById("ecoles").hidden = false;

            }
        }
    </script>
@endsection
