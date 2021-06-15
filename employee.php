<?php
require_once("db_connect.php");
require_once("fonction.php");

// Je récupère les données de tous les employés en bdd
$res = $db->query("SELECT * FROM employees");
// Je transforme mon résultat sous forme de tableau (je facilite la manipulation de mes données)
$employees = resultAsArray($res);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employés</title>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;
        }
</style>
</head>

<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date d'embauche</th>
            <th>Job ID</th>
            <th>Salaire</th>
            <th>Commission</th>
            <th>Manager ID</th>
            <th>Departement ID</th>
        </tr>

        <?php
        // J'itère sur mon tableau d'employés pour afficher leur données
        foreach ($employees as $employee) {
            echo "<tr>" .
                "<td>{$employee['employee_id']}</td>" .
                "<td>{$employee['first_name']}</td>" .
                "<td>{$employee['last_name']}</td>" .
                "<td>{$employee['email']}</td>" .
                "<td>{$employee['phone_number']}</td>" .
                "<td>{$employee['hire_date']}</td>" .
                "<td>{$employee['job_id']}</td>" .
                "<td>{$employee['salary']}</td>" .
                "<td>{$employee['commission_pct']}</td>" .
                "<td>{$employee['manager_id']}</td>" .
                "<td>{$employee['department_id']}</td>" .
                "</tr>";
        }
        ?>
    </table>
</body>

</html>