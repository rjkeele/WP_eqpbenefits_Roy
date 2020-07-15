<?php
/**
 *  The template for displaying Page Contact.
 *
 * @package ThemeIsle.
 *
 *    Template Name: Enroller
 */
session_start();
if (!isset($_SESSION['dob']) || $_SESSION['dob'] == '') {
    header('Location: /find-me', true);
}

get_header();
?>
    </header><!--/header-->
    <div id="main-content">
        <div class="container" style="max-width: 1500px">
            <div id="content-area" class="clearfix" style="max-width: 1200px; margin: auto">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="main_title"><?php the_title(); ?></h1>
                    <div class="entry-content">
                        <div class="wrapper ef">
                            <div id="enroller-content" class="ef">
                                <form action="/enroll/overview" method="post" id="form_enroll">
                                    <?php
                                    $path = get_home_path() . 'enroller_II/index.php';
                                    require($path);
                                    ?>
                                </form>
                            </div> <!-- /div #enroller-content -->
                        </div><!--/div .wrapper-->
                    </div> <!-- .entry-content -->
                </article> <!-- .et_pb_post -->
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>