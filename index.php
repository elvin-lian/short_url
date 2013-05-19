<?php
include 'application/init.php';

$url = config('redirect_url');

$short_url = null;
if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/') {
    $request = $_SERVER['PATH_INFO'];
}elseif(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
    $request = $_SERVER['REQUEST_URI'];
}else{
    $request = '';
}
$_tmp = explode('/', $request);
if (isset($_tmp[1])) $short_url = $_tmp[1];

if (empty($short_url)) {
    header('Location: ' . $url);
    exit();
}

$table_suffix = substr($short_url, 0, 1);
if (!preg_match("/[0-9A-Za-z]/", $table_suffix)) {
    header('Location: ' . $url);
    exit();
}

$table_name = strtolower('urls_' . $table_suffix);
$id = 0;
$id_str = substr($short_url, 1);
if (!empty($id_str)) $id = any2Dec($id_str, 62);

if ($id > 0) {
    $link = E_PDO::singleton();
    $pdo = $link->db();
    $stm = $pdo->prepare('SELECT id,url FROM ' . $table_name . ' WHERE id = ? LIMIT 1');
    if ($stm->execute(array($id)) && $row = $stm->fetch()) {
        $url = $row['url'];
        $id = $row['id'];
        $pdo->exec("UPDATE {$table_name} SET `num`=`num`+1, `updated_at` = " . time() . " WHERE id = {$id} LIMIT 1");
    }
}

header('Location: ' . $url);