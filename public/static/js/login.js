var LG = LG || {} ;
LG  = {
    init:function(){
        LG.loginTab()
        //输入input时触发检测输入的内容，是否符合规范
        $(".login-ipt").on("keydown",function(){
            LG.checkInpit()
        })
    },
    loginTab:function(){
        $(".login-tab-box").find("span").on("click",function(){
            $(this).addClass("on").siblings().removeClass("on")
        })
    },
    checkInpit:function(){
        var username = $("input[name='username']").val();
        var passwd = $("input[name='passwd']").val();
        if(username!=""&&passwd!=''){
            $(".login-btn").addClass("on");
        }else{
            $(".login-btn").removeClass("on");
        }
    }
}
LG.init()