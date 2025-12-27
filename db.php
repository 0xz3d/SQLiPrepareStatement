<?php
$host = '127.0.0.1';
$db   = 'school_db';
$user = 'root'; 
$pass = ''; 

$dsn = "mysql:host=$host;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => true, 
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    $pdo->exec("USE $db");


    $pdo->exec("CREATE TABLE IF NOT EXISTS exam_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(100),
        score INT,
        subject VARCHAR(50),
        class_id VARCHAR(20)
    )");
    $check = $pdo->query("SELECT COUNT(*) FROM exam_results")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO exam_results (student_name, score, subject, class_id) VALUES 
            ('John Doe', 85, 'Mathematics', 'CLASS_101'),
            ('Jane Doe', 92, 'Mathematics', 'CLASS_101')");
    }

} catch (\PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
