	<!-- HEADER Content -->
	 <div id="header">
            <header class="clearfix">
                <!-- Branding -->
                <div class="branding">
                    <a class="brand" href="index.html">
                        <span>GOES - Admin</span>
                    </a>
                    <a role="button" tabindex="0" class="offcanvas-toggle visible-xs-inline">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <!-- Branding end -->

                <!-- Left-side navigation -->
                <ul class="nav-left pull-left list-unstyled list-inline">
                    <li class="leftmenu-collapse">
                        <a role="button" tabindex="0" class="collapse-leftmenu">
                            <i class="fa fa-outdent"></i>
                        </a>
                    </li>
                </ul>
                <!-- Right-side navigation -->
                <ul class="nav-right pull-right list-inline">
                    <li class="dropdown nav-profile">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo SITE; ?>assets/images/profile-photo.jpg" alt="" class="0 size-30x30"> </a>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <div class="user-info">
                                    <div class="user-name"><?php echo $_SESSION['nomeSession']; ?></div>
                                </div>
                            </li>
                            <li>
                                <a href="<?php echo SITE; ?>login/sair" role="button" tabindex="0">
                                    <i class="fa fa-sign-out"></i>Sair</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Right-side navigation end -->
            </header>
        </div>
	<!--/ HEADER Content  --> 
	
	<!--  CONTROLS Content -->
	<div id="controls"> 
		<!--SIDEBAR Content -->
		<aside id="leftmenu">
			<div id="leftmenu-wrap">
				<div class="panel-group slim-scroll" role="tablist">
					<div class="panel panel-default">						
						<div id="leftmenuNav" class="panel-collapse collapse in" role="tabpanel">
							<div class="panel-body"> 
								<!--  NAVIGATION Content -->
								<ul id="navigation">
									<li><a href="<?php echo SITE; ?>inicio/inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li> 
                                    <li><a href="<?php echo SITE; ?>tarefas/gerenciar"><i class="fa fa-navicon"></i> <span>Tarefas</span></a></li> 
                                    <li><a href="<?php echo SITE; ?>contatos/listar"><i class="fa fa-phone-square"></i> <span>Contatos</span></a></li>
                                    <li><a href="<?php echo SITE; ?>clientes/gerenciar"><i class="fa fa-users"></i> Clientes</a></li>
                                    <li><a href="<?php echo SITE; ?>ordemservicos/gerenciar"><i class="fa fa-plus-square-o"></i> <span>Ordem de Serviço</span></a></li>
                                    <li><a href="<?php echo SITE; ?>calendario/gerenciar"><i class="fa fa-calendar"></i> <span>Calendário</span></a></li>
								</ul>
								<!--/ NAVIGATION Content --> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside>
		<!--/ SIDEBAR Content --> 
	</div>
	<!--/ CONTROLS Content --> 