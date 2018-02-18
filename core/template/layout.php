<?php
// Before anything is sent, set the appropriate header
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Africa/Nairobi");
$configs = parse_ini_file(WPATH . "core/configs.ini");
$_SESSION["mail_host"] = $configs["mail_host"];
$_SESSION["MUsername"] = $configs["MUsername"];
$_SESSION["MPassword"] = $configs["MPassword"];
$_SESSION["SMTPSecure"] = $configs["SMTPSecure"];
$_SESSION["Port"] = $configs["Port"];
$_SESSION["MUsernameFrom"] = $configs["MUsernameFrom"];
$_SESSION["Feedback"] = $configs["Feedback"];
$_SESSION["Null_Feedback"] = $configs["Null_Feedback"];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="web/img/favicon.ico" type="image/ico" sizes="16x16 32x32">
        <link rel="icon" href="web/img/favicon.png" type="image/png" sizes="16x16 32x32">
        <link rel="icon" href="web/img/favicon.svg" type="image/png" sizes="16x16 32x32">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Be Bulinda: Think Binay. Think Design. Think Code.">
        <meta name="keywords" content="be bulinda">
        <meta name="author" content="Be Bulinda">
        <link rel="stylesheet" href="web/css/main.css">

        <!--Listing FILTER END-->
        <?php
        /*         * *
         * This section specifies the page header
         */

        // The page title
        if ($templateResource = TemplateResource::getResource('title')) {
            ?>
            <title><?php echo $templateResource; ?></title>
        <?php } ?>
        <!-- Basic CSS -->
        <!-- End of basic CSS -->
        <?php
        // The CSS included
        if ($templateResource = TemplateResource::getResource('css')) {
            ?>
            <!-- Additional CSS -->
            <?php
            foreach ($templateResource as $style) {
                $style = "web/$style";
                ?>
                <link rel="stylesheet" href="<?php echo $style; ?>" />
                <?php
            }
            ?>
            <!-- Additional CSS end -->
            <?php
        }
        ?>

        <!-- Favicon and touch icons -->

    </head>
    <!--    <body>-->

    <body>

        <?php
        require_once "header.php";
        require_once $currentPage;
        require_once "footer.php";
        ?>

        <!-- Basic scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-2.2.4.min.js"><\/script>')</script>
        <script src="web/js/functions-min.js"></script>
        <!-- End of basic scripts -->

        <?php
        /*         * *
         * Specify the scripts that are to be added.
         */
        if ($templateResource = TemplateResource::getResource('js')) {
            ?>
            <!-- Additional Scripts -->
            <?php
            foreach ($templateResource as $js) {
                $js = "web/$js";
                ?>
                <script src="<?php echo $js; ?>"></script>
                <?php
            }
            ?>
            <?php
        }
        ?>

        <?php if (!App::isLoggedIn()) { ?>

            <?php
        }
        ?>
    </div>
</body>
</html>