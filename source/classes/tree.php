<?php
require_once (__DIR__ . '/branch.php');
require_once (__DIR__ . '/leaf.php');

class Tree
{
    protected $stem_branch = null;
    protected $max_leaves_weight = null;
    protected $total_branches = null;

    public function __construct($branches_amount = 0, $max_leaves_weight = 0) {
        $this->stem_branch = new Branch();
        $this->setLeavesWeightPerBranch($max_leaves_weight);
        $this->setBranches($branches_amount);
    }

    public function setLeavesWeightPerBranch($max_leaves_weight) {
        $this->max_leaves_weight = $max_leaves_weight;
    }

    public function setBranches($branches_amount = 0) {
        $i = 0;
        while ($i < $branches_amount) {
            $this->setNextBranch($this->stem_branch);
            $i++;
        }
        $this->total_branches = $branches_amount;
    }

    public function setLeaves($leaves, $branch = null) {
        $leaves = $this->sortLeaves($leaves);

        $tmp_leaves = array();
        $tmp_weight = 0;
        for ($i = 0; $i < sizeof($leaves); $i++) {
        	$tmp_leaves[] = $leaves[$i];
        	$tmp_weight += $leaves[$i]->getWeight();
	        
        	if (
        		($leaves[$i + 1] !== null && $tmp_weight + $leaves[$i]->getWeight() >= $this->max_leaves_weight) ||
		        ($leaves[$i + 1] === null && $leaves[$i]->getWeight() <= $this->max_leaves_weight)
	        ) {
		        $this->getNextBranchWithoutLeaves()->setLeaves($tmp_leaves);
                $tmp_leaves = [];
                $tmp_weight = 0;
        		var_dump('here');
	        }
        	
        	
        	
	        /*
            if ($tmp_weight + $leaves[$i]->getWeight() >= $this->max_leaves_weight) {
                $this->getNextEmptyBranch()->setLeaves($tmp_leaves);
                var_dump('here<br/>');
                $tmp_leaves = [];
                $tmp_weight = 0;
            }
            $tmp_leaves[] = $leaves[$i];
            $tmp_weight += $leaves[$i]->getWeight();
*/
	        /*
            var_dump($tmp_leaves);
            echo '<br/>';
            var_dump('tmp_weight:'.$tmp_weight);
            echo '<br/>';
            var_dump('new weight: '.$tmp_weight + $leaves[$i]->getWeight() .'; max-weight: '. $this->max_leaves_weight);
            echo '<br/><br/>';
*/

//            if ($tmp_weight < $this->max_leaves_weight) {
//                $tmp_leaves[] = $leaves[$i];
//                $tmp_weight += $leaves[$i]->getWeight();
//            }
//            else {
//                $this->getNextEmptyBranch()->setLeaves($tmp_leaves);
//                $tmp_leaves = [];
//                $tmp_weight = 0;
//            }
        }
    }

    private function setNextBranch($branch) {
        /** @var $branch Branch */
        if ($branch->getLeftBranch() === null) {
            $branch->setLeftBranch(new Branch());
            return;
        }
        elseif ($branch->getRightBranch() === null) {
            $branch->setRightBranch(new Branch());
            return;
        }
        else
            $this->setNextBranch($branch->getLeftBranch()); //можно додумать, как раскидывать ветки поровну на лево и право, но это в следующей версии ))
    }
	
	public function listAllAvailableBranches($branch = null, $iteration = 0) {
		/** @var $current_branch Branch */
		$current_branch = $branch === null ? $this->stem_branch : $branch;
		if ($current_branch->getRightBranch() !== null)
			echo "Level $iteration: right branch<br />";
		if ($current_branch->getLeftBranch() !== null) {
			echo "Level $iteration: left branch<br />";
			$this->listAllAvailableBranches($current_branch->getLeftBranch(), ++$iteration);
		}
	}

    private function sortLeaves($leaves_array) {
        $size = sizeof($leaves_array);
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size - 1 - $i; $j++) {
                if ($leaves_array[$j + 1]->getWeight() < $leaves_array[$j]->getWeight()) {
                    $tmp = $leaves_array[$j];
                    $leaves_array[$j] = $leaves_array[$j + 1];
                    $leaves_array[$j + 1] = $tmp;
                }
            }
        }
        return $leaves_array;
    }

    public function showLeaves($leaves) {
        foreach ($leaves as $key => $leaf) {
            /** @var $leaf Leaf */
            echo "Leaf $key weight " . $leaf->getWeight() . '<br />';
        }
    }

    public function getNextBranchWithoutLeaves($branch = null) {
        /** @var $current_branch Branch */
        $current_branch = $branch === null ? $this->stem_branch : $branch;
        if ($current_branch->getLeaves() === null)
            return $current_branch;
        elseif ($current_branch->getRightBranch() !== null && $current_branch->getRightBranch()->getLeaves() === null)
            return $current_branch->getRightBranch();
        elseif ($current_branch->getLeftBranch() !== null && $current_branch->getLeftBranch()->getLeaves() === null)
            return $current_branch->getLeftBranch();
        else
            return $this->getNextBranchWithoutLeaves($current_branch->getLeftBranch());
    }

    public function showTree($branch = null, $iteration = 0) {
        /** @var $current_branch Branch */
        $current_branch = $branch === null ? $this->stem_branch : $branch;
        echo "Level $iteration: has " . sizeof($current_branch->getLeaves()) . ' leaves<br />';
        
        if ($current_branch->getRightBranch() !== null) {
	        echo "Level $iteration: right branch<br />";
	        if ($current_branch->getRightBranch()->getLeaves() !== null)
		        echo "Level $iteration: has " . sizeof($current_branch->getRightBranch()->getLeaves()) . ' leaves<br />';
        }
        if ($current_branch->getLeftBranch() !== null) {
            echo "Level $iteration: left branch<br />";
            $this->showTree($current_branch->getLeftBranch(), ++$iteration);
        }
    }
}