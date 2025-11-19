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

$sortColumn = 'nom';
$sortOrder = 'ASC';
$errorMessage = '';

if (isset($_GET['sort'])) {
    $sortColumn = $_GET['sort'];
}

if (isset($_GET['order'])) {
    $sortOrder = $_GET['order'];
}

$validColumns = ['nom', 'pays', 'course', 'temps'];
$validOrders = ['ASC', 'DESC'];

if (!in_array($sortColumn, $validColumns, true)) {
    $errorMessage = 'Paramètre de tri inconnu — tri par défaut appliqué.';
    $sortColumn = 'nom';
}

$query = $mysqlClient->prepare('SELECT * FROM `jo`.`100` ORDER BY ' . $sortColumn . ' ' . $sortOrder);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

$mysqlClient = null;
$dbh = null;
?>
<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th><a href="?sort=nom&order=<?php echo ($sortColumn === 'nom' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Nom <?php echo ($sortColumn === 'nom') ? (($sortOrder === 'ASC') ? '↑' : '↓') : ''; ?></a></th>
            <th><a href="?sort=pays&order=<?php echo ($sortColumn === 'pays' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Pays <?php echo ($sortColumn === 'pays') ? (($sortOrder === 'ASC') ? '↑' : '↓') : ''; ?></a></th>
            <th><a href="?sort=course&order=<?php echo ($sortColumn === 'course' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Course <?php echo ($sortColumn === 'course') ? (($sortOrder === 'ASC') ? '↑' : '↓') : ''; ?></a></th>
            <th><a href="?sort=temps&order=<?php echo ($sortColumn === 'temps' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Temps <?php echo ($sortColumn === 'temps') ? (($sortOrder === 'ASC') ? '↑' : '↓') : ''; ?></a></th>
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