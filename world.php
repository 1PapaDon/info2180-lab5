<?php
// Database connection
$host = 'localhost';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<p>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? '';

if ($lookup === 'cities') {
    $stmt = $conn->prepare(
        "SELECT cities.name, cities.district, cities.population 
         FROM cities 
         JOIN countries ON cities.country_code = countries.code 
         WHERE countries.name LIKE :country"
    );
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) === 0) {
        echo "<p>No cities found for \"" . htmlspecialchars($country) . "\".</p>";
    } else {
        ?>
        <table>
            <caption>Cities in "<?= htmlspecialchars($country); ?>"</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['district']); ?></td>
                    <td><?= number_format($row['population']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }
} else {
    if ($country) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) === 0) {
        echo "<p>No countries found matching \"" . htmlspecialchars($country) . "\".</p>";
    } else {
        ?>
        <table>
            <caption>Countries matching "<?= htmlspecialchars($country); ?>"</caption>
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['continent']); ?></td>
                    <td><?= htmlspecialchars($row['independence_year'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($row['head_of_state'] ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }
}
?>