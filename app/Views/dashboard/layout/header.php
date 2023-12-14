<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?php isset($title) ? print($title) : '' ?></h1>
                <!-- <span class="m-0"><?php isset($subtitle) ? print($subtitle) : '' ?></span> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a style="text-decoration: none;" href="<?= base_url('dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item <?php echo isset($subtitle) ? '' : 'active' ?>"><?php isset($title) ? print($title) : '' ?></li>
                    <?php if (isset($title1)) :  ?>
                        <li class="breadcrumb-item <?php echo isset($title1) ? '' : 'active' ?>"><?php isset($title1) ? print($title1) : '' ?></li>
                    <?php endif; ?>
                    <?php if (isset($subtitle)) :  ?>
                        <li class="breadcrumb-item active"><?php isset($subtitle) ? print(elipsis($subtitle, 30)) : '' ?></li>
                    <?php endif; ?>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->