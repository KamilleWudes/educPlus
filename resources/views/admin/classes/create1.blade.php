<form method="POST" action="{{ route('createAnneeScolaire') }}">
    @csrf
    <div class="col">
        <div class="modal fade" id="exampleDarkModal" tabindex="-1" aria-hidden="true";>
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-dark"style="width:800px">
                    <div class="modal-header">
                        <h5 class="modal-title text-white">Formulaire d''enregistrement de la classe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-white">
                        <h5 class="mb-0 text-white">Nouvelle classe</h5>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Ecole
                                </label>
                            <div class="col-sm-9">
                                    <select class="form-select mb-0" aria-label="Default select example">
                                        <option selected>Selectionner l''ecole</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Niveau
                                </label>
                            <div class="col-sm-9">
                                    <select class="form-select mb-0" aria-label="Default select example">
                                        <option selected>Selectionner le niveau</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Entrez la classe
                                </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('nom') is-invalid  @enderror"
                                    id="inputEnterYourName" name="nom" placeholder="classe">
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
</form>
