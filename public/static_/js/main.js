/*
 * @Author: GhostChen
 * @Date: 2018-08-29 11:39:10 
 * @Last Modified by: ghostChen
 * @Last Modified time: 2018-12-04 09:56:44
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
    },

}

main.init();
