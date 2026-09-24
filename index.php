<?php

include "db.php";


// =========================================
// TOTAL EMPLOYEES
// =========================================

$total_result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM employees"
);

$total_employees = $total_result->fetch_assoc()["total"];


// =========================================
// TOTAL DEPARTMENTS
// =========================================

$department_result = $conn->query(
    "SELECT COUNT(DISTINCT department) AS total
     FROM employees
     WHERE department IS NOT NULL
     AND department != ''"
);

$total_departments = $department_result->fetch_assoc()["total"];


// =========================================
// TOTAL POSITIONS
// =========================================

$position_result = $conn->query(
    "SELECT COUNT(DISTINCT position) AS total
     FROM employees
     WHERE position IS NOT NULL
     AND position != ''"
);

$total_positions = $position_result->fetch_assoc()["total"];


// =========================================
// EMPLOYEES BY DEPARTMENT
// For Employee Overview
// =========================================

$department_data = [];

$overview_result = $conn->query(
    "SELECT department, COUNT(*) AS total
     FROM employees
     GROUP BY department
     ORDER BY total DESC"
);

while ($row = $overview_result->fetch_assoc()) {

    $department_data[] = $row;

}


// =========================================
// MESSAGE
// =========================================

$message = "";

if (isset($_GET["message"])) {

    $message = $_GET["message"];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Employee Management System</title>


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

        <li class="active">

            <a href="index.php">

                <i class="bi bi-speedometer2"></i>

                <span>Dashboard</span>

            </a>

        </li>


        <!-- EMPLOYEES -->

        <li>

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
                Dashboard
            </h5>

            <small>
                Home / Dashboard
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
         DASHBOARD CONTENT
    ===================================== -->

    <main class="dashboard-container">


        <!-- PAGE HEADER -->

        <div class="dashboard-header">

            <h2>
                Dashboard
            </h2>

            <p>
                Welcome to the Employee Management System
            </p>

        </div>



        <!-- =================================
             SUCCESS MESSAGE
        ================================== -->

        <?php if ($message != ""): ?>

            <div class="alert alert-success">

                <i class="bi bi-check-circle-fill"></i>

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>



        <!-- =================================
             STATISTICS
        ================================== -->

        <div class="row g-4 mb-4">


            <!-- TOTAL EMPLOYEES -->

            <div class="col-lg-4 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-people-fill"></i>

                    </div>


                    <div class="stat-content">

                        <span>
                            Total Employees
                        </span>

                        <h3>
                            <?= $total_employees ?>
                        </h3>

                    </div>

                </div>

            </div>



            <!-- TOTAL DEPARTMENTS -->

            <div class="col-lg-4 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-building"></i>

                    </div>


                    <div class="stat-content">

                        <span>
                            Departments
                        </span>

                        <h3>
                            <?= $total_departments ?>
                        </h3>

                    </div>

                </div>

            </div>



            <!-- TOTAL POSITIONS -->

            <div class="col-lg-4 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-person-badge-fill"></i>

                    </div>


                    <div class="stat-content">

                        <span>
                            Positions
                        </span>

                        <h3>
                            <?= $total_positions ?>
                        </h3>

                    </div>

                </div>

            </div>


        </div>



        <!-- =================================
             LOWER DASHBOARD
        ================================== -->

        <div class="row g-4">


            <!-- EMPLOYEE OVERVIEW -->

            <div class="col-lg-8">

                <div class="metallic-card dashboard-panel employee-overview-card">


                    <!-- OVERVIEW HEADER -->

                    <div class="overview-header">

                        <div class="overview-title">

                            <div class="overview-title-icon">

                                <i class="bi bi-bar-chart-fill"></i>

                            </div>

                            <div>

                                <h5>
                                    Employee Overview
                                </h5>

                                <p>
                                    Employee distribution by department
                                </p>

                            </div>

                        </div>


                        <!-- TOTAL -->

                        <div class="overview-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                <?= $total_employees ?>
                            </strong>

                        </div>

                    </div>



                    <!-- OVERVIEW CONTENT -->

                    <div class="overview-content">


                        <?php if (count($department_data) > 0): ?>


                            <?php foreach ($department_data as $department): ?>


                                <?php

                                $department_total =
                                    $department["total"];


                                if ($total_employees > 0) {

                                    $percentage =
                                        ($department_total /
                                        $total_employees) * 100;

                                } else {

                                    $percentage = 0;

                                }


                                // Department icon

                                $icon = "bi-building";


                                switch ($department["department"]) {

                                    case "IT":

                                        $icon = "bi-pc-display";

                                        break;


                                    case "Human Resources":

                                        $icon = "bi-person-heart";

                                        break;


                                    case "Finance":

                                        $icon = "bi-cash-stack";

                                        break;


                                    case "Marketing":

                                        $icon = "bi-megaphone";

                                        break;


                                    case "Operations":

                                        $icon = "bi-gear";

                                        break;

                                }

                                ?>


                                <!-- DEPARTMENT -->

                                <div class="overview-item">


                                    <!-- ICON -->

                                    <div class="overview-department-icon">

                                        <i class="bi <?= $icon ?>"></i>

                                    </div>



                                    <!-- DETAILS -->

                                    <div class="overview-details">


                                        <!-- NAME + COUNT -->

                                        <div class="overview-label">

                                            <span>

                                                <?= htmlspecialchars(
                                                    $department["department"]
                                                ) ?>

                                            </span>

                                            <strong>

                                                <?= $department_total ?>

                                            </strong>

                                        </div>



                                        <!-- PROGRESS -->

                                        <div class="overview-progress">

                                            <div
                                                class="overview-progress-fill"
                                                style="width: <?= $percentage ?>%;">
                                            </div>

                                        </div>



                                        <!-- INFORMATION -->

                                        <div class="overview-bottom">

                                            <span>

                                                <?= round($percentage) ?>%
                                                of employees

                                            </span>

                                            <span>

                                                <?= $department_total ?>

                                                <?= $department_total == 1
                                                    ? "employee"
                                                    : "employees" ?>

                                            </span>

                                        </div>


                                    </div>


                                </div>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <!-- EMPTY STATE -->

                            <div class="overview-empty">


                                <div class="overview-empty-icon">

                                    <i class="bi bi-people"></i>

                                </div>


                                <h5>
                                    No Employee Data
                                </h5>


                                <p>
                                    Add employees to see the department overview.
                                </p>


                                <a
                                    href="add_employee.php"
                                    class="btn btn-metal">

                                    <i class="bi bi-person-plus-fill"></i>

                                    Add Employee

                                </a>


                            </div>


                        <?php endif; ?>


                    </div>


                </div>

            </div>




            <!-- QUICK ACTIONS -->

            <div class="col-lg-4">

                <div class="metallic-card dashboard-panel">


                    <div class="panel-header">

                        <div>

                            <h5>
                                Employee Management
                            </h5>

                            <p>
                                Manage your employees
                            </p>

                        </div>

                    </div>



                    <!-- VIEW EMPLOYEES -->

                    <a
                        href="employees.php"
                        class="quick-action">

                        <div class="quick-icon">

                            <i class="bi bi-people-fill"></i>

                        </div>


                        <div>

                            <strong>
                                View Employees
                            </strong>

                            <small>
                                View employee records
                            </small>

                        </div>


                        <i class="bi bi-chevron-right"></i>

                    </a>



                    <!-- ADD EMPLOYEE -->

                    <a
                        href="add_employee.php"
                        class="quick-action">

                        <div class="quick-icon">

                            <i class="bi bi-person-plus-fill"></i>

                        </div>


                        <div>

                            <strong>
                                Add Employee
                            </strong>

                            <small>
                                Add a new employee
                            </small>

                        </div>


                        <i class="bi bi-chevron-right"></i>

                    </a>


                </div>

            </div>


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
