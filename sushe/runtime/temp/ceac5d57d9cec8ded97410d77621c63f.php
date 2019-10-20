<?php /*a:2:{s:93:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/student/feedback_log.html";i:1571584388;s:86:"/home/dujianjun/PhpstormProjects/sushe/sushe/application/chasu/view/public/header.html";i:1570269144;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>反馈记录</title>

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
                我的反馈记录
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-responsive table-hover">
                <thead v-if="">
                    <tr>
                        <td>id</td>
                        <td>内容</td>
                        <td>反馈时间</td>
                        <td>处理情况</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in fk_list">
                        <td>{{item.id}}</td>
                        <td>{{item.content}}</td>
                        <td>{{item.date}}</td>
                        <td>{{item.status}}</td>
                        <td >
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
                            <td>内容</td>
                            <td>
                            <textarea ref="content" id="" cols="20" rows="5" class="form-control">
                                {{fk_detail.content}}
                            </textarea>
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
                                    {{fk_detail.reply}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-sm btn-info" :id="fk_detail.id" @click="modify" v-if="fk_detail.status!='已处理'">修改</button>
                                <button class="btn btn-danger btn-sm" :id="fk_detail.id" @click="cancel" v-if="fk_detail.status!='已处理'">
                                    取消
                                </button>
                            </td>
                        </tr>
                    </table>
<!--                    <p v-else="fk_detail">-->
<!--                        没有数据-->
<!--                    </p>-->
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
              if (!confirm("确认取消？")) return;
                let id = event.target.id;

              $.post("cancelfeedback",{id:id},res=>{
                  if (res.code==200){
                      alert("处理成功");
                      location.reload()
                  }else {
                      alert("处理失败，请稍后重试");
                  }
              })

          } ,
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
            modify:function (event) {
                if (!confirm("确认提交？")) return;
                let id = event.target.id,
                    content = this.$refs.content.value;
                $.post("modifyfeedback",{id:id,content:content},res=>{
                    if (res.code==200){
                        alert("提交成功");
                        location.reload()
                    }else {
                        alert("提交失败，请稍后重试");
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