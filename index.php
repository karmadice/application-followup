<?php
class Interview
{
    /**
     * Error : Class property is declared as non-static property, but is used as Static property
     * Change 1 : Adding static keyword to fix error.
     */
	public static $title = 'Interview test';
}

$lipsum = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus incidunt, quasi aliquid, quod officia commodi magni eum? Provident, sed necessitatibus perferendis nisi illum quos, incidunt sit tempora quasi, pariatur natus.';

$people = array(
	array('id'=>1, 'first_name'=>'John', 'last_name'=>'Smith', 'email'=>'john.smith@hotmail.com'),
	array('id'=>2, 'first_name'=>'Paul', 'last_name'=>'Allen', 'email'=>'paul.allen@microsoft.com'),
	array('id'=>3, 'first_name'=>'James', 'last_name'=>'Johnston', 'email'=>'james.johnston@gmail.com'),
	array('id'=>4, 'first_name'=>'Steve', 'last_name'=>'Buscemi', 'email'=>'steve.buscemi@yahoo.com'),
	array('id'=>5, 'first_name'=>'Doug', 'last_name'=>'Simons', 'email'=>'doug.simons@hotmail.com')
);

/**
 * Error : Not checking if varaible being accessed is set and not empty could result in PHP Notice while execution.
 * Change 2: It's always safe to confirm that array is set to avoid notices. Empty would evaluate if array is set and is not empty.
 * Change 3: Although GET and POST are both equally unsafe, using POST can prevent Semantic URL attack
 */
$person = !empty($_POST['person']) ? $_POST['person'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Interview test</title>
	<style>
		body {font: normal 14px/1.5 sans-serif;}
	</style>
</head>
<body>

	<h1><?=Interview::$title;?></h1>

	<?php
	// Print 10 times
    /**
     * Error: Provided condition for the loop is logically invalid. To execute loop 10 times, init counter parameter of for loop must be less than test counter (end counter) parameter if incremental operator is used as counter.
     * Change 4: Swap values of init and test counters.
     */
	for ($i=0; $i<10; $i++) {
	    // Unlike Python and JavaScript, php uses dot(.) for string concatenation instead of plus(+) sign.
		echo '<p>'.$lipsum.'</p>';
	}
	?>
	<hr>
    
    <!-- Change 5: Since we are accessing data using pre-defined variable $_POST, form method must be POST as well -->
    <!-- Change 6: Using PHP_SELF to reduce risk of XSS attack -->
    <!-- Change 7: Added required attribute for all inputs for validation purpose -->
    <form method="POST" action="<?=htmlentities($_SERVER['PHP_SELF']);?>">
		<p><label for="firstName">First name</label> <input type="text" required name="person[first_name]" id="firstName"></p>
		<p><label for="lastName">Last name</label> <input type="text" required name="person[last_name]" id="lastName"></p>
        <!-- Change 8: Changed input type from text to email for validation purpose -->
		<p><label for="email">Email</label> <input type="email" name="person[email]" required id="email"></p>
        <!-- Change 9: Unnecessary back slash was used -->
		<p><input type="submit" value="Submit"></p>
	</form>

	<?php
    /**
     * Change 10 : Checking if variable is set and is not empty
     * Change 11: Sanitize and validate input data
     * 
     */
    if (!empty($person)): ?>
		<p><strong>Person</strong> <?=filter_var($person['first_name'], FILTER_SANITIZE_STRING);?>, <?=filter_var($person['last_name'], FILTER_SANITIZE_STRING);?>, <?=filter_var($person['email'], FILTER_SANITIZE_EMAIL);?></p>
	<?php endif; ?>
    
	<hr>

	<table>
		<thead>
			<tr>
				<th>First name</th>
				<th>Last name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php
            /**
             * Change 12: Since type of $people variable is an array, we shall use array[key] syntax to access its elements instead of using syntax to access objects
             */
            foreach ($people as $person): ?>
				<tr>
					<td><?=$person['first_name'];?></td>
					<td><?=$person['last_name'];?></td>
					<td><?=$person['email'];?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</body>
</html>