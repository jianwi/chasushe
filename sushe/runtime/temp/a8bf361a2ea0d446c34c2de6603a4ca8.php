<?php /*a:2:{s:91:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/fk_deal_room.html";i:1569947499;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1568623801;}*/ ?>
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
                查宿处理
            </h5>
        </div>
        <div class="card-body">
            <div id="room_check_info">
                <div>
                    <div>
                        <div v-if="room_check_info">
                            <div class="form-group">
                                <form action="" @submit.prevent="sub">

                                    <div>
                                        <table class="table table-hover">
                                            <tr>
                                                <td>
                                                    id:
                                                </td>
                                                <td>
                                                    {{room_check_info.id}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    房间:
                                                </td>
                                                <td>
                                                    {{room_check_info.room.gongyu}}
                                                    {{room_check_info.room.danyuan}}
                                                    {{room_check_info.room.louceng}}层
                                                    {{room_check_info.room.fangjian}}号
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend input-group-text">
                                                            宿舍得分
                                                        </div>
                                                        <input disabled class="form-control" type="text" name="grade" :value="room_check_info.grade" >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>违纪行为</td>
                                                <td>{{room_check_info.crime}}</td>
                                            </tr>
                                            <tr>
                                                <td>查宿备注</td>
                                                <td> {{room_check_info.comment}}</td>
                                            </tr>
                                            <tr>
                                                <td>当前状态</td>
                                                <td>
                                                    <p v-if="room_check_info==1">已删除</p>
                                                    <p v-if="room_check_info">未删</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="bg-light p-2">
                                        <p v-if="room_check_info.pic">查宿快照(照片不支持编辑呦!)</p>
                                        <img width="300px" class="mw-100 m-2" :src="'/uploads/'+item" v-for="item in room_check_info.pic" alt="">
                                    </div>
                                    <input type="text" name="id" :value="room_check_info.id" hidden>
                                </form>
                            </div>
                        </div>
                        <div v-else>
                             加载失败，可能此条信息已被删除
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    let app = new Vue({
        el: "#app",
        data: {
            room_check_info: "",
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
            },
            delRoomCheck: function (event) {
                if (!confirm("确认删除此信息?")) return;
                $.getJSON("delRoomCheck&id=" + event.target.id, res => {
                    if (res.code == 200) {
                        alert("处理成功");
                        location.reload()
                    } else {
                        alert("处理失败,请稍后再试")
                    }
                })
            },
        },
        created:function () {
            $.getJSON("roomcheckinfo&id=<?php echo htmlentities($id); ?>", res => this.room_check_info = res)
        },
    })
</script>
</body>