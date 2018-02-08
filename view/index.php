<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $modName?>——接口文档</title>
</head>
<body>
<ul>
<?php foreach($list as $module){?>
    <?php foreach($module as $key => $item){?>
        <li><?php echo $key?> => <?php echo $item?></li>
<?php }}?>
</ul>
</body>
</html>