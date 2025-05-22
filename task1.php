<?php
function solveDoomsdayEscape($n, $m, $grid) {
    $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]];
    $visited = array_fill(0, $n, array_fill(0, $m, false));
    $queue = new SplPriorityQueue();
    $queue->insert([0, 0, 0], PHP_INT_MAX);
    
    while (!$queue->isEmpty()) {
        $current = $queue->extract();
        $time = $current[0];
        $i = $current[1];
        $j = $current[2];
        
        if ($i == $n - 1 && $j == $m - 1) {
            return "YES";
        }
        
        if ($visited[$i][$j]) {
            continue;
        }
        $visited[$i][$j] = true;
        
        foreach ($directions as $dir) {
            $ni = $i + $dir[0];
            $nj = $j + $dir[1];
            
            if ($ni >= 0 && $ni < $n && $nj >= 0 && $nj < $m && !$visited[$ni][$nj]) {
                $newTime = $time + 1;
                if ($newTime < $grid[$ni][$nj]) {
                    $priority = ($n - 1 - $ni) + ($m - 1 - $nj);
                    $queue->insert([$newTime, $ni, $nj], $priority);
                }
            }
        }
    }
    
    return "NO";
}

$input = "3 3\n2 3 4\n3 4 5\n4 5 6";

$lines = explode("\n", trim($input));
[$n, $m] = array_map('intval', explode(' ', $lines[0]));
$grid = [];
for ($i = 1; $i <= $n; $i++) {
    $grid[] = array_map('intval', explode(' ', $lines[$i]));
}

echo solveDoomsdayEscape($n, $m, $grid);
?>