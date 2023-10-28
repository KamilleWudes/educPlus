<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Scolaire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .header {
            text-align: center;
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }

        .school-info {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
        }

        .school-info h2 {
            font-size: 28px;
            margin-bottom: 10px;
            text-align: left;
        }

        .school-slogan {
            text-align: left;
            margin-bottom: 10px;
        }

        .student-info {
            margin-top: 20px;
        }

        .grades-table table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .grades-table th,
        .grades-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .grades-table th {
            background-color: #f0f0f0;
            color: #333;
        }

        {{-- .grades-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        } --}} .total-moyenne {
            background-color: #ffc107;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <h2 class="h3">Complexe Scolaire {{ $entry->classe->ecole->nom }}</h2>
                <p><strong>Email :</strong> {{ $entry->classe->ecole->email }}</p>
                <p><strong>Téléphone :</strong> {{ $entry->classe->ecole->telephone1 }} /
                    {{ $entry->classe->ecole->telephone2 }}</p>
                <span <p><strong>Adresse :</strong> {{ $entry->classe->ecole->adresse }}</p>
                    <p><strong>Niveau scolaire :</strong> {{ $entry->classe->niveauScolaire->nom }}</p>

                    {{-- N°{{ $entry->id }} <br>
                    Notes{{ $entry->note }} --}}
            </div>

            <div class="col-md-6 text-md-right">
                <span class="float-right">REPUBLIC TOGOLAISE</span></p> <br>
                <span class="float-right">Travail-Liberté-Patrie</span></p>
                <br>
                <strong>
                    <table border="1" class="float-right" style="text-align:center">
                        <tr>
                            <th colspan="2" style="text-align">Informations</th>
                        </tr>
                        <tr>
                            <td>Année Scolaire :</td>
                            <td>{{ $entry->anneeScolaire->annee1 }}- {{ $entry->anneeScolaire->annee2 }}</td>

                        </tr>
                        <tr>
                            <td>Effectif:</td>
                            <td>{{ $effectifTotal }}</td>
                        </tr>

                        <tr>
                            <td>Natricule:</td>
                            <td>{{ $entry->inscription->etudiant->matricule }}</td>
                        </tr>
                        <tr>
                            <td>Sexe:</td>
                            @if ($entry->inscription->etudiant->sexe == 'H')
                                <td>M</td>
                            @else
                                <td>F</td>
                            @endif

                        </tr>
                        <tr>
                            <td>Classe:</td>
                            <td>{{ $entry->classe->nom }}</td>
                        </tr>

                    </table>
                </strong><br>

            </div>
        </div> <br>
        <h3 class="col-md-9 text-md-right"><strong>BULLETIN DE NOTES DU {{ $entry->typeTrimestre->nom }}</strong></h3>

        <br>
        <div class="grades-table">
            <p class="float-left"><strong><u>Nom:</u></strong> {{ $entry->inscription->etudiant->nom }}</p>
            <p class="col-md-6 text-md-right"><strong><u>Prénom(s):</u></strong>
                {{ $entry->inscription->etudiant->prenom }}</p>
            {{-- <table class="table table-bordered"> --}}

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Matières</th>
                        <th colspan="2">Note de classe</th>
                        <th>Moy Notes de classe</th>
                        <th>Note de compo</th>
                        <th>Moy (compo + classe)</th>
                        <th>Coef</th>
                        <th>Produit</th>
                        {{-- <th>Rang</th> --}}
                        <th>Appréciation</th>
                        <th>Professeur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matieres as $matiere)
                        <tr>

                            <td>

                                {{ $matiere->nom }}
                            </td>

                            <td>{{ $matiere->note1 }}</td>
                            <td>{{ $matiere->note2 }}</td>
                            <td>{{ $matiere->moyenne_devoirs }}</td>

                            <td>{{ $matiere->note_composition }}</td>
                            <td>{{ $matiere->moyenne_compo_classe }}</td>
                            <td>{{ $matiere->coef }}</td>
                            <td>{{ $matiere->produit }}</td>




                            <td>{{ $matiere->appreciation }}</td>
                            <td>{{ $matiere->nom_professeur }} {{ $matiere->prenom_professeur }}</td>
                        </tr>
                    @endforeach


                    <tr class="total-notes">
                        <td class="text-center"><strong>TOTAUX</strong></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td style=" background-color: #f0f0f0;"><strong>{{ $sommeCoefficients }}</strong></td>
                        <td style=" background-color: #f0f0f0;"><strong>{{ $sommeProduits }}</strong></td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6 text-md-right">

                    <table border="1">
                        <tr>
                            <th colspan="2">
                                <p><u>MOYENNE GLOBALE:</u> <span
                                        style="font-weight: bold;">{{ $moyenneGlobaleArrondie }}</span>
                                    SUR <span style="font-weight: bold;">20</span></p>
                                <p><u>RANG:</u> <span style="font-weight: bold;">{{ $rangEtudiant }}è</span> SUR <span
                                        style="font-weight: bold;">{{ $effectifTotal }}</span></p>
                            </th>
                        </tr>
                        {{-- <tr>
                            <td colspan="2">
                                <p>Plus forte moyenne de la classe: <span
                                        style="font-weight: bold;">{{ $moyenneMaxClasseArrondie }}</span>
                                    SUR
                                    <span style="font-weight: bold;">20</span>
                                </p>
                                <p>Plus faible moyenne de la classe: <span
                                        style="font-weight: bold;">{{ $moyenneMinClasseArrondie }}</span>
                                    SUR
                                    <span style="font-weight: bold;">20</span>
                                </p>
                                <hr>
                                <p>Moyenne de la classe: <span
                                        style="font-weight: bold;">{{ $NewmoyenneDeLaClasse }}</span>
                                    SUR <span style="font-weight: bold;">20</span></p>
                            </td>

                        </tr> --}}
                        <tr>
                            <td colspan="2"><u>OBSERVATION DU CHEF D''ETABLISSEMENT:</u>
                                <p><span style="font-weight: bold;">{{ $appreciation }}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p id="dateAffichee"></p>
                                <p><span style="font-weight: bold;"> LE DIRECTEUR,</span></p>
                                @foreach ($responsables as $rep)
                                    <p><span style="font-weight: bold;">{{ $rep->name }} {{ $rep->prenom }}</span>
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Créez une instance de l'objet Date pour obtenir la date actuelle
        const dateActuelle = new Date();

        // Options pour formater la date
        const options = {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };

        // Utilisez Intl.DateTimeFormat pour formater la date selon les options
        const dateFormatee = new Intl.DateTimeFormat('fr-FR', options).format(dateActuelle);
        // Ajoutez "Fait le " devant la date formatée
        const dateAffichee = `Fait le ${dateFormatee}`;
        // Affichez la date affichée dans votre élément HTML (par exemple, avec un identifiant "dateAffichee")
        document.getElementById('dateAffichee').textContent = dateAffichee;
    </script>
</body>

</html>
