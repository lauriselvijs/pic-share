import "./bootstrap";
import jQuery from "jquery";
import { MIME_TYPES } from "./const.js";

window.$ = jQuery;

//TODO:
// [] -remove jQuery support
// jQuery
// Dark mode
$("#dark-mode-btn").on("click", function () {
    $("#dark-mode-btn svg").toggle("fast");
});

// Open modal
$("#open-modal-menu-btn").on("click", function () {
    $("#modal-menu").show(0, function () {
        $("#modal-content").animate({ width: "50%" }, "fast");
    });
});

// Close modal
$("#close-modal-btn").on("click", function () {
    $("#modal-content").animate({ width: "0" }, "fast", function () {
        $("#modal-menu").hide();
    });
});

// js
// Upload files
const dropBox = document.getElementById("image-drop-box");
const dropBoxInput = document.getElementById("image-drop-box-input");
const dropBoxUploadedFileNameElement = document.getElementById(
    "image-drop-box-file-name"
);

dropBox.addEventListener("dragover", dragOverDropBoxHandler);
dropBox.addEventListener("drop", dropOnDropBoxHandler);
dropBoxInput.addEventListener("change", inputDropBoxHandler);
dropBoxUploadedFileNameElement.addEventListener(
    "click",
    clickOnDropBoxUploadedFleNameElementHandler
);

function clickOnDropBoxUploadedFleNameElementHandler() {
    dropBoxInput.value = "";
    dropBoxUploadedFileNameElement.textContent = "";
}

function inputDropBoxHandler() {
    dropBoxUploadedFileNameElement.textContent =
        dropBoxInput.files.item(0).name;
}

function dropOnDropBoxHandler(event) {
    event.preventDefault();
    const droppedFile = event.dataTransfer.files[0];
    const droppedFiles = event.dataTransfer.files;

    if (
        droppedFile &&
        MIME_TYPES.includes(droppedFile.type) &&
        arrContainsOneElement(droppedFiles)
    ) {
        dropBoxInput.files = droppedFiles.files;
        dropBoxUploadedFileNameElement.textContent = droppedFile.name;
    }
}

function dragOverDropBoxHandler(event) {
    event.preventDefault();
}

/**
 * Returns true if array contains one element otherwise false
 *
 * @param {Array} elementArr - Array of elements to check
 * @returns {boolean} Is array of one element
 */
function arrContainsOneElement(elementArr) {
    return elementArr.length === 1;
}
