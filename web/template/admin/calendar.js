<!--
document.writeln('<div id=meizzDateLayer style="position: absolute; width: 142; height: 166; z-index: 10009; display: none">');
document.writeln('<span id=tmpSelectYearLayer   style="z-index: 9999;position: absolute;top: 2; left: 18;display: none"></span>');
document.writeln('<span id=tmpSelectMonthLayer style="z-index: 9999;position: absolute;top: 2; left: 75;display: none"></span>');
document.writeln('<table border=0 cellspacing=1 cellpadding=0 width=142 height=160 bgcolor=#000000 onselectstart="return false">');
document.writeln('   <tr><td width=142 height=23 bgcolor=#FFFFFF><table border=0 cellspacing=1 cellpadding=0 width=140 height=23>');
document.writeln('       <tr align=center><td width=20 align=center bgcolor=#808080 style="font-size:12px;cursor: pointer;color: #FFD700" ');
document.writeln('         onclick="meizzPrevM()" title="前一月"><b>&lt;</b>');
document.writeln('         </td><td width=100 align=center style="font-size:12px;cursor:default">');

document.writeln('         <span id=meizzYearHead onmouseover="style.backgroundColor=\'yellow\'" onmouseout="style.backgroundColor=\'white\'" title="点击这里选择年份" onclick="tmpSelectYearInnerHTML(this)" style="cursor: pointer;"></span>&nbsp;年&nbsp;<span');
document.writeln('          id=meizzMonthHead onmouseover="style.backgroundColor=\'yellow\'" onmouseout="style.backgroundColor=\'white\'" title="点击这里选择月份" onclick="tmpSelectMonthInnerHTML(this)" style="cursor: pointer;"></span>&nbsp;月</td>');

