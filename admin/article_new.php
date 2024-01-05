<?php
// Part A: Setup
declare(strict_types=1);                                         // Use strict types
include '../includes/database-connection.php'; 

session_start();
$logged_in = $_SESSION['logged_in'] ?? false;  

if(!$logged_in){
    
   header('Location: index.php'); 
   exit();
}


// File upload settings
$uploads = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR; // Image upload folder
$file_types      = ['image/jpeg', 'image/png', 'image/gif',];      // Allowed file types
$file_extensions = ['jpg', 'jpeg', 'png', 'gif'];                 // Allowed extensions
$max_size        = '5242880';                                      // Max file size (NOTE .htaccess file settings take priority over this setting)




$temp = $_FILES['image']['tmp_name'] ?? '';                 // Temporary image
$destination = '';                                               // Where to save file
// Initialize variables that the HTML page needs
$article = [
    'id' => '',
    'title' => '',
    'summary' => '',
    'content' => '',
    'member_id' => 0,
    'category_id' => 0,
    'image_id' => null,
    'published' => false,
    'image_file' => '',
    'image_alt' => '',
];                                                                 // Article data
$errors = [
    'warning' => '',
    'title' => '',
    'summary' => '',
    'content' => '',
    'author' => '',
    'category' => '',
    'image_file' => '',
    'image_alt' => '',
];                                                                 // Error messages


$saved_image = $article['image_file'] ? true : false;       // Has an image been uploaded
// Get all members and all categories
$sql = "SELECT id, forename, surname FROM member;";     // SQL to get all members
$authors = pdo($pdo, $sql)->fetchAll();                     // Get all members

$sql = "SELECT id, name FROM category;";             // SQL to get all categories
$categories = pdo($pdo, $sql)->fetchAll();                  // Get all categories
//

// Part B: Get and validate form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {                 // If form submitted
    // If file bigger than limit in php.ini or .htaccess store error message - NOTE: Line updated from book
    $errors['image_file'] = ($temp === '' and $_FILES['image']['error'] === 1) ? 'File too big ' : '';

    // If image was uploaded, get image data and validate
    if ($temp and $_FILES['image']['error'] === 0) {                   // If file uploaded and no error
        $article['image_alt'] = $_POST['image_alt'];                   // Get alt text
        // Validate image file
      
        $uploadedmime = mime_content_type($temp);
        
        
        
        $errors['image_file'] = in_array($uploadedmime, $file_types )? '' : 'Wrong file type. ';    
        // Check file type
        
        
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)); // File extension in lowercase
        
        
        $errors['image_file'] .= in_array($extension, $file_extensions) ? '' : 'Wrong file extension. ';                           // Check file extension
        $errors['image_file'] .= ($_FILES['image']['size'] <= $max_size) ? '' : 'File too big. ';      
        
// Check size
        
        // If image file is valid, specify the location to save it
        if ($errors['image_file'] === '' and $errors['image_alt'] === '') { // If valid
            $article['image_file'] = create_filename($_FILES['image']['name'], $uploads);
            
           
              $destination = $uploads . $article['image_file'];         // Destination
           
           
        }
    }

    // Get article data
    $article['title'] = $_POST['title'];              // Title
    $article['summary'] = $_POST['summary'];            // Summary
    $article['content'] = $_POST['content'];            // Content
    $article['member_id'] = $_POST['member_id'];          // Author
    $article['category_id'] = $_POST['category_id'];        // Category
    $article['published'] = (isset($_POST['published']) and ($_POST['published'] == 1)) ? 1 : 0;   // Is it published?
    

