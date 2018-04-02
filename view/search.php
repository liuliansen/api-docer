<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $apiInfo['title']?>——接口文档</title>

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
    <style>
        .info-head {
            font-size: 16px;
            max-width: 200px;
        }
        .info-body {
            font-size: 16px;
        }
    </style>
</head>
<body style=";padding: 5px;">
    <div class="col-md-12" style="padding: 0;">
        <div style="width: 100%;height: 30px;font-size: 20px;font-weight: bold; text-align: center;">所有名称包含关键字："<?php echo $keyWord?>" 的接口</div>
        <table class="table table-hover alert alert-success">
            <thead>
            <tr>
                <th>#</th>
                <th>接口模块</th>
                <th>接口名称</th>
                <th>接口地址</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;?>
            <?php foreach ($result as $list){?>
                <?php foreach ($list as $api){?>
                    <tr>
                        <td><?php echo $i++?></td>
                        <td><?php echo $api['module']?></td>
                        <td>
                            <a  href="#" data-url="/<?php echo $app,'/',$mod,'/',$api['md5'] ?>">
                                <?php echo $api['title']?>
                            </a>
                        </td>
                        <td>
                            <a  href="#" data-url="/<?php echo $app,'/',$mod,'/',$api['md5'] ?>">
                                <?php echo $api['url']?>
                            </a>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script src="/assets/js/jquery-1.10.2.js"></script>
<script>
    $('a').click(function(){
       window.location.href = $(this).data('url');
    });
</script>