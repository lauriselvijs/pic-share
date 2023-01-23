class ModalView {
    #modalBg;
    #modalContent;
    #openModalMenuBtn;
    #closeModalBtn;
    #modal;

    constructor(modal) {
        this.#modalBg = document.getElementById("modal-bg");
        this.#modalContent = document.getElementById("modal-content");
        this.#openModalMenuBtn = document.getElementById("open-modal-btn");
        this.#closeModalBtn = document.getElementById("close-modal-btn");
        this.#modal = modal;
    }

    render() {
        if (this.#modal.isOpen && !this.#modal.isTransition) {
            this.#modalBg.classList.remove("hidden");
            this.#modalBg.classList.add("block");

            setTimeout(() => {
                this.#modalContent.classList.remove("w-0");
                this.#modalContent.classList.add("w-1/2");
            }, 0);
        }

        if (this.#modal.isTransition) {
            this.#modalContent.classList.remove("w-1/2");
            this.#modalContent.classList.add("w-0");
        }

        if (!this.#modal.isOpen && !this.#modal.isTransition) {
            this.#modalBg.classList.remove("block");
            this.#modalBg.classList.add("hidden");

            this.#modalContent.classList.remove("w-1/2");
            this.#modalContent.classList.add("w-0");
        }
    }

    get modalBg() {
        return this.#modalBg;
    }

    get modalContent() {
        return this.#modalContent;
    }

    get openModalMenuBtn() {
        return this.#openModalMenuBtn;
    }

    get closeModalBtn() {
        return this.#closeModalBtn;
    }
}

export default ModalView;
