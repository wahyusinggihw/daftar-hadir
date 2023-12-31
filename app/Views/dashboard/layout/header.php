<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?php isset($title) ? print($title) : '' ?></h1>
                <span class="m-0"><?php isset($subtitle) ? print($subtitle) : '' ?></span>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard/">Home</a></li>
                    <li class="breadcrumb-item active"><?php isset($title) ? print($title) : '' ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->