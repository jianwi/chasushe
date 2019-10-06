<?php /*a:2:{s:83:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/room.html";i:1570335409;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>公寓管理</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/font-awesome.min.css">

<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>

</head>
<body>

     <div class="card" id="room">
         <div class="card-header">
             <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
                 <span class="fa fa-arrow-left"></span>
             </button>
             <h5 class="text-center d-inline-block w-75 m-0">
                 公寓信息管理
             </h5>
         </div>
        <div class="card-body">
            <h6>查看公寓</h6>
            <label for="" class="">选择公寓</label>
            <div class="input-group">
                <select name="" v-model="gongyu_id" id="gongyu" class="form-control" @change="sel('danyuan','gongyu_id')">
                    <option :value="item.id" v-for="item in gongyu">{{item.name}}</option>
                </select>
                <button class="input-group-append btn btn-danger" @click="del('gongyu_id')">删除</button>
            </div>
            <label for="" class="">选择单元</label>
            <div class="input-group">
            <select name="" id="danyuan" v-model="danyuan_id" class="form-control" @change="sel('louceng','danyuan_id')">
                <option :value="item.id" v-for="item in danyuan">{{item.name}}</option>
            </select>
                <button class="input-group-append btn btn-danger" @click="del('danyuan_id')">删除</button>
            </div>
            <label for="" class="">选择楼层</label>

            <div class="input-group">
            <select name="" id="loucheng" v-model="louceng_id" class="form-control" @change="sel('fangjian','louceng_id')">
                <option :value="item.id" v-for="item in louceng">{{item.name}}</option>
            </select>
                <button class="input-group-append btn btn-danger" @click="del('louceng_id')">删除</button>
            </div>
            <label for="fangjian" class="">查看房间号</label>
            <div class="input-group">
            <select name="" v-model="fangjian_id" id="fangjian" class="form-control">
                <option :value="item.id" v-for="item in fangjian">{{item.name}}</option>
            </select>
                <button class="input-group-append btn btn-danger" @click="del('fangjian_id')">删除</button>
            </div>
            <hr>
           <button class="my-5  p-1 btn btn-primary" data-toggle="modal" data-target="#new-room-modal">新建一个公寓</button>
        </div>

    </div>
<!--modal start-->
    <div class="modal fade" id="new-room-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">添加一个公寓</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form action="" method="post" id="new-room-form" onsubmit="return false" @submit="sub">
                        <label for="">公寓名称</label>
                        <input required type="text" name="room_name" class="form-control">
                        <label>单元</label>
                        <div v-html="danyuan">
                        </div>
                            <button class="btn btn-info m-2">提交</button>
                        </form>

                    </div>
                </div>
            </div>
    </div>
    </div>
<!--modal end-->
<template id="danyuan-tem">
    <div class="input-group input-group-sm my-1">
        <div class="input-group-prepend">
            <p class="input-group-text">名称</p>
        </div>
        <input type="text" required name="danyuan_name[]"  class="text-center form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
        <div class="input-group-prepend">
            <p class="input-group-text">楼层</p>
        </div>
        <input type="text" name="louceng[]" required class="form-control">
        <div class="input-group-append">
            <p class="input-group-text">房间数</p>
        </div>
        <input type="text" name="room_count[]" required class="form-control">
        <button class="input-group-append btn btn-info" onclick="$(this.parentElement.parentElement).append($('#danyuan-tem').html())">
            <span class="fa fa-plus"></span>
        </button>
        <button class="input-group-append btn btn-danger" onclick="this.parentElement.remove()">
            <span class="fa fa-trash-o"></span>
        </button>
    </div>
</template>

    <script>


let vm = new Vue({
    el:"#new-room-modal",
    data:{
        "danyuan" : $("#danyuan-tem").html()
    },
    methods:{
        newDanyuan:function () {

        },
        sub:function () {
            let form_data = new FormData($("#new-room-form")[0]);
            $.ajax({
                url:"saveRoom",
                method: "post",
                data:form_data,
                contentType: false,
                dataType: false,
                processData: false,
                async: true,
                success: function (res){
                   if (res==1){
                       alert("成功")
                   }else {
                       alert("失败")
                   }
                    location.reload()

                }
            })
        }
    }

});
let room_vm = new Vue({
    el:"#room",
    data:{
        "gongyu":[],
        "fangjian":[],
        "danyuan":[],
        "louceng":[],
        gongyu_id:"",
        danyuan_id:"",
        "louceng_id":"",
        "fangjian_id":""
    },
    methods: {
        sel:function (which_sel,cur) {
            $.getJSON("getRoom&id="+this[cur],res=>room_vm[which_sel]=res)
        },
        del:function (which) {
            if (!confirm("确认操作？")) return;
            $.post("delete",{id:this[which]},res=>{
                if (res.code == 200){
                    alert("删除成功")
                    location.reload()
                }else {
                    alert("删除失败")
                    location.reload()
                }
            })
        }
    }
})
        $(document).ready(()=> {
                $.getJSON("allRoom",res=>room_vm.gongyu=res)
            }
        )
    </script>
</body>
</html>