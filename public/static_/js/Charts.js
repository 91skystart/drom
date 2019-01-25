//# sourceURL=Charts.js
/**
 * @title echarts 二次封装
 * @description echarts 
 * @author ChenSiTong
 * @date 2018-04-12
 *
 */
;var Charts = function(){};
Charts.prototype = {
    //初始化运行
    init:function(){
            
    },
    /**
     * 常规图表
    * @param options 传入的参数
    * @param options.dom DOM容器 ID 不需要加# 如："container"
    * @param options.data 数据源 
    * @param options.type 图表种类
    * @param options.color 颜色数组
    * @param options.xAxis 横坐标数组
    * @param options.data.name 数据的名称
    * @param options.data.data 数据的值
    * @param options.data.max 数据的最大值
    * 
    */
    getChart:function(options){
        //工具栏标题
        var legend_data = [];
        //Y轴数据构建
        var series = [];
        for(var i = 0; i<options.data.length;i++){
            legend_data.push(options.data[i].name);
            series.push({
                name:options.data[i].name,
                type:options.type == "stackLine" ? "line" : options.type,
                data:options.data[i].data,
                smooth: true
            })
        }
        if(options.type == "line"){
            series[0].areaStyle={
                normal: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: 'rgba(42,82,177,0.2)'
                    }, {
                        offset: 1,
                        color: 'rgba(242, 229, 229, 0.2)'
                    }], false),
                    shadowColor: 'rgba(0, 0, 0, 0.1)',
                    shadowBlur: 10
                }
            };
            series[0].itemStyle={
                normal: {
                    color: 'rgb(0,136,212)',
                    borderColor: 'rgba(0,136,212,0.2)',
                    borderWidth: 12
    
                }
            }
        }
       
        option = {
            color: options.color || ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83','#38c9b3','#dd78e1','#adad83','#2ea73d','#b78cec','#ca8622','#000','#bda29a','#6e7074', '#546570', '#c4ccd3','#541616','#32746a'],
            xAxis: {
                type: 'category',
                axisLine:{
                    lineStyle: {
                        color: '#000',
                        width:1
                    }
                },
                data: options.xAxis
            },
            title: {
                text: options.title,
                x:"200",
                y:"200"
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                orient: 'vertical',
                right: '0',
                bottom:"20",
                data:legend_data
            },
            yAxis: {
                type: 'value',
                axisLine:{
                    lineStyle: {
                        color: '#000',
                        width:1
                    }
                },
            },
            series:series
        };
        console.log(option);
        //判断是否为扇形图
        if(options.type == "pie"){
            Charts.prototype.getPie(option,options);
            return;
        }
        
        //判断是否为雷达图
        if(options.type == "radar"){
            Charts.prototype.getRadar(option,options);
            return;
        }
        //判断是否为堆叠折线图
        if(options.type == "stackLine"){
            Charts.prototype.getStackLine(option,options);
            return;
        }
        if(options.type == "XBar"){
            Charts.prototype.getXBar(option,options);
            return;
        }
        var myChart = echarts.init(document.getElementById(options.dom));
        console.log(option);
        myChart.setOption(option);

    },
    /**
    * 雷达图表
    * @param option echarts的option配置项对象
    * @param options 传入的参数
    */
    getRadar:function(option,options){
        delete option.xAxis;
        delete option.series;
        delete option.yAxis;
        option.tooltip = {};
        var series = [];
        var indicator = [];
        series = [{
            name:options.title,
            type:options.type,
            data:[]
        }];
        for(var i = 0;i<options.data.length;i++){
            indicator.push({
                name:options.data[i].name,
                max:options.data[i].max
            })
            series[0].data.push({
                value:options.data[i].data,
                name:options.data[i].name
            });
        }
        option.series = series;
        option.radar = {
            // shape: 'circle',
            name: {
                textStyle: {
                    color: '#fff',
                    backgroundColor: '#999',
                    borderRadius: 3,
                    padding: [3, 5]
                }
            },
            indicator:indicator,

        }
        var myChart = echarts.init(document.getElementById(options.dom));
        console.log(option);
        myChart.setOption(option);
    },
    /**
    * 堆叠折线图
    * @param option echarts的option配置项对象
    * @param options 传入的参数
    */
    getStackLine:function(option,options){
        option = {};
        console.log(option);
        option.tooltip = {};
        option.title = {
            text:options.title
        };
        var legend_data = [];
        var series = [];
        for(var i = 0;i<options.data.length;i++){
            legend_data.push(options.data[i].name);
            series.push({
                name:options.data[i].name,
                type:'line',
                stack: '总量',
                areaStyle: {normal: {}},
                data:options.data[i].data
            })
        }
        option.tooltip = {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#6a7985'
                }
            }
        };
        option.legend = {
            data:options.legend_data
        };
        option.toolbox = {
            feature:{
                saveAsImage:{}
            }
        };
        option.grid = {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        };
        option.xAxis = {
            type : 'category',
            boundaryGap : false,
            data : options.xAxis
        };
        option.yAxis = [
            {
                type:'value'
            }
        ];
        option.series = series;
        var myChart = echarts.init(document.getElementById(options.dom));
        console.log(option);
        myChart.setOption(option);
        
    },
    //饼图
    getPie:function(option,options){
        option = {};
        option.title = {
            text:options.title,
            x:'45%',
            y:'0'
        };
        option.tooltip = {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        };
        var legend_data = [];
        var series_data = [];
        for(var i = 0;i<options.data.length;i++){
            legend_data.push(options.data[i].name);
            series_data.push({
                value:options.data[i].data,
                name:options.data[i].name
            })
        }
        option.series = [
            {
                name:options.title,
                type: 'pie',
                radius : '70%',
                center: ['55%', '48%'],
                data:series_data,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
        option.tooltip = {
            enterable: true,
            formatter: options.tooltipFunc,
            triggerOn: 'click'
        }
        option.color = options.color || ['#c23531','#2f4554',"blue",'#61a0a8', '#d48265', '#91c7ae','#749f83','#38c9b3','#dd78e1','#adad83','#2ea73d','#b78cec','#ca8622','#000','#bda29a','#6e7074', '#546570', '#c4ccd3','#541616','#32746a'];
        var myChart = echarts.init(document.getElementById(options.dom));
        myChart.setOption(option);
    }
}