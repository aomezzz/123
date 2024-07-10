<?php
session_start();

// Initialize session variable for storing persons data
if (!isset($_SESSION['persons'])) {
    $_SESSION['persons'] = [];
}

// Function to generate unique ID (simulating auto-increment)
function generateUniqueId() {
    return uniqid();
}

// Function to create a new person
function createPerson($name, $age, $street, $city, $state, $postalCode) {
    $person = [
        'id' => generateUniqueId(),
        'name' => $name,
        'age' => $age,
        'street' => $street,
        'city' => $city,
        'state' => $state,
        'postalCode' => $postalCode
    ];

    // Add person to session array
    $_SESSION['persons'][] = $person;

    return $person;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postalCode'];

    // Create new person
    $newPerson = createPerson($name, $age, $street, $city, $state, $postalCode);

    if ($newPerson) {
        echo "<script>alert('New person created successfully');</script>";
        echo "<script>window.location = 'index.html';</script>";
    } else {
        echo "Error creating person";
    }
}
?>