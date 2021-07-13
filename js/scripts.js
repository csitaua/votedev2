$(document).ready(function () {

  $('.mult_sel').on('change', function() {
   if($('.mult_sel:checked').length > 2) {
  		 this.checked = false;
   }
  });


})

function checkMult1(){
  if($('.mult_sel:checked').length == 2) {
      return true;
  }
  else{
    return false;
  }
}
