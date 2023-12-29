<?php
$servername = "localhost";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=phpmysql", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";

    $stmt = $conn->prepare("SELECT * FROM `category` WHERE `navigation` = 1;");

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $categories = $stmt->fetchAll();
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

        <title>Cihuatl CSS Template</title>
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
                                   // echo $category['name'];
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
            <h1><a href="#">Cihuatl</a></h1>
            <p class="site-description">A life without limits</p>
        </header>

        <div class="container mb-4">
            <div id="slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#slider" data-slide-to="0" class="active"></li>
                    <li data-target="#slider" data-slide-to="1"></li>
                    <li data-target="#slider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="550" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">First slide</text></svg>
                        <div class="carousel-caption d-none d-md-block">
                            <a href="./single.html"><h5>First slide label</h5></a>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="550" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Second slide</text></svg>
                        <div class="carousel-caption d-none d-md-block">
                            <a href="./single.html"><h5>Second slide label</h5></a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="550" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Thrid slide</text></svg>
                        <div class="carousel-caption d-none d-md-block">
                            <a href="./single.html"><h5>Third slide label</h5></a>
                            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="container-fluid" id="content-wrapper">
            <div class="container" id="main">
                <div class="row">
                    <section class="col-12 col-md-8 col-lg-9" id="posts">
                        <article class="post">
                            <header class="post-header text-center mb-3">
                                <div class="post-title">
                                    <a href="./single.html">
                                        <h2>Healthy life</h2>
                                    </a>
                                </div>
                                <div class="post-header-line-1">
                                    <div class="post-date">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i> 16 / 06 / 2020
                                    </div>
                                </div>
                            </header>
                            <main class="post-body">
                                <div class="post-thumbnail">
                                    <div class="post-tags">
                                        <a href="#">Health</a>
                                        <a href="#">Life</a>
                                    </div>
                                    <div class="post-author">
                                        <span>by </span> Francisco
                                    </div>
                                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block" width="800" height="400" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Post thumbnail</text></svg>
                                </div>
                                <div class="post-content">
                                    <p>Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis. Ne malorum
                                        ceteros feugait quo, ius ea liber offendit placerat, est habemus aliquyam legendos id.
                                        Eam no corpora maluisset definitiones, eam mucius malorum id. Quo ea idque commodo utroque,
                                        per ex eros etiam accumsan.</p>
                                </div>
                            </main>
                            <footer class="post-footer row">
                                <div class="read-more col-12 col-sm-4 text-center text-sm-left">
                                    <a href="./single.html">Read more <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                                <div class="post-share col-6 col-sm-4 text-left text-sm-center">
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                </div>
                                <div class="post-comments-number col-6 col-sm-4 text-right">
                                    <a href="./single.html#comments"></a>3 Comments</a>
                                </div>
                            </footer>
                        </article>
                        <article class="post">
                            <header class="post-header text-center mb-3">
                                <div class="post-title">
                                    <a href="./single.html">
                                        <h2>Great Movies</h2>
                                    </a>
                                </div>
                                <div class="post-header-line-1">
                                    <div class="post-date">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i> 16 / 06 / 2020
                                    </div>
                                </div>
                            </header>
                            <main class="post-body">
                                <div class="post-thumbnail">
                                    <div class="post-tags">
                                        <a href="#">Health</a>
                                        <a href="#">Life</a>
                                    </div>
                                    <div class="post-author">
                                        <span>by </span> Francisco
                                    </div>
                                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block" width="800" height="400" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Post thumbnail</text></svg>
                                </div>
                                <div class="post-content">
                                    <p>Ea eam labores imperdiet, apeirian democritum ei nam, doming neglegentur ad vis. Ne malorum
                                        ceteros feugait quo, ius ea liber offendit placerat, est habemus aliquyam legendos id.
                                        Eam no corpora maluisset definitiones, eam mucius malorum id. Quo ea idque commodo utroque,
                                        per ex eros etiam accumsan.</p>
                                </div>
                            </main>
                            <footer class="post-footer row">
                                <div class="read-more col-12 col-sm-4 text-center text-sm-left">
                                    <a href="./single.html">Read more <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                                <div class="post-share col-6 col-sm-4 text-left text-sm-center">
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                </div>
                                <div class="post-comments-number col-6 col-sm-4 text-right">
                                    <a href="./single.html#comments">3 Comments</a>
                                </div>
                            </footer>
                        </article>
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
                                    <li>
                                        <a href="#"><span>Health</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><span>Travel</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><span>Education</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="popular-posts widget">
                            <h2>Popular posts</h2>
                            <div class="widget-content">
                                <a href="single.html">
                                    <div class="popular-thumbnail">
                                        <svg class="border-light bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="65" height="65" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Post thumbnail</text></svg>
                                    </div>
                                    <div class="info">
                                        <div class="popular-post-title">The best venues in town.</div>
                                        <div class="popular-post-description">Lorem ipsum dolor kiasi dulum tunik morum.</div>
                                    </div>
                                </a>
                                <a href="single.html">
                                    <div class="popular-thumbnail">
                                        <svg class="border-light bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="65" height="65" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Post thumbnail</text></svg>
                                    </div>
                                    <div class="info">
                                        <div class="popular-post-title">Great movies.</div>
                                        <div class="popular-post-description">Lorem morum isueridium ipsum dolor kiasi dulum tunik morum.</div>
                                    </div>
                                </a>
                                <a href="single.html">
                                    <div class="popular-thumbnail">
                                        <svg class="border-light bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="65" height="65" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Post thumbnail</text></svg>
                                    </div>
                                    <div class="info">
                                        <div class="popular-post-title">Best courses about Artificial Intelligence.</div>
                                        <div class="popular-post-description">Lorem morum isueridium ipsum dolor kiasi dulum tunik morum.</div>
                                    </div>
                                </a>
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
