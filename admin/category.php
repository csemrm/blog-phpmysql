<?php
// Part A: Setup
declare(strict_types=1);
include '../src/bootstrap.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Get and validate id

$category = [
    'id' => $id,
    'name' => '',
    'description' => '',
    'navigation' => false,
];

if ($id) {
    $category = $cms->getCategory()->get($id);

    if ($_POST) {

        $category['name'] = $_POST['name'];
        $category['description'] = $_POST['description'];
        $category['navigation'] = (isset($_POST['navigation']) and ($_POST['navigation'] == 1)) ? 1 : 0; // Get navigation

        $result = $cms->getCategory()->update($category);
        if ($result) {
            header("Location: categories.php");
        }
    }
} else {

    if ($_POST) {

        $category['name'] = $_POST['name'];
        $category['description'] = $_POST['description'];
        $category['navigation'] = (isset($_POST['navigation']) and ($_POST['navigation'] == 1)) ? 1 : 0; // Get navigation
        unset($category['id']);
        $result = $cms->getCategory()->create($category);
        if ($result) {
            header("Location: categories.php");
        }
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
<main class="container admin" id="content">
    <form action="category.php?id=<?php echo $id ?>" method="post" class="narrow">
        <h1> <?php if ($id) { ?> 
                Edit <?php } else {
    ?> Add <?php } ?> Category</h1> 

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