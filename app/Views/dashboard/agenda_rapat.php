<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= session()->getFlashdata('success') ?>',
            })
        </script>
    <?php endif; ?>

    <?php if ($agenda != null) : ?>
        <a href="<?= base_url('/dashboard/agenda-rapat/tambah-agenda') ?>" class="btn btn-primary mb-2">Tambah Agenda</a>
        <div class="table-container my-3" style="background-color:white; padding: 20px;">
            <table id="example" class="row-border" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Rapat</th>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <th>Nama Bidang</th>
                        <?php endif; ?>
                        <th>Agenda</th>
                        <th>Deskripsi</th>
                        <th>Tanggal/Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agenda as $item) : ?>
                        <tr>
                            <td></td>
                            <td><?= $item['kode_rapat'] ?></td>
                            <?php if (session()->get('role') == 'admin') : ?>
                                <td><?= $item['admin_nama_bidang'] ?></td>
                            <?php endif; ?>
                            <td><?= $item['agenda_rapat'] ?></td>
                            <td><?= elipsis($item['deskripsi']) ?></td>
                            <td><?= $item['tanggal'] . '/ ' . $item['jam'] ?></td>
                            <td><span class="badge <?= $item['status'] == 'selesai' ? 'bg-danger' : 'bg-success' ?>"><?= $item['status'] ?></span></td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-12 btn-group">
                                        <a href="<?= base_url('dashboard/agenda-rapat/daftar-hadir/' . $item['slug']) ?>" class="btn btn-info mx-2"><i class="fa-solid fa-list" style="color: white;"></i></a>
                                        <a href="<?= base_url('dashboard/agenda-rapat/view-agenda/' . $item['slug']) ?>" class="btn btn-info"><i class="fa-solid fa-eye" style="color: white;"></i></a>
                                        <?php if ($item['status'] != 'selesai') : ?>
                                            <a href="<?= base_url('dashboard/agenda-rapat/edit-agenda/' . $item['slug']) ?>" class="btn btn-warning mx-2  <?= $item['editable'] == 'false' ? 'disabled' : '' ?>"><i class="fa-solid fa-pen" style="color: white;"></i></a>
                                            <button class="btn btn-danger delete-button" data-id="<?= $item['id_agenda'] ?>"><i class="fa-solid fa-trash"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                        </tr>
                    <?php endforeach ?>
                    <!-- Add more rows as needed -->
                </tbody>

            </table>
        </div>


    <?php else : ?>
        <div class="button-container">
            <div class="icon-empty">
                <img src="<?php echo base_url('assets/img/icon-empty.svg'); ?>" alt="SVG Image">
            </div>
            <div class="data-kosong">
                Data Agenda Kosong
            </div>
            <a href="<?= base_url('/dashboard/agenda-rapat/tambah-agenda') ?>" id="tambah-agenda" class="btn btn-primary mb-2">Tambah Agenda</a>
        </div>
    <?php endif; ?>

    <script>
        let startNumber = 1;
        let targets = <?php echo (session()->get('role') == 'admin') ? JSON_ENCODE([7]) : JSON_ENCODE([6]); ?>;
        let table = new DataTable('#example', {
            responsive: true,
            "columnDefs": [{
                "targets": targets, // Index of the column to disable sorting (zero-based index)
                "orderable": false,

            }],
            // Additional DataTables options here
            createdRow: function(row, data, dataIndex) {
                $('td:eq(0)', row).html(startNumber++);
            }
        });
        // Get the URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const dataInfo = urlParams.get('data-info');
        // console.log('data-info:', dataInfo);
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

        function showDeleteConfirmation(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Anda yakin akan menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                base_url = '<?= base_url() ?>';
                if (result.isConfirmed) {
                    // Trigger the form submission for POST request
                    console.log(id);
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = base_url + '/dashboard/delete-agenda/' + id;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Attach the delete confirmation modal to each delete button
        $(document).on('click', '.delete-button', function() {
            const itemId = $(this).data('id');
            showDeleteConfirmation(itemId);
        });
    </script>
</body>

<?= $this->endSection() ?>