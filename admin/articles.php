<?php
declare(strict_types = 1);                             // Use strict types
include '../includes/database-connection.php';         // Database connection

$sql = "SELECT a.id, a.title, a.summary, a.created, a.category_id, a.member_id, a.published,
               c.name     AS category,
               CONCAT(m.forename, ' ', m.surname) AS author,
               i.file     AS image_file,
               i.alt      AS image_alt 
          FROM article    AS a
          JOIN category   AS c   ON a.category_id = c.id
          JOIN member     AS m   ON a.member_id   = m.id
          LEFT JOIN image AS i   ON a.image_id    = i.id
         ORDER BY a.id DESC;";                         // SQL to get article summaries
$articles = pdo($pdo, $sql)->fetchAll();               // Get article summaries
?>
<?php include '../includes/admin-header.php'; ?>
  <main class="container" id="content">
    <section class="header">
      <h1>Articles</h1>
    </section>
    <table>
      <tr>
        <th>Image</th><th>Title</th><th class="created">Created</th><th class="pub">Published</th><th class="edit">Edit</th><th class="del">Delete</th>
      </tr>
      <?php foreach ($articles as $article) { ?>
      <tr>
          <td><img width="150px" src="../uploads/<?=($article['image_file'] ?? 'blank.png') ?>"
                 alt="<?= ($article['image_alt']) ?>"></td>
        <td><strong><?= ($article['title']) ?></strong></td>
        <td><?= ($article['created']) ?></td>
        <td><?= ($article['published']) ? 'Yes' : 'No' ?></td>
        <td><a href="article.php?id=<?= $article['id'] ?>" class="btn btn-primary">Edit</a></td>
        <td><a href="article-delete.php?id=<?= $article['id'] ?>" class="btn btn-danger">Delete</a></td>
      </tr>
      <?php } ?>
    </table>
  </main>
<?php include '../includes/admin-footer.php'; ?>