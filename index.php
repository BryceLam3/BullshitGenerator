<?php
@header('Content-Type: text/html; charset=UTF-8');

$key = $_GET["key"];
if (!empty($key)) {
	putenv('LANG=en_US.UTF-8');
	// 如果没有任何输出那应该是php的system函数被禁用了
	system("python3 自动狗屁不通文章生成器.py $key 2>&1");
	exit(0);
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>狗屁不通文章生成器</title>
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
<div class="mdui-toolbar mdui-color-grey-800">
    <span class="mdui-typo-title mdui-center">狗屁不通文章生成器</span></div>
<div class="mdui-progress" style="position: fixed; display: none;">
    <div class="mdui-progress-indeterminate"></div>
</div>
<div class="mdui-container doc-container">
    <div class="mdui-row">
        <div class="mdui-col-xs-12 mdui-col-sm-6 mdui-col-offset-sm-3 mdui-m-b-2">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">文章关键词</label>
                <input id="keyword" class="mdui-textfield-input" type="text" value="MT管理器"/>
            </div>
            <button id="generate" class="mdui-btn mdui-btn-block mdui-color-theme-accent mdui-ripple" style="margin-top: 5px;">生成文章</button>
            <div id="article_content" style="padding-top: 5px;">

            </div>
        </div>
    </div>
    <div class="mdui-dialog" id="dialog">
        <div class="mdui-dialog-title">错误</div>
        <div class="mdui-dialog-content">***</div>
        <div class="mdui-dialog-actions">
            <button class="mdui-btn mdui-ripple" mdui-dialog-close>关闭</button>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/js-cookie/latest/js.cookie.min.js"></script>
<script src="//cdn.bootcss.com/mdui/0.4.3/js/mdui.min.js"></script>
<script>
    $$ = mdui.JQ;
    var keyword = Cookies.get('keyword');
    if (keyword != undefined && keyword.length > 0) {
    	$$("#keyword").val(keyword);
    }
    $$(function () {
        $$('#generate').on('click', function () {
        	keyword = $$("#keyword").val();
        	if (keyword.length == 0) {
        		$$('#article_content').html("");
	        	return;
        	}
        	Cookies.set('keyword', keyword)
            $$('#generate').attr("disabled", "true");
            $$('.mdui-progress').show();
            $$.ajax({
                method: 'GET',
                url: document.location.toString().split("?")[0] + '?key=' + keyword,
                success: function (data) {
                    $$('#article_content').html(data);
                },
                error: function (xhr, textStatus) {
                    $$('.mdui-dialog-content').text(textStatus);
                    new mdui.Dialog('#dialog').open();
                },
                complete: function () {
                    $$('.mdui-progress').hide();
                    $$('#generate').removeAttr("disabled");
                }
            });
        });
    });
</script>
</body>
</html>
