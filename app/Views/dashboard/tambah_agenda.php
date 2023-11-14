<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <!-- buat agar menjadi di tengah -->

    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/dashboard/agenda-rapat/tambah-agenda/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Agenda Rapat</label>
                            <input type="text" class="form-control <?= validation_show_error('agenda_rapat') ? 'is-invalid' : '' ?>" value="<?= old('agenda_rapat') ?>" id="agenda_rapat" name="agenda_rapat">
                            <div class="invalid-feedback">
                                <?= validation_show_error('agenda_rapat') ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Tempat Rapat</label>
                            <input type="text" class="form-control <?= validation_show_error('tempat') ? 'is-invalid' : '' ?>" value="<?= old('tempat') ?>" id="tempat" name="tempat">
                            <div class="invalid-feedback">
                                <?= validation_show_error('tempat') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control <?= validation_show_error('tanggal') ? 'is-invalid' : '' ?>" value="<?= old('tanggal', date('Y-m-d')) ?>" id="tanggal" name="tanggal" min="<?= date('Y-m-d') ?>">
                            <div class="invalid-feedback">
                                <?= validation_show_error('tanggal') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Jam</label>
                            <input class="timepicker-default form-control <?= validation_show_error('jam') ? 'is-invalid' : '' ?>" value="<?= old('jam') ?>" id="jam" name="jam">
                            <input style="display: none;" class="timepicker form-control <?= validation_show_error('jam') ? 'is-invalid' : '' ?>" value="<?= old('jam') ?>" id="jam" name="jam">
                            <div class="invalid-feedback">
                                <?= validation_show_error('jam') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Agenda Rapat</label>
                        <textarea class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" rows="5" id="deskripsi" name="deskripsi"><?= old('deskripsi') ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('deskripsi') ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
        // Function to format the current time as 'HH:mm' and round to the nearest 30-minute interval
        function getCurrentTimeRounded() {
            const now = new Date();
            const minutes = now.getMinutes();

            // Calculate the remaining minutes until the next 30-minute interval
            const remainingMinutes = 30 - (minutes % 30);

            // Calculate the time for the next 30-minute interval
            const roundedTime = new Date(now);
            roundedTime.setMinutes(roundedTime.getMinutes() + remainingMinutes);

            return `${roundedTime.getHours().toString().padStart(2, '0')}:${roundedTime.getMinutes().toString().padStart(2, '0')}`;
        }

        // Get the current time rounded to the nearest 30-minute interval and set it as the defaultTime
        const defaultTimeRounded = getCurrentTimeRounded();

        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            defaultTime: defaultTimeRounded,
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            minTime: '00:00', // Set an initial minTime
        });

        $('.timepicker-default').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            defaultTime: defaultTimeRounded,
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            minTime: defaultTimeRounded // Set an initial minTime
        });

        // show timepicker time based on the selected date
        $('#tanggal').on('change', function() {
            const selectedDate = $(this).val();
            if (selectedDate === '<?= date('Y-m-d') ?>') {
                $('.timepicker').hide();
                $('.timepicker-default').show();
            } else {
                $('.timepicker-default').hide();
                $('.timepicker').show();
            }
        });
    </script>
</body>
<?= $this->endSection() ?>