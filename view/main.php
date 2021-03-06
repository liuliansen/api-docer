﻿<!DOCTYPE html>
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
            width: 200px;
        }
        .info-body {
            font-size: 16px;
        }
    </style>
</head>
<body style=";padding: 5px;">
<div class="row" style="margin:0 !important;">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover" style="margin-bottom: 20px;">
            <tr>
                <td class="info-head">服务器地址</td>
                <td class="info-body" colspan="3">
                    正式：
                    <span style="font-size: 20px;font-weight: bolder;">
                        <a><?php echo $servInfo['product_server']?></a>
                    </span><br/>
                    测试：
                    <span style="font-size: 20px;font-weight: bolder;">
                        <a><?php echo $servInfo['test_server']?></a>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-head">模块数量</td>
                <td class="info-body">
                    <span class="label label-success" style="margin-bottom: 10px;">
                        <?php echo $moduleQty?>
                    </span>
                </td>
                <td class="info-head">接口总数</td>
                <td class="info-body">
                      <span class="label label-success" style="margin-bottom: 10px;">
                        <?php echo $apiQty?>
                    </span>
                </td>
            </tr>
        </table>
    <div>
</div>
    <div class="col-md-12" style="padding: 0;margin-top: 30px;">
        <div style="width: 100%;height: 30px;font-size: 20px;font-weight: bold;">文档说明</div>
        <div class="alert alert-danger" style="font-size: 16px;margin-bottom: 50px;"><?php echo $globalDesc?></div>
    </div>
    <div class="col-md-12" style="padding: 0;">
        <div style="width: 100%;height: 30px;font-size: 20px;font-weight: bold;">系统级全局请求参数</div>
        <table class="table table-hover alert alert-success">
            <thead>
            <tr>
                <th>#</th>
                <th>参数名称</th>
                <th>参数类型</th>
                <th>是否必须</th>
                <th>默认值</th>
                <th>参数说明</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0; $i<count($globalAppParams); $i++){?>
                <tr>
                    <td><?php echo $i+1?></td>
                    <td><?php echo $globalAppParams[$i]['name']?></td>
                    <td><?php echo $globalAppParams[$i]['type']?></td>
                    <td><?php echo $globalAppParams[$i]['require']?></td>
                    <td><?php echo $globalAppParams[$i]['default']?></td>
                    <td><?php echo $globalAppParams[$i]['desc']?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>

    <div class="col-md-12" style="padding: 0;margin-top: 30px;">
        <div style="width: 100%;height: 30px;font-size: 20px;font-weight: bold;">接口级全局请求参数</div>
        <table class="table table-hover alert alert-success">
            <thead>
            <tr>
                <th>#</th>
                <th>参数名称</th>
                <th>参数类型</th>
                <th>是否必须</th>
                <th>默认值</th>
                <th>参数说明</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0; $i<count($globalApiParams); $i++){?>
                <tr>
                    <td><?php echo $i+1?></td>
                    <td><?php echo $globalApiParams[$i]['name']?></td>
                    <td><?php echo $globalApiParams[$i]['type']?></td>
                    <td><?php echo $globalApiParams[$i]['require']?></td>
                    <td><?php echo $globalApiParams[$i]['default']?></td>
                    <td><?php echo $globalApiParams[$i]['desc']?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12" style="padding: 0;margin-top: 30px;">
        <div style="width: 100%;height: 30px;font-size: 20px;font-weight: bold;">响应说明</div>
        <div class="alert alert-danger" style="font-size: 16px;margin-bottom: 50px;">
            <pre><?php echo $responseDesc?></pre>
        </div>
    </div>
</body>
</html>