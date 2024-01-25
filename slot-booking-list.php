<?php 
    session_start();
    require_once(dirname(__FILE__) . '\DatabaseClass.php');

    // try to conenct with db
    $database = new DatabaseClass();

    // list fetche
    $results = [];
    $results = $database->slotBookingDataFetch();

    // option fetch
    $students = $database->dataFetch('students');
    $games = $database->dataFetch('games');
    $slots = $database->dataFetch('slots');


    // delete operation
    if(isset($_GET['operation']) && $_GET['operation'] == 'delete'){

        $response = $database->delete($_GET['id'],$_GET['table']);

        if($response){

            $_SESSION["success"] = "Deleted Successfully";
            header('Location: http://localhost/web_internet/slot-booking-list.php');
            
        } else {
            $_SESSION["error"] = "Something went wrong during data save!";
        }

    }

    if(isset($_POST['student_id'])){

        if(!empty($_POST['student_id'])){

            $response = $database->slotBookinStore($_POST);

            // switch ($response) {
            //     case 'create':
            //         $_SESSION["success"] = "Created Successfully!";
            //         break;
            //     case 'exist':
            //         $_SESSION["error"] = "Slot already booked!";
            //       break;
            //     case 'error':
            //         $_SESSION["error"] = "Something went wrong during data save!";
            //       break;
            // }
            // header('Location: http://localhost/web_internet/slot-booking-list.php');


            switch ($response) {
                case 'create':
                    header('Location: http://localhost/web_internet/slot-booking-list.php?status=create');
                    break;
                case 'exist':
                    header('Location: http://localhost/web_internet/slot-booking-list.php?status=exist');
                  break;
                case 'error':
                    header('Location: http://localhost/web_internet/slot-booking-list.php?status=error');
                  break;
            }


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
        <div class="col-12">

            <?php if(isset($_GET['status']) && $_GET['status'] == 'error'){ ?>
                <div class="alert alert-danger" role="alert">Something went wrong!</div>
            <?php } ?>

            <?php if(isset($_GET['status']) && $_GET['status'] == 'exist'){ ?>
                <div class="alert alert-danger" role="alert">Slot Already exist!</div>
            <?php } ?>

            <?php if(isset($_GET['status']) && $_GET['status'] == 'create'){ ?>
                <div class="alert alert-success" role="alert">Created Successfully!</div>
            <?php } ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Slot booking list</h5>
                </div>
                <form action="" method="post">      
                    <div class="card-body gap-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Student <small class="text-danger">(required)</small></label>
                                    <select name="student_id"  class="form-control input-md" required>
                                        <option value="">Please select</option>
                                        <?php if(count($students) > 0){ foreach($students as $index => $student) { ?>
                                            <option value="<?php echo $student['id'] ?>"><?php echo $student['name'] ?> (<?php echo $student['student_id'] ?>)</option>
                                        <?php } } ?>
                                    </select>
                                 </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Game <small class="text-danger">(required)</small></label>
                                    <select name="game_id"  class="form-control input-md" required>
                                        <option value="">Please select</option>
                                        <?php if(count($games) > 0){ foreach($games as $index => $game) { ?>
                                            <option value="<?php echo $game['id'] ?>"><?php echo $game['name'] ?></option>
                                        <?php } } ?>
                                    </select>
                                 </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Slot <small class="text-danger">(required)</small></label>
                                    <select name="slot_id" class="form-control input-md" required>
                                        <option value="">Please select</option>
                                        <?php if(count($slots) > 0){ foreach($slots as $index => $slot) { ?>
                                            <option value="<?php echo $slot['id'] ?>"><?php echo $slot['name'] ?></option>
                                        <?php } } ?>
                                    </select>
                                 </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Booking date <small class="text-danger">(required)</small></label>
                                    <input type="date" name="date" class="form-control input-md" required>
                                 </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group my-2">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="form-control btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    Booking list
                </div>
                <div class="card-body  table-responsive p-0">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Game</th>
                                <th>Date</th>

                                <th>Slot Name</th>
                                <th>Start</th>
                                <th>End</th>

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
                                <td><?php echo $row['student_name'] ?></td>
                                <td><?php echo $row['game_name'] ?></td>
                                <td><?php echo $row['date'] ?></td>

                                <td><?php echo $row['slot_name'] ?></td>
                                <td><?php echo $row['slot_start_time'] ?></td>
                                <td><?php echo $row['slot_end_time'] ?></td>
                                <td>
                                    <a href="slot-booking-list.php?operation=delete&id=<?php echo $row['id'] ?>&table=slot_bookings" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php 
                                    } 
                                } else {
                            ?>
                            <tr>
                                <td colspan="8">Empty table!</td>
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

