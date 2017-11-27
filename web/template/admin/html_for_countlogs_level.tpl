<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.ReportLine}}</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<style type="text/css">
BODY {
	FONT-SIZE: 12px;text-align: center;
	margin-top:15px;
}
TD {
 FONT-SIZE:12px; 
}

th {
	background-COLOR: d9ecfa;
}

A {
	COLOR: blue; TEXT-DECORATION: none
}
A:hover {
	COLOR: ff0000; TEXT-DECORATION: underline
}
DIV {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; MARGIN: 1px; PADDING-TOP: 0px
}
FORM {
	MARGIN: 0px
}
INPUT {
	BORDER-RIGHT: #6699cc 1px solid; BORDER-TOP: #6699cc 1px solid; BACKGROUND: #ffffff; MARGIN: 1px 0px; FONT: 12px/1.3em Arial, Helvetica, sans-serif; BORDER-LEFT: #6699cc 1px solid; COLOR: #006699; BORDER-BOTTOM: #6699cc 1px solid
}
TEXTAREA {
	BORDER-RIGHT: #6699cc 1px solid; BORDER-TOP: #6699cc 1px solid; BACKGROUND: #ffffff; MARGIN: 1px 0px; FONT: 12px/1.3em Arial, Helvetica, sans-serif; BORDER-LEFT: #6699cc 1px solid; COLOR: #006699; BORDER-BOTTOM: #6699cc 1px solid
}
SELECT {
	BORDER-RIGHT: #6699cc 1px solid; BORDER-TOP: #6699cc 1px solid; BACKGROUND: #ffffff; MARGIN: 1px 0px; FONT: 12px/1.3em Arial, Helvetica, sans-serif; BORDER-LEFT: #6699cc 1px solid; COLOR: #006699; BORDER-BOTTOM: #6699cc 1px solid
}
#div_header {
	BORDER-RIGHT: #799ae1 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #799ae1 1px solid; MARGIN-TOP: 2px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; BORDER-LEFT: #799ae1 1px solid; PADDING-TOP: 0px; BORDER-BOTTOM: #799ae1 1px solid; width:98%;
}
#div_main {
	BORDER-RIGHT: #799ae1 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #799ae1 1px solid; MARGIN-TOP: 20px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; BORDER-LEFT: #799ae1 1px solid; PADDING-TOP: 0px; BORDER-BOTTOM: #799ae1 1px solid; width:98%;
}
.div_title_box {
	FONT-WEIGHT: bold; COLOR: #ffffff; HEIGHT: 25px; BACKGROUND-COLOR: #799ae1; TEXT-ALIGN: center
}
.div_content_box {
	BACKGROUND-COLOR: #cad7f7
}
.input_shorttext {
	WIDTH: 150px; HEIGHT: 20px
}
.div_content_box TD {
	BORDER-RIGHT: white 1px solid; BORDER-TOP: white 1px solid; BORDER-LEFT: white 1px solid; COLOR: black; BORDER-BOTTOM: white 1px solid
}
.div_content_box TH {
	FONT-SIZE: 12px; BACKGROUND-IMAGE: url(images/Th_Bg.gif); HEIGHT: 30px
}
#guestbook_edit {
	
}
#guestbook_edit TEXTAREA {
	WIDTH: 500px; HEIGHT: 100px
}
#guestbook_reply TEXTAREA {
	WIDTH: 500px; HEIGHT: 100px
}
.main_title
{
	font-size: 14px;
	font-weight: bold;
	color: #ffffff;
	padding-top: 5px;
	padding-left:3px;

}
.main_content{
	padding:10px;
		border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-right-color: 3a6ea7;
	border-bottom-color: 3a6ea7;
	border-left-color: 3a6ea7;
}
.td_line
{
	border-bottom-width: 1px;
	border-bottom-style: dashed;
	border-bottom-color: #adadad;
}
.btn1
{
	background-image: url(images/btn1.gif);
	height: 24px;
	width: 64px;
	font-size: 12px;
	color: #FFFFFF;
	border:0px;
}

.btn2
{
	background-image: url(images/btn2.gif);
	height: 24px;
	width: 125px;
	font-size: 12px;
	color: #FFFFFF;
	border:0px;
}
/* This is for Gecko-based browsers */

.DynarchCalendar {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
}

.DynarchCalendar-title, .DynarchCalendar-title div {
  -moz-border-radius: 0 0 4px 4px;
  -webkit-border-radius: 0 0 4px 4px;
  border-radius: 0 0 4px 4px;
}

.DynarchCalendar-topBar {
  -moz-border-radius: 4px 4px 0 0;
  -webkit-border-radius: 4px;
  border-radius: 4px 4px 0 0;
}

.DynarchCalendar-bottomBar {
  -moz-border-radius: 0 0 4px 4px;
  -webkit-border-radius: 0 0 4px 4px;
  border-radius: 0 0 4px 4px;
}

.DynarchCalendar-bottomBar-today {
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}

.DynarchCalendar-navBtn, .DynarchCalendar-navBtn div {
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}

.DynarchCalendar-menu {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
}

.DynarchCalendar-menu table td div {
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}

.DynarchCalendar-weekNumber {
  -moz-border-radius: 4px 0 0 4px;
  -webkit-border-radius: 4px 0 0 4px;
  border-radius: 4px 0 0 4px;
}

.DynarchCalendar-day {
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}

.DynarchCalendar-day-disabled {
  -moz-border-radius: 0;
  -webkit-border-radius: 0;
  border-radius: 0;
}

.DynarchCalendar-tooltipCont {
  -moz-border-radius: 0 0 5px 5px;
  -webkit-border-radius: 5px;
}

.DynarchCalendar-time-hour, .DynarchCalendar-time-minute {
  -moz-border-radius: 3px 0 0 3px;
  -webkit-border-radius: 3px;
}

.DynarchCalendar-time-am {
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
}

</style>
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <tr >
          
          <td height="35" bgcolor="#528AC7" class="main_title">{{$language.ReportManager}}——报表查看</td>         
          
        </tr>
        </tr>
      </table></td>
  </tr>

  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width=70%"  class="BBtable" style="text-align:center">
					<tr>
					
					{{if $table == "countlogs_day_level"}}
						<th class="list_bg" width="10%"  bgcolor="d9ecfa" width="5%">日期</th>
					
					{{else }} 
					<th class="list_bg"  width="10%"   bgcolor="d9ecfa" >起始日期</th>
						<th class="list_bg" width="10%"   bgcolor="d9ecfa" >结束日期</th>
					{{/if}}
						
			          <TH width="8%" class="list_bg">level</TH>
					    <TH width="5%" class="list_bg">alllog</TH>
						
					</tr>
					{{section name=t loop=$all}}
					<tr>
		
						{{if $table == "countlogs_day_level"}}
							<td>{{$all[t].date}}</td>
						{{else }} 
							<td>{{$all[t].date_start}}</td>
							<td>{{$all[t].date_end}}</td>
							
						{{/if}}
						 <TD>{{$all[t].level}}</TD>

			              <TD>{{$all[t].alllog}}</TD>
						
					</tr>
					{{/section}}
					
				</table>
	</td>
  </tr>

</table>
</body>
</html>


