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
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Ecole</li>
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
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Liste des Ecoles</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="ms-auto"><a href=" {{ route('addecole') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"
                                data-bs-toggle="" data-bs-target=""><i
                                    class="bx bxs-plus-square"></i>Nouvelle Ecole</a></div>
                        {{--  @include('admin.ecoles.create')  --}}
                    </div>
                    <br>
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center">Numero</th>
                                <th style="text-align:center">Ecoles</th>
                                <th style="text-align:center">Ajouté</th>
                                <th style="text-align:center">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ecoles as $ecole)
                                <tr>
                                    <td style="text-align:center">{{ $ecole->id }}</td>
                                    <td style="text-align:center">{{ $ecole->nom }}</td>
                                    <td style="text-align:center">{{ $ecole->created_at->diffForHumans()}}</td>

                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{ url('ecole='.$ecole->id) }}" class=""><i class='bx bxs-edit'
                                                    style="text-align:center"></i></a>
                                            <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'
                                                    style="text-align:center"></i></a>
                                        </div>
                                        {{--  <a href="{{ url('anneeScolaire/'.$anneeScolaire->id) }}"<button type="button" class="btn btn-dark px-5 radius-30">Modifier</button></a>  --}}

                                    </td>
                                    {{--  <td>
                                            <button type=""  class="btn btn-danger px-5 radius-30"
                                            onclick="if(confirm('Voulez vous vraiment supprimer cet anneeScolaire?')){document.getElementById('form-{{ $anneeScolaire->id }}').submit()}">Suprimer</button>
                                        <form id="form-{{ $anneeScolaire->id }}" method="POST"
                                            action="{{ route('delete_anneeScolaire', ['anneeScolaire' => $anneeScolaire->id]) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete">

                                        </form>

                                        </td>  --}}
                                </tr>
                            @endforeach

                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <br> <br> <br> <br> <br>
    @endsection
