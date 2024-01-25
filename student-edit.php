<?php 
    session_start();
    require_once(dirname(__FILE__) . '\DatabaseClass.php');

    // try to conenct with db
    $database = new DatabaseClass();

    if(isset($_POST['id']) && isset($_POST['name'])){
        if(!empty($_POST['name'])  && !empty($_POST['name'])){
            $database->studentEdit($_POST);
        }
    }

    // other 
    include 'header.php';
    include 'sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light pt-3 pb-2 mb-4 border-bottom">
        <div class="container-fluid"></div>
    </nav>
    <div class="row g-4">
        <div class="col-lg-12">

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
                    <h5 class="card-title">Edit slot</h5>
                </div>
                <form action="" method="post">      
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">      
                    <div class="card-body gap-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Name <small class="text-danger">(required)</small></label>
                                    <input type="text" name="name" value="<?php echo $_GET['name'] ?>" class="form-control input-md" placeholder="E.g. Morning" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Student ID <small class="text-danger">(required)</small></label>
                                    <input type="number" name="student_id" value="<?php echo $_GET['student_id'] ?>"  class="form-control input-md" placeholder="E.g. 2019100010027" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Batch <small class="text-danger">(required)</small></label>
                                    <input type="text" name="batch" value="<?php echo $_GET['batch'] ?>"  class="form-control input-md" placeholder="E.g. 5th" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Department <small class="text-danger">(required)</small></label>
                                    <input type="text" name="department" value="<?php echo $_GET['department'] ?>"  class="form-control input-md" placeholder="E.g. CSE" required>
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
</main>

<?php 
    include 'footer.php';
    session_unset();
?>

