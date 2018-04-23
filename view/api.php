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

         .api-label{
             display: block;
             float: left;
             height: 34px;
             width: 120px;
             line-height: 34px;
             padding: 0 10px;
             font-size: 16px;
         }
        .api-input{
            float: left;
        }
        .width500{
            width: 500px;
        }
        .width200{
            width: 200px;
        }
        .width220{
            width: 220px;
        }
        .width20{
            width: 20px;
        }
        .width280{
            width: 280px;
        }
        .api-block{
            margin-bottom: 10px;
        }
        .api-add-header,.api-remove-header,.api-add-param,.api-remove-param{
            margin-left: 10px;
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
                <div class="panel-body">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#home-pills" data-toggle="tab" style="color: #fff;background-color:blue ;border-radius: 4px;position: relative;display: block;padding: 10px 15px;font-size: 20px;font-weight: bolder;">响应格式</a>
                        </li>
                        <li class="" ><a href="#profile-pills" data-toggle="tab" style="color: #fff;background-color: #F0733B;border-radius: 4px;position: relative;display: block;padding: 10px 15px;font-size: 20px;font-weight: bolder;">在线测试</a>
                        </li>
                    </ul>



                    <div class="tab-content" style="margin-top: 10px;">
                        <div class="tab-pane fade active in" id="home-pills">
                                <pre style="font-size: 20px;background: #FFF7E9;"><?php echo $apiInfo['return'] ?></pre>
                        </div>

                        <div class="tab-pane fade " id="profile-pills">
                            <div style="min-width:700px;height:auto;border-radius: 4px; background:#FFEFAF; padding: 20px;">
                                <label class="api-label">接口地址</label>
                                <div style="float: left;">
                                    <select id="server" class="form-control api-input width220">
                                        <option><?php echo $servInfo['product_server']?></option>
                                        <option selected="selected"><?php echo $servInfo['test_server']?></option>
                                    </select>
                                    <input type="text" class="api-input width280" id="api-url" value="<?php echo $apiInfo['url']?>"/>
                                </div>
                                <div style="clear: both;"></div>
                                <label class="api-label">请求头</label>
                                <div style="float: left;" id="api-headers">
                                    <div class="api-block">
                                        <input type="text" class="api-input width500 header-set" />&nbsp;&nbsp;
                                        <button class="btn api-add-header">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                        <button class="btn api-remove-header">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </button>
                                        <div style="clear: both;"></div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div style="clear: both;"></div>
                                <label class="api-label">请求参数</label>
                                <div style="float: left;" id="api-params">
                                    <?php for ($i=0; $i<count($apiInfo['param']); $i++){?>
                                        <div class="api-block">
                                            <input type="text" class="api-input width200 parameter-name" value="<?php echo $apiInfo['param'][$i]['name']?>" placeholder="参数名"/>
                                            <label type="text" class="width20" style="display: block;float: left;text-align: center">:</label>
                                            <input type="text" class="api-input width280 parameter-value" placeholder="不填写，将会使用空字符串作为值"/>
                                            <?php if($apiInfo['param'][$i]['require'] == 1){?>
                                            <span style="color: red">*</span><?php }?>
                                            <button class="btn api-add-param">
                                                <i class="glyphicon glyphicon-plus"></i>
                                            </button>
                                            <button class="btn api-remove-param">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </button>
                                            <div style="clear: both;"></div>
                                        </div>
                                    <?php }?>
                                </div>
                                <div style="clear: both;"></div>
                                <div style="float: left; width:620px;  height: 50px;">
                                    <button id="submit" class="btn btn-danger" style="float: right;margin-left: 20px;">
                                        提交
                                    </button>
                                </div>
                                <div style="clear: both;"></div>
                                <label class="api-label">响应结果</label>
                                <div style="float: left;min-width: 100%;min-height:200px;" id="api-response">
                                    <textarea id="api-result" style="height:200px;width:100%; resize: vertical;"></textarea>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/assets/js/jquery-1.10.2.js"></script>
<script src="/assets/js/bootstrap.js"></script>
<script src="/assets/js/custom.js"></script>
</html>
<script>
    function addHeader(){
        $('#api-headers').append('<div class="api-block">\n' +
            '                                    <input type="text" class="api-input width500 header-set" />&nbsp;&nbsp;' +
            '                                    <button class="btn api-add-header">\n' +
            '                                        <i class="glyphicon glyphicon-plus"></i>\n' +
            '                                    </button>\n' +
            '                                    <button class="btn api-remove-header">\n' +
            '                                        <i class="glyphicon glyphicon-remove"></i>\n' +
            '                                    </button>\n' +
            '                                    <div style="clear: both;"></div>\n' +
            '                                </div>');
    }

    function addParams(){
        $('#api-params').append('<div class="api-block">\n' +
'                                     <input type="text" class="api-input width200 parameter-name" value="" placeholder="参数名"/>\n'+
'                                      <label type="text" class="width20" style="display: block;float: left;text-align: center">:</label>\n' +
'                                      <input type="text" class="api-input width280 parameter-value" placeholder="值"/>&nbsp;&nbsp;\n' +
'                                      <button class="btn api-add-param">\n' +
'                                          <i class="glyphicon glyphicon-plus"></i>\n' +
'                                      </button>\n' +
'                                      <button class="btn api-remove-param">\n' +
'                                          <i class="glyphicon glyphicon-remove"></i>\n' +
'                                      </button>\n' +
'                                      <div style="clear: both;"></div>\n' +
'                                  </div>');
    }

    $(document).on('click','.api-add-header',{},function(e){
        addHeader();
    });

    $(document).on('click','.api-remove-header',{},function(e){
        $(this).closest('div').remove();

        if ($('#api-headers>.api-block').length == 0){
            addHeader();
        }
    });

    $(document).on('click','.api-add-param',{},function(e){
        addParams();
    });

    $(document).on('click','.api-remove-param',{},function(e){
        $(this).closest('div').remove();

        if ($('#api-params>.api-block').length == 0){
            addParams();
        }

    });

    $('#submit').click(function(){
        var data;
        data = {
            url: $('#server').val()+ $.trim($('#api-url').val()),
            headers:[],
            params:[]
        };
        $('#api-headers>.api-block').map(function(i,el){
            var set = $.trim($(el).find('.header-set:first').val());
            if(set)  data.headers.push(set);
        });

        $('#api-params>.api-block').map(function(i,el){
            var name = $.trim($(el).find('.parameter-name:first').val());
            var value = $.trim($(el).find('.parameter-value:first').val());
            if(name) data.params.push({name:name,value:value});
        });

        $.post("/<?php echo $app,'/',$mod,'/__call?api=',$api ?>",data,function(res){
            $('#api-result').html(res);
        });

    });

</script>