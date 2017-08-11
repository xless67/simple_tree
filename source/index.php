<?php

require_once (__DIR__ . '/classes/tree.php');
require_once (__DIR__ . '/classes/leaf.php');
//require_once (__DIR__ . '/classes/branch.php');
//require_once (__DIR__ . '/classes/leaf.php');

$tree = new Tree();
$tree->setBranches(3);                  // количество веток(узлов)
$tree->setLeavesWeightPerBranch(3);     // максимальный вес листьев для веток (константа W)

$leaves = [                             // создаем листья с весом
    new Leaf(2),
    new Leaf(4),
    new Leaf(3),
    new Leaf(1),
];

$tree->setLeaves($leaves);
$tree->showTree();