<?php
$servername = "localhost";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=phpmysql", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

    $stmt = $conn->prepare("SELECT * FROM `category` WHERE `navigation` = 1;");

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    print_r($result);

    $categories = $stmt->fetchAll();
    ?>
    <pre>
        <?php
        print_r($categories);

        foreach ($categories as $key => $category) {
            echo $category['name']; 
            echo '<br/>';
        }
        ?>
    </pre>

    <?php
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<pre>
    
</pre>