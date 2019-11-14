<!DOCTYPE html>
<?php 
$key = $_SERVER['QUERY_STRING'];
$key = str_replace("-", "+", $key);
$key = str_replace("_", "/", $key);
$key = base64_decode($key);
?>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo $key; ?></title>
    <link rel="stylesheet" href="//cdn.bootcss.com/mdui/0.4.3/css/mdui.min.css">
    <style type="text/css">
        .doc-container {
            padding-bottom: 20px;
        }

        .mdui-row, [class*="mdui-row-"] {
            margin-right: 0;
            margin-left: 0;
        }

        p {
            margin-top: 12px;
            margin-bottom: 12px;
            line-height: 200%;
            font-size: 16px;
            text-indent:32px;
        }
    </style>
</head>
<body class="mdui-theme-accent-blue">
<div class="mdui-progress" style="position: fixed; display: none;">
    <div class="mdui-progress-indeterminate"></div>
</div>
<div class="mdui-container doc-container">
    <div class="mdui-row">
        <div class="mdui-col-xs-12 mdui-col-sm-6 mdui-col-offset-sm-3 mdui-m-b-2">
            <div id="article_content" style="padding-top: 5px;">
<?php
if (!empty($key)) {
	putenv('LANG=en_US.UTF-8');
	// 如果没有任何输出那应该是php的system函数被禁用了
	system("python3 自动狗屁不通文章生成器.py $key 2>&1");
	exit(0);
}
?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
