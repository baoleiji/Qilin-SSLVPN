<?php
$db1_host = '172.16.210.21';
$db1_user = 'freesvr';
$db1_pwd = 'freesvr';
$db1_dbname = 'audit_sec';

$db2_host = 'localhost';
$db2_user = 'root';
$db2_pwd = '';
$db2_dbname = 'ss';

$link = mysql_connect($db1_host, $db1_user, $db1_pwd);
mysql_select_db($db1_dbname, $link);
$result = mysql_query("SHOW TABLES FROM ".$db1_dbname);

if (!$result) {
	print "DB Error, could not list tables\n";
	print 'MySQL Error: ' . mysql_error();
	exit;
}

$i=0;
while ($row = mysql_fetch_row($result)) {
	$db1_tablesname[$row[0]] = $i;
	$db1_tables[$i]['name'] = $row[0];
	$column_res = mysql_query("SHOW COLUMNS FROM ".$row[0]);
	unset($column);
	while($column_row = mysql_fetch_array($column_res,MYSQL_ASSOC)){
		$column[$column_row['Field']] = $column_row;
	}
	$db1_tables[$i]['field'] = $column;

	$keys_res = mysql_query("SHOW keys FROM ".$row[0]);
	unset($keys);
	while($keys_row = mysql_fetch_array($keys_res,MYSQL_ASSOC)){
		$keys[$keys_row['Key_name']][] = $keys_row['Column_name'];
	}
	$db1_tables[$i]['key'] = $keys;

	$i++;
}

$link2 = mysql_connect($db2_host, $db2_user, $db2_pwd);
mysql_select_db($db2_dbname, $link2);
$result2 = mysql_query("SHOW TABLES FROM ".$db2_dbname, $link2);

if (!$result2) {
	print "DB Error, could not list tables\n";
	print 'MySQL Error: ' . mysql_error();
	exit;
}

$i=0;
while ($row = mysql_fetch_row($result2)) {
	$db2_tablesname[$row[0]] = $i;
	$db2_tables[$i]['name'] = $row[0];
	$column_res = mysql_query("SHOW COLUMNS FROM ".$row[0], $link2);
	unset($column);
	while($column_row = mysql_fetch_row($column_res,MYSQL_ASSOC)){
		$column[$column_row['Field']] = $column_row;
	}
	$db2_tables[$i]['field'] = $column;
	$i++;
}

function ADD_PRI_UNI_MUL($key, $field, $table){
	switch($key){
		case 'PRI':
			return ","." ADD PRIMARY KEY(".$field.")";
			break;
		case 'UNI':
			return ","." ADD UNIQUE INDEX(".$field.")";
			break;
		case 'MUL':
//var_dump($table);
			return ","." ADD UNIQUE KEY(".implode(",", $table['key'][$field]).")";
			break;
		default:
			return " ";
			break;
	}
}


//echo '<pre>';print_r($db1_tables);echo '</pre>';
function compare_two_table($table1, $table2){
	$alert_sql = "";
	//print_r($table1);print_r($table2);
	//echo '<pre>';print_r($table2);echo '</pre>';
	foreach($table1['field'] AS $key => $field){
		if(empty($table2[$field['Field']])){
			$alter_sql .= " ADD COLUMN `".$field['Field']."` ".$field['Type']." ".($field['Null']=='NO' ? 'NOT NULL' : 'NULL')." ".(($field['Default']=='') ? '' : 'DEFAULT '.$field['Default'])." ".$field["Extra"]." ".ADD_PRI_UNI_MUL($field['Key'], $field['Field'], $table1)/*($field['Key']=='PRI' ? 'PRIMARY KEY' : ' ADD  INDEX('.$field['Field'].')')*/.",";
		}else if($field['Type']!=$table2[$field['Field']]['Type'] || $field['Null']!=$table2[$field['Field']]['Null'] || $field['Key']!=$table2[$field['Field']]['Key'] || $field['Default']!=$table2[$field['Field']]['Default'] || $field['Extra']!=$table2[$field['Field']]['Extra']){
			$alter_sql .= " Modify COLUMN `".$field['Field']."` ".$field['Type']." ".($field['Null']=='NO' ? 'NOT NULL' : 'NULL')." ".(($field['Default']=='') ? '' : 'DEFAULT '.$field['Default'])." ".$field["Extra"]." ".ADD_PRI_UNI_MUL($field['Key'], $field['Field'], $table1)/*($field['Key']=='PRI' ? 'PRIMARY KEY' : ' ADD INDEX('.$field['Field'].')')*/.",";
		}
	}
	return substr($alter_sql,0,strlen($alter_sql)-1);
}


$link = mysql_connect($db1_host, $db1_user, $db1_pwd);
mysql_select_db($db1_dbname, $link);

$sql = "";
for($i=0; $i<count($db1_tablesname); $i++){
	if(array_key_exists($db1_tables[$i]['name'], $db2_tablesname)){
		$modstr = compare_two_table($db1_tables[$i], $db2_tables[$db2_tablesname[$db1_tables[$i]['name']]]['field']);
		if(!empty($modstr)){
			$diff[$db1_tables[$i]['name']] =	'ALTER TABLE '.$db1_tables[$i]['name'].' '.$modstr;
			$sql .= $diff[$db1_tables[$i]['name']].';';
		}
	}else{
		$rs = mysql_query("SHOW CREATE TABLE ".$db1_tables[$i]['name'], $link);
		$f = mysql_fetch_array($rs, MYSQL_ASSOC);
		$diff[$db1_tables[$i]['name']] = str_replace("\n","",$f['Create Table']);
		$sql .= $diff[$db1_tables[$i]['name']].';';
	}
}
if($diff)
foreach($diff AS $key => $value){
	echo $value.';<br /><br />';
	//mysql_query($value) or die(mysql_error());
}
else{
	echo $db1_dbname.' is the same as '.$db2_dbname;
}
//echo '<pre>';print_r($diff);echo '</pre>';
?>
