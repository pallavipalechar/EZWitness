<?php
require_once("database.php");?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>

          <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <!-- <link rel="stylesheet" href="assets/css/animate.css"> -->
         <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
       <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <!-- <link rel="stylesheet" href="assets/css/animate.css"> -->
        
    </head>
    <style>
      
      </style>
    <body>
    <form action="" method="POST" id="foo" enctype="multipart/form-data">
        <script type="text/javascript">
            function shiftchange(){

                                       // setup some local variables
                                      var $form = $("#foo");

                                      // Let's select and cache all the fields
                                      var $inputs = $form.find("input, select, button, textarea");

                                      // Serialize the data in the form
                                      var serializedData = $form.serialize();

                                      $.ajax({
                                        type:'POST',
                                        data: serializedData,
                                        url: "update_shiftchange.php", success: function(result){
                                        alert(result);
                                        document.location.reload(true);
                                      }});
                              }
        </script>
        <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
       // $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
    	
<div class="wrapper">

    <?php include("left.php");?>
    <div class="container">


    <div class="floatss">
        
                        <table id='datatable1' class="table1 display responsive nowrap ">
                          <tr >
                            <td>
                                <label class="labe_Change">Change Shift</label>
                                <select name='shift_name_change' class="Selct_btn">";
                                    <?php $sqlshift = "select * from shift_details" ;
                                    $resultshift = mysqli_query($con, $sqlshift);
                                    while ($rowshift = mysqli_fetch_assoc($resultshift)) 
                                    {
                                        echo "<option value='".$rowshift['shift_name']."'>".$rowshift['shift_name']."</option>
                                        ";
                                    }
                                     ?>
                                </select>
                                    <input type="button" style="background-color: #034f84;" name="btn_shiftchange" class="btn_sendmailbtn" onclick="shiftchange()" value="Submit">
                            </td>
                        </tr>
                    </table>
                </div>
                <style type="text/css">
                    .labe_Change {
                          font-size: 21px;
                          color: white;
                          padding-right: 9px;
                          padding-left: 174px;
                          font-family: inherit;
                      }
                    .Selct_btn {
                        border-radius: 6px;
                        font-size: 19px;
                        width: 142px;
                        height: 30px;
                        text-align: center;
                        font-weight: 600;
                    }
                    .btn_sendmailbtn{
                    padding: 7px 12px;
                    border-radius: 10px;
                    margin-top: 6px;
                    color: black;
                    font-size: 15px
                    font-weight:800;
                }
                .floatss {
    position: fixed;
    width: 100%;
    height: auto;
    bottom: 0;
    right: 0;
    left: 0; /* Ensure it spans the entire width */
    background-color: #363434;
    padding: 10px;
    box-shadow: 2px 2px 3px #999;
    overflow: auto;
    z-index: 1000; /* Ensure it's above other content */
}

.my-floatss {
    margin-top: 10px;
}


          </style>

    <br><center><h2>Shift Assign</h2></center><br>
    <button class="btn btn-primary" style="margin-left: 20px;"><a href="shift_details.php">Add Shift</a></button>
