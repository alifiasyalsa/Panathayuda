<?php
$page = "field";
include('header.php');
include('navbar.php');
?>

<div id="page-wrapper">
    <div class="header">
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <h1 class="page-header">Lapangan</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Lapangan</a></li>
            <li class="active">Data</li>
        </ol>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card col-md-12" style="padding: 0px !important;">
                    <div class="card-action">
                        Tambah Data Lapangan
                    </div>
                    <div class="card-content">
                        <form method="post" action="process.php?process=addField" enctype='multipart/form-data'>
                            <div class="form-group col-md-6">
                                <label for="nama">Nama Lapangan</label>
                                <input type="text" class="form-control" id="nama" name="fieldName">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="price">Harga</label>
                                <input type="number" class="form-control" id="price" name="fieldPrice">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="size">Ukuran </label>
                                <input type="text" class="form-control" id="size" name="fieldSize">
                            </div>
                            <div class="form-group col-md-9">
                                <label for="desc">Deskripsi</label>
                                <textarea class="form-control" id="desc" name="fieldDesc"></textarea>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="foto">Foto </label>
                                <input type="file" class="form-control" id="foto" name="fieldImg">
                                <p style="color: red; font-size:12px;">Ekstensi yang diperbolehkan .png | .jpg | .jpeg</p>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="add_field">&nbsp;</label>
                                <button type="submit" id="add_field" class="btn btn-success form-control">Tambah Data</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="card">
                    <div class="card-action">
                        Kelola Data Lapangan
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="fieldRecord">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lapangan</th>
                                        <th>Harga</th>
                                        <th>Foto</th>
                                        <th>Ukuran</th>
                                        <th>Deskripsi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
        <!-- /. ROW  -->
        <?php
        include('footer.php');
        ?>