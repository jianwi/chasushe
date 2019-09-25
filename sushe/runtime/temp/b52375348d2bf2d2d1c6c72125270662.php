<?php /*a:1:{s:84:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/index/index.html";i:1568964273;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查宿系统</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
</head>
<body>
<div class="text-center alert alert-info h-100 py-4 pb-5 m-0">
    <img src="<?php echo htmlentities($user_info->info->yb_userhead); ?>" class="w-25 rounded-circle"/>
    <h2 class="m-4">
        欢迎使用查宿系统
    </h2>
    <p class="text-center  p-3">
        请选择您的身份以进入不同的系统
    </p>

    <a href="/teacher" class="btn btn-block p-3 btn-info my-4 mx-auto w-75">我是辅导员</a>
    <a href="/admin" class="btn btn-block btn-info p-3 mx-auto mb-5 w-75">我是后台管理员</a>

</div>
<div class="alert alert-secondary text-center m-0 fixed-bottom">
Powered and Design by 奇点工作室
</div>

</body>
</html>