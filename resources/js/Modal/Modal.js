class Modal {
    #isOpen;
    #isTransition;

    constructor() {
        this.#isOpen = false;
        this.#isTransition = false;
    }

    open() {
        this.#isOpen = true;
    }

    close() {
        this.#isOpen = false;
    }

    startTransition() {
        this.#isTransition = true;
    }

    endTransition() {
        this.#isTransition = false;
    }

    get isOpen() {
        return this.#isOpen;
    }

    get isTransition() {
        return this.#isTransition;
    }
}

export default Modal;
