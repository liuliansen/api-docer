<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $modName?>——接口文档</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="/assets/css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="/assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="/assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0;height:">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">接口列表</span>
            </div>

            <div class="header-right">
                <div class="input-group">
                    <input type="text" placeholder="输入关键字查询" class="form-control">
                    <span class="form-group input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
<!--                <span>Power by LianSen@我爱微点</span>-->
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <?php   foreach($list as $package => $item) { ?>
                        <li>
                            <a href="#">
                                <i class="fa fa-desktop "></i>
                                <?php echo $package?>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                            <?php foreach ($item as $md5 => $title) { ?>
                                <li>
                                    <a class="api-url" href="#" data-url="/<?php echo $app,'/',$mod,'/',$md5 ?>">
                                        <i class="fa fa-toggle-on"></i>
                                        <?php echo $title?>
                                    </a>
                                </li>
                            <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
<!--                        <a class="active-menu" href="#"><i class="fa fa-desktop "></i>UI Elements <span class="fa arrow"></span></a>-->

                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <!-- /. PAGE INNER  -->
            <iframe id="api-page" frameborder="0" width="100%" height="100%" src="">

            </iframe>
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

<!--    <div id="footer-sec">-->
<!--        LianSen@我爱微点-->
<!--    </div>-->
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="/assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="/assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="/assets/js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="/assets/js/custom.js"></script>
    


</body>
<script>
    function updatePageHeight()
    {
        var height = document.body.clientHeight - $('.navbar-cls-top:first').height();
        $('#page-wrapper').css('height',height+'px');
    }
    $(document).ready(function(){
        updatePageHeight();
        $('.api-url').on('click',function(){
            $('#page-wrapper').css('height',$(document).height()+'px');
            $('#api-page').attr('src',$(this).data('url'));
            $('.api-url').removeClass('active-menu');
            $(this).addClass('active-menu');
        });
    });
</script>
</html>
