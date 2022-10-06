<?php
// Importing the _connec.php file which includes the connection informations.
require_once '_connec.php';

// Instantiating an object of class \PDO through the 'new' keyword
// The \PDO object is the connection to the database, stored in the variable $pdo
$pdo = new \PDO(DSN, USER, PASS);

// Calling a simple request to query all the datas.
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

// Creating the "errors" array to be able to fill it with errors if needed
$errors = [];

// Action to do when the form is submitted.
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validating user datas from the form
    if(
        !isset($_POST['firstname'])
        || trim($_POST['firstname']) === ''
        || strlen($_POST['firstname']) > 45
        ) 
        $errors[] = "firstname=1";

    if(
        !isset($_POST['lastname'])
        || trim($_POST['lastname']) === ''
        || strlen($_POST['lastname']) > 45
        ) 
        $errors[] = "lastname=1";

    if(!empty($errors)) {
        // Making a string of the errors, separated by "&" to obtain it from the URL in form
        // Redirecting it to the form with messages reporting the errors
        $errorsJoined = join('&', $errors);
        header("Location: /?".$errorsJoined);
        return;
    }

    // Sanitizing the user input to make sure there isn't excessive amount of spaces and no SQL Injections.
    $firstname = trim(htmlspecialchars($_POST['firstname']));
    $lastname = trim(htmlspecialchars($_POST['lastname']));
    

    // INSERTING into the table friend the new entry, created by the user
    $sanitizedInput = ('INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)');
    $newFriend = $pdo->prepare($sanitizedInput);


    // Prevents SQL Injections
    $newFriend->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $newFriend->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

    $newFriend->execute();

    header("Refresh: 0");
}


// Creating an HTML list from the database, displaying all the entries from the table friend.

foreach($friends as $friend){
    echo "<li>$friend[firstname] $friend[lastname]</li>";
}

?>

<!-- HTML form to add a friend to the database -->

<h2>Add a Friend !</h2>
<form action="" method="post">
    <div>
        <label for="firstname">Firstname :</label>
        <input
        type="text"
        id="firstname"
        name="firstname"
        required>
    </div>

    <?php if (isset($_GET["firstname"])) :?>
        <p>Please enter a firstname of less than 45 characters.</p>
    <?php endif; ?>

    <div>
        <label for="lastname">Lastname :</label>
        <input
        type="text"
        id="lastname"
        name="lastname"
        required>
    </div>

    <?php if (isset($_GET["lastname"])) :?>
        <p>Please enter a lastname of less than 45 characters.</p>
    <?php endif; ?>

    <div>
        <input type="submit">
    </div>
</form>
