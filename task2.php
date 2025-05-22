<?php
function solveDoomsdayEscape() {
    $input = file('php://stdin');
    $firstLine = explode(' ', trim($input[0]));
    $n = (int)$firstLine[0];
    $m = (int)$firstLine[1];
    
    $grid = [];
    $visited = array_fill(0, $n, array_fill(0, $m, false));
    $queue = new SplQueue();
    
    for ($i = 0; $i < $n; $i++) {
        $grid[$i] = array_map('intval', explode(' ', trim($input[$i + 1])));
    }
    
    // Check starting cell
    if ($grid[0][0] == 0) {
        echo "NO\n";
        return;
    }
    
    $queue->enqueue([0, 0, 0]);
    $visited[0][0] = true;
    
    $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]];
    $found = false;
    
    while (!$queue->isEmpty()) {
        [$x, $y, $time] = $queue->dequeue();
        
        if ($x == $n - 1 && $y == $m - 1) {
            $found = true;
            break;
        }
        
        foreach ($directions as $dir) {
            $nx = $x + $dir[0];
            $ny = $y + $dir[1];
            
            if ($nx >= 0 && $nx < $n && $ny >= 0 && $ny < $m && !$visited[$nx][$ny]) {
                $newTime = $time + 1;
                if ($newTime < $grid[$nx][$ny]) {
                    $visited[$nx][$ny] = true;
                    $queue->enqueue([$nx, $ny, $newTime]);
                }
            }
        }
    }
    
    echo $found ? "YES\n" : "NO\n";
}

solveDoomsdayEscape();
?>