const elementUpdate = document.getElementsByClassName("update");
const URL = document.getElementById("url").value;

for (let i = 0; i < elementUpdate.length; i++) {
    elementUpdate[i].addEventListener("click", function () {
        const ID = this.getAttribute("data-id");
        document
            .getElementById("form-update")
            .setAttribute("action", URL + "/pulang/" + ID);
    });
}

