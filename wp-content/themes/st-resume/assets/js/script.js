/* ===============================================
  OPEN CLOSE Menu
============================================= */

function st_resume_open_menu() {
  jQuery('button.menu-toggle').addClass('close-panal');
  setTimeout(function(){
    jQuery('nav#primary-menu').show();
  }, 100);

  return false;
}

jQuery( "button.menu-toggle").on("click", st_resume_open_menu);

function st_resume_close_menu() {
  jQuery('button.close-menu').removeClass('close-panal');
  jQuery('nav#primary-menu').hide();
}

jQuery( "button.close-menu").on("click", st_resume_close_menu);

/* ===============================================
  TRAP TAB FOCUS ON MODAL MENU
============================================= */

jQuery('button.close-menu').on('keydown', function (e) {

  if (jQuery("this:focus") && !!e.shiftKey && e.keyCode === 9) {
  } else if (jQuery("this:focus") && (e.which === 9)) {
    e.preventDefault();
    jQuery(this).blur();
    jQuery('.st-nav li a:first').focus()
  }
});

jQuery('.st-nav li a:first').on('keydown', function (event) {
  if (jQuery("this:focus") && !!event.shiftKey && event.keyCode === 9) {
    event.preventDefault();
    jQuery(this).blur();
    jQuery('button.close-menu').focus()
  }
});

window.onload = function() {
  document.getElementById("st-resume-loader-container").style.display = "flex";
};
window.addEventListener("load", function() {
  setTimeout(function() {
      document.getElementById("st-resume-loader-container").style.display = "none";
  } );
});