document.writeln('         <td width=20 bgcolor=#808080 align=center style="font-size:12px;cursor: pointer;color: #FFD700" ');
document.writeln('          onclick="meizzNextM()" title="后一月"><b>&gt;</b></td></tr>');
document.writeln('     </table></td></tr>');
document.writeln('   <tr><td width=142 height=18 bgcolor=#808080>');
document.writeln('<table border=0 cellspacing=0 cellpadding=0 width=140 height=1 style="cursor:default">');
document.writeln('<tr align=center><td style="font-size:12px;color:#FFFFFF">日</td>');
document.writeln('<td style="font-size:12px;color:#FFFFFF" class="td1">一</td><td style="font-size:12px;color:#FFFFFF">二</td>');
document.writeln('<td style="font-size:12px;color:#FFFFFF">三</td><td style="font-size:12px;color:#FFFFFF">四</td>');
document.writeln('<td style="font-size:12px;color:#FFFFFF">五</td><td style="font-size:12px;color:#FFFFFF">六</td></tr>');
document.writeln('</table></td></tr><!-- Author:F.R.Huang(meizz) http://www.meizz.com/ mail: meizz@hzcnc.com2002-10-8 --><!-- Hack By Lulu http://www.hotcity.cn2007-09-26 -->');
document.writeln('   <tr><td width=142 height=120>');
document.writeln('     <table border=0 cellspacing=1 cellpadding=0 width=140 height=120 bgcolor=#FFFFFF>');
var n=0; for (j=0;j<5;j++){ document.writeln (' <tr align=center>'); for (i=0;i<7;i++){
document.writeln('<td width=20 height=20 id=meizzDay'+n+' style="font-size:12px" onclick=meizzDayClick(this)></td>');n++;}
document.writeln('</tr>');}
document.writeln('       <tr align=center><td width=20 height=20 style="font-size:12px" id=meizzDay35 ');
document.writeln('          onclick=meizzDayClick(this)></td>');
document.writeln('         <td width=20 height=20 style="font-size:12px" id=meizzDay36 onclick=meizzDayClick(this)></td>');
document.writeln('         <td colspan=5 align=right><span onclick=closeLayer() style="font-size:12px;cursor: pointer"');
document.writeln('          title="返回（不选择日期）"><u>关闭</u></span>&nbsp;</td></tr>');
document.writeln('     </table></td></tr><tr><td>');
document.writeln('         <table border=0 cellspacing=1 cellpadding=0 width=100% bgcolor=#FFFFFF>');
document.writeln('           <tr><td align=left><input type=button value="<<" title="前一年" onclick="meizzPrevY()" ');
document.writeln('              onfocus="this.blur()" style=" cursor: pointer;BACKGROUND-COLOR: #808080;BORDER-BOTTOM: #808080 1px outset; BORDER-LEFT: #808080 1px outset; BORDER-RIGHT: #808080 1px outset; BORDER-TOP: #808080 1px outset; FONT-SIZE: 12px; height: 20px;color: #FFD700; font-weight: bold"><input title="前一月" type=button ');
document.writeln('              value="<" onclick="meizzPrevM()" onfocus="this.blur()" style="cursor: pointer;BACKGROUND-COLOR: #808080;BORDER-BOTTOM: #808080 1px outset; BORDER-LEFT: #808080 1px outset; BORDER-RIGHT: #808080 1px outset; BORDER-TOP: #808080 1px outset;font-size: 12px; height: 20px;color: #FFD700; font-weight: bold"></td><td ');
document.writeln('              align=center><input type=button value="重置" onclick="meizzToday()" ');
document.writeln('              onfocus="this.blur()" title="显示当前时间" style="cursor: pointer;BACKGROUND-COLOR: #808080;BORDER-BOTTOM: #808080 1px outset; BORDER-LEFT: #808080 1px outset; BORDER-RIGHT: #808080 1px outset; BORDER-TOP: #808080 1px outset;font-size: 12px; height: 20px;color: #FFFFFF; font-weight: bold"></td><td ');
document.writeln('              align=right><input type=button value=">" onclick="meizzNextM()" ');
document.writeln('              onfocus="this.blur()" title="后一月" style="cursor: pointer;BACKGROUND-COLOR: #808080;BORDER-BOTTOM: #808080 1px outset; BORDER-LEFT: #808080 1px outset; BORDER-RIGHT: #808080 1px outset; BORDER-TOP: #808080 1px outset;font-size: 12px; height: 20px;color: #FFD700; font-weight: bold"><input ');
document.writeln('              type=button value=" >>" title="后一年" onclick="meizzNextY()"');
document.writeln('              onfocus="this.blur()" style="cursor: pointer;BACKGROUND-COLOR: #808080;BORDER-BOTTOM: #808080 1px outset; BORDER-LEFT: #808080 1px outset; BORDER-RIGHT: #808080 1px outset; BORDER-TOP: #808080 1px outset;font-size: 12px; height: 20px;color: #FFD700; font-weight: bold"></td>');
document.writeln('</tr></table></td></tr></table><iframe src="javascript:false" style="position:absolute; visibility:inherit; top:0px; left:0px; width:100%; height:100%; z-index:-1; filter="progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)";"></iframe></div>');


var outObject;
var dads;
function setday(tt,obj) //主调函数
{
   if (arguments.length >   2){alert("对不起！传入本控件的参数太多！");return;}
   if (arguments.length == 0){alert("对不起！您没有传回本控件任何参数！");return;}
   dateObj=document.getElementById("meizzDateLayer");
   dads   = dateObj.style;
   var th = tt;
   var ttop   = tt.offsetTop;      //TT 控件的定位点高
   var thei   = tt.clientHeight;   //TT 控件本身的高
   var tleft = tt.offsetLeft;     //TT 控件的定位点宽
   var ttyp   = tt.type;           //TT 控件的类型
   while (tt = tt.offsetParent){ttop+=tt.offsetTop; tleft+=tt.offsetLeft;}
   dads.top   = (ttyp=="image")? ttop+thei : ttop+thei+6;
   dads.left = tleft;
   outObject = (arguments.length == 1) ? th : obj;
   dads.display = '';
   //event.returnValue=false;
}

