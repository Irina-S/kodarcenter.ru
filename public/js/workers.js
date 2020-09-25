// регулярное выражение для поиска чисел с плавающей точкой
let numberRegExp = /\d+(\.\d+)?/;
let cardHeight = 385;
let activeCardHeight = 550;

// функция, генерирующая карточки,задающая их размеры и положение
function createCards(){
    let workersCards = document.getElementById('workers-cards');
    // закрываем открытые карточки на случай, если это ресайз

    // количество колонок в зависимости от доступной ширины
    let colNumber = 4;
    if (workersCards.offsetWidth<954 && workersCards.offsetWidth>=685)
        colNumber = 3;
    else if (workersCards.offsetWidth<685 && workersCards.offsetWidth>=460)
        colNumber=2;
    else if (workersCards.offsetWidth<460)
        colNumber = 1;
    
    // ширина строки
    // костыль, контейнер как бы выезжает за пределы род жлемента, что бы у карточек был отступ слева и при этом
    // они не нарушали величину отступов по краям страницы
    let rowWidth = document.getElementById('content').offsetWidth+15;
    // ширина и высота каждой карточки
    let cardWidth = rowWidth/colNumber;//px
    // счетчики строк и столбцов
    let rowCount = 0;
    let colCount = 0;
    let jsWorkersCards = Array.from(document.getElementsByClassName('js-workers-card'));
    jsWorkersCards.forEach(function(card){
        // сохраняем их номера строки и столбца
        card.dataset.row = rowCount+1;
        card.dataset.col = colCount+1;
        // задаем позицию
        card.style.position = "absolute";
        card.style.top = rowCount*cardHeight+"px";
        card.style.left = colCount*cardWidth+"px";
        card.style.width = cardWidth+"px";
        card.getElementsByClassName('workers-card')[0].style.width = (cardWidth-15)+"px";
        // сохраняем позицию на всякий случай
        card.dataset.top = rowCount*cardHeight;
        card.dataset.left = colCount*cardWidth;
        colCount++;
        // если дошли до последнего столбца в строке
        if (colCount%colNumber==0){
            colCount=0;
            rowCount++;
        }
        card.addEventListener('click', cardClickHandler)
    })
    // задем высоту контйнера явно, т.к. карточки позициоированны абсолютно
    workersCards.style.height = (rowCount+(colCount==0?0:1))*cardHeight+"px";
    // сохраняем получившееся колличество строк и столбцов
    workersCards.dataset.rows = colCount==0?rowCount:rowCount+1;
    workersCards.dataset.cols = colNumber;
    workersCards.dataset.initialHeight = workersCards.offsetHeight;
}

createCards();

// изменяяем ширину карточек и перегруппируем их пр изменении ширины окна
$(window).resize(function(){
    restoreCards();
    createCards();
});

