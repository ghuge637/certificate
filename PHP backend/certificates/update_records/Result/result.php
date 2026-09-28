<?php
// index.php
session_start();
include('../../db_conn.php');
$selected_year = isset($_POST['academic_status']) ? $_POST['academic_status'] : 'first_year';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Result Update</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; background:#f7f7f7; }
    table { border-collapse: collapse; width: 100%; background: #fff; }
    th, td { padding: 10px 12px; border: 1px solid #ddd; text-align: left; }
    th { background: #0073e6; color: white; }
    tr:nth-child(even) { background: #f2f6fb; }
    .btn { padding: 6px 10px; border: none; border-radius: 4px; cursor: pointer; }
    .btn-edit { background: #ff9800; color: white; }
    /* Modal */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
             background: rgba(0,0,0,0.6); justify-content: center; align-items: center; }
    .modal-content { background: white; padding: 20px; border-radius: 8px; width: 400px; }
    .modal-content h2 { margin-top: 0; }
    .close { float: right; cursor: pointer; font-size: 18px; }
    input, select { width: 100%; padding: 8px; margin: 6px 0; border: 1px solid #ccc; border-radius: 4px; }
    .btn-save { background: #28a745; color: white; }

    /* select acadmic year */
form {
  background: #ffffff;
  padding: 20px 25px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  max-width: 400px;
  margin: 20px auto;
  text-align: center;
  font-family: Arial, sans-serif;
}

h2 {
  color: #2c3e50;
  margin-bottom: 15px;
  font-size: 22px;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 8px;
  color: #34495e;
}

select {
  width: 100%;
  padding: 10px;
  font-size: 15px;
  border-radius: 8px;
  border: 1px solid #bdc3c7;
  margin-bottom: 15px;
  outline: none;
  transition: all 0.3s ease;
}

select:focus {
  border-color: #2980b9;
  box-shadow: 0 0 6px rgba(41,128,185,0.3);
}

button {
  background: #2980b9;
  color: white;
  border: none;
  padding: 10px 18px;
  font-size: 15px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #1c5980;
}

/* search bar */
    .search-container {
    margin: 20px 0;
    padding: 0 15px;
}

.search-box {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
}

#searchInput {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border: 2px solid #e2e8f0;
    border-radius: 25px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: white;
}

#searchInput:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #7a8c9e;
    font-size: 18px;
}

/* Optional: Add a subtle animation when focused */
#searchInput:focus + .search-icon {
    color: #3498db;
}

/* For smaller screens */
@media (max-width: 768px) {
    #searchInput {
        padding: 10px 15px 10px 40px;
        font-size: 16px;
    }
    
    .search-icon {
        left: 12px;
        font-size: 16px;
    }
}
  </style>
  
</head>
<body>
  <!-- <h2>Select Academic Year</h2> -->
  <form method="post" action="">
    <label>Select Academic Year:</label>
    <select name="academic_status" required>
      <option value="first_year" <?= $selected_year=="first_year" ? "selected" : "" ?>>First Year</option>
      <option value="second_year" <?= $selected_year=="second_year" ? "selected" : "" ?>>Second Year</option>
      <option value="third_year" <?= $selected_year=="third_year" ? "selected" : "" ?>>Third Year</option>
      <option value="final_year" <?= $selected_year=="final_year" ? "selected" : "" ?>>Fourth Year</option>
    </select>
    <button type="submit">Load Records</button>
  </form>
  

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
     // Protect table name from injection (only allow known values)
    $valid_tables = ["first_year","second_year","third_year","final_year"];
    $table = in_array($selected_year, $valid_tables) ? $selected_year : "first_year";

    // Fetch data
    $sql = "SELECT prnno, academic_status, SGPA, CGPA, exam_form_status FROM $table";
    $result = $conn->query($sql);

    if($table == "first_year"){echo "<H1>Frirst Year Records</H1>";}
    elseif($table == "second_year"){echo "<H1>Second Year Records</H1>";}
    elseif($table == "third_year"){echo "<H1>Third Year Records</H1>";}
    else{echo "<H1>Fourth Year Records</H1>";}

    // echo "<input type='text' id='searchInput' placeholder='Search by PRN No' onkeyup='searchTable()'>";

 if ($result && $result->num_rows > 0): ?>
    <div class="search-container">
        <div class="search-box">
            <input type='text' id='searchInput' placeholder='Search by PRN No' onkeyup='searchTable()'>
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>
    <table id="recordsTable">
      <thead>
        <tr>
          <th>Number</th>
          <th>Academic Status</th>
          <th>SGPA</th>
          <th>CGPA</th>
          <th>Exam Form Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php  while($row=$result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['prnno']); ?></td>
            <td><?= htmlspecialchars($row['academic_status']); ?></td>
            <td><?= htmlspecialchars($row['SGPA']); ?></td>
            <td><?= htmlspecialchars($row['CGPA']); ?></td>
            <td><?= htmlspecialchars($row['exam_form_status']); ?></td>
            <td>
              <button class="btn btn-edit"
                onclick="openEditModal(
                  '<?= $row['prnno']; ?>',
                  '<?= htmlspecialchars($row['academic_status']); ?>',
                  '<?= htmlspecialchars($row['SGPA']); ?>',
                  '<?= htmlspecialchars($row['CGPA']); ?>',
                  '<?= htmlspecialchars($row['exam_form_status']); ?>'
                )">Edit</button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No records found.</p>
  <?php endif; ?>

  <!-- Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Edit Record</h2>
      <form id="editForm" method="post" action="update.php">
        <input type="hidden" name="prnno" id="edit_id">
        <input type="hidden" name="table" id="table" value="<?php echo $table; ?>">

        <label>Academic Status:</label>
            <select name="academic_status" id="edit_academic_status" required>
            <option value="Pursuing">Pursuing</option>
            <option value="Completed">Completed</option>
            </select>


        <label>SGPA:</label>
        <input type="number" step="0.01" name="SGPA" id="edit_SGPA" required>

        <label>CGPA:</label>
        <input type="number" step="0.01" name="CGPA" id="edit_CGPA" required>

        <label>Exam Form Status:</label>
        <input type="text" name="exam_form_status" id="edit_exam_form_status" required>

        <button type="submit" class="btn btn-save">Save Changes</button>
      </form>
    </div>
  </div>

  <script>
    function openEditModal(id, academic_status, SGPA, CGPA, exam_form_status) {
      document.getElementById("edit_id").value = id;
      document.getElementById("edit_academic_status").value = academic_status;
      document.getElementById("edit_SGPA").value = SGPA;
      document.getElementById("edit_CGPA").value = CGPA;
      document.getElementById("edit_exam_form_status").value = exam_form_status;
      document.getElementById("editModal").style.display = "flex";
    }
    function closeModal() {
      document.getElementById("editModal").style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == document.getElementById("editModal")) {
        closeModal();
      }
    }
      // Search Function
      function searchTable() {
        let input = document.getElementById("searchInput").value.toUpperCase();
        let table = document.getElementById("recordsTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) { // skip table header
          let td = tr[i].getElementsByTagName("td")[0]; // first column = PRN No
          if (td) {
            let txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(input) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }       
        }
      }
</script>


</body>
</html>
<?php
}
$conn->close();
?>
