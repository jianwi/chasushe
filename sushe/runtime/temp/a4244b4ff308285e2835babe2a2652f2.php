<?php /*a:2:{s:90:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/teacher/check_log.html";i:1568991553;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1568623801;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查宿记录</title>

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
                查宿记录
            </h5>
        </div>
        <div class="card-body">
            <p class="text-info">宿舍检查记录</p>
            <div  v-if="roomcheck.length!=0" >
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>房间</td>
                            <td>打分</td>
                            <td>详情</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in roomcheck" >
                            <td>{{item.id}}</td>
                            <td>
                                {{item.room.gongyu}}
                                {{item.room.danyuan}}
                                {{item.room.louceng}}层
                                {{item.room.fangjian}}号
                            </td>
                            <td >{{item.grade}}</td>
                            <td><button class="btn btn-sm btn-primary" data-toggle="modal" :id="item.id" @click="getRoomCheckInfo" data-target="#room_check_info" >详情</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group-sm text-center">
                    <button class="btn btn-info" @click="prePage('roomcheck')">上一页</button>

                    <button class="btn btn-info" @click="nextPage('roomcheck')">下一页</button>
                </div>
            </div>
            <div v-else="">暂时没有记录呦</div>
            <hr>
            <p class="text-info">学生违纪记录</p>
            <div v-if="studentcheck.length!=0">
                <table class="table table-sm  table-hover table-bordered">
                    <thead>
                    <tr>
                        <td>id</td>
                        <td>姓名</td>
                        <td>宿舍</td>
                        <td>违纪行为</td>
                        <td>删除</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in studentcheck" >
                        <td>{{item.id}}</td>
                        <td >{{item.name}}</td>
                        <td>
                            {{item.room.gongyu}}
                            {{item.room.danyuan}}
                            {{item.room.louceng}}层
                            {{item.room.fangjian}}号
                        </td>
                        <td>
                            {{item.crime}}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger" :id="item.id" @click="del">
                                删除
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-group-sm text-center">
                    <button class="btn btn-info" @click="prePage('studentcheck')">上一页</button>
                    <button class="btn btn-info" @click="nextPage('studentcheck')">下一页</button>
                </div>
            </div>
            <div v-else="">暂时没有记录呦</div>

            <hr>
            <div>
                <h4>按照宿舍查记录</h4>
                <div class="input-group">
                    <select next="danyuan" v-model="gongyu_id" class="form-control" ref="gongyu" @change="sel">
                        <option :value="item.id" v-for="item in gongyu">{{item.name}}</option>
                    </select>
                </div>
                <label for="" class="">选择单元</label>
                <div class="input-group">
                    <select next="louceng" v-model="danyuan_id" class="form-control" @change="sel">
                    <option :value="item.id" v-for="item in danyuan">{{item.name}}</option>
                    </select>
                </div>
                <label for="" class="">选择楼层</label>
                <div class="input-group">
                    <select next="fangjian" v-model="louceng_id" class="form-control" @change="sel">
                    <option :value="item.id" v-for="item in louceng">{{item.name}}</option>
                    </select>
                </div>
                <label for="fangjian" class="">选择房间号</label>
                <div class="input-group">
                    <select class="form-control" v-model="fangjian_id" @change="setRoomCheck2">
                    <option :value="item.id" v-for="item in fangjian">{{item.name}}</option>
                    </select>
                </div>
                <div v-if="fangjian_id">
                    <div  v-if="roomcheck2.length!=0" >
                        <table class="table table-sm table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>id</td>
                                <td>房间</td>
                                <td>打分</td>
                                <td>详情</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in roomcheck2" >
                                <td>{{item.id}}</td>
                                <td>
                                    {{item.room.gongyu}}
                                    {{item.room.danyuan}}
                                    {{item.room.louceng}}层
                                    {{item.room.fangjian}}号
                                </td>
                                <td >{{item.grade}}</td>
                                <td><button class="btn btn-sm btn-primary" data-toggle="modal" :id="item.id" @click="getRoomCheckInfo" data-target="#room_check_info" >详情</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2 m-2 bg-white" v-else="">
                        没有数据呦
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="room_check_info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    查看详情
                    <button class="close" type="button" data-dismiss="modal">
                        x
                    </button>
                </div>
                <div class="modal-body" v-if="room_check_info">
                    <div class="form-group">
                        <form action="" @submit.prevent="sub">

                        <p>id: {{room_check_info.id}}</p>
                        <p>房间:
                            {{room_check_info.room.gongyu}}
                            {{room_check_info.room.danyuan}}
                            {{room_check_info.room.louceng}}层
                            {{room_check_info.room.fangjian}}号
                        </p>
                        <div class="input-group">
                            <div class="input-group-prepend input-group-text">
                                宿舍得分
                            </div>
                            <input class="form-control" type="text" name="grade" :value="room_check_info.grade" >
                        </div>
                        <div>
                            <table class="table table-hover">
                                <tr>
                                    <td>违纪行为</td>
                                    <td><textarea class="form-control" name="crime" id="" cols="30" rows="5">{{room_check_info.crime}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>查宿备注</td>
                                    <td><textarea class="form-control" name="comment" id="" cols="30" rows="5">{{room_check_info.comment}}</textarea></td>
                                </tr>
                            </table>
                        </div>
                        <div class="bg-light p-2">
                            <p v-if="room_check_info.pic">查宿快照(照片不支持编辑呦!)</p>
                            <img width="310px" class="mw-100 m-2" :src="'/uploads/'+item" v-for="item in room_check_info.pic" alt="">
                        </div>
                            <input type="text" name="id" :value="room_check_info.id" hidden>
                        <button class="btn btn-primary m-3">提交修改</button>
                            <button class="btn btn-danger m-3" :id="room_check_info.id" @click.prevent="delRoomCheck">删除此记录</button>
                        </form>
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
            "roomcheck": "",
            roomcheck2:"",
            "studentcheck": "",
            roomcheck_page: 0,
            studentcheck_page: 0,
            room_check_info: "",
            gongyu:[],
            danyuan:"",
            louceng:"",
            fangjian:"",
            gongyu_id:"",
            danyuan_id:"",
            louceng_id:"",
            fangjian_id:""
        },
        methods: {
            sel:function(event)
            {
                $.getJSON("/index/getRoom&id="+event.target.value,res=>this[event.target.getAttribute("next")]=res)
            },
            prePage: function (which) {
                if (this[which + "_page"] == 0) {
                    alert("这已经是第一页啦！！！");
                    return;
                }
                $.getJSON(which + "log&p=" + (this[which + "_page"] - 1) * 10, res => this[which] = res)
                this[which + "_page"] -= 1;
            },
            nextPage: function (which) {
                if (this[which + "_page"].length == 0) {
                    alert("没有数据鸟，当前是最后一页")
                    return
                }
                $.getJSON(which + "log&p=" + (this[which + "_page"] + 1) * 10, res => {
                    if (res.length == 0) {
                        alert("没有数据鸟");
                        return;
                    }
                    this[which] = res
                    this[which + "_page"] += 1;
                })

            },
            getRoomCheckInfo: function (event) {
                let id = event.target.id
                $.getJSON("roomcheckinfo&id=" + id, res => this.room_check_info = res)
            },
            sub: function (event) {
                if (!confirm("确认要修改查宿信息吗?")) return;
                let post_data = new FormData(event.target)
                $.ajax({
                    url: "modifyCheckInfo",
                    contentType: false,
                    processData: false,
                    method: "POST",
                    data: post_data,
                    success: function (res) {
                        if (res.code == 200) {
                            alert("提交成功");
                            location.reload();
                        } else {
                            alert("提交失败")
                        }
                    }
                })
            },
            setRoomCheck2:function()
            {
                $.getJSON("roomCheck2Log&id=" + this.fangjian_id, res => this.roomcheck2 = res)
            },
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
            $.getJSON("roomchecklog",res=>this.roomcheck=res);
            $.getJSON("studentchecklog",res=>this.studentcheck=res);
            $.getJSON("/index/allRoom",res=>this.gongyu=res);
        },
    })
</script>
</body>
</html>