import { MIME_TYPES } from "./const";

const dropBox = document.getElementById("image-drop-box");
const dropBoxInput = document.getElementById("image-drop-box-input");
const dropBoxUploadedFileName = document.getElementById(
    "image-drop-box-file-name"
);
const thumbnailContainer = document.getElementById("thumbnail-container");
const oldPostImage = document.getElementById("old-post-image");

/**
 * Returns true if array contains one element otherwise false
 *
 * @param {Array<any>} elementArr - Array of elements to check
 * @returns {boolean} Is array of one element
 */
const arrContainsOneElement = (elementArr) => {
    return elementArr.length === 1;
};

/**
 * Display an image thumbnail from a selected file and append it to a container.
 *
 * @param {File} file - The selected file.
 * @param {HTMLElement} container - The container where the thumbnail will be displayed.
 */
const displayImageThumbnail = (file, container) => {
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement("img");
            img.src = e.target.result;
            container.innerHTML = ""; // Clear previous thumbnail
            container.appendChild(img);
        };
        reader.readAsDataURL(file);

        if (oldPostImage) {
            oldPostImage.style.display = "none";
        }
    }
};

function onDropBoxUploadedFileNameClick() {
    dropBoxInput.value = "";
    dropBoxUploadedFileName.textContent = "";
    thumbnailContainer.innerHTML = ""; // Clear the thumbnail

    if (oldPostImage) {
        oldPostImage.style.display = "block";
    }
}

function onDropBoxInputChange() {
    const selectedFile = dropBoxInput.files[0];

    if (selectedFile) {
        dropBoxUploadedFileName.textContent = selectedFile.name;

        // Display the thumbnail if it's an image file
        displayImageThumbnail(selectedFile, thumbnailContainer);
    } else {
        dropBoxUploadedFileName.textContent = "";
        thumbnailContainer.innerHTML = ""; // Clear the thumbnail
    }
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

        // Display the thumbnail
        displayImageThumbnail(selectedFile, thumbnailContainer);
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
        onDropBoxUploadedFileNameClick
    );
}
