<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<?php

if (isset($_GET['now'])) {
    echo "<script>alert('Sukses!');window.location='individual.php?page=paid';</script>";
    exit;
}

?>
<!-- Content Header (Page header) -->


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Info:</h5>
                    Riwayat Reservasi yang Aktif dan Sudah Berakhir
                </div>



                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="m-0">Reservasi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id='example1'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Tiket</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $conn = connect()->query("SELECT *, booked.id as id, payment.date as pd FROM `booked` INNER JOIN payment ON booked.payment_id = payment.id INNER JOIN schedule ON schedule.id = booked.schedule_id  WHERE payment.passenger_id = '$user_id' ORDER BY booked.id DESC");
                                $sn = 0;
                                while ($row = $conn->fetch_assoc()) {
                                    $fullname = getRouteFromSchedule($row['schedule_id']);
                                    $id = $row['id'];
                                    $sn++;
                                    echo "<tr>
                                    <td>$sn</td>
                                    <td>" . $row['code'] . "</td>
                                    <td>" . $row['date'] . "</td>
                                    <td>" . ((isScheduleActive($row['schedule_id']) ? '<span class="text-bold text-success">Aktif' : '<span class="text-bold text-danger">Sudah Berakhir')) . "</span></td>
                                    <td>
                                    <button type='button' class='btn btn-primary' data-toggle='modal'
                                    data-target='#view$id'>
                                    Detail
                                </button>
                                    </td>

                                    </tr>";
                                ?>
                                <div class="modal fade" id="view<?php echo $id ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Reservasi untuk <?php echo getTrainName($row['train_id']) . " " . $fullname;?>
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <p><b>Fasilitas :</b>
                                                    <?php echo getTrainName($row['train_id']);
                                                        ?>
                                                </p>
                                                <p><b>Tanggal Pembayaran :</b>
                                                    <?php echo ($row['pd']);
                                                        ?>
                                                </p>
                                                <p><b>Total Pembayaran :</b> IDR
                                                    <?php echo ($row['amount']);
                                                        ?>
                                                </p>
                                                <p><b>Nomor Pembayaran :</b>
                                                    <?php echo ($row['ref']);
                                                        ?>
                                                </p>
                                                <?php
                                                     $fet = querySchedule('future');
                                                     $msg = "";
                                                     $output = "<option value=''>Choose One Or Skip To Leave As It Is</option>";
                                                     if ($fet->num_rows < 1) $msg = "<span class='text-danger'>No Upcoming Schedules Yet</span>";
                            while ($fetch = $fet->fetch_assoc()) {
    //Check if the current date is same with Database scheduled date
    $db_date = $fetch['date'];
    if ($db_date == date('d-m-Y')) {
        //Oh yes, so what should happen?
        //Check for the time. If there is still about an hour left, proceed else, skip this data
        $db_time = $fetch['time'];
        $current_time = date('H:i');
        if ($current_time >= $db_time) {
            continue;
        }
    }
    $fullname =  getRoutePath($fetch['route_id']);
    $datetime = $fetch['date'];
    $output .= "<option value='$fetch[id]'>$fullname - $datetime</option>";
                            };
                                                   ?>

                                                <!-- Start -->


                                                <!-- End -->
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <?php
                                }
                                    ?>
                            </tbody>
                        </table>


                    </div>

                    <br />
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<?php 
if (isset($_POST['modify'])){

    $pk = $_POST['pk'];
    $s = $_POST['s'];
    $db = connect();
    $sql = "UPDATE booked SET schedule_id = '$s' WHERE id = '$pk';";
    // die($sql);
    $query = $db->query($sql);
    if ($query){
        alert("Modification Saved");
        load($_SERVER['PHP_SELF']."?page=paid");
        
    }else{
        alert("Error Occurred While Trying To Save.");
    }
}

?>