<html>
<head>
    <style>
        body {
            font: 12px verdana;
            font-weight: bold;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .indent {
            margin-left: 20px;
        }
    </style>
</head>
<body>

<?php

abstract class Task {
    protected $title;
    protected $date;
    protected $dueDate;
    protected $description;
    protected $assignedTo;

    public function __construct($title, $date, $dueDate, $description, $assignedTo) {
        $this->title = $title;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->description = $description;
        $this->assignedTo = $assignedTo;
    }

    abstract public function getDescription();
}

class IndividualTask extends Task {
    public function getDescription() {
        echo "Individual Task: " . $this->title . "<br>";
        echo "Date: " . $this->date . "<br>";
        echo "Due Date: " . $this->dueDate . "<br>";
        echo "Description: " . $this->description . "<br>";
        echo "Assigned To: " . $this->assignedTo . "<br>";
        echo "<br>";
    }
}

class Project extends Task {
    protected $budget;
    protected $workItems = array();

    public function __construct($title, $date, $dueDate, $description, $assignedTo, $budget) {
        parent::__construct($title, $date, $dueDate, $description, $assignedTo);
        $this->budget = $budget;
    }

    public function addWorkItem($workItem) {
        array_push($this->workItems, $workItem);
    }

    public function getDescription() {
        echo "Project: " . $this->title . "<br>";
        echo "Date: " . $this->date . "<br>";
        echo "Due Date: " . $this->dueDate . "<br>";
        echo "Description: " . $this->description . "<br>";
        echo "Assigned To: " . $this->assignedTo . "<br>";
        echo "Budget: " . $this->budget . "<br>";
        echo "Work Items: <br>";
        foreach ($this->workItems as $workItem) {
            echo "&nbsp;&nbsp;&nbsp;";
            $workItem->getDescription();
        }
        echo "<br>";
    }
}

class TimeBasedTask extends Task {
    protected $estimatedHours;
    protected $hoursSpent;
    protected $childTasks = array();

    public function __construct($title, $date, $dueDate, $description, $assignedTo, $estimatedHours, $hoursSpent) {
        parent::__construct($title, $date, $dueDate, $description, $assignedTo);
        $this->estimatedHours = $estimatedHours;
        $this->hoursSpent = $hoursSpent;
    }

    public function addChildTask($childTask) {
        array_push($this->childTasks, $childTask);
    }

    public function getDescription() {
        echo "Time-Based Task: " . $this->title . "<br>";
        echo "Date: " . $this->date . "<br>";
        echo "Due Date: " . $this->dueDate . "<br>";
        echo "Description: " . $this->description . "<br>";
        echo "Assigned To: " . $this->assignedTo . "<br>";
        echo "Estimated Hours: " . $this->estimatedHours . "<br>";
        echo "Hours Spent: " . $this->hoursSpent . "<br>";
        echo "Child Tasks: <br>";
        foreach ($this->childTasks as $childTask) {
            echo "&nbsp;&nbsp;&nbsp;";
            $childTask->getDescription();
        }
        echo "<br>";
    }
}

class FixedBudgetTask extends Task {
    protected $budget;
    protected $childTask;

    public function __construct($title, $date, $dueDate, $description, $assignedTo, $budget) {
        parent::__construct($title, $date, $dueDate, $description, $assignedTo);
        $this->budget = $budget;
    }

    public function setChildTask($childTask) {
        $this->childTask = $childTask;
    }

    public function getDescription() {
        echo "Fixed Budget Task: " . $this->title . "<br>";
        echo "Date: " . $this->date . "<br>";
        echo "Due Date: " . $this->dueDate . "<br>";
        echo "Description: " . $this->description . "<br>";
        echo "Assigned To: " . $this->assignedTo . "<br>";
        echo "Budget: " . $this->budget . "<br>";
        if ($this->childTask) {
            echo "Child Task: <br>";
            echo "&nbsp;&nbsp;&nbsp;";
            $this->childTask->getDescription();
        }
        echo "<br>";
    }
}

// Example usage
$project = new Project("Software Project", "2024-01-11", "2024-02-28", "Develop a new software", "John Doe", 10000);
$project->addWorkItem(new IndividualTask("Design UI", "2024-01-15", "2024-01-20", "Create UI wireframes", "Jane Doe"));
$project->addWorkItem(new IndividualTask("Coding", "2024-01-21", "2024-02-10", "Write code", "Bob Smith"));

$timeBasedTask = new TimeBasedTask("Code Review", "2024-02-15", "2024-02-18", "Review code", "Alice Johnson", 10, 5);
$timeBasedTask->addChildTask(new IndividualTask("Fix Bugs", "2024-02-19", "2024-02-22", "Fix reported bugs", "Charlie Brown"));

$fixedBudgetTask = new FixedBudgetTask("Testing", "2024-02-25", "2024-03-05", "Test the application", "Eve Anderson", 5000);
$fixedBudgetTask->setChildTask(new IndividualTask("Write Test Cases", "2024-02-26", "2024-03-01", "Create test cases", "David Miller"));

$project->getDescription();
$timeBasedTask->getDescription();
$fixedBudgetTask->getDescription();

?>



</body>
</html>

