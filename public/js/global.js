// функция, создающая по навигации дополнительную выпадающую навигацию
function appendDropdownNav(){
    let nav = document.getElementById('nav-list');
    let navItems = Array.from(nav.children);
    let navDropdownItems = document.createElement('ul');
    navDropdownItems.className = 'nav-dropdown-list';
    navItems.forEach(function(navItem){
        let navDropdownItem = document.createElement('li');
        navDropdownItem.innerHTML = navItem.innerHTML;
        navDropdownItems.appendChild(navDropdownItem);
    });
    document.getElementById('nav').after(navDropdownItems);
}

appendDropdownNav();


// Все, что ниже отвечает за показ кнопки прокрутки к началу страницы
function checkScroll(){
    if (window.pageYOffset>document.documentElement.clientHeight)
      document.getElementById('up-button').style.display = "block";
    else
      document.getElementById('up-button').style.display = "none";
}

window.addEventListener('scroll', checkScroll)

document.getElementById('up-button').addEventListener('click', function(){
    window.scrollTo(0,0);
  })
