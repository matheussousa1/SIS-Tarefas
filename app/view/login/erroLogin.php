<div class="authentication">
<div class="header header-filter" style="background-image: url('<?php echo SITE; ?>assets/images/login-bg.jpg'); background-size: cover; background-position: top center;">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 text-center">
        <div class="card card-signup">
          <form class="form" action="<?php echo SITE."login/logar";?>" method="post">
            <div class="header header-danger text-center">
              <h4>Error Login</h4>
            </div>
            <h3 class="mt-0">GOES</h3>
            <p class="help-block">Area Administrativa</p>
            <div class="content">
              <div class="form-group">
                <input type="text" class="form-control underline-input" placeholder="Usuario" name="idUser" id="idUser" >
              </div>
              <div class="form-group">
                <input type="password" placeholder="Senha..." class="form-control underline-input"  name="senha" id="senha">
              </div>
            </div>
            <div class="footer text-center">
              <button type="submit" class="btn btn-info btn-raised">Entrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>