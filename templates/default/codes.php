<pre><?php

$group = 5;
$count = $group;
foreach ($codes as $code) {
    if ($count == 0) {
        echo "\n";
        $count = $group;
    }
    echo "$code->code\n";
    $count--;
}
?></pre>