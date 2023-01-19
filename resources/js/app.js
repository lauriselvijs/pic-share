import "./bootstrap";
import { MIME_TYPES, FLASH_MSG_HIDE_DELAY, TABLET_WIDTH } from "./const.js";

// Modal
const modalBg = document.getElementById("modal-bg");
const modalContent = document.getElementById("modal-content");
const openModalMenuBtn = document.getElementById("open-modal-btn");
const closeModalBtn = document.getElementById("close-modal-btn");

// Open modal
openModalMenuBtn.addEventListener("click", function () {
    modalBg.classList.add("block");
    modalBg.classList.remove("hidden");

    setTimeout(() => {
        modalContent.classList.add("w-1/2");
    }, 0);
});

// Set modal content to 0%
closeModalBtn.addEventListener("click", function () {
    modalContent.classList.remove("w-1/2");
});

// Close modal when transition ended
modalContent.addEventListener("transitionend", function () {
    if (!modalContent.classList.contains("w-1/2")) {
        modalBg.classList.add("hidden");
        modalBg.classList.remove("block");
    }
});

// Close modal if user is on desktop
window.addEventListener("resize", function () {
    if (document.body.offsetWidth > TABLET_WIDTH) {
        modalBg.style.display = "none";
    }
});

// Flash msg
const flashMsg = document.getElementById("flash-msg");
const flashMsgCloseBtn = document.getElementById("close-flash-msg-btn");

function onFlashMsgCloseBtnClick() {
    flashMsg.style.display = "none";
}

if (flashMsg) {
    flashMsgCloseBtn.addEventListener("click", onFlashMsgCloseBtnClick);

    setTimeout(() => {
        flashMsg.style.display = "none";
    }, FLASH_MSG_HIDE_DELAY);
}

// Upload files
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

// Clear search input
const clearPostsSearchInputBtn = document.getElementById(
    "clear-posts-search-input"
);
const postsSearchInput = document.getElementById("posts-search-input");

if (postsSearchInput) {
    toggleClearPostsSearchInputBtn(postsSearchInput, clearPostsSearchInputBtn);
}

function onClearPostsSearchInputBtnClick() {
    postsSearchInput.value = "";
    clearPostsSearchInputBtn.style.display = "none";
}

function onPostsSearchInput() {
    toggleClearPostsSearchInputBtn(postsSearchInput, clearPostsSearchInputBtn);
}

if (clearPostsSearchInputBtn) {
    clearPostsSearchInputBtn.addEventListener(
        "click",
        onClearPostsSearchInputBtnClick
    );
}

if (postsSearchInput) {
    postsSearchInput.addEventListener("input", onPostsSearchInput);
}

/**
 * Toggles the display of a clear button for a posts search input
 * @param {HTMLInputElement} postsSearchInput - The input element for the posts search
 * @param {HTMLButtonElement} clearPostsSearchInputBtn - The button element to clear the search input
 */
function toggleClearPostsSearchInputBtn(
    postsSearchInput,
    clearPostsSearchInputBtn
) {
    if (postsSearchInput.value === "") {
        clearPostsSearchInputBtn.style.display = "none";
    } else if (postsSearchInput.value !== "") {
        clearPostsSearchInputBtn.style.display = "inline-block";
    }
}
