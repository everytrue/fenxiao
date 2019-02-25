{extend name="public/container"}
{block name="content"}
<div class="layui-fluid">
    <!--列表-->
    <table id="list" lay-filter="list"></table>
    <!--end-->
</div>
<script src="{__ADMIN_PATH}js/layuiList.js"></script>
<script src="/public/static/plug/layui/layui.all.js"></script>
{/block}
{block name="script"}

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
</script>
<script>
    layui.use(['table', 'layer'], function(){
        var table = layui.table;
        table.render({
            elem: '#list'
            ,url:'/index.php/admin/approval.approval_api/pageList'
            ,parseData: function (res) {
                return {
                    'code': res.code,
                    'msg': res.msg,
                    'count': res.data.total,
                    'data': res.data.list
                };
            }
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,cols: [[
                {field:'id', title: 'ID', sort: true}
                ,{field:'name', title: '姓名'}
                ,{field:'id_number', title: '身份证号码', sort: true}
                ,{field:'phone', title: '手机号'}
                ,{field:'bank', title: '银行'} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
                ,{field:'experience', title: '推广经验', sort: true}
                ,{field:'status', title: '状态', sort: true}
                ,{field:'create_time', title: '创建时间'}
                ,{fixed: 'right', width: 165, align:'center', toolbar: '#barDemo'}
            ]]
        });

        table.on('tool(list)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                ,layEvent = obj.event; //获得 lay-event 对应的值
            if(layEvent === 'detail'){
                layer.open({
                    type: 1,
                    //skin: 'layui-layer-rim', //加上边框
                    area: ['60%', '500px'], //宽高
                    content: ['/index.php/admin/approval.approval_api/detail']
                });
            }
        });
    });
</script>
{/block}
