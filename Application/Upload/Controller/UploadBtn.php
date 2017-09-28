<?php

$str = <<<EOF


<script type="text/javascript">
	var img_id_upload=new Array();//初始化数组，存储已经上传的图片名
	var i=0;//初始化数组下标
	$(function() {
	    $('#file_upload').uploadify({
	    	'auto'     : false,//关闭自动上传
	    	'removeTimeout' : 1,//文件队列上传完成1秒后删除
	        'swf'      : '/Public/upload/uploadify.swf',
	        'uploader' : "/index.php/Upload/Upload/moveUpload/tb/{$tableName}/moduleid/{$id}",
	        'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
			'buttonText' : '上传附件',//设置按钮文本
	        'multi'    : true,//允许同时上传多张图片
	        'uploadLimit' : 50,//一次最多只允许上传10张图片
	        'fileTypeDesc' : 'Image Files',//只允许上传图像
	        'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg; *.txt; *.doc; *.docx; *.rtf; *.ppt; *.zip; *.rar; *.xls; *.pdf; *.xlsx;',//限制允许上传的图片后缀
	        'fileSizeLimit' : '20000KB',//限制上传的图片不得超过200KB 
	        'onUploadSuccess' : function(file, data, response) {
	        		var arr = eval("(" + data + ")");
	        		if(isNaN(arr.id)) {
	        			alert(arr.id);
	        			return;
	        		}
	        		if("" == $("#upload_update").val()){
	        	    	$("#upload_update").val(arr.id);
	        	    } else {
	        	    	var upload_id = $("#upload_update").val();
	        	    	upload_id = upload_id+"|"+arr.id;
	        	    	$("#upload_update").val(upload_id);
	        	    }
	        	    $("#show_upload").append(arr.path);
	        		//每次成功上传后执行的回调函数，从服务端返回数据到前端
	               img_id_upload[i]=data.id;
	               i++;
	        },
	        'onQueueComplete' : function(queueData) {
	        	
	        	alert(i+"个文件上传成功!")
	        	
	        }
	    });
	});
</script>

	<input type="hidden" value="" name="upload_update" id="upload_update"/>

	
	<div class="">
	
	<input type="file" name="file_upload" id="file_upload" />
		<p>
			<a href="javascript:$('#file_upload').uploadify('settings', 'formData', {'typeCode':document.getElementById('id_file').value});$('#file_upload').uploadify('upload','*')">上传</a>
			<a href="javascript:$('#file_upload').uploadify('cancel','*')">重置</a>
		</p>
		<input type="hidden" value="1215154" name="tmpdir" id="id_file">
        
    
    </div>
    </div>
EOF;
