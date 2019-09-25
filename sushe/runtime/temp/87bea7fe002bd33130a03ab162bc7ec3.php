<?php /*a:2:{s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/student/index.html";i:1569342413;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1568623801;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生页面</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<div class="text-center alert alert-info h-100 py-4 pb-5 m-0">
    <h2 class="m-4 mb-5">
        欢迎使用查宿系统
    </h2>
    <img src="<?php echo htmlentities($user_info->info->yb_userhead); ?>" class="w-25 rounded-circle"/>

    <a href="/student/mine" class="btn btn-block p-3 btn-info my-4 mx-auto w-75" hidden>我的信息</a>
    <a href="/student/checkLog" class="btn btn-block btn-info p-3 mx-auto mb-5 w-75">辅导员查宿记录</a>

</div>
<div class="alert alert-secondary text-center m-0 fixed-bottom">
    Powered and Design by 奇点工作室
</div>

</body>
</html>