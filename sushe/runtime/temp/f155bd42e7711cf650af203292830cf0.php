<?php /*a:1:{s:93:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/index/become_teacher.html";i:1568732100;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册辅导员</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/jquery.min.js"></script></head>
<body>
<div id="app">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
                <span class="fa fa-arrow-left"></span>
            </button>
            <h5 class="text-center d-inline-block w-75 m-0">
                注册辅导员/管理员
            </h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <form action="" onsubmit="return false" @submit="sub">
                    <label for="">姓名</label>
                    <input type="text" v-model="user_name" class="form-control" required>
                    <label for="">手机号</label>
                    <input type="text" v-model="phone" class="form-control" required>
                    <label for="">备注</label>
                    <textarea type="text" v-model="extra" class="form-control" required></textarea>
                    <hr>
                    <button class="btn btn-primary">提交</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let app = new Vue({
        el:"#app",
        data:{
            user_name:"",
            phone:"",
            extra:""
        },
        methods:{
            sub:function () {
                let post_data = {
                    "name" : this.user_name,
                    "phone" :this.phone,
                    "extra" :this.extra
                }
                $.post("becomeTeacherSub",post_data,(res)=>{
                    if (res.code==200){
                        alert("提交成功，请耐心等待管理员审核")
                    }else {
                        alert("提交失败，原因未知！")
                    }
                });
            }
        }
    })
</script>
</body>
</html>