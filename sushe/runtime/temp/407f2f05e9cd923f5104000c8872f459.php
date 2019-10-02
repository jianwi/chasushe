<?php /*a:2:{s:96:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/teacher/fk_deal_student.html";i:1569940602;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1568623801;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>反馈记录</title>

    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>

<div id="app">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
                <span class="fa fa-arrow-left"></span>
            </button>
            <h5 class="text-center d-inline-block w-75 m-0">
                学生违纪信息
            </h5>
        </div>
        <div class="card-body">
            <div v-if="check_info">
                <table class="table table-striped">
                    <tr>
                        <td>id</td>
                        <td>{{check_info.id}}</td>
                    </tr>
                    <tr>
                        <td>学生姓名</td>
                        <td>{{check_info.name}}</td>
                    </tr>
                    <tr>
                        <td>学生照片</td>
                        <td>
                            <img :src="'/uploads/'+check_info.pic" width="130px" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>宿舍</td>
                        <td>
                            {{check_info.room.gongyu}}
                            {{check_info.room.danyuan}}
                            {{check_info.room.louceng}}层
                            {{check_info.room.fangjian}}号
                        </td>
                    </tr>
                    <tr>
                        <td>学院</td>
                        <td>{{check_info.college}}</td>
                    </tr>
                    <tr>
                        <td>专业</td>
                        <td>{{check_info.major}}</td>
                    </tr>
                    <tr>
                        <td>违纪行为</td>
                        <td>{{check_info.crime}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-sm btn-danger" :id="check_info.id" @click="del">
                                删除
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            <div v-else>
                加载失败，可能此条信息已被删除

            </div>
        </div>

    </div>
</div>
<script>
    let app = new Vue({
        el: "#app",
        data: {
            check_info: "",
        },
        methods: {
            del: function (event) {
                if (!confirm("确认删除此信息?")) return;
                $.getJSON("delStudentCheck&id=" + event.target.id, res => {
                    if (res.code == 200) {
                        alert("处理成功");
                        location.reload()
                    } else {
                        alert("处理失败,请稍后再试")
                    }
                })
            }
        },
        created:function () {
            $.getJSON("studentcheckinfo&id=<?php echo htmlentities($id); ?>", res => this.check_info = res)
        },
    })
</script>
</body>