var MonHead = new Array(12);          //定义阳历中每个月的最大天数
     MonHead[0] = 31; MonHead[1] = 28; MonHead[2] = 31; MonHead[3] = 30; MonHead[4]   = 31; MonHead[5]   = 30;
     MonHead[6] = 31; MonHead[7] = 31; MonHead[8] = 30; MonHead[9] = 31; MonHead[10] = 30; MonHead[11] = 31;

var meizzTheYear=new Date().getFullYear(); //定义年的变量的初始值
var meizzTheMonth=new Date().getMonth()+1; //定义月的变量的初始值
var meizzWDay=new Array(37);                //定义写日期的数组


function dateOnclick(e) //任意点击时关闭该控件
{
var srcElement;
if(document.all)
   srcElement = window.event.srcElement;
else
   srcElement =e.target;

   with(srcElement)
   { if (tagName != "INPUT")
     dads.display="none";
   }
}
document.onclick = dateOnclick;
function meizzWriteHead(yy,mm)   //往  head  中写入当前的年与月
{
if(document.all)
{
   //ie
   document.getElementById("meizzYearHead").innerText=yy;
   document.getElementById("meizzMonthHead").innerText=mm;
}else{
   document.getElementById("meizzYearHead").textContent=yy;
   document.getElementById("meizzMonthHead").textContent=mm;
}


}

function tmpSelectYearInnerHTML(obj) //年份的下拉框
{

var strYear=getInnerText(obj);;

   if (strYear.match(/\D/)!=null){alert("年份输入参数不是数字！");return;}
   var m = (strYear) ? strYear : new Date().getFullYear();
   if (m < 1000 || m > 9999) {alert("年份值不在 1000到 9999之间！");return;}
   var n = m - 10;
   if (n < 1000) n = 1000;
   if (n + 26 > 9999) n = 9974;
   var s = "<select name=tmpSelectYear style='font-size: 12px' "
      s += "onblur='document.getElementById(\"tmpSelectYearLayer\").style.display=\"none\"' "
      s += "onchange='document.getElementById(\"tmpSelectYearLayer\").style.display=\"none\";"
      s += "meizzTheYear = this.value; meizzSetDay(meizzTheYear,meizzTheMonth)'>\r\n";
   var selectInnerHTML = s;
   for (var i = n; i < n + 26; i++)
   {
     if (i == m)
        {selectInnerHTML += "<option value='" + i + "' selected>" + i + "年" + "</option>\r\n";}
     else {selectInnerHTML += "<option value='" + i + "'>" + i + "年" + "</option>\r\n";}
   }
   selectInnerHTML += "</select>";
   document.getElementById("tmpSelectYearLayer").style.display="";
   document.getElementById("tmpSelectYearLayer").innerHTML = selectInnerHTML;
   document.getElementById("tmpSelectYear").focus();
}

function tmpSelectMonthInnerHTML(obj) //月份的下拉框
{
var strMonth=getInnerText(obj);;

   if (strMonth.match(/\D/)!=null){alert("月份输入参数不是数字！");return;}
   var m = (strMonth) ? strMonth : new Date().getMonth() + 1;
   var s = "<select name=tmpSelectMonth style='font-size: 12px' "
      s += "onblur='document.getElementById(\"tmpSelectMonthLayer\").style.display=\"none\"' "
      s += "onchange='document.getElementById(\"tmpSelectMonthLayer\").style.display=\"none\";"
      s += "meizzTheMonth = this.value; meizzSetDay(meizzTheYear,meizzTheMonth)'>\r\n";
   var selectInnerHTML = s;
   for (var i = 1; i < 13; i++)
   {
     if (i == m)
        {selectInnerHTML += "<option value='"+i+"' selected>"+i+"月"+"</option>\r\n";}
     else {selectInnerHTML += "<option value='"+i+"'>"+i+"月"+"</option>\r\n";}
   }
   selectInnerHTML += "</select>";
   document.getElementById("tmpSelectMonthLayer").style.display="";
   document.getElementById("tmpSelectMonthLayer").innerHTML = selectInnerHTML;
   document.getElementById("tmpSelectMonth").focus();
}

