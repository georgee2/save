function additem() {
    // clone element
    const sizeRow = document.getElementById("itemskey").cloneNode(true);
    document.querySelector(".items-container").appendChild(sizeRow);
}

function removeitem() {
    if (document.querySelector(".items-container").children.length > 1) {
        document
            .querySelector(".items-container #itemskey:last-of-type")
            .remove();
    }
}