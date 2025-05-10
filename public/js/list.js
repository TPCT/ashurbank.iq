const list = document.querySelectorAll(".list-group-item.list-group-item-action");
const listGroup =document.querySelector("#list-group");
const listItem=listGroup.children;



list.forEach((item) => {
    item.addEventListener("click",(e) => {
        document.body.scrollTop = 500;
        list.forEach(removeActive);
        e.target.classList.add("active");
        getSection(item.getAttribute("data-href").split("#")[1])
    });
});

const removeActive = (item) => {
    item.classList.remove("active");
};
const getSection=(href)=>{
    for (const item of listItem) {
        if(item.getAttribute("id")==href){
            item.scrollIntoView({ behavior: 'smooth', block: 'start'});
            break;
        }
    }
}
const getHeader=(href)=>{
    for (const item of list) {
        if(item.getAttribute("data-href").split("#")[1]==href){
            list.forEach(removeActive);
            item.classList.add("active");
            break;
        }
    }

}

listGroup.addEventListener("scroll",() =>{
    const scrollPosition = listGroup.scrollTop+120;
    for (const item of listItem) {
        const itemTop = item.offsetTop;
        if (itemTop >= scrollPosition) {
            getHeader(item.getAttribute("id"));
            break;
        }
    }
});







