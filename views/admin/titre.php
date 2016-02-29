<?php $this->layout('admin/layout') ?>
<?php $this->start('page'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Des titres en folies</small>
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge titre_count"></div>
                            <div>Titres</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Titres</h3>
                </div>
                <div class="panel-body">
                    <div class="titre_list list-group"></div>
                </div>
            </div>
        </div>
  </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->
<?=$this->stop(); ?>
