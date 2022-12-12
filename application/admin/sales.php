<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'payment';

?>
<div class="content">



    <div class="row">
        <div class="container-fluid">
            <div class="col-lg-12">


                <div class="card card-success">
                    <div class="card-header border-0">
                        <h3 class="card-title">List Pembayaran</h3>

                    </div>
                    <div class="card-body">
                        <table id='example1' class="table table-striped table-bordered table-hover table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Fasilitas</th>
                                    <th>Acara</th>
                                    <th>Tanggal</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pay = $conn->query("SELECT *, schedule.id as id, schedule.date as date FROM schedule INNER JOIN payment ON schedule.id = payment.schedule_id");
                                $sn = 0;

                                while ($val = $pay->fetch_assoc()) {
                                    $id = $val['id'];
                                    $array = getTotalBookByType($id);
                                    $sn++;
                                    echo "<tr>
                                      <td>" . getTrainName($val['train_id']) . "</td>
                                      <td>" . getRouteName($val['route_id']) . ' (' . getRoutePath($val['route_id']) . ')' . "</td>
                                      <td>" . $val['date'] . "</td>
                                      <td>IDR " . sum($val['id'], 'first') + sum($val['id'], 'second') . "</td>
                                      </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->

            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- /.col -->
</div>
<!-- /.row -->

</div>