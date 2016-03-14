<?php
class database
{
	function databaseConnect($ipadress, $username, $password, $database)
	{
		global $conn;

		$conn = new mysqli("localhost", "root", "", "foodrandomizer");
		if ($conn->connect_error) {
		    ?>
		    	<form action='Home.php' name="GoBackToHome" method='post'>
					<input type='submit' value='Go Back' />
				</form>
				<?php
		    die ("<b>Error Message:</b> Failed to connect with the database.");
		}
	}
	function TableBuilder($tabelName)
	{
		global $conn;
		
		$sql = "SELECT * FROM $tabelName";
		$result = $conn->query($sql);
		$countRows = $result->num_rows;

		$sqlCount = "SHOW COLUMNS FROM `$tabelName`";
		$resultColumns = $conn->query($sqlCount);
		$countColumns = $resultColumns->num_rows;

		echo "<h1>" . $tabelName . "</h1>";
		
		if ($result->num_rows > 0) {
			
		    echo "<table class='table columntitle table-striped'><tr>";

		    for($k = 1; $k <= $countColumns; $k++) 
			{
				$columnCount = $resultColumns->fetch_assoc();
				echo "<th><label>" . $columnCount["Field"] . "</label></th>";
			}
			echo "<th>Edit</th><th>Delete</th></tr>";
		    
		    // output data of each row
		    for($i = 1; $i <= $countRows; $i++) {
		        	$row = $result->fetch_assoc();
		        	?>
		        	<tr>
		        		<?php
						$infoColumns = $conn->query($sqlCount);

			    		for($j = 1; $j <= $countColumns; $j++) 
						{
							$columnCount = $infoColumns->fetch_assoc();

							$columName = $columnCount["Field"];
							if($columName == "id")
							{
		        			echo "<td><label class='idLabel' id='" . $tabelName ."_lblRows" . $i . $j . "' class='label'>" . $row["$columName"] . "</label></td>";
							}
							else
							{
		        			echo "<td><label id='" . $tabelName ."_lblRows" . $i . $j . "' class='label'>" . $row["$columName"] . "</label></td>";
		        			}
		        		}
		        		?>
		        		<td>
			        		<form action='' name="editform<?php echo $i;?>" method='post'>
					    	    <input type='hidden' name='editordeleteid' value='<?php echo $row["id"] . ";split;" . $tabelName . ";split;edit"; ?>' />
		                	   	<input type='hidden' name='tabelname<?php echo $i; ?>' value='<?php echo $tabelName; ?>'  class="HiddenTabelName" />
		                	   	<button name="<?php echo $tabelName; ?>_btnEdit<?php echo $i; ?>" class="edit">Edit</button>
		        			</form>
		        		</td>
		        		<td>
			        		<form action='' name="deleteform<?php echo $i;?>" method='post'>
					    	    <input type='hidden' name='editordeleteid' value='<?php echo $row["id"] . ";split;" . $tabelName . ";split;delete"; ?>' />
	  							<input type='submit' value='Delete' />
	  						</form>
	  					</td></tr>
	  					<?php
		    }
		    echo "</table>";
		} else {
		    echo "No results";
		}
		echo "<br>";
	?>
		<form action="" style="text-align:left;">
		    <input type="submit" value="Voeg toe">
		</form>
		<?php
	}
}
?>