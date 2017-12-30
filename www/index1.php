<?php
	include 'include/db.php';
//QUERYING THE PDO
	//$sql = $conn->query("select * from team");
	//foreach ($conn->query($sql) as row) {
	//	echo $row[1];
	$name = "paul";
	$ans = $conn->prepare("SELECT * from team where name = :name");
	$ans->bindParam(':name',$name);
	//$conn->bindValue(":name","paul");
	$ans->execute();

	//THIS WORKS
	//echo var_dump($row);
	//echo print_r($row)
	//$row = $ans->execute();
	$res = $ans->fetch();
	//$res = $ans->fetch(PDO::FETCH_ASSOC);
	//extract($res);
	// $res = $ans-.fetchALL() <<<<.....THIS DOES NOT WORK
//	foreach($res as $sho){
		/*echo var_dump($res)."<br>";
		echo $res["name"]."<br>";
		echo $res["team_id"]; */
		//echo var_dump($sho);
	//	echo "Good work".'<br>';

//	}
	//THIS WORKS ALSO:
	echo $res['name'].'<br>';
	echo $res[0];
	//echo "<p> $name </p>"; //USE THIS WHEN YOU USE THE FETCH_ASSOC

	 //THIS WORKS TOO
	/* for($i=0; $row = $ans->fetch(); $i++){
         echo $i." <br>".$row['name']."<br/>";
       } */

	?>