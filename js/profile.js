$(function () {
   $('.panel-google-plus > .panel-footer > .input-placeholder, .panel-google-plus > .panel-google-plus-comment > .panel-google-plus-textarea > button[type="reset"]').on('click', function(event) {
        var $panel = $(this).closest('.panel-google-plus');
            $comment = $panel.find('.panel-google-plus-comment');
            
        $comment.find('.btn:first-child').addClass('disabled');
        $comment.find('textarea').val('');
        
        $panel.toggleClass('panel-google-plus-show-comment');
        
        if ($panel.hasClass('panel-google-plus-show-comment')) {
            $comment.find('textarea').focus();
        }
   });
   $('.panel-google-plus-comment > .panel-google-plus-textarea > textarea').on('keyup', function(event) {
        var $comment = $(this).closest('.panel-google-plus-comment');
        
        $comment.find('button[type="submit"]').addClass('disabled');
        if ($(this).val().length >= 1) {
            $comment.find('button[type="submit"]').removeClass('disabled');
        }
   });
});

var flag = 0;
document.getElementById('startmodal').onclick=function(){

  var blackground = document.getElementById('blackground');
  var container = document.getElementById('modalcontainer');
  blackground.style.height = '100%';
  container.style.height = '60%';
  flag = 1;

  // blackground.onclick=function{
  //     if(flag == 0){

  // }else{
  //   document.getElementById('blackground').style.height = '0';
  //   document.getElementById('modalcontainer').style.height = '0';
  // }
  // }
}

$('#close').bind('click', function(){
  var blackground = document.getElementById('blackground');
  var container = document.getElementById('modalcontainer');
  blackground.style.height = '0%';
  container.style.height = '0%';
});

// document.getElementById('blackground').onclick=function{
//   if(flag == 0){

//   }else{
//     document.getElementById('blackground').style.height = '0';
//     document.getElementById('modalcontainer').style.height = '0';
//   }
// }