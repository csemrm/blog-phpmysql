<?php
declare(strict_types = 1);                                    // Use strict types
http_response_code(404);                                      // Set HTTP response code
require_once '../includes/database-connection.php';              // Create PDO object

$sql = "SELECT id, name FROM category WHERE navigation = 1;"; // SQL to get categories
$navigation  = pdo($pdo, $sql)->fetchAll();                   // Get navigation categories
$section     = '';                                            // Current category
$title       = 'Page not found';                              // HTML <title> content
$description = '';                                            // Meta description content
?>
  <main class="container" id="content">
    <h1>Sorry! We cannot find that page.</h1>
    <p>Try the <a href="index.php">home page</a> or email us
      <a href="mailto:hello@eg.link">hello@eg.link</a></p>
  </main>