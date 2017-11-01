function createList(id, quality, name){
    var ul = document.getElementById(id);
    var li = document.createElement("li");
    var input =  document.createElement("input");
    li.appendChild(document.createTextNode(quality));
    input.setAttribute("value", quality);
    input.setAttribute("name", name);
    input.setAttribute("type", "hidden");
    li.appendChild(input)
    ul.appendChild(li);
}
