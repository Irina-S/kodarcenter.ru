// Колличество разделов
let sections = document.getElementsByClassName('section-header')
let sectionsCount =sections.length!=0?(+(sections[sections.length-1].dataset.sectionNumber) + 1 ):0;


// Функция создающая новую строку для раздела
// Принимает в качестве параметра, номер раздела к которому относится
function newRow(sectionNumber){
    let tr = document.createElement(`tr`);
    tr.innerHTML =  `<td><input type="text" name="services[name][]" placeholder="Введите название услуги"></td>`+
                    `<td><input type="text" name="services[leaders][]" placeholder="Введите ФИО ведущего(их)"></td>`+
                    `<td><input type="text" name="services[price][]" placeholder="Введите цену"></td>`+
                    `<td><input type="hidden" name="services[sectionNumber][]" value=${sectionNumber}><button class="cross del-row-button" title="Удалить эту строку" tabindex="-1" type="button"></button></td>`;
    return tr;
}


// Функция создающая новый раздел
function newSectionHeader(){
    let tr = document.createElement(`tr`);
    tr.dataset.sectionNumber = sectionsCount;
    // заголовок раздела
    tr.className = `section-header`;
    tr.innerHTML =  `<td colspan="3"><input type="text" name = "sections[]" placeholder="Введите название раздела"></td>`+
                    `<td><button class="cross del-section-button" title="Удалить этот раздел" tabindex="-1" type="button" data-section-number=${sectionsCount}></button></td>`;
    return tr;
}


function newSectionLastRow(){
    let tr = document.createElement(`tr`);
    // строка с кнопкой добавления 
    tr.className = `section-last-row`;
    tr.innerHTML = `<td colspan="4"><button class="plus create-row-button" data-section-number=${sectionsCount} title="Добавить новую строку в этот раздел" tabindex="-1" type="button"></button></td>`;
    sectionsCount++;
    return tr;

}

// Функция, удаляющая весь раздел
// Принимает в качестве параметра первую строку раздела
function delSection(section){
    let curRow = section.nextElementSibling;
    section.remove();
    while (curRow.className!=`section-last-row`){
        let curRowTmp = curRow;
        curRow = curRow.nextElementSibling;
        curRowTmp.remove();
    }
    curRow.remove();
}

// Функция, удаляющая строку вразделе
// Принимает в качестве параметра строку
function delRow(row){
    row.remove();
}





// Обработчик нажатия на кнопку добавления нового раздела
function createNewSectionBtnHandler(){
    // let t = newSection();
    // console.dir(t);
    document.getElementById(`price-edit-table`).appendChild(newSectionHeader());
    document.getElementById(`price-edit-table`).appendChild(newSectionLastRow());
}

// Обработчик нажатия на кнопку удаления раздела
function delSectionBtnHandler(sectionHeaderRow){
    let sectionHeader = sectionHeaderRow.getElementsByTagName(`input`)[0];
    let confirmation = confirm("Вы действительно хотите удалить раздел "+sectionHeader.value+"?");
    if (!confirmation){
        return;
    }
    delSection(sectionHeaderRow);
}

// Обработчик нажатия на кнопку добавления новой строки в раздел
function createRowHandler(btn){
    let tr = newRow(btn.dataset.sectionNumber);
    let curRow = btn.parentElement.parentElement;
    curRow.before(tr);
}

// Обработчик нажатия на кнопку удаления строки из раздела
function delRowHandler(){
    let row = this.parentElement.parentElement;
    let rowTitle = row.getElementsByTagName(`input`)[0];
    if (rowTitle.value.length>0){
        let confirmation = confirm("Вы действительно хотите удалить "+rowTitle.value+"?");
        if (!confirmation){
            return;
        }
    }
    delRow(row);
}




// Присваиваем обработчик клика на кнопку создания нового раздела
document.getElementById(`section-create-button`).addEventListener(`click`, function(event){
    createNewSectionBtnHandler();
});



document.getElementById("price-edit-form").addEventListener('click', function(event){
    console.dir(event.target.classList);
    // если это кнопка удаления строки
    if (event.target.classList.contains('del-row-button')){
        console.log('Удаляем строку');
        let row = event.target.parentElement.parentElement;
        delRow(row);
    }
    else if(event.target.classList.contains('del-section-button')){
        console.log('Удаляем раздел');
        let sectionHeaderRow = event.target.parentElement.parentElement;
        delSectionBtnHandler(sectionHeaderRow);
    }
    else if(event.target.classList.contains('create-row-button')){
        console.log('Добавляем строку');
        createRowHandler(event.target);
    }
})


