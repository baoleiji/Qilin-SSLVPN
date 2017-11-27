/**//**
*本日历选择控件由tiannet根据前人经验完善而得。大部分代码来自meizz的日历控件。
*tiannet添加了时间选择功能、select,object标签隐藏功能，还有其它小功能。
*使用方法：
* (1)只选择日期 <input type="text" name="date" readOnly onClick="setDay(this);">
* (2)选择日期和小时 <input type="text" name="dateh" readOnly onClick="setDayH(this);">
* (3)选择日期和小时及分钟 <input type="text" name="datehm" readOnly onClick="setDayHM(this);">
*设置参数的方法
* (1)设置日期分隔符 setDateSplit(strSplit);默认为"-"
* (2)设置日期与时间之间的分隔符 setDateTimeSplit(strSplit);默认为" "
* (3)设置时间分隔符 setTimeSplit(strSplit);默认为":"
* (4)设置(1),(2),(3)中的分隔符 setSplit(strDateSplit,strDateTimeSplit,strTimeSplit);
* (5)设置开始和结束年份 setYearPeriod(intDateBeg,intDateEnd)
*说明：
* 默认返回的日期时间格式如同：2005-02-02 08:08
*/
//------------------ 样式定义 ---------------------------//
//功能按钮同样样式
var s_tiannet_turn_base = "height:16px;font-size:9pt;color:white;border:0 solid #CCCCCC;cursor:hand;background-color:#2650A6;";
//翻年、月等的按钮
var s_tiannet_turn = "width:28px;" + s_tiannet_turn_base;
//关闭、清空等按钮样式
var s_tiannet_turn2 = "width:22px;" + s_tiannet_turn_base;
//年选择下拉框
var s_tiannet_select = "width:64px;display:none;";
//月、时、分选择下拉框
var s_tiannet_select2 = "width:46px;display:none;";
//日期选择控件体的样式
var s_tiannet_body = "width:150;background-color:#2650A6;display:none;z-index:9998;position:absolute;" +
"border-left:1 solid #CCCCCC;border-top:1 solid #CCCCCC;border-right:1 solid #999999;border-bottom:1 solid #999999;";
//显示日的td的样式
var s_tiannet_day = "width:21px;height:20px;background-color:#D8F0FC;font-size:10pt;";
//字体样式
var s_tiannet_font = "color:#FFCC00;font-size:9pt;cursor:hand;";
//链接的样式
var s_tiannet_link = "text-decoration:none;font-size:9pt;color:#2650A6;";
//横线
var s_tiannet_line = "border-bottom:1 solid #6699CC";
//------------------ 变量定义 ---------------------------//
var tiannetYearSt = 1950;//可选择的开始年份
var tiannetYearEnd = 2010;//可选择的结束年份
var tiannetDateNow = new Date();
var tiannetYear = tiannetDateNow.getFullYear(); //定义年的变量的初始值
var tiannetMonth = tiannetDateNow.getMonth()+1; //定义月的变量的初始值
var tiannetDay = tiannetDateNow.getDate();
var tiannetHour = tiannetDateNow.getHours();
var tiannetMinute = tiannetDateNow.getMinutes();
var tiannetArrDay=new Array(42); //定义写日期的数组
var tiannetDateSplit = "-"; //日期的分隔符号
var tiannetDateTimeSplit = " "; //日期与时间之间的分隔符
var tiannetTimeSplit = ":"; //时间的分隔符号
var tiannetOutObject; //接收日期时间的对象
var arrTiannetHide = new Array();//被强制隐藏的标签
var m_bolShowHour = false;//是否显示小时
var m_bolShowMinute = false;//是否显示分钟
var m_bolShowYMD = true; //是否显示日期

