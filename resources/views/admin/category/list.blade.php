@extends('layouts.admin',['active'=>'分类管理','highlight'=>'分类列表'])
@section('title', '分类管理-'.Config::get('site.site_title'))
@section('style')
    <style>
        .description{
            text-indent: 2em;
            font-size: 13px;
        }
        .el-tag--mini {
            margin-left: 10px;
            border-radius: 50%;
            padding: 0 6px 0 6px;
        }
    </style>
@endsection
@section('content')

    <div id="tree">
        <section class="content-header">
            <div class="pull-left btn_group_work">
                <a href="javascript:;" @click="add({{$rootCategory}},event)" class="btn btn-success" type="button"><i class="fa fa-plus"></i>
                    添加分类</a>
            </div>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 分类管理</a></li>
                <li class="active">分类列表</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">分类列表</h3>
                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right"
                                           placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                <tr style="border-bottom: 2px solid #02a55b">
                                    <th>分类名称</th>
                                    <th style="width: 200px;text-align: center">操作</th>
                                </tr>
                                </tbody>
                            </table>
                            <div v-cloak>
                                <el-tree
                                    :load="loadNode"
                                    lazy
                                    :indent="38"
                                    :props="props"
                                    :data="data"
                                    @node-click="handleNodeClick"
                                    :render-content="renderContent"
                                >
                                </el-tree>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <div class=" pull-right">
                                {{--{!! $league->links() !!}--}}
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <el-dialog
                :title="dialog.title"
                :visible.sync="dialog.show"
                lock-scroll
                size="small"
                width="600px"
                :close-on-click-modal=false
        >
            <el-form :model="form">
                <el-form-item label="分类名称" label-width="">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="分类描述" label-width="">
                    <el-input type="textarea" :rows=4 v-model="form.description"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialog.show = false">取 消</el-button>
                <el-button type="primary" @click="save()">确 定</el-button>
            </div>
        </el-dialog>
    </div>
@endsection

@section('js')
    @parent
    <script>
        new Vue({
            el: '#tree',
            data: function () {
                return {
                    data:[],
                    props: {
                        label: 'name',
                        children: 'children'
                    },
                    dialog:{
                        title:'',
                        show:false,
                    },
                    form:{
                        id:'',
                        name:'',
                        isAdd:false,
                        description:''
                    }
                }
            },
            methods: {
                add :function (node,e) {
                    var info = node.data;
                    this.dialog = {
                        title:'添加'+info.name+'的子分类',
                        show:true
                    };
                    this.form = {
                        id:info.id,
                        isAdd:true,
                        name:'',
                        description:''
                    };

                    e.cancelBubble = true;
                },
                edit :function (node,e) {
                    var info = node.data;

                    this.dialog = {
                        title:'修改'+info.name+'分类',
                        show:true
                    };
                    this.form = {
                        id:info.id,
                        isAdd:false,
                        name:info.name,
                        description:info.description
                    };
                    e.cancelBubble = true;
                    //点击确认添加信息了api
                },
                destroy :function (node,e) {
                    var APP =this;
                    var info = node.data;
                    APP.$confirm('此操作将删除该分类和所有子分类,文章将会找不到分类, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(function () {
                        APP.ajax("POST",'{{ route('admin.category_destroy') }}',{id:info.id},function (r) {
                            APP.$message({
                                message: '删除成功！',
                                type: 'success'
                            });
                            setTimeout(function () {
                                window.location.reload();
                            },APP)
                        },this);
                    }).catch(function () {
//                        APP.$message({
//                        type: 'info',
//                        message: '已取消删除'
//                    });
                });
                    e.cancelBubble = true;
                },
                save :function () {
                    var APP =this;
                    if(!APP.form.isAdd){
                        APP.ajax("POST",'{{ route('admin.category_edit') }}',this.form,function (r) {
                            APP.$message({
                                message: '保存成功！',
                                type: 'success'
                            });
                            setTimeout(function () {
                                window.location.reload();
                            },500)
                        },this);
                    }else {//添加子分类
                        APP.ajax("POST",'{{ route('admin.category_add') }}',this.form,function (r) {
                            APP.$message({
                                message: '添加子分类成功！',
                                type: 'success'
                            });
                            setTimeout(function () {
                                window.location.reload();
                            },500)
                        },this);
                    }
                },
                info :function (node,e) {
                    var info = node.data;
                    this.$alert('<strong>名称:'+info.name+'</strong><br>描述:<br><div class="description">'+info.description+'</div>', '分类详情', {
                        type: 'info',
                        dangerouslyUseHTMLString: true,
                        callback: action = function () {}
                    });
                    e.cancelBubble = true;
                },
                handleNodeClick : function (data,k) {

                },
                loadNode :function (node, resolve) {
                    var APP = this;

                    if (node.level === 0) {return resolve({!! json_encode($node) !!});}


                    var nodeId = node.data.id;
                    APP.ajax("GET","{{ route('admin.category_get_node') }}/"+nodeId,{},function (data) {
                        return resolve(data);
                    },APP);

                    return resolve([]);

                },
                renderContent : function (h, { node, data, store }) {

                    var APP = this;
                    return h('el-row',{props: {type:"flex"}}, [
                        h('div', {
                            props: {

                            },
                            style: {
                                flex:"1"
                            }//(parseInt(node.data.right) - parseInt(node.data.left) - 1)/2
                        }, [h('span',{},node.data.name),h('el-tag',{props: {type:"danger",size:"mini"}},(parseInt(node.data.rgt) - parseInt(node.data.lft) - 1)/2)]),
                        h('div', {
                            props: {

                            },
                            style: {
                                width:"200px"
                            },
                            on: {
                                click: function () {}
                            }
                        },[h('el-button-group',{},[
                                h('el-button',{props: {type:"info",icon:"el-icon-information",size:"mini"},on: {click:function () {
                                    APP.info(node,event);
                                }}},''),
                                h('el-button',{props: {type:"primary",icon:"el-icon-edit",size:"mini"},on: {click:function () {
                                    APP.edit(node,event);
                                }}},''),
                                h('el-button',{props: {type:"success",icon:"el-icon-plus",size:"mini"},on: {click:function () {
                                    APP.add(node,event);
                                }}},''),
                                h('el-button',{props: {type:"danger",icon:"el-icon-delete",size:"mini"},on: {click:function () {
                                    APP.destroy(node,event);
                                }}},'')
                            ]
                        )]),

                    ]);
                }

            }
        })
    </script>
@endsection