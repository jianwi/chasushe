<?php /*a:2:{s:84:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/index.html";i:1570334748;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员后台</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/font-awesome.min.css">

<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>

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
            <a href="/admin/history" class="text-center nav d-inline-block border p-2 rounded shadow my-1">
                <img src="/static/img/history.png" alt="" class="nav_img">
                <p class="w-100 m-1  p-1 text-center">操作日志</p>
            </a>
        </div>
    </div>

    <div>
    </div>
</body>
</html>