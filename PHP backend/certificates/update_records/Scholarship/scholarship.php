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
  <title>Scholarship Update</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; background:#f7f7f7; }
    table { border-collapse: collapse; width: 100%; background: #fff; }
    th, td { padding: 10px 12px; border: 1px solid #ddd; text-align: left; }
    th { background: #0073e6; color: white; }
    tr:nth-child(even) { background: #f2f6fb; }
    .btn { padding: 6px 10px; border: none; border-radius: 4px; cursor: pointer; }
    .btn-edit { background: #ff9800; color: white; }
    /* Modal */
     /* Background overlay */
.custom-modal {
  display: none; 
  position: fixed;
  z-index: 999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

/* Modal box */
.custom-modal-content {
  background: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  position: relative;
  animation: fadeIn 0.3s ease-in-out;
}

/* Close button */
.custom-close {
  position: absolute;
  top: 12px;
  right: 15px;
  font-size: 22px;
  font-weight: bold;
  color: #555;
  cursor: pointer;
}

.custom-close:hover {
  color: #000;
}

/* Form styling */
.custom-form label {
  display: block;
  margin-top: 12px;
  font-weight: bold;
  color: #2c3e50;
}

.custom-form input,
.custom-form select {
  width: 100%;
  padding: 8px 10px;
  margin-top: 6px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
  box-sizing: border-box;
}

.custom-form input:focus,
.custom-form select:focus {
  border-color: #2980b9;
  outline: none;
  box-shadow: 0 0 6px rgba(41,128,185,0.3);
}

/* Save button */
.btn-save {
  margin-top: 18px;
  width: 100%;
  padding: 10px;
  background: #2980b9;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.btn-save:hover {
  background: #1c5980;
}

/* Animation */
@keyframes fadeIn {
  from {opacity: 0; transform: scale(0.9);}
  to {opacity: 1; transform: scale(1);}
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

    </style>
  
</head>
<body>
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
    $sql = "SELECT prnno, total_fees, paid_fees, schlorship_form_status, first_installment, second_installment FROM $table";
    $result = $conn->query($sql);

    if($table == "first_year"){echo "<H1>Frirst Year Records</H1>";}
    elseif($table == "second_year"){echo "<H1>Second Year Records</H1>";}
    elseif($table == "third_year"){echo "<H1>Third Year Records</H1>";}
    else{echo "<H1>Fourth Year Records</H1>";}

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
          <th>Total Fees</th>
          <th>Paid Fees</th>
          <th>Form Status</th>
          <th>First Installment</th>
          <th>Second Installment</th>
          <th>remaining</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php  while($row=$result->fetch_assoc()): $remaining = $row['total_fees'] - $row['paid_fees'] - $row['first_installment'] - $row['second_installment'] ?>
          <tr>
            <td><?= htmlspecialchars($row['prnno']); ?></td>
            <td><?= htmlspecialchars($row['total_fees']); ?></td>
            <td><?= htmlspecialchars($row['paid_fees']); ?></td>
            <td><?= htmlspecialchars($row['schlorship_form_status']); ?></td>
            <td><?= htmlspecialchars($row['first_installment']); ?></td>
            <td><?= htmlspecialchars($row['second_installment']); ?></td>
            <td><?= htmlspecialchars($remaining); ?></td>
            <td>
              <button class="btn btn-edit"
                onclick="openEditModal(
                  '<?= $row['prnno']; ?>',
                  '<?= htmlspecialchars($row['total_fees']); ?>',
                  '<?= htmlspecialchars($row['paid_fees']); ?>',
                  '<?= htmlspecialchars($row['schlorship_form_status']); ?>',
                  '<?= htmlspecialchars($row['first_installment']); ?>',
                  '<?= htmlspecialchars($row['second_installment']); ?>'
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
<div id="editModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="custom-close" onclick="closeModal()">&times;</span>
    <h3>Edit Record</h3>
    <form method="POST" class="custom-form" action="update.php">
        <input type="hidden" name="prnno" id="edit_prnno">
        <input type="hidden" name="table" id="table" value="<?php echo $table; ?>">

        <label>Total Fees:</label>
        <input type="text" name="total_fees" id="edit_total_fees" required>

        <label>Paid Fees:</label>
        <input type="text" name="paid_fees" id="edit_paid_fees" required>

        <label>Scholarship Form:</label>
        <select name="schlorship_form_status" id="edit_scholarship">
            <option value="Submitted">Submitted</option>
            <option value="Not Submitted">Not Submitted</option>
        </select>

        <label>First Installment:</label>
        <input type="text" name="first_installment" id="edit_first" required>

        <label>Second Installment:</label>
        <input type="text" name="second_installment" id="edit_second" required>

        <button type="submit" class="btn-save">Save Changes</button>
    </form>
  </div>
</div>


  <script>

    function openEditModal(prnno, total_fees, paid_fees, schlorship_form_status, first_installment, second_installment) {
    document.getElementById("edit_prnno").value = prnno;
    document.getElementById("edit_total_fees").value = total_fees;
    document.getElementById("edit_paid_fees").value = paid_fees;
    document.getElementById("edit_scholarship").value = schlorship_form_status;
    document.getElementById("edit_first").value = first_installment;
    document.getElementById("edit_second").value = second_installment;
    document.getElementById("editModal").style.display = "block";
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
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
