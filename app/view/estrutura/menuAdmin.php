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
                                    <!-- <li><a href="<?php echo SITE; ?>dadostecnicos/gerenciar"><i class="fa fa-list"></i> Dados Técnicos</a></li> -->
                                    <li><a href="<?php echo SITE; ?>fornecedores/gerenciar"><i class="fa fa-truck"></i> <span>Fornecedores</span></a></li>
                                    <li><a href="<?php echo SITE; ?>contasbancarias/listar"><i class="fa fa-money"></i> <span>Contas Bancárias</span></a></li>
                                    <li><a href="<?php echo SITE; ?>produtos/gerenciar"><i class="fa fa-shopping-cart"></i> <span>Produtos / Serviços</span></a></li>
                                    <li><a href="<?php echo SITE; ?>propostas/gerenciar"><i class="fa fa-file"></i> <span>Propostas</span></a></li>
                                    <li><a href="<?php echo SITE; ?>ordemservicos/gerenciar"><i class="fa fa-plus-square-o"></i> <span>Ordem de Serviço</span></a></li>
                                    <li><a href="<?php echo SITE; ?>calendario/gerenciar"><i class="fa fa-calendar"></i> <span>Calendário</span></a></li>
                                    <!-- <li><a href="<?php echo SITE; ?>financeiro/gerenciar"><i class="fa fa-money"></i> <span>Financeiro</span></a></li> -->
                                    <li>
                                        <a role="button" tabindex="0">
                                            <i class="fa fa-money"></i>
                                            <span>Financeiro</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo SITE; ?>financeiro/gerenciar">
                                                    <i class="fa fa-angle-right"></i> Gerenciar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo SITE; ?>financeiro/contaspagar">
                                                    <i class="fa fa-angle-right"></i> Contas a pagar</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo SITE; ?>financeiro/contasreceber">
                                                    <i class="fa fa-angle-right"></i> Contas a receber</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- <li><a href="<?php echo SITE; ?>mapa/inicio"><i class="fa fa-map"></i> <span>Mapa</span></a></li> -->
                                    <!-- <li><a href="<?php echo SITE; ?>inicio/inicio"><i class="fa fa-tachometer"></i> <span>Relatórios</span></a></li> -->
                                    <li><a href="<?php echo SITE; ?>despesas/gerenciar"><i class="fa fa-money"></i> <span>Despesas</span></a></li>
                                    <li><a href="<?php echo SITE; ?>usuarios/gerenciar"><i class="fa fa-users"></i> Usuários</a></li>

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