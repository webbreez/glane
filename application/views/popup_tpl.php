<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>LOGICLANE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Le javascript ================================================== -->
        <?php //echo html::script("assets/js/jquery-1.9.1.min.js");?>
        <?php echo html::script("assets/js/jquery-1.8.2.js");?> 
        <?php echo html::script("assets/js/jquery.validate.min.js");?>
        <?php echo html::script("assets/js/additional-methods.js");?>
        <?php echo html::script("assets/bootstrap/js/bootstrap.min.js");?>
         
        <!-- Le styles -->
        <?php echo html::stylesheet("assets/bootstrap/css/bootstrap.css");?>    
        <style>
            body {
                padding-top: 5px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
            label.error { color: #E4782F; }

            .sidebar-nav-fixed {
                position:fixed;
                top:100;
                left:20px;
            }

        </style>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo URL::site('assets/images/favicon.ico');?>">
    </head>

    <body>

       
        <div class="container">
            <?php echo $content;?>
        </div>

    </body>
</html>
