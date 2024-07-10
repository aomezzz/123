<?php
session_start();

// Initialize session variable if not already set
if (!isset($_SESSION['persons'])) {
    $_SESSION['persons'] = [];
}

// Function to find a person by ID
function findPersonById($id) {
    foreach ($_SESSION['persons'] as $person) {
        if ($person['id'] == $id) {
            return $person;
        }
    }
    return null;
}

// Process form submission for updating person
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postalCode'];

    foreach ($_SESSION['persons'] as &$person) {
        if ($person['id'] == $id) {
            $person['name'] = $name;
            $person['age'] = $age;
            $person['street'] = $street;
            $person['city'] = $city;
            $person['state'] = $state;
            $person['postalCode'] = $postalCode;
            break;
        }
    }

    // Redirect back to view.php after updating
    header("Location: view.php");
    exit();
}

// Delete operation
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    foreach ($_SESSION['persons'] as $key => $person) {
        if ($person['id'] == $id) {
            unset($_SESSION['persons'][$key]);
            header("Location: view.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Persons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            margin-top: 10px;
        }
        .action-buttons a {
            display: inline-block;
            margin-right: 5px;
            padding: 6px 12px;
            background-color: #007bff;
            border: 1px solid #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-buttons a:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .update-form {
            display: none;
            background: #f9f9f9;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .update-form label {
            display: block;
            margin-bottom: 5px;
        }
        .update-form input[type="text"],
        .update-form input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .update-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .update-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Persons</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Postal Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['persons'] as $person): ?>
                <tr>
                    <td><?php echo $person['id']; ?></td>
                    <td><?php echo $person['name']; ?></td>
                    <td><?php echo $person['age']; ?></td>
                    <td><?php echo $person['street']; ?></td>
                    <td><?php echo $person['city']; ?></td>
                    <td><?php echo $person['state']; ?></td>
                    <td><?php echo $person['postalCode']; ?></td>
                    <td class="action-buttons">
                        <a href="javascript:void(0);" onclick="toggleUpdateForm('<?php echo $person['id']; ?>')">Edit</a>
                        <a href="view.php?action=delete&id=<?php echo $person['id']; ?>" onclick="return confirm('Are you sure you want to delete this person?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="index.html">Back to Form</a>

        <!-- Update Form -->
        <?php foreach ($_SESSION['persons'] as $person): ?>
        <div class="update-form" id="updateForm<?php echo $person['id']; ?>">
            <h3>Edit Person</h3>
            <form action="view.php" method="post">
                <input type="hidden" name="id" value="<?php echo $person['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $person['name']; ?>" required><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $person['age']; ?>" required><br>

                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo $person['street']; ?>" required><br>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo $person['city']; ?>" required><br>

                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="<?php echo $person['state']; ?>" required><br>

                <label for="postalCode">Postal Code:</label>
                <input type="text" id="postalCode" name="postalCode" value="<?php echo $person['postalCode']; ?>" required><br>

                <input type="submit" name="update" value="Update">
            </form>
        </div>
        <?php endforeach; ?>

        <script>
            function toggleUpdateForm(personId) {
                var updateForm = document.getElementById('updateForm' + personId);
                if (updateForm.style.display === 'block') {
                    updateForm.style.display = 'none';
                } else {
                    updateForm.style.display = 'block';
                }
            }
        </script>
    </div>
</body>
</html>