// Validate article data and create error messages if it is invalid
    
    
    
    

    // Otherwise
    $arguments = $article;                                   // Save data as $arguments
    try {                                                    // Try to insert data
        $pdo->beginTransaction();                            // Start transaction
        if ($destination) {                                  // If have valid image 
           
           
            
            move_uploaded_file($temp,$destination);
           // $resized     = crop_and_resize_image_gd($destination, $thumbpath, 200, 200);
             
            $sql = "INSERT INTO image (file, alt) 
                        VALUES (:file, :alt);";                  // SQL to add image
            // Run SQL to add image to image table
            pdo($pdo, $sql, [$arguments['image_file'], $arguments['image_alt'],]);
            $arguments['image_id'] = $pdo->lastInsertId();   // Get new image id
        }
        unset($arguments['image_file'], $arguments['image_alt']); // Cut image data

        
            unset($arguments['id']);                         // Remove id
            $sql = "INSERT INTO article (title, summary, content, category_id, 
                                    member_id, image_id, published)
                             VALUES (:title, :summary, :content, :category_id, :member_id,  
                                    :image_id, :published);";    // SQL to create article
        

        // When running the SQL, three things can happen:
        // Article saved | Title already in use | Exception thrown for other reason
        pdo($pdo, $sql, $arguments);                         // Run SQL to add article
        $pdo->commit();                                      // Commit changes
        header("Location: articles.php");
    } catch (Exception $e) {                                 // If exception thrown
        $pdo->rollBack();                                    // Roll back SQL changes
        if (file_exists($destination)) {                     // If image file exists
            unlink($destination);                            // Delete image file
        }
        // If the exception was a PDOException and it was an integrity constraint
        if (($e instanceof PDOException) and ($e->errorInfo[1] === 1062)) {
            $errors['warning'] = 'Article name already in use'; // Store warning
        } else {                                             // Otherwise
            throw $e;                                        // Rethrow exception
        }
    }

    $article['image_file'] = $saved_image ? $article['image_file'] : ''; 
}
?>
<?php include '../includes/admin-header.php'; ?>
<form action="article_new.php" method="POST" enctype="multipart/form-data">
    <main class="container admin" id="content">

        <h1>Add Article </h1>
        <?php if ($errors['warning']) { ?>
            <div class="alert alert-danger"><?= $errors['warning'] ?></div>
        <?php } ?>

        <div class="admin-article">
            <section class="image">
               
                    <label for="image">Upload image:</label>
                    <div class="form-group image-placeholder">
                        <input type="file" name="image" accept="" class="form-control-file" id="image"><br>
                        <span class="errors"><?= $errors['image_file'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="image_alt">Alt text: </label>
                        <input type="text" name="image_alt" id="image_alt" value="" class="form-control">
                        <span class="errors"><?= $errors['image_alt'] ?></span>
                    </div>
                 
            </section>

            <section class="text">
                <div class="form-group">
                    <label for="title">Title: </label>
                    <input type="text" name="title" id="title" value=""
                           class="form-control">
                    <span class="errors"><?= $errors['title'] ?></span>
                </div>
                <div class="form-group">
                    <label for="summary">Summary: </label>
                    <textarea name="summary" id="summary"
                              class="form-control"></textarea>
                    <span class="errors"><?= $errors['summary'] ?></span>
                </div>
                <div class="form-group">
                    <label for="content">Content: </label>
                    <textarea name="content" id="content"
                              class="form-control"></textarea>
                    <span class="errors"><?= $errors['content'] ?></span>
                </div>
                <div class="form-group">
                    <label for="member_id">Author: </label>
                    <select name="member_id" id="member_id">
                        <?php foreach ($authors as $author) { ?>
                            <option value="<?= $author['id'] ?>"
                                    <?= ($article['member_id'] == $author['id']) ? 'selected' : ''; ?>>
                                <?= ($author['forename'] . ' ' . $author['surname']) ?></option>
                        <?php } ?>
                    </select>
                    <span class="errors"><?= $errors['author'] ?></span>
                </div>
                <div class="form-group">
                    <label for="category">Category: </label>
                    <select name="category_id" id="category">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?= $category['id'] ?>"
                                    <?= ($article['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?= ($category['name']) ?></option>
                        <?php } ?>
                    </select>
                    <span class="errors"><?= $errors['category'] ?></span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="published" value="1" class="form-check-input" id="published"
                           <?= ($article['published'] == 1) ? 'checked' : ''; ?>>
                    <label for="published" class="form-check-label">Published</label>
                </div>
                <input type="submit" name="update" value="Save" class="btn btn-primary">
            </section><!-- /.text -->
        </div><!-- /.admin-article -->
    </main>
</form>
<?php include '../includes/admin-footer.php'; ?>