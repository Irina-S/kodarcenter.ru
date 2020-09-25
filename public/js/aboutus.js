$(function(){
    // зависимость высоты от ширины видео
    $('.film').height($('.film').width()*(9/16));
  
    $(window).resize(function(){
      $('.film').height($('.film').width()*(9/16));
    });
  });

//   функция, создающая навигацию по странице из заголовков
 function createHeadersList(){
     let headers = document.getElementsByClassName('articles-header');
     let headersList = document.createElement('ul');
     headersList.className = "headers-list";

     let count = 1;
     Array.from(headers).forEach(function(item){
        // Создаем и присваиваем якорь.  
        let anchor = document.createElement('a');
        anchor.name = "article"+count;
        count++;
        item.before(anchor);
        // Создаем ссылающийся на эту статью элемент в навигации.
        let headersListItem = document.createElement('li');
        headersListItem.className = "headers-list-item";
        headersListItem.innerHTML = '<a href="#'+anchor.name+'">'+item.innerText+'</a>';
        headersList.appendChild(headersListItem);
     });
     document.getElementsByClassName('sidebar')[0].appendChild(headersList);
 }

createHeadersList();

// функция, определяющая виден ли элемент в окне
function isVisible(target) {
  // Все позиции элемента
  var targetPosition = {
      top: window.pageYOffset + target.getBoundingClientRect().top,
      left: window.pageXOffset + target.getBoundingClientRect().left,
      right: window.pageXOffset + target.getBoundingClientRect().right,
      bottom: window.pageYOffset + target.getBoundingClientRect().bottom
    },
    // Получаем позиции окна
    windowPosition = {
      top: window.pageYOffset,
      left: window.pageXOffset,
      right: window.pageXOffset + document.documentElement.clientWidth,
      bottom: window.pageYOffset + document.documentElement.clientHeight
    };

  if (targetPosition.bottom > windowPosition.top && // Если позиция нижней части элемента больше позиции верхней чайти окна, то элемент виден сверху
    targetPosition.top < windowPosition.bottom && // Если позиция верхней части элемента меньше позиции нижней чайти окна, то элемент виден снизу
    targetPosition.right > windowPosition.left && // Если позиция правой стороны элемента больше позиции левой части окна, то элемент виден слева
    targetPosition.left < windowPosition.right) { // Если позиция левой стороны элемента меньше позиции правой чайти окна, то элемент виден справа
    // Если элемент полностью видно, то запускаем следующий код

    return true;
    } 
    else {
      // Если элемент не видно, то запускаем этот код
      return false;
    };
};

// функция возвращающая, какой элемент будет видим следующим
// targets - элементы
// dst - направление прокрутки(true - вниз, false - вверх)
function getNewVisible(targets, dst=true){
  let visibles = Array.from(targets).filter(isVisible);
  // Если прокрутка вниз
  if (dst)
    return visibles.pop();
  else
    return visibles.shift();
}

// Функция позволяющая получить направление прокрутки
// Возвращает true - вниз, false - вверх
function getScrollDst(){
  let st = window.pageYOffset;
  let scrollDst;
  if (st > window.scrollPos){
    scrollDst = true;
    this.console.log('вниз');
  } 
  else {
    scrollDst = false;
    this.console.log('вверх');
  }
  window.scrollPos = st;
  return scrollDst;
}
// Необходимая функции выше, глоб.переменная, храянящая последнюю позицию прокрутки окна
window.scrollPos = 0;


// Функция подсвечивающая ссылку в навигации,соответсвующую видимой статье
function hightlightVisibleLink(visible){
  let visiblesHeader = visible.getElementsByClassName('articles-header')[0].innerText;
  let headersListArray = Array.from(document.getElementsByClassName('headers-list-item'));
  let visiblesHeaderLink = (headersListArray.filter((header)=>header.querySelector('a').innerText==visiblesHeader))[0];
  visiblesHeaderLink.classList.add('selected-item');
  // КОСТЫЛЬ!!!
  let curLink = visiblesHeaderLink.nextElementSibling;
  while (curLink){
    curLink.classList.remove('selected-item');
    curLink = curLink.nextElementSibling;
  }
  curLink = visiblesHeaderLink.previousElementSibling;
  while (curLink){
    curLink.classList.remove('selected-item');
    curLink = curLink.previousElementSibling;
  }
}



window.addEventListener('scroll', function(event){
  // checkScroll();
  // определение направления прокрутки
  let dst = getScrollDst();
  let articles = document.getElementsByClassName('article');
  // let articlesArray = Array.from(document.getElementsByClassName('article'));
  let visible = getNewVisible(articles, dst);
  // console.log("будет выведен");
  // console.dir(visible);
  if (visible){
    hightlightVisibleLink(visible);
  }
});


// определяем первый видимый элемент при загрузке страницы
hightlightVisibleLink(getNewVisible(document.getElementsByClassName('article'), false));