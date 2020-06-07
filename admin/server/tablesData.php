<?php
include "dbConnect.php";
function tablesData($db){
    $query = "SELECT `picture`, `username`, `email`,`date`, `plus` FROM `users`";
    $result  = mysqli_query($db, $query);
    $tablesHtml = '';
    while($row = mysqli_fetch_row($result)) {
        if ($row['4'] == "0"){$row['4'] = "No";}else{$row[4] = "Yes";}
        $tablesHtml = $tablesHtml.'
                  <tr>
                      <td><img src="../user-AccountImages/'.$row['0'].'" width="70rem%;height:auto;border-radius:30px" alt="Avatar"></td>
                      <td>'.$row['1'].'</td>
                      <td>'.$row['2'].'</td>
                      <td>'.$row['3'].'</td>
                      <td>'.$row['4'].'</td>
                  </tr>';

    }
    return $tablesHtml;
}
$tablesHtml = tablesData($db);