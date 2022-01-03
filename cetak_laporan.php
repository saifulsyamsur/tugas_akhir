<!DOCTYPE html>
<html lang="en">
<?php
include "connection/koneksi.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];


if(isset($_SESSION['edit_order'])){
  //echo $_SESSION['edit_order'];
  unset($_SESSION['edit_order']);

}

if(isset ($_SESSION['username'])){
  
  $query = "select * from tb_user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  while($r = mysqli_fetch_array($sql)){
    
    $nama_user = $r['nama_user'];
    $uang = 0;

?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>&nbsp;</title>
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="template/dashboard/css/bootstrap.min.css" />
  <link rel="stylesheet" href="template/dashboard/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="template/dashboard/css/fullcalendar.css" />
  <link rel="stylesheet" href="template/dashboard/css/matrix-style.css" />
  <link rel="stylesheet" href="template/dashboard/css/matrix-media.css" />
  <link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" href="template/dashboard/css/jquery.gritter.css" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

<style>

@page{
  size: auto;
}
body {
  background: rgb(204,204,204); 
}

@media print {
  body, page {
    margin: auto;
    box-shadow: 0;
  }
}

</style>


</head>

<body>

  <page size="dipakai" layout="landscape">
    <br>
      <center>
        <h4>
          Liwis Pizza Bandarmasih
        </h4>
        <span>
          Jl. Sultan Adam, Banjarmasin<br>
          Telp. +62858 1437 8929 || E-mail saifulsyamsur@gmail.com
        </span>
      </center>
            <hr>
      <div class="row-fluid">
      <div class="span9">
        <div class="widget-box">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
            <h5>Laporan Hari Ini</h5>
          </div>
          <div class="widget-content nopadding" >
            <table class="table table-bordered table-invoice-full">
              <thead>
                <tr>
                  <th class="head0">No.</th>
                  <th class="head0">Nama Menu</th>
                  <th class="head1">Sisa Stok</th>
                  <th class="head0">Jumlah Terjual</th>
                  <th class="head0 right">Harga</th>
                  <th class="head0 right">Total Masukan</th>
                </tr>
              </thead>
              <?php
                $no = 1;
                

                $query_lihat_menu = "select * from tb_masakan";
                $sql_lihat_menu = mysqli_query($conn, $query_lihat_menu);

              ?>
              <tbody>
              <?php
                while($r_lihat_menu = mysqli_fetch_array($sql_lihat_menu)){
              ?>
                  <tr>
                    <td><center><?php echo $no++;?>.</center></td>
                    <td><?php echo $r_lihat_menu['nama_masakan'];?></td>
                    <td><center><?php echo $r_lihat_menu['stok'];?></center></td>
                    <td>
                      <center>
                        <?php
                        $id_masakan = $r_lihat_menu['id_masakan'];
                        $query_lihat_stok = "select * from tb_pesan left join tb_order on tb_pesan.id_pesan = tb_order.id_order left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where status_bayar = 'sudah bayar'";
                        $query_jumlah = "select sum(jumlah) as jumlah_terjual from tb_pesan left join tb_order on tb_pesan.id_pesan = tb_order.id_order where id_masakan = $id_masakan";
                        $sql_jumlah = mysqli_query($conn, $query_jumlah);
                        $result_jumlah = mysqli_fetch_array($sql_jumlah);

                        $jml = 0;

                        if($result_jumlah['jumlah_terjual'] != 0 || $result_jumlah['jumlah_terjual'] != null || $result_jumlah['jumlah_terjual'] != ""){
                          //echo $result_jumlah['jumlah_terjual'];
                          $jml = $result_jumlah['jumlah_terjual'];
                          echo $jml;
                        } else {
                          $jml = 0;
                          echo $jml;
                        }
                      ?>
                      </center>
                    </td>
                    <td style="text-align: right">Rp. <?php echo $r_lihat_menu['harga'];?> ,-</td>
                    <td style="text-align: right">Rp. 

                      <?php

                        $id_masakan = $r_lihat_menu['id_masakan'];
                        $query_lihat_stok = "select * from tb_pesan left join tb_order on tb_pesan.id_pesan = tb_order.id_order left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where status_bayar = 'sudah bayar'";
                        $query_jumlah = "select sum(jumlah) as jumlah_terjual from tb_pesan left join tb_order on tb_pesan.id_pesan = tb_order.id_order where id_masakan = $id_masakan";
                        $sql_jumlah = mysqli_query($conn, $query_jumlah);
                        $result_jumlah = mysqli_fetch_array($sql_jumlah);

                        $jml = 0;

                        if($result_jumlah['jumlah_terjual'] != 0 || $result_jumlah['jumlah_terjual'] != null || $result_jumlah['jumlah_terjual'] != ""){
                          //echo $result_jumlah['jumlah_terjual'];
                          $jml = $result_jumlah['jumlah_terjual'] * $r_lihat_menu['harga'];
                          echo $jml;
                        } else {
                          $jml = $result_jumlah['jumlah_terjual'] * $r_lihat_menu['harga'];
                          echo $jml;
                        }
                        $uang += $jml;
                      ?>

                   ,-</td>
                </tr>
              <?php
                }
                //echo $uang;
              ?>
                </tbody>
                </table>
                <div class="bg_lg">
                <h3>
                <center>
                  <td><strong>Total</strong></td>
                  <td class="right"><strong>Rp. <?php echo $uang;?>,-</strong></td>
                </center>
                </h3>
                </div>           
              <div>
      <span id="remove">
        <a class="btn btn-success" id="ct"><span class="icon-print"></span> DOWNLOAD</a>
      </span>
    </div>
  </page>
</body>

<?php
    }
?>
<?php
    }
?>

<script type="text/javascript">
  document.getElementById('ct').onclick = function(){
    $("#remove").remove();
    window.print();
  }
  $(document).ready(function(){
    $("remove").remove();

  });

 
</script>

<script src="template/dashboard/js/excanvas.min.js"></script> 
<script src="template/dashboard/js/jquery.min.js"></script> 
<script src="template/dashboard/js/jquery.ui.custom.js"></script> 
<script src="template/dashboard/js/bootstrap.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.resize.min.js"></script> 
<script src="template/dashboard/js/jquery.peity.min.js"></script> 
<script src="template/dashboard/js/fullcalendar.min.js"></script> 
<script src="template/dashboard/js/matrix.js"></script> 
<script src="template/dashboard/js/matrix.dashboard.js"></script> 
<script src="template/dashboard/js/jquery.gritter.min.js"></script> 
<script src="template/dashboard/js/matrix.interface.js"></script> 
<script src="template/dashboard/js/matrix.chat.js"></script> 
<script src="template/dashboard/js/jquery.validate.js"></script> 
<script src="template/dashboard/js/matrix.form_validation.js"></script> 
<script src="template/dashboard/js/jquery.wizard.js"></script> 
<script src="template/dashboard/js/jquery.uniform.js"></script> 
<script src="template/dashboard/js/select2.min.js"></script> 
<script src="template/dashboard/js/matrix.popover.js"></script> 
<script src="template/dashboard/js/jquery.dataTables.min.js"></script> 
<script src="template/dashboard/js/matrix.tables.js"></script>
</html>