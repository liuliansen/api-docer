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
<body style="width: 100%">
<div style="width:100%;height:100%;display:flex;">
    <div style="float:left;width: 300px;height: 100%; background: #000;padding-top: 50px;padding-bottom:20px;position: relative;">
        <div style="position:absolute;top:0;left:0;width:100%;height:50px;color:#ffffff;font-size:20px;font-weight:bolder;line-height:50px;background: #1E60B8;">
            <span style="margin-left: 30px;">
                <a id="goto-main" style="color:#fff;cursor: pointer;">
                    <?php echo $appModuleName?>接口列表
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                </a>
            </span>
        </div>
        <div style="overflow-y: auto;height:100%;width:300px;">
            <nav class="navbar-default" role="navigation">
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
        </div>
        <div style="position:absolute;bottom:0;left:0;width:100%;height:20px;font-weight:bolder;line-height:20px;background: #ccc;">
            ©我爱微点-LianSen&lt;liansen@d3zz.com&gt;
        </div>
    </div>
    <div style="float:left;flex:1;height: 100%;position: relative;padding-top: 50px;background: #ccc;">
        <div style="width:100%;height:50px;position:absolute;top:0;left:0;color:#ffffff;font-size:20px;font-weight:bolder;background: #0000ff;">
            <div style="float: right;margin-right: 20px;height: 100%;margin-top: 10px;">
                <div class="input-group" >
                    <input type="text" placeholder="输入关键字查询" class="form-control" id="input-search">
                    <span class="form-group input-group-btn">
                        <button class="btn btn-default" type="button" id="btn-search">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div style="margin:0;height: 100%; padding: 0;">
            <!-- /. PAGE INNER  -->
            <iframe id="api-page" frameborder="0" width="100%" height="100%" src="/<?php echo $app,'/',$mod,'/__main' ?>" style="display:block;">            </iframe>
        </div>
    </div>
</div>

</body>
<script src="/assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="/assets/js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="/assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="/assets/js/custom.js"></script>
<script>
    $('.api-url').on('click',function(){
        $('#api-page').attr('src',$(this).data('url'));
        $('.api-url').removeClass('active-menu');
        $(this).addClass('active-menu');
    });

    $('#goto-main').on('click',function(){
        $('#api-page').attr('src',"/<?php echo $app,'/',$mod,'/__main' ?>");
        $('.api-url').removeClass('active-menu');
    });


    $('#btn-search').click(function(e){

    });
    $('#input-search').keypress(function(e){
        
    });

    function search()
    {

    }
</script>
</html>
