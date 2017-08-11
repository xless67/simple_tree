<?php

class Branch
{
    protected $next_left_branch = null;
    protected $next_right_branch = null;
    protected $leaves = null;

    public function __construct($next_left_branch = null, $next_right_branch = null, $leaves = null) {
        $this->next_left_branch = $next_left_branch;
        $this->next_right_branch = $next_right_branch;
        $this->leaves = $leaves;
    }

    public function getLeftBranch() {
        return $this->next_left_branch;
    }

    public function getRightBranch() {
        return $this->next_right_branch;
    }

    public function getLeaves() {
        return $this->leaves;
    }

    public function setLeftBranch($next_left_branch) {
        $this->next_left_branch = $next_left_branch;
    }

    public function setRightBranch($next_right_branch) {
        $this->next_right_branch = $next_right_branch;
    }

    public function setLeaves($leaves) {
        $this->leaves = $leaves;
    }
}
