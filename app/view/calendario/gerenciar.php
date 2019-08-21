<link rel="stylesheet" href="<?php echo SITE; ?>assets/js/vendor/fullcalendar/fullcalendar.css">
<script src='<?php echo SITE; ?>assets/js/vendor/fullcalendar/lang/pt-br.js'></script>
<script type="text/javascript">
  $(window).load(function () {
 
      $('#calendar').fullCalendar({
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
            'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Aug', 'Set', 'Out', 'Nov', 'Dez'],
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        eventRender: function(eventObj, $el) {
          $el.popover({
            html:true,
            title: eventObj.title,
            content: eventObj.description,
            trigger: 'hover',
            placement: 'top',
            container: 'body'
          });
        },
        events: '<?php echo AJAX; ?>calendario.php?acao=buscar',
    });
   });
</script>
<section id="content">
      <div class="page page-calendar">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="boxs">
              <div class="boxs-header">
                  <h3 class="custom-font hb-amber">
                      <strong>Calendário </strong></h3>
              </div>
              <!-- right side -->
              <div class="tcol">
                <!-- right side body -->
                <div class="p-15">
                  <button class="btn btn-raised btn-default btn-sm mr-5" id="change-view-day">Dia</button>
                  <button class="btn btn-raised btn-default btn-sm mr-5" id="change-view-week">Semana</button>
                  <button class="btn btn-raised btn-default btn-sm mr-5" id="change-view-month">Mês</button>
                  <div id="calendar"></div>
                </div>
                <!-- /right side body -->
              </div>
              <!-- /right side -->
            </div>
          </div>
        </div>
      </div>
    </section>
<script src="<?php echo SITE; ?>assets/bundles/fullcalendarscripts.bundle.js"></script>
<script src="<?php echo SITE; ?>assets/js/page/calendar.js"></script>