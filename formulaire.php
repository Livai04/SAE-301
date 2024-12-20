<?php
include 'class/database.php';
include 'class/recup_form.php';
include 'class/Inscription.php';
include 'class/Formation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $db->connect();

    // Validation des données reçues
    $errors = [];
    $civilite = trim($_POST['civilite'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $departement = trim($_POST['departement'] ?? '');
    $code_postal = trim($_POST['code_postal'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $niveau = trim($_POST['niveau'] ?? '');
    $commentaire = trim($_POST['commentaire'] ?? '');
    $idFormation = $_POST['id_formations'] ?? null;

    // Validation
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Une adresse email valide est requise.";
    }

    if (!empty($errors)) {
        die(implode("<br>", $errors));
    }

    // Traitement si aucune erreur
    $form = new RecupForm($_POST);
    $inscription = new Inscription($db);

    try {
        $inscription->save($form, $idFormation);
        echo "Inscription réussie !";
    } catch (Exception $e) {
        echo "Erreur lors de l'inscription : " . $e->getMessage();
    }

    $db->disconnect();
}
?>
    
    <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plongée Sous-Marine CVP43</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Texte à gauche -->
            <div class="col-md-6">
                <h1 class="form-label">Découvrez la plongée sous-marine avec CVP43 !</h1>
                <p class="form-label">
                    Plongez dans une aventure inoubliable avec notre formation de plongée sous-marine. Que vous soyez
                    débutant ou passionné en quête de perfectionnement, nos cours sont adaptés à tous les niveaux.
                    Encadrés par des professionnels expérimentés, vous apprendrez les techniques essentielles pour
                    explorer les fonds marins en toute sécurité et avec confiance.
                </p>
            </div>
            <!-- Image à droite -->
            <div class="col-md-6 text-center">
                <img src="images/tortue.png" alt="Tortue de mer" class="img-fluid tortue">
            </div>
        </div>
    </div>

    <!-- Formulaire dans un conteneur -->
    <div class="container my-5">
        <form class="form-section">
            <div class="mb-4">
                <label class="form-label">Civilité :</label>
                <div>
                    <input type="radio" name="civilite" id="madame" value="Madame" checked>
                    <label for="madame" class="ms-2">Madame</label>
                    <input type="radio" name="civilite" id="monsieur" value="Monsieur" class="ms-3">
                    <label for="monsieur" class="ms-2">Monsieur</label>
                    <input type="radio" name="civilite" id="autre" value="Autre" class="ms-3">
                    <label for="autre" class="ms-2">Autre</label>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" id="nom" class="custom-input form-control" placeholder="Nom">
                </div>
                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" id="prenom" class="custom-input form-control" placeholder="Prénom">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" id="email" class="custom-input form-control" placeholder="Email">
                </div>
                <div class="col-md-6">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" id="telephone" class="custom-input form-control" placeholder="Téléphone">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" id="adresse" class="custom-input form-control" placeholder="Adresse">
                </div>
                <div class="col-md-6">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" id="ville" class="custom-input form-control" placeholder="Ville">
                </div>
                <div class="col-md-6">
                    <label for="departement" class="form-label">Département</label>
                    <input type="text" id="departement" class="custom-input form-control" placeholder="Département">
                </div>
                <div class="col-md-6">
                    <label for="codepostal" class="form-label">Code Postal</label>
                    <input type="text" id="codepostal" class="custom-input form-control" placeholder="Code Postal">
                </div>
            </div>

            <div class="row g-3 mt-4">
                <!-- Champ Niveau -->
                <div class="col-md-6">
                    <label for="niveau" class="form-label">Niveau</label>
                    <select id="niveau" class="custom-input form-control">
                        <option selected disabled>Choisissez votre niveau de plongée</option>
                        <option value="debutant">Débutant</option>
                        <option value="intermediaire">Intermédiaire</option>
                        <option value="avance">Avancé</option>
                    </select>
                </div>

                <!-- Champ Commentaires -->
                <div class="col-md-6">
                    <label for="commentaires" class="form-label">Commentaires Supplémentaires</label>
                    <textarea id="commentaires" rows="3" class="custom-input form-control" placeholder="Votre commentaire"></textarea>
                </div>
            </div>

            <div class="button-container mt-4">
                <button type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
