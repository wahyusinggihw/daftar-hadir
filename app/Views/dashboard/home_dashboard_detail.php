<?= $this->extend('dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->get('role') == 'superadmin') : ?>
    <div class="row">
        <div class="col-sm-4">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $totalagenda ?></h3>

                    <p>Total Agenda Rapat</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" data-info="" class="small-box-footer info">Filter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-sm-4">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $totalAgendaTersedia ?></h3>

                    <p>Agenda Rapat Tersedia</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" data-info="tersedia" class="small-box-footer info">Filter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $totalAgendaSelesai ?></h3>

                    <p>Agenda Rapat Selesai</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" data-info="selesai" class="small-box-footer info">Filter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div>
        <div class="table-container my-3" style="background-color:white; padding: 20px;">
            <table id="example" class="row-border" style="width:100%">
                <thead>
                    <tr>
                        <!-- <th>id</th> -->
                        <th>No</th>
                        <th>Kode Rapat</th>
                        <th>Instansi</th>
                        <th>Bidang</th>
                        <th>Agenda</th>
                        <th>Deskripsi</th>
                        <th>Tempat</th>
                        <th>Tanggal/Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($agenda as $item) : ?>
                        <tr>
                            <td></td>
                            <td><?= $item['kode_rapat'] ?></td>
                            <td><?= $item['nama_instansi'] ?></td>
                            <td><?= $item['admin_nama_bidang'] ?></td>
                            <td><?= $item['agenda_rapat'] ?></td>
                            <td><?= elipsis($item['deskripsi']) ?></td>
                            <td><?= $item['tempat'] ?></td>
                            <td><?= $item['tanggal'] . ', ' . $item['jam'] ?></td>
                            <td><span class="badge <?= $item['status'] == 'selesai' ? 'bg-danger' : 'bg-success' ?>"><?= $item['status'] ?></td>

                        </tr>
                    <?php endforeach ?>

                    <!-- Add more rows as needed -->
                </tbody>

            </table>
        </div>
    </div>
<?php endif; ?>

<!-- Small boxes (Stat box) -->


<script>
    // show tables if element clicked
    $(document).ready(function() {
        $('#example').DataTable();
    });


    let startNumber = 1;
    let table = new DataTable('#example', {
        responsive: true,
        "columnDefs": [{
            "targets": [null], // Index of the column to disable sorting (zero-based index)
            "orderable": false,

        }],
        // Additional DataTables options here
        createdRow: function(row, data, dataIndex) {
            $('td:eq(0)', row).html(startNumber++);
        }
    });

    // Set search value programmatically
    document.addEventListener('DOMContentLoaded', function() {
        const infoElements = document.querySelectorAll('.info');

        infoElements.forEach(function(infoElement) {
            infoElement.addEventListener('click', function(event) {
                event.preventDefault();
                const dataInfo = this.getAttribute('data-info');

                if (dataInfo === 'tersedia') {
                    table.search('tersedia').draw();
                    // Handle the 'tersedia' action
                } else if (dataInfo === 'selesai') {
                    // Handle the 'selesai' action
                    table.search('selesai').draw();
                } else {
                    // Handle the default action
                    table.search('').draw();
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>