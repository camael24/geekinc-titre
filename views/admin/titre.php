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
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Titres</h3>
                </div>
                <div class="panel-body">
                    <div class="titre_list list-group"></div>
                      <div class="text-right">
                        <a href="#" class="newTitre"><i class="fa fa-plus-circle fa-2x"></i></a>
                      </div>
                </div>

            </div>
        </div>
        <div class="div_form col-lg-6" style="display: none;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-tasks fa-fw"></i> Détails <a href="#"class="form_close close"><i class="fa fa-fw fa-close pull-right"></i></a></h3>
                </div>
                <div class="panel-body">
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="form_name" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Titre</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="form_titre" placeholder="Titre">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">css</label>
                      <div class="col-sm-10">
                        <select id="form_class" class="col-sm-2 form-control">
                          <option selected="selected">geekinc</option>
                          <option>geekinc-ink</option>
                          <option>geekinc-bits</option>
                          <option>geekinc-play</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Duration</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="form_duration" placeholder="Duration en s">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" id="form_uri">
                        <button type="submit" class="form_send btn btn-primary">Update</button>
                        <a href="#" class="trashed btn btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
  </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->
<?=$this->stop(); ?>
