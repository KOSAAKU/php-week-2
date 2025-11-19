<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
try {
    $mysqlClient = new PDO('mysql:host=localhost;port=3306;dbname=jo;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die($e->getMessage());
}


$sortColumn = 'nom';
$sortOrder = 'ASC';
if (isset($_GET['sort'])) 
{
    $sortColumn = $_GET['sort'];
}
if (isset($_GET['order'])) 
{
    $sortOrder = $_GET['order'];
}
$validColumns = ['nom','pays','course','temps'];
$validOrders  = ['ASC','DESC'];
if (!in_array($sortColumn,$validColumns))
{
     $sortColumn='nom';
}
if (!in_array($sortOrder,$validOrders))   
{
    $sortOrder='ASC'; 
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit = 10; 
$offset = ($page - 1) * $limit; 


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchSQL = "%$search%";


$message = '';
if (!empty($_POST) && isset($_POST['add'])) {
    $nom = $_POST['nom'];
    $pays = strtoupper($_POST['pays']); 
    $course = $_POST['course']; 
    $temps = $_POST['temps'];   

    if (strlen($pays) !== 3) $message = "Le pays doit faire 3 lettres."; 
    elseif (!is_numeric($temps)) $message = "Le temps doit être numérique."; 
    else {
        $ins = $mysqlClient->prepare("INSERT INTO `100` (nom,pays,course,temps) VALUES (?,?,?,?)");
        $ins->execute([$nom,$pays,$course,$temps]); 
        $message = "Ajout effectué";
    }
}


$coursesReq = $mysqlClient->query("SELECT DISTINCT course FROM `100` ORDER BY course");
$courses = $coursesReq->fetchAll(PDO::FETCH_COLUMN);


$countSql = "SELECT COUNT(*) FROM `100` WHERE nom LIKE ? OR pays LIKE ? OR course LIKE ?";
$countStmt = $mysqlClient->prepare($countSql);
$countStmt->execute([$searchSQL,$searchSQL,$searchSQL]);
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);


$sql = "SELECT * FROM `100` WHERE nom LIKE ? OR pays LIKE ? OR course LIKE ? ORDER BY $sortColumn $sortOrder LIMIT $offset,$limit";
$stmt = $mysqlClient->prepare($sql);
$stmt->execute([$searchSQL,$searchSQL,$searchSQL]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>100m</title>
</head>
<body>

<p><?php echo $message; ?></p> 


<form method="GET">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"> <!-- champ recherche -->
    <button type="submit">OK</button>
</form>
<br>

<table border="1" cellpadding="8">
<tr>
    <th><a href="?sort=nom&order=<?php echo ($sortOrder==='ASC'?'DESC':'ASC'); ?>&search=<?php echo $search; ?>">Nom</a></th>   <!-- tri nom -->
    <th><a href="?sort=pays&order=<?php echo ($sortOrder==='ASC'?'DESC':'ASC'); ?>&search=<?php echo $search; ?>">Pays</a></th>  <!-- tri pays -->
    <th><a href="?sort=course&order=<?php echo ($sortOrder==='ASC'?'DESC':'ASC'); ?>&search=<?php echo $search; ?>">Course</a></th> <!-- tri course -->
    <th><a href="?sort=temps&order=<?php echo ($sortOrder==='ASC'?'DESC':'ASC'); ?>&search=<?php echo $search; ?>">Temps</a></th>  <!-- tri temps -->
    <th>Classement</th> 
    <th>Modifier</th>   
</tr>

<?php
$i = 0;                   
$max = count($data);      
while ($i < $max) {       
    $row = $data[$i];     


    $rankStmt = $mysqlClient->prepare("SELECT COUNT(*)+1 FROM `100` WHERE course=? AND temps < ?");
    $rankStmt->execute([$row['course'], $row['temps']]);
    $classement = $rankStmt->fetchColumn();
?>
<tr>
    <td><?php echo $row['nom']; ?></td>        
    <td><?php echo $row['pays']; ?></td>       
    <td><?php echo $row['course']; ?></td>
    <td><?php echo $row['temps']; ?>s</td>
    <td><?php echo $classement; ?></td>
    <td><a href="edit.php?id=<?php echo $row['id']; ?>">Modifier</a></td> 
</tr>
<?php
    $i++; 
}
?>
</table>
<br>


<?php
$p = 1;
while ($p <= $totalPages) { 
    echo '<a href="?page='.$p.'&search='.$search.'&sort='.$sortColumn.'&order='.$sortOrder.'">'.$p.'</a> ';
    $p++;
}
?>

<br><br>

<form method="POST">
    <input type="hidden" name="add" value="1"> 
    Nom : <input type="text" name="nom"><br><br>
    Pays : <input type="text" name="pays"><br><br>

    Course :
    <select name="course"> 
        <?php
        $c = 0;
        $cc = count($courses);
        while ($c < $cc) { 
            echo '<option>'.$courses[$c].'</option>';
            $c++;
        }
        ?>
    </select><br><br>

    Temps : <input type="text" name="temps"><br><br>
    <button type="submit">Ajouter</button>
</form>

</body>
</html>
