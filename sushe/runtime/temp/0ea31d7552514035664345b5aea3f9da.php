<?php /*a:1:{s:84:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/index.html";i:1568730466;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员后台</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/vue.js"></script>
    <link rel="stylesheet" href="/static/css/index.css">
</head>
<body>
    <div class="alert alert-info py-5">
        <h2 class="text-center">
            管理员后台
        </h2>
    </div>

    <div class="border p-4 pb-5 bg-light">
        <div>
            <a href="/admin/room" class="text-center nav d-inline-block border p-2 rounded shadow">
                <img src="/static/img/sushe.png" alt="" class="nav_img">
                <p class="w-100 m-1  p-1 text-center">公寓信息</p>
            </a>
            <a href="/admin/students" class="text-center nav d-inline-block border p-2 rounded shadow">
                <img src="/static/img/student.png" alt="" class="nav_img">
                <p class="w-100 m-1  p-1 text-center">学生信息</p>
            </a>
            <a href="/admin/teachers" class="text-center nav d-inline-block border p-2 rounded shadow">
                <img src="/static/img/fudaoyuan.png" alt="" class="nav_img">
                <p class="w-100 m-1  p-1 text-center">辅导员</p>
            </a>
        </div>
    </div>

    <div>
    </div>
</body>
</html>