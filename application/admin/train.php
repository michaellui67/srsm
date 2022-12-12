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
                                List Fasilitas</h3>
                            <div class='float-right'>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#add">
                                    Tambah Fasilitas
                                </button>
                            </div>
                        </div>

                        <div class="card-body">

                            <table id="example1" style="align-items: stretch;"
                                class="table table-hover w-100 table-bordered table-striped<?php //
                                                                                                                                            ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Fasilitas</th>
                                        <th>Foto</th>
                                        <th style="width: 30%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row = $conn->query("SELECT * FROM train");
                                    if ($row->num_rows < 1) echo "No Records Yet";
                                    $sn = 0;
                                    while ($fetch = $row->fetch_assoc()) {
                                        $id = $fetch['id'];
                                    ?>

                                    <tr>
                                        <td><?php echo ++$sn; ?></td>
                                        <td><?php echo $fullname = $fetch['name']; ?></td>
                                        <td>
                                            <img src="<?php echo getTrainFoto($fetch['id']); ?>" width="240px" height="160px">
                                        </td>
                                        <td>
                                            <form method="POST">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#edit<?php echo $id ?>">
                                                    Ubah
                                                </button> -

                                                <input type="hidden" class="form-control" name="del_train"
                                                    value="<?php echo $id ?>" required id="">
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure about this?')"
                                                    class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="edit<?php echo $id ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Mengubah <?php echo $fullname ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" class="form-control" name="id"
                                                            value="<?php echo $id ?>" required id="">
                                                        <p>Nama Fasilitas : <input type="text" class="form-control"
                                                                name="name" value="<?php echo $fetch['name'] ?>"
                                                                required minlength="3" id=""></p>
                                                        <p>Foto : <input type="file" class="form-control" name="file"
                                                                required></p>
                                                        <input class="btn btn-info" type="submit" value="Ubah"
                                                            name='edit'>
                                                        </p>
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
                <h4 class="modal-title">Tambah Fasilitas
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">

                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Fasilitas</th>
                            <td><input type="text" class="form-control" name="name" required minlength="3" id=""></td>
                        </tr>
                        <tr>
                            <th>Foto</th>
                            <td><input type="file" name='file' required id=""></td>
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

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $loc = uploadFile('file');
    $first_seat = '1';
    $second_seat = '1';
    if (!isset($name, $loc, $first_seat, $second_seat)) {
        alert("Fill Form Properly!");
    } else {
        $conn = connect();
        //Check if train exists
        $check = $conn->query("SELECT * FROM train WHERE name = '$name' ")->num_rows;
        if ($check) {
            alert("Fasilitas sudah ada");
        } else {
            $ins = $conn->prepare("INSERT INTO train (name, loc, first_seat, second_seat) VALUES (?,?,?,?)");
            $ins->bind_param("ssss", $name, $loc, $first_seat, $second_seat);
            $ins->execute();
            alert("Sukses!");
            load($_SERVER['PHP_SELF'] . "$me");
        }
    }
}

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $loc = uploadFile('file');
    $first_seat = '1';
    $second_seat = '1';
    $id = $_POST['id'];
    if (!isset($name, $loc, $first_seat, $second_seat)) {
        alert("Fill Form Properly!");
    } else {
        $conn = connect();
        //Check if train exists
        $check = $conn->query("SELECT * FROM train WHERE name = '$name' ")->num_rows;
        if ($check == 2) {
            alert("Fasilitas sudah ada");
        } else {
            $ins = $conn->prepare("UPDATE train SET name = ?, loc = ?, first_seat = ?, second_seat = ? WHERE id = ?");
            $ins->bind_param("ssssi", $name, $loc, $first_seat, $second_seat, $id);
            $ins->execute();
            alert("Sukses!");
            load($_SERVER['PHP_SELF'] . "$me");
        }
    }
}

if (isset($_POST['del_train'])) {
    $con = connect();
    $conn = $con->query("DELETE FROM train WHERE id = '" . $_POST['del_train'] . "'");
    if ($con->affected_rows < 1) {
        alert("Error!");
        load($_SERVER['PHP_SELF'] . "$me");
    } else {
        alert("Sukses!");
        load($_SERVER['PHP_SELF'] . "$me");
    }
}
?>