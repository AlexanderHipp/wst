<?php include("base.php");?>

<form action="<?php echo $PHP_SELF;?>"  method="post">
<fieldset>


<p>Start typing the name of a state or territory of the United States</p>

<p class="ui-widget">

<label for="state">State (abbreviation in separate field): </label>

<input type="text" id="state"  name="state" /> </p>

<input type="hidden" id="state_id" name="state_id" />


<p><input type="submit" name="submitBtn" value="Submit" /></p>

</fieldset>
</form>

<?php
if (isset($_POST['submit'])) {
	echo "<p>";
	while (list($key,$value) = each($_POST)){
		echo "<strong>" . $key . "</strong> = ".$value."<br />";
	}
	echo "</p>";
}


function() {

            
            $"#state" . autocomplete{
                source: "states.php",
                minLength: 2,
                select: function(event, ui) {
                    $('#state_id').val(ui.item.id);
                    $('#abbrev').val(ui.item.abbrev);
                }
            };

            $("#state_abbrev").autocomplete{
                source: "states_abbrev.php",
                minLength: 2
            };
        }


$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$return_arr = array();

/* If connection to database, run sql statement. */
if ($conn)
{
	$fetch = mysql_query("SELECT * FROM states where state like '%" . mysql_real_escape_string($_GET['term']) . "%'"); 

	/* Retrieve and store in array the results of the query.*/
	while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		$row_array['id'] = $row['id'];
		$row_array['value'] = $row['state'];
		$row_array['abbrev'] = $row['abbrev'];

        array_push($return_arr,$row_array);
    }
}

/* Free connection resources. */
mysql_close($conn);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);
?>