@extends('layouts/master')
@section('contenu')
    <div class="col-12" <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Années scolaires</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Liste des années scolaires</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="POST" action="{{ route('createAnneeScolaire') }}">
                            @csrf
                        <input type="hidden"  class="form-control @error('annee1') is-invalid  @enderror"
                                    id="inputEnterYourName" name="annee1" value="{{ old('annee1') }}"
                                    placeholder="Entrer debut année Scolaire"/>
                                    
                                    <input type="hidden" class="form-control @error('annee2') is-invalid  @enderror"
                                    id="inputEnterYourName2" name="annee2" placeholder="Entrer fin année Scolaire"/>
                                    
                                    <input type="hidden" value="{{ EcolesId() }}" name="ecole_id" />
                              
                        <div class="ms-auto"><button type="submit" class="btn btn-light radius-30 mt-2 mt-lg-0"
                                data-bs-toggle="modal" data-bs-target="#exampleDarkModal"><i
                                    class="bx bxs-plus-square"></i>Nouvelle année scolaire</button></div>


                                    
                        {{-- @include('admin.annee-scolaires.create') --}}
                        </form>
                    </div>
                    <br> <br>
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                {{-- <th style="text-align:center">Numero</th> --}}
                                <th style="text-align:center">Annee scolaire</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anneeScolaires as $anneeScolaire)
                                <tr>
                                    {{-- <td style="text-align:center">{{ $anneeScolaire->id }}</td> --}}
                                        <td style="text-align:center">{{ $anneeScolaire->annee1 }} - {{ $anneeScolaire->annee2 }}</td>
                                </tr>
                            @endforeach

                            </tfoot>
                    </table>
                </div>
            </div>
        </div>

    @endsection

    @push('validate')
    <script>
        var d = new Date();
        old = d.getFullYear();
        console.log(old);
        news = d.getFullYear() + 1;
        console.log(news);

        document.getElementById('inputEnterYourName').value = old
        document.getElementById('inputEnterYourName2').value = news

        document.getElementById("inputEnterYourName").readOnly = true;
        document.getElementById("inputEnterYourName2").readOnly = true;


        var successFlash = '{{ session('success') }}';
        var errorFlash = '{{ session('error') }}';

        if (successFlash) {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: successFlash,
                showClass: {
                    popup: 'animate__animated animate__jackInTheBox'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                },
                timer: 500000, // Temps en millisecondes (3 secondes dans cet exemple)
                timerProgressBar: true, // Affiche une barre de progression
                toast: false, // Style de popup de notification
                position: 'center' // Position de la notification
            });
        } else if (errorFlash) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: errorFlash,
                showClass: {
                    popup: 'animate__animated animate__shakeX'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                },
                //timer: 50000, // Temps en millisecondes (3 secondes dans cet exemple)
                //timerProgressBar: true, // Affiche une barre de progression
                //toast: false, // Style de popup de notification
                //position: 'top-end' // Position de la notification
            });
        }
    </script>
@endpush

    
