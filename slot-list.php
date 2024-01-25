<?php 
    session_start();
    require_once(dirname(__FILE__) . '\DatabaseClass.php');

    // try to conenct with db
    $database = new DatabaseClass();

    $results = [];
    $results = $database->dataFetch('slots');

    // delete operation
    if(isset($_GET['operation']) && $_GET['operation'] == 'delete'){

        $response = $database->delete($_GET['id'],$_GET['table']);

        if($response){

            $_SESSION["success"] = "Deleted Successfully";
            header('Location: http://localhost/web_internet/slot-list.php');
            
        } else {
            $_SESSION["error"] = "Something went wrong during data save!";
        }
        
    }

    // other 
    include 'header.php';
    include 'sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light pt-3 pb-2 mb-4 border-bottom">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">Games List</a> -->
        </div>
    </nav>

    <div class="row">
        <div class="col-6">

            <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error'] ?>
            </div>
            <?php } ?>

            <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success'] ?>
            </div>
            <?php } ?>


            <div class="card">
                <div class="card-header">
                    Slot list
                    <div class="card-tools">
                        <a href="slot-create.php" class="btn btn-sm btn-success">Create</a>
                    </div>
                </div>
                <div class="card-body  table-responsive p-0">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(count($results) > 0){ 
                                    foreach($results as $index => $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['start_time'] ?></td>
                                <td><?php echo $row['end_time'] ?></td>
                                <td>
                                    <a href="slot-edit.php?id=<?php echo $row['id'] ?>&name=<?php echo $row['name'] ?>&start_time=<?php echo $row['start_time'] ?>&end_time=<?php echo $row['end_time'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="slot-list.php?operation=delete&id=<?php echo $row['id'] ?>&table=slots" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php 
                                    } 
                                } else {
                            ?>
                            <tr>
                                <td colspan="5">Empty table!</td>
                            </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

<?php 
    include 'footer.php';
    session_unset();
?>

