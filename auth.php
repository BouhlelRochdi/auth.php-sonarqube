<?php
$data_base_host= 'sql11.freesqldatabase.com';
$database_name= 'sql11660786';
$database_username= 'sql11660786';
$db_password= 'GC4KIJHAby';
$db_port= '3306';

$loacal_data_base_host= 'localhost';
$loacal_database_name= 'securite_applicative';
$loacal_database_username= 'root';
$loacal_db_password= '';
$loacal_db_port= '3306';

$mysqli = new mysqli($loacal_data_base_host, $loacal_database_username, $loacal_db_password, $loacal_database_name, $loacal_db_port);

if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $login = $_POST["login"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Requête SQL pour vérifier les informations d'authentification
    $query = "SELECT * FROM users WHERE login = ? AND mot_de_passe = ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $login, $mot_de_passe);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Utilisateur authentifié avec succès
        $row = $result->fetch_assoc();
        echo json_encode(["message" => "Bonjour", "utilisateur" => $row]);
    } else {
        // Authentification échouée
        echo json_encode(["message" => "Échec de l'authentification"]);
    }
} else {
    // Formulaire d'authentification
    echo '<form method="post">
            <label for="login">Login :</label>
            <input type="text" name="login" required>
            <br>
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" name="mot_de_passe">
            <br>
            <input type="submit" value="Se connecter">
          </form>';
}

// Fermer la connexion à la base de données
$mysqli->close();
?>
