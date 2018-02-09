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
</head>
<body style="background: #ffffff;padding: 5px;">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                接口信息
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="margin:10px;font-size:16px;">
                            接口名称: <span style="font-size: 20px;font-weight: bolder;">
                                <?php echo $apiInfo['title']?></span></div>
                        <div style="margin:10px;font-size:16px;">
                            接口地址: <span style="font-size: 20px;font-weight: bolder;"> <a>
                                    <?php echo $apiInfo['url']?></a></span>
                        </div>
                        <div style="margin:10px;font-size:16px;">
                            接口作者: <span style="font-size: 20px;font-weight: bolder;">
                                <?php echo htmlentities($apiInfo['author'])?></span></div>
                        <div style="margin:10px;font-size:16px;">
                            请求类型: <span style="font-size: 20px;font-weight: bolder;">
                                <span class="label label-danger" style="margin-bottom: 10px;">
                                    <?php echo strtoupper($apiInfo['method'])?></span></div>
                        <div style="margin:10px;font-size:16px;">
                            <div style="font-size: 20px;font-weight: bolder;">接口说明: </div>
                            <div style="padding: 10px;"><?php echo implode('',$apiInfo['description'])?></div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div style="font-size: 20px;font-weight: bolder;">请求参数</div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
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
                                            <td><?php
                                                switch ($apiInfo['param'][$i]['type']){
                                                    case 'string' : echo '字符串'; break;
                                                    case 'int'    : echo '整数'; break;
                                                    case 'float'  : echo '浮点型'; break;
                                                    case 'boolean' : echo '布尔型'; break;
                                                    case 'date' : echo '日期'; break;
                                                    case 'array' : echo '数组'; break;
                                                    case 'fixed' : echo '固定值'; break;
                                                    case 'enum' : echo '枚举类型'; break;
                                                    case 'object' : echo '对象'; break;
                                                    default:echo '未知类型';
                                                }?></td>
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
                                <div style="padding: 10px;font-size: 20px;color: #E5563C;">
                                <?php foreach ($apiInfo['return'] as $row){?>
                                    <?php echo str_replace(["\t",' '],['&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;'],$row) .'<br/>'?>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>