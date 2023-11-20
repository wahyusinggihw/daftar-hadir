<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error') ?>',
            })
        </script>
    <?php endif; ?>

    <!-- buat agar menjadi di tengah -->
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/dashboard/agenda-rapat/tambah-agenda/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Agenda Rapat</label>
                            <input type="text" class="form-control <?= validation_show_error('agenda_rapat') ? 'is-invalid' : '' ?>" value="<?= old('agenda_rapat') ?>" id="agenda_rapat" name="agenda_rapat" minlength="5">
                            <div class="agenda-counter"></div>
                            <div class="invalid-feedback">
                                <?= validation_show_error('agenda_rapat') ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Tempat Rapat</label>
                            <input type="text" class="form-control <?= validation_show_error('tempat') ? 'is-invalid' : '' ?>" value="<?= old('tempat') ?>" id="tempat" name="tempat" minlength="5">
                            <div class="tempat-counter"></div>
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
                            <input class="timepicker-default readonly form-control <?= validation_show_error('jam') ? 'is-invalid' : '' ?>" value="<?= old('jam') ?>" id="jam" name="jam" autocomplete="off">
                            <div class="invalid-feedback">
                                <?= validation_show_error('jam') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Rapat</label>
                        <textarea class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" rows="5" id="deskripsi" name="deskripsi" minlength="5"><?= old('deskripsi') ?></textarea>
                        <div class="deskripsi-counter"></div>
                        <div class="invalid-feedback">
                            <?= validation_show_error('deskripsi') ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <style>
        /* prevent user from inputting, but allow user to click */
        #jam {
            background-color: white;
        }
    </style>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> -->
    <script>
        // show minlength
        function handleCharacterCounter(inputId, counterClass, minLength) {
            $(inputId).on('input', function() {
                const length = $(this).val().length;
                if (length < minLength) {
                    $(counterClass).text(`Minimal karakter yang diinput adalah ${minLength} karakter`).addClass('text-danger');
                } else {
                    $(counterClass).text('').removeClass('text-danger');
                }
            });
        }

        // Call the function for each input field
        handleCharacterCounter('#agenda_rapat', '.agenda-counter', 5);
        handleCharacterCounter('#tempat', '.tempat-counter', 5);
        handleCharacterCounter('#deskripsi', '.deskripsi-counter', 5);

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

        function getCurrentTime() {
            const now = new Date();
            return `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
        }

        // Get the current time rounded to the nearest 30-minute interval and set it as the defaultTime
        const defaultTimeRounded = getCurrentTimeRounded();
        const defaultTime = getCurrentTime();

        const timepicker = flatpickr('.timepicker-default', {
            // allowInput: true,
            disableMobile: true,
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            minTime: defaultTime,
            defaultHour: defaultTime.split(':')[0],
            // defaultMinute: defaultTime.split(':')[1],
        });

        // show timepicker time based on the selected date
        $('#tanggal').on('change', function() {
            const selectedDate = $(this).val();
            if (selectedDate === '<?= date('Y-m-d') ?>') {
                timepicker.set('minTime', defaultTime);
                timepicker.set('defaultHour', defaultTime.split(':')[0]);
                timepicker.set('defaultMinute', defaultTime.split(':')[1]);
                $('.timepicker-default').val(defaultTime);
            } else {
                timepicker.set('minTime', '00:00');
                timepicker.set('defaultHour', '00');
                timepicker.set('defaultMinute', '00');
            }
        });
    </script>
</body>
<?= $this->endSection() ?>