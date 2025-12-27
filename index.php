<?php
require 'db.php';


$orderExists = isset($_GET['order']) && !empty($_GET['order']);
$classExists = isset($_GET['class_id']) && !empty($_GET['class_id']);

try {
    if (!$orderExists && !$classExists) {
        echo "<h1>Welcome to Grade Monitor System</h1>";
        echo "<p>If you want to get some data, please specify 'order' and 'class_id' in the URL.</p>";
        $results = []; 
    } 
    else {
        
        $orderBy = $_GET['order'];
        $classIdInput = $_GET['class_id'];
        $selectedCol = "`" . str_replace("`", "", $orderBy) . "`";

        $sql = "SELECT $selectedCol FROM exam_results WHERE class_id = ? ORDER BY student_name ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$classIdInput]);
        $results = $stmt->fetchAll();
        
        $message = "<h2>Results for Class: " . htmlspecialchars($classIdInput) . "</h2>";
    }
    
} catch (Exception $e) {
    echo "<h3>SQL Debug Output:</h3><pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    $results = [];
}
?>

<!DOCTYPE html>
<html>
<head><title>Teacher Portal - Grades</title></head>
<body>
    <h1>Class Grade Viewer</h1>
    
    <table border="1">
        <thead>
            <tr>
                <?php if (!empty($results)): ?>
                    <?php foreach (array_keys($results[0]) as $header): ?>
                        <th><?php echo htmlspecialchars($header); ?></th>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <?php foreach ($row as $val): ?>
                        <td><?php echo htmlspecialchars($val); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>