<?php
/**
 * receive a URL, echo short URL
 */
include 'application/init.php';

$url = isset($_GET['url']) ? $_GET['url'] : (isset($_POST['url']) ? $_POST['url'] : '');
$url = urldecode(trim($url));
if ('' == $url) render_json(array('status' => 0, 'message' => 'Error: URL is null.'));
if (!preg_match("/^http(s)?:\/\//", $url)) render_json(array('status' => 0, 'message' => 'Error: Invalidate URL.'));

$hex = hex_url($url);
$table_suffix = substr($hex, 0, 1);
$table_name = strtolower('urls_' . $table_suffix);

$link = E_PDO::singleton();
$pdo = $link->db();

//====== create table
$stm = $pdo->prepare("SHOW TABLES LIKE ?");
$stm->execute(array($table_name));
$res = $stm->fetchAll();
if (empty($res)) {
    $auto_inc = rand(72, 10000);
    $sql = <<<EOD
CREATE TABLE `{$table_name}` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hex` char(16) NOT NULL,
  `url` varchar(500) NOT NULL,
  `num` int(11) unsigned DEFAULT '0',
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `hex` (`hex`)
) ENGINE=MyISAM AUTO_INCREMENT={$auto_inc} CHARSET=utf8;
EOD;
    $pdo->exec($sql);
}
//====== END

//====== insert or update
$id = 0;
$stm = $pdo->prepare("SELECT id, url FROM {$table_name} WHERE `hex` = ?");
if ($stm->execute(array($hex))) {
    while ($row = $stm->fetch(PDO::FETCH_LAZY)) {
        if ($row['url'] == $url) {
            $id = $row['id'];
            break;
        }
    }
}

if (0 == $id) {
    $stm = $pdo->prepare("INSERT INTO {$table_name} SET hex=:hex, url=:url, updated_at=:updated_at, num=:num");
    if ($stm->execute(array('hex' => $hex, 'url' => $url, 'updated_at' => time(), 'num' => 0))) {
        $id = $pdo->lastInsertId();
    }
}
if ($id > 0) {
    render_json(array('status' => 1, 'url' => $url, 'short_url' => config('host') . '/' . $table_suffix . dec2Any($id, 62)));
} else {
    render_json(array('status' => 0, 'url' => $url, 'message' => 'Error: Something error'));
}