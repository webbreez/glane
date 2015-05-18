<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>LOGICLANE INVENTORY PANEL</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Le javascript ================================================== -->
        <!-- Le styles -->
        <?php echo html::stylesheet("assets/bootstrap/css/bootstrap.css");?>    
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
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
        <link rel="icon" type="image/png" href="<?php echo url::base();?>assets/images/favicon.ico">
    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?php echo URL::site('index');?>">INVENTORY PANEL</a>
                    <div class="nav-collapse">
                        <?php
                        if($this->session->get("manager_id"))
                        {
                        ?>
                        <ul class="nav">
                            
                        </ul>
                        <p class="navbar-text pull-right">
                            Welcome <?php echo $this->session->get("manager_name")?>! <a href="<?php echo URL::site('inventory/logout');?>">Logout</a>
                        </p>
                        <?php
                        }
                        ?>
                    </div><!--/.nav-collapse -->                    
                </div>
            </div>
        </div>

        <?php
        if($this->session->get("manager_id"))
        {
        ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2 sidebar-width">
                    <div class="well sidebar-nav-fixed">
                        <ul class="nav nav-list">
                            <li <?echo $this->uri->segment(1) == "home" ? "class='active'": '' ?> ><a href="<?php echo URL::site('admin/home');?>">Home</a></li>
                            <li <?echo $this->uri->segment(1) == "settings" ? "class='active'": '' ?> ><a href="<?php echo URL::site('admin/settings');?>">Settings</a></li>
                            <li <?echo $this->uri->segment(1) == "members" ? "class='active'": '' ?> ><a href="<?php echo URL::site('admin/members');?>">Members</a></li>
                        <ul>
                    </div> <!-- /sidebar -->
                </div> <!-- /span -->
        <div class="span8 span-fixed-sidebar">
                    <?php echo $content;?>
                </div> <!-- /span -->
            </div> <!-- /row -->
        </div> <!-- /container -->
        <?php
        }else{
        ?>
        <div class="container">
            <?php echo $content;?>
        </div>
        <?php
            }
        ?>
    </body>
</html>
