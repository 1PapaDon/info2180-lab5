<?php
$host = 'localhost';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// get the country from URL (?country=...)
$country = $_GET['country'] ?? '';

if ($country) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<ul>
<?php foreach ($results as $row): ?>
    <li><?= $row['name'] . " is ruled by " . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>