<?php
$servername = "localhost";
$username = "root";
$password = "root";

$article_id = filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT);     // Validate id




try {
    $conn = new PDO("mysql:host=$servername;dbname=phpmysql", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";

    $stmt = $conn->prepare("SELECT * FROM `category` WHERE `navigation` = 1;");

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $categories = $stmt->fetchAll();

    //SELECT * FROM `article` WHERE `category_id` = 2
//SELECT * FROM `article` WHERE `id` = 1
//SELECT article.id as article_id, `title`,`summary`,`content`,`created` , member.forename, member.surname, member_id, member.id as member_table_id FROM `article` left JOIN member on article.member_id = member.id WHERE article.id = 3;
   
    $query = $conn->prepare("SELECT article.id as article_id, `title`,`summary`,`content`,`created` , member.forename, member.surname, member_id, member.id as member_table_id FROM `article` left JOIN member on article.member_id = member.id WHERE article.id = :article_id ;");
    $query->bindParam(':article_id', $article_id);
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->execute();

    $article = $query->fetch();

    $category_id = $article['category_id'];

    $stmt = $conn->prepare("SELECT * FROM `category` WHERE `id` = :category_id;");
    $stmt->bindParam(':category_id', ($category_id), PDO::PARAM_INT);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    
    $categoryone = $stmt->fetch();
    
     
    $stmt = $conn->prepare("SELECT * FROM `article` WHERE published=1 ORDER BY rand() LIMIT 3;");

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $randArticles = $stmt->fetchAll();
   
    ?>


    <?php
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> 


<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="css/fonts.css"/>
        <link href="css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <title><?php echo $article['title']  ?></title>
    </head>
    <body>
        <div class="container-fluid bg-dark">

            <!-- skip links for screen readers -->
            <span class="sr-only">
                <a href="#posts">Go to main content</a>
                <a href="#sidebar">Go to sitebar</a>
            </span>

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="./">
                    <img src="./img/cihuatl.png" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <?php
                                foreach ($categories as $key => $category) { 
                                    ?>
                                    <li><a class="dropdown-item" href="category.php?category_id=<?php echo $category['id'] ?>"><?php echo $category['name']; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>

                    </ul>
                    <div class="form-inline my-2 my-lg-0 text-light">
                        <a href="#" data-toggle="modal" data-target="#searchModal" class="text-light">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-light">
                                    <h5 class="modal-title" id="searchModalLabel">Search</h5>
                                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="my-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2" />
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <header class="container py-5" id="header">
            <h1><a href="./index.html">Cihuatl</a></h1>
            <p class="site-description">A life without limits</p>
        </header>

        <div class="container-fluid" id="content-wrapper">
            <div class="container" id="main">
                <div class="row">
                    <section class="col-12 col-md-8 col-lg-9" id="posts">
                        <article class="post">
                            <header class="post-header text-center mb-3">
                                <div class="post-title">
                                    <a href="#">
                                        <h2><?php echo $article['title'] ?></h2>
                                    </a>
                                </div>
                                <div class="post-header-line-1">
                                    <div class="post-date">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>  
                                            <?php
                                        $date = date_create_from_format('Y-m-d H:i:s', $article['created']);
                                        echo $date->format('d / m / Y');
                                        ?>
                                    </div>
                                    <div class="post-tags">
                                        <a href="#">Health</a>
                                        <a href="#">Life</a>
                                    </div>
                                    <div class="post-author">
                                        <span>by </span> <?php echo $article['forename']; ?>
                                    </div>
                                </div>
                            </header>
                            <main class="post-body">
                                <?php echo $article['content'] ?>
                            </main>
                            <footer class="post-footer row">
                                <div class="post-share col-6 text-left">
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                </div>
                                <div class="post-comments-number col-6 text-right">
                                    <a href="#">3 Comments</a>
                                </div>
                            </footer>
                        </article>

                        <div id="author-box">
                            <div class="author-box-avatar">
                                <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block" width="250" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                            </div>
                            <div class="author-box-name">
                                <a href="#">Cihuatl</a>
                            </div>
                            <div class="author-box-description">
                                <p>Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis. Ne malorum ceteros feugait quo, ius ea liber offendit placerat, est habemus aliquyam legendos id.</p>
                            </div>
                        </div>

                        <div id="post-navigation" class="container">
                            <div class="row">
                                <div id="next-post" class="col-12 col-sm-6">
                                    <div class="nav-post-thumb">
                                        <a href="#">
                                            <svg class="bd-placeholder-img bd-placeholder-img-lg d-block" width="125" height="75" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                        </a>
                                    </div>
                                    <div class="nav-post-info d-flex align-items-center">
                                        <a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i> Next post</a>
                                    </div>
                                </div>
                                <div id="previous-post" class="col-12 col-sm-6">
                                    <div class="nav-post-thumb">
                                        <a href="#">
                                            <svg class="bd-placeholder-img bd-placeholder-img-lg d-block" width="125" height="75" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                        </a>
                                    </div>
                                    <div class="nav-post-info d-flex align-items-center justify-content-end">
                                        <a href="#">Previous post <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="related-posts">
                            <h5>Related posts</h5>
                            <div class="related-post-list row">
                                <?php foreach ($randArticles as $article) {?>
                                
                                <div class="related-post col-6 col-sm-4">
                                    <div class="related-post-thumb">
                                        <a href="#">
                                            <svg class="bd-placeholder-img bd-placeholder-img-lg d-block" width="125" height="75" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                        </a>
                                    </div>
                                    <div class="related-post-info">
                                        <a href="#">Design</a> <a href="#">Fashion</a>
                                    </div>
                                    <div class="related-post-title">
                                        <a href="#">Mexico most beautiful beachs</a>
                                    </div>
                                </div>
                                
                                <?php } ?>
                            </div>
                        </div>

                        <div id="comments">
                            <h4>Comments</h4>
                            <div class="comment-block">
                                <div class="comment">
                                    <div class="comment-avatar">
                                        <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block" width="100" height="100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <cite class="fn"><a href="#">Francisco</a></cite>
                                            <span>20 July 2021</span>
                                        </div>
                                        <div class="comment-body">
                                            Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis. Ne malorum ceteros feugait quo, ius ea liber offendit placerat.
                                        </div>
                                        <div class="reply">
                                            <a href="#">Reply</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-replies">
                                    <div class="comment">
                                        <div class="comment-avatar">
                                            <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block" width="100" height="100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                        </div>
                                        <div class="comment-content">
                                            <div class="comment-meta">
                                                <cite class="fn"><a href="#">Cihuatl</a></cite>
                                                <span>20 July 2021</span>
                                            </div>
                                            <div class="comment-body">
                                                Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis. Ne malorum ceteros feugait quo, ius ea liber offendit placerat.
                                            </div>
                                            <div class="reply">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-block">
                                <div class="comment">
                                    <div class="comment-avatar">
                                        <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block" width="100" height="100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <cite class="fn"><a href="#">OpenThemes.com</a></cite>
                                            <span>20 July 2021</span>
                                        </div>
                                        <div class="comment-body">
                                            Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis. Ne malorum ceteros feugait quo, ius ea liber offendit placerat.
                                        </div>
                                        <div class="reply">
                                            <a href="#">Reply</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="comment-form">
                            <h4>Leave your comment</h4>
                            <form action="#">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <input type="text" id="user-name" class="form-control" name="name" placeholder="Name*" required />
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="text" id="user-email" class="form-control" name="emal" placeholder="Email*" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input typeof="text" id="user-url" class="form-control" name="url" placeholder="URL">
                                </div>
                                <div class="form-group">
                                    <label for="user-comment-content">Message*</label>
                                    <textarea class="form-control" id="user-comment-content" rows="6"></textarea>
                                </div>
                                <button type="submit" class="btn btn-outline-dark mb-2">Submit</button>
                            </form>
                        </div>

                    </section>

                    <aside class="col-12 col-md-4 col-lg-3" id="sidebar">
                        <div class="widget search-form">
                            <h2>Search</h2>
                            <div class="widget-content">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tags widget">
                            <h2>Categories</h2>
                            <div class="widget-content">
                                <ul>
                                     <?php
                                foreach ($categories as $key => $category) { 
                                    ?> <li>
                                        <a href="category.php?category_id=<?php echo $category['id'] ?>"><span><?php echo $category['name']; ?></span></a>
                                    </li>                                   
 <?php
                                }
                                ?>
                                   
                                </ul>
                            </div>
                        </div>

                        <div class="popular-posts widget">
                            <h2>Popular posts</h2>
                            <div class="widget-content">
                                <?php foreach ($randArticles as $key=> $article){ ?>
                                <a href="single.php?article_id=<?php echo $article['id'] ?>">
                                    <div class="popular-thumbnail">
                                        <svg class="border-light bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="65" height="65" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Post thumbnail</text></svg>
                                    </div>
                                    <div class="info">
                                        <div class="popular-post-title"><?php echo $article['title'] ?></div>
                                        <div class="popular-post-description"><?php echo $article['summary'] ?>.</div>
                                    </div>
                                </a> 
                                <?php } ?>
                            </div>
                        </div>

                        <div class="widget email-subscription">
                            <h2>Subscribe!</h2>
                            <div class="widget-content">
                                <p class="widget-description">Subscribe for free to get 1 mail per week.</p>
                                <form  class="form-inline">
                                    <label class="sr-only" for="inlineFormInputGroupEmail2">Email</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input type="text" class="form-control" aria-describedby="button-addon3" id="inlineFormInputGroupEmail2" placeholder="Email">
                                        <div class="input-group-append">
                                            <button class="btn bg-dark text-light" type="button" id="button-addon3">
                                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="widget profile">
                            <h2>About me</h2>
                            <div class="widget-content">
                                <div class="profile-avatar">
                                    <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="300" height="300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Image</text></svg>
                                </div>
                                <div class="profile-name">Cihuatl Ixta</div>
                                <div class="profile-description">Hello there! My name is Cihuatl, I'm a beautiful template from OpenThemes.com</div>
                            </div>
                        </div>

                        <div class="widget social">
                            <h2>Follow me</h2>
                            <div class="widget-content">
                                <a href="#"><i class="fa fa-firefox  d-flex justify-content-center align-items-center" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-youtube  d-flex justify-content-center align-items-center" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-facebook  d-flex justify-content-center align-items-center" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter  d-flex justify-content-center align-items-center" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram  d-flex justify-content-center align-items-center" aria-hidden="true"></i></a>
                            </div>
                        </div>

                    </aside>
                </div>
            </div>
        </div>

        <footer class="container-fluid bg-dark text-light" id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4" id="footer-1">

                        <div class="widget tags-cloud">
                            <h2>Topics</h2>
                            <div class="widget-content">
                                <span class="label-size label-size-5">
                                    <a dir="ltr" href="#">Blog</a>
                                </span>
                                <span class="label-size label-size-4">
                                    <a dir="ltr" href="#">Campus</a>
                                </span>
                                <span class="label-size label-size-5">
                                    <a dir="ltr" href="#">Courses</a>
                                </span>
                                <span class="label-size label-size-4">
                                    <a dir="ltr" href="#">Open Source</a>
                                </span>
                                <span class="label-size label-size-3">
                                    <a dir="ltr" href="#">Python</a>
                                </span>
                                <span class="label-size label-size-5">
                                    <a dir="ltr" href="#">Spanish</a>
                                </span>
                                <span class="label-size label-size-3">
                                    <a dir="ltr" href="#">Testimonials</a>
                                </span>
                                <span class="label-size label-size-1">
                                    <a dir="ltr" href="#">Videos</a>
                                </span>
                                <span class="label-size label-size-4">
                                    <a dir="ltr" href="#">WordPress</a>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-sm-6 col-lg-4" id="footer-2">

                        <div class="widget links-list">
                            <h2>Blogroll</h2>
                            <div class="widget-content">
                                <ul>
                                    <li><a href="https://openthemes.com">Open Themes</a></li>
                                    <li><a href="https://blogandweb.com">Blog and Web</a></li>
                                    <li><a href="https://btemplates.com">Blogger Templates</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-sm-6 col-lg-4" id="footer-3">

                        <div class="widget">
                            <h2>Latest comments</h2>
                            <div class="widget-content">
                                <a href="#" class="lt-comment">
                                    <div class="lt-comment-avatar">
                                        <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="50" height="50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Ava</text></svg>
                                    </div>
                                    <div class="lt-comment-content">
                                        <span class="lt-comment-author">Francisco:</span> Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis.
                                    </div>
                                </a>
                                <a href="#" class="lt-comment">
                                    <div class="lt-comment-avatar">
                                        <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="50" height="50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Ava</text></svg>
                                    </div>
                                    <div class="lt-comment-content">
                                        <span class="lt-comment-author">OpenThemes:</span> Democritum ei nam, doming neglegentur ad vis.
                                    </div>
                                </a>
                                <a href="#" class="lt-comment">
                                    <div class="lt-comment-avatar">
                                        <svg class="border-light rounded-circle bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="50" height="50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Ava</text></svg>
                                    </div>
                                    <div class="lt-comment-content">
                                        <span class="lt-comment-author">Francisco:</span> Yep.
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </footer>

        <div class="container-fluid" id="bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 mb-3 mb-md-0" id="you-can-modify-this-as-you-want">
                        <span>&copy; 2020. <a href="">MySite.com</a></span>
                    </div>
                    <div class="col-12 col-md-7 text-md-right" id="please-dont-change">
                        <p><span class="heart"><i class="fa fa-heart" aria-hidden="true"></i></span> Designed by <a href="https://openthemes.com/">OpenThemes</a>.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href='javascript:void(0)' id='back-top'>
            <i class='fa fa-angle-up'></i>
        </a>

        <script src="js/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

        <script type="text/javascript">
            $j = jQuery.noConflict();
            $j(document).ready(function () {
                var stickyNavigation = $j('nav.navbar.navbar-dark');
                $j(window).scroll(function () {
                    if ($j(this).scrollTop() > 200) {
                        stickyNavigation.addClass('sticky');
                    } else {
                        stickyNavigation.removeClass('sticky');
                    }
                });

                //Empty search string
                $j(".search-form button").on("click", function () {
                    var search = $j(this).parent().siblings("input");
                    if (search.val() === "") {
                        search.focus();
                        return false;
                    }
                });

                //Back to top
                $j(window).scroll(function () {
                    $j(this).scrollTop() > 400 ? $j("#back-top").fadeIn() : $j("#back-top").fadeOut()
                });
                $j("#back-top").click(function () {
                    return $j("body,html").animate({scrollTop: 0}, 800), !1
                });

                $j(function () {
                    $j("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        $j(this).siblings().toggleClass("show");


                        if (!$j(this).next().hasClass('show')) {
                            $j(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                        }
                        $j(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                            $j('.dropdown-submenu .show').removeClass("show");
                        });

                    });
                });

            });
        </script>
    </body>
</html>
