<link href="/hsgm/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="/hsgm/plugins/tree/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">

                    <i class="fa fa-search font-dark"></i>
                    <span class="caption-subject bold uppercase">{{ $pagename }}</span>
                </div>
                
            </div>
            <!-- <div class="portlet-body">先去掉</div> -->
            <div class="portlet-body">
            	<div class="row">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bubble font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">TEST </span>
                            </div>
                            <!-- <div class="actions">
                                <div class="btn-group">
                                    <a class="btn green-haze btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;"> Option 1</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a href="javascript:;">Option 2</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">Option 3</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">Option 4</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                        <div class="portlet-body">
                        
                        
                            	<div id="tree_2" class="tree-demo jstree jstree-2 jstree-default jstree-checkbox-selection" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1" aria-busy="false">
                            	<ul class="jstree-container-ul jstree-children jstree-wholerow-ul jstree-no-dots" role="group">
                            		<li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_1_anchor" aria-expanded="true" id="j2_1" class="jstree-node  jstree-open">
                         			<div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div> 
                            		<i class="jstree-icon jstree-ocl" role="presentation"></i>
                                    <a class="jstree-anchor" href="#" tabindex="-1" id="j2_1_anchor">
                                    	<i class="jstree-icon jstree-checkbox jstree-undetermined" role="presentation"></i>
                                    	<!-- <i class="jstree-icon jstree-themeicon fa fa-folder icon-state-warning icon-lg jstree-themeicon-custom" role="presentation"></i> -->father1
                                    </a>
                                        
                                        <!--11111 begin-->
                            			<ul role="group" class="jstree-children">
                            			<!--1->1 第一个子节点 -->
                                            <li role="treeitem" aria-selected="true" aria-level="2" aria-labelledby="j2_2_anchor" id="j2_2" class="jstree-node  jstree-leaf">
                                            <div unselectable="on" role="presentation" class="jstree-wholerow jstree-wholerow-clicked">&nbsp;</div>
                                            <i class="jstree-icon jstree-ocl" role="presentation"></i>
                                                <a class="jstree-anchor  jstree-clicked" href="#" tabindex="-1" id="j2_2_anchor">
                                                	<i class="jstree-icon jstree-checkbox" role="presentation"></i> 第一子节点
                                                </a>
                                            </li>
                                         <!-- 1->2 第2个子节点 -->
                                            <li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_3_anchor" id="j2_3" class="jstree-node  jstree-leaf">
                                            <div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div>
                                            <i class="jstree-icon jstree-ocl" role="presentation"></i>
                                                <a class="jstree-anchor" href="#" tabindex="-1" id="j2_3_anchor">
                                                	<i class="jstree-icon jstree-checkbox" role="presentation"></i>2222
                                                </a>
                                            </li>
                                         <!--1->3 第3个子节点 begin -->
                                            <li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_4_anchor" aria-expanded="true" id="j2_4" class="jstree-node jstree-open">
                                            <div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div>
                                            <i class="jstree-icon jstree-ocl" role="presentation"></i>
                                                
                                                <a class="jstree-anchor" href="#" tabindex="-1" id="j2_4_anchor">
                                                	<i class="jstree-icon jstree-checkbox" role="presentation"></i>33333
                                                </a>
                                                
                                                
                                                <!--1->3->1-->
                            					<ul role="group" class="jstree-children" style="">
                           
                                                    <li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j2_5_anchor" id="j2_5" class="jstree-node  jstree-leaf jstree-last">
                                                    	<div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div>
                                                    	<i class="jstree-icon jstree-ocl" role="presentation"></i>
                                                        <a class="jstree-anchor" href="#" tabindex="-1" id="j2_5_anchor">
                                                        	<i class="jstree-icon jstree-checkbox" role="presentation"></i>Another node
                                                        </a>
                                                    </li>
                            					</ul>
                            				</li>
                            				<!--1->3  end -->
                            				
                            			<!--1->4   第4个子节点 -->		
                            				<li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_6_anchor" id="j2_6" class="jstree-node  jstree-leaf">
                                				<div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div>
                                				<i class="jstree-icon jstree-ocl" role="presentation"></i>
                                                    <a class="jstree-anchor" href="#" tabindex="-1" id="j2_6_anchor">
                                                    	<i class="jstree-icon jstree-checkbox" role="presentation"></i>custom icon
                                                    </a>
                                                </li>
                                        <!--1->5   第5个子节点 -->
                                            <li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_7_anchor" aria-disabled="true" id="j2_7" class="jstree-node  jstree-leaf jstree-last">
                                            	<div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div>
                                            	<i class="jstree-icon jstree-ocl" role="presentation"></i>
                                                <a class="jstree-anchor  jstree-disabled" href="#" tabindex="-1" id="j2_7_anchor">
                                                	<i class="jstree-icon jstree-checkbox" role="presentation"></i>disabled node
                                                </a>
                                            </li>
                            			</ul>
                            			<!--11111 end-->
                            		</li>
                            		
                                    <li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_8_anchor" id="j2_8" class="jstree-node  jstree-leaf jstree-last">
                                    	<div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div>
                                		<i class="jstree-icon jstree-ocl" role="presentation"></i>
                                    	<a class="jstree-anchor" href="#" tabindex="-1" id="j2_8_anchor">
                                    		<i class="jstree-icon jstree-checkbox" role="presentation"></i>father2 
                                    	</a>
                                    </li>
                           		</ul>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            

    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
<div class="panel-body">

	<h2>配置结构如下：</h2>
	{!! $prev !!}
</div>
<script type="text/javascript">
$(function(){	
    var href="/setgamecfg/list?";
    $("#typeid").change(function(){
    	$("#searchall").attr("href",href+"typeid="+$(this).val());
    
    });
    $(".delcfg").click(function(){
        var delid = $(this).data('delid');
        var type = $(this).data('tid');
    	swal({
    	  title: "你确定要删除 id为"+delid+" 这条记录吗?",
    	 // text: "你确定要删除 id为"+delid+" 这条记录吗",
    	  type: "warning",
    	  showCancelButton: true,
    	  confirmButtonText: "删除！",
    	  cancelButtonText: "取消！~",
    	  confirmButtonClass: "btn-danger",
    	  closeOnConfirm: false,
    	  showLoaderOnConfirm: true
    	}, function () {
     	  setTimeout(function () {
      		 $.ajax( {
  	        	async: false,
  	        	cache: false,
  	            type : "get",
  	            url : "/setgamecfg/del",	            
  	            dataType : 'json',
  	            data : {'_token':'{{csrf_token()}}',id:delid,typeid:type},
  	            success : function(data) {
  	                if(data.status){ 
  	                	swal("Deleted!", data.msg, "success");
  	                	Layout.loadAjaxContent("/setgamecfg/list?typeid="+type);
  	                }else{
  	                	swal("删除失败!");
  	                }
  	            }, 
  	            error: function(request) {
  	            	swal(request);
  	            }
  	        });
     	  }, 100);
      	  
    	});
    });
    

});


</script>    
<script src="/hsgm/plugins/tree/jstree/dist/jstree.min.js" type="text/javascript"></script> 
 <script src="/hsgm/plugins/tree/ui-tree.min.js" type="text/javascript"></script>
<script src="/hsgm/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>                   
<script src="/hsgm/plugins/bootstrap-sweetalert/ui-sweetalert.min.js" type="text/javascript"></script>                           