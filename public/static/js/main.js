/*
 * @Author: GhostChen
 * @Date: 2018-08-29 11:39:10 
 * @Last Modified by: ghostChen
 * @Last Modified time: 2019-01-25 15:10:39
 */


var main = main || {};
main = {
    init:function(){
        $(".layui-nav-item .username").on("mouseover",function(){
            $(this).find("span").css({
                "transform":"rotate(-120deg)"
            })
        })
        $(".layui-nav-item .username").on("mouseout",function(){
            $(this).find("span").css({
                "transform":"rotate(0deg)"
            })
        })
        $(".menu-btn").on("mouseenter",function(){
            $(".menu-child-list").removeClass("hide");
            $(document).on("click",function(){
                $(".menu-child-list").addClass("hide");
            })
        })
        $(".menu-child-list").on("mouseleave",function(){
            $(".menu-child-list").addClass("hide");
        })
        $(".menu-btn").on("click",function(e){
            e.stopPropagation();//阻止事件冒泡
        })
    },

}

main.init();
