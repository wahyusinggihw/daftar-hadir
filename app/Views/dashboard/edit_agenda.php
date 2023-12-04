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
    <div class="">
        <div class="card card-warning">
            <div class="card-body">
                <form action="<?= base_url('/dashboard/agenda-rapat/edit-agenda/' . $data['id_agenda'] . '/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" id="text" name="id_agenda" value="<?= $data['id_agenda'] ?>">
                    <div class="row">
                        <!-- <div class="col-sm-6"> -->
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control <?= validation_show_error('agenda_rapat') ? 'is-invalid' : '' ?>" value="<?= old('agenda_rapat', $data['agenda_rapat']) ?>" id="agenda_rapat" name="agenda_rapat" maxlength="255">
                            <div class="agenda-counter"></div>
                            <div class="invalid-feedback">
                                <?= validation_show_error('agenda_rapat') ?>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-sm-6"> -->
                        <div class="form-group">
                            <label>Program</label>
                            <input type="text" class="form-control <?= validation_show_error('program') ? 'is-invalid' : '' ?>" value="<?= old('program', $data['program']) ?>" id="program" name="program" maxlength="255">
                            <div class="program-counter"></div>
                            <div class="invalid-feedback">
                                <?= validation_show_error('program') ?>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-sm"> -->
                        <div class="form-group">
                            <label>Kegiatan</label>
                            <textarea class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" rows="2" id="deskripsi" name="deskripsi" maxlength="2550"><?= old('deskripsi', $data['deskripsi']) ?></textarea>
                            <div class="deskripsi-counter"></div>
                            <div class="invalid-feedback">
                                <?= validation_show_error('deskripsi') ?>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-sm-6"> -->
                        <div class="form-group">
                            <label>Tempat Rapat</label>
                            <input type="text" class="form-control <?= validation_show_error('tempat') ? 'is-invalid' : '' ?>" value="<?= old('tempat', $data['tempat']) ?>" id="tempat" name="tempat" maxlength="">
                            <div class="tempat-counter"></div>
                            <div class="invalid-feedback">
                                <?= validation_show_error('tempat') ?>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control <?= validation_show_error('tanggal') ? 'is-invalid' : '' ?>" value="<?= old('tanggal', $data['tanggal']) ?>" id="tanggal" name="tanggal" min="<?= date('Y-m-d') ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('tanggal') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Jam</label>
                                <input class="timepicker-default form-control <?= validation_show_error('jam') ? 'is-invalid' : '' ?>" value="<?= old('jam', $data['jam']) ?>" id="jam" name="jam">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('jam') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('dashboard/agenda-rapat') ?>" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </div>
    <style>
        /* prevent user from inputting, but allow user to click */
        #jam {
            background-color: white;
        }
    </style>

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
        handleCharacterCounter('#program', '.program-counter', 5);
        handleCharacterCounter('#tempat', '.tempat-counter', 5);
        handleCharacterCounter('#deskripsi', '.deskripsi-counter', 5);

        $(document).ready(function() {
            const defaultDate = '<?= $data['tanggal'] ?>';
            const currentDate = '<?= date('Y-m-d') ?>';
            const defaultTime = '<?= $data['jam'] ?>';
            const currentTime = getCurrentTime();

            let minTime;
            if (currentDate === defaultDate) {
                minTime = currentTime;
            } else {
                minTime = '00:00';
            }


            const timepicker = flatpickr('.timepicker-default', {
                disableMobile: true,
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                minTime: minTime,
                defaultHour: minTime.split(':')[0],
                defaultMinute: minTime.split(':')[1],
            });

            $('#tanggal').on('change', function() {
                const selectedDate = $(this).val();
                if (selectedDate === currentDate) {
                    timepicker.set('minTime', currentTime);
                    timepicker.set('defaultHour', currentTime.split(':')[0]);
                    timepicker.set('defaultMinute', currentTime.split(':')[1]);
                    // timepicker.setDate(selectedDate + ' ' + currentTime, true);
                    $('.timepicker-default').val(currentTime)
                } else {
                    timepicker.set('minTime', '00:00');
                    timepicker.set('defaultHour', '00');
                    timepicker.set('defaultMinute', '00');
                }
            });

            function getCurrentTime() {
                const now = new Date();
                return `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
            }
        });
    </script>
</body>

<?= $this->endSection() ?>