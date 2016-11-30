<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        <?php
            $submittedName = $_GET['name'];
            $submittedNumber = $_GET['number'];
            if (isset($submittedName) && isset($submittedNumber)) {
                try {
                    $iniData = parse_ini_file("data.ini.php");
                    $database = new PDO('mysql:host=localhost,dbname=test', $iniData[insecure][user], $iniData[insecure][pass]);
                } catch (PDOEXCEPTION $e) {
                    print($e->getMessage());
                    die();
                }
                $nameInsert = $database->prepare('INSERT INTO test (name,value) VALUES (:name,:value)');
                $nameInsert->bindParam(':name',$submittedName);
                $nameInsert->bindParam(':value',$submittedNumber);
                $nameInsert->execute();
                print("you submitted " + $submittedName + " and " + $submittedNumber + "!");
                $sql = 'SELECT name, value FROM test ORDER BY name';
                foreach ($database->query($sql) as $row) {
                    print $row['name'] . "\t";
                    print $row['value'] . "\n";
                }
            }
            else {
                ?>
                <form action="selfForm.php" method="get">
                    <input type="text" name="name" placeholder="a name" />
                    <input type="text" name="number" placeholder="a number" />
                    <input type="submit" value="submit" />
                </form>
                <?php
            }
         ?>
    </body>
</html>
