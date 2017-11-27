在页面中加入下面代码 
<SCRIPT type=text/javascript>
var siteUrl = "图片路径";
</SCRIPT>


表单内容

<INPUT id=startdate readOnly value="<?php echo date('Y-m-d H:i:s');?>" 
      name=startdate>
      <IMG 
      onclick="getDatePicker('startdate', event, 21)" 
      src="../Public/images/time.gif"> 