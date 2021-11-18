
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
var element = document.getElementById('body');
    var op = 0.01;  // initial opacity
    element.style.display = 'block';
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 10);

</script>