<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../../css/bootstrap.min.css" rel="stylesheet"/>
	<title>match info here</title>
	<style>
		.error {
			color:#ff0000;
		}
	</style>
  </head>
  <body>
	<div class="container">
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            $tournament = $_GET['tournament'];
            if (isset($tournament)) {
                $id1 = $_GET['id1'];
                $games1 = $_GET['games1'];
                $characters1 = $_GET['characters1'];
                $id2 = $_GET['id2'];
                $games2 = $_GET['games2'];
                $characters2 = $_GET['characters2'];
                try {
                    $iniData = parse_ini_file("data.ini.php");
                    $database = new PDO('mysql:host=localhost,dbname=test', $iniData['insecure']['user'], $iniData['insecure']['pass']);
                } catch (PDOEXCEPTION $e) {
                    print($e->getMessage());
                    die();
                }
                $nameInsert = $database->prepare('INSERT INTO smash_player_h2h (Player_1_ID, Player_1_Characters, Player_1_Wins, Player_2_ID, Player_2_Characters, Player_2_Wins) VALUES (:id1, :characters1, :games1, :id2, :characters2, :games2');
                $nameInsert->bindParam(':id1', $id1);
                $nameInsert->bindParam(':characters1', $characters1);
                $nameInsert->bindParam(':games1', $games1);
                $nameInsert->bindParam(':id2', $id2);
                $nameInsert->bindParam(':characters2', $characters2);
                $nameInsert->bindParam(':games2', $games2);
                $nameInsert->execute();
                $matchid = $database->query('SELECT ID FROM smash player id\'s ORDER BY DESC')[0];
                $nameInsert = $database->prepare('INSERT INTO smash_player_h2h (Match_ID) VALUES (:matchid');
                $charInsert->execute();
                print("match recorded");
            }
        ?>
		<div class="col-lg-12 text-center">
			<h2 id="title">enter your match info here</h2>
		</div>
		<div class="col-xs-12" style="height:30px;"></div>
		<form id="register-form" class="container-fluid" method="get" action="matchinfo.php">
			<div class="form-group col-md-6">
				<label for="firstName">what is the name of the tournament?</label>
				<input class="form-control required" type="text" id="tournament" name="tournament" placeholder="tournament"/>
			</div>
			<div class="form-group col-md-6">
				<label for="firstName">what is the winner's player id?</label>
				<input class="form-control required" type="text" id="id1" name="id1" placeholder="winner id"/>
			</div>
			<div class="form-group col-md-6">
				<label for="lastName">how many games did he win?</label>
				<input class="form-control required" type="text" id="games1" name="games1" placeholder="2-3"/>
			</div>
			<div class="form-group container-fluid" id="characters1">
                <label for="secondaries">what characters did he play?</label>
				<input class="form-control" type="text" id="characters1" name="characters1[]"></input>
                <input class="form-control" type="button" value="add another character" onClick="addInput('characters1');">
			</div>
			<div class="form-group col-md-6">
				<label for="lastName">what is the loser's player id?</label>
				<input class="form-control required" type="text" id="id2" name="id2" placeholder="loser id"/>
			</div>
			<div class="form-group col-md-6">
				<label for="lastName">how many games did he win?</label>
				<input class="form-control required" type="text" id="games2" name="games2" placeholder="0-3"/>
			</div>
			<div class="form-group container-fluid" id="characters2">
                <label for="secondaries">what characters did he play?</label>
				<input class="form-control" type="text" id="characters2" name="characters2[]"></input>
                <input class="form-control" type="button" value="add another character" onClick="addInput('charcters2');">
			</div>
            <div class="col-xs-12" style="height:10px;"></div>
			<div class="form-group container-fluid">
				<input class="form-control" type="submit" value="submit!"></input>
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
