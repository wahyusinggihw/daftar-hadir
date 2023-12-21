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

    <?php if (session()->get('role') != 'operator') : ?>
        <a href="<?= base_url('dashboard/kelola-admin/tambah-admin') ?>" class="btn btn-primary mb-2"><?= (session()->get('role') == 'superadmin') ? 'Tambah Admin' : 'Tambah Operator' ?></a>
    <?php endif; ?>

    <div class="table-container my-3" style="background-color:white; padding: 20px;">
        <table id="example" class="row-border" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Instansi</th>
                    <?php if (session()->get('role') == 'admin') : ?>
                        <th>Nama Bidang</th>
                    <?php endif; ?>
                    <th>Nama Admin</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $item) : ?>
                    <tr>
                        <td></td>
                        <td><?= $item['nama_instansi'] ?></td>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <td><?= $item['nama_bidang'] ?></td>
                        <?php endif; ?>
                        <td><?= $item['nama'] ?></td>
                        <td><?= $item['username'] ?></td>
                        <td>
                            <div class="row">
                                <div class="col-lg-12 btn-group">
                                    <!-- <a href="<?= base_url('dashboard/kelola-admin/view-agenda/' . $item['slug']) ?>" class="btn btn-secondary"><i class="fa-solid fa-eye"></i></a> -->
                                    <a href="<?= base_url('dashboard/kelola-admin/edit-admin/' . $item['slug']) ?>" class="btn btn-warning mx-2"><i class="fas fa-lock"></i></a>
                                    <button href="#" class="btn btn-danger delete-button" data-id="<?= $item['id_admin'] ?>"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                <!-- Add more rows as needed -->
            </tbody>

        </table>
    </div>

    <script>
        let startNumber = 1;
        new DataTable('#example', {
            responsive: true,
            "columnDefs": [{
                // "targets": [2, 5], // Index of the column to disable sorting (zero-based index)
                "orderable": false,

            }],
            // Additional DataTables options here
            createdRow: function(row, data, dataIndex) {
                $('td:eq(0)', row).html(startNumber++);
            }
        });

        function showDeleteConfirmation(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Anda yakin akan menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#22b23a',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(id);
                    // Trigger the form submission for POST request
                    base_url = '<?= base_url() ?>';
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = base_url + '/dashboard/kelola-admin/delete-admin/' + id;
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