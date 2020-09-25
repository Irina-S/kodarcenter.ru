Array.from(document.getElementsByClassName("price-table-subheader")).forEach(function(item){
    item.addEventListener("click", function(){
        this.classList.toggle("opened-header");
        let curRow = this.nextElementSibling;
        while(curRow && !curRow.classList.contains("price-table-subheader")){
            curRow.classList.toggle("opened-row");
            curRow = curRow.nextElementSibling;
        }
    })
})

Array.from(document.getElementsByClassName("graphics-table-subheader")).forEach(function(item){
    item.addEventListener("click", function(){
        this.classList.toggle("opened-header");
        let curRow = this.nextElementSibling;
        while(curRow && !curRow.classList.contains("graphics-table-subheader")){
            curRow.classList.toggle("opened-row");
            curRow = curRow.nextElementSibling;
        }
    })
})