//САМАЯ ВАЖНАЯ ФУНКЦИЯ, анимирует раскрытие карточек сотрудников
function cardClickHandler(event){
    let workersCards = document.getElementById('workers-cards');//контейнер с карточками
    let classArray = Array.from(this.classList);
    
    // возвращаем карточки на место
    restoreCards(this);
    
    // открываем или закрываем карточку
    this.classList.toggle('active-card');
    // записываем длинну 
    activeCardHeight = this.offsetHeight;

    // если карточка была закрыта и ее нужно открыть
    if (!classArray.includes('active-card')){
        //открываем карточку
        //если это в первом столбце
        //то просто прибавляем разницу
        if (this.dataset.col==1){
            workersCards.style.height = (+workersCards.offsetHeight+activeCardHeight-cardHeight)+"px";
        }
        // а если не первый то прибавляем высоту открытой карточки и переносим ее нановую строку
        else{
            this.style.left = 0;
            this.style.top = +(+this.dataset.top+cardHeight)+"px";
            // прибавляем высоту открытой карточки
            workersCards.style.height = (+workersCards.offsetHeight+activeCardHeight)+"px";
        }
        //передвигаем остальные карточки, находящиеся ниже(ЕСЛИ ОНИ ЕСТЬ)
        // и не последняя строка
        if (this.nextElementSibling && this.dataset.row!=workersCards.dataset.rows){
            let curCard = this;
            if (curCard.dataset.col==1)
                curCard = curCard.nextElementSibling;
            else{
                // сначала находим первую карточку след.строки
                while (curCard.dataset.col!=1)
                    curCard=curCard.nextElementSibling;
            }
                
            // и с двигаем на строчку вниз все начина с нее
            let verOffset = this.dataset.col==1?activeCardHeight-cardHeight:activeCardHeight;
            while (curCard){
                // на высоту открытой карточки
                curCard.style.top = (+(curCard.style.top.match(numberRegExp)[0])+verOffset)+"px";
                curCard = curCard.nextElementSibling;
            }
            // не забываем увеличить 
        }

        //если это карточка не из последнего столбца, 
        //и не последняя
        //то нужно сдвигать следующие за ней карточки
        if (this.dataset.col != workersCards.dataset.cols && 
            this.nextElementSibling){
            //то нужно сдвигать следующие за ней карточки
            let neighbohorsCards;//сколько карточек переносить
            let lastRowCards;
            let n;//
            
            if (this.dataset.row!=workersCards.dataset.rows){
                neighbohorsCards = workersCards.dataset.cols-this.dataset.col; //для последней строки
                lastRowCards = workersCards.dataset.cols - workersCards.lastElementChild.dataset.col; //сколько места в последней строке?
                n = Math.min(neighbohorsCards, neighbohorsCards-(neighbohorsCards - lastRowCards));
            }
            else{
                neighbohorsCards = workersCards.lastElementChild.dataset.col - this.dataset.col;//для не последних строк
                lastRowCards = 4; //с новой строки
                n = neighbohorsCards;
            }             
            let curTop;
            // если это не последняя строка
            if (this.dataset.row!=workersCards.dataset.rows)
                curTop = +(workersCards.lastElementChild.style.top.match(numberRegExp)[0]);
            else if (this.dataset.col==1) 
                curTop = +(workersCards.lastElementChild.style.top.match(numberRegExp)[0])+activeCardHeight;
            else
                curTop = +(workersCards.lastElementChild.style.top.match(numberRegExp)[0])+activeCardHeight+cardHeight;
            // ПОСМОТРИ, НЕ НАДО ЛИ ПРИБАВИТЬ ШИРИНУ И ДРУГИХ КАРТОЧЕК!!!!!!!!!!!!!!!
            let horOffset = workersCards.lastElementChild.offsetWidth;
            // 
            let curLeft = this.dataset.row!=workersCards.dataset.rows?+(workersCards.lastElementChild.style.left.match(numberRegExp)[0])+horOffset:0;
            let curCard = this.nextElementSibling;
            // переносим карточки
            for (let i=0; i<n;i++){
                curCard.style.top = curTop+"px";
                curCard.style.left = curLeft+"px";
                // A НЕ WIDTH?????????????????????????????????????????????
                curLeft+=horOffset;
                curCard = curCard.nextElementSibling;
            }
            // не забываем увеличить контейнер
            // в зависимости от строки и столбца карточки
            if (this.dataset.row==workersCards.dataset.rows)
                workersCards.style.height = (+workersCards.offsetHeight+cardHeight)+"px";
            //если для карточек требующих сдвига, в последней строке недостаточно места
            if (neighbohorsCards>lastRowCards){
                // с начала новой строки
                curLeft = 0;
                curTop = +(workersCards.lastElementChild.style.top.match(numberRegExp)[0])+cardHeight;
                for (let i=0; i<neighbohorsCards-lastRowCards; i++){
                    curCard.style.top = curTop+"px";
                    curCard.style.left = curLeft+"px";
                    curLeft+=horOffset;
                    curCard = curCard.nextElementSibling;
                }
                // не забываем увеличить ширину контейнера для новой строки
                workersCards.style.height = +(workersCards.offsetHeight+cardHeight)+"px";
            }                
        }  
        this.scrollIntoView(true, {block: "center", behavior: "smooth"});
    }
    // если карточка была открыта и ее нужно закрыть
    else{
        // возращаем карточку на место
        this.style.top = this.dataset.top+"px";
        this.style.left = this.dataset.left+"px";
        // возвращаем сдивинутые картоки на место
        let curCard =this.nextElementSibling;
        while (curCard){
            curCard.style.left = curCard.dataset.left+"px";
            curCard.style.top = curCard.dataset.top+"px";
            curCard = curCard.nextElementSibling;
        }
        // и восттанавливаем ширину контейнера до исходной
        workersCards.style.height = workersCards.dataset.initialHeight+"px";
        
    }
  
}

// Функция, возвращающая карточки на место
function restoreCards(self){
    let workersCards = document.getElementById('workers-cards');
    let activeCards = workersCards.getElementsByClassName('active-card');
    // закрываем открытые карточки если они есть
    if (activeCards.length!=0)
        if (activeCards[0]!=self){
        // закрываем карточки
        let curCard = activeCards[0];
        // возвращаем карточки на место
        while (curCard){
            curCard.style.left = curCard.dataset.left+"px";
            curCard.style.top = curCard.dataset.top+"px";
            curCard = curCard.nextElementSibling;
        }
        activeCards[0].classList.remove('active-card');
        workersCards.style.height = workersCards.dataset.initialHeight+"px";
    }
}
