<?php /*a:2:{s:93:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/teacher/feedback_log.html";i:1571579232;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生反馈记录</title>

    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/font-awesome.min.css">

<script src="/static/js/vue.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/popper.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>

<div id="app">
    <h2 ref="loading" class="alert alert-info text-center py-5 align-content-center" style="position: fixed;width: 100%;height: 100vh;z-index: 1000">
        加载中,请稍后
    </h2>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-info rounded-circle" onclick="history.back()">
                <span class="fa fa-arrow-left"></span>
            </button>

            <h5 class="text-center d-inline-block w-75 m-0">
                学生反馈记录
            </h5>
        </div>
        <div class="card-body" v-if="fk_list.length != 0">
            <table class="table table-responsive table-hover table-sm">
                <thead v-if="">
                    <tr>
                        <td>id</td>
                        <td>学生姓名</td>
                        <td>反馈时间</td>
                        <td>处理情况</td>
                        <td>类型</td>
                        <td>详情</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in fk_list">
                        <td>{{item.id}}</td>
                        <td>{{item.name}}</td>
                        <td>{{item.date}}</td>
                        <td>{{item.status}}</td>
                        <td>{{item.type}}</td>
                        <td>
                            <button class="btn btn-info btn-sm" :id="item.id" @click="detail" data-toggle="modal" data-target="#fk_detail">
                                详情
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="btn-group-sm text-center">
                <button class="btn btn-info" @click="prePage()">上一页</button>

                <button class="btn btn-info" @click="nextPage()">下一页</button>
            </div>
        </div>
        <div v-else class="alert alert-info m-3">
            暂时没有记录
        </div>
    </div>
    <div class="modal hide" data-toggle="modal" id="fk_detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    反馈详情
                    <button type="button" data-dismiss="modal" class="close">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive table-hover">
                        <tr>
                            <td>id</td>
                            <td>{{fk_detail.id}}</td>
                        </tr>
                        <tr>
                            <td>学生姓名</td>
                            <td>
                                {{fk_detail.name}}
                            </td>
                        </tr>
                        <tr>
                            <td>内容</td>
                            <td>
                                {{fk_detail.content}}
                            </td>
                        </tr>
                        <tr>
                            <td>时间</td>
                            <td>
                                {{fk_detail.date}}
                            </td>
                        </tr>
                        <tr>
                            <td>回复</td>
                            <td>
                                <textarea ref="reply" name="reply" id="" cols="20" rows="5" class="form-control">
                                    {{fk_detail.reply}}
                                </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a :href="'fkdealstudent?id='+fk_detail.id" v-if="fk_detail.type=='学生违纪'" class="btn btn-sm btn-info">去处理</a>
                                <a :href="'fkdealroom?id='+fk_detail.id" v-if="fk_detail.type=='查宿'" class="btn btn-sm btn-info">去处理</a>
                                <button class="btn btn-sm btn-info" :id="fk_detail.id" @click="hasDeal">已处理</button>
                                <button class="btn btn-sm btn-info" :id="fk_detail.id" @click="cancel">驳回</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    let app = new Vue({
        "el":"#app",
        data:{
            "fk_list":[],
            "fk_detail":{},
            page:0
        },
        methods:{
          cancel:function (event) {
              if (!confirm("确认驳回学生的反馈？")) return;
                let id = event.target.id,
                    reply = this.$refs.reply.value;

              $.post("cancelfeedback",{id:id,reply:reply},res=>{
                  if (res.code==200){
                      alert("处理成功");
                      location.reload()
                  }else {
                      alert("处理失败，请稍后重试");
                  }
              })
          },
            prePage: function () {
                if (this.page < 1) {
                    alert("这已经是第一页啦！！！");
                    return;
                }
                $.getJSON("getFeedbackList" + "?p=" + (this.page - 1) * 10, res => this.fk_list = res.data)
                this.page -= 1;
            },
            nextPage: function () {
                if (this.fk_list.length == 0) {
                    alert("没有数据鸟，当前是最后一页")
                    return
                }
                $.getJSON("getFeedbackList" + "?p=" + (this.page + 1) * 10, res => {
                    if (res.data.length == 0) {
                        alert("没有数据鸟");
                        return;
                    }
                    this.fk_list = res.data
                    this.page += 1;
                })

            },
            detail:function (event) {
                let id = event.target.id;
                $.getJSON("feedbackDetail&id="+id,res => this.fk_detail = res.data);
            },
            hasDeal:function (event) {
                if (!confirm("请确认您已经处理过学生的反馈了？")) return;
                let id = event.target.id,
                    reply = this.$refs.reply.value;
                $.post("confirmfeedback",{id:id,reply:reply},res=>{
                    if (res.code==200){
                        alert("处理成功");
                        location.reload()
                    }else {
                        alert("处理失败，请稍后重试");
                    }
                })
            }
        },
        created:function () {
            $.getJSON("getFeedbackList",res => this.fk_list = res.data);
        },
        mounted:function () {
            this.$refs.loading.hidden = 1;
        }
    })
</script>
</body>
</html>