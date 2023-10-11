
<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'fruts', 'fruts lena hai', current_timestamp()), (NULL, 'mango ', 'lena hai bazar se abhi ke abhi', current_timestamp());
$insert=false;
$update=false;
$delete=false;
// Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset( $_POST['snoEdit'])){
  // Update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

  // Sql query to be executed
  $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
}
else{
    echo "We could not update the record successfully";
}
}
else{

  $title = $_POST["title"];
  $description = $_POST["description"];

  // sql query to be executed
  $sql = "INSERT INTO `notes` (`title`, `description`, `tstamp`) VALUES ('$title', '$description', current_timestamp())";
  $result = mysqli_query($conn, $sql);

  // add notes 
  if ($result) {
    // echo "record file has been inserted <br>";
    $insert = true;
  } else {
    echo "not inserted".mysqli_error($conn);
  }
  
}
}



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faizi Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#myTable').DataTable();
      });
    </script>
  </head>
  <body>
<!-- start modal -->
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editBackdropLabel">Update Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                      <form action="/crud/index.php" method="post">
                        <input type="hidden" name='snoEdit' id='snoEdit'>
                        <div class="mb-3">
                          <label for="title" class="form-label">Note Title</label>
                          <input type="text" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="title">
                        </div>
                        <div class="mb-3">
                          <label for="description" class="form-label">Description</label>
                          <textarea name="descriptionEdit" id="descriptionEdit" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" >Update Note</button>
                      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Faizi Notes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      <?php
      if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success !</strong> Your Note has been Successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
       ?>

      <?php
      if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success !</strong> Your Note has been deleted Successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
       ?>

      <?php
      if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success !</strong> Your Note has been updated Successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
       ?>

      <!-- star container section  -->
      <div class="container">
       <div class="row">
        <div class="col-lg-8 mx-auto my-3">
            <div class="card">
                <h3 class="my-2 mx-auto">Add a Note</h3>
                <hr>
                <div class="card-body">
                    <form action="/crud/index.php" method="post">
                        <div class="mb-3">
                          <label for="title" class="form-label">Note Title</label>
                          <input type="text" name="title" class="form-control" id="title" aria-describedby="title">
                        </div>
                        <div class="mb-3">
                          <label for="description" class="form-label">Description</label>
                          <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" >Add Note</button>
                      </form>
                </div>
            </div>
        </div>
       </div>
      </div>
      <!-- end container section  -->

      <!-- star container section  -->
      <div class="container my-3">
        <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <table id="myTable" class="table">
                    <thead>
                      <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $sql = "SELECT * From `notes`";
                      $result = mysqli_query($conn, $sql);
                      $sno=0;
                      while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno+1;
                        echo " <tr>
                        <th scope='row'>". $sno ."</th>
                        <td>". $row['title'] ."</td>
                        <td>". $row['description'] ."</td>
                        <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
                        </tr>";
                      } 
                      
                      ?>
                    </tbody>
                  </table>
                  <hr>
                </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- end container section  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit",);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value =title;
          descriptionEdit.value =description;
          snoEdit.value = e.target.id;
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
    </script>
  </body>
</html>