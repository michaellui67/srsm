<?php
if (!isset($file_access)) die("Direct File Access Denied");
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
                                List Masukan</h3>
                        </div>

                        <div class="card-body">

                            <table id="example1" style="align-items: stretch;"
                                class="table table-hover w-100 table-bordered table-striped<?php //
                                                                                                                                            ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                        <th style="width: 30%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row = $conn->query("SELECT * FROM `feedback` order by response ASC");
                                    if ($row->num_rows < 1) echo "No Feedbacks Yet";
                                    $sn = 0;
                                    while ($fetch = $row->fetch_assoc()) {
                                        $id = $fetch['id'];
                                    ?>

                                    <tr>
                                        <td><?php echo ++$sn; ?></td>
                                        <td><?php echo $fullname = getIndividualName($fetch['user_id']); ?></td>
                                        <td><?php echo $fetch['message']; ?></td>
                                        <td><?php echo $response = $fetch['response']; ?></td>
                                        <td>
                                            <form method="POST">
                                                <?php
                                                    if ($response == NULL) {
                                                    ?>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#edit<?php echo $id ?>">
                                                    Balas
                                                </button>
                                                <?php
                                                    } else {
                                                        echo "No action";
                                                    }
                                                    ?>


                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="edit<?php echo $id ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Balasan untuk masukan oleh <?php echo $fullname; ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">
                                                        <input type="hidden" class="form-control" name="id"
                                                            value="<?php echo $id ?>" required id="">
                                                        <p>Balasan : <textarea class="form-control" name="reply" required
                                                                minlength="3"></textarea>

                                                        <p>

                                                            <input class="btn btn-info" type="submit" value="Submit"
                                                                name='send_reply'>
                                                        </p>
                                                    </form>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Tutup</button>
                                                    </div>
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
<?php

if (isset($_POST['send_reply'])) {
    $reply = $_POST['reply'];
    $id = $_POST['id'];
    if (replyTo($id, $reply)) {
        echo "<script>alert('Sukses!');window.location='admin.php'</script>";
    } else {
        echo "<script>alert('Error!');window.location='admin.php'</script>";
    }
}

?>