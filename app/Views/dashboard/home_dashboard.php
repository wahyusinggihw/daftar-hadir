<?= $this->extend('dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->get('role') == 'superadmin') : ?>

    <div>
        <div class="table-container my-3" style="background-color:white; padding: 20px;">
            <table id="example" class="row-border" style="width:100%">
                <thead>
                    <tr>
                        <!-- <th>id</th> -->
                        <th>No</th>
                        <th>ID Instansi</th>
                        <th>Instansi</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($agenda as $item) : ?>
                        <tr>
                            <td></td>
                            <td><?= $item['id_instansi'] ?></td>
                            <td><?= $item['nama_instansi'] ?></td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-12 btn-group">
                                        <a href="<?= base_url('dashboard/view-detail-by-instansi/' . $item['id_instansi']) ?>" class="btn btn-info"><i class="fa-solid fa-eye" style="color: white;"></i></a>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach ?>

                    <!-- Add more rows as needed -->
                </tbody>

            </table>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $totalagenda ?></h3>

                    <p>Total Agenda Rapat</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" data-info="" class="small-box-footer info">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $totalAgendaTersedia ?></h3>

                    <p>Agenda Rapat Tersedia</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" data-info="tersedia" class="small-box-footer info">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">

            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $totalAgendaSelesai ?></h3>

                    <p>Agenda Selesai</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" data-info="selesai" class="small-box-footer info">More info <i class="fas fa-arrow-circle-right"></i></a>
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
        new DataTable('#example', {
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

        document.addEventListener('DOMContentLoaded', function() {
            const infoElements = document.querySelectorAll('.info');

            infoElements.forEach(function(infoElement) {
                infoElement.addEventListener('click', function(event) {
                    event.preventDefault();
                    const base_url = '<?= base_url() ?>';
                    const dataInfo = this.getAttribute('data-info');
                    const redirectURL = base_url + 'dashboard/agenda-rapat?data-info=' + dataInfo;

                    if (dataInfo === 'tersedia') {
                        // Redirect to the URL
                        window.location.href = redirectURL;
                        table.search('tersedia').draw();
                    } else if (dataInfo === 'selesai') {
                        // Redirect to the URL
                        window.location.href = redirectURL;
                    } else {
                        // Redirect to the URL
                        window.location.href = redirectURL;
                    }
                });
            });
        });
    </script>

    <?= $this->endSection() ?>