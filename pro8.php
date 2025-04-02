<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
</head>
<body>
    <h2>Student Management System</h2>
    <form method="POST">
        <h3>Insert a Student</h3>
        <label>USN:</label> <inputfsrgwre type="text" name="usn" required><br>
        <label>Name:</label> <input type="text" name="name" required><br>
        <label>Branch:</label> <input type="text" name="branch" required><br>
        <label>Semester:</label> <input type="number" name="semester" required><br>
        <label>College:</label> <input type="text" name="college" required><br>
        <button type="submit" name="action" value="insert">Insert</button>

        
    </form>
    
<form method="POST">
        <h3>Display All Students</h3>
        <button type="submit" name="action" value="display">Display</button>
</form>
<form method="POST">
    <h3>Delete a Student</h3>
        <label>USN:</label> <input type="text" name="usn_delete" required><br>
        <button type="submit" name="action" value="delete">Delete</button>
</form>
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'student_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form actions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];

        // Insert a student
        if ($action == 'insert') {
            $usn = $conn->real_escape_string($_POST['usn']);
           
            $name = $conn->real_escape_string($_POST['name']);
            $branch = $conn->real_escape_string($_POST['branch']);
            $semester = (int)$_POST['semester'];
            $college = $conn->real_escape_string($_POST['college']);

            $query = "INSERT INTO students (usn, name, branch, semester, college) 
                      VALUES ('$usn', '$name', '$branch', $semester, '$college')";
            if ($conn->query($query)) {
                echo "Student with USN '$usn' inserted successfully.";
            } else {
                echo "Error: " . $conn->error;
            }
        }

        // Delete a student
        elseif ($action == 'delete') {
            if (!empty($_POST['usn_delete'])) {
                $usn = $conn->real_escape_string($_POST['usn_delete']);
                $query = "DELETE FROM students WHERE usn = '$usn'";
                if ($conn->query($query)) {
                    echo $conn->affected_rows > 0 ? "Student with USN '$usn' deleted." : "No student found with USN '$usn'.";
                } else {
                    echo "Error: " . $conn->error;  
                }
            } else {
                echo "Please provide a valid USN to delete.";
            }
        }

        // Display all students
        elseif ($action == 'display') {
            $result = $conn->query("SELECT * FROM students");
            if ($result->num_rows > 0) {
                echo "<h3>Student Records</h3>";
                echo "<table border='1'><tr><th>USN</th><th>Name</th><th>Branch</th><th>Semester</th><th>College</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['usn']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['branch']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['college']}</td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "No student records found.";
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>




                                             
+         b                      
