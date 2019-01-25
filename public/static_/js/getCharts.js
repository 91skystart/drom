var chart = chart || {};
chart = {
    init:function(){
        chart.getManWomenLine();
        
    },
    //男女人数折现图
    getManWomenLine:function(){
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('man_woman_line'));

        // 指定图表的配置项和数据
        option = {
            backgroundColor: '#fff',
            title: {
                text: '男女比例折线图 (单位：人)',
                show: true,
                textStyle: {
                    fontWeight: 'normal',
                    fontSize: 16,
                    color: '#333'
                },
                left: 'center'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    lineStyle: {
                        color: '#333'
                    }
                }
            },
            legend: {
                icon: 'rect',
                itemWidth: 14,
                itemHeight: 5,
                itemGap: 13,
                data: ['近6个月平均拜访次数'],
                right: 'center',
                textStyle: {
                    fontSize: 12,
                    color: '#333'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                axisLine: {
                    lineStyle: {
                        color: '#ccc'
                    }
                },
                axisLabel: {
                    margin: 10,
                    textStyle: {
                        fontSize: 14,
                        color: '#999'
                    }
                },
                data: ['1班','2班','3班','4班','5班','6班']
            }],
            yAxis: [{
                type: 'value',
                name: '',
                axisTick: {
                    show: false
                },
                axisLine: {
                    lineStyle: {
                        color: '#fff'
                    }
                },
                axisLabel: {
                    margin: 10,
                    textStyle: {
                        fontSize: 14,
                        color: '#999'
                    }
                },
                splitLine: {
                    lineStyle: {
                        type: 'solid',
                        color: '#ccc'
                    }
                }
            }],
            series: [{
                name: '男生比例',
                type: 'line',
                smooth: true,
                symbol: 'rect',
                symbolSize: 5,
                showSymbol: false,
                lineStyle: {
                    normal: {
                        width: 1
                    }
                },
                areaStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(0, 136, 212, 0.2)'
                        }, {
                            offset: 1,
                            color: 'rgba(0, 136, 212, 0)'
                        }], false),
                        shadowColor: 'rgba(0, 0, 0, 0.1)',
                        shadowBlur: 10
                    }
                },
                itemStyle: {
                    normal: {
                        color: 'rgb(0,136,212)',
                        borderColor: 'rgba(0,136,212,0.2)',
                        borderWidth: 12
        
                    }
                },
                data: [120, 110, 145, 122, 165, 150],
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
            }, {
                name: '女生比例',
                type: 'line',
                smooth: true,
                symbol: 'rect',
                symbolSize: 5,
                showSymbol: false,
                lineStyle: {
                    normal: {
                        width: 1
                    }
                },
                areaStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(241, 106, 106, 0.2)'
                        }, {
                            offset: 1,
                            color: 'rgba(242, 229, 229, 0.2)'
                        }], false),
                        shadowColor: 'rgba(0, 0, 0, 0.1)',
                        shadowBlur: 10
                    }
                },
                itemStyle: {
                    normal: {
                        color: 'rgb(0,136,212)',
                        borderColor: 'rgba(0,136,212,0.2)',
                        borderWidth: 12
        
                    }
                },
                data: [90, 20, 185, 122, 155, 50],
                markPoint: {
                    itemStyle:{
                        color:"#ee4d64"
                    },
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
            }]
        }

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    },
    //籍贯比例饼图
    getNativeProportion:function(){
        var chart = new Charts();
        chart.getChart({
            dom:"native_proportion",
            data:[
                {
                    name:"北京",
                    data:32
                },
                {
                    name:"上海",
                    data:65
                },
                {
                    name:"深圳",
                    data:12
                },
                {
                    name:"湖南",
                    data:54
                },
                {
                    name:"安徽",
                    data:89
                },
                {
                    name:"其他",
                    data:21
                }
            ],
            title:"籍贯比例饼图",
            type:"pie",
            xAxis:["北京","上海","深圳","湖南","安徽","其他"]
        })
    },
    //年纪比例折线
    getAgeProportionLine:function(){
        var chart = new Charts();
        chart.getChart({
            dom:"age_proportion",
            data:[
                {
                    name:"",
                    data:[12,32,12,45,33,2]
                },
            ],
            title:"籍贯比例饼图(单位：百分比)",
            type:"line",
            xAxis:["15","16","17","18","19","其他"],
            color:["#65b2f6"]
        })
    },
    graduationBar:function(){
        var chart = new Charts();
        chart.getChart({
            dom:"graduationBar",
            data:[
                {
                    name:"400-490",
                    data:[221,22,200,77]
                },
                {
                    name:"500-590",
                    data:[355,177,544,221]
                },
                {
                    name:"600-690",
                    data:[54,32,122,344]
                },
                {
                    name:"700-790",
                    data:[543,345,235,453]
                },
                {
                    name:"800以上",
                    data:[50,30,20,50]
                },

            ],
            title:"毕业分析条形图",
            type:"bar",
            xAxis:["2015年","2016年","2017年","2018年"],
        })
    }

}

