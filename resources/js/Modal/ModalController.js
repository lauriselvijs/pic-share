import ModalService from "./ModalService";

class ModalController {
    #modal;
    #modalService;
    #view;

    constructor(modal, view) {
        this.#modal = modal;
        this.#view = view;
        this.#modalService = new ModalService(modal);

        this.#addEventListeners();
    }

    #addEventListeners() {
        this.#view.openModalMenuBtn?.addEventListener("click", () => {
            this.#modal.open();
            this.renderView();
        });
        this.#view.closeModalBtn?.addEventListener("click", () => {
            this.#modal.startTransition();
            this.renderView();
        });
        this.#view.modalContent?.addEventListener("transitionend", () => {
            // TODO:
            // [ ] - Move to view
            if (!this.#view.modalContent.classList.contains("w-1/2")) {
                this.#modal.endTransition();
                this.#modal.close();
                this.renderView();
            }
        });
        window.addEventListener("resize", () => {
            this.#modalService.closeIfOnTablet();
            this.renderView();
        });
    }

    renderView() {
        this.#view.render();
    }
}

export default ModalController;
