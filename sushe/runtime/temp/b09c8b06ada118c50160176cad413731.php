<?php /*a:2:{s:91:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/all_students.html";i:1571581414;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生管理</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/font-awesome.min.css">

<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<div class="card" id="app">
    <h2 ref="loading" class="alert alert-info text-center py-5 align-content-center" style="position: fixed;width: 100%;height: 100vh;z-index: 1000">
        加载中,请稍后
    </h2>
    <div class="card-header">
        <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
            <span class="fa fa-arrow-left"></span>
        </button>
        <h5 class="text-center d-inline-block w-75 m-0">
            学生信息管理
        </h5>
    </div>
    <div class="card-body">
        <div class="">

        </div>
        <div>
            <input type="text" class="form-control my-2" placeholder="请输入学生姓名" @change="searchStudent">
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm w-100">
                <tr ref="th">
                    <td>姓名</td>
                    <td>学院</td>
                    <td>班级</td>
                    <td>宿舍</td>
                    <td>详情</td>
                </tr>
                <tr v-for="item in students">
                    <td>{{item.name}}</td>
                    <td>{{item.college}}</td>
                    <td>{{item.class}}</td>
                    <td>
                        {{item.room.xiaoqu}}
                        {{item.room.gongyu}}
                        {{item.room.danyuan}}
                        {{item.room.louceng}}层
                        {{item.room.fangjian}}号
                    </td>
                    <td>
                        <a :href="'modifystudentinfo?id='+item.id" class="btn btn-sm btn-info">修改</a>
                    </td>
                </tr>
            </table>
            <div class="btn-group-sm text-center" ref="page_toggle">
                <button class="btn btn-info" @click="prePage">上一页</button>

                <button class="btn btn-info" @click="nextPage">下一页</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        查看详情
                    </h4>
                    <button class="close" type="button" data-dismiss="modal">x</button>
                </div>
                <div v-if="the_student">
                    <div class="modal-body" >
                        <table class="table table-hover mw-100 table-bordered">
                            <tr v-for="(item,index) in the_student">
                                <td>
                                    {{index}}
                                </td>
                                <td class="w-75">
                                    {{item}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>


        </div>

    </div>
</div>

<script>
    let app = new Vue({
        el:"#app",
        data:{
            students:[],
            current_page : 0,
            the_student:{},
        },
        methods:{
            set:function (type) {
                if (type == -1){
                    if (!confirm("确认删除操作？")) return;
                }
                let post_data = {
                    "id" :this.the_student.id,
                    "type" :type
                }
                $.post("studentCheck",post_data,(res)=>{
                    if (res.code == 200){
                        alert("操作成功");
                        location.reload()
                    }else {
                        alert("操作失败");
                        location.reload()
                    }
                })
            },
            prePage:function () {
                if (this.current_page == 0) {
                    alert("这已经是第一页啦！！！");
                    return;
                }
                $.getJSON("studentsList&p="+(this.current_page-1)*10,res=>app.students=res)
                this.current_page -=1;
            },
            nextPage:function () {
                if (this.students.length == 0) {
                    alert("没有数据鸟，当前是最后一页")
                    return
                }
                $.getJSON("studentsList&p="+(this.current_page+1)*10,res=>{
                    if (res.length == 0){
                        alert("没有数据鸟");
                        return;
                    }
                    app.students=res
                    this.current_page+=1;
                })

            },
            GenerateThestudent:function (event) {
                let ths = this.$refs.th.children
                let tds = event.target.parentElement.parentElement.children
                let  v = [];
                for (let item of tds){
                    v.push(item.textContent)
                }
                v.pop()
                let student_detail = {};
                student_detail.id = event.target.id
                v.forEach((item,index)=>{
                    student_detail[ths[index].textContent] = item
                })
                this.the_student = student_detail
            },
            searchStudent:function (event) {
                let name = event.target.value
                $.post("studentSearch",{name:name},res=>app.students=res)
                this.$refs.page_toggle.hidden = 1;
            }
        },
        created:function () {
            $.getJSON("studentsList",res=>app.students=res)
        },
        mounted:function () {
            this.$refs.loading.hidden = 1;
        }
    })
</script>
</body>
</html>