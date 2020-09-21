<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($title); ?></title>
    <meta name="title" content="<?php echo ($title); ?>">


    <link href="/bysystem/Public/share/share.min.css" rel="stylesheet">
    <script src="/bysystem/Public/share/qrcode.js"></script>
    <script src="/bysystem/Public/share/social-share.js"></script>

</head>
<body>
<h3 style="text-align: center"><?php echo ($title); ?></h3>
<hr>
<p><?php echo ($info); ?></p><br><br>
<div style="float: right;margin-right: 10%;">日期：<?php echo (date("Y-m-d",$time)); ?></div></br></br></br>


<div style="margin:0 auto;width:300px;height:100px" >
   <div class="share-component"data-sites="weibo,qzone,qq,wechat"></div>


</div>


</body>
</html>