var m_aMonHead = new Array(12); //定义阳历中每个月的最大天数
m_aMonHead[0] = 31; m_aMonHead[1] = 28; m_aMonHead[2] = 31; m_aMonHead[3] = 30; m_aMonHead[4] = 31; m_aMonHead[5] = 30;
m_aMonHead[6] = 31; m_aMonHead[7] = 31; m_aMonHead[8] = 30; m_aMonHead[9] = 31; m_aMonHead[10] = 30; m_aMonHead[11] = 31;
// ---------------------- 用户可调用的函数 -----------------------------//
//用户主调函数－只选择日期
function setDay(obj){
tiannetOutObject = obj;
m_bolShowHour = false;
m_bolShowMinute = false;
m_bolShowYMD = true;
//如果标签中有值，则将日期初始化为当前值
var strValue = tiannetTrim(tiannetOutObject.value);
if( strValue != "" ){
tiannetInitDate(strValue);
}
tiannetPopCalendar();
}
//用户主调函数－选择日期和小时
function setDayH(obj){
tiannetOutObject = obj;
m_bolShowHour = true;
m_bolShowYMD = true;
//如果标签中有值，则将日期和小时初始化为当前值
var strValue = tiannetTrim(tiannetOutObject.value);
if( strValue != "" ){
tiannetInitDate(strValue.substring(0,10));
var hour = strValue.substring(11,13);
if( hour < 10 ) tiannetHour = hour.substring(1,2);
}
tiannetPopCalendar();
}
//用户主调函数－选择日期和小时及分钟
function setDayHM(obj){
tiannetOutObject = obj;
m_bolShowHour = true;
m_bolShowMinute = true;
m_bolShowYMD = true;
//如果标签中有值，则将日期和小时及分钟初始化为当前值
var strValue = tiannetTrim(tiannetOutObject.value);
if( strValue != "" ){
tiannetInitDate(strValue.substring(0,10));
var time = strValue.substring(11,16);
var arr = time.split(tiannetTimeSplit);
tiannetHour = arr[0];
tiannetMinute = arr[1];
if( tiannetHour < 10 ) tiannetHour = tiannetHour.substring(1,2);
if( tiannetMinute < 10 ) tiannetMinute = tiannetMinute.substring(1,2);
}else setNow();
tiannetPopCalendar();
}

function setHM(obj){
	tiannetOutObject = obj;
	m_bolShowYMD = false;
	m_bolShowHour = true;
	m_bolShowMinute = true;
	//如果标签中有值，则将日期和小时及分钟初始化为当前值
	var strValue = tiannetTrim(tiannetOutObject.value);
	if( strValue != "" ){
	tiannetInitDate(tiannetYear+tiannetDateSplit+tiannetMonth+tiannetDateSplit+tiannetDay);
	var time = strValue.substring(0,5);
	var arr = time.split(tiannetTimeSplit);
	tiannetHour = arr[0];
	tiannetMinute = arr[1];
	if( tiannetHour < 10 ) tiannetHour = tiannetHour.substring(1,2);
	if( tiannetMinute < 10 ) tiannetMinute = tiannetMinute.substring(1,2);
	}else setNow();
	tiannetPopCalendar();
}

function setNow(){

}

