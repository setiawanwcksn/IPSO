<script type="application/javascript">
    $("#tab nav a").click(function(){
  const id = $(this).data('id');
  if(!$(this).hasClass('active')){
    $("#tab nav a").removeClass('active');
    $(this).addClass('active');
    
    $('.tab-content').hide();
    $(`[data-content=${id}]`).fadeIn();
  }
});
</script>