<br><br>
             
    <!--<div class="form">
    <label>Employee ID</label><br>
    <input type="text" name="emp_id" class="textfd"><br>
    <label>Employee Name</label><br>
    <input type="text" name="emp_name" class="textfd"><br> 
    <input type="submit" style="background-color: #034f84;" class="btn btn-primary" name="btn_assign" value="Search"> 
    <input type="submit" style="background-color: #034f84;" value="Reset" class="disable-text-selection" name="reset">
              </div> -->
  <style>
 .textfd{
  width: 45%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
  width: 22%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
               input[type="submit"] {
    background: #ea4c4c;
}

input[type=button] {
  width: 15%;
  background-color: #ea4c4c;
  color: white;
  height: 30px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=submit]:hover {
  background-color: #ea4c4c;
}

.form{
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>

 <label><h4>&nbsp;&nbsp;&nbsp;Search</h4></label>
                <input id="myInput" type="text" placeholder="search here">
    <table class="table table-striped thead-dark table-bordered table-hover" id="pager"  style="margin-left: 15px;">
      <thead>
            <tr>
                <th class="disable-text-selection">Select All<br/> <input type="checkbox" onClick="toggle(this)" /></th>
                <th>Emp ID</th>
                <th>Emp Name</th>
                <th>Dep ID</th>
                <th>Department</th>
                <th>Shift</th>
            </tr>
</thead>
<tbody id="myTable"> 
            <?php
            if (isset($_POST['reset'])) 
            {
             

               $sql = "select * from emp_details";
            }

            if (isset($_POST['btn_assign'])) 
            {
              

                $emp_id=$_POST['emp_id'];
                $emp_name=$_POST['emp_name'];
               $sql = "select * from emp_details where eid='$emp_id' or fname='$emp_name'";
            }
            else{
                $sql = "select * from emp_details ORDER BY fname";
            }
            $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
?>
                  <tbody id="myTable"> 
                  <?php
                    echo "<tr>";
                    echo '<td class="disable-text-selection"><input type="checkbox" name="check_list[]" value="'.$row['eid'].'"></td>';
                    echo "<td>".$row['eid']."</td>";
                    echo "<td>".$row['fname']."</td>";
                     echo "<td>".$row['dep_id']."</td>";
                    echo "<td>".$row['dep_description']."</td>";
                   
                    echo "<td>".$row['shift']."</td>";
                    ?>  
                    </tr> 
                    </tbody> 
            <div class="modal fade" id="modal_update<?php echo $row['s']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                    
                  <h3 class="modal-title">Are you sure want to approve?</h3>
                </div>
                <form method="POST" enctype="multipart/form-data">
                 <input type="hidden" id="getID" name="ID" value="<?php echo $row['s']?>">
                 <input type="hidden" name="n" value="<?php echo $row['fname'] ?>">
                 <input type="hidden" name="dt" value="<?php echo $row['start'] ?>">
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  <input type="submit" id="submit" name="approve"  value="Yes" class="btn btn-danger" />
                 </div>
                 </form>
                 </div>
                 </div>
                 </div>
                 
                
<?php
}
            ?>

        </table>
         <div id="pageNavPosition" class="pager-nav"></div>
          
         </div></div>
<script>  

           
function toggle(source) {
  checkboxes = document.getElementsByName('check_list[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

</script>

<script src="assets/js/jquery-1.10.2.js"></script>
         <!-- Bootstrap Js CDN -->
    <script src="assets/js/bootstrap.min.js"></script>

         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
             $('sams').on('click', function(){
                 $('makota').addClass('animated tada');
             });
         </script>
         </form>
    </body>
</html>
<style type="text/css">
  #content {
    padding: 1px;
    min-height: auto;
    transition: all 0.3s;
    width: 100%;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 21%;
}
.table1 {
    width: 100%;
    max-width: 100%;
    margin-bottom: 2%;
}
</style>
 <script>
/* eslint-env browser */
/* global document */

function Pager(tableName, itemsPerPage) {
    'use strict';

    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;

    this.showRecords = function (from, to) {
        let rows = document.getElementById(tableName).rows;

        // i starts from 1 to skip table header row
        for (let i = 1; i < rows.length; i++) {
            if (i < from || i > to) {
                rows[i].style.display = 'none';
            } else {
                rows[i].style.display = '';
            }
        }
    };

    this.showPage = function (pageNumber) {
        if (!this.inited) {
            // Not initialized
            return;
        }

        let oldPageAnchor = document.getElementById('pg' + this.currentPage);
        oldPageAnchor.className = 'pg-normal';

        this.currentPage = pageNumber;
        let newPageAnchor = document.getElementById('pg' + this.currentPage);
        newPageAnchor.className = 'pg-selected';

        let from = (pageNumber - 1) * itemsPerPage + 1;
        let to = from + itemsPerPage - 1;
        this.showRecords(from, to);

        let pgNext = document.querySelector('.pg-next'),
            pgPrev = document.querySelector('.pg-prev');

        if (this.currentPage == this.pages) {
            pgNext.style.display = 'none';
        } else {
            pgNext.style.display = '';
        }

        if (this.currentPage === 1) {
            pgPrev.style.display = 'none';
        } else {
            pgPrev.style.display = '';
        }
    };

    this.prev = function () {
        if (this.currentPage > 1) {
            this.showPage(this.currentPage - 1);
        }
    };

    this.next = function () {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    };

    this.init = function () {
        let rows = document.getElementById(tableName).rows;
        let records = (rows.length - 1);

        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    };

    this.showPageNav = function (pagerName, positionId) {
        if (!this.inited) {
            // Not initialized
            return;
        }

        let element = document.getElementById(positionId),
            pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal pg-prev">&#171;</span>';

        for (let page = 1; page <= this.pages; page++) {
            pagerHtml += '<span id="pg' + page + '" class="pg-normal pg-next" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';
        }

        pagerHtml += '<span onclick="' + pagerName + '.next();" class="pg-normal">&#187;</span>';

        element.innerHTML = pagerHtml;
    };
}



//
let pager = new Pager('pager', 10);

pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
  <style type="text/css">
                .btn_week
                {    
                    width: 20%;
                    height: 95px;
                    padding: 10px;
                    margin: 1%;
                    border: 2px;
                    border-color: black;
                    font-weight: 900;
                    font-size: 16px;
                    box-shadow: darkkhaki;
                }
                .pager-nav {
    margin: 16px 0;
}
.pager-nav span {
    display: inline-block;
    padding: 4px 8px;
    margin: 1px;
    cursor: pointer;
    font-size: 14px;
    background-color: #FFFFFF;
    border: 1px solid #e1e1e1;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}
.pager-nav span:hover,
.pager-nav .pg-selected {
    background-color: #f9f9f9;
    border: 1px solid #CCCCCC;
}
.pager-nav {
    margin: 1px 0;
    position: relative;
    top: -10%;
}
@media only screen and (max-width: 600px) {
    .pager-nav {
        margin: 1px 0;
        position: relative;
        top: -6%;
    }

}

            </style>
<style>
    body {
        overflow-x: hidden; 
        margin: 0; 
        padding: 0; 
    }
    .container {
        max-width: 100%;
        overflow-x: hidden; 
        margin: 0; 
        padding: 0; 
    }
</style>

