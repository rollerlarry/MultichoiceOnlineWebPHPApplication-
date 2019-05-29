<div class="modal-footer">
  <div>
    <small>Version <strong>v6.3</strong></small> Copyright <li class="fa fa-copyright"></li> 2017 by <strong><a href="abount.html">ITCode Team</a></strong> <br>
  </div>
</div>
<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<script src="../js/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">
  CKEDITOR.replace('content');
</script>
<script src="../js/highcharts.js"></script>
<script src="../js/exporting.js"></script>
<script src="../js/<drilldown class=""></drilldown>js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/metisMenu.min.js"></script>
<script src="../js/startmin.js"></script>
<link rel="stylesheet prefetch" href="../css/datepicker.css">
<script src="../js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  $(function () {  
     $("#datepicker").datepicker({         
         autoclose: true,         
         todayHighlight: true 
     }).datepicker('update', new Date());
  });
</script>
<!-- loading -->
<script type="text/javascript">
  $('#load').on('click', function() {
    var $this = $(this);
  $this.button('loading');
    setTimeout(function() {
       $this.button('reset');
   }, 2000);
});
</script>
<!-- upfile -->
<script type="text/javascript">
  $('#imageUpload').change(function(){      
      readImgUrlAndPreview(this);
      function readImgUrlAndPreview(input){
         if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {                    
                      $('#imagePreview').attr('src', e.target.result);
              }
                };
                reader.readAsDataURL(input.files[0]);
           }  
    });
</script>
</body>
</html>
