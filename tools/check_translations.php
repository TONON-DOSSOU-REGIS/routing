<?php
$base = __DIR__ . '/../lang';
$baseLocale = 'fr';
$locales = array_filter(scandir($base), function ($d) use ($base) {
    return $d[0] !== '.' && is_dir($base . '/' . $d);
});

function flat(array $arr, $prefix = '') {
    $out = [];
    foreach ($arr as $k => $v) {
        $key = $prefix === '' ? $k : $prefix . '.' . $k;
        if (is_array($v)) {
            $out = array_merge($out, flat($v, $key));
        } else {
            $out[$key] = $v;
        }
    }
    return $out;
}

$fr = [];
foreach (glob($base . '/' . $baseLocale . '/*.php') as $file) {
    $name = basename($file, '.php');
    $data = include $file;
    if (is_array($data)) {
        $fr[$name] = flat($data);
    }
}

$report = [];
foreach ($locales as $loc) {
    if ($loc === $baseLocale) continue;
    foreach (glob($base . '/' . $loc . '/*.php') as $file) {
        $name = basename($file, '.php');
        $data = include $file;
        if (!is_array($data)) continue;
        $flat = flat($data);
        foreach ($flat as $k => $v) {
            if (isset($fr[$name][$k]) && $fr[$name][$k] === $v) {
                $report[] = $loc . '/' . $name . '.php:' . $k;
            }
        }
    }
}

foreach ($report as $line) {
    echo $line, PHP_EOL;
}
?>
