<?php
if (!isset($file_access))
    die("Direct File Access Denied");
$source = 'train';
$me = "?page=$source";
?>

<div class="content">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                Cari</h3>
                            <div class='float-right'>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#add">
                                    Cari
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php
                            if (isset($_POST['submit'])) {
                                $ticket = $_POST['ticket'];
                                $conn = connect();
                                //Check if train exists
                                $check = $conn->query("SELECT * FROM booked WHERE code = '$ticket' ");
                                if ($check->num_rows != 1) {
                                    alert("Invalid Ticket Number Provided");
                                } else {
                                    $id = $check->fetch_assoc()['id'];
                                    $row = $conn->query("SELECT schedule.route_id as route_id, schedule.id as schedule_id, passenger.name as fullname, passenger.email as email, passenger.phone as phone, passenger.loc as loc, payment.amount as amount, payment.ref as ref, payment.date as payment_date, schedule.train_id as train_id, booked.code as code, booked.no as no, booked.class as class, booked.seat as seat, schedule.date as date FROM booked INNER JOIN schedule on booked.schedule_id = schedule.id INNER JOIN payment ON payment.id = booked.payment_id INNER JOIN passenger ON passenger.id = booked.user_id WHERE booked.id = '$id'")->fetch_assoc();
                                    echo '<table id="example1" style="align-items: stretch;" class="table table-hover w-100 table-bordered table-striped">';
                                    echo "
                                    <tr><td colspan='2' class='text-center'><img src='uploads/$row[loc]' class='img img-thumbnail' width='200' height='200'></td></tr>
                                    <tr><th>Nama</th><td>$row[fullname]</td></tr>
                                    <tr><th>Email</th><td>$row[email]</td></tr>
                                    <tr><th>Nomor HP</th><td>$row[phone]</td></tr>
                                    <tr><th>Kode Tiket</th><td>$row[code]</td></tr>
                                    <tr><th>Tanggal</th><td>" . date("D d, M Y", strtotime($row['date'])) . " </td></tr>
                                    <tr><th>Jumlah Pembayaran</th><td>IDR $row[amount]</td></tr>
                                    <tr><th>Tanggal Pembayaran</th><td>$row[payment_date]</td></tr>
                                    <tr><th>Referensi Pembayaran</th><td>$row[ref]</td></tr>
                                    <tr><th>Acara</th><td>" . getRouteName($row['route_id']) . ' (' . getRouteFromSchedule($row['schedule_id']) . ')' . "</td></tr>
                                    <tr><th>Fasilitas</th><td>" . getTrainName($row['train_id']) . "</td></tr>
                                    </table>";
                                }
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>
</section>
</div>

<div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <h4 class="modal-title">Cari Customer dengan Nomor Tiket
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <table class="table table-bordered">
                        <tr>
                            <th>Masukkan Nomor Tiket</th>
                            <td><input type="text" class="form-control" name="ticket" required minlength="3" id=""></td>
                        </tr>
                        <td colspan="2">

                            <input class="btn btn-info" type="submit" value="Submit" name='submit'>
                        </td>
                        </tr>
                    </table>
                </form>



            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>