function closeLayer()                //这个层的关闭
{
     dads.display="none";
   }

function dateOnkeydown(e)
   {
    var keynum;
    if(window.event)    //    IE   浏览器   
    {   
    keynum    =    e.keyCode   
    }else    if(e.which){    //    Netscape/Firefox/Opera   浏览器   
    keynum    =    e.which   
    }   

     if (keynum==27)dads.display="none";
   }
document.onkeydown = dateOnkeydown;


function IsPinYear(year)             //判断是否闰平年
   {
     if (0==year%4&&((year%100!=0)||(year%400==0))) return true;else return false;
   }

function GetMonthCount(year,month)   //闰年二月为29天
   {
     var c=MonHead[month-1];if((month==2)&&IsPinYear(year)) c++;return c;
   }

function GetDOW(day,month,year)      //求某天的星期几
   {
     var dt=new Date(year,month-1,day).getDay()/7; return dt;
   }

function meizzPrevY()   //往前翻 Year
   {
     if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear--;}
     else{alert("年份超出范围（1000-9999）！");}
     meizzSetDay(meizzTheYear,meizzTheMonth);
   }
function meizzNextY()   //往后翻 Year
   {
     if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear++;}
     else{alert("年份超出范围（1000-9999）！");}
     meizzSetDay(meizzTheYear,meizzTheMonth);
   }
function meizzToday()   //Today Button
   {
     meizzTheYear = new Date().getFullYear();
     meizzTheMonth = new Date().getMonth()+1;
     meizzSetDay(meizzTheYear,meizzTheMonth);
   }
function meizzPrevM()   //往前翻月份
   {
     if(meizzTheMonth>1){meizzTheMonth--}else{meizzTheYear--;meizzTheMonth=12;}
     meizzSetDay(meizzTheYear,meizzTheMonth);
   }
function meizzNextM()   //往后翻月份
   {
     if(meizzTheMonth==12){meizzTheYear++;meizzTheMonth=1}else{meizzTheMonth++}
     meizzSetDay(meizzTheYear,meizzTheMonth);
   }

function meizzSetDay(yy,mm)    //主要的写程序**********
{
   meizzWriteHead(yy,mm);
   for (var i = 0; i < 37; i++){meizzWDay[i]=""};   //将显示框的内容全部清空
   var day1 = 1,firstday = new Date(yy,mm-1,1).getDay();   //某月第一天的星期几
   for (var i = firstday; day1 < GetMonthCount(yy,mm)+1; i++){meizzWDay[i]=day1;day1++;}
   for (var i = 0; i < 37; i++)
   { var da = document.getElementById("meizzDay"+i+"");      //书写新的一个月的日期星期排列
     if (meizzWDay[i]!="")
       { da.innerHTML = "<b>" + meizzWDay[i] + "</b>";
         da.style.backgroundColor = (yy == new Date().getFullYear() &&
         mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()) ? "#FFD700" : "#73a6de";
         da.style.cursor="pointer"
       }
     else{da.innerHTML="";da.style.backgroundColor="";da.style.cursor="default"}
   }
}
function meizzDayClick(obj)   //点击显示框选取日期，主输入函数*************
{
var n=getInnerText(obj);

   var yy = meizzTheYear;
   var mm = meizzTheMonth;
   if (mm < 10){mm = "0" + mm;}
   if (outObject)
   {
     if (!n) {outObject.value=""; return;}
     if ( n < 10){n = "0" + n;}
     outObject.value= yy + "-" + mm + "-" + n ; //注：在这里你可以输出改成你想要的格式
     closeLayer();
   }
   else {closeLayer(); alert("您所要输出的控件对象并不存在！");}
}
meizzSetDay(meizzTheYear,meizzTheMonth);


function getInnerText(obj)
{
if(document.all)
{
   //ie
   return obj.innerText;
}else{
   return obj.textContent;
}
}
// -->
