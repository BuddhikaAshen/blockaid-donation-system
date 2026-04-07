<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $account_type = $_POST['account_type'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Detect email based on account type
    if ($account_type == "person") {
        $email = $_POST['person_email'];
    }

    if ($account_type == "organization") {
        $email = $_POST['org_email'];
    }

    // =========================
    // CHECK EMAIL EXISTS
    // =========================
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email already registered!";
        exit();
    }

    // =========================
    // PERSON REGISTRATION
    // =========================
    if ($account_type == "person") {

        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO users (email, password_hash, account_type)
                VALUES (?, ?, 'individual')";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();

        $user_id = $stmt->insert_id;

        $sql2 = "INSERT INTO individual_profiles (user_id, full_name, phone)
                 VALUES (?, ?, ?)";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("iss", $user_id, $full_name, $phone);
        $stmt2->execute();

        echo "Person registered successfully";
    }

    // =========================
    // ORGANIZATION REGISTRATION
    // =========================
    if ($account_type == "organization") {

        $org_name = $_POST['organization_name'];
        $org_type = $_POST['organization_type'];
        $reg_number = $_POST['registration_number'];
        $responsible = $_POST['responsible_person'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO users (email, password_hash, account_type)
                VALUES (?, ?, 'organization')";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();

        $user_id = $stmt->insert_id;

        $sql2 = "INSERT INTO organization_profiles
                (user_id, organization_name, organization_type, registration_number, responsible_person_name, phone)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("isssss", $user_id, $org_name, $org_type, $reg_number, $responsible, $phone);
        $stmt2->execute();

        echo "Organization registered successfully";
    }
}
?>