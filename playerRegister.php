<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../../css/bootstrap.min.css" rel="stylesheet"/>
	<title>register pls</title>
	<style>
		.error {
			color:#ff0000;
		}
	</style>
  </head>
  <body>
	<div class="container">
        <div class="col-xs-12">
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            $first = $_GET['firstName'];
            if (isset($first)) {
                $last = $_GET['lastName'];
                $nameTag = $_GET['tag'];
                $main = $_GET['main'];
                $secondaryArray = $_GET['secondary'];
                foreach ($secondaryArray as $secondary) {
                    $secondaries .= $secondary . "\n";
                }
                try {
                    $iniData = parse_ini_file("data.ini.php", true);
                    $database = new PDO('mysql:host=127.0.0.1;dbname=playground16', $iniData['insecure']['user'], $iniData['insecure']['pass']);
                } catch (PDOEXCEPTION $e) {
                    print($e->getMessage());
                    die();
                }
                print("<p>attempting to insert: " . $first . " " . $last . ": " . $nameTag . " who mains " . $main . " and secondaries " . $secondaries . "</p>");
                $nameInsert = $database->prepare('INSERT INTO smash_player_data (first_name, last_name, tag, main, secondaries)
                    VALUES (:first, :last, :tag, :main, :secondaries)');
                $nameInsert->bindParam(':first',$first);
                $nameInsert->bindParam(':last',$last);
                $nameInsert->bindParam(':tag',$nameTag);
                $nameInsert->bindParam(':main',$main);
                $nameInsert->bindParam(':secondaries',$secondaries);
                $insertion = $nameInsert->execute();
                if ($insertion)
                    print("<p>inserted: " . $first . " " . $last . ": " . $nameTag . " who mains " . $main . " and secondaries " . $secondaries . "</p>");
            }
        ?>
        </div>
		<div class="col-lg-12 text-center">
			<h2 id="title">register in our smash database!</h2>
		</div>
		<div class="col-xs-12" style="height:30px;"></div>
		<form id="register-form" class="container-fluid" method="get" action="playerRegister.php">
			<div class="form-group col-md-6">
				<label for="firstName">what is your first name?</label>
				<input class="form-control required" type="text" id="firstName" name="firstName" placeholder="ordinary"/>
			</div>
			<div class="form-group col-md-6">
				<label for="lastName">what is your last name?</label>
				<input class="form-control required" type="text" id="lastName" name="lastName" placeholder="Joe"/>
			</div>
			<div class="form-group container-fluid">
				<label for="tag">what is your tag?</label>
				<input class="form-control required tag" type="text" id="tag" name="tag"/>
            </div>
            <div class="form-group container-fluid">
                <label for="main">main:</label>
				<input class="form-control required" type="text" id="main" name="main"></input>
			</div>
            <div class="form-group container-fluid" id="secondary">
                <label for="secondaries">secondary 1:</label>
				<input class="form-control" type="text" id="secondaries" name="secondary[]"></input>
                <input class="form-control" type="button" value="add another secondary" onClick="addInput('secondary');">
			</div>
            <div class="col-xs-12" style="height:10px;"></div>
			<div class="form-group container-fluid">
				<input class="form-control" type="submit" value="register!"></input>
			</div>
		</form>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/jquery.validate.min.js"></script>
    <script src="../../js/addinput.js"></script>
	<script>
	$(document).ready(function(){
		$.validator.addMethod("tag", function(value, element) {
			return this.optional(element) || /^[a-z,0-9,\.,\_]+$/i.test(value);
		}, "tag must contain only letters, periods, underscores, and numbers.");
		$("#register-form").validate({
			rules: {
				passConfirm: {
					equalTo: "#password"
			}
		}
		});
	 });
	</script>
  </body>
</html>
