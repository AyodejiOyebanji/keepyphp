<?php
require_once("dbcred.php");
$query = "SELECT * FROM note_tb ";
$stmt = $connect->prepare($query);
$stmt->execute();
// to fetch all the notes
$allNotes = mysqli_fetch_all(mysqli_stmt_get_result($stmt));

// to delete a note
if (isset($_POST['delete'])) {
  $note_id = $_POST["note_id"];
  $query = "DELETE FROM note_tb WHERE note_id = ?";
  $del_stmt = $connect->prepare($query);
  $del_stmt->bind_param('i', $note_id);
  $execute = $del_stmt->execute();
  if ($execute) {
    $_SESSION['message'] = "Note deleted";
    $_SESSION['status'] = true;
    header("location:index.php");
  } else {
    $_SESSION['message'] = "Unable to  delete at the moment";
    $_SESSION['status'] = false;
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

  <title>Document</title>
</head>

<body>

  <!-- nav bar starts here -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Note</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <!-- nav bar ends here -->
  <?php
  session_start();
  if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-danger text-center'>" . $_SESSION['message'] . "</div>";
  }
  session_unset()

  ?>

  <form action="process.php" method="post">
    <div class="d-flex justify-content-center mt-5">
      <div class="addSection p-3">
        <input type="text" class="title mb-3 " placeholder="Title" name="title"> <br>
        <textarea class="noteArea" cols="75" rows="auto" placeholder="Take a note............." name="note"></textarea>
        <div class="d-flex justify-content-end mt-3">
          <input type="submit" class="btn btn-primary" value="Add Note" name="submit"> </input>
        </div>

      </div>
    </div>
  </form>



  <!-- to display all the notes -->

  <div class="d-flex justify-content-center" style="display: flex !important;
   flex-wrap: wrap;">
    <?php foreach ($allNotes as $item) : ?>
      <div class="card m-3 " style="width: 18rem;">
      <div>
        
        <h5 class="showtitle text-center " style="font-size:20px; font-weight:500"  ><?= $item[1]?></h5>
        <hr>
      </div>
        
        <p class="p-3" style=" display: inline;
        width:300px;
        overflow: hidden;
        white-space: nowrap; text-overflow: ellipsis;" > <?= $item[2] ?></p>
        <div class="dropdown d-flex justify-content-end">
          <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="material-symbols-outlined">
              more_vert
            </span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <form method="POST">
              <input type="hidden" name="note_id" value="<?= $item[0] ?>" />
              <li class="p-3"> <button name="delete" class="btn btn-danger w-100"> Delete</button> </li>
              
            </form>
            <form action="edit.php" method="POST">
               <input type="hidden" name="note_id" value="<?= $item[0] ?>" /> 
              <li class="p-3"> <button name="edit" class="btn btn-danger w-100" > Edit</button> </li>
              

            </form>

          </ul>
        </div>


      </div>
    <?php endforeach; ?>

  </div>

  





</body>

</html>