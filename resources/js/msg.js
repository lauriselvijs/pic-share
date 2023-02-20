import { FLASH_MSG_HIDE_DELAY } from "./const";

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