//设置开始日期和结束日期
function setYearPeriod(intDateBeg,intDateEnd){
tiannetYearSt = intDateBeg;
tiannetYearEnd = intDateEnd;
}
//设置日期分隔符。默认为"-"
function setDateSplit(strDateSplit){
tiannetDateSplit = strDateSplit;
}
//设置日期与时间之间的分隔符。默认为" "
function setDateTimeSplit(strDateTimeSplit){
tiannetDateTimeSplit = strDateTimeSplit;
}
//设置时间分隔符。默认为":"
function setTimeSplit(strTimeSplit){
tiannetTimeSplit = strTimeSplit;
}
//设置分隔符
function setSplit(strDateSplit,strDateTimeSplit,strTimeSplit){
tiannetDateSplit(strDateSplit);
tiannetDateTimeSplit(strDateTimeSplit);
tiannetTimeSplit(strTimeSplit);
}
//设置默认的日期。格式为：YYYY-MM-DD
function setDefaultDate(strDate){
tiannetYear = strDate.substring(0,4);
tiannetMonth = strDate.substring(5,7);
tiannetDay = strDate.substring(8,10);
}
//设置默认的时间。格式为：HH24:MI
function setDefaultTime(strTime){
tiannetHour = strTime.substring(0,2);
tiannetMinute = strTime.substring(3,5);
}
// ---------------------- end 用户可调用的函数 -----------------------------//
//------------------ begin 页面显示部分 ---------------------------//
var weekName = new Array("日","一","二","三","四","五","六");
document.write('<div id="divTiannetDate" style="'+s_tiannet_body+'">');
document.write('<div align="center" id="divTiannetDateText" style="padding-top:2px;">');
document.write('<span id="tiannetYearHead" style="'+s_tiannet_font+'" '+
'onclick="spanYearCEvent();"> 年</span>');
document.write('<select id="selTianYear" style="'+s_tiannet_select+'" Author="tiannet" '+
' onChange="tiannetYear=this.value;tiannetSetDay(tiannetYear,tiannetMonth);document.all.tiannetYearHead.style.display=\'\';'+
'this.style.display=\'none\';">');
for(var i=tiannetYearSt;i <= tiannetYearEnd;i ++){
document.writeln('<option value="' + i + '">' + i + '年</option>');
}
document.write('</select>');
document.write('<span id="tiannetMonthHead" Author="tiannet" style="'+s_tiannet_font+'" '+
'onclick="spanMonthCEvent();">  月</span>');
document.write('<select id="selTianMonth" style="'+s_tiannet_select2+'" Author="tiannet" '+
'onChange="tiannetMonth=this.value;tiannetSetDay(tiannetYear,tiannetMonth);document.all.tiannetMonthHead.style.display=\'\';'+
'this.style.display=\'none\';">');
for(var i=1;i <= 12;i ++){
document.writeln('<option value="' + i + '">' + i + '月</option>');
}
document.write('</select>');
//document.write('</div>');
//document.write('<div align="center" id="divTiannetTimeText" Author="tiannet">');
document.write('<span id="tiannetHourHead" Author="tiannet" style="'+s_tiannet_font+'display:none;" '+
'onclick="spanHourCEvent();"> 时</span>');
document.write('<select id="selTianHour" style="'+s_tiannet_select2+'display:none;" Author="tiannet" '+
' onChange="tiannetHour=this.value;tiannetWriteHead();document.all.tiannetHourHead.style.display=\'\';' +
'this.style.display=\'none\';">');
for(var i=0;i <= 23;i ++){
document.writeln('<option value="' + i + '">' + i + '时</option>');
}
document.write('</select>');
document.write('<span id="tiannetMinuteHead" Author="tiannet" style="'+s_tiannet_font+'display:none;" '+
'onclick="spanMinuteCEvent();">  分</span>');
document.write('<select id="selTianMinute" style="'+s_tiannet_select2+'display:none;" Author="tiannet" '+
' onChange="tiannetMinute=this.value;tiannetWriteHead();document.all.tiannetMinuteHead.style.display=\'\';'+
'this.style.display=\'none\';">');
for(var i=0;i <= 59;i ++){
document.writeln('<option value="' + i + '">' + i + '分</option>');
}
document.write('</select>');
document.write('</div>');
document.write("<div id='dateselectid1'>");
//输出一条横线
document.write('<div style="'+s_tiannet_line+'"></div>');
document.write('<div align="center" id="divTiannetTurn" style="border:0;" Author="tiannet">');
document.write('<input type="button" style="'+s_tiannet_turn+'" value="年↑" title="上一年" onClick="tiannetPrevYear();">');
document.write('<input type="button" style="'+s_tiannet_turn+'" value="年↓" title="下一年" onClick="tiannetNextYear();"> ');
document.write('<input type="button" style="'+s_tiannet_turn+'" value="月↑" title="上一月" onClick="tiannetPrevMonth();">');
document.write('<input type="button" style="'+s_tiannet_turn+'" value="月↓" title="下一月" onClick="tiannetNextMonth();">');
document.write('</div>');
//输出一条横线
document.write('<div style="'+s_tiannet_line+'"></div>');
document.write('<table border=0 cellspacing=0 cellpadding=0 bgcolor=white onselectstart="return false">');
document.write(' <tr style="background-color:#2650A6;font-size:10pt;color:white;height:22px;" Author="tiannet">');
for(var i =0;i < weekName.length;i ++){
//输出星期
document.write('<td width="21" align="center" Author="tiannet">' + weekName[i] + '</td>');
}
document.write(' </tr>');
document.write('</table>');
document.write('</div>');
//输出天的选择
document.write('<table border=0 cellspacing=1 cellpadding=0 bgcolor=white onselectstart="return false">');

var n = 0;
for (var i=0;i<5;i++) { 
document.write (' <tr align=center id="trTiannetDay' + i + '" >');
for (var j=0;j<7;j++){
document.write('<td align="center" id="tdTiannetDay' + n + '" '+
'onClick="tiannetDay=this.innerText;tiannetSetValue(true);" ' 
+' style="' + s_tiannet_day + '"> </td>');
n ++;
}
document.write (' </tr>');

}

