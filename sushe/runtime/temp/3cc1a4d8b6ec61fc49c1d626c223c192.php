<?php /*a:2:{s:87:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/students.html";i:1570334748;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生管理</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/font-awesome.min.css">

<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="card" id="app">
        <div class="card-header">
            <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
                <span class="fa fa-arrow-left"></span>
            </button>
            <h5 class="text-center d-inline-block w-75 m-0">
                学生信息管理
            </h5>
        </div>
        <div class="card-body">
            <div class="card-body">
                <br>
                <label for="" class="">选择公寓</label>
                <div class="input-group">
                    <select name="" v-model="gongyu_id" id="gongyu" class="form-control" @change="sel('danyuan','gongyu_id')">
                        <option :value="item.id" v-for="item in gongyu">{{item.name}}</option>
                    </select>
                </div>
                <label for="" class="">选择单元</label>
                <div class="input-group">
                    <select name="" id="danyuan" v-model="danyuan_id" class="form-control" @change="sel('louceng','danyuan_id')">
                        <option :value="item.id" v-for="item in danyuan">{{item.name}}</option>
                    </select>
                </div>
                <label for="" class="">选择楼层</label>

                <div class="input-group">
                    <select name="" id="loucheng" v-model="louceng_id" class="form-control" @change="sel('fangjian','louceng_id')">
                        <option :value="item.id" v-for="item in louceng">{{item.name}}</option>
                    </select>
                </div>
                <label for="fangjian" class="">选择房间号</label>
                <div class="input-group">
                    <select name="" v-model="fangjian_id" id="fangjian" class="form-control"  @change="getStudent">
                        <option :value="item.id" v-for="item in fangjian">{{item.name}}</option>
                    </select>
                </div>
                <div v-if="!getStudentStatus" class="alert alert-info">没有数据呦</div>
                <div>
                    <hr>
                    <div>
                        <div class="border border-light p-3 mw-100" style="width: 300px" v-for="item in students">
                            <img class="img-fluid p-2" :src="'/uploads/'+item.pic" alt="">
                            <p>姓名: {{item.name}}</p>
                            <p>学院: {{item.college}}</p>
                            <p>班级: {{item.major}}</p>
                            <p class="btn-group">
                                <a :href="'modifystudentinfo?id='+item.id" class="btn btn-sm btn-info">修改</a>
                                <button class="btn btn-sm btn-danger" :id="item.id" @click="del">删除</button>
                            </p>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary" href="allstudents">查看所有学生信息</a>

            </div>
    </div>
    </div>
 <template>

 </template>
    <script>
        let app = new Vue({
            el:"#app",
            data:{
                "gongyu":[],
                "fangjian":[],
                "danyuan":[],
                "louceng":[],
                gongyu_id:"",
                danyuan_id:"",
                "louceng_id":"",
                "fangjian_id":"",
                students:"",
                getStudentStatus:1,
            },
            methods: {
                sel:function (which_sel,cur) {
                    $.getJSON("/index/getRoom&id="+this[cur],res=>this[which_sel]=res)
                },
                sub:function (event) {
                    if (!confirm("确认信息无误?")) return;
                    let post_data = new FormData(event.target)
                    $.ajax({
                        url :"chooseFormSub",
                        contentType:false,
                        processData:false,
                        method:"POST",
                        data: post_data,
                        success: function (res) {
                            if (res.code == 200){
                                alert("提交成功");
                                location.href="./"
                            }else {
                                alert("提交失败")
                            }
                        }

                    })
                },
                del:function (event) {
                    if (!confirm("确认要删除这位同学吗?")) return;
                    $.post("deleteUser",{id:event.target.id},res=>{
                        if (res.code == 200){
                            alert("删除成功")
                            location.reload()
                        }else {
                            alert("删除失败,请稍后再试")
                            // location.reload()
                        }
                    })
                },
                getStudent:function (event) {
                    let room_id = event.target.value;
                    $.post("/index/getUser",{room:room_id},res=>this.students=res)
                    this.getStudentStatus = this.students.length==0 ? false:1;
                }
            },
            created:function () {
                $.getJSON("/index/allRoom",res=>this.gongyu=res)
            }
        })

    </script>
</body>
</html>