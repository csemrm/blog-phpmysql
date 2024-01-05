<?php
// Part A: Setup
declare(strict_types=1);                                // Use strict types
include '../includes/database-connection.php';            // Database connection
//
// Initialize variables

 $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Get and validate id



$category = [
    'id' => $id,
    'name' => '',
    'description' => '',
    'navigation' => false,
];                                                        // Initialize category array
$errors = [
    'warning' => '',
    'name' => '',
    'description' => '',
];                                                        // Initialize errors array
// If there was an id, page is editing the category, so get current category
if ($id) {                                                // If got an id
    $sql = "SELECT id, name, description, navigation 
              FROM category 
             WHERE id = :id;";                            // SQL statement
    $category = pdo($pdo, $sql, [$id])->fetch();          // Get category data
    
   
}
// PART B: Get and validate form data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {               // If form submitted
    $category['name'] = $_POST['name'];            // Get name
    $category['description'] = $_POST['description'];     // Get description
    $category['navigation'] = (isset($_POST['navigation']) and ($_POST['navigation'] == 1)) ? 1 : 0; // Get navigation
    // Check if all data is valid and create error messages if it is invalid 
    
     $category['id'] = $_POST['id'] ?? ''; 
     
    $arguments = $category;                           // Set arguments array for SQL
     
    if($id){
        
        $sql = "UPDATE `category` SET `name` = :name, `description` = :description, `navigation` = :navigation WHERE `category`.`id` = :id;";
        
    }else{
// If there is no id
        unset($arguments['id']);                      // Remove id from category array
        
        //INSERT INTO `category` (`name`, `description`, `navigation`) VALUES ( :name, :description, :navigation);
        $sql = "INSERT INTO category (name, description, navigation) 
                         VALUES (:name, :description, :navigation);"; // Create category
    }

    // When running the SQL, three things can happen:
    // Category saved | Name already in use | Exception thrown for other reason
    try {                                             // Start try block to run SQL
        pdo($pdo, $sql, $arguments);                 
        header('Location: categories.php');
        exit;
    } catch (PDOException $e) {                       // If a PDO exception was raised
        if ($e->errorInfo[1] === 1062) {              // If error indicates duplicate entry
            $errors['warning'] = 'Category name already in use'; // Store error message
        } else {                                      // Otherwise unexpected error
            throw $e;                                 // Re-throw exception
        }
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
<main class="container admin" id="content">
    <form action="category.php?id=<?php echo $id ?>" method="post" class="narrow">
        <h1> <?php if($id){ ?> 
            Edit <?php }else { 
                ?> Add <?php  } ?> Category</h1> 

        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name"
                   value="<?= ($category['name']) ?>" class="form-control">
            <span class="errors"><?= $errors['name'] ?></span>
        </div>

        <div class="form-group">
            <label for="description">Description: </label>
            <textarea name="description" id="description"
                      class="form-control"><?= ($category['description']) ?></textarea>
            <span class="errors"><?= $errors['description'] ?></span>
        </div>

        <div class="form-check">
            <input type="checkbox" name="navigation" id="navigation"
                   value="1" class="form-check-input" 
                   
                   
                   <?= ($category['navigation'] === 1) ? 'checked' : '' ?>
                   >
            <label class="form-check-label" for="navigation">Navigation</label>
        </div>
        <input type="hidden" value ="<?php echo $id ?>" name="id" />
        <input type="submit" value="Save" class="btn btn-primary btn-save">
    </form>
</main>
<?php include '../includes/admin-footer.php'; ?>