<?php
session_start();

include_once "dbconn.php";  // Ensure this file initializes the $connect variable

// To Validate Data from Database
function validateInput($input)
{
    global $connect;

    if (is_array($input)) {
        throw new InvalidArgumentException('Expected a string, but received an array.');
    }

    return mysqli_real_escape_string($connect, trim($input));
}

// To redirect from one page to another page
function redirect($url, $status)
{
    $_SESSION["status"] = $status;
    header("Location: $url");
    exit(0);
}

// Display alert messages
function alertMessage()
{
    if (isset($_SESSION["status"])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>' . htmlspecialchars($_SESSION["status"], ENT_QUOTES, 'UTF-8') . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION["status"]);
    }
}

// To Insert Values in Database
function insert($tableName, $data)
{
    global $connect;

    $table = validateInput($tableName);

    $columns = array_keys($data);
    $values = array_map(function ($value) use ($connect) {
        return "'" . mysqli_real_escape_string($connect, $value) . "'";
    }, array_values($data));

    $finalColumn = implode(", ", $columns);
    $finalValues = implode(", ", $values);

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";

    return mysqli_query($connect, $query);
}

// To Update Values in Database
function updateValues($tableName, $data, $id)
{
    global $connect;

    $table = validateInput($tableName);
    $id = validateInput($id);

    $updateStringData = "";

    foreach ($data as $column => $value) {
        $updateStringData .= $column . "='" . mysqli_real_escape_string($connect, $value) . "', ";
    }

    $finalUpdatedData = rtrim($updateStringData, ', ');

    $query = "UPDATE $table SET $finalUpdatedData WHERE id='$id'";

    return mysqli_query($connect, $query);
}

// To Get All Records from a Table
function getAll($tableName, $status = NULL)
{
    global $connect;

    $table = validateInput($tableName);

    $query = $status === "status" ? "SELECT * FROM $table WHERE status='0'" : "SELECT * FROM $table";

    return mysqli_query($connect, $query);
}

// To Get a Record by ID
function getById($tableName, $id)
{
    global $connect;

    $table = validateInput($tableName);
    $id = validateInput($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";

    $result = mysqli_query($connect, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return [
                'status' => '200',
                'data' => $row,
                'message' => 'Record Found.'
            ];
        } else {
            return [
                'status' => '404',
                'message' => 'No Data Found.'
            ];
        }
    } else {
        return [
            'status' => '500',
            'message' => 'Something Went Wrong.'
        ];
    }
}

// To Delete a Record by ID
function delete($tableName, $id)
{
    global $connect;

    $table = validateInput($tableName);
    $id = validateInput($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";

    return mysqli_query($connect, $query);
}

function checkParamsID($type)
{
    if (isset($_GET[$type])) {
        if (isset($_GET[$type]) != "") {
            return $_GET[$type];
        } else {
            echo "<h5>No ID Found in Params</h5>";
        }

    } else {
        echo "<h5>No ID Found in Params</h5>";
    }
}
?>