// Обработчик клика на кнопке добавления новых полей для файлов
document.getElementById('more-files-button').addEventListener('click', function(){
    let inputFile = document.createElement('input');
    inputFile.setAttribute('name', 'img[]');
    inputFile.setAttribute('type', 'file');
    inputFile.setAttribute('accept', 'image/jpeg,image/png,image/gif');
    this.before(inputFile);
})