<?php
class UnionFind {
    private $parent = [];
    private $rank = [];
    
    public function __construct($size) {
        for ($i = 0; $i < $size; $i++) {
            $this->parent[$i] = $i;
            $this->rank[$i] = 0;
        }
    }
    
    public function find($x) {
        if ($this->parent[$x] != $x) {
            $this->parent[$x] = $this->find($this->parent[$x]);
        }
        return $this->parent[$x];
    }
    
    public function union($x, $y) {
        $xRoot = $this->find($x);
        $yRoot = $this->find($y);
        
        if ($xRoot == $yRoot) {
            return false;
        }
        
        if ($this->rank[$xRoot] < $this->rank[$yRoot]) {
            $this->parent[$xRoot] = $yRoot;
        } else {
            $this->parent[$yRoot] = $xRoot;
            if ($this->rank[$xRoot] == $this->rank[$yRoot]) {
                $this->rank[$xRoot]++;
            }
        }
        
        return true;
    }
}

function solveForestPowerGrid($n, $m, $edges) {
    if ($n == 0) return -1;
    
    usort($edges, function($a, $b) {
        return $a[2] - $b[2];
    });
    
    $uf = new UnionFind($n);
    $totalCost = 0;
    $edgesUsed = 0;
    
    foreach ($edges as $edge) {
        $u = $edge[0] - 1;
        $v = $edge[1] - 1;
        $w = $edge[2];
        
        if ($uf->find($u) != $uf->find($v)) {
            $uf->union($u, $v);
            $totalCost += $w;
            $edgesUsed++;
            if ($edgesUsed == $n - 1) {
                break;
            }
        }
    }
    
    return $edgesUsed == $n - 1 ? $totalCost : -1;
}

$input = "4 4\n1 2 5\n2 3 6\n3 4 2\n4 1 3";

$lines = explode("\n", trim($input));
[$n, $m] = array_map('intval', explode(' ', $lines[0]));
$edges = [];
for ($i = 1; $i <= $m; $i++) {
    $edges[] = array_map('intval', explode(' ', $lines[$i]));
}

echo solveForestPowerGrid($n, $m, $edges);
?>