document.write (' <tr align=center id="trTiannetDay5" >');
document.write('<td align="center" id="tdTiannetDay35" onClick="tiannetDay=this.innerText;tiannetSetValue(true);" ' 
+' style="' + s_tiannet_day + '"> </td>');
document.write('<td align="center" id="tdTiannetDay36" onClick="tiannetDay=this.innerText;tiannetSetValue(true);" ' 
+' style="' + s_tiannet_day + '"> </td>');
document.write('<td align="right" colspan="5"><a href="javascript:tiannetClear();" style="' + s_tiannet_link + '">清空</a>'+
' <a href="javascript:tiannetHideControl();" style="' + s_tiannet_link + '">关闭</a>' +
' <a href="javascript:tiannetSetValue(true);" style="' + s_tiannet_link + '">确定</a> ' +
'</td>');
document.write (' </tr>');
document.write('</table>');
document.write('</div>');

//------------------ end 页面显示部分 ---------------------------//
//------------------ 显示日期时间的span标签响应事件 ---------------------------//
//单击年份span标签响应
function spanYearCEvent(){
hideElementsById(new Array("selTianYear","tiannetMonthHead"),false);
if(m_bolShowHour) hideElementsById(new Array("tiannetHourHead"),false);
if(m_bolShowMinute) hideElementsById(new Array("tiannetMinuteHead"),false);
hideElementsById(new Array("tiannetYearHead","selTianMonth","selTianHour","selTianMinute"),true);
}
//单击月份span标签响应
function spanMonthCEvent(){
hideElementsById(new Array("selTianMonth","tiannetYearHead"),false);
if(m_bolShowHour) hideElementsById(new Array("tiannetHourHead"),false);
if(m_bolShowMinute) hideElementsById(new Array("tiannetMinuteHead"),false);
hideElementsById(new Array("tiannetMonthHead","selTianYear","selTianHour","selTianMinute"),true);
}
//单击小时span标签响应
function spanHourCEvent(){
if(m_bolShowYMD){
	hideElementsById(new Array("selTianMonth","tiannetYearHead"),false);
}
else{
	hideElementsById(new Array("selTianMonth","tiannetYearHead"),true);
}
if(m_bolShowHour) hideElementsById(new Array("selTianHour"),false);
if(m_bolShowMinute) hideElementsById(new Array("tiannetMinuteHead"),false);
hideElementsById(new Array("tiannetHourHead","selTianYear","selTianMonth","selTianMinute"),true);
}
//单击分钟span标签响应
function spanMinuteCEvent(){
if(m_bolShowYMD){
	hideElementsById(new Array("selTianMonth","tiannetYearHead"),false);
}
else{
	hideElementsById(new Array("selTianMonth","tiannetYearHead"),true);
}
if(m_bolShowHour) hideElementsById(new Array("tiannetHourHead"),false);
if(m_bolShowMinute) hideElementsById(new Array("selTianMinute"),false);
hideElementsById(new Array("tiannetMinuteHead","selTianYear","selTianMonth","selTianHour"),true);
}
//根据标签id隐藏或显示标签
function hideElementsById(arrId,bolHide){
var strDisplay = "";
if(bolHide) strDisplay = "none";
for(var i = 0;i < arrId.length;i ++){
var obj = document.getElementById(arrId[i]);
obj.style.display = strDisplay;
}
}
//------------------ end 显示日期时间的span标签响应事件 ---------------------------//
//判断某年是否为闰年
function isPinYear(year){
var bolRet = false;
if (0==year%4&&((year%100!=0)||(year%400==0))) {
bolRet = true;
}
return bolRet;
}
//得到一个月的天数，闰年为29天
function getMonthCount(year,month){
var c=m_aMonHead[month-1];
if((month==2)&&isPinYear(year)) c++;
return c;
}
//重新设置当前的日。主要是防止在翻年、翻月时，当前日大于当月的最大日
function setRealDayCount() {
if( tiannetDay > getMonthCount(tiannetYear,tiannetMonth) ) {
//如果当前的日大于当月的最大日，则取当月最大日
tiannetDay = getMonthCount(tiannetYear,tiannetMonth);
}
}
//在个位数前加零
function addZero(value){
if(value < 10 ){
value = "0" + value;
}
return value;
}
//取出空格
function tiannetTrim(str) {
return str.replace(/(^\s*)|(\s*$)/g,"");
}
//为select创建一个option
function createOption(objSelect,value,text){
var option = document.createElement("OPTION");
option.value = value;
option.text = text;
objSelect.options.add(option);
}
//往前翻 Year
function tiannetPrevYear() {
if(tiannetYear > 999 && tiannetYear <10000){tiannetYear--;}
else{alert("年份超出范围（1000-9999）！");}
tiannetSetDay(tiannetYear,tiannetMonth);
//如果年份小于允许的最小年份，则创建对应的option
if( tiannetYear < tiannetYearSt ) {
tiannetYearSt = tiannetYear;
createOption(document.all.selTianYear,tiannetYear,tiannetYear + "年");
}
checkSelect(document.all.selTianYear,tiannetYear);
tiannetWriteHead();
}
//往后翻 Year
function tiannetNextYear() {
if(tiannetYear > 999 && tiannetYear <10000){tiannetYear++;}
else{alert("年份超出范围（1000-9999）！");return;}
tiannetSetDay(tiannetYear,tiannetMonth);
//如果年份超过允许的最大年份，则创建对应的option
if( tiannetYear > tiannetYearEnd ) {
tiannetYearEnd = tiannetYear;
createOption(document.all.selTianYear,tiannetYear,tiannetYear + "年");
}
checkSelect(document.all.selTianYear,tiannetYear);
tiannetWriteHead();
}
//选择今天
function tiannetToday() {
tiannetYear = tiannetDateNow.getFullYear();
tiannetMonth = tiannetDateNow.getMonth()+1;
tiannetDay = tiannetDateNow.getDate();
tiannetSetValue(true);
//tiannetSetDay(tiannetYear,tiannetMonth);
//selectObject();
}
//往前翻月份
function tiannetPrevMonth() {
if(tiannetMonth>1){tiannetMonth--}else{tiannetYear--;tiannetMonth=12;}
tiannetSetDay(tiannetYear,tiannetMonth);
checkSelect(document.all.selTianMonth,tiannetMonth);
tiannetWriteHead();
}
//往后翻月份
function tiannetNextMonth() {
if(tiannetMonth==12){tiannetYear++;tiannetMonth=1}else{tiannetMonth++}
tiannetSetDay(tiannetYear,tiannetMonth);
checkSelect(document.all.selTianMonth,tiannetMonth);
tiannetWriteHead();
}
//向span标签中写入年、月、时、分等数据
function tiannetWriteHead(){
document.all.tiannetYearHead.innerText = tiannetYear + "年";
document.all.tiannetMonthHead.innerText = tiannetMonth + "月";
if( m_bolShowHour ) document.all.tiannetHourHead.innerText = " "+tiannetHour + "时";
if( m_bolShowMinute ) document.all.tiannetMinuteHead.innerText = tiannetMinute + "分";
tiannetSetValue(false);//给文本框赋值，但不隐藏本控件
}
//设置显示天
function tiannetSetDay(yy,mm) {

setRealDayCount();//设置当月真实的日
tiannetWriteHead();
var strDateFont1 = "", strDateFont2 = "" //处理日期显示的风格
for (var i = 0; i < 37; i++){tiannetArrDay[i]=""}; //将显示框的内容全部清空
var day1 = 1;
var firstday = new Date(yy,mm-1,1).getDay(); //某月第一天的星期几
for (var i = firstday; day1 < getMonthCount(yy,mm)+1; i++){
tiannetArrDay[i]=day1;day1++;
}
//如果用于显示日的最后一行的第一个单元格的值为空，则隐藏整行。
//if(tiannetArrDay[35] == ""){
// document.all.trTiannetDay5.style.display = "none";
//} else {
// document.all.trTiannetDay5.style.display = "";
//}
for (var i = 0; i < 37; i++){ 
var da = eval("document.all.tdTiannetDay"+i) //书写新的一个月的日期星期排列
if (tiannetArrDay[i]!="") { 
//判断是否为周末，如果是周末，则改为红色字体
if(i % 7 == 0 || (i+1) % 7 == 0){
strDateFont1 = "<font color=#f0000>"
strDateFont2 = "</font>"
} else {
strDateFont1 = "";
strDateFont2 = ""
}
da.innerHTML = strDateFont1 + tiannetArrDay[i] + strDateFont2;
//如果是当前选择的天，则改变颜色
if(tiannetArrDay[i] == tiannetDay ) {
da.style.backgroundColor = "#CCCCCC";
} else {
da.style.backgroundColor = "#EFEFEF";
}
da.style.cursor="hand"
} else {
da.innerHTML="";da.style.backgroundColor="";da.style.cursor="default"
}
}//end for
tiannetSetValue(false);//给文本框赋值，但不隐藏本控件
}//end function tiannetSetDay
//根据option的值选中option
function checkSelect(objSelect,selectValue) {
var count = parseInt(objSelect.length);
if( selectValue < 10 && selectValue.toString().length == 2) {
selectValue = selectValue.substring(1,2);
}
for(var i = 0;i < count;i ++){
if(objSelect.options[i].value == selectValue){
objSelect.selectedIndex = i;
break;
}
}//for
}
//选中年、月、时、分等下拉框
function selectObject(){
//如果年份小于允许的最小年份，则创建对应的option
if( tiannetYear < tiannetYearSt ) {
for( var i = tiannetYear;i < tiannetYearSt;i ++ ){
createOption(document.all.selTianYear,i,i + "年");
}
tiannetYearSt = tiannetYear;
}
//如果年份超过允许的最大年份，则创建对应的option
if( tiannetYear > tiannetYearEnd ) {
for( var i = tiannetYearEnd+1;i <= tiannetYear;i ++ ){
createOption(document.all.selTianYear,i,i + "年");
}
tiannetYearEnd = tiannetYear;
}
checkSelect(document.all.selTianYear,tiannetYear);
checkSelect(document.all.selTianMonth,tiannetMonth);
if( m_bolShowHour ) checkSelect(document.all.selTianHour,tiannetHour);
if( m_bolShowMinute ) checkSelect(document.all.selTianMinute,tiannetMinute);
}
//给接受日期时间的控件赋值
//参数bolHideControl - 是否隐藏控件
function tiannetSetValue(bolHideControl){
var value = "";
if( !tiannetDay || tiannetDay == "" ){
tiannetOutObject.value = value;
return;
}

if(m_bolShowYMD){
var mm = tiannetMonth;
var day = tiannetDay;
if( mm < 10 && mm.toString().length == 1) mm = "0" + mm;
if( day < 10 && day.toString().length == 1) day = "0" + day;
value = tiannetYear + tiannetDateSplit + mm + tiannetDateSplit + day;
}
if( m_bolShowHour ){
var hour = tiannetHour;
if( hour < 10 && hour.toString().length == 1 ) hour = "0" + hour;
value += tiannetDateTimeSplit + hour;
}
if( m_bolShowMinute ){
var minute = tiannetMinute;
if( minute < 10 && minute.toString().length == 1 ) minute = "0" + minute;
value += tiannetTimeSplit + minute;
}
tiannetOutObject.value = value;
//document.all.divTiannetDate.style.display = "none";
if( bolHideControl ) {
tiannetHideControl();
}
}
//是否显示时间
function showTime(){
if( !m_bolShowHour && m_bolShowMinute){
alert("如果要选择分钟，则必须可以选择小时！");
return;
}
hideElementsById(new Array("tiannetHourHead","selTianHour","tiannetMinuteHead","selTianMinute"),true);
if( m_bolShowHour ){
//显示小时
hideElementsById(new Array("tiannetHourHead"),false);
}
if( m_bolShowMinute ){
//显示分钟
hideElementsById(new Array("tiannetMinuteHead"),false);
}
}
//弹出显示日历选择控件，以让用户选择
function tiannetPopCalendar(){
//隐藏下拉框，显示相对应的head
hideElementsById(new Array("selTianYear","selTianMonth","selTianHour","selTianMinute"),true);
hideElementsById(new Array("tiannetYearHead","tiannetMonthHead","tiannetHourHead","tiannetMinuteHead"),false);
tiannetSetDay(tiannetYear,tiannetMonth);

tiannetWriteHead();
showTime();
var dads = document.all.divTiannetDate.style;
var iX, iY;

var h = 187; //document.all.divTiannetDate.offsetHeight;
var w = 150; //document.all.divTiannetDate.offsetWidth;
//计算left
if (window.event.x + w > document.body.clientWidth - 10 )
iX = window.event.x - w - 5 ;
else
iX = window.event.x + 5; 
if (iX <0) 
iX=0;
//计算top
iY = window.event.y;
if (window.event.y + h > document.body.clientHeight - 10 )
iY = document.body.scrollTop + document.body.clientHeight - h - 5 ;
else
iY = document.body.scrollTop +window.event.y + 5; 
if (iY <0) 
iY=0;
dads.left = iX;
dads.top = iY;
tiannetShowControl();
selectObject();
if(!m_bolShowYMD){
	hideElementsById(new Array('dateselectid1','trTiannetDay0','trTiannetDay1','trTiannetDay2','trTiannetDay3','trTiannetDay4',"tiannetYearHead","tiannetMonthHead"), true);
}else{
	hideElementsById(new Array('dateselectid1','trTiannetDay0','trTiannetDay1','trTiannetDay2','trTiannetDay3','trTiannetDay4',"tiannetYearHead","tiannetMonthHead"), false);
	
}
}
//隐藏日历控件(同时显示被强制隐藏的标签)
function tiannetHideControl(){
document.all.divTiannetDate.style.display = "none";
tiannetShowObject();
arrTiannetHide = new Array();//将被隐藏的标签对象清空
}
//显示日历控件(同时隐藏会遮挡的标签)
function tiannetShowControl(){
document.all.divTiannetDate.style.display = "";
tiannetHideObject("Select");
tiannetHideObject("OBJECT");
}
//根据标签名称隐藏标签。如会遮住控件的select，object
function tiannetHideObject(strTagName) {

x = document.all.divTiannetDate.offsetLeft;
y = document.all.divTiannetDate.offsetTop;
h = document.all.divTiannetDate.offsetHeight;
w = document.all.divTiannetDate.offsetWidth;

for (var i = 0; i < document.getElementsByTagName(strTagName).length/*document.all.tags(strTagName).length*/; i++)
{

var obj = document.getElementsByTagName(strTagName)[i];
if (! obj || ! obj.offsetParent)
continue;
// 获取元素对于BODY标记的相对坐标
var objLeft = obj.offsetLeft;
var objTop = obj.offsetTop;
var objHeight = obj.offsetHeight;
var objWidth = obj.offsetWidth;
var objParent = obj.offsetParent;

while (objParent.tagName.toUpperCase() != "BODY"){
objLeft += objParent.offsetLeft;
objTop += objParent.offsetTop;
objParent = objParent.offsetParent;
}
//alert("控件左端:" + x + "select左端" + (objLeft + objWidth) + "控件底部:" + (y+h) + "select高:" + objTop);

var bolHide = true;
if( obj.style.display == "none" || obj.style.visibility == "hidden" || obj.getAttribute("Author") == "tiannet" ){
//如果标签本身就是隐藏的，则不需要再隐藏。如果是控件中的下拉框，也不用隐藏。
bolHide = false;
}
if( ( (objLeft + objWidth) > x && (y + h + 20) > objTop && (objTop+objHeight) > y && objLeft < (x+w) ) && bolHide ){
//arrTiannetHide.push(obj);//记录被隐藏的标签对象
arrTiannetHide[arrTiannetHide.length] = obj;
obj.style.visibility = "hidden";
}


}
}
//显示被隐藏的标签
function tiannetShowObject(){
for(var i = 0;i < arrTiannetHide.length;i ++){
//alert(arrTiannetHide[i]);
arrTiannetHide[i].style.visibility = "";
}
}
//初始化日期。
function tiannetInitDate(strDate){
var arr = strDate.split(tiannetDateSplit);
tiannetYear = arr[0];
tiannetMonth = arr[1];
tiannetDay = arr[2];
}
//清空
function tiannetClear(){
tiannetOutObject.value = "";
tiannetHideControl();
}
//任意点击时关闭该控件
document.onclick=function (){ 
with(window.event.srcElement){ 
if (tagName != "INPUT" && getAttribute("Author") != "tiannet")
tiannetHideControl();
}
}
//按ESC键关闭该控件
document.onkeypress=function (){
if( event.keyCode == 27 ){
tiannetHideControl();
}
}