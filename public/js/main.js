document.addEventListener("DOMContentLoaded", function () {
    const addPicBtn = document.querySelector(".add-pic");
    const removePicBtn = document.querySelector(".remove-pic");
    const addToolBtn = document.querySelector(".add-tool");
    const removeToolBtn = document.querySelector(".del-tool");
    addPicBtn.addEventListener("click", function () {
        // clone picture elements
        const picture = document.querySelector(".picture").cloneNode(true);
        document.querySelector(".pictures").appendChild(picture);
    });
    removePicBtn.addEventListener("click", function () {
        if (document.querySelector(".pictures").children.length !== 1)
            document.querySelector(".pictures .picture:last-of-type").remove();
    });

    addToolBtn.addEventListener("click", function () {
        // clone tool elements
        const picture = document.querySelector(".tool").cloneNode(true);
        picture.querySelector("input").value = "";
        document.querySelector(".tools").appendChild(picture);
    });
    removeToolBtn.addEventListener("click", function () {
        if (document.querySelector(".tools").children.length !== 1)
            document.querySelector(".tools .tool:last-of-type").remove();
    });
});
