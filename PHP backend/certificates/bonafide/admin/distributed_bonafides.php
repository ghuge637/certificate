<style>      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid black;
            padding: 8px 5px;
            text-align: center;
        }

        .table th {
            background-color:rgba(47, 48, 50, 0.26);
        }
        .btn{
            padding : 5px 8px;
            border-radius: 8px;
            font-size: 15px;
            background-color: white;
            color: black;
            border: 1px solid Black;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .btn:hover:hover{
            cursor: pointer;
            /* box-shadow : 0 2px 0px ; */
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.7);  

        }
</style>


<center><H2> Distributed Bonafides</H2></center>
<a href="admin_portal.php"><button class="btn">Back</button></a>
<?php
                        include('../../db_conn.php');
                        
                        $sql = "SELECT students.prnno, students.studname, students.studdob, students.branch, students.year, distributed_bonafides.reason,distributed_bonafides.distributed_date
                                FROM distributed_bonafides 
                                JOIN students ON distributed_bonafides.prnno = students.prnno";  //base on selected veriable display requestes
                        $check_result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($check_result) > 0) {

                            echo "<table class='table'>
                                    <thead>
                                        <tr>
                                            <th>PRN No</th>
                                            <th>Student Name</th>
                                            <th>Date of Birth</th>
                                            <th>Branch</th>
                                            <th>Year</th>
                                            <th>Reason</th>
                                            <th>distributed Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                            while ($row = mysqli_fetch_assoc($check_result)) { 
                                echo "<tr>
                                        <td>" . $row['prnno'] . "</td>
                                        <td>" . $row['studname'] . "</td>
                                        <td>" . $row['studdob'] . "</td>
                                        <td>" . $row['branch'] . "</td>
                                        <td>" . $row['year'] . "</td>
                                        <td>" . $row['reason'] . "</td> 
                                        <td>" . $row['distributed_date'] . "</td>";
            
                            }

                                                    
                                        echo "</tr>";
                            
                            echo "</tbody></table>";
}

?>