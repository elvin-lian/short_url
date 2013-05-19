<?php
/**
 * 返回一字符串，十进制 number 以 radix 进制的表示。
 * @param dec       需要转换的数字
 * @param toRadix    输出进制。当不在转换范围内时，此参数会被设定为 2，以便及时发现。
 * @return    指定输出进制的数字
 */
function dec2Any($dec, $toRadix)
{
    $MIN_RADIX = 2;
    $MAX_RADIX = 62;
    $num62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($toRadix < $MIN_RADIX || $toRadix > $MAX_RADIX) {
        $toRadix = 2;
    }
    if ($toRadix == 10) {
        return $dec;
    }
    // -Long.MIN_VALUE 转换为 2 进制时长度为65
    $buf = array();
    $charPos = 64;
    $isNegative = $dec < 0; //(bccomp($dec, 0) < 0);
    if (!$isNegative) {
        $dec = -$dec; // bcsub(0, $dec);
    }

    while (bccomp($dec, -$toRadix) <= 0) {
        $buf[$charPos--] = $num62[-bcmod($dec, $toRadix)];
        $dec = bcdiv($dec, $toRadix);
    }
    $buf[$charPos] = $num62[-$dec];
    if ($isNegative) {
        $buf[--$charPos] = '-';
    }
    $_any = '';
    for ($i = $charPos; $i < 65; $i++) {
        $_any .= $buf[$i];
    }
    return $_any;
}

/**
 * 返回一字符串，包含 number 以 10 进制的表示。<br />
 * fromBase 只能在 2 和 62 之间（包括 2 和 62）。
 * @param number    输入数字
 * @param fromRadix    输入进制
 * @return  十进制数字
 */
function any2Dec($number, $fromRadix)
{
    $num62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $dec = 0;
    $len = strlen($number) - 1;
    for ($t = 0; $t <= $len; $t++) {
        $digitValue = strpos($num62, $number[$t]);
        $dec = bcadd(bcmul($dec, $fromRadix), $digitValue);
    }
    return $dec;
}

function hex_url($url)
{
    $hex = md5('hbmy879x2ittlybx8oua8g6zbkpmnugv' . $url . 'rxouxzkhzyhsdxpd');
    return substr($hex, 8, 16);
}

function config($name)
{
    return E_Config::singleton()->get($name);
}

function render_json($arr, $content_type = 'application/json; charset=UTF-8')
{
    header('Content-type: ' . $content_type);
    header("expires:mon,26jul199705:00:00gmt");
    header("cache-control:no-cache,must-revalidate");
    header("pragma:no-cache");
    echo json_encode($arr);
    exit;
}