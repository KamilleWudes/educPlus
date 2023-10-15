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
                        <h5 class="mb-0 text-white">Nouvelle année scolaire</h5><br><br><br><br>
                        <div class="row mb-3">
                            <label for="inputEnterYourName" class="col-sm-3 col-form-label">Nouvelle Année Scolaire :
                            </label>
                            <div class="col-md-4">

                                <input type="text" class="form-control @error('annee1') is-invalid  @enderror"
                                    id="inputEnterYourName" name="annee1" value="{{ old('annee1') }}"
                                    placeholder="Entrer debut année Scolaire">
                                @error('annee1')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-md-4">

                                <input type="text" class="form-control @error('annee2') is-invalid  @enderror"
                                    id="inputEnterYourName2" name="annee2" placeholder="Entrer fin année Scolaire">
                                @error('annee2')
                                    <span class="error" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <input type="hidden" value="{{ EcolesId() }}" name="ecole_id" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary px-5 px-5"><i
                                class="bx bx-check-circle mr-1"></i>Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
