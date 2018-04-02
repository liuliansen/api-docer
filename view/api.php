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
        .row{margin: 0 !important;}
        .info-head {
            font-size: 20px;
            max-width: 200px;
        }
        .info-body {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="alert alert-warning" style="font-size: 20px;color: #E97824;">
        本页由程序自动生成，如果对此信息有疑问请联系接口作者！
    </div>
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover" style="margin-bottom: 20px;">
            <tr>
                <td class="info-head">接口名称</td>
                <td class="info-body">
                    <span style="color:#D9362C;">
                        <?php echo $apiInfo['title']?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-head">接口地址</td>
                <td class="info-body">
                   <span style="font-size: 20px;font-weight: bolder;">
                        <a><?php echo $apiInfo['url']?></a>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-head">具体地址</td>
                <td class="info-body">
                    正式：
                    <span style="font-size: 15px;font-weight: bolder;">
                        <a><?php echo $servInfo['product_server'].$apiInfo['url']?></a>
                    </span><br/>
                    测试：
                    <span style="font-size: 15px;font-weight: bolder;">
                        <a><?php echo $servInfo['test_server'].$apiInfo['url']?></a>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-head">请求类型</td>
                <td class="info-body">
                    <span class="label label-danger" style="margin-bottom: 10px;">
                        <?php echo strtoupper($apiInfo['method'])?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-head">接口作者</td>
                <td class="info-body">
                    <span style="font-size: 20px;font-weight: bolder;">
                        <?php echo htmlentities($apiInfo['author'])?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-head">接口说明</td>
                <td class="info-body">
                    <?php echo implode('',$apiInfo['description'])?>
                </td>
            </tr>
        </table>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div style="font-size: 20px;font-weight: bolder;">接口级参数</div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover  alert alert-success">
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
                        <?php for ($i=0; $i<count($apiInfo['param']); $i++){?>
                            <tr>
                                <td><?php echo $i+1?></td>
                                <td><?php echo $apiInfo['param'][$i]['name']?></td>
                                <td><?php echo $apiInfo['param'][$i]['type']?></td>
                                <td><?php echo $apiInfo['param'][$i]['require'] == 1 ? '是':'否'?></td>
                                <td><?php echo $apiInfo['param'][$i]['default'] ?: '-'?></td>
                                <td><?php echo $apiInfo['param'][$i]['desc']?></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div style="font-size: 20px;font-weight: bolder;">响应结果</div>
                </div>
                <div class="panel-body">
                    <pre style="font-size: 20px;background: #FFF7E9;"><?php echo $apiInfo['return'] ?></pre>
                </div>
            </div>
        </div>
    </div>
</body>
</html>