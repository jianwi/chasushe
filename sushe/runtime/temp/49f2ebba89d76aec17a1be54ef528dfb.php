<?php /*a:1:{s:91:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/teacher/check_room.html";i:1568731581;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查宿</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/ssi-uploader.min.css">
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/popper.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/ssi-uploader.js"></script>
</head>
<body>
<div class="card" id="app">
    <div class="card-header">
        <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
            <span class="fa fa-arrow-left"></span>
        </button>
        <h5 class="text-center d-inline-block w-75 m-0">
            查宿
        </h5>
    </div>
    <div class="card-body">
        <div class="card-body">
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
            <div>
                <hr>
                <div>
                    <div class="border border-white bg-light p-3 w-100" v-for="item in students">
                        <img class="p-1 m-2 border-white" style="width: 130px;" :src="'/uploads/'+item.pic" alt="">
                        <p>姓名: {{item.name}}</p>
                        <p>学院: {{item.college}}</p>
                        <p>班级: {{item.major}}</p>
                        <p class="btn-group">
                            <button value="1" :name="item.name" :id="item.id"   @click="mark" class="btn btn-sm btn-info">晚归</button>
                            <button class="btn btn-sm btn-danger" :name="item.name" :id="item.id" value="2" @click="mark">夜不归宿</button>
                        </p>
                    </div>
                    <div v-show="this.fangjian_id" class="my-3 p-2">
                        <form action="" @submit="sub" onsubmit="return false">
                        <div class="input-group">
                            <span class="input-group-prepend input-group-text">宿舍打分</span>
                            <input type="number" class="form-control" name="grade">
                        </div>
                        <div>
                            <label for="">违规行为</label>
                            <textarea class="form-control" name="crime" ></textarea>
                            <label for="">查宿备注</label>
                            <textarea class="form-control" name="comment"></textarea>
                        </div>
                        <label for="">上传宿舍照片</label>
                        <br>
                        <div>
                            <input type="file" multiple id="ssi-upload"/>
                        </div>
                        <input type="text" v-model="images" hidden name="pic">
                            <input type="text" v-model="fangjian_id" hidden name="room">
                        <button class="btn btn-primary my-2">提交</button>
                        </form>
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
            "gongyu":[],
            "fangjian":[],
            "danyuan":[],
            "louceng":[],
            gongyu_id:"",
            danyuan_id:"",
            "louceng_id":"",
            "fangjian_id":"",
            students:"",
            images:[]
        },
        methods: {
            sel:function (which_sel,cur) {
                $.getJSON("/index/getRoom&id="+this[cur],res=>this[which_sel]=res)
            },
            sub:function (event) {
                if (!confirm("确认提交(请在提交前上传图片)?")) return;
                let post_data = new FormData(event.target)
                $.ajax({
                    url :"checkRoomSub",
                    contentType:false,
                    processData:false,
                    method:"POST",
                    data: post_data,
                    success: function (res) {
                        if (res.code == 200){
                            alert("提交成功");
                        }else {
                            alert("提交失败")
                        }
                    }
                })
            },
           mark:function (event) {
                if (!confirm("确认操作?")) return;
                let post_data = {
                    student_id:event.target.id,
                    crime:event.target.value
                }
                $.post("markUser",post_data,res=>{
                    if (res.code == 200){
                        alert("操作成功")
                        // location.reload()
                    }else {
                        alert("操作失败,请稍后再试")
                        // location.reload()
                    }
                })
            },
            getStudent:function (event) {
                let room_id = event.target.value;
                $.post("/index/getUser",{room:room_id},res=>this.students=res)
            },
            showImg:function (event) {
                let file = event.target.files[0]
                event.target.parentElement.children[0].src = URL.createObjectURL(file);
                $(event.target.parentElement.parentElement).append(`<label onclick="()=>{this.children[2].click()}"  style="width: 120px;"  class="border position-relative m-1">
                                    <img class="position-absolute w-100">
                                    <h4 class="h4 text-center"><span class="fa fa-plus fa-2x text-black-50 m-4"></span></h4>
                                    <input  hidden type="file" name="photo[]" onchange="app.showImg(event)">
                                </label>`)
            }
        },
        created:function () {
            $.getJSON("/index/allRoom",res=>this.gongyu=res)
        }
    })

$('#ssi-upload').ssi_uploader({
    url: 'upload',
    locale:"zh_CN",
    onEachUpload:function (res) {
        if (res.responseMsg=="服务器内部错误") return;
        app.images.push(res.responseMsg)
    }
});
</script>
</body>
</html>