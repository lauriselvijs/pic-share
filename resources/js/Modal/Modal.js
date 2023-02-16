class Modal {
    #isOpen;
    #isClosing;

    constructor() {
        this.#isOpen = false;
        this.#isClosing = false;
    }

    open() {
        this.#isOpen = true;
    }

    close() {
        this.#isOpen = false;
    }

    startCloseTransition() {
        this.#isClosing = true;
    }

    endCloseTransition() {
        this.#isClosing = false;
    }

    get isOpen() {
        return this.#isOpen;
    }

    get isClosing() {
        return this.#isClosing;
    }
}

export default Modal;
