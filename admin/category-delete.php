<?php
declare(strict_types=1);                                  // Use strict types
include '../includes/database-connection.php';            // Database connection

session_start();

$logged_in = $_SESSION['logged_in'] ?? false;  

if(!$logged_in){
    
   header('Location: index.php'); 
   exit();
}


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Get and validate id
$category = '';                                           // Initialize category name

if (!$id) {                                               // If no valid id
    header('Location: categories.php');
}

$sql = "SELECT * FROM category WHERE id = :id;";       // SQL to get category name
$category = pdo($pdo, $sql, [$id])->fetch();        // Get category name
if (!$category['name']) {                                         // If no category
    header('Location: categories.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {               // If form was submitted
    try {                                                 // Try to delete data
        $sql = "DELETE FROM category WHERE id = :id;";    // SQL statement
        pdo($pdo, $sql, [$_POST['id']]);                           // Run SQL
        header('Location: categories.php');
    } catch (PDOException $e) {                           // Catch exception
        if ($e->errorInfo[1] === 1451) {                  // If integrity constraint
            header('Location: categories.php');
        } else {                                          // Otherwise
            throw $e;                                     // Re-throw exception
        }
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
  <main class="container admin" id="content">
    <form action="category-delete.php?id=<?= $id ?>" method="POST" class="narrow">
      <h1>Delete Category</h1>
      <p>Click confirm to delete the category: <em><?= ($category['name']) ?></em></p>
       <input type="hidden" value ="<?php echo $id ?>" name="id" />
      <input type="submit" name="delete" value="Confirm" class="btn btn-primary">
      <a href="categories.php" class="btn btn-danger">Cancel</a>
    </form>
  </main>
<?php include '../includes/admin-footer.php'; ?>