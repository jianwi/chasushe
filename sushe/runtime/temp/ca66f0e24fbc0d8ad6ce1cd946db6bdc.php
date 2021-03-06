<?php /*a:2:{s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/admin/history.html";i:1571582144;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>系统操作记录</title>
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
            平台操作记录
        </h5>
    </div>
    <div class="card-body">
        <div class="">

        </div>
        <div>
<!--            <input type="text" class="form-control my-2" placeholder="" @change="searchStudent">-->
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm w-100">
                <tr ref="th">
                    <td>id</td>
                    <td>操作人</td>
                    <td>行为描述</td>
                    <td>快照</td>
                    <td>还原</td>
                </tr>
                <tr v-for="item in history_list">
                    <td>{{item.id}}</td>
                    <td>{{item.name}}</td>
                    <td>{{item.msg}}</td>
                    <td>
                        <a :href="'fkdealroom?id='+item.obj" v-if="item.type==2" class="btn btn-sm btn-info">查看</a>
                        <a :href="'fkdealstudent?id='+item.obj" v-if="item.type==1" class="btn btn-sm btn-info">查看</a>
                    </td>
                    <td>
                        <button :id="item.id" class="btn btn-sm btn-info" @click="drawback">还原</button>
                    </td>
                </tr>
            </table>
            <div class="btn-group-sm text-center" ref="page_toggle">
                <button class="btn btn-info" @click="prePage">上一页</button>

                <button class="btn btn-info" @click="nextPage">下一页</button>
            </div>
        </div>
    </div>

</div>
<script>
    let app = new Vue({
        el: "#app",
        data: {
            history_list: "",
            page:0,
        },
        methods: {
            drawback: function (event) {
                if (!confirm("确认还原操作?")) return;
                $.getJSON("drawback&id=" + event.target.id, res => {
                    if (res.code == 200) {
                        alert("处理成功");
                        location.reload()
                    } else {
                        alert("处理失败,请稍后再试")
                    }
                })
            },
            prePage: function () {
                if (this.page < 1) {
                    alert("这已经是第一页啦！！！");
                    return;
                }
                $.getJSON("gebackList" + "?p=" + (this.page - 1) * 10, res => this.history_list = res)
                this.page -= 1;
            },
            nextPage: function () {
                if (this.history_list.length == 0) {
                    alert("没有数据鸟，当前是最后一页")
                    return
                }
                $.getJSON("historyList" + "?p=" + (this.page + 1) * 10, res => {
                    if (res.length == 0) {
                        alert("没有数据鸟");
                        return;
                    }
                    this.history_list = res
                    this.page += 1;
                })

            },
        },
        created:function () {
            $.getJSON("historyList", res => this.history_list = res)
        },
        mounted:function () {
            this.$refs.loading.hidden = 1;
        }

    })
</script>
</body>
</html>