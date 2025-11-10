    <?php
//    require 'vendor/autoload.php';
//    use Inn\App;

    spl_autoload_register(function ($class_name) {
        $class_path = __DIR__ . "/" . str_replace('\\', '/',$class_name) . '.php';
        include $class_path;
    }); 

    $test_object = new src\Test();


    $connection_string = 'pgsql:host=db;port=5432;dbname=database';
    $user = 'user';
    $password = 'pasw';

    try {
        $pdo = new PDO($connection_string, $user, $password);
//        echo 'Succeeded<br>';
    } catch (PDOException $e) {
        echo 'Failed: ' . $e->getMessage() . '.<br>';
    }

    require_once "Scraper/Scraper.php";