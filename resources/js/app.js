import algoliasearch from "algoliasearch/lite";

import "./bootstrap";
import {
    MIME_TYPES,
    FLASH_MSG_HIDE_DELAY,
    ALGOLIA_APP_ID,
    ALGOLIA_SEARCH_KEY,
} from "./const";

import "./Modal";

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

// Search

// Algolia
const searchClient = algoliasearch(ALGOLIA_APP_ID, ALGOLIA_SEARCH_KEY);

const POST_SEARCH_SUGGESTION_LIST_ITEM_ID = "post-search-suggestion-list-item";
const postSearchContainer = document.getElementById("post-search-container");
const clearPostsSearchInputBtn = document.getElementById(
    "clear-posts-search-input"
);
const postsSearchInput = document.getElementById("posts-search-input");
const postSearchSuggestionBox = document.getElementById(
    "post-search-suggestion-box"
);
const postSearchSuggestionListItem = document.getElementById(
    POST_SEARCH_SUGGESTION_LIST_ITEM_ID
);
const postSearchSuggestionBoxList = document.getElementById(
    "post-search-suggestion-box-list"
);
const postSearchForm = document.getElementById("posts-search-form");

function onClearPostsSearchInputBtnClick() {
    postsSearchInput.value = "";
    clearPostsSearchInputBtn.style.display = "none";
    postSearchSuggestionBox.style.display = "none";
}

const posts = [
    { title: "Post 1", slug: "post-1" },
    { title: "Post 2", slug: "post-2" },
    { title: "Post 3", slug: "post-3" },
];

if (postsSearchInput) {
    if (postsSearchInput.value) {
        toggleClearPostsSearchInputBtn(
            postsSearchInput,
            clearPostsSearchInputBtn
        );
    }
}

async function onPostsSearchInput(event) {
    const retrievedPosts = await searchPosts(event.target.value);

    const postsSearchInput = event.target.value;
    const retrievedPostsLength = retrievedPosts.length;

    toggleClearPostsSearchInputBtn(postsSearchInput, clearPostsSearchInputBtn);
    resetPostSearchSuggestionBox(postSearchSuggestionBoxList);
    togglePostSearchSuggestionBox(
        postsSearchInput,
        retrievedPostsLength,
        postSearchSuggestionBox
    );
    displayPostSearchSuggestion(retrievedPosts, postSearchSuggestionListItem);
}

function onDocumentClick(event) {
    if (!postSearchContainer.contains(event.target)) {
        postSearchSuggestionBox.style.display = "none";
    }
}

async function onPostsSearchInputFocus(event) {
    if (event.target.value) {
        const retrievedPosts = await searchPosts(event.target.value);

        postSearchSuggestionBox.style.display = "block";

        const postsSearchInput = event.target.value;
        const retrievedPostsLength = retrievedPosts.length;

        resetPostSearchSuggestionBox(postSearchSuggestionBoxList);
        togglePostSearchSuggestionBox(
            postsSearchInput,
            retrievedPostsLength,
            postSearchSuggestionBox
        );
        displayPostSearchSuggestion(
            retrievedPosts,
            postSearchSuggestionListItem
        );
    }
}

function onPostSearchSuggestionBoxListClick(event) {
    postsSearchInput.value = event.srcElement.innerText;
    postSearchForm.submit();
}

clearPostsSearchInputBtn?.addEventListener(
    "click",
    onClearPostsSearchInputBtnClick
);
postsSearchInput?.addEventListener("input", onPostsSearchInput);
postsSearchInput?.addEventListener("focus", onPostsSearchInputFocus);
postSearchSuggestionBoxList?.addEventListener(
    "click",
    onPostSearchSuggestionBoxListClick
);

document.addEventListener("click", onDocumentClick);

function resetPostSearchSuggestionBox(postSearchSuggestionBoxList) {
    while (postSearchSuggestionBoxList.children.length > 1) {
        postSearchSuggestionBoxList.removeChild(
            postSearchSuggestionBoxList.lastChild
        );
    }

    postSearchSuggestionBoxList.firstChild.id =
        POST_SEARCH_SUGGESTION_LIST_ITEM_ID;
    postSearchSuggestionBoxList.firstChild.textContent = "";
}

function togglePostSearchSuggestionBox(
    postsSearchInput,
    retrievedPostsLength,
    searchSuggestionBox
) {
    if (!postsSearchInput || retrievedPostsLength === 0) {
        searchSuggestionBox.style.display = "none";
    } else if (postsSearchInput && retrievedPostsLength !== 0) {
        searchSuggestionBox.style.display = "block";
    }
}

function displayPostSearchSuggestion(posts, searchPostSuggestionListItem) {
    posts.forEach(({ title, slug }, index) => {
        if (index === 0) {
            searchPostSuggestionListItem.id = slug;
            searchPostSuggestionListItem.textContent = title;
        } else if (index > 0) {
            const prevListItem = document.getElementById(posts[index - 1].slug);

            const newPostSearchSuggestionListItem =
                postSearchSuggestionListItem.cloneNode(true);
            newPostSearchSuggestionListItem.id = slug;
            newPostSearchSuggestionListItem.textContent = title;

            prevListItem.after(newPostSearchSuggestionListItem);
        }
    });
}

/**
 * Toggles the display of a clear button for a posts search input
 * @param {HTMLInputElement} postsSearchInput - The input element for the posts search
 * @param {HTMLButtonElement} clearPostsSearchInputBtn - The button element to clear the search input
 * @return {void}
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

/**
 * Search post records
 *
 * @param {string} param
 * @returns { Promise<Array<any> | undefined>}
 */
async function searchPosts(param) {
    const index = searchClient.initIndex("posts");

    try {
        const { hits = [] } = await index.search(param);

        return hits;
    } catch (error) {
        console.log(error);
    }
}
