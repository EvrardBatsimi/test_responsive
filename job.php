<?php
//? Je récupère mon fichier de connexion à la base de données
require_once("db_connect.php");

//? Je récupère mon fichier contenant mes fonctions
require("function.php");

//? Si j'ai toutes les valeurs de mon formulaire dans la superglobale $_POST ET que j'ai dans l'url un paramètre id et un parametre action ET que mon parametre action=update ALORS j'accède à la suite
if (isset($_POST['job_id'], $_POST['job_title'], $_POST['min_salary'], $_POST['max_salary'], $_GET['id'], $_GET['action']) && $_GET['action'] == "update") {
    //? Si le salaire max est supérieur ou égal au salaire minimum ALORS j'accède à la mise à jour
    if ($_POST['max_salary'] >= $_POST['min_salary']) {

        //* J'effectue la mise à jour
        $sql = "UPDATE jobs SET job_id='{$_POST['job_id']}', job_title='{$_POST['job_title']}', min_salary={$_POST['min_salary']}, max_salary={$_POST['max_salary']} WHERE job_id = '{$_GET['id']}'";
        $db->query($sql);

        //* Je redirige l'utilisateur sur mon fichier sans paramètre dans l'url pour pouvoir de nouveau ajouter de nouveaux jobs
        header("Location: job.php");
    } else echo "Le salaire maximum est inférieur au salaire minimum. C'est impossible."; //! Sinon j'affiche un message d'erreur
}

//* J'initialise une variable $to_update avec un tableau contenant chaque clés de mon formulaire à null pour eviter une erreur de variable non définie si jamais je ne rentre pas dans le if si dessous
$to_update = ['job_id' => null, 'job_title' => null, 'min_salary' => 0, 'max_salary' => 0];

//? Si j'ai un parametre id et un parametre action dans mon url ET si le parametre action=update
if (isset($_GET['id'], $_GET['action']) && $_GET['action'] == "update") {

    //* J'effectue une selection de toutes les informations du job correspondant à l'id passé en parametre dans l'url
    $res = $db->query("SELECT * FROM jobs WHERE job_id = '{$_GET['id']}'");
    $to_update = resultAsArray($res)[0];
}

//? Si j'ai toutes les valeurs de mon formulaire dans la superglobale $_POST et que le parametre action de mon url est différent de `update`
if (isset($_POST['job_id'], $_POST['job_title'], $_POST['min_salary'], $_POST['max_salary']) && $_GET['action'] != "update") {

    //? Si le salaire max est supérieur ou égal au salaire minimum ALORS j'accède à la mise à jour
    if ($_POST['max_salary'] >= $_POST['min_salary']) {
        $sql = "INSERT INTO jobs (job_id, job_title, min_salary, max_salary) VALUES ('{$_POST['job_id']}', '{$_POST['job_title']}', {$_POST['min_salary']}, {$_POST['max_salary']})";
        $db->query($sql);
    } else echo "Le salaire maximum est inférieur au salaire minimum. C'est impossible."; //! Sinon j'affiche un message d'erreur
}

//* Je selectionne tous les jobs de la bdd
$res = $db->query("SELECT * FROM jobs");
//* Je les récupère sous forme de tableau
$jobs = resultAsArray($res);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
</head>

<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Intitulé</th>
            <th>Salaire min</th>
            <th>Salaire max</th>
            <th>Modifier</th>
        </tr>

        <?php
        //* J'affiche les jobs sous forme d'une table HTML
        foreach ($jobs as $job) {
            echo "<tr>" .
                "<td>{$job['job_id']}</td>" .
                "<td>{$job['job_title']}</td>" .
                "<td>{$job['min_salary']}</td>" .
                "<td>{$job['max_salary']}</td>" .
                //? Je crée un lien qui redirige vers la page actuelle en ajoutant des parametres dans l'url afin de préremplir les champs de mon formulaire et de pouvoir effectuer la mise à jour d'un job
                "<td><a href='job.php?id={$job['job_id']}&action=update'>Modifier</a></td>" .
                "</tr>";
        }
        ?>
    </table>

    <form method="POST">
        <!-- J'affecte à mes différents champs les valeurs de $to_update (soit null soit celles du select pour la mise à jour) -->
        <input type="text" name="job_id" placeholder="Job ID" value="<?php echo $to_update['job_id']; ?>">

        <input type="text" name="job_title" placeholder="Intitulé" value="<?php echo $to_update['job_title']; ?>">

        Min:<input type="number" name="min_salary" min="0" value="<?php echo $to_update['min_salary']; ?>">
        Max:<input type="number" name="max_salary" min="0" value="<?php echo $to_update['max_salary']; ?>">

        <input type="submit" value="Ajouter">
    </form>
</body>

</html>