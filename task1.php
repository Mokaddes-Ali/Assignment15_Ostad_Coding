<?php
class UnionFind {
    private $parent = [];
    private $rank = [];

    public function __construct($size) {
        for ($i = 1; $i <= $size; $i++) {
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

        if ($xRoot == $yRoot) return false;

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

function solvePowerGrid() {
    $input = file('php://stdin');
    $firstLine = explode(' ', trim($input[0]));
    $n = (int)$firstLine[0];
    $m = (int)$firstLine[1];
    
    $edges = [];
    
    for ($i = 1; $i <= $m; $i++) {
        $line = explode(' ', trim($input[$i]));
        $u = (int)$line[0];
        $v = (int)$line[1];
        $w = (int)$line[2];
        $edges[] = ['u' => $u, 'v' => $v, 'w' => $w];
    }
    
    usort($edges, function($a, $b) {
        return $a['w'] - $b['w'];
    });
    
    $uf = new UnionFind($n);
    $totalCost = 0;
    $edgesUsed = 0;
    
    foreach ($edges as $edge) {
        if ($uf->union($edge['u'], $edge['v'])) {
            $totalCost += $edge['w'];
            $edgesUsed++;
            if ($edgesUsed == $n - 1) break;
        }
    }
    
    echo ($edgesUsed == $n - 1) ? $totalCost . "\n" : "-1\n";
}

solvePowerGrid();
?>