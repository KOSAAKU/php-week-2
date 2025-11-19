<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
try {
    $mysqlClient = new PDO(
        'mysql:host=localhost;port=3306;dbname=jo;charset=utf8',
        'root',
        ''
    );
} catch (PDOException $e) {
    die($e->getMessage());
}

$query = $mysqlClient->prepare('SELECT * FROM `jo`.`100`');
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

$mysqlClient = null;
$dbh = null;
?>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Pays</th>
            <th>Course</th>
            <th>Temps</th>
        </tr>
    </thead>
<?php foreach ($data as $value) 
{ ?>
    <tr>
        <td><?php echo $value ["nom"]; ?></td>
        <td><?php echo $value ["pays"]; ?></td>
        <td><?php echo $value ["course"]; ?></td>
        <td><?php echo $value ["temps"]; ?>s</td>
    </tr>
<?php } ?>
</table>
<?php