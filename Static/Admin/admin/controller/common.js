/**

 @Name：layuiAdmin 公共业务
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：LPPL

 */
var loginInter = 0;
var adminSession = layui.data('layuiAdmin')['adminSession'];
layui.define(function(exports){
    var $ = layui.$
        ,layer = layui.layer
        ,laytpl = layui.laytpl
        ,setter = layui.setter
        ,view = layui.view
        ,admin = layui.admin;
    if(loginInter===0){
        loginInter = setInterval(function () {
            admin.req({
                url:"/Api/admin/Login/getInfo?adminSession=" + adminSession,
                success:function (res) {
                    if (res.code==401){
                        admin.exit();
                    }
                }
            });
        },5000);
    }




    //退出
    admin.events.logout = function(){
        //执行退出接口
        admin.req({
            url: '/Api/Admin/Login/logout'
            ,type: 'get'
            ,data: {}
            ,done: function(res){ //这里要说明一下：done 是只有 response 的 code 正常才会执行。而 succese 则是只要 http 为 200 就会执行

                //清空本地记录的 token，并跳转到登入页
                admin.exit();
            }
        });
    };


    //对外暴露的接口
    exports('common', {});
});