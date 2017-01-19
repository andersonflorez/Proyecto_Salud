</section>
<script type="text/javascript">const url = '<?=URL?>'</script>
<script src="<?=URL?>Public/Js/Lib/jquery.validate.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Lib/additional-methods.min.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Validaciones/Functions_Validation.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Lib/messages_es.min.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Lib/select2.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/notify.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/script.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/datepicker.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/datepicker.es.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/datepicker.in.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/jquery.timepicker.min.js" charset="utf-8"></script>
<?php

// El siguiente fragmento de código enlaza los Javascripts de la variable $scripts automáticamente:

if (isset($this->scripts)) {
  foreach ($this->scripts as $script) {
    ?>
    <script src="<?=URL?>Public/Js/<?=$script?>" charset="utf-8"></script>
    <?php
  }
}
?>
</body>
</html>
