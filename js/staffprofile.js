document.addEventListener("DOMContentLoaded", function(event) {

  $('#edit-btn').click(function(){

    $('#heading1, #mapping1').addClass('hidden');
    $('#heading2, #mapping2, #mapping3').removeClass('hidden');
    $('#save-btn, #back-btn').removeClass('hidden');
    $('#save-btn, #back-btn').addClass('btn btn-primary');
    $('#photo-btn').removeClass('hidden');
    $('#edit-btn, #pswd-btn').removeClass('btn btn-primary');
    $('#edit-btn, #pswd-btn').addClass('hidden');
    $('input, select').removeClass('form-control-plaintext');
    $('input, select').addClass('form-control');
    $('input').attr('readonly', false);
    $('select').attr('disabled', false);

  });

  $('#back-btn').click(function(){
    if (confirm('Are you sure NOT to save?')){
      $('#heading1, #mapping1').removeClass('hidden');
      $('#heading2, #mapping2, #mapping3').addClass('hidden');
      $('#save-btn, #back-btn').addClass('hidden');
      $('#save-btn, #back-btn').removeClass('btn btn-primary');
      $('#photo-btn').addClass('hidden');
      $('#edit-btn, #pswd-btn').addClass('btn btn-primary');
      $('#edit-btn, #pswd-btn').removeClass('hidden');
      $('input, select').addClass('form-control-plaintext');
      $('input, select').removeClass('form-control');
      $('input').attr('readonly', true);
      $('select').attr('disabled', true);
    }

  });

  var src = document.getElementById("file-input");
  var target = document.getElementById("profile-photo");
  showImage(src,target);

  function showImage(src,target) {
    var fr=new FileReader();
    // when image is loaded, set the src of the image where you want to display it
    fr.onload = function(e) { target.src = this.result; };
    src.addEventListener("change",function() {
      // fill fr with image data    
      fr.readAsDataURL(src.files[0]);
    });
  }
});
