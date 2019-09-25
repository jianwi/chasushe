<?php /*a:2:{s:98:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/modify_student_info.html";i:1568731700;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1568623801;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改学生信息</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
    <style>
        #img_area {
            position: relative;
            display: table-cell;
            width: 130px;
            height: 180px;
        }
        #img_area img{
            width: 130px;
        }
    </style>
</head>
<body>
<div class="card" id="app">
    <div class="card-header">
        <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
            <span class="fa fa-arrow-left"></span>
        </button>
        <h5 class="text-center d-inline-block w-75 m-0">
            修改学生信息
        </h5>
    </div>
    <div class="card-body">
        <div class="card-body">
            <form action="" ref="my_form" class="form-group"  onsubmit="return false" @submit="sub">
                <h6>完善信息</h6>
                <label for="image_file" id="img_area" class="border border-secondary">
                    <img :src="img_src" class="position-absolute h-100 w-100">
                    <h4 class="h4 text-center"><span class="fa fa-plus fa-2x text-black-50 m-4"></span></h4>
                    <p class="m-3 text-center h5">上传照片</p>
                    <input id="image_file" hidden type="file" name="photo" @change="showImg">
                </label>
                <label for="">姓名</label>
                <input type="text" placeholder="请填写您的姓名" class="form-control" name="name" value="<?php echo htmlentities($user['name']); ?>" required>
                <label for="">学院</label>
                <input type="text" placeholder="" name="college" class="form-control" value="<?php echo htmlentities($user['college']); ?>" required>
                <label for="">专业</label>
                <input type="text" class="form-control" required name="major" value="<?php echo htmlentities($user['major']); ?>">

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
                <label for="fangjian" class="">房间号</label>
                <div class="input-group">
                    <select name="room" v-model="fangjian_id" id="fangjian" class="form-control">
                        <option :value="item.id" v-for="item in fangjian">{{item.name}}</option>
                    </select>
                </div>
                <input type="text" value="<?php echo htmlentities($user['id']); ?>" hidden name="id">
                <button class="btn btn-outline-info m-3 mx-auto px-3">提交</button>
            </form>
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
            img_src :"/uploads/<?php echo htmlentities($user['pic']); ?>",

        },
        methods: {
            sel:function (which_sel,cur) {
                $.getJSON("/index/getRoom&id="+this[cur],res=>this[which_sel]=res)
            },
            sub:function (event) {
                if (!confirm("确认信息无误?")) return;
                let post_data = new FormData(event.target)
                $.ajax({
                    url :"modifyStudentInfoSub",
                    contentType:false,
                    processData:false,
                    method:"POST",
                    data: post_data,
                    success: function (res) {
                        if (res.code == 200){
                            alert("提交成功");
                            location.reload();
                        }else {
                            alert("提交失败")
                        }
                    }

                })
            },
            showImg:function (event) {
                let file = event.target.files[0]
                $("img")[0].hidden=0
                this.img_src = URL.createObjectURL(file)
            }
        },
        created:function () {
            $.getJSON("/index/allRoom",res=>this.gongyu=res)
        }
    })
</script>
</body>
</html>