// https://codepen.io/BJack/pen/alGCs/
// drop down the menu, and swap the icon to the close icon
$('.menu').click(function(){
    $(this).toggleClass('icon-menu');
    $(this).toggleClass('icon-cross');
    $('.nav-dropdown-list').toggleClass('down');
    $('.nav-dropdown-list li a').removeClass('down');
    // $('.search').removeClass('down');
    // $('.icon-search').removeClass('icon-cross');
  });
  
  //Make sure the menu icon behaves corectly when the menu is open
  $('.nav-dropdown-list li a').click(function(){
      $('.menu').addClass('icon-menu');
      $('.menu').removeClass('icon-cross');
      $('.nav-dropdown-list').toggleClass('down');
  });
