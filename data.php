<?php
$con = mysql_connect("localhost","root","1991462");

if (!$con) {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("sackdenim", $con);

$sth = mysql_query("SELECT nyata FROM rekap_penjualan ORDER BY bulan DESC LIMIT 12");
$rows = array();
$rows['name'] = 'Realita';
while($r = mysql_fetch_array($sth)) {
    $rows['data'][] = $r['nyata'];
}

$sth = mysql_query("SELECT moving FROM rekap_penjualan ORDER BY bulan DESC LIMIT 12");
$rows1 = array();
$rows1['name'] = 'Moving';
while($rr = mysql_fetch_assoc($sth)) {
    $rows1['data'][] = $rr['moving'];
}

$result = array();
array_push($result,$rows);
array_push($result,$rows1);

print json_encode($result, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
