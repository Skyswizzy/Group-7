<?php
include "db.php";

$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");

$message = "";

if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employees - Employee Management System</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">

</head>


<body>


<!-- =========================================
     SIDEBAR
     ========================================= -->

<div class="sidebar">

    <div class="sidebar-brand">

        <i class="bi bi-people-fill"></i>

        <div>
            <span>EMPLOYEE</span>
            <span>MANAGEMENT</span>
        </div>

    </div>


    <div class="sidebar-title">
        MENU
    </div>


    <ul class="sidebar-menu">

        <!-- Dashboard -->

        <li>

            <a href="index.php">

                <i class="bi bi-speedometer2"></i>

                <span>Dashboard</span>

            </a>

        </li>


        <!-- Employees -->

        <li class="active">

            <a href="employee.php">

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


    <!-- =========================================
         TOP NAVBAR
         ========================================= -->

    <div class="top-navbar">


        <div class="top-navbar-left">

            <h5>Employee Management System</h5>

            <small>
                Manage employee records and information
            </small>

        </div>


        <div class="top-navbar-right">

            <i class="bi bi-person-circle"></i>

            <span>Administrator</span>

        </div>

    </div>



    <!-- =========================================
         EMPLOYEE CONTENT
         ========================================= -->

    <div class="dashboard-container">


        <!-- PAGE HEADER -->

        <div class="employee-page-header employee-header-spacing">


            <div>

                <h2>Employees</h2>

                <p>
                    Manage employee information and records.
                </p>

            </div>


            <!-- ADD EMPLOYEE -->

            <a href="add_employee.php"
               class="btn btn-metal">

                <i class="bi bi-person-plus-fill me-2"></i>

                Add Employee

            </a>


        </div>



        <!-- SUCCESS MESSAGE -->

        <?php if ($message != ""): ?>

            <div class="alert alert-success alert-dismissible fade show mt-4"
                 role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                <?= htmlspecialchars($message) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>



        <!-- EMPLOYEE TABLE -->

        <div class="metallic-card employee-table-card mt-4">


            <!-- TABLE HEADER -->

            <div class="employee-card-header">


                <div class="employee-card-title">

                    <div class="employee-card-icon">

                        <i class="bi bi-people-fill"></i>

                    </div>


                    <div>

                        <h5>Employee Records</h5>

                        <p>
                            View and manage all employee information.
                        </p>

                    </div>

                </div>


                <!-- EMPLOYEE COUNT -->

                <div class="employee-count">

                    <i class="bi bi-person-lines-fill"></i>

                    <span>
                        <?= $result->num_rows ?> Employees
                    </span>

                </div>


            </div>



            <!-- TABLE -->

            <div class="table-responsive">

                <table class="table employee-table align-middle mb-0">


                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Full Name</th>

                            <th>Position</th>

                            <th>Email</th>

                            <th>Department</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php if ($result->num_rows > 0): ?>


                        <?php while ($employee = $result->fetch_assoc()): ?>


                            <tr>


                                <!-- ID -->

                                <td>

                                    <span class="employee-id">

                                        <?= $employee['id'] ?>

                                    </span>

                                </td>


                                <!-- NAME -->

                                <td>

                                    <div class="employee-name">

                                        <div class="employee-avatar">

                                            <i class="bi bi-person-fill"></i>

                                        </div>

                                        <strong>

                                            <?= htmlspecialchars(
                                                $employee['full_name']
                                            ) ?>

                                        </strong>

                                    </div>

                                </td>


                                <!-- POSITION -->

                                <td>

                                    <?= htmlspecialchars(
                                        $employee['position']
                                    ) ?>

                                </td>


                                <!-- EMAIL -->

                                <td>

                                    <span class="employee-email">

                                        <?= htmlspecialchars(
                                            $employee['email']
                                        ) ?>

                                    </span>

                                </td>


                                <!-- DEPARTMENT -->

                                <td>

                                    <span class="department-badge">

                                        <?= htmlspecialchars(
                                            $employee['department']
                                        ) ?>

                                    </span>

                                </td>


                                <!-- ACTIONS -->

                                <td>

                                    <div class="employee-actions">


                                        <!-- EDIT -->

                                        <a
                                            href="edit_employee.php?id=<?= $employee['id'] ?>"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="Edit Employee"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                            <span>Edit</span>

                                        </a>



                                        <!-- DELETE -->

                                        <a
                                            href="delete_employee.php?id=<?= $employee['id'] ?>"
                                            class="btn btn-sm btn-danger"
                                            title="Delete Employee"
                                            onclick="return confirm('Are you sure you want to delete this employee?');"
                                        >

                                            <i class="bi bi-trash"></i>

                                            <span>Delete</span>

                                        </a>


                                    </div>

                                </td>


                            </tr>


                        <?php endwhile; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="6"
                                class="text-center"
                            >

                                <div class="empty-employees">

                                    <div class="empty-employee-icon">

                                        <i class="bi bi-people"></i>

                                    </div>

                                    <h5>
                                        No Employee Records
                                    </h5>

                                    <p>
                                        There are currently no employees
                                        in the system.
                                    </p>

                                    <a
                                        href="add_employee.php"
                                        class="btn btn-metal"
                                    >

                                        <i class="bi bi-person-plus-fill me-2"></i>

                                        Add Employee

                                    </a>

                                </div>

                            </td>

                        </tr>


                    <?php endif; ?>


                    </tbody>

                </table>

            </div>


        </div>



        <!-- BACK TO DASHBOARD -->

        <div class="employee-back">

            <a
                href="index.php"
                class="btn btn-outline-secondary"
            >

                <i class="bi bi-arrow-left me-2"></i>

                Back to Dashboard

            </a>

        </div>


    </div>


</div>



<!-- Bootstrap JavaScript -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>