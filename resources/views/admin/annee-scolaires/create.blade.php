<form method="POST" action="{{ route('createAnneeScolaire') }}">
    @csrf
    <div class="col">
        <div class="modal fade" id="exampleDarkModal" tabindex="-1" aria-hidden="true";>
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-dark"style="width:800px">
                    <div class="modal-header">
                        <h5 class="modal-title text-white">Formulaire d'enregistrement de l'année scolaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-white">
                        <h5 class="mb-0 text-white">Nouvelle année scolaire</h5><br><br>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Debut annee
                                scolaire</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('annee1') is-invalid  @enderror"
                                    id="inputEnterYourName" name="annee1" value="{{ old('annee1') }}" placeholder="Entrer debut année Scolaire">
                                @error('annee1')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Fin annee
                                scolaire</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('annee2') is-invalid  @enderror"
                                    id="inputEnterYourName" name="annee2" value="{{ old('annee2') }}" placeholder="Entrer fin année Scolaire">
                                @error('annee2')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <input type="text" value="{{ EcolesId() }}" name="ecole_id"/>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary px-5 px-5" id="flash"
                                    data-flash="{!! session()->get('success') !!}"><i
                                        class="bx bx-check-circle mr-1"></i>Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
