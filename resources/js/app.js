import "./bootstrap";
import jQuery from "jquery";
import { MIME_TYPES, MODAL_WITH, FLASH_MSG_HIDE_DELAY } from "./const.js";

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
        $("#modal-content").animate({ width: MODAL_WITH }, "fast");
    });
});

// Close modal
$("#close-modal-btn").on("click", function () {
    $("#modal-content").animate({ width: 0 }, "fast", function () {
        $("#modal-menu").hide();
    });
});

// TODO:
// [] - access tailwind config and replace 1200 with theme.screens.md
// Close modal if screen resized
$(window).on("resize", function () {
    if (document.body.offsetWidth > 1200) {
        $("#modal-content").animate({ width: 0 }, "fast", function () {
            $("#modal-menu").hide();
        });
    }
});

// Flash msg
$("#close-flash-msg-btn").on("click", function () {
    $("#flash-msg").hide();
});

if (document.body.contains(document.getElementById("flash-msg"))) {
    setTimeout(() => {
        $("#flash-msg").hide();
    }, FLASH_MSG_HIDE_DELAY);
}

// Upload files
const dropBox = document.getElementById("image-drop-box");
const dropBoxInput = document.getElementById("image-drop-box-input");
const dropBoxUploadedFileNameElement = document.getElementById(
    "image-drop-box-file-name"
);

dropBox && dropBox.addEventListener("dragover", dragOverDropBoxHandler);
dropBox && dropBox.addEventListener("drop", dropOnDropBoxHandler);
dropBoxInput && dropBoxInput.addEventListener("change", inputDropBoxHandler);
dropBoxUploadedFileNameElement &&
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
        dropBoxInput.files = droppedFiles;
        dropBoxUploadedFileNameElement.textContent = droppedFile.name;
        console.log(dropBoxInput.files);
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
const arrContainsOneElement = (elementArr) => {
    return elementArr.length === 1;
};
