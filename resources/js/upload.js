import { MIME_TYPES } from "./const";

const dropBox = document.getElementById("image-drop-box");
const dropBoxInput = document.getElementById("image-drop-box-input");
const dropBoxUploadedFileName = document.getElementById(
    "image-drop-box-file-name"
);

function onDropBoxUploadedFleNameClick() {
    dropBoxInput.value = "";
    dropBoxUploadedFileName.textContent = "";
}

function onDropBoxInputChange() {
    dropBoxUploadedFileName.textContent = dropBoxInput.files.item(0).name;
}

function onDropBoxDrop(event) {
    event.preventDefault();
    const droppedFile = event.dataTransfer.files[0];
    const droppedFiles = event.dataTransfer.files;

    if (
        droppedFile &&
        MIME_TYPES.includes(droppedFile.type) &&
        arrContainsOneElement(droppedFiles)
    ) {
        dropBoxInput.files = droppedFiles;
        dropBoxUploadedFileName.textContent = droppedFile.name;
        console.log(dropBoxInput.files);
    }
}

function onDropBoxDragOver(event) {
    event.preventDefault();
}

if (dropBox) {
    dropBox.addEventListener("dragover", onDropBoxDragOver);
    dropBox.addEventListener("drop", onDropBoxDrop);
}

if (dropBoxInput) {
    dropBoxInput.addEventListener("change", onDropBoxInputChange);
}

if (dropBoxUploadedFileName) {
    dropBoxUploadedFileName.addEventListener(
        "click",
        onDropBoxUploadedFleNameClick
    );
}

/**
 * Returns true if array contains one element otherwise false
 *
 * @param {Array<any>} elementArr - Array of elements to check
 * @returns {boolean} Is array of one element
 */
const arrContainsOneElement = (elementArr) => {
    return elementArr.length === 1;
};
