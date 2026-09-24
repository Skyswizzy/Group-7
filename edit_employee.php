<?php
include "db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location: employees.php");

    exit();
}

$id = intval($_GET["id"]);


$stmt = $conn->prepare(
    "SELECT * FROM employees WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows == 0) {

    header("Location: employees.php");

    exit();
}


$employee = $result->fetch_assoc();

$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $position = trim($_POST["position"]);
    $email = trim($_POST["email"]);
    $department = trim($_POST["department"]);


    if (
        empty($full_name) ||
        empty($position) ||
        empty($email) ||
        empty($department)
    ) {

        $error = "Please fill in all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $update = $conn->prepare(
            "UPDATE employees
             SET full_name = ?,
                 position = ?,
                 email = ?,
                 department = ?
             WHERE id = ?"
        );


        $update->bind_param(
            "ssssi",
            $full_name,
            $position,
            $email,
            $department,
            $id
        );


        if ($update->execute()) {

            header(
                "Location: employees.php?message=" .
                urlencode("Employee updated successfully!")
            );

            exit();

        } else {

            $error = "Unable to update employee.";

        }

        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Edit Employee</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">


    <!-- Custom CSS -->

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>


<!-- =========================================
     SIDEBAR
========================================= -->

<div class="sidebar">


    <!-- BRAND -->

    <div class="sidebar-brand">

        <i class="bi bi-people-fill"></i>

        <div>

            <span>EMPLOYEE</span>

            <span>MANAGEMENT</span>

        </div>

    </div>


    <!-- MENU -->

    <div class="sidebar-title">
        MENU
    </div>


    <ul class="sidebar-menu">


        <!-- DASHBOARD -->

        <li>

            <a href="index.php">

                <i class="bi bi-speedometer2"></i>

                <span>Dashboard</span>

            </a>

        </li>


        <!-- EMPLOYEES -->

        <li class="active">

            <a href="employees.php">

                <i class="bi bi-people-fill"></i>

                <span>Employees</span>

            </a>

        </li>


    </ul>

</div>



<!-- =========================================
     MAIN CONTENT
========================================= -->

<div class="main-content">


    <!-- =====================================
         TOP NAVBAR
    ====================================== -->

    <nav class="top-navbar">


        <div class="top-navbar-left">

            <h5>
                Edit Employee
            </h5>

            <small>
                Employees / Edit Employee
            </small>

        </div>


        <div class="top-navbar-right">

            <i class="bi bi-person-circle"></i>

            <span>
                Administrator
            </span>

        </div>


    </nav>



    <!-- =====================================
         PAGE CONTENT
    ====================================== -->

    <main class="dashboard-container">


        <div class="dashboard-header">

            <h2>
                Edit Employee
            </h2>

            <p>
                Update employee information.
            </p>

        </div>



        <!-- FORM -->

        <div class="form-container">


            <?php if ($error != ""): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>



            <form method="POST">


                <!-- FULL NAME -->

                <div class="mb-3">

                    <label class="form-label">
                        Full Name *
                    </label>

                    <input
                        type="text"
                        name="full_name"
                        class="form-control"
                        value="<?= htmlspecialchars($employee['full_name']) ?>"
                        required>

                </div>



                <!-- POSITION -->

                <div class="mb-3">

                    <label class="form-label">
                        Position *
                    </label>

                    <input
                        type="text"
                        name="position"
                        class="form-control"
                        value="<?= htmlspecialchars($employee['position']) ?>"
                        required>

                </div>



                <!-- EMAIL -->

                <div class="mb-3">

                    <label class="form-label">
                        Email *
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($employee['email']) ?>"
                        required>

                </div>



                <!-- DEPARTMENT -->

                <div class="mb-4">

                    <label class="form-label">
                        Department *
                    </label>


                    <?php

                    $departments = [
                        "IT",
                        "Human Resources",
                        "Finance",
                        "Marketing",
                        "Operations"
                    ];

                    ?>


                    <select
                        name="department"
                        class="form-select"
                        required>


                        <?php foreach ($departments as $dept): ?>

                            <option
                                value="<?= htmlspecialchars($dept) ?>"
                                <?= $employee['department'] == $dept ? 'selected' : '' ?>>

                                <?= htmlspecialchars($dept) ?>

                            </option>

                        <?php endforeach; ?>


                    </select>

                </div>



                <!-- BUTTONS -->

                <div class="d-flex gap-2">


                    <button
                        type="submit"
                        class="btn btn-metal">

                        <i class="bi bi-check-lg"></i>

                        Update Employee

                    </button>


                    <a
                        href="employees.php"
                        class="btn btn-outline-secondary">

                        Cancel

                    </a>


                </div>


            </form>


        </div>


    </main>



    <!-- FOOTER -->

    <footer class="dashboard-footer">

        Employee Management System &copy; 2026

    </footer>


</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>
