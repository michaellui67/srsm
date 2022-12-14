<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>

<div class="content">
    <div class="container-fluid">
        <?php
        if (!isset($_POST['submit'])) {
        ?>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="m-0">Tips</h5>
                    </div>
                    <div class="card-body">
                        Gunakan menu pada sebelah kiri untuk mengakses sistem
                        <br />Lihat jadwal reservasi yang tersedia pada menu Reservasi. <br>Setelah menyelesaikan 
                        proses pembayaran maka Reservasi akan muncul pada menu Lihat Reservasi.<br>Kritik dan Saran dapat disampaikan pada menu Masukan.
                    </div>
                </div>
            </div><?php
                    } else {
                        $class = $_POST['class'];
                        $number = $_POST['number'];
                        $schedule_id = $_POST['id'];
                        if ($number < 1) die("Invalid Number");
                        ?>

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header alert-success">
                            <h5 class="m-0">Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                Anda akan membayar untuk
                                <?php echo $number, " Sesi", $number > 1 ? 's' : '', ' pada ', getRouteFromSchedule($schedule_id); ?>
                                <br />

                                <?php

                                    $fee = ($_SESSION['amount'] = getFee($schedule_id, $class));
                                    $amount = intval($fee);
                                    echo "Total = IDR ", $total = $amount;
                                    $fee =  intval($total) . "00";
                                    $_SESSION['amount'] =  $total;
                                    $_SESSION['original'] =  $fee;
                                    $_SESSION['schedule'] =  $schedule_id;
                                    $_SESSION['no'] =  $number;
                                    $_SESSION['class'] =  $class;
                                    ?>
                            </div>
                            <a href="pay.php"><button
                                    onclick="return confirm('Silahkan hubungi kontak WA 081331907503 dengan bukti transfer untuk menyelesaikan reservasi.\nTiket akan tampil setelah petugas kami telah menkonfirmasi pembayaran')"
                                    class="btn btn-primary">Bayar Sekarang</button></a>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

