<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<?php

$me = $_SESSION['user_id'];

?>

<div class="content">



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><b>Reservasi Fasilitas Stadion Malang</b></h3>
                </div>
                <div class="card-body">

                    <table id="example1" style="align-items: stretch;"
                        class="table table-hover w-100 table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fasilitas</th>
                                <th>Foto</th>
                                <th>Tanggal</th>
                                <th>Sesi</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $row = querySchedule('future');
                            if ($row->num_rows < 1) echo "<div class='alert alert-danger' role='alert'>
                            Sorry, There are no schedules at the moment! Please visit after some time.
                          </div>";
                            $sn = 0;
                            while ($fetch = $row->fetch_assoc()) {
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
                                $id = $fetch['id']; ?><tr>
                                <td><?php echo ++$sn; ?></td>
                                <td><?php echo $fullname =  getTrainName($fetch['train_id']);?></td>
                                <td>
                                    <img src="<?php echo $loc = getTrainFoto($fetch['train_id']);?>">
                                </td>
                                <td><?php echo $fetch['date'] ?>
                                </td>
                                <td><?php echo $details = getRouteName($fetch['route_id']) . ' (' . getRouteFromSchedule($fetch['id']) . ')'?>
                                </td>
                                <td><?php
                                $day = date('D', strtotime($fetch['date']));
                                                        if ($day == "Sat" || $day == "Sun") {
                                                            echo $price = 'IDR ' . ($fetch['first_fee']);
                                                        } else {
                                                            echo $price = 'IDR ' . ($fetch['second_fee']);
                                                        }?></td>
                                <td>
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#book<?php echo $id ?>">
                                        Reservasi
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="book<?php echo $id ?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Reservasi untuk <?php echo $fullname;?></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">


                                            <form action="<?php echo $_SERVER['PHP_SELF'] . "?loc=$id" ?>"
                                                method="post">
                                                <p> Apakah anda sudah yakin dengan reservasi ini?
                                                    <br><?php
                                                    echo 'Fasilitas: ' . $fullname;
                                                    ?><br><?php
                                                    echo 'Sesi: ' . $details;?><br>
                                                    <?php
                                                    echo 'Harga: ' . $price;
                                                    ?>
                                                </p>
                                                <input type="hidden" class="form-control" name="id"
                                                    value="<?php echo $id ?>" required>
                                                <input type="hidden" min='1' value="<?php echo (int)filter_var(getRouteName($fetch['route_id']), FILTER_SANITIZE_NUMBER_INT);
                                                    ?>" name="number" class="form-control" required>
                                                <input type="hidden" class="form-control" name="class" value="<?php
                                                        $day = date('D', strtotime($fetch['date']));
                                                        if ($day == "Sat" || $day == "Sun") {
                                                            echo "first";
                                                        } else {
                                                            echo "second";
                                                        }
                                                        ?>" class="form-control" required>
                                                <input type="submit" name="submit" class="btn btn-success"
                                                    value="Submit">

                                            </form>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                <?php
                            }
                                ?>

                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    </form>

</div>