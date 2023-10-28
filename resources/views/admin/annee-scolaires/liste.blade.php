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
                        <div class="ms-auto"><a href="javascript:;" class="btn btn-light radius-30 mt-2 mt-lg-0"
                                data-bs-toggle="modal" data-bs-target="#exampleDarkModal"><i
                                    class="bx bxs-plus-square"></i>Nouvelle année scolaire</a></div>
                        @include('admin.annee-scolaires.create')